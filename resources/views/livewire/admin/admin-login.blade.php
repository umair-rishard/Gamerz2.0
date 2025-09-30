<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gamerz Admin Login</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tailwind v2.2 -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-cover bg-center flex items-center justify-center relative"
      style="background-image: url('/images/bg2.png');">

  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-70"></div>

  <!-- Home button -->
  <a href="http://127.0.0.1:8000/" title="Back to Home" aria-label="Back to Home"
     class="z-10 fixed top-4 left-4 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white bg-opacity-90 hover:bg-opacity-100 shadow-lg border border-gray-200 focus:outline-none">
      <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10"/>
      </svg>
  </a>

  <!-- Glass card -->
  <div
    class="relative w-full max-w-md rounded-2xl shadow-2xl border p-8 bg-white bg-opacity-20 border-white border-opacity-20"
    style="backdrop-filter: blur(18px) saturate(160%); -webkit-backdrop-filter: blur(18px) saturate(160%);"
  >
      <!-- Inner highlight for glass -->
      <div class="pointer-events-none absolute inset-0 rounded-2xl"
           style="box-shadow: inset 0 1px 0 rgba(255,255,255,.25);"></div>

      <!-- Logo + Title -->
      <div class="text-center mb-6 relative">
          <img src="/images/logo.png" alt="Gamerz Logo" class="mx-auto w-24 h-24 mb-4">
          <h1 class="text-3xl font-extrabold text-white">
              Gamerz Admin Login
          </h1>
          <p class="text-sm text-gray-200 mt-1">Sign in to access your dashboard</p>
      </div>

      <!-- Login Section -->
      <div id="login-section" class="relative">
          <form id="login-form" class="space-y-5">
              <!-- Email -->
              <div>
                  <label class="block text-sm font-medium text-white">Email</label>
                  <input type="email" id="email"
                         class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                         placeholder="admin@example.com" required>
              </div>

              <!-- Password -->
              <div>
                  <label class="block text-sm font-medium text-white">Password</label>
                  <div class="relative mt-1">
                      <input type="password" id="password"
                             class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                             placeholder="Enter your password" required>
                      <button type="button" onclick="togglePassword()"
                              class="absolute inset-y-0 right-3 flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                          Show
                      </button>
                  </div>
              </div>

              <!-- Login Button -->
              <button type="submit"
                      class="w-full py-3 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 shadow-lg transition transform hover:scale-105">
                  Login
              </button>
          </form>
      </div>

      <!-- 2FA Verification Section -->
      <div id="twofa-section" class="hidden relative">
          <div class="text-center mb-6">
              <h1 class="text-3xl font-bold text-white">Two-Factor Verification</h1>
              <p class="text-sm text-gray-200 mt-1">Enter your authenticator code</p>
          </div>

          <form id="twofa-form" class="space-y-5">
              <input type="hidden" id="admin_id">

              <div>
                  <label class="block text-sm font-medium text-white">Authenticator Code</label>
                  <input type="text" id="code"
                         class="w-full mt-1 px-4 py-3 rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-500 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                         placeholder="123456" required>
              </div>

              <button type="submit"
                      class="w-full py-3 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 shadow-lg transition transform hover:scale-105">
                  Verify Code
              </button>
          </form>
      </div>

      <!-- Footer -->
      <footer class="mt-6 text-gray-200 text-xs text-center relative">
          © 2025 Gamerz Admin Panel. All rights reserved.
      </footer>
  </div>

  <script>
      function togglePassword() {
          const input = document.getElementById('password');
          input.type = input.type === 'password' ? 'text' : 'password';
      }

      // Login handler
      document.getElementById('login-form').addEventListener('submit', async function(e) {
          e.preventDefault();
          const email = document.getElementById('email').value;
          const password = document.getElementById('password').value;

          try {
              const res = await axios.post('/api/admin/login', { email, password });
              if (res.data.requires_2fa) {
                  document.getElementById('login-section').classList.add('hidden');
                  document.getElementById('twofa-section').classList.remove('hidden');
                  document.getElementById('admin_id').value = res.data.admin_id;
                  Swal.fire('2FA Required', 'Enter your Google Authenticator code', 'info');
              } else {
                  localStorage.setItem('admin_token', res.data.token);
                  Swal.fire('Success', 'Login successful', 'success').then(() => {
                      window.location.href = '/admin/dashboard';
                  });
              }
          } catch (err) {
              Swal.fire('Error', err.response?.data?.message || 'Login failed', 'error');
          }
      });

      // 2FA handler
      document.getElementById('twofa-form').addEventListener('submit', async function(e) {
          e.preventDefault();
          const admin_id = document.getElementById('admin_id').value;
          const code = document.getElementById('code').value;

          try {
              const res = await axios.post('/api/admin/verify-2fa', { admin_id, code });
              localStorage.setItem('admin_token', res.data.token);
              Swal.fire('Success', '2FA verified', 'success').then(() => {
                  window.location.href = '/admin/dashboard';
              });
          } catch (err) {
              Swal.fire('Error', err.response?.data?.message || 'Verification failed', 'error');
          }
      });
  </script>

</body>
</html>
