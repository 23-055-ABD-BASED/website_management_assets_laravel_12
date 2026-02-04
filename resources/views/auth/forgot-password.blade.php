<x-guest-layout>

    <!-- ========== MOBILE BACKGROUND ========== -->
    <div
        class="lg:hidden fixed inset-0 bg-cover bg-center z-0"
        style="background-image: url('{{ asset('images/regsix.jpg') }}');"
    >
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- ========== WRAPPER (DESKTOP TETAP CENTER) ========== -->
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">

        <!-- ================= MAIN CARD ================= -->
        <div
            class="
                relative z-10 w-full max-w-4xl

                /* MOBILE */
                bg-white
                h-[45vh]
                mt-[55vh]
                rounded-t-3xl

                /* DESKTOP (ASLI, JANGAN DIUBAH) */
                lg:h-auto
                lg:mt-0
                lg:rounded-2xl
                lg:shadow-2xl
                lg:bg-white

                overflow-hidden
                grid grid-cols-1 lg:grid-cols-2
                mobile-slide-up
            "
        >

            <!-- ========== LEFT IMAGE (DESKTOP ONLY) ========== -->
            <div class="relative hidden lg:block overflow-hidden bg-[#171717]">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ asset('images/regsix.jpg') }}');"
                ></div>
            </div>

            <!-- ========== RIGHT SIDE (FORM) ========== -->
            <div
                class="
                    flex items-center justify-center
                    h-full
                    px-6 py-8
                    lg:p-10
                "
            >
                <div class="w-full max-w-md">

                    <h2 class="text-xl sm:text-2xl font-bold text-[#171717]">
                        Forgot Password
                    </h2>

                    <p class="text-sm text-[#444444] mt-1">
                        Masukkan email akun kamu, kami akan mengirimkan link reset password.
                    </p>

                    <x-auth-session-status class="my-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autofocus
                                placeholder="@gmail.com"
                                class="mt-1 w-full rounded-xl"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <button
                            type="submit"
                            class="w-full py-3 rounded-xl bg-[#fd2800] text-white font-semibold"
                        >
                            Kirim Link Reset Password
                        </button>

                        <div class="text-center text-sm text-[#444444]">
                            Ingat password?
                            <a href="{{ route('login') }}" class="text-[#fd2800] font-semibold">
                                Kembali ke Login
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
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
