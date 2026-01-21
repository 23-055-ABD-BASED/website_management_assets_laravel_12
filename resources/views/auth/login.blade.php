<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#ffffff]">
        

        <!-- ================= MAIN CARD ================= -->
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

            <!-- ========== LEFT SIDE (IMAGE + BLOBS) ========== -->
            <div class="relative hidden lg:block overflow-hidden bg-[#171717]">

                <!-- IMAGE -->
                <div
                    class="absolute inset-0 bg-cover bg-center opacity-100"
                    style="background-image: url('{{ asset('images/regfive.jpg') }}');"
                ></div>

                {{-- <!-- BLOBS -->
                <svg
                    class="absolute inset-0 w-full h-full pointer-events-none"
                    viewBox="0 0 900 600"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <!-- KANAN ATAS -->
                    <path
                        fill="#ffffff"
                        transform="translate(960, -180) scale(1.6)"
                        d="M0 270.4C-16.8 277.5 -33.5 284.6 -41.5 261.7C-49.4 238.9 -48.4 186 -52.8 162.6C-57.3 139.2 -67.1 145.3 -73.5 144.3C-80 143.4 -83.2 135.4 -107 147.2C-130.7 159.1 -175.1 190.9 -191.2 191.2C-207.3 191.5 -195.2 160.4 -198.2 144C-201.2 127.7 -219.4 126.1 -232.6 118.5C-245.7 110.9 -253.9 97.1 -254.9 82.8C-255.8 68.5 -249.5 53.6 -250.9 39.7C-252.3 25.8 -261.3 12.9 -270.4 0L0 0Z"
                    />

                    <!-- KIRI BAWAH -->
                    <path
                        fill="#ffffff"
                        transform="translate(0, 770) scale(1.3)"
                        d="M0 -270.4C15.5 -270 30.9 -269.6 39.6 -249.9C48.2 -230.1 50.1 -191 58.4 -179.7C66.7 -168.5 81.3 -185.2 101.7 -199.6C122 -214 148.1 -226 158.9 -218.8C169.8 -211.5 165.5 -185 166.9 -166.9C168.3 -148.8 175.3 -139.1 169.9 -123.4C164.4 -107.8 146.5 -86.2 147 -74.9C147.6 -63.7 166.7 -62.8 176.9 -57.5C187.1 -52.2 188.4 -42.4 202.5 -32.1C216.6 -21.7 243.5 -10.9 270.4 0L0 0Z"
                    />
                </svg> --}}
            </div>

            <!-- ========== RIGHT SIDE (FORM) ========== -->
            <div class="flex items-center justify-center p-10">
                <div class="w-full max-w-md">

                    <h2 class="text-2xl font-bold text-[#171717]">
                        Sign In
                    </h2>
                    <p class="text-sm text-[#444444] mt-1">
                        Welcome back, please login to your account
                    </p>

                    <x-auth-session-status class="my-4" :status="session('status')" />

                    <form  id="login-form" method="POST" action="{{ route('login.post') }}" class="mt-6 space-y-5" >
                        @csrf

                        <!-- USERNAME -->
                        <div>
                            <x-input-label for="username" value="Username" class="text-[#444444]" />
                            <x-text-input
                                id="username"
                                name="username"
                                type="text"
                                :value="old('username')"
                                required
                                autofocus
                                class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800]"
                            />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <x-input-label for="password" value="Password" class="text-[#444444]" />

                            <div class="relative">
                                <x-text-input
                                    id="login_password"
                                    name="password"
                                    type="password"
                                    required
                                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800] pr-10"
                                />

                                <!-- ICON MATA -->
                                <button
                                    type="button"
                                    onclick="togglePassword('login_password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center"
                                >
                                    <img
                                        src="{{ asset('images/visible.png') }}"
                                        class="eye-open w-5 h-5"
                                    >
                                    <img
                                        src="{{ asset('images/hide.png') }}"
                                        class="eye-closed w-5 h-5 hidden"
                                    >
                                </button>

                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- REMEMBER + FORGOT -->
                        <div class="flex items-center justify-between text-sm text-[#444444]">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="remember"
                                       class="rounded border-gray-300 text-[#fd2800] focus:ring-[#fd2800]">
                                Remember me
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-[#fd2800] hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- LOGIN BUTTON -->
                        <button
                            type="submit"
                            class="w-full py-3 rounded-lg bg-[#fd2800] text-white font-semibold hover:opacity-90 transition"
                        >
                            Sign In
                        </button>

                        <!-- REGISTER CTA -->
                        <div class="text-center text-sm text-[#444444]">
                            Belum punya akun?
                           <a href="{{ route('register') }}" class="data-fade-css" data-fade>
                                Daftar sekarang
                                </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);

    if (input.type === "password") {
        input.type = "text";
        btn.classList.add("text-[#fd2800]");
    } else {
        input.type = "password";
        btn.classList.remove("text-[#fd2800]");
    }
}
</script>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeOpen = btn.querySelector('.eye-open');
    const eyeClosed = btn.querySelector('.eye-closed');

    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        input.type = "password";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
    }
}
</script>
