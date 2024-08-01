<x-layout>
    <div class="relative flex flex-col items-center justify-start sm:justify-center min-h-screen overflow-hidden py-6 sm:py-12 bg-white">
        <div class="max-w-xl w-full px-5 text-center mt-20 sm:mt-0">
            <h2 class="mb-2 text-3xl sm:text-4xl md:text-[42px] font-bold text-zinc-800">Check your inbox</h2>
            <p class="mb-2 text-base sm:text-lg text-zinc-500">
                We are glad, for making the first step to work with us. We’ve sent you a verification link to your email address <span class="font-medium text-indigo-500"></span>.
            </p>
            <p class="mb-2 text-base sm:text-lg text-zinc-500">Did not receive email?</p>
            <form action="{{route('verification.send')}}" method="post">
                @csrf
                <button  class="mt-3 inline-block w-full sm:w-96 rounded bg-gray-900 px-5 py-3 font-medium text-white shadow-md shadow-indigo-500/20 hover:bg-indigo-700">Resend Email →</button>
            </form>
            </div>
    </div>
    
    
    
</x-layout>