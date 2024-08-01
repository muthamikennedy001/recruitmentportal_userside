<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AssessmentController extends Controller
{
    public function showQuestion(Request $request)
    {
        $authToken = Session::get('api_token');
        $assessment_id = $request->input('assessment_id');
        $job_id = $request->input('job_id'); // Capture job_id from request

        // Validate job_id
        if (!$job_id) {
            Log::error('Job ID is required.');
            return back()->withErrors(['error' => 'Job ID is required.']);
        }

        // Check for API token
        if (!$authToken) {
            Log::error('Authentication token not found.');
            return back()->withErrors(['error' => 'Authentication token not found.']);
        }

        // Fetch user details
        $userApiUrl = config('app.api_base_url') . '/api/profile';
        $userResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken
        ])->get($userApiUrl);

        if (!$userResponse->successful()) {
            Log::error('Failed to fetch user details', [
                'status' => $userResponse->status(),
                'body' => $userResponse->body()
            ]);
            return back()->withErrors(['error' => 'Failed to fetch user details.']);
        }

        $userDetails = $userResponse->json();
        $userId = $userDetails['id'];

        // Check if the user has already completed this assessment
        // if (Session::has("completed_{$assessment_id}_{$userId}")) {
        //     Log::info("User already completed assessment {$assessment_id}");
        //     return back()->withErrors(['error' => 'You have already completed this test.']);
        // }

        // Fetch assessment data
        $adminBaseUrl = config('app.api_admin_base_url');
        $apiUrl = $adminBaseUrl . '/api/assessment';
        $response = Http::get($apiUrl, ['assessment_id' => $assessment_id]);

        if (!$response->successful()) {
            Log::error('Failed to fetch assessment data', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return back()->withErrors(['error' => 'Failed to fetch quiz data.']);
        }

        $quizData = $response->json();
        Log::info('Assessment data fetched successfully', ['quizData' => $quizData]);

        // Store pass mark, start time, and job_id
        Session::put('pass_mark', $quizData['computed_pass_mark_in_marks'] ?? 0);
        Session::put('start_time', Session::get('start_time', now()->timestamp));
        Session::put('job_id', $job_id); // Store job_id in session

        $currentIndex = Session::get('current_index', 0);
        $totalTimeRequired = $quizData['total_time_required_in_minutes'] * 60;
        $startTime = Session::get('start_time', now()->timestamp);
        $elapsedTime = now()->timestamp - $startTime;

        if ($elapsedTime > $totalTimeRequired) {
            Log::warning('Time limit exceeded for assessment', ['assessment_id' => $assessment_id]);
            return $this->completeQuiz($assessment_id);
        }

        if ($currentIndex < count($quizData['questions'])) {
            $currentQuestion = $quizData['questions'][$currentIndex];
            Log::info('Displaying question', [
                'currentIndex' => $currentIndex,
                'currentQuestion' => $currentQuestion
            ]);

            // Pass job_id to view
            return view('posts.assessment', compact('currentQuestion', 'quizData', 'currentIndex', 'assessment_id', 'totalTimeRequired', 'elapsedTime', 'job_id'));
        } else {
            return $this->completeQuiz($assessment_id);
        }
    }


    public function submitAnswer(Request $request)
    {
        $assessment_id = $request->input('assessment_id');
        $job_id = $request->session()->get('job_id'); // Retrieve job_id from session
        $quizData = json_decode($request->input('quiz_data'), true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($quizData['questions'])) {
            Log::error('Invalid or missing quiz data on submit', ['quiz_data' => $quizData]);
            return back()->withErrors(['error' => 'Quiz data is missing or invalid.']);
        }

        $currentIndex = Session::get('current_index', 0);
        $questions = $quizData['questions'];

        if ($currentIndex >= count($questions)) {
            return $this->completeQuiz($assessment_id);
        }

        $currentQuestion = $questions[$currentIndex];
        $userAnswers = $request->input('answer', []);
        $correctAnswers = $currentQuestion['correct_answer'];
        $allocatedMarks = $currentQuestion['allocated_marks'];
        $correctCount = count($correctAnswers);

        $scoreForThisQuestion = 0;
        if ($correctCount > 0) {
            $marksPerCorrectAnswer = $allocatedMarks / $correctCount;
            if (is_array($userAnswers)) {
                foreach ($userAnswers as $answer) {
                    if (in_array($answer, $correctAnswers)) {
                        $scoreForThisQuestion += $marksPerCorrectAnswer;
                    }
                }
            } else {
                if (in_array($userAnswers, $correctAnswers)) {
                    $scoreForThisQuestion += $marksPerCorrectAnswer;
                }
            }
        } else {
            Log::error('No correct answers found for the current question.', [
                'currentQuestion' => $currentQuestion
            ]);
        }

        $totalScore = Session::get('total_score', 0) + $scoreForThisQuestion;
        Session::put('total_score', $totalScore);
        Session::put('current_index', $currentIndex + 1);

        Log::info('Submitting answer', [
            'currentQuestion' => $currentQuestion,
            'userAnswers' => $userAnswers,
            'correctAnswers' => $correctAnswers,
            'allocatedMarks' => $allocatedMarks,
            'scoreForThisQuestion' => $scoreForThisQuestion,
            'totalScore' => $totalScore
        ]);

        if ($currentIndex + 1 < count($questions)) {
            return redirect()->route('quiz.start', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
        } else {
            return redirect()->route('quiz.complete', ['assessment_id' => $assessment_id, 'job_id' => $job_id]);
        }
    }

    public function completeQuiz($assessment_id)
    {
        $baseUrl = config('app.api_base_url');
        $totalScore = Session::get('total_score', 0);
        $passMark = Session::get('pass_mark', 0);
        $authToken = Session::get('api_token');
        $job_id = Session::get('job_id');

        $result = $totalScore >= $passMark ? 'shortlisted' : 'rejected';

        Log::info('Quiz completed', [
            'assessment_id' => $assessment_id,
            'totalScore' => $totalScore,
            'passMark' => $passMark,
            'result' => $result,
            'job_id' => $job_id
        ]);

        $requestData = [
            'job_id' => $job_id,
            'assessment_id' => $assessment_id,
            'assessment_score' => $totalScore
        ];

        $assessmentAttemptsApiUrl = "{$baseUrl}/api/user/assessment-attempts";
        $assessmentAttemptsResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
            'Accept' => 'application/json'
        ])->post($assessmentAttemptsApiUrl, $requestData);

        if (!$assessmentAttemptsResponse->successful()) {
            Log::error('Failed to store assessment attempt via API', [
                'status' => $assessmentAttemptsResponse->status(),
                'body' => $assessmentAttemptsResponse->body()
            ]);
        }

        if ($result === 'shortlisted') {
            $shortlistedJobsApiUrl = "{$baseUrl}/api/user/shortlistedapplicants";
            $shortlistedJobsResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken,
                'Accept' => 'application/json'
            ])->post($shortlistedJobsApiUrl, $requestData);

            if (!$shortlistedJobsResponse->successful()) {
                Log::error('Failed to store shortlisted job via API', [
                    'status' => $shortlistedJobsResponse->status(),
                    'body' => $shortlistedJobsResponse->body()
                ]);
            }
        }

        Session::forget('current_index');
        Session::forget('total_score');
        Session::forget('start_time');
        Session::forget('pass_mark');
        Session::forget('job_id');

        if ($authToken) {
            $userApiUrl = config('app.api_base_url') . '/api/profile';
            $userResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $authToken
            ])->get($userApiUrl);

            if ($userResponse->successful()) {
                $userDetails = $userResponse->json();
                $userId = $userDetails['id'];
                Session::put("completed_{$assessment_id}_{$userId}", true);
            } else {
                Log::error('Failed to fetch user details after quiz completion', [
                    'status' => $userResponse->status(),
                    'body' => $userResponse->body()
                ]);
            }
        }

        return redirect()->route('posts.index', ['result' => $result, 'modal' => true])->with('clearLocalStorage', true);
    }
}
