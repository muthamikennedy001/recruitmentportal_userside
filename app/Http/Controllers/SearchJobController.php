<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchJobController extends Controller
{
    public function search(Request $request)
    {
        $adminBaseUrl = config('app.api_admin_base_url');
        $searchTerm = $request->input('search', '');

        try {
            // Make the HTTP request
            $response = Http::timeout(30)->get("{$adminBaseUrl}/api/jobs");

            // Check if the request was successful
            if (!$response->successful()) {
                throw new \Exception("API request failed with status code: " . $response->status());
            }

            // Decode the JSON
            $allJobs = json_decode($response->body(), true);

            // Check if JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("JSON decoding failed: " . json_last_error_msg());
            }

            // Check if $allJobs is an array
            if (!is_array($allJobs)) {
                throw new \Exception("Decoded data is not an array");
            }

            // Filter jobs
            $filteredJobs = array_filter($allJobs, function ($job) use ($searchTerm) {
                return $this->jobMatchesSearchTerm($job, $searchTerm);
            });

            // Paginate the filtered jobs
            $page = max(1, (int) $request->input('page', 1));
            $perPage = 10; // You can adjust this number
            $offset = ($page - 1) * $perPage;

            $paginatedJobs = new LengthAwarePaginator(
                array_slice($filteredJobs, $offset, $perPage, true),
                count($filteredJobs),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            $modal = false;
            $result = 'none';
            return view('posts.index', [
                'jobs' => $paginatedJobs,
                'searchTerm' => $searchTerm,
                "modal" => $modal,
                'result' => $result,

            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Job search failed: ' . $e->getMessage());

            // Return an error view or redirect with an error message
            return view('posts.index', ['message' => 'An error occurred while fetching jobs. Please try again later.']);
        }
    }

    private function parsePartialSalaryRange($searchTerm)
    {
        // Match patterns like "30000+", "30k+", "-40000", "-40k", "30000-", "30k-", or just "30000", "30k"
        if (preg_match('/^(-?\d+k?[\+\-]?)|(-?\d+[\+\-]?)$/i', $searchTerm, $matches)) {
            $value = $this->convertSalaryToNumber(preg_replace('/[+\-k]/i', '', $matches[0]));

            if (strpos($searchTerm, '+') !== false) {
                return ['min' => $value, 'max' => null];
            } elseif (strpos($searchTerm, '-') === 0) {
                return ['min' => null, 'max' => $value];
            } elseif (substr($searchTerm, -1) === '-') {
                return ['min' => $value, 'max' => null];
            } else {
                return ['partial' => $value];
            }
        }

        // Match full range like "30000-40000" or "30k-40k"
        if (preg_match('/^(\d+k?)-(\d+k?)$/i', $searchTerm, $matches)) {
            return [
                'min' => $this->convertSalaryToNumber($matches[1]),
                'max' => $this->convertSalaryToNumber($matches[2])
            ];
        }

        return null;
    }

    private function convertSalaryToNumber($salary)
    {
        if (strtolower(substr($salary, -1)) === 'k') {
            return (int) substr($salary, 0, -1) * 1000;
        }
        return (int) $salary;
    }

    private function jobMatchesSearchTerm($job, $searchTerm)
    {
        $fieldsToSearch = ['title', 'category', 'location', 'tag'];

        foreach ($fieldsToSearch as $field) {
            if (isset($job[$field]) && $this->partialMatch($job[$field], $searchTerm)) {
                return true;
            }
        }

        // Check closing date
        if (isset($job['closing_date']) && $this->closingDateMatches($job['closing_date'], $searchTerm)) {
            return true;
        }
        if (isset($job['salary_range'])) {
            $jobSalaryRange = explode('-', $job['salary_range']);
            if (count($jobSalaryRange) == 2) {
                $jobMinSalary = (string) $jobSalaryRange[0];
                $jobMaxSalary = (string) $jobSalaryRange[1];

                // Check if searchTerm is a single number
                if (is_numeric($searchTerm) && strlen($searchTerm) == 1) {
                    // Check if the search term matches the first digit of either min or max salary
                    if (
                        substr($jobMinSalary, 0, 1) === $searchTerm ||
                        substr($jobMaxSalary, 0, 1) === $searchTerm
                    ) {
                        return true;
                    }
                }

                // Check for partial range match
                $partialRange = $this->parsePartialSalaryRange($searchTerm);
                if ($partialRange) {
                    if (isset($partialRange['partial'])) {
                        // Check if the partial salary appears anywhere in the salary range
                        $partialStr = (string)$partialRange['partial'];
                        if (
                            strpos($jobMinSalary, $partialStr) === 0 ||
                            strpos($jobMaxSalary, $partialStr) === 0
                        ) {
                            return true;
                        }
                    } elseif (($partialRange['min'] === null || (int)$jobMaxSalary >= $partialRange['min']) &&
                        ($partialRange['max'] === null || (int)$jobMinSalary <= $partialRange['max'])
                    ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function partialMatch($haystack, $needle)
    {
        return is_string($haystack) && stripos($haystack, $needle) !== false;
    }

    private function closingDateMatches($closingDate, $searchTerm)
    {
        $formats = ['d.m.Y', 'd-m-Y', 'd/m/Y', 'd,m,Y'];

        // Try to parse the search term
        $searchDate = $this->parseDate($searchTerm, $formats);

        // If search term couldn't be parsed as a date, it doesn't match
        if (!$searchDate) {
            return false;
        }

        // Try to parse the closing date
        $jobClosingDate = $this->parseDate($closingDate, $formats);

        // If closing date couldn't be parsed, it doesn't match
        if (!$jobClosingDate) {
            return false;
        }

        return $searchDate->isSameDay($jobClosingDate);
    }

    private function parseDate($dateString, $formats)
    {
        // First, try the specific formats
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString);
            } catch (\Exception $e) {
                // If this format doesn't work, try the next one
                continue;
            }
        }

        // If none of the specific formats worked, try Carbon's flexible parsing
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            // If even flexible parsing fails, return null
            return null;
        }
    }
}
