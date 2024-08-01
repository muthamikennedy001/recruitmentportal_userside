<x-layout>
    <style>
        :root {
            --main-color: #4a76a8;
        }

        .bg-main-color {
            background-color: var(--main-color);
        }

        .text-main-color {
            color: var(--main-color);
        }

        .border-main-color {
            border-color: var(--main-color);
        }
    </style>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div class="container mx-auto my-5 p-5">
        <div class="no-wrap md:-mx-2 md:flex">
            <!-- Left Side -->
            <div class="mb-4 w-full md:mx-2 md:w-3/12">
                <!-- Profile Card -->
                <div class="border-t-4 border-green-400 bg-white p-3">
                    <div class="image overflow-hidden">
                        <img class="mx-auto h-auto w-full"
                            src="https://lavinephotography.com.au/wp-content/uploads/2017/01/PROFILE-Photography-112.jpg"
                            alt="">
                    </div>

                    <h1 class="my-1 text-xl font-bold leading-8 text-gray-900">{{ $userData['data']['name'] }}</h1>
                    <h3 class="font-lg text-semibold leading-6 text-gray-600">{{ $userData['data']['email'] }}</h3>
                    {{-- <p class="text-sm text-gray-500 hover:text-gray-600 leading-6">
                        I am a skilled React developer with a passion for building responsive and high-performance web applications. With 3 years of experience, I excel in transforming complex requirements into user-friendly interfaces and staying up-to-date with the latest technologies.
                    </p> --}}
                    <ul
                        class="mt-3 divide-y rounded bg-gray-100 px-3 py-2 text-gray-600 shadow-sm hover:text-gray-700 hover:shadow">

                        <li class="flex items-center py-3">
                            <span>Member since</span>
                            <span
                                class="ml-auto">{{ \Carbon\Carbon::parse($userData['data']['created_at'])->format('d M Y') }}</span>
                        </li>
                        <li class="flex items-center py-3">
                            <span></span>
                            <span class="ml-auto">
                                <span class="rounded bg-purple-900 px-2 py-1 text-sm text-white">Edit Profile</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <!-- End of profile card -->
                <div class="my-4"></div>
                <!-- Friends card -->
                <div class="bg-white p-3 hover:shadow">
                    <div class="flex items-center space-x-3 text-xl font-semibold leading-8 text-gray-900">
                        <span class="text-green-500">
                            <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                        <span>My Documents</span>
                    </div>
                    <div class="grid grid-cols-2 gap-1">
                        {{-- <div class="my-2 text-center">
                            <svg width="64px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M864 992H160c-70.4 0-128-57.6-128-128V160c0-70.4 57.6-128 128-128h704c70.4 0 128 57.6 128 128v704c0 70.4-57.6 128-128 128z"
                                        fill="#FFFFFF"></path>
                                    <path
                                        d="M32 144.8v169.6h960V144.8c0-62.4-50.4-112.8-112.8-112.8H144.8C82.4 32 32 82.4 32 144.8z"
                                        fill="#0da6d9"></path>
                                    <path d="M164 168.8m-56.8 0a56.8 56.8 0 1 0 113.6 0 56.8 56.8 0 1 0-113.6 0Z"
                                        fill="#EC7BB0"></path>
                                    <path d="M476 168.8m-56.8 0a56.8 56.8 0 1 0 113.6 0 56.8 56.8 0 1 0-113.6 0Z"
                                        fill="#82CFCD"></path>
                                    <path
                                        d="M476 232.8c-35.2 0-64.8-28.8-64.8-64.8 0-35.2 28.8-64.8 64.8-64.8 35.2 0 64.8 28.8 64.8 64.8-0.8 36-29.6 64.8-64.8 64.8z m0-112.8c-26.4 0-48.8 21.6-48.8 48.8s21.6 48.8 48.8 48.8 48.8-21.6 48.8-48.8-22.4-48.8-48.8-48.8z"
                                        fill="#0eaec4"></path>
                                    <path d="M320 168.8m-56.8 0a56.8 56.8 0 1 0 113.6 0 56.8 56.8 0 1 0-113.6 0Z"
                                        fill="#F1ED7B"></path>
                                    <path
                                        d="M164 232.8c-35.2 0-64.8-28.8-64.8-64.8 0-35.2 28.8-64.8 64.8-64.8 35.2 0 64.8 28.8 64.8 64.8s-28.8 64.8-64.8 64.8z m0-112.8c-26.4 0-48.8 21.6-48.8 48.8s21.6 48.8 48.8 48.8 48.8-21.6 48.8-48.8-21.6-48.8-48.8-48.8zM476 232.8c-35.2 0-64.8-28.8-64.8-64.8 0-35.2 28.8-64.8 64.8-64.8 35.2 0 64.8 28.8 64.8 64.8-0.8 36-29.6 64.8-64.8 64.8z m0-112.8c-26.4 0-48.8 21.6-48.8 48.8s21.6 48.8 48.8 48.8 48.8-21.6 48.8-48.8-22.4-48.8-48.8-48.8zM320 232.8c-35.2 0-64.8-28.8-64.8-64.8 0-35.2 28.8-64.8 64.8-64.8s64.8 28.8 64.8 64.8-29.6 64.8-64.8 64.8zM320 120c-26.4 0-48.8 21.6-48.8 48.8s21.6 48.8 48.8 48.8 48.8-21.6 48.8-48.8S346.4 120 320 120zM32 306.4h960v16H32zM864 834.4H160c-4.8 0-8-3.2-8-8s3.2-8 8-8h704c4.8 0 8 3.2 8 8s-3.2 8-8 8zM480 450.4H160c-4.8 0-8-3.2-8-8s3.2-8 8-8h320c4.8 0 8 3.2 8 8s-3.2 8-8 8zM480 578.4H160c-4.8 0-8-3.2-8-8s3.2-8 8-8h320c4.8 0 8 3.2 8 8s-3.2 8-8 8zM480 706.4H160c-4.8 0-8-3.2-8-8s3.2-8 8-8h320c4.8 0 8 3.2 8 8s-3.2 8-8 8z"
                                        fill="#0eaec4"></path>
                                    <path
                                        d="M864 1000H160c-75.2 0-136-60.8-136-136V160c0-75.2 60.8-136 136-136h704c75.2 0 136 60.8 136 136v704c0 75.2-60.8 136-136 136zM160 40C93.6 40 40 93.6 40 160v704c0 66.4 53.6 120 120 120h704c66.4 0 120-53.6 120-120V160c0-66.4-53.6-120-120-120H160z"
                                        fill="#0eaec4"></path>
                                    <path
                                        d="M871.2 224.8H636.8c-31.2 0-56.8-25.6-56.8-56.8 0-31.2 25.6-56.8 56.8-56.8h234.4c31.2 0 56.8 25.6 56.8 56.8 0 32-25.6 56.8-56.8 56.8z"
                                        fill="#FFFFFF"></path>
                                    <path
                                        d="M871.2 232.8H636.8c-35.2 0-64.8-28.8-64.8-64.8 0-35.2 28.8-64.8 64.8-64.8h234.4c35.2 0 64.8 28.8 64.8 64.8s-28.8 64.8-64.8 64.8zM636.8 120c-26.4 0-48.8 21.6-48.8 48.8s21.6 48.8 48.8 48.8h234.4c26.4 0 48.8-21.6 48.8-48.8s-21.6-48.8-48.8-48.8H636.8z"
                                        fill="#0eaec4"></path>
                                    <path d="M608 442.4h256v256H608z" fill="#AF5655"></path>
                                    <path
                                        d="M838.4 706.4H633.6c-18.4 0-33.6-15.2-33.6-33.6V468c0-18.4 15.2-33.6 33.6-33.6h204.8c18.4 0 33.6 15.2 33.6 33.6v204.8c0 18.4-15.2 33.6-33.6 33.6z m-204.8-256c-9.6 0-17.6 8-17.6 17.6v204.8c0 9.6 8 17.6 17.6 17.6h204.8c9.6 0 17.6-8 17.6-17.6V468c0-9.6-8-17.6-17.6-17.6H633.6z"
                                        fill="#0eaec4"></path>
                                </g>
                            </svg>
                            <a href="#" class="text-main-color text-sm">Resume End point Not Yet Implemented</a>
                        </div> --}}
                        <div class="my-2 text-center">
                            <svg width="64px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <rect width="24" height="24" fill="white"></rect>
                                    <path
                                        d="M11.5144 3.12584C11.8164 2.95805 12.1836 2.95805 12.4856 3.12584L21.4856 8.12584C21.8031 8.30221 22 8.63683 22 9C22 9.36317 21.8031 9.69779 21.4856 9.87416L12.4856 14.8742C12.1836 15.0419 11.8164 15.0419 11.5144 14.8742L9 13.4773V14.6212L11.0287 15.7483C11.6328 16.0839 12.3672 16.0839 12.9713 15.7483L19.3499 12.2046C19.4773 12.1338 19.6353 12.2188 19.6464 12.3641L19.9314 16.0686C20.0072 17.0538 19.3559 17.9336 18.4171 18.1743C17.6573 18.3693 16.5807 18.664 15.8497 18.9368C14.9401 19.2764 13.8454 19.9536 13.1583 20.4134C12.459 20.8812 11.5412 20.8812 10.8419 20.4134C10.3602 20.0911 9.67815 19.6619 9 19.3171V20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20V18.5622C6.50505 18.4164 5.99699 18.2806 5.58296 18.1744C4.64424 17.9336 3.99295 17.0538 4.06873 16.0686L4.35369 12.3642C4.36487 12.2188 4.52279 12.1339 4.65023 12.2047L7 13.5101V12.5C7 12.4565 7.00283 12.4133 7.00836 12.3708L2.51436 9.87416C2.19689 9.69779 2 9.36317 2 9C2 8.63683 2.19689 8.30221 2.51436 8.12584L11.5144 3.12584Z"
                                        fill="#2393a9"></path>
                                </g>
                            </svg>

                            @php
                                $highestCertLink = isset($highestEducationLevel['certificate'])
                                    ? $baseUrlWithStorage . '/' . $highestEducationLevel['certificate']
                                    : '#';
                            @endphp
                            <a class="text-main-color text-sm" href="{{ $highestCertLink }}" target="_blank">
                                {{ isset($highestEducationLevel['certificate']) && $highestEducationLevel['certificate']
                                    ? 'View Degree Certificate'
                                    : 'Certificate not available' }}
                            </a>
                        </div>
                        <div class="my-2 text-center">
                            <svg width="64px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M130.307 227.97h748.911v568.098H130.307z" fill="#0dcae3"></path>
                                    <path
                                        d="M879.218 806.068H130.307l-10-10V227.971l10-10h748.911l10 10v568.098l-10 9.999z m-738.911-20h728.911V237.971H140.307v548.097z"
                                        fill="#0a3848"></path>
                                    <path d="M182.067 278.597h650.094v457.616H182.067z" fill="#c1fafb"></path>
                                    <path d="M647.317 851.206l48.691-28.271 34.106 36.642-2.786-162.345-82.199-4.633z"
                                        fill="#228E9D"></path>
                                    <path
                                        d="M696.205 658.662m-51.076 0a51.076 51.076 0 1 0 102.152 0 51.076 51.076 0 1 0-102.152 0Z"
                                        fill="#0e5ca4"></path>
                                    <path
                                        d="M135.602 800.025a9.648 9.648 0 0 1-9.653-9.653V232.795a9.647 9.647 0 0 1 5.958-8.917 9.66 9.66 0 0 1 10.52 2.093l44.506 44.506a9.651 9.651 0 0 1 2.828 6.825v468.565a9.651 9.651 0 0 1-2.828 6.825l-44.506 44.506a9.65 9.65 0 0 1-6.825 2.827z m9.653-543.927V767.07l25.2-25.201V281.298l-25.2-25.2zM870.3 800.025a9.65 9.65 0 0 1-6.825-2.828l-44.506-44.506a9.651 9.651 0 0 1-2.828-6.825V277.301a9.651 9.651 0 0 1 2.828-6.825l44.506-44.506a9.648 9.648 0 0 1 10.52-2.093 9.646 9.646 0 0 1 5.958 8.917v557.578a9.646 9.646 0 0 1-9.653 9.653z m-34.853-58.156l25.2 25.201V256.098l-25.2 25.2v460.571z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M825.794 286.954H180.108a9.658 9.658 0 0 1-6.825-2.828l-44.506-44.506a9.654 9.654 0 0 1-2.093-10.52 9.66 9.66 0 0 1 8.917-5.958H870.3a9.652 9.652 0 0 1 6.824 16.478l-44.506 44.506a9.654 9.654 0 0 1-6.824 2.828z m-641.689-19.306h637.692l25.2-25.2H158.905l25.2 25.2zM656.969 800.025H135.602a9.653 9.653 0 0 1-6.824-16.477l44.506-44.506a9.656 9.656 0 0 1 6.825-2.828H656.97c5.329 0 9.653 4.321 9.653 9.653v44.506c-0.001 5.332-4.325 9.652-9.654 9.652zM158.905 780.72h488.412v-25.2H184.105l-25.2 25.2zM870.3 800.025H725.306c-5.329 0-9.653-4.32-9.653-9.653v-44.506c0-5.332 4.324-9.653 9.653-9.653h100.488a9.658 9.658 0 0 1 6.825 2.828l44.506 44.506a9.653 9.653 0 0 1-6.825 16.478zM734.959 780.72h112.039l-25.2-25.2H734.96v25.2z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M825.794 755.519H725.306c-5.329 0-9.653-4.321-9.653-9.653v-49.653a9.668 9.668 0 0 1 3.206-7.186c8.836-7.921 13.901-19.255 13.901-31.092 0-22.96-18.671-41.64-41.615-41.64-22.956 0-41.634 18.68-41.634 41.64a41.694 41.694 0 0 0 13.888 31.048 9.635 9.635 0 0 1 3.224 7.198v49.685c0 5.332-4.324 9.653-9.653 9.653H180.108c-5.329 0-9.653-4.321-9.653-9.653V277.301c0-5.332 4.324-9.653 9.653-9.653h645.685c5.329 0 9.653 4.321 9.653 9.653v468.565c0.001 5.333-4.323 9.653-9.652 9.653z m-90.835-19.305h81.182v-449.26h-626.38v449.26h457.555v-35.931a61.033 61.033 0 0 1-17.113-42.347c0-33.606 27.338-60.946 60.94-60.946 33.591 0 60.921 27.34 60.921 60.946 0 15.824-6.184 31.026-17.106 42.37v35.908z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M351.943 338.053h293.614v19.306H351.943zM246.648 510.679h501.357v19.306H246.648zM246.648 554.468h501.357v19.306H246.648zM246.648 648.283h130.753v19.306H246.648zM426.583 648.283h130.754v19.306H426.583zM680.856 718.011l-1.835-0.346c-1.345-0.279-2.2-0.465-2.992-0.691l5.329-18.558c0.34 0.1 0.717 0.167 1.081 0.242l1.973 0.38-3.556 18.973zM700.873 718.102l-2.401-19.155 5.48 18.558c-0.974 0.264-2.03 0.465-3.079 0.597z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M725.306 860.859a9.634 9.634 0 0 1-4.864-1.317l-29.298-17.094-29.31 17.097a9.653 9.653 0 1 1-14.517-8.34V696.182a9.654 9.654 0 0 1 16.101-7.183 40.115 40.115 0 0 0 9.143 6.175c1.672 0.873 3.325 1.568 5.273 2.231 0.873 0.301 1.728 0.568 2.595 0.795 0.302 0.057 0.591 0.122 0.848 0.195 0.415 0.113 0.88 0.204 1.345 0.302l1.791 0.342c4.393 0.707 8.918 0.741 13.706-0.041l3.167-0.669c0.924-0.223 1.929-0.474 2.872-0.826 5.606-1.876 10.451-4.698 14.737-8.506 2.847-2.52 6.913-3.145 10.363-1.587a9.652 9.652 0 0 1 5.7 8.805v154.993a9.655 9.655 0 0 1-4.845 8.371 9.66 9.66 0 0 1-4.807 1.28z m-58.684-147.121v120.663l19.658-11.469a9.655 9.655 0 0 1 9.728 0.003l19.645 11.463V713.753a59.866 59.866 0 0 1-5.052 1.942c-1.339 0.509-3.111 0.999-4.889 1.423l-4.261 0.893c-7.283 1.194-13.473 1.166-20.362 0.041l-2.067-0.387a55.936 55.936 0 0 1-2.432-0.544 10.192 10.192 0 0 1-0.578-0.125 53.317 53.317 0 0 1-4.456-1.335 58.645 58.645 0 0 1-4.934-1.923z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M691.144 718.894c-3.236 0-6.624-0.283-10.055-0.842l-2.067-0.387a50.222 50.222 0 0 1-2.464-0.55 9.445 9.445 0 0 1-0.766-0.176 111.37 111.37 0 0 1-3.406-1.015c-0.088-0.028-0.71-0.223-0.798-0.252a59.35 59.35 0 0 1-7.655-3.23 60.702 60.702 0 0 1-12.537-8.384 8.89 8.89 0 0 1-0.855-0.678 60.996 60.996 0 0 1-20.337-45.446c0-33.606 27.338-60.946 60.94-60.946 33.591 0 60.921 27.34 60.921 60.946 0 17.313-7.402 33.882-20.311 45.464-0.346 0.308-0.71 0.591-1.088 0.842-5.97 5.102-12.694 8.949-20.016 11.437-1.672 0.553-3.281 1.043-4.94 1.439l-2.143 0.481c-0.597 0.169-1.647 0.371-2.696 0.503a60.648 60.648 0 0 1-9.727 0.794z m-10.589-20.67c0.258 0.05 0.503 0.11 0.729 0.17 0.415 0.122 0.792 0.189 1.156 0.264l1.929 0.371c4.481 0.726 8.962 0.751 13.75-0.031 0.126-0.034 1.056-0.198 1.188-0.226l1.979-0.443c1.043-0.251 2.136-0.591 3.218-0.952 5.222-1.776 10.08-4.632 14.366-8.466 0.277-0.245 0.56-0.471 0.855-0.678 8.295-7.877 13.033-18.853 13.033-30.297 0-22.96-18.671-41.64-41.615-41.64-22.956 0-41.634 18.68-41.634 41.64a41.684 41.684 0 0 0 13.172 30.391c0.257 0.189 0.509 0.396 0.754 0.613a41.585 41.585 0 0 0 9.194 6.272 40.533 40.533 0 0 0 5.204 2.194c1.044 0.319 1.892 0.583 2.722 0.818z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M246.648 392.427v94.443l78.528-46.474zM343.431 392.427h47.583v94.443h-47.583z"
                                        fill="#0e5ca4"></path>
                                    <path
                                        d="M463.544 439.907m-47.48 0a47.48 47.48 0 1 0 94.96 0 47.48 47.48 0 1 0-94.96 0Z"
                                        fill="#0e5ca4"></path>
                                    <path
                                        d="M530.689 402.347h84.523v84.523h-84.523zM642.536 486.87l26.134-84.523 29.232 25.32 30.083-25.32 19.419 84.523z"
                                        fill="#0e5ca4"></path>
                                </g>
                            </svg>
                            @php
                                $kcseLink = isset($secondaryEducation['kcseCertificate'])
                                    ? $baseUrlWithStorage . '/' . $secondaryEducation['kcseCertificate']
                                    : '#';
                            @endphp
                            <a class="text-main-color text-sm" href="{{ $kcseLink }}" target="_blank">
                                {{ isset($secondaryEducation['kcseCertificate']) && $secondaryEducation['kcseCertificate']
                                    ? 'View KCSE Certificate'
                                    : 'Certificate not available' }}
                            </a>

                        </div>
                        <div class="my-2 text-center">
                            <svg width="64px" height="30px" viewBox="0 0 1024 1024" class="icon" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M130.307 227.97h748.911v568.098H130.307z" fill="#0dcae3"></path>
                                    <path
                                        d="M879.218 806.068H130.307l-10-10V227.971l10-10h748.911l10 10v568.098l-10 9.999z m-738.911-20h728.911V237.971H140.307v548.097z"
                                        fill="#0a3848"></path>
                                    <path d="M182.067 278.597h650.094v457.616H182.067z" fill="#c1fafb"></path>
                                    <path d="M647.317 851.206l48.691-28.271 34.106 36.642-2.786-162.345-82.199-4.633z"
                                        fill="#228E9D"></path>
                                    <path
                                        d="M696.205 658.662m-51.076 0a51.076 51.076 0 1 0 102.152 0 51.076 51.076 0 1 0-102.152 0Z"
                                        fill="#0e5ca4"></path>
                                    <path
                                        d="M135.602 800.025a9.648 9.648 0 0 1-9.653-9.653V232.795a9.647 9.647 0 0 1 5.958-8.917 9.66 9.66 0 0 1 10.52 2.093l44.506 44.506a9.651 9.651 0 0 1 2.828 6.825v468.565a9.651 9.651 0 0 1-2.828 6.825l-44.506 44.506a9.65 9.65 0 0 1-6.825 2.827z m9.653-543.927V767.07l25.2-25.201V281.298l-25.2-25.2zM870.3 800.025a9.65 9.65 0 0 1-6.825-2.828l-44.506-44.506a9.651 9.651 0 0 1-2.828-6.825V277.301a9.651 9.651 0 0 1 2.828-6.825l44.506-44.506a9.648 9.648 0 0 1 10.52-2.093 9.646 9.646 0 0 1 5.958 8.917v557.578a9.646 9.646 0 0 1-9.653 9.653z m-34.853-58.156l25.2 25.201V256.098l-25.2 25.2v460.571z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M825.794 286.954H180.108a9.658 9.658 0 0 1-6.825-2.828l-44.506-44.506a9.654 9.654 0 0 1-2.093-10.52 9.66 9.66 0 0 1 8.917-5.958H870.3a9.652 9.652 0 0 1 6.824 16.478l-44.506 44.506a9.654 9.654 0 0 1-6.824 2.828z m-641.689-19.306h637.692l25.2-25.2H158.905l25.2 25.2zM656.969 800.025H135.602a9.653 9.653 0 0 1-6.824-16.477l44.506-44.506a9.656 9.656 0 0 1 6.825-2.828H656.97c5.329 0 9.653 4.321 9.653 9.653v44.506c-0.001 5.332-4.325 9.652-9.654 9.652zM158.905 780.72h488.412v-25.2H184.105l-25.2 25.2zM870.3 800.025H725.306c-5.329 0-9.653-4.32-9.653-9.653v-44.506c0-5.332 4.324-9.653 9.653-9.653h100.488a9.658 9.658 0 0 1 6.825 2.828l44.506 44.506a9.653 9.653 0 0 1-6.825 16.478zM734.959 780.72h112.039l-25.2-25.2H734.96v25.2z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M825.794 755.519H725.306c-5.329 0-9.653-4.321-9.653-9.653v-49.653a9.668 9.668 0 0 1 3.206-7.186c8.836-7.921 13.901-19.255 13.901-31.092 0-22.96-18.671-41.64-41.615-41.64-22.956 0-41.634 18.68-41.634 41.64a41.694 41.694 0 0 0 13.888 31.048 9.635 9.635 0 0 1 3.224 7.198v49.685c0 5.332-4.324 9.653-9.653 9.653H180.108c-5.329 0-9.653-4.321-9.653-9.653V277.301c0-5.332 4.324-9.653 9.653-9.653h645.685c5.329 0 9.653 4.321 9.653 9.653v468.565c0.001 5.333-4.323 9.653-9.652 9.653z m-90.835-19.305h81.182v-449.26h-626.38v449.26h457.555v-35.931a61.033 61.033 0 0 1-17.113-42.347c0-33.606 27.338-60.946 60.94-60.946 33.591 0 60.921 27.34 60.921 60.946 0 15.824-6.184 31.026-17.106 42.37v35.908z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M351.943 338.053h293.614v19.306H351.943zM246.648 510.679h501.357v19.306H246.648zM246.648 554.468h501.357v19.306H246.648zM246.648 648.283h130.753v19.306H246.648zM426.583 648.283h130.754v19.306H426.583zM680.856 718.011l-1.835-0.346c-1.345-0.279-2.2-0.465-2.992-0.691l5.329-18.558c0.34 0.1 0.717 0.167 1.081 0.242l1.973 0.38-3.556 18.973zM700.873 718.102l-2.401-19.155 5.48 18.558c-0.974 0.264-2.03 0.465-3.079 0.597z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M725.306 860.859a9.634 9.634 0 0 1-4.864-1.317l-29.298-17.094-29.31 17.097a9.653 9.653 0 1 1-14.517-8.34V696.182a9.654 9.654 0 0 1 16.101-7.183 40.115 40.115 0 0 0 9.143 6.175c1.672 0.873 3.325 1.568 5.273 2.231 0.873 0.301 1.728 0.568 2.595 0.795 0.302 0.057 0.591 0.122 0.848 0.195 0.415 0.113 0.88 0.204 1.345 0.302l1.791 0.342c4.393 0.707 8.918 0.741 13.706-0.041l3.167-0.669c0.924-0.223 1.929-0.474 2.872-0.826 5.606-1.876 10.451-4.698 14.737-8.506 2.847-2.52 6.913-3.145 10.363-1.587a9.652 9.652 0 0 1 5.7 8.805v154.993a9.655 9.655 0 0 1-4.845 8.371 9.66 9.66 0 0 1-4.807 1.28z m-58.684-147.121v120.663l19.658-11.469a9.655 9.655 0 0 1 9.728 0.003l19.645 11.463V713.753a59.866 59.866 0 0 1-5.052 1.942c-1.339 0.509-3.111 0.999-4.889 1.423l-4.261 0.893c-7.283 1.194-13.473 1.166-20.362 0.041l-2.067-0.387a55.936 55.936 0 0 1-2.432-0.544 10.192 10.192 0 0 1-0.578-0.125 53.317 53.317 0 0 1-4.456-1.335 58.645 58.645 0 0 1-4.934-1.923z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M691.144 718.894c-3.236 0-6.624-0.283-10.055-0.842l-2.067-0.387a50.222 50.222 0 0 1-2.464-0.55 9.445 9.445 0 0 1-0.766-0.176 111.37 111.37 0 0 1-3.406-1.015c-0.088-0.028-0.71-0.223-0.798-0.252a59.35 59.35 0 0 1-7.655-3.23 60.702 60.702 0 0 1-12.537-8.384 8.89 8.89 0 0 1-0.855-0.678 60.996 60.996 0 0 1-20.337-45.446c0-33.606 27.338-60.946 60.94-60.946 33.591 0 60.921 27.34 60.921 60.946 0 17.313-7.402 33.882-20.311 45.464-0.346 0.308-0.71 0.591-1.088 0.842-5.97 5.102-12.694 8.949-20.016 11.437-1.672 0.553-3.281 1.043-4.94 1.439l-2.143 0.481c-0.597 0.169-1.647 0.371-2.696 0.503a60.648 60.648 0 0 1-9.727 0.794z m-10.589-20.67c0.258 0.05 0.503 0.11 0.729 0.17 0.415 0.122 0.792 0.189 1.156 0.264l1.929 0.371c4.481 0.726 8.962 0.751 13.75-0.031 0.126-0.034 1.056-0.198 1.188-0.226l1.979-0.443c1.043-0.251 2.136-0.591 3.218-0.952 5.222-1.776 10.08-4.632 14.366-8.466 0.277-0.245 0.56-0.471 0.855-0.678 8.295-7.877 13.033-18.853 13.033-30.297 0-22.96-18.671-41.64-41.615-41.64-22.956 0-41.634 18.68-41.634 41.64a41.684 41.684 0 0 0 13.172 30.391c0.257 0.189 0.509 0.396 0.754 0.613a41.585 41.585 0 0 0 9.194 6.272 40.533 40.533 0 0 0 5.204 2.194c1.044 0.319 1.892 0.583 2.722 0.818z"
                                        fill="#0a3848"></path>
                                    <path
                                        d="M246.648 392.427v94.443l78.528-46.474zM343.431 392.427h47.583v94.443h-47.583z"
                                        fill="#0e5ca4"></path>
                                    <path
                                        d="M463.544 439.907m-47.48 0a47.48 47.48 0 1 0 94.96 0 47.48 47.48 0 1 0-94.96 0Z"
                                        fill="#0e5ca4"></path>
                                    <path
                                        d="M530.689 402.347h84.523v84.523h-84.523zM642.536 486.87l26.134-84.523 29.232 25.32 30.083-25.32 19.419 84.523z"
                                        fill="#0e5ca4"></path>
                                </g>
                            </svg>
                            @php
                                $certLink = isset($professionalQualification['professionalCertificate'])
                                    ? $baseUrlWithStorage . '/' . $professionalQualification['professionalCertificate']
                                    : '#';
                            @endphp
                            <a class="text-main-color text-sm" href="{{ $certLink }}" target="_blank">
                                {{ isset($professionalQualification['professionalCertificate']) &&
                                $professionalQualification['professionalCertificate']
                                    ? 'View Professional Certificate'
                                    : 'Certificate not available' }}
                            </a>
                        </div>

                    </div>

                </div>
                <!-- End of friends card -->
            </div>
            <!-- Right Side -->
            <div class="mx-2 h-auto w-full md:w-9/12">
                <!-- Profile tab -->
                <!-- About Section -->
                <div class="rounded-sm bg-white p-3 shadow-sm">
                    <div class="mb-3 flex items-center space-x-2 font-semibold leading-8 text-gray-900">
                        <span class="text-green-500">
                            <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <span class="tracking-wide">About</span>
                    </div>
                    <div class="text-gray-700">
                        <div class="grid gap-4 text-sm md:grid-cols-2">
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">First Name</div>
                                <div class="px-4 py-2">{{ $personalDetails['firstname'] ?? 'N/A' }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Last Name</div>
                                <div class="px-4 py-2"> {{ $personalDetails['lastname'] ?? 'N/A' }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Gender</div>
                                <div class="px-4 py-2">{{ $personalDetails['gender'] ?? 'N/A' }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Contact No.</div>
                                <div class="px-4 py-2"> {{ $personalDetails['contactNo'] ?? 'N/A' }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Current Address</div>
                                <div class="px-4 py-2">{{ $personalDetails['address'] ?? 'N/A' }}</div>
                            </div>
                            {{-- <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Permanant Address</div>
                                <div class="px-4 py-2">Arlington Heights, IL, Illinois</div>
                            </div> --}}
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Email</div>
                                <div class="break-all px-4 py-2">
                                    <a class="text-blue-800"
                                        href="{{ $userData['data']['email'] }}">{{ $userData['data']['email'] }}</a>
                                </div>
                            </div>
                            {{-- <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Birthday</div>
                                <div class="px-4 py-2">Feb 06, 1998</div>
                            </div> --}}
                        </div>
                    </div>
                    <a href="{{ route('editpersonaldetails', ['personalDetails' => $personalDetails]) }}">

                        <button
                            class="focus:shadow-outline hover:shadow-xs my-4 block w-full rounded-lg p-3 text-sm font-semibold text-blue-800 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
                            Edit Information
                        </button>
                    </a>
                </div>
                <!-- End of about section -->

                <div class="my-4"></div>

                <!-- Experience and education -->
                <div class="rounded-sm bg-white p-3 shadow-sm">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <div class="mb-3 flex items-center space-x-2 font-semibold leading-8 text-gray-900">
                                <span class="text-green-500">
                                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path fill="#fff" d="M12 14l9-5-9-5-9 5-9 5z" />
                                        <path fill="#fff"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </span>
                                <span class="tracking-wide">High School Education</span>
                            </div>
                            <ul class="list-inside space-y-2">
                                <li>
                                    <div class="text-neutral-700"><strong>School:</strong>
                                        {{ $secondaryEducation['school'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"> <strong>Year:</strong>
                                        {{ $secondaryEducation['kcseYear'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"> <strong>Grade:</strong>
                                        {{ $secondaryEducation['grade'] ?? 'Not provided' }}</div>
                                    @php
                                        $kcseLink = isset($secondaryEducation['kcseCertificate'])
                                            ? $baseUrlWithStorage . '/' . $secondaryEducation['kcseCertificate']
                                            : '#';
                                    @endphp
                                    <a class="text-main-color text-sm" href="{{ $kcseLink }}" target="_blank">
                                        {{ isset($secondaryEducation['kcseCertificate']) && $secondaryEducation['kcseCertificate']
                                            ? 'View KCSE Certificate'
                                            : 'Certificate not available' }}
                                    </a>
                                </li>

                                <a
                                    href="{{ route('edithighschooleducationdetails', ['secondaryEducation' => $secondaryEducation]) }}">

                                    <button
                                        class="focus:shadow-outline hover:shadow-xs my-4 block w-full rounded-lg p-3 text-sm font-semibold text-blue-800 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
                                        Edit Information
                                    </button>
                                </a>
                            </ul>

                        </div>
                        <div>
                            <div class="mb-3 flex items-center space-x-2 font-semibold leading-8 text-gray-900">
                                <span class="text-neutral-700">
                                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path fill="#fff" d="M12 14l9-5-9-5-9 5-9 5z" />
                                        <path fill="#fff"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </span>
                                <span class="tracking-wide">Tertiary Education</span>
                            </div>
                            <ul class="list-inside space-y-2">
                                <li>
                                    <div class="text-neutral-700"><strong>Institution:</strong>
                                        {{ $highestEducationLevel['institution'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"><strong>Course:</strong>
                                        {{ $highestEducationLevel['course'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"><strong>Graduation Year:</strong>
                                        {{ $highestEducationLevel['graduationYear'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"><strong>Grade:</strong>
                                        {{ $highestEducationLevel['grade'] ?? 'Not provided' }}</div>
                                    @php
                                        $highestCertLink = isset($highestEducationLevel['certificate'])
                                            ? $baseUrlWithStorage . '/' . $highestEducationLevel['certificate']
                                            : '#';
                                    @endphp
                                    <a class="text-main-color text-sm" href="{{ $highestCertLink }}"
                                        target="_blank">
                                        {{ isset($highestEducationLevel['certificate']) && $highestEducationLevel['certificate']
                                            ? 'View Degree Certificate'
                                            : 'Certificate not available' }}
                                    </a>
                                    <div></div>
                                </li>
                                <a
                                    href="{{ route('edithighesteducationleveldetails', ['$highestEducationLevel' => $highestEducationLevel]) }}">

                                    <button
                                        class="focus:shadow-outline hover:shadow-xs my-4 block w-full rounded-lg p-3 text-sm font-semibold text-blue-800 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
                                        Edit Information
                                    </button>
                                </a>
                            </ul>
                        </div>
                    </div>
                    <!-- End of Experience and education grid -->
                </div>
                <!-- End of profile tab -->
                <div class="my-4"></div>

                <!-- Experience and education -->
                <div class="rounded-sm bg-white p-3 shadow-sm">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <div class="mb-3 flex items-center space-x-2 font-semibold leading-8 text-gray-900">
                                <span class="text-green-500">
                                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                                <span class="tracking-wide">Professional Experience</span>
                            </div>
                            <ul class="list-inside space-y-2">
                                <li>
                                    <div class="text-neutral-700"><strong>Institution:</strong>
                                        {{ $professionalQualification['institution'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"><strong>Issuing Body:</strong>
                                        {{ $professionalQualification['body'] ?? 'Not provided' }}</div>
                                    <div class="text-neutral-700"><strong>Award:</strong>
                                        {{ $professionalQualification['award'] ?? 'Not provided' }}</div>
                                    @php
                                        $certLink = isset($professionalQualification['professionalCertificate'])
                                            ? $baseUrlWithStorage .
                                                '/' .
                                                $professionalQualification['professionalCertificate']
                                            : '#';
                                    @endphp
                                    <a class="text-main-color text-sm" href="{{ $certLink }}" target="_blank">
                                        {{ isset($professionalQualification['professionalCertificate']) &&
                                        $professionalQualification['professionalCertificate']
                                            ? 'View Professional Certificate'
                                            : 'Certificate not available' }}
                                    </a>
                                </li>
                                <a
                                    href="{{ route('editprofessionalqualificationdetails', ['$professionalQualification' => $professionalQualification]) }}">
                                    <button
                                        class="focus:shadow-outline hover:shadow-xs my-4 block w-full rounded-lg p-3 text-sm font-semibold text-blue-800 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
                                        Edit Information
                                    </button>
                                </a>
                            </ul>
                        </div>
                        {{-- <div>
                            <div class="mb-3 flex items-center space-x-2 font-semibold leading-8 text-gray-900">
                                <span class="text-neutral-700">
                                    <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path fill="#fff" d="M12 14l9-5-9-5-9 5-9 5z" />
                                        <path fill="#fff"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                </span>
                                <span class="tracking-wide">Experience</span>
                            </div>
                            <ul class="list-inside space-y-2">
                                <li>
                                    <div class="text-neutral-700">End point Not Yet Implemented</div>
                                    <div class="text-xs text-gray-500">March 2020 - Now</div>
                                </li>
                                <li>
                                    <div class="text-neutral-700">End point Not Yet Implemented</div>
                                    <div class="text-xs text-gray-500">March 2020 - Now</div>
                                </li>
                              
                            </ul>
                        </div> --}}
                    </div>
                    <!-- End of Experience and education grid -->
                </div>
                <!-- End of profile tab -->

            </div>
        </div>
    </div>
</x-layout>
