<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>recruitment portal</title>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
        @stack('styles') <!-- For any additional page-specific styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="">
        <header class="fixed top-0 z-10 w-full">
            <nav
                class="flex-no-wrap shadow-dark-mild relative flex w-full items-center justify-between bg-slate-300 py-2 dark:bg-neutral-700 lg:flex-wrap lg:justify-start lg:py-4">
                <div class="flex w-full flex-wrap items-center justify-between px-3">
                    <!-- Hamburger button for mobile view -->
                    <button
                        class="block border-0 bg-transparent px-2 text-black/50 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 lg:hidden"
                        type="button" data-twe-collapse-init data-twe-target="#navbarSupportedContent1"
                        aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="[&>svg]:w-7 [&>svg]:stroke-black/50 dark:[&>svg]:stroke-neutral-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <!-- Collapsible navigation container -->
                    <div class="!visible hidden flex-grow basis-[100%] items-center lg:!flex lg:basis-auto"
                        id="navbarSupportedContent1" data-twe-collapse-item>
                        <a class="mb-4 me-5 ms-2 mt-3 flex items-center text-neutral-900 hover:text-neutral-900 focus:text-neutral-900 dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400 lg:mb-0 lg:mt-0"
                            href="/">
                            <img src="https://eclectics.io/wp-content/uploads/assets/eclectics.svg" style="height: 15px"
                                alt="Eclectics Logo" loading="lazy" />
                        </a>
                        <ul class="list-style-none me-auto flex flex-col ps-0 lg:flex-row" data-twe-navbar-nav-ref>

                            @if (session()->has('api_token'))
                                <li class="mb-4 lg:mb-0 lg:pe-2" data-twe-nav-item-ref>
                                    <a class="text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80 lg:px-2"
                                        href="{{ route('dashboard') }}" data-twe-nav-link-ref>Dashboard</a>
                                </li>
                                <li class="mb-4 lg:mb-0 lg:pe-2" data-twe-nav-item-ref>
                                    <a class="text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80 lg:px-2"
                                        href="{{ route('posts.index') }}" data-twe-nav-link-ref>Open Jobs</a>
                                </li>
                                <li class="mb-4 lg:mb-0 lg:pe-2" data-twe-nav-item-ref>
                                    <a class="text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80 lg:px-2"
                                        href="{{ route('user.applications') }}" data-twe-nav-link-ref>My
                                        Applications</a>
                                </li>
                            @else
                                <li class="mb-4 lg:mb-0 lg:pe-2" data-twe-nav-item-ref>
                                    <a class="text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80 lg:px-2"
                                        href="/" data-twe-nav-link-ref>Home</a>
                                </li>
                            @endif

                        </ul>
                    </div>

                    <!-- Right elements -->
                    <div class="relative flex items-center">


                        @if (session()->has('api_token'))
                            <!-- First dropdown container -->
                            {{-- 
                            <div class="relative" data-twe-dropdown-ref data-twe-dropdown-alignment="end">
                                <!-- First dropdown trigger -->
                                <a class="me-4 flex items-center text-neutral-600 dark:text-white" href="#"
                                    id="dropdownMenuButton1" role="button" data-twe-dropdown-toggle-ref
                                    aria-expanded="false">
                                    <!-- Dropdown trigger icon -->
                                    <span class="[&>svg]:w-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <!-- Notification counter -->
                                    <span
                                        class="bg-danger absolute -mt-4 ms-2.5 rounded-full px-[0.35em] py-[0.15em] text-[0.6rem] font-bold leading-none text-white">3</span>
                                </a>
                                <!-- First dropdown menu -->
                                <ul class="dark:bg-surface-dark absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg data-[twe-dropdown-show]:block"
                                    aria-labelledby="dropdownMenuButton1" data-twe-dropdown-menu-ref>
                                    <!-- First dropdown menu items -->
                                    <li>
                                        <a class="dark:bg-surface-dark block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                            href="#" data-twe-dropdown-item-ref>Notification 1</a>
                                    </li>
                                    <li>
                                        <a class="dark:bg-surface-dark block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                            href="#" data-twe-dropdown-item-ref>Notification 2</a>
                                    </li>
                                    <li>
                                        <a class="dark:bg-surface-dark block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                            href="#" data-twe-dropdown-item-ref>Notification 3</a>
                                    </li>
                                </ul>
                            </div> --}}
                            <!-- Second dropdown container -->
                            <div class="relative" data-twe-dropdown-ref data-twe-dropdown-alignment="end">
                                <!-- Second dropdown trigger -->
                                <a class="flex items-center whitespace-nowrap transition duration-150 ease-in-out motion-reduce:transition-none"
                                    href="#" id="dropdownMenuButton2" role="button" data-twe-dropdown-toggle-ref
                                    aria-expanded="false">
                                    <!-- User avatar -->
                                    <img src="https://tecdn.b-cdn.net/img/new/avatars/2.jpg" class="rounded-full"
                                        style="height: 25px; width: 25px" alt="" loading="lazy" />
                                </a>
                                <!-- Second dropdown menu -->
                                <ul class="dark:bg-surface-dark absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg data-[twe-dropdown-show]:block"
                                    aria-labelledby="dropdownMenuButton2" data-twe-dropdown-menu-ref>
                                    <!-- Second dropdown menu items -->

                                    <li>

                                        <a class="dark:bg-surface-dark block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                            href="{{ route('myprofile') }}" data-twe-dropdown-item-ref>My Profile</a>
                                    </li>
                                    <li>
                                        <a class="dark:bg-surface-dark block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                            href="#" data-twe-dropdown-item-ref>Settings</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button
                                                class="dark:bg-surface-dark block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25"
                                                data-twe-dropdown-item-ref type="submit">Log Out</button>
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        @else
                            <a class="me-4 text-neutral-600 dark:text-white" href="{{ route('login') }}">
                                <span class="[&>svg]:w-5">
                                    <svg fill="#081b68" height="25px" width="25px" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 296.999 296.999" xml:space="preserve" stroke="#081b68">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M146.603,0c-31.527,0-61.649,9.762-87.11,28.232c-4.377,3.176-5.567,9.188-2.73,13.791l23.329,37.845 c1.509,2.449,3.971,4.158,6.793,4.716c2.82,0.559,5.748-0.084,8.077-1.773c13.897-10.081,30.343-15.41,47.56-15.41 c44.718,0,81.098,36.38,81.098,81.098c0,44.718-36.38,81.098-81.098,81.098c-17.217,0-33.663-5.329-47.56-15.41 c-2.329-1.689-5.255-2.331-8.077-1.773c-2.821,0.558-5.283,2.267-6.793,4.716l-23.329,37.846 c-2.838,4.603-1.647,10.615,2.73,13.791c25.46,18.47,55.583,28.232,87.11,28.232c81.883,0,148.5-66.617,148.5-148.5 S228.486,0,146.603,0z M146.603,276.326c-23.925,0-46.906-6.529-67.024-18.965l12.579-20.407 c15.288,8.741,32.497,13.317,50.364,13.317c56.117,0,101.771-45.655,101.771-101.771c0-56.116-45.655-101.771-101.771-101.771 c-17.866,0-35.076,4.576-50.364,13.317L79.579,39.638c20.117-12.435,43.099-18.965,67.024-18.965 c70.483,0,127.826,57.343,127.826,127.826S217.087,276.326,146.603,276.326z">
                                                        </path>
                                                        <path
                                                            d="M105.966,193.934c-2.115,3.172-2.312,7.25-0.513,10.611c1.799,3.36,5.302,5.459,9.113,5.459h45.482 c3.456,0,6.684-1.727,8.601-4.603l34.112-51.167c2.315-3.472,2.315-7.996,0-11.467L168.65,91.599 c-1.917-2.876-5.144-4.603-8.601-4.603h-45.482c-3.812,0-7.315,2.099-9.113,5.459c-1.799,3.361-1.602,7.44,0.513,10.611 l12.027,18.041H29.288c-15.104,0-27.393,12.288-27.393,27.393s12.288,27.393,27.393,27.393h88.705L105.966,193.934z M29.288,155.219c-3.705,0-6.719-3.014-6.719-6.719c0-3.705,3.014-6.719,6.719-6.719h108.02c3.812,0,7.315-2.099,9.113-5.459 c1.799-3.361,1.602-7.44-0.513-10.611l-12.027-18.041h20.635l27.22,40.83l-27.22,40.83h-20.635l12.027-18.041 c2.115-3.172,2.312-7.25,0.513-10.611c-1.799-3.36-5.302-5.459-9.113-5.459H29.288z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        @endif
                    </div>

                </div>
            </nav>
        </header>
        <main class="mx-auto px-4 py-8">
            {{ $slot }}
        </main>

        <!--Footer container-->
        @stack('scripts')
        <x-footer />


    </body>

</html>
