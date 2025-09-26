// resources/js/app.js

import './bootstrap';

import axios from 'axios';

// Make axios globally available
window.axios = axios;

// Default headers
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// ✅ Attach user_token if it exists (for normal users)
const userToken = localStorage.getItem("user_token");
if (userToken) {
    window.axios.defaults.headers.common["Authorization"] = `Bearer ${userToken}`;
    console.log("✅ User token attached to axios headers");
} else {
    console.warn("⚠️ No user_token found in localStorage");
}

// ✅ Attach admin_token if it exists (for admins)
const adminToken = localStorage.getItem("admin_token");
if (adminToken) {
    window.axios.defaults.headers.common["Authorization"] = `Bearer ${adminToken}`;
    console.log("✅ Admin token attached to axios headers");
}

// ✅ Optional: Always warm up Sanctum CSRF cookie (for session-based routes)
(async () => {
    try {
        await axios.get("/sanctum/csrf-cookie");
        console.log("CSRF cookie initialized ✅");
    } catch (e) {
        console.warn("⚠️ Could not set CSRF cookie:", e);
    }
})();
