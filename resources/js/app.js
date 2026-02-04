import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

Livewire.start();
document.addEventListener("DOMContentLoaded", () => {

    /* ======================================
       GLOBAL FADE INIT
    ====================================== */
    document.body.classList.add("page-fade");
    requestAnimationFrame(() => {
        document.body.classList.add("show");
    });

    /* ======================================
       FADE UNTUK LINK (LOGIN ↔ REGISTER)
       hanya link dengan data-fade
    ====================================== */
    document.querySelectorAll("a[data-fade]").forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            document.body.classList.remove("show");

            setTimeout(() => {
                window.location.href = link.href;
            }, 350);
        });
    });

    /* ======================================
       LOGOUT (POST + FADE)
    ====================================== */
    const logoutBtn = document.getElementById("logout-btn");
    const logoutForm = document.getElementById("logout-form");

    if (logoutBtn && logoutForm) {
        logoutBtn.addEventListener("click", () => {
            document.body.classList.remove("show");
            setTimeout(() => logoutForm.submit(), 350);
        });
    }

    /* ======================================
       LOGIN AJAX
    ====================================== */
    const loginForm = document.getElementById("login-form");

    if (loginForm) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(loginForm);
            const token = loginForm.querySelector('input[name="_token"]').value;

            try {
                console.log('Submitting login form to:', loginForm.action);
                const response = await fetch(loginForm.action, {
                    method: "POST",
                    credentials: "include", // UBAH dari same-origin ke include
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: formData,
                });

                console.log('Response status:', response.status);
                const data = await response.json();
                console.log('Response data:', data);

                if (response.status === 422) {
                    Swal.fire({
                        icon: "error",
                        title: "Login Gagal",
                        text: data.errors?.username?.[0] ?? "Login gagal",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    return;
                }

                if (!response.ok) {
                    throw new Error("Server error");
                }

                Swal.fire({
                    icon: "success",
                    title: "Login Berhasil",
                    timer: 1000,
                    showConfirmButton: false,
                }).then(() => {
                    console.log('Redirecting to:', data.redirect);
                    document.body.classList.remove("show");
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 300);
                });

            } catch (err) {
                console.error('Login error:', err);
                Swal.fire("Error", "Terjadi kesalahan server", "error");
            }
        });
    }

    /* ======================================
       REGISTER AJAX
    ====================================== */
    const registerForm = document.getElementById("register-form");

    if (registerForm) {
    registerForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const password = registerForm.querySelector('input[name="password"]');
        const confirm  = registerForm.querySelector('input[name="password_confirmation"]');
        const errorMsg = document.getElementById('password-error');

        // VALIDASI PASSWORD DULU
        if (password.value !== confirm.value) {
            errorMsg.classList.remove('hidden');
            return; // ⛔ STOP DI SINI (tidak kirim ke backend)
        }

        // ✅ PASSWORD SAMA → LANJUT
        errorMsg.classList.add('hidden');

        const formData = new FormData(registerForm);
        const token = registerForm.querySelector('input[name="_token"]').value;

        try {
            const response = await fetch(registerForm.action, {
                method: "POST",
                credentials: "include",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token,
                },
                body: formData,
            });

            const data = await response.json();

            // ❌ ERROR BACKEND (username sudah ada dll)
            if (response.status === 422) {
                Swal.fire({
                    icon: "error",
                    title: "Registrasi Gagal",
                    text: data.errors?.username?.[0] ?? "Registrasi gagal",
                    timer: 1500,
                    showConfirmButton: false,
                });
                return;
            }

            if (!response.ok) {
                throw new Error("Server error");
            }

            // ✅ BERHASIL
            Swal.fire({
                icon: "success",
                title: "Registrasi Berhasil",
                text: "Akun berhasil dibuat",
                timer: 1000,
                showConfirmButton: false,
            }).then(() => {
                document.body.classList.remove("show");
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 300);
            });

        } catch (err) {
            Swal.fire("Error", "Terjadi kesalahan server", "error");
        }
    });
}

});
