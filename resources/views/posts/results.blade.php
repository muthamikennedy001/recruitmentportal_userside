<!-- resources/views/quiz/result.blade.php -->
 <!-- If you have a layout file, adjust accordingly -->
 <x-layout>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Quiz Result</div>

                    <div class="card-body">
                        <p>Your total score: {{ $totalScore }}</p>
                        <p>Pass mark: {{ $passMark }}</p>
                        <p>Result: {{ $result }}</p>

                        <!-- You can add more details or styling as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
 </x-layout>
