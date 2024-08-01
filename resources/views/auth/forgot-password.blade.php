<x-layout>
  <div class="relative flex flex-col text-gray-700 bg-transparent shadow-none rounded-xl bg-clip-border justify-center items-center px-4 sm:px-6 py-8 max-w-screen-md mx-auto">
    <div class="mt-7 bg-white rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700 border-2 border-blue-gray-200 w-full">
        <div class="p-6 sm:p-8">
          <div class="text-center">
            <h1 class="block text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">Forgot password?</h1>
            <p class="mt-3 text-sm sm:text-md text-gray-600 dark:text-gray-400">
              Remembered your password?
              <a class="text-blue-500 decoration-2 hover:underline font-medium" href="{{route("login")}}">
                Login here
              </a>
            </p>
          </div>

          @if (session('status'))
          <x-flashMsg msg="{{ session('status') }}" />
          @endif
  
          <div class="mt-6">
            <form action="{{route('password.request')}}" method="post">
              @csrf
              <div class="grid gap-y-4 sm:gap-y-5">
                <div>
                  <label for="email" class="block text-sm sm:text-md font-bold ml-1 mb-2 dark:text-white">Email address</label>
                  <div class="relative">
                    <input type="email" id="email" name="email" class="py-3 sm:py-4 px-4 sm:px-5 block w-full border-2 border-gray-200 rounded-md text-sm sm:text-md focus:border-blue-500 focus:ring-blue-500 shadow-sm @error('email') ring-red-500 @enderror" 
                    @error('email') ring-red-500 @enderror>
                  </div>
                  @error('email')
                  <p class="error">{{$message}}</p>   
                  @enderror
                </div>
                <button type="submit" class="py-3 sm:py-4 px-4 sm:px-5 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-gray-900 text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm sm:text-md dark:focus:ring-offset-gray-800">Reset password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
</x-layout>
