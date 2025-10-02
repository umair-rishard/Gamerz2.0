<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gamerz Login</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-cover bg-center flex items-stretch justify-center relative"
      style="background-image: url('/images/bg.jpg');">

  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-70"></div>

  <!-- Home button -->
  <a href="/" title="Back to Home" aria-label="Back to Home"
     class="z-20 fixed top-4 left-4 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white bg-opacity-90 hover:bg-opacity-100 shadow-lg border border-gray-200">
      <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10"/>
      </svg>
  </a>

  <!-- Centering wrapper adds top/bottom breathing room -->
  <div class="relative z-10 w-full px-4">
    <div class="mx-auto my-10 lg:my-14 w-full max-w-md">

      <!-- Glass card -->
      <div
        class="relative rounded-2xl shadow-2xl border p-8
               bg-white bg-opacity-20 border-white border-opacity-30
               max-h-[88vh] overflow-y-auto"
        style="backdrop-filter: blur(18px) saturate(160%); -webkit-backdrop-filter: blur(18px) saturate(160%);"
      >
          <!-- Inner highlight for glass -->
          <div class="pointer-events-none absolute inset-0 rounded-2xl"
               style="box-shadow: inset 0 1px 0 rgba(255,255,255,.25);"></div>

          <!-- Logo + Title -->
          <div class="text-center mb-6 relative">
              <img src="/images/logo.png" alt="Gamerz Logo" class="mx-auto w-20 h-20 mb-3">
              <h1 class="text-2xl font-extrabold text-white">Welcome Back 👋</h1>
              <p class="text-sm text-gray-200 mt-1">Login to continue to Gamerz</p>
          </div>

          <!-- Login Form -->
          <form id="apiLoginForm" class="space-y-5 relative">
              @csrf

              <!-- Email -->
              <div>
                  <label class="block text-sm font-medium text-white">Email</label>
                  <input type="email" id="email" name="email"
                         class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                         placeholder="you@example.com" required>
              </div>

              <!-- Password -->
              <div>
                  <label class="block text-sm font-medium text-white">Password</label>
                  <input type="password" id="password" name="password"
                         class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                         placeholder="••••••••" required>
              </div>

              <!-- Remember + Forgot -->
              <div class="flex items-center justify-between">
                  <label class="flex items-center text-white text-sm">
                      <input type="checkbox" id="remember_me" name="remember" class="mr-2">
                      Remember me
                  </label>
                  @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}" class="text-sm text-indigo-300 hover:text-white">
                          Forgot your password?
                      </a>
                  @endif
              </div>

              <!-- Login button -->
              <button type="submit"
                      class="w-full py-3 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 shadow-lg transition transform hover:scale-105">
                  Log In
              </button>
          </form>

          <!-- Divider -->
          <div class="my-6 flex items-center">
              <div class="flex-grow border-t border-white/40"></div>
              <span class="px-3 text-white text-sm">OR</span>
              <div class="flex-grow border-t border-white/40"></div>
          </div>

          <!-- Google Login -->
          <button type="button" id="googleLoginBtn"
                  class="w-full flex items-center justify-center py-3 rounded-xl font-semibold text-white bg-red-500 hover:bg-red-600 shadow-lg transition">
              <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                  <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.65 30.47 0 24 0 14.62 0 6.4 5.32 2.55 13.05l7.98 6.2C12.33 13.28 17.74 9.5 24 9.5z"/>
                  <path fill="#4285F4" d="M46.1 24.5c0-1.59-.15-3.13-.42-4.61H24v9.13h12.43c-.53 2.89-2.09 5.34-4.46 7.02l7.01 5.45C43.68 37.26 46.1 31.34 46.1 24.5z"/>
                  <path fill="#FBBC05" d="M10.53 28.25c-1.08-3.17-1.08-6.58 0-9.75l-7.98-6.2C-1.4 17.37-1.4 31.63 2.55 39.95l7.98-6.2z"/>
                  <path fill="#34A853" d="M24 48c6.47 0 11.9-2.13 15.87-5.77l-7.01-5.45c-2.17 1.48-4.94 2.36-8.86 2.36-6.26 0-11.67-3.78-13.47-9.25l-7.98 6.2C6.4 42.68 14.62 48 24 48z"/>
              </svg>
              Login with Google
          </button>

          <!-- Register -->
          @if (Route::has('register'))
              <div class="mt-6">
                  <a href="{{ route('register') }}"
                     class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl font-semibold text-white border border-white border-opacity-50 hover:bg-white hover:bg-opacity-20">
                      Don’t have an account? Create one
                  </a>
              </div>
          @endif

          <!-- Footer -->
          <footer class="mt-6 text-gray-200 text-xs text-center relative">
              © 2025 Gamerz. All rights reserved.
          </footer>
      </div>
    </div>
  </div>

  <!-- Firebase (needed for Google login) -->
  <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth-compat.js"></script>

  <script>
    // ✅ Replace with your real Firebase config if different
    const firebaseConfig = {
      apiKey: "AIzaSyBEmRyeQYwTSzYxg0CWE2GYH9b5_dC0ol0",
      authDomain: "gamerz-7c030.firebaseapp.com",
      projectId: "gamerz-7c030",
      storageBucket: "gamerz-7c030.appspot.com",
      messagingSenderId: "555671661814",
      appId: "1:555671661814:web:177654b132350531e610d7"
    };
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();
    const provider = new firebase.auth.GoogleAuthProvider();
    provider.setCustomParameters({ prompt: 'select_account' });

    // Email/Password Login
    document.getElementById("apiLoginForm").addEventListener("submit", async function(e) {
      e.preventDefault();
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      try {
          const response = await axios.post("/api/login", { email, password });
          localStorage.setItem("auth_token", response.data.token);
          Swal.fire('Success', 'Login successful', 'success').then(() => {
              window.location.href = "/dashboard";
          });
      } catch (error) {
          Swal.fire('Error', error.response?.data?.message || 'Login failed', 'error');
      }
    });

    // Google Login
    document.getElementById("googleLoginBtn").addEventListener("click", async () => {
      try {
        if (auth.currentUser) await auth.signOut();
        const result = await auth.signInWithPopup(provider);
        const idToken = await result.user.getIdToken();

        const response = await fetch("/api/google-login", {
          method: "POST",
          headers: { "Content-Type": "application/json", "Accept": "application/json" },
          body: JSON.stringify({ token: idToken })
        });

        const data = await response.json();
        if (data.status === "password_setup") {
          window.location.href = "/set-password/" + data.user_id;
        } else if (data.status === "success" && data.token) {
          localStorage.setItem("auth_token", data.token);
          Swal.fire('Success', 'Google login successful', 'success').then(() => {
              window.location.href = "/dashboard";
          });
        } else {
          Swal.fire('Error', data.message || 'Google login failed', 'error');
        }
      } catch (err) {
        Swal.fire('Error', err.message, 'error');
      }
    });
  </script>
</body>
</html>
