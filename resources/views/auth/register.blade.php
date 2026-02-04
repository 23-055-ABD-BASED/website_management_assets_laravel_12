<x-guest-layout>
<div
    class="h-screen overflow-hidden bg-cover bg-center relative"
    style="background-image: url('{{ asset('images/regone.jpg') }}');"
>


        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-white/50 lg:bg-white"></div>

        <!-- CONTENT WRAPPER -->
<div class="relative z-10 w-full h-full flex items-end lg:items-center justify-center">

            <!-- ================= MAIN CARD ================= -->
<div
 class="w-full max-w-4xl
 mx-0 lg:mx-0
 bg-white shadow-2xl overflow-hidden
 grid grid-cols-1 lg:grid-cols-2

 /* MOBILE PANEL */
 h-[75vh] mt-[25vh] rounded-t-3xl

 /* DESKTOP */
 lg:h-auto lg:mt-0 lg:rounded-2xl
mobile-slide-up
">

                <!-- ========== LEFT SIDE (IMAGE + BLOBS) ========== -->
                <div class="relative hidden lg:block overflow-hidden bg-[#171717]">

                    <!-- IMAGE -->
                    <div
                        class="absolute inset-0 bg-cover bg-center"
                        style="background-image: url('{{ asset('images/regone.jpg') }}');"
                    ></div>

                    <!-- BLOBS -->
                    <!-- <svg
                        class="absolute inset-0 w-full h-full pointer-events-none"
                        viewBox="0 0 900 600"
                        xmlns="http://www.w3.org/2000/svg"
                    > -->
                        <!-- KANAN ATAS -->
                        <!-- <path
                            fill="#ffffff"
                            transform="translate(960, -210) scale(1.6)"
                            d="M0 270.4C-16.8 277.5 -33.5 284.6 -41.5 261.7C-49.4 238.9 -48.4 186 -52.8 162.6C-57.3 139.2 -67.1 145.3 -73.5 144.3C-80 143.4 -83.2 135.4 -107 147.2C-130.7 159.1 -175.1 190.9 -191.2 191.2C-207.3 191.5 -195.2 160.4 -198.2 144C-201.2 127.7 -219.4 126.1 -232.6 118.5C-245.7 110.9 -253.9 97.1 -254.9 82.8C-255.8 68.5 -249.5 53.6 -250.9 39.7C-252.3 25.8 -261.3 12.9 -270.4 0L0 0Z"
                        /> -->

                        <!-- KIRI BAWAH -->
                        <!-- <path
                            fill="#ffffff"
                            transform="translate(0, 815) scale(1.3)"
                            d="M0 -270.4C15.5 -270 30.9 -269.6 39.6 -249.9C48.2 -230.1 50.1 -191 58.4 -179.7C66.7 -168.5 81.3 -185.2 101.7 -199.6C122 -214 148.1 -226 158.9 -218.8C169.8 -211.5 165.5 -185 166.9 -166.9C168.3 -148.8 175.3 -139.1 169.9 -123.4C164.4 -107.8 146.5 -86.2 147 -74.9C147.6 -63.7 166.7 -62.8 176.9 -57.5C187.1 -52.2 188.4 -42.4 202.5 -32.1C216.6 -21.7 243.5 -10.9 270.4 0L0 0Z"
                        />
                    </svg> -->
                </div>

                <!-- ========== RIGHT SIDE (REGISTER FORM) ========== -->
<div class="flex items-center justify-center h-full p-6 sm:p-8 lg:p-10">
                    <div class="w-full max-w-md">

                        <h2 class="text-xl sm:text-2xl font-bold text-[#171717]">
                            Create Account
                        </h2>
                        <p class="text-sm text-[#444444] mt-1">
                            Create your account to get started
                        </p>

                        <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-5" id="register-form">
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
                                    placeholder="Username"
                                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800]"
                                />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>

                            <!-- EMAIL -->
                            <div class="mt-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="@gmail.com"
                                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                >

                                @error('email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- PASSWORD -->
                            <div>
                                <x-input-label for="password" value="Password" class="text-[#444444]" />

                                <div class="relative">
                                    <x-text-input
                                        id="register_password"
                                        name="password"
                                        type="password"
                                        required
                                        placeholder="Password"
                                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800] pr-10"
                                    />
                                    <button
                                        type="button"
                                        onclick="toggleRegisterPasswords(this)"
                                        class="absolute inset-y-0 right-3 flex items-center"
                                    >
                                        <img src="{{ asset('images/visible.png') }}" class="eye-open w-5 h-5">
                                        <img src="{{ asset('images/hide.png') }}" class="eye-closed w-5 h-5 hidden">
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <div>
                                <x-input-label for="password_confirmation" value="Confirm Password" class="text-[#444444]" />

                                <div class="relative">
                                    <x-text-input
                                        id="register_password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        required
                                        placeholder="Confirm Password"
                                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800] pr-10"
                                    />

                                    <p id="password-error"
                                    class="text-red-500 text-sm mt-1 hidden">
                                        Password tidak sama
                                    </p>

                                </div>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- REGISTER BUTTON -->
                            <button
                                type="submit"
                                name="register"
                                class="w-full py-3 rounded-lg bg-[#fd2800] text-white font-semibold hover:opacity-90 transition"
                            >
                                Register
                            </button>

                            <!-- LOGIN CTA -->
                            <div class="text-center text-sm text-[#444444]">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="data-fade-css" data-fade>
                                    Login Sekarang
                                </a>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
    </div>
</x-guest-layout>

{{-- <script>
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
</script> --}}

<script>
function validateRegisterPassword() {

    const password = document.querySelector('input[name="password"]');
    const confirm  = document.querySelector('input[name="password_confirmation"]');
    const errorMsg = document.getElementById('password-error');
    const backendError = document.getElementById('backend-error');

    if (!password || !confirm) return true;

    if (password.value !== confirm.value) {
        // tampilkan error client
        errorMsg.classList.remove('hidden');

        // sembunyikan error backend
        if (backendError) {
            backendError.style.display = 'none';
        }

        return false; // ⛔ STOP SUBMIT
    }

    errorMsg.classList.add('hidden');
    return true;
}
</script>


<script>
function toggleRegisterPasswords(btn) {
    const password = document.getElementById('register_password');
    const confirm  = document.getElementById('register_password_confirmation');

    const eyeOpen = btn.querySelector('.eye-open');
    const eyeClosed = btn.querySelector('.eye-closed');

    const show = password.type === "password";

    password.type = show ? "text" : "password";
    confirm.type  = show ? "text" : "password";

    if (show) {
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
    } else {
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
    }
}
</script>

<style>
@media (max-width: 1023px) {
    .mobile-slide-up {
        animation: slideUp 0.6s ease-out forwards;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }
}
</style>