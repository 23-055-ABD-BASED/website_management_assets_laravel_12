<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white relative">

        <!-- ========== BACKGROUND IMAGE (MOBILE) ========== -->
        <div class="absolute inset-0 lg:hidden bg-cover bg-center"
            style="background-image: url('{{ asset('images/regsol.jpg') }}');">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- ================= MAIN CARD ================= -->
        <div
            class="relative z-10 w-full max-w-4xl mx-4 lg:mx-0 rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 bg-white/90 backdrop-blur-lg lg:bg-white">

            <!-- ========== LEFT SIDE (IMAGE DESKTOP) ========== -->
            <div class="relative hidden lg:block overflow-hidden bg-[#171717]">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ asset('images/regsol.jpg') }}');"
                ></div>
            </div>

            <!-- ========== RIGHT SIDE (FORM) ========== -->
            <div class="flex items-center justify-center p-6 sm:p-8 lg:p-10">
                <div class="w-full max-w-md">

                    <h2 class="text-xl sm:text-2xl font-bold text-[#171717]">
                        Forgot Password
                    </h2>

                    <p class="text-sm text-[#444444] mt-1">
                        Masukkan email akun kamu, kami akan mengirimkan link reset password.
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="my-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
                        @csrf

                        <!-- EMAIL -->
                        <div>
                            <x-input-label for="email" value="Email" class="text-[#444444]" />
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                :value="old('email')"
                                required
                                autofocus
                                placeholder="@gmail.com"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800]"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- SUBMIT -->
                        <button
                            type="submit"
                            class="w-full py-3 rounded-lg bg-[#fd2800] text-white font-semibold hover:opacity-90 transition">
                            Kirim Link Reset Password
                        </button>

                        <!-- BACK TO LOGIN -->
                        <div class="text-center text-sm text-[#444444]">
                            Ingat password?
                            <a href="{{ route('login') }}" class="text-[#fd2800] hover:underline">
                                Kembali ke Login
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
