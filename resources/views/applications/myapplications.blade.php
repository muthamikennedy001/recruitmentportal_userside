<x-layout>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <div class="mx-auto flex max-w-full flex-col p-4 md:flex-row md:p-8">
        <div class="rounded-lg bg-white p-4 shadow-lg md:p-8">
            <div class="md:flex md:items-start md:justify-between">
                <div class="mb-6 md:mb-0 md:mr-10">
                    <p class="font-medium text-blue-500">Applied For</p>
                    <h1 class="mt-2 text-2xl font-bold text-gray-900 md:text-4xl">{{ $job['title'] ?? 'No Title' }}</h1>
                    <div class="mt-4 flex items-center text-gray-600">
                        <span class="mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <span>{{ $job['tag'] ?? 'Tag Not Specified' }}</span>
                        <span class="mx-2 md:mx-4">|</span>
                        <span class="mr-2">
                            <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <!-- Salary icon SVG -->
                            </svg>
                        </span>
                        <span>Ksh. {{ $job['salary_range'] ?? 'Salary Not Specified' }}</span>
                    </div>
                    <p class="mt-4 text-gray-500">Applied On:
                        <b>{{ isset($application['application_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $application['application_date'])->format('M d Y') : 'Closing Date Not Specified' }}</b>
                    </p>
                </div>
                <div class="md:ml-10 md:mt-8">
                    <div class="mx-auto flex max-w-screen-lg items-start">
                        <div class="w-full">
                            <div class="flex w-full items-center">
                                <div
                                    class="@if ($application['applicant']['status'] == 'Hired') bg-green-700  @elseif($application['applicant']['status'] == 'Approved') bg-green-800  @elseif($application['applicant']['status'] == 'Rejected') bg-red-700 @else bg-gray-400 @endif mx-[-1px] flex h-8 w-8 shrink-0 items-center justify-center rounded-full p-1.5">
                                    <span class="text-base font-bold text-gray-900">1</span>
                                </div>
                                <div class="mx-4 h-1 w-full rounded-lg bg-blue-400"></div>
                            </div>
                            <div class="mr-4 mt-2">
                                <h6 class="text-base font-bold text-blue-500">Assessments</h6>
                                @if ($application['applicant']['status'] == 'In Review')
                                    <p class="text-bold text-gray-700">In Review</p>
                                @elseif($application['applicant']['status'] == 'Approved')
                                    <p class="text-bold text-green-700">Done</p>
                                @elseif($application['applicant']['status'] == 'Hired')
                                    <p class="text-bold text-green-700">Done</p>
                                @elseif($application['applicant']['status'] == 'Rejected')
                                    <p class="text-bold text-green-700">Done</p>
                                @endif

                            </div>
                        </div>
                        <div class="w-full">
                            <div class="flex w-full items-center">
                                <div
                                    class="@if ($application['applicant']['status'] == 'Hired') bg-green-700  @elseif($application['applicant']['status'] == 'Approved') bg-green-800  @elseif($application['applicant']['status'] == 'Rejected') bg-red-700 @else bg-gray-400 @endif mx-[-1px] flex h-8 w-8 shrink-0 items-center justify-center rounded-full p-1.5">
                                    <span class="text-base font-bold text-gray-900">2</span>
                                </div>
                                <div class="mx-4 h-1 w-full rounded-lg bg-blue-400"></div>
                            </div>
                            <div class="mr-4 mt-2">
                                <h6 class="text-base font-bold text-blue-500">Interview</h6>
                                @if ($application['applicant']['status'] == 'In Review')
                                    <p class="text-bold text-gray-700">Not Done</p>
                                @elseif($application['applicant']['status'] == 'Approved')
                                    <p class="text-bold text-green-900">Not Done</p>
                                @elseif($application['applicant']['status'] == 'Hired')
                                    <p class="text-bold text-green-900">Done</p>
                                @elseif($application['applicant']['status'] == 'Rejected')
                                    <p class="text-bold text-green-900">Done</p>
                                @endif

                            </div>
                        </div>
                        <div>
                            <div class="flex items-center">
                                <div
                                    class="@if ($application['applicant']['status'] == 'Hired') bg-green-800 @elseif($application['applicant']['status'] == 'Rejected') bg-red-700 @else bg-gray-400 @endif mx-[-1px] flex h-8 w-8 shrink-0 items-center justify-center rounded-full p-1.5">
                                    <span class="text-base font-bold text-gray-900">3</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h6 class="text-base font-bold text-blue-500">Outcome</h6>
                                @if ($application['applicant']['status'] == 'In Review')
                                    <p class="text-xs text-gray-600">Pending</p>
                                @elseif($application['applicant']['status'] == 'Approved')
                                    <p class="text-xs text-gray-600">Pending</p>
                                @elseif($application['applicant']['status'] == 'Hired')
                                    <p class="text-xs text-green-700">Hired</p>
                                @elseif($application['applicant']['status'] == 'Rejected')
                                    <p class="text-xs text-red-700">Rejected</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        {!! $job['description'] ?? '<p>No Description</p>' !!}
                    </div>
                    {{-- <a href="{{ route('checkUserData', ['assessment_id' => $job['assessment_id'], 'job_id' => $job['id']]) }}">
                        <button class="mt-6 bg-purple-900 text-white py-2 px-4 rounded">Apply for this job</button>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</x-layout>
