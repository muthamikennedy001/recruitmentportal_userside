<x-layout>
    <form id="quiz-form" class="mx-auto max-w-3xl px-4 py-12 md:px-8" action="{{ route('quiz.submit') }}" method="POST">
        @csrf
        <input type="hidden" name="assessment_id" value="{{ $assessment_id }}">
        <input type="hidden" name="quiz_data" value="{{ json_encode($quizData) }}">

        <div class="space-y-12">
            <!-- Question Display -->
            <div class="border-b border-gray-900/10 pb-12">
                <div id="timer" class="mt-6 text-center font-semibold text-gray-600">Time Left: <span
                        id="time-remaining"></span></div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Question {{ $currentIndex + 1 }} of
                    {{ count($quizData['questions']) }}</h2>
                <p class="mt-1 font-medium leading-6 text-gray-900">{{ $currentQuestion['question'] }}</p>
                <div class="mt-4 space-y-10">
                    <fieldset>
                        <legend class="sr-only">Choices</legend>
                        <div class="mt-4 space-y-6">
                            @php
                                $isMultiple = count($currentQuestion['correct_answer']) > 1;
                            @endphp
                            @foreach ($currentQuestion['multiple_choices'] as $choice)
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        @if ($isMultiple)
                                            <input id="choice-{{ $loop->index }}" name="answer[]" type="checkbox"
                                                value="{{ $choice }}"
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        @else
                                            <input id="choice-{{ $loop->index }}" name="answer" type="radio"
                                                value="{{ $choice }}"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        @endif
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="choice-{{ $loop->index }}"
                                            class="font-medium text-gray-700">{{ $choice }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="submit" id="submit-btn"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Next</button>
        </div>
    </form>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if (session('clearLocalStorage'))
                    localStorage.removeItem('quizStartTime');
                @endif

                var totalTimeRequired = {{ $totalTimeRequired }};
                var startTime = localStorage.getItem('quizStartTime');
                var elapsedTime = startTime ? Math.floor((Date.now() - startTime) / 1000) : 0;
                var remainingTime = Math.max(totalTimeRequired - elapsedTime, 0);

                // Update timer display function
                function updateTimer() {
                    if (remainingTime <= 0) {
                        clearInterval(timerInterval);
                        window.location.href = "{{ route('quiz.complete', ['assessment_id' => $assessment_id]) }}";
                    } else {
                        var minutes = Math.floor(remainingTime / 60);
                        var seconds = remainingTime % 60;
                        document.getElementById("time-remaining").textContent = minutes + "m " + seconds + "s";
                        remainingTime--;
                    }
                }

                // Initial call to update timer display
                updateTimer();

                // Update the timer every second
                var timerInterval = setInterval(updateTimer, 1000);

                // Store start time in localStorage
                if (!startTime) {
                    localStorage.setItem('quizStartTime', Date.now());
                }
            });
        </script>
    @endpush
</x-layout>
