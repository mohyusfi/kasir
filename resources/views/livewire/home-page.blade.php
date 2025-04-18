<div>
    <section class="flex w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
        <div class="ml-12 my-12">
            <h1 class="text-6xl -mt-5 lg:mt-12 mb-1 lg:text-8xl font-bold text-cyan-800">Welcome!</h1>
            <h2 class="ml-2 font-bold text-2xl lg:text-4xl text-teal-500">HF Karang Rejo</h2>
            <div class="mt-5 border-4 border-indigo-400 w-[300px] lg:w-[520px] bg-indigo-50 px-5"
                style="border-radius:30px; font-family:arial;">
                <h3 class="mt-8 ml-2 text-2xl">Please login to access this page</h3>
                <h4 class="mt-1 ml-2">Don't have an account? Please register to create an account</h4>
                <div class="text-sm mb-6 not-has-[nav]:hidden justify-center mt-8 flex items-center gap-4">
                    <a href="{{ route('login') }}"
                        class=" bg-cyan-700 inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18]  rounded-full text-sm leading-normal hover:bg-sky-400">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 light:text-[#EDEDEC] border-cyan-700 hover:border-sky-400 border text-[#1b1b18]  rounded-full text-sm leading-normal">
                            Register
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <div class="flex justify-center items-center">
            <x-application-logo class="block h-[300px] w-auto fill-current text-gray-800" />
        </div>
    </section>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</div>