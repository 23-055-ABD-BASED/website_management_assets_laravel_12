<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white relative">

        <!-- ========== BACKGROUND IMAGE (MOBILE) ========== -->
        <div class="absolute inset-0 lg:hidden bg-cover bg-center"
            style="background-image: url('{{ asset('images/regjjk.jpg') }}');">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- ================= MAIN CARD ================= -->
        <div
            class="relative z-10 w-full max-w-4xl mx-4 lg:mx-0 rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2 bg-white/90 backdrop-blur-lg lg:bg-white">

            <!-- ========== LEFT SIDE (IMAGE DESKTOP) ========== -->
            <div class="relative hidden lg:block overflow-hidden bg-[#171717]">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ asset('images/regjjk.jpg') }}');"
                ></div>
            </div>

            <!-- ========== RIGHT SIDE (FORM) ========== -->
            <div class="flex items-center justify-center p-6 sm:p-8 lg:p-10">
                <div class="w-full max-w-md">

                    <h2 class="text-xl sm:text-2xl font-bold text-[#171717]">
                        Reset Password
                    </h2>

                    <p class="text-sm text-[#444444] mt-1">
                        Silakan masukkan password baru untuk akun kamu.
                    </p>

                    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
                        @csrf

                        <!-- TOKEN -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- EMAIL -->
                        <div>
                            <x-input-label for="email" value="Email" class="text-[#444444]" />
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                :value="old('email', $request->email)"
                                required
                                autofocus
                                placeholder="@gmail.com"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800]"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <x-input-label for="password" value="New Password" class="text-[#444444]" />

                            <div class="relative">
                                <x-text-input
                                    id="reset_password"
                                    name="password"
                                    type="password"
                                    required
                                    placeholder="New Password"
                                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800] pr-10"
                                />

                                <!-- ICON MATA -->
                                <button
                                    type="button"
                                    onclick="toggleResetPassword(this)"
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
                                    id="reset_password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    required
                                    placeholder="Confirm Password"
                                    class="mt-1 w-full rounded-lg border-gray-300 focus:border-[#fd2800] focus:ring-[#fd2800] pr-10"
                                />
                            </div>

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- SUBMIT -->
                        <button
                            type="submit"
                            class="w-full py-3 rounded-lg bg-[#fd2800] text-white font-semibold hover:opacity-90 transition"
                        >
                            Reset Password
                        </button>

                        <!-- BACK TO LOGIN -->
                        <div class="text-center text-sm text-[#444444]">
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

<!-- TOGGLE PASSWORD -->
<script>
function toggleResetPassword(btn) {
    const password = document.getElementById('reset_password');
    const confirm = document.getElementById('reset_password_confirmation');

    const eyeOpen = btn.querySelector('.eye-open');
    const eyeClosed = btn.querySelector('.eye-closed');

    const isHidden = password.type === "password";

    password.type = isHidden ? "text" : "password";
    confirm.type = isHidden ? "text" : "password";

    eyeOpen.classList.toggle("hidden", isHidden);
    eyeClosed.classList.toggle("hidden", !isHidden);
}
</script>
