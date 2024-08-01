<x-layout>
    <div x-data="{ open: false }">
        <button @click="open = true"
            class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-700 focus:bg-blue-700 focus:outline-none">
            Open Modal
        </button>

        <div @keydown.escape.window="open = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            x-show="open" style="display: none" x-cloak>
            <!-- Modal -->
            <div class="flex min-h-screen items-center justify-center">
                <div class="transform overflow-hidden rounded-lg bg-white p-6 shadow-xl transition-all sm:w-full sm:max-w-lg"
                    @click.away="open = false" x-transition:enter="ease-out duration-100"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between">
                        <div class="text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900"> Congratulations You Have Passed The
                                First Phase Of The Application</h3>
                            <div class="mt-1">
                                </a>
                                <p class="text-bold text-gray-500">
                                    Read The Instructions For The Next Application
                                </p>
                            </div>
                        </div>
                        <span class="cursor-pointer" @click="open = false">✕</span>
                    </div>

                    <!-- Modal body -->
                    <div class="my-2 text-left">
                        <ol class="list-decimal">

                            <li>You Will Receive An Email </li>
                            <li>If you have never uploaded the documents you will be prompted to upload first</li>
                            <li>If you want to update documents you can use the profile page</li>
                            <li>Use Of AI or any other assistance is prohibited and can lead to disqualification</li>

                        </ol>
                    </div>

                    <!-- Modal footer -->
                    <div class="mt-4 flex items-center justify-end gap-2">
                        <button type="button"
                            class="inline-flex w-full justify-center rounded-md border border-blue-500 px-4 py-2 text-base font-medium text-blue-500 hover:border-blue-400 hover:bg-blue-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm"
                            @click="open = false">
                            Find More Jobs
                        </button>
                        <button type="button"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-base font-medium text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm"
                            @click="open = false">
                            My Applications
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layout>
