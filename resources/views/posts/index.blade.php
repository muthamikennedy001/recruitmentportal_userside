<x-layout>

    @if ((isset($jobs) && count($jobs) > 0) || (isset($paginatedJobs) && $paginatedJobs->count() > 0))
        <div class="relative flex flex-col gap-4 overflow-hidden bg-gray-50 p-6 sm:py-12">
            <h1 class="text-center text-3xl font-bold leading-9 text-slate-900">Latest Job Postings</h1>
            <section class="search-section" style="display: flex; justify-content: center; margin-bottom: 20px;">
                <div class="container" style="width: 100%; max-width: 800px;">
                    <div class="search-box" style="width: 100%;">
                        <form action="{{ route('jobs.search') }}" method="GET" style="display: flex;">
                            <input type="text" name="search"
                                placeholder="Search by title, category, location, tag, salary range..."
                                value="{{ old('search') }}"
                                style="flex-grow: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px 0 0 4px;">
                            <button type="submit"
                                class="flex items-center gap-1 rounded-r-md bg-purple-900 px-4 py-2 font-medium text-white"
                                style="border: none; cursor: pointer;">Search</button>
                        </form>
                    </div>
                </div>
            </section>
            <div
                class="mx-auto grid w-fit grid-cols-1 justify-center justify-items-center gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach (isset($paginatedJobs) ? $paginatedJobs : $jobs as $job)
                    <div class="w-full rounded-xl bg-white shadow-md duration-500 hover:scale-105 hover:shadow-xl">
                        <div
                            class="mx-auto flex flex-row justify-between gap-3 rounded-md px-5 py-4 sm:flex-row sm:items-center">
                            <div>
                                <!-- Job Category -->
                                <span class="text-sm text-purple-600">
                                    {{ $job['category'] ?? 'Category Not Specified' }}</span>

                                <!-- Job Title -->

                                <h3 class="mt-px font-bold">{{ $job['title'] ?? 'Not Specified' }}</h3>
                                <!-- Job Tag and Location -->
                                <div class="mt-2 flex items-center gap-3">

                                    <span
                                        class="rounded-full bg-purple-100 px-3 py-1 text-sm text-purple-700">{{ $job['tag'] ?? 'No Tag' }}</span>

                                    <span class="flex items-center gap-1 text-sm text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $job['location'] ?? 'Location Not Specified' }}
                                    </span>

                                </div>
                                <div class="mt-2 flex items-center gap-3">

                                    <span class="flex items-center gap-1 text-sm text-slate-600">
                                        <svg width="30px" height="30px" viewBox="0 0 1024 1024" class="icon"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M732.1 399.3C534.6 356 696.5 82.1 425.9 104.8s-527.2 645.8-46.8 791.7 728-415 353-497.2z"
                                                    fill="#46bbd8"></path>
                                                <path
                                                    d="M539.5 838.8c-1.4 0-2.9-0.3-4.2-1L330.1 730.3a8.95 8.95 0 0 1-3.8-12.1L529 331.1a8.92 8.92 0 0 1 8-4.8c1.4 0 2.9 0.3 4.2 1l205.2 107.5c4.4 2.3 6.1 7.7 3.8 12.1L547.4 834a8.92 8.92 0 0 1-7.9 4.8z"
                                                    fill="#519ea9"></path>
                                                <path
                                                    d="M537 335.3l205.2 107.5-202.7 387-205.2-107.4L537 335.3m0-17.9c-1.8 0-3.6 0.3-5.3 0.8-4.5 1.4-8.3 4.6-10.5 8.8L318.4 714.1a17.9 17.9 0 0 0 7.6 24.2l205.2 107.5c2.6 1.4 5.4 2 8.3 2 1.8 0 3.6-0.3 5.3-0.8 4.5-1.4 8.3-4.6 10.5-8.8L758.1 451a17.88 17.88 0 0 0-7.6-24.1L545.3 319.4c-2.5-1.3-5.4-2-8.3-2z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M538.4 835.5c-1 0-2-0.2-2.9-0.5l-254-87a8.98 8.98 0 0 1-5.6-11.4L440 257.4c1.3-3.7 4.7-6.1 8.5-6.1 1 0 1.9 0.2 2.9 0.5l254 87c2.2 0.8 4.1 2.4 5.1 4.5s1.2 4.6 0.4 6.8l-164 479.3c-0.8 2.2-2.4 4.1-4.5 5.1-1.3 0.7-2.6 1-4 1z"
                                                    fill="#FFFFFF"></path>
                                                <path
                                                    d="M448.6 260.4l254 87-164.2 479.1-254-87 164.2-479.1m0-17.9c-2.7 0-5.4 0.6-7.9 1.8a18.1 18.1 0 0 0-9.1 10.3L267.5 733.7c-3.2 9.4 1.8 19.5 11.1 22.7l254 87c1.9 0.6 3.8 1 5.8 1 2.7 0 5.4-0.6 7.9-1.8 4.3-2.1 7.5-5.8 9.1-10.3l164.1-479.2c3.2-9.4-1.8-19.5-11.1-22.7l-254-87c-1.9-0.6-3.9-0.9-5.8-0.9z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M448.6 323c-6.9 0-13.7-1.1-20.3-3.4-2.2-0.8-4.1-2.4-5.1-4.5s-1.2-4.6-0.4-6.8l17.4-50.8c1.3-3.7 4.7-6.1 8.5-6.1 1 0 1.9 0.2 2.9 0.5l50.8 17.4c2.2 0.8 4.1 2.4 5.1 4.5s1.2 4.6 0.4 6.8a62.83 62.83 0 0 1-59.3 42.4z"
                                                    fill="#FFFFFF"></path>
                                                <path
                                                    d="M448.6 260.4l50.8 17.4a53.82 53.82 0 0 1-50.8 36.3c-5.8 0-11.6-0.9-17.4-2.9l17.4-50.8m0-17.9c-7.4 0-14.4 4.7-16.9 12.1l-17.4 50.8c-1.5 4.5-1.2 9.4 0.9 13.7 2.1 4.3 5.8 7.5 10.3 9.1 7.5 2.6 15.3 3.9 23.2 3.9a71.6 71.6 0 0 0 67.7-48.4c1.5-4.5 1.2-9.4-0.9-13.7a18.1 18.1 0 0 0-10.3-9.1l-50.8-17.4c-2-0.7-3.9-1-5.8-1z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M685.1 407.1c-1 0-2-0.2-2.9-0.5a62.74 62.74 0 0 1-39-79.6c1.3-3.7 4.7-6.1 8.5-6.1 1 0 1.9 0.2 2.9 0.5l50.8 17.4c4.7 1.6 7.2 6.7 5.6 11.4L693.6 401c-0.8 2.2-2.4 4.1-4.5 5.1-1.3 0.7-2.6 1-4 1z"
                                                    fill="#FFFFFF"></path>
                                                <path
                                                    d="M651.7 330l50.8 17.4-17.4 50.8a53.8 53.8 0 0 1-33.4-68.2m0-17.9c-2.7 0-5.4 0.6-7.9 1.8a18.1 18.1 0 0 0-9.1 10.3c-12.8 37.3 7.2 78.1 44.5 90.9 1.9 0.7 3.9 1 5.8 1 7.4 0 14.4-4.7 16.9-12.1l17.4-50.8c1.5-4.5 1.2-9.4-0.9-13.7a18.1 18.1 0 0 0-10.3-9.1L657.5 313c-1.8-0.6-3.8-0.9-5.8-0.9z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M335.3 765.9c-1 0-2-0.2-2.9-0.5L281.6 748c-2.2-0.8-4.1-2.4-5.1-4.5s-1.2-4.6-0.4-6.8l17.4-50.8c0.8-2.2 2.4-4.1 4.5-5.1a8.9 8.9 0 0 1 6.8-0.4 62.74 62.74 0 0 1 39 79.6c-0.8 2.2-2.4 4.1-4.5 5.1-1.3 0.5-2.7 0.8-4 0.8z"
                                                    fill="#FFFFFF"></path>
                                                <path
                                                    d="M301.9 688.8c28.1 9.6 43 40.1 33.4 68.2l-50.8-17.4 17.4-50.8m0-17.9c-2.7 0-5.4 0.6-7.9 1.8a18.1 18.1 0 0 0-9.1 10.3l-17.4 50.8c-3.2 9.4 1.8 19.5 11.1 22.7l50.8 17.4c1.9 0.6 3.8 1 5.8 1 2.7 0 5.4-0.6 7.9-1.8 4.3-2.1 7.5-5.8 9.1-10.3 6.2-18.1 5-37.5-3.4-54.7-8.4-17.2-23-30-41.1-36.2-1.9-0.7-3.9-1-5.8-1z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M538.4 835.5c-1 0-1.9-0.2-2.9-0.5l-50.8-17.4c-2.2-0.8-4.1-2.4-5.1-4.5s-1.2-4.6-0.4-6.8a62.75 62.75 0 0 1 59.2-42.4c6.9 0 13.8 1.1 20.4 3.4 2.2 0.8 4.1 2.4 5.1 4.5s1.2 4.6 0.4 6.8l-17.4 50.8a9.01 9.01 0 0 1-8.5 6.1z"
                                                    fill="#FFFFFF"></path>
                                                <path
                                                    d="M538.4 772.8c5.8 0 11.7 0.9 17.5 2.9l-17.4 50.8-50.8-17.4a53.56 53.56 0 0 1 50.7-36.3m0-17.9v17.9-17.9a71.6 71.6 0 0 0-67.7 48.4c-3.2 9.4 1.8 19.5 11.1 22.7l50.8 17.4c1.9 0.6 3.8 1 5.8 1 2.7 0 5.4-0.6 7.9-1.8 4.3-2.1 7.5-5.8 9.1-10.3l17.4-50.8c3.2-9.4-1.8-19.5-11.1-22.7-7.6-2.6-15.4-3.9-23.3-3.9z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M493.6 692.4c-16.4 0-32.6-2.7-48.3-8.1-1-0.4-2.2-0.7-3.4-1.3a148.5 148.5 0 0 1-97.2-143c0-0.8 0.2-1.7 0.4-2.4l27.6-80.6c0.3-0.8 0.7-1.5 1.2-2.2 27.9-37.8 72.7-60.3 119.7-60.3 16.4 0 32.6 2.7 48.2 8.1 51.5 17.6 89.2 61.9 98.4 115.5 1.7 9.5 2.5 19.2 2.3 28.8 0 0.8-0.2 1.6-0.4 2.4l-27.6 80.6c-0.3 0.8-0.7 1.5-1.2 2.2-28 37.7-72.7 60.3-119.7 60.3z"
                                                    fill="#FFFFFF"></path>
                                                <path
                                                    d="M493.5 402.6c15.1 0 30.5 2.5 45.6 7.6 50.3 17.2 84.6 60.1 93 109.2 1.6 8.9 2.4 18.1 2.2 27.2l-27.6 80.6a141.19 141.19 0 0 1-113.1 57.1c-15.1 0-30.5-2.5-45.7-7.6-1-0.3-2-0.7-3-1.2-0.1 0-0.2-0.1-0.2-0.1-57.7-21.3-93.3-76.6-91.9-135.2l27.6-80.6c26.4-35.8 68.7-57 113.1-57m0-16.3c-49.6 0-96.8 23.8-126.3 63.6-1 1.3-1.8 2.8-2.3 4.4l-27.6 80.6c-0.5 1.6-0.8 3.2-0.9 4.9a156.78 156.78 0 0 0 102.3 150.7l3.8 1.5c16.5 5.7 33.6 8.5 50.9 8.5 49.6 0 96.7-23.8 126.2-63.6 1-1.3 1.8-2.8 2.3-4.4l27.6-80.6c0.5-1.6 0.8-3.2 0.9-4.9 0.3-10.1-0.6-20.4-2.4-30.5a156.69 156.69 0 0 0-103.8-121.7c-16.3-5.6-33.4-8.5-50.7-8.5z"
                                                    fill="#151B28"></path>
                                                <path
                                                    d="M634.3 546.6l-27.6 80.6c-35.5 48-99.2 69.8-158.8 49.4-1-0.3-2-0.7-3-1.2-0.1 0-0.2-0.1-0.2-0.1-43.1-31.7-62.9-88.9-44.6-142.2 22.5-65.7 94-100.7 159.6-78.3a125.1 125.1 0 0 1 72.5 64.4 140 140 0 0 1 2.1 27.4z"
                                                    fill="#2AEFC8"></path>
                                                <path
                                                    d="M456.5 496.9c-11 5.4-18 10.7-22.3 23.3-4.8 14.1 1.3 26.5 14.5 31 34.1 11.7 45.7-54.8 94.4-38.1 21.3 7.3 31.1 25.7 26.7 47.7l22.3 7.6-4.2 12.2-22.1-7.6c-6.4 14-18.5 25.7-30.3 32l-8.6-11.7c11.4-6.4 22.1-15.5 26.9-29.6 5.9-17.3-0.5-29.3-15.1-34.3-38.1-13.1-50.7 53.1-94.9 37.9-19.7-6.7-29.4-24.9-25.7-44.9l-22.3-7.6 4.2-12.2 22.1 7.6c6.3-13.8 16.3-20.7 27.4-25.6l7 12.3z"
                                                    fill="">
                                                </path>
                                            </g>
                                        </svg>
                                        Ksh. {{ $job['salary_range'] ?? 'Salary Not Specified' }}
                                    </span>
                                </div>
                                <!-- Job Closing Date -->
                                <div class="mt-2 flex items-center gap-3">

                                    <span class="flex items-center gap-1 text-sm text-slate-600">
                                        <svg width="25px" height="25px" viewBox="0 0 50 50"
                                            xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <path fill="#1420cc"
                                                d="M43,8.277H40.548V7a2.5,2.5,0,0,0-2.5-2.5H37A2.5,2.5,0,0,0,34.5,7V8.277H15.5V7A2.5,2.5,0,0,0,13,4.5H11.952A2.5,2.5,0,0,0,9.452,7V8.277H7a2.5,2.5,0,0,0-2.5,2.5V43A2.5,2.5,0,0,0,7,45.5H43A2.5,2.5,0,0,0,45.5,43V10.777A2.5,2.5,0,0,0,43,8.277Z" />
                                            <path fill="#767af9"
                                                d="M30.028,15.557a14.472,14.472,0,1,1-14.47,14.471A14.488,14.488,0,0,1,30.028,15.557Z" />
                                            <path fill="#1420cc"
                                                d="M30.005,41.831a11.8,11.8,0,1,0-11.8-11.8A11.817,11.817,0,0,0,30.005,41.831Z" />
                                            <path fill="#ffffff"
                                                d="M30.005,19.226a10.8,10.8,0,1,1-10.8,10.8A10.815,10.815,0,0,1,30.005,19.226Z" />
                                            <path fill="#ffffff"
                                                d="M7,44.5A1.5,1.5,0,0,1,5.5,43V15.468H24.848A15.446,15.446,0,0,0,24.606,44.5Z" />
                                            <path fill="#ffffff"
                                                d="M44.5,43A1.5,1.5,0,0,1,43,44.5H35.451A15.525,15.525,0,0,0,44.5,35.451Z" />
                                            <path fill="#1420cc"
                                                d="M10.318,19.841a2.411,2.411,0,1,0,2.411,2.41A2.413,2.413,0,0,0,10.318,19.841Z" />
                                            <path fill="#4430df"
                                                d="M10.318,23.663a1.411,1.411,0,1,1,1.411-1.412A1.413,1.413,0,0,1,10.318,23.663Z" />
                                            <path fill="#1420cc"
                                                d="M10.318,27.618a2.411,2.411,0,1,0,2.411,2.41A2.413,2.413,0,0,0,10.318,27.618Z" />
                                            <path fill="#4430df"
                                                d="M10.318,31.439a1.411,1.411,0,1,1,1.411-1.411A1.412,1.412,0,0,1,10.318,31.439Z" />
                                            <circle fill="#1420cc" cx="10.318" cy="37.806" r="2.411" />
                                            <circle fill="#4430df" cx="10.318" cy="37.806" r="1.411" />
                                            <rect fill="#1e72b3" height="6.446" rx="1.5" width="4.045" x="35.503"
                                                y="5.5" />
                                            <rect fill="#1e72b3" height="6.446" rx="1.5" width="4.045" x="10.452"
                                                y="5.5" />
                                            <path fill="#2479ae"
                                                d="M5.5,10.777A1.5,1.5,0,0,1,7,9.277H9.452v1.169a2.5,2.5,0,0,0,2.5,2.5H13a2.5,2.5,0,0,0,2.5-2.5V9.277H34.5v1.169a2.5,2.5,0,0,0,2.5,2.5h1.048a2.5,2.5,0,0,0,2.5-2.5V9.277H43a1.5,1.5,0,0,1,1.5,1.5v3.1H5.5Z" />
                                        </svg>
                                        {{ isset($job['closing_date']) ? \Carbon\Carbon::parse($job['closing_date'])->format('d M Y') : 'Closing Date Not Specified' }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('posts.show', ['post' => $job['id']]) }}">

                                <button
                                    class="flex gap-1 rounded-md bg-purple-900 px-4 py-2 align-bottom font-medium text-white">
                                    View
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </a>

                        </div>

                    </div>
                @endforeach
                <div x-data="{ open: {{ $modal ? 'true' : 'false' }}, result: '{{ $result }}' }">
                    <div @keydown.escape.window="open = false"
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="open"
                        style="display: none" x-cloak>
                        <!-- Modal -->
                        <div class="flex min-h-screen items-center justify-center">
                            <div class="transform overflow-hidden rounded-lg bg-white p-6 shadow-xl transition-all sm:w-full sm:max-w-lg"
                                @click.away="open = false" x-transition:enter="ease-out duration-100"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0">
                                <!-- Modal header -->
                                <div class="flex items-start justify-between">
                                    <div class="text-left">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900"
                                            x-show="result === 'shortlisted'">Congratulations🥳🥳🥳
                                            You Have Passed The First Phase Of The Application</h3>
                                        <h3 class="text-lg font-medium leading-6 text-gray-900"
                                            x-show="result === 'rejected'">Sorry, you have failed the first phase of
                                            the application.</h3>
                                        <div class="mt-1">
                                            <p class="text-bold text-gray-500" x-show="result === 'shortlisted'">
                                                Read the instructions for the next application.
                                            </p>
                                            <p class="text-bold text-gray-500" x-show="result === 'rejected'">
                                                But you can try other jobs.
                                            </p>
                                        </div>
                                    </div>
                                    <span class="cursor-pointer" @click="open = false">✕</span>
                                </div>

                                <!-- Modal body -->
                                <div class="my-2 text-left">
                                    <ol class="list-decimal" x-show="result === 'shortlisted'">
                                        <li>You will receive an email with another set of practical questions.</li>
                                        <li>Follow the instructions in the email.</li>
                                        <li>Make sure you submit before the deadline.</li>
                                    </ol>
                                    <div x-show="result === 'rejected'">
                                        <p>We encourage you to apply for other available job postings that match your
                                            skills and experience.</p>
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <div class="mt-4 flex items-center justify-end gap-2">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-blue-500 px-4 py-2 text-base font-medium text-blue-500 hover:border-blue-400 hover:bg-blue-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm"
                                        @click="open = false">
                                        Apply For More Jobs
                                    </button>
                                    <a href="{{ route('user.applications') }}">
                                        <button type="button" x-show="result === 'shortlisted'"
                                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-base font-medium text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm"
                                            @click="open = false">
                                            My Applications
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ open: {{ session('modal_message') ? 'true' : 'false' }}, message: '{{ session('modal_message') }}' }">
                    <div @keydown.escape.window="open = false"
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="open" x-cloak>
                        <!-- Modal -->
                        <div class="flex min-h-screen items-center justify-center">
                            <div class="transform overflow-hidden rounded-lg bg-white p-6 shadow-xl transition-all sm:w-full sm:max-w-lg"
                                @click.away="open = false" x-transition:enter="ease-out duration-100"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0">

                                <!-- Modal header -->
                                <div class="flex items-start justify-between">
                                    <div class="text-left">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900"> Oops Opps !! </h3>
                                    </div>
                                    <span class="cursor-pointer" @click="open = false">✕</span>
                                </div>

                                <!-- Modal body -->
                                <div class="my-2 text-left">
                                    <p class="text-bold text-gray-500" x-text="message"></p>
                                </div>

                                <!-- Modal footer -->
                                <div class="mt-4 flex items-center justify-end gap-2">

                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-blue-500 px-4 py-2 text-base font-medium text-blue-500 hover:border-blue-400 hover:bg-blue-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm"
                                        @click="open = false">
                                        Close
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="mt-4">
                @if (isset($paginatedJobs) && method_exists($paginatedJobs, 'links'))
                    {{ $paginatedJobs->links() }}
                @elseif (isset($jobs) && method_exists($jobs, 'links'))
                    {{ $jobs->links() }}
                @endif
            </div>

        </div>
    @else
        <x-nojobs />
    @endif
</x-layout>
