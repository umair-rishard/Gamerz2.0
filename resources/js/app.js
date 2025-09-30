// resources/js/app.js

import './bootstrap';
import axios from 'axios';

// Make axios globally available
window.axios = axios;

// Default headers
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// ----- Auth header (pick ONE token) -----
// Prefer admin token if present, otherwise use user auth_token
const adminToken = localStorage.getItem('admin_token');
const userToken  = localStorage.getItem('auth_token');
const activeToken = adminToken || userToken;

if (activeToken) {
  window.axios.defaults.headers.common['Authorization'] = `Bearer ${activeToken}`;
  console.log(`✅ ${adminToken ? 'Admin' : 'User'} token attached to axios headers`);
} else {
  console.warn('⚠️ No auth_token found in localStorage');
}

// ----- Warm up Sanctum CSRF cookie (optional for session routes) -----
(async () => {
  try {
    await axios.get('/sanctum/csrf-cookie');
    console.log('CSRF cookie initialized ✅');
  } catch (e) {
    console.warn('⚠️ Could not set CSRF cookie:', e);
  }
})();

// ----- Global 401 handler: prompt login on unauthorized -----
window.axios.interceptors.response.use(
  (response) => response,
  (error) => {
    const status = error?.response?.status;

    if (status === 401) {
      // Show a friendly prompt and redirect to login
      if (window.Swal) {
        Swal.fire({
          icon: 'info',
          title: 'Please log in',
          text: 'You need to be logged in to continue.',
        }).then(() => (window.location.href = '/login'));
      } else {
        alert('Please log in to continue.');
        window.location.href = '/login';
      }
    }

    return Promise.reject(error);
  }
);
