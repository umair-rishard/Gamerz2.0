<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex flex-col justify-center items-center min-h-screen px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8">
        <div id="login-section">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Admin Login</h1>
                <p class="text-sm text-gray-500 mt-1">Sign in to access your dashboard</p>
            </div>

            <form id="login-form" class="space-y-5">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email"
                        class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400"
                        placeholder="admin@example.com" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <input type="password" id="password"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400"
                            placeholder="Enter your password" required>
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-sm text-indigo-600 hover:underline">
                            Show
                        </button>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold shadow-md transition">
                    Login
                </button>
            </form>
        </div>

        <!-- 2FA Verification Section -->
        <div id="twofa-section" class="hidden">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Two-Factor Verification</h1>
                <p class="text-sm text-gray-500 mt-1">Enter your authenticator code</p>
            </div>

            <form id="twofa-form" class="space-y-5">
                <input type="hidden" id="admin_id">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Authenticator Code</label>
                    <input type="text" id="code"
                        class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400"
                        placeholder="123456" required>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold shadow-md transition">
                    Verify Code
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-6 text-gray-500 text-xs text-center">
        © 2025 Gamerz Admin Panel. All rights reserved.
    </footer>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Handle login form
    document.getElementById('login-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const res = await axios.post('/api/admin/login', { email, password });

            if (res.data.requires_2fa) {
                // Show 2FA form
                document.getElementById('login-section').classList.add('hidden');
                document.getElementById('twofa-section').classList.remove('hidden');
                document.getElementById('admin_id').value = res.data.admin_id;
                Swal.fire('2FA Required', 'Enter your Google Authenticator code', 'info');
            } else {
                // Save token + redirect
                localStorage.setItem('admin_token', res.data.token);
                Swal.fire('Success', 'Login successful', 'success').then(() => {
                    window.location.href = '/admin/dashboard';
                });
            }
        } catch (err) {
            Swal.fire('Error', err.response?.data?.message || 'Login failed', 'error');
        }
    });

    // Handle 2FA form
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
