/**
 * CONSOLE TEST - Session & Authentication Check
 * 
 * Jalankan commands ini di DevTools Console (F12) untuk debug session issue
 */

// ===== TEST 1: Check CSRF Token =====
console.log("TEST 1: CSRF Token");
const csrfToken = document.querySelector('meta[name="csrf-token"]');
console.log("CSRF Token Meta:", csrfToken ? csrfToken.getAttribute('content') : "NOT FOUND");
console.log("");

// ===== TEST 2: Check Cookies =====
console.log("TEST 2: Cookies");
console.log("All Cookies:", document.cookie);
console.log("Has laravel_session:", document.cookie.includes('laravel_session') ? "YES" : "NO");
console.log("");

// ===== TEST 3: Test Fetch dengan Credentials =====
console.log("TEST 3: Fetch Credentials Test");
console.log("Testing fetch with credentials: 'include'...");

fetch('/dashboard', {
    method: 'GET',
    credentials: 'include',
    headers: {
        'Accept': 'application/json',
    }
})
.then(response => {
    console.log("Response Status:", response.status);
    console.log("Response URL:", response.url);
    if (response.status === 200) {
        console.log("Dashboard accessible - Session OK!");
    } else if (response.status === 302 || response.status === 401) {
        console.log("Redirected - Session might not be working");
    }
    return response.text();
})
.then(html => {
    console.log("Response contains 'dashboard':", html.includes('dashboard') ? "YES" : "NO");
})
.catch(err => console.error("Error:", err));

console.log("");

// ===== TEST 4: Check Auth User Info =====
console.log("TEST 4: Current User Info");
console.log("Note: This requires backend endpoint - see AJAX test");
console.log("");

// ===== TEST 5: Session Cookie Details =====
console.log("TEST 5: Cookie Details");
const cookies = document.cookie.split(';');
cookies.forEach(cookie => {
    const [name, value] = cookie.split('=');
    if (name.trim() === 'laravel_session') {
        console.log("laravel_session Cookie Found!");
        console.log("  Value:", value.substring(0, 20) + "...");
        console.log("  Session is being stored");
    }
});

if (!document.cookie.includes('laravel_session')) {
    console.log("laravel_session NOT FOUND in cookies");
    console.log("   This means session is not being saved to browser");
}

console.log("");
console.log("===== END OF TESTS =====");
console.log("");
console.log("NEXT: Try login and run these tests again to compare");
