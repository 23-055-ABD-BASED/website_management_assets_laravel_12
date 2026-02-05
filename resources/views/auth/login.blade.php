<x-guest-layout>

    <!-- ================= MOBILE BACKGROUND ================= -->
    <div
        class="lg:hidden fixed inset-0 bg-cover bg-bottom z-0"
        style="background-image: url('{{ asset('images/regp.jpg') }}');"
    ></div>

<div class="relative h-screen overflow-hidden flex items-end lg:items-center justify-center">

        <!-- ================= MAIN CARD ================= -->
        <div class="
            w-full max-w-4xl

            /* MOBILE */
            bg-transparent shadow-none rounded-none mx-0

            /* DESKTOP */
            lg:mx-0 lg:bg-white lg:rounded-2xl lg:shadow-2xl

            overflow-hidden grid grid-cols-1 lg:grid-cols-2 z-10
        ">

            <!-- ========== LEFT SIDE (IMAGE DESKTOP ONLY) ========== -->
            <div class="relative hidden lg:block overflow-hidden bg-[#171717]">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ asset('images/regp.jpg') }}');"
                ></div>
            </div>

            <!-- ========== RIGHT SIDE (FORM) ========== -->
<div class="
    relative bg-white

    /* MOBILE */
    h-[60vh]
    mt-[40vh]
    rounded-t-3xl
    px-6 py-8

    /* DESKTOP */
    lg:h-auto lg:mt-0 lg:rounded-none
    lg:p-10

    flex items-center justify-center
    mobile-slide-up
">


                <div class="w-full max-w-md">

                    <h2 class="text-2xl font-bold text-[#171717]">
                        Sign In
                    </h2>
                    <p class="text-sm text-[#444444] mt-1">
                        Welcome back, please login to your account
                    </p>

                    <x-auth-session-status class="my-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login.post') }}" class="mt-6 space-y-5">
                        @csrf

                        <!-- USERNAME / EMAIL -->
                        <div>
                            <x-input-label for="login" value="Username atau Email" />
                            <x-text-input
                                id="login"
                                name="login"
                                type="text"
                                required
                                placeholder="username atau email"
                                class="mt-1 w-full rounded-xl"
                            />
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <x-input-label for="password" value="Password" />
                            <div class="relative">
                                <x-text-input
                                    id="login_password"
                                    name="password"
                                    type="password"
                                    required
                                    placeholder="Password"
                                    class="mt-1 w-full rounded-xl pr-10"
                                />

                                <button
                                    type="button"
                                    onclick="togglePassword('login_password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center"
                                >
                                    <img src="{{ asset('images/visible.png') }}" class="eye-open w-5 h-5">
                                    <img src="{{ asset('images/hide.png') }}" class="eye-closed w-5 h-5 hidden">
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="text-[#fd2800] hover:underline">
                                Forgot password?
                            </a>
                        </div>

                        <button
                            type="submit"
                            class="w-full py-3 rounded-xl bg-[#fd2800] text-white font-semibold"
                        >
                            Sign In
                        </button>

                        <div class="text-center text-sm text-[#444444]">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-[#fd2800] font-semibold">
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