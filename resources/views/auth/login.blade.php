<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <!-- Default Email/Password Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                         required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="my-6 text-center">
            <span class="text-gray-500">OR</span>
        </div>

        <!-- Google Login Button -->
        <div class="flex justify-center">
            <button id="googleLoginBtn"
                class="flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.65 30.47 0 24 0 14.62 0 6.4 5.32 2.55 13.05l7.98 6.2C12.33 13.28 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.1 24.5c0-1.59-.15-3.13-.42-4.61H24v9.13h12.43c-.53 2.89-2.09 5.34-4.46 7.02l7.01 5.45C43.68 37.26 46.1 31.34 46.1 24.5z"/>
                    <path fill="#FBBC05" d="M10.53 28.25c-1.08-3.17-1.08-6.58 0-9.75l-7.98-6.2C-1.4 17.37-1.4 31.63 2.55 39.95l7.98-6.2z"/>
                    <path fill="#34A853" d="M24 48c6.47 0 11.9-2.13 15.87-5.77l-7.01-5.45c-2.17 1.48-4.94 2.36-8.86 2.36-6.26 0-11.67-3.78-13.47-9.25l-7.98 6.2C6.4 42.68 14.62 48 24 48z"/>
                </svg>
                Login with Google
            </button>
        </div>

    </x-authentication-card>
</x-guest-layout>

<!-- ✅ Firebase CDN Compat Versions -->
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth-compat.js"></script>

<script>
  // Your Firebase config
  const firebaseConfig = {
    apiKey: "AIzaSyBEmRyeQYwTSzYxg0CWE2GYH9b5_dC0ol0",
    authDomain: "gamerz-7c030.firebaseapp.com",
    projectId: "gamerz-7c030",
    storageBucket: "gamerz-7c030.appspot.com", // ✅ small fix here: use .appspot.com not .firebasestorage.app
    messagingSenderId: "555671661814",
    appId: "1:555671661814:web:177654b132350531e610d7"
  };

  // Initialize Firebase (compat mode)
  firebase.initializeApp(firebaseConfig);

  const auth = firebase.auth();
  const provider = new firebase.auth.GoogleAuthProvider();

  document.getElementById("googleLoginBtn").addEventListener("click", () => {
    auth.signInWithPopup(provider)
      .then(async (result) => {
        const idToken = await result.user.getIdToken();

        // Send token to backend
        const response = await fetch("/api/google-login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
          },
          body: JSON.stringify({ token: idToken })
        });

        const data = await response.json();
        console.log("Backend response:", data);

        // ✅ Handle cases
        if (data.status === "new_user") {
          alert("Welcome! Please verify OTP to set your password.");
          window.location.href = "/verify-otp?user_id=" + data.user_id + "&new=1";
        }
        else if (data.status === "otp_required") {
          alert("Please verify OTP to continue.");
          window.location.href = "/verify-otp?user_id=" + data.user_id;
        }
        else if (data.status === "success" && data.token) {
          alert("Google login successful! Redirecting to dashboard...");
          window.location.href = "/dashboard";
        }
        else {
          alert("Backend verification failed.");
        }
      })
      .catch((error) => {
        console.error(error);
        alert("Google login failed: " + error.message);
      });
  });
</script>
