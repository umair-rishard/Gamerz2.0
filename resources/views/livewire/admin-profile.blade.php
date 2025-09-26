<!-- SINGLE ROOT WRAPPER REQUIRED BY LIVEWIRE -->
<div id="admin-profile-root" class="min-h-screen bg-white">
  <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    <!-- Toasts -->
    <div id="toastRoot" class="fixed top-4 right-4 z-50 space-y-3"></div>

    <!-- Top bar -->
    <div class="mb-8 flex items-center justify-between">
      <a href="{{ route('admin.dashboard') }}"
         class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-900 text-white hover:bg-slate-800 shadow-sm transition-transform duration-200 hover:scale-[1.02]">
        <span aria-hidden="true">←</span> Back to Dashboard
      </a>
      <span class="text-sm text-slate-500">Admin • Profile &amp; Security</span>
    </div>

    <!-- Title -->
    <div class="mb-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Admin Profile</h1>
      <p class="text-slate-500 mt-1">Manage your account, password, and security settings.</p>
    </div>

    <!-- Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Profile card -->
      <div class="relative overflow-hidden bg-sky-50/80 backdrop-blur-md shadow-xl ring-1 ring-sky-200 rounded-2xl p-6 transition-all duration-300">
        <div class="absolute -top-12 -left-12 h-28 w-28 rounded-full bg-sky-200/60 blur-2xl"></div>
        <h2 class="text-lg font-semibold text-slate-900 mb-5">Profile</h2>

        <form id="profileForm" class="space-y-5">
          <div>
            <label class="block text-sm font-medium text-slate-700">Username</label>
            <input id="name" type="text"
                   class="mt-1 w-full border border-sky-100 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                   placeholder="Your name"/>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700">Email Address</label>
            <input id="email" type="email"
                   class="mt-1 w-full border border-sky-100 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                   placeholder="you@example.com"/>
          </div>

          <div class="pt-1">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white hover:bg-sky-700 shadow-sm transition disabled:opacity-60"
                    data-loading-text="Saving...">
              <svg class="w-4 h-4 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v2m0 10v2m7-7h-2M7 12H5m10.95 6.364-1.414-1.414M8.464 8.464 7.05 7.05m9.9 0-1.414 1.414M8.464 15.536 7.05 16.95"/></svg>
              Save changes
            </button>
          </div>
        </form>
      </div>

      <!-- Security status + UI toggles -->
      <div class="relative overflow-hidden bg-sky-50/80 backdrop-blur-md shadow-xl ring-1 ring-sky-200 rounded-2xl p-6">
        <div class="absolute -bottom-12 -right-12 h-28 w-28 rounded-full bg-sky-200/60 blur-2xl"></div>
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-slate-900">Security</h2>
          <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-sky-100 text-sky-700">Status</span>
        </div>
        <p id="security" class="text-slate-700 mt-3">Checking...</p>

        <!-- Client-side UI switches (no API impact) -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Compact Layout switch -->
          <div class="flex items-center justify-between">
            <div class="text-sm">
              <div class="font-medium text-slate-800">Compact Layout</div>
              <div class="text-slate-500">Denser spacing</div>
            </div>
            <button type="button" id="toggleCompact"
              class="relative h-7 w-12 rounded-full bg-slate-300 transition flex items-center">
              <span class="absolute left-1 h-6 w-6 rounded-full bg-white shadow translate-x-0 transition-transform"></span>
            </button>
          </div>

          <!-- Toasts switch -->
          <div class="flex items-center justify-between">
            <div class="text-sm">
              <div class="font-medium text-slate-800">Enable Toasts</div>
              <div class="text-slate-500">Fancy notifications</div>
            </div>
            <button type="button" id="toggleToasts"
              class="relative h-7 w-12 rounded-full bg-sky-600 transition flex items-center">
              <span class="absolute left-1 h-6 w-6 rounded-full bg-white shadow translate-x-5 transition-transform"></span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <!-- Change Password -->
      <div class="relative overflow-hidden bg-sky-50/80 backdrop-blur-md shadow-xl ring-1 ring-sky-200 rounded-2xl p-6">
        <div class="absolute -top-12 -left-12 h-28 w-28 rounded-full bg-sky-200/60 blur-2xl"></div>
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Change Password</h2>

        <form id="passwordForm" class="space-y-5">
          <div class="relative">
            <label class="block text-sm font-medium text-slate-700">Current password</label>
            <input id="current_password" type="password"
                   class="mt-1 w-full border border-sky-100 rounded-xl px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                   placeholder="••••••••"/>
            <button type="button" data-toggle="current_password"
                    class="absolute right-2 top-9 text-slate-500 hover:text-slate-700 transition"
                    aria-label="Toggle current password">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>

          <div class="relative">
            <label class="block text-sm font-medium text-slate-700">New password</label>
            <input id="password" type="password"
                   class="mt-1 w-full border border-sky-100 rounded-xl px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                   placeholder="••••••••"/>
            <button type="button" data-toggle="password"
                    class="absolute right-2 top-9 text-slate-500 hover:text-slate-700 transition"
                    aria-label="Toggle new password">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>

          <div class="relative">
            <label class="block text-sm font-medium text-slate-700">Confirm new password</label>
            <input id="password_confirmation" type="password"
                   class="mt-1 w-full border border-sky-100 rounded-xl px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                   placeholder="••••••••"/>
            <button type="button" data-toggle="password_confirmation"
                    class="absolute right-2 top-9 text-slate-500 hover:text-slate-700 transition"
                    aria-label="Toggle confirm password">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>

          <div class="pt-1">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white hover:bg-sky-700 shadow-sm transition disabled:opacity-60"
                    data-loading-text="Updating...">
              <svg class="w-4 h-4 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v4m0 8v4m8-8h-4M8 12H4"/></svg>
              Update password
            </button>
          </div>
        </form>
      </div>

      <!-- Read-only UI prefs -->
      <div class="relative overflow-hidden bg-sky-50/80 backdrop-blur-md shadow-xl ring-1 ring-sky-200 rounded-2xl p-6">
        <div class="absolute -bottom-12 -right-12 h-28 w-28 rounded-full bg-sky-200/60 blur-2xl"></div>
        <h2 class="text-lg font-semibold text-slate-900 mb-2">Preferences / Settings</h2>
        <p class="text-sm text-slate-600">These are UI helpers only (no API changes).</p>

        <div class="mt-5 space-y-4">
          <label class="flex items-center justify-between">
            <span class="text-sm">
              <span class="font-medium text-slate-800">Show borders</span>
              <span class="block text-slate-500">Subtle card rings</span>
            </span>
            <input id="chkRings" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500" checked>
          </label>

          <label class="flex items-center justify-between">
            <span class="text-sm">
              <span class="font-medium text-slate-800">Rounded corners</span>
              <span class="block text-slate-500">Extra smooth radius</span>
            </span>
            <input id="chkRadius" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500" checked>
          </label>

          <label class="flex items-center justify-between">
            <span class="text-sm">
              <span class="font-medium text-slate-800">Animated hovers</span>
              <span class="block text-slate-500">Micro-interactions</span>
            </span>
            <input id="chkHovers" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500" checked>
          </label>
        </div>
      </div>
    </div>

    <!-- Danger Zone -->
    <div class="relative overflow-hidden bg-rose-50/90 backdrop-blur-md shadow-xl ring-1 ring-rose-200 rounded-2xl p-6 mt-6">
      <div class="absolute -top-10 -right-10 h-28 w-28 rounded-full bg-rose-200/60 blur-2xl"></div>
      <h2 class="text-lg font-semibold text-red-700 mb-2">Danger Zone</h2>
      <p class="text-slate-600 mb-4">Deleting your admin account is permanent.</p>
      <form id="deleteForm" class="space-y-5">
        <div class="relative">
          <label class="block text-sm font-medium text-slate-700">Confirm with password</label>
          <input id="confirm_password_for_delete" type="password"
                 class="mt-1 w-full border border-rose-100 rounded-xl px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:border-transparent transition"
                 placeholder="••••••••"/>
          <button type="button" data-toggle="confirm_password_for_delete"
                  class="absolute right-2 top-9 text-slate-500 hover:text-slate-700 transition"
                  aria-label="Toggle delete confirm password">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700 shadow-sm transition disabled:opacity-60"
                data-loading-text="Deleting...">
          <svg class="w-4 h-4 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6M6 7h12m-9-3h6a2 2 0 0 1 2 2v1H5V6a2 2 0 0 1 2-2Z"/></svg>
          Delete account
        </button>
      </form>
    </div>

    <!-- 2FA (below danger zone) -->
    <div class="relative overflow-hidden bg-sky-50/80 backdrop-blur-md shadow-xl ring-1 ring-sky-200 rounded-2xl p-6 mt-6">
      <div class="absolute -bottom-10 -right-10 h-28 w-28 rounded-full bg-sky-200/60 blur-2xl"></div>

      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Two-Factor Authentication (2FA)</h2>
        <span id="twofaStatusBadge" class="text-sm px-3 py-1 rounded-full bg-slate-100 text-slate-700">—</span>
      </div>

      <!-- 2FA disabled -->
      <div id="twofaDisabled" class="mt-4 hidden">
        <p class="text-slate-700">2FA adds an extra layer of security to your admin account.</p>
        <button id="btnStartEnable2fa"
                class="mt-3 px-4 py-2 rounded-xl bg-sky-600 text-white hover:bg-sky-700 shadow-sm transition">
          Enable 2FA
        </button>

        <div id="twofaSetupBox" class="mt-5 hidden border border-sky-100 rounded-2xl p-4">
          <p class="text-slate-700 mb-3">Scan this QR with Google Authenticator (or Authy), then enter the 6-digit code.</p>
          <div id="twofaQr" class="bg-white p-3 rounded-xl border border-sky-100 inline-block shadow-sm"></div>
          <div class="mt-3">
            <label class="block text-sm font-medium text-slate-700">Authenticator code</label>
            <input id="twofaCode" type="text"
                   class="mt-1 w-full border border-sky-100 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-transparent transition"
                   placeholder="123456"/>
          </div>
          <div class="mt-4 flex items-center gap-3">
            <button id="btnConfirm2fa"
                    class="px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm transition">
              Confirm &amp; Activate
            </button>
            <button id="btnCancel2fa"
                    class="px-4 py-2 rounded-xl bg-slate-100 text-slate-800 hover:bg-slate-200 transition">
              Cancel
            </button>
          </div>
        </div>
      </div>

      <!-- 2FA enabled -->
      <div id="twofaEnabled" class="mt-4 hidden">
        <p class="text-slate-700">2FA is currently enabled for this account.</p>

        <div class="mt-4 flex flex-wrap items-center gap-3">
          <button id="btnShowRecovery"
                  class="px-4 py-2 rounded-xl bg-slate-800 text-white hover:bg-slate-900 shadow-sm transition">
            Show recovery codes
          </button>
          <button id="btnRegenerateRecovery"
                  class="px-4 py-2 rounded-xl bg-sky-600 text-white hover:bg-sky-700 shadow-sm transition">
            Regenerate recovery codes
          </button>
          <button id="btnDisable2fa"
                  class="px-4 py-2 rounded-xl bg-rose-600 text-white hover:bg-rose-700 shadow-sm transition">
            Disable 2FA
          </button>
        </div>

        <div id="recoveryBox" class="mt-4 hidden border border-sky-100 rounded-2xl p-4">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold text-slate-900">Recovery codes</h3>
            <button type="button" id="btnCopyRecovery"
                    class="inline-flex items-center gap-2 text-sm px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 9V5a2 2 0 0 1 2-2h6l4 4v10a2 2 0 0 1-2 2h-5M9 9H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-2"/></svg>
              Copy
            </button>
          </div>
          <p class="text-sm text-slate-600 mb-3">
            Store these codes securely. Each code can be used once if you lose access to your authenticator app.
          </p>
          <pre id="recoveryCodes" class="bg-slate-50 p-3 rounded-xl text-sm leading-6 ring-1 ring-slate-200 overflow-x-auto"></pre>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem("admin_token");
    const $ = (id) => document.getElementById(id);

    const securityEl = $("security");
    const twofaStatusBadge = $("twofaStatusBadge");
    const twofaEnabledBox = $("twofaEnabled");
    const twofaDisabledBox = $("twofaDisabled");
    const twofaSetupBox = $("twofaSetupBox");
    const twofaQr = $("twofaQr");
    const twofaCode = $("twofaCode");
    const recoveryBox = $("recoveryBox");
    const recoveryCodes = $("recoveryCodes");

    /* Toasts */
    let toastsEnabled = true;
    function showToast(type, message) {
        if (!toastsEnabled) { console.log(type, message); return; }
        const root = document.getElementById("toastRoot");
        if (!root) return alert(message);
        const color = type === "success" ? "bg-emerald-600" :
                      type === "error"   ? "bg-rose-600" :
                      type === "warn"    ? "bg-amber-500" : "bg-slate-700";
        const el = document.createElement("div");
        el.className = `${color} text-white rounded-xl shadow-lg px-4 py-3 flex items-start gap-3 transform transition-all duration-300 translate-y-[-8px] opacity-0`;
        el.innerHTML = `
          <div class="pt-0.5">
            ${type === "success" ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>' :
               type === "error" ?   '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>' :
               type === "warn" ?    '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>' :
                                   '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6v6l4 2"/></svg>'}
          </div>
          <div class="text-sm leading-5 pr-2">${message}</div>
          <button aria-label="Close" class="ml-auto opacity-80 hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        `;
        root.appendChild(el);
        requestAnimationFrame(() => {
          el.classList.remove("translate-y-[-8px]","opacity-0");
          el.classList.add("translate-y-0","opacity-100");
        });
        const remove = () => { el.classList.add("translate-y-[-8px]","opacity-0"); setTimeout(() => el.remove(), 240); };
        el.querySelector("button")?.addEventListener("click", remove);
        setTimeout(remove, 3600);
    }

    /* Loading states */
    function setLoading(btn, isLoading) {
        if (!btn) return;
        const original = btn.getAttribute("data-original-text");
        const loadingText = btn.getAttribute("data-loading-text") || "Please wait...";
        if (isLoading) {
            if (!original) btn.setAttribute("data-original-text", btn.innerHTML);
            btn.innerHTML = `
              <span class="inline-flex items-center gap-2">
                <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                ${loadingText}
              </span>`;
            btn.disabled = true;
        } else {
            if (original) btn.innerHTML = original;
            btn.disabled = false;
        }
    }

    /* Password visibility toggles */
    document.querySelectorAll("[data-toggle]").forEach(btn => {
      btn.addEventListener("click", () => {
        const id = btn.getAttribute("data-toggle");
        const input = document.getElementById(id);
        if (!input) return;
        input.type = input.type === "password" ? "text" : "password";
      });
    });

    /* UI toggles (no CSS @apply) */
    const toggleCompact = document.getElementById("toggleCompact");
    const toggleToasts  = document.getElementById("toggleToasts");
    const chkRings   = document.getElementById("chkRings");
    const chkRadius  = document.getElementById("chkRadius");
    const chkHovers  = document.getElementById("chkHovers");
    const cardSelector = ".bg-sky-50\\/80, .bg-rose-50\\/90";

    function setClassOnCards(add, cls) {
      document.querySelectorAll(cardSelector).forEach(c => c.classList[add ? "add" : "remove"](cls));
    }

    // Compact layout
    toggleCompact?.addEventListener("click", () => {
      const knob = toggleCompact.querySelector("span");
      const isOn = toggleCompact.classList.contains("bg-sky-600");
      if (isOn) {
        toggleCompact.classList.remove("bg-sky-600"); toggleCompact.classList.add("bg-slate-300");
        knob.classList.remove("translate-x-5"); knob.classList.add("translate-x-0");
        document.documentElement.classList.remove("text-[15px]");
        setClassOnCards(false, "p-5");
      } else {
        toggleCompact.classList.remove("bg-slate-300"); toggleCompact.classList.add("bg-sky-600");
        knob.classList.remove("translate-x-0"); knob.classList.add("translate-x-5");
        document.documentElement.classList.add("text-[15px]");
        setClassOnCards(true, "p-5");
      }
    });

    // Toasts
    toggleToasts?.addEventListener("click", () => {
      const knob = toggleToasts.querySelector("span");
      const isOn = toggleToasts.classList.contains("bg-sky-600");
      if (isOn) {
        toggleToasts.classList.remove("bg-sky-600"); toggleToasts.classList.add("bg-slate-300");
        knob.classList.remove("translate-x-5"); knob.classList.add("translate-x-0");
        toastsEnabled = false;
      } else {
        toggleToasts.classList.remove("bg-slate-300"); toggleToasts.classList.add("bg-sky-600");
        knob.classList.remove("translate-x-0"); knob.classList.add("translate-x-5");
        toastsEnabled = true; showToast("success", "Toasts enabled");
      }
    });

    // Rings / Radius / Hovers
    chkRings?.addEventListener("change", () => setClassOnCards(chkRings.checked, "ring-1"));
    chkRadius?.addEventListener("change", () => setClassOnCards(chkRadius.checked, "rounded-2xl"));
    chkHovers?.addEventListener("change", () => setClassOnCards(chkHovers.checked, "hover:shadow-2xl"));

    /* Auth guard + axios */
    if (!token) { securityEl.innerText = "Not logged in (no admin token)."; return; }
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

    /* Load profile & 2FA */
    function refreshProfile() {
        return axios.get("/api/admin/profile")
            .then(res => {
                const p = res.data;
                $("name").value  = p.name || "";
                $("email").value = p.email || "";
                securityEl.innerText = "Logged in ✅";

                const enabled = !!p.two_factor_confirmed_at;
                if (enabled) {
                    twofaStatusBadge.textContent = "Enabled";
                    twofaStatusBadge.className = "text-sm px-3 py-1 rounded-full bg-emerald-100 text-emerald-700";
                    twofaEnabledBox.classList.remove("hidden");
                    twofaDisabledBox.classList.add("hidden");
                } else {
                    twofaStatusBadge.textContent = "Disabled";
                    twofaStatusBadge.className = "text-sm px-3 py-1 rounded-full bg-rose-100 text-rose-700";
                    twofaEnabledBox.classList.add("hidden");
                    twofaDisabledBox.classList.remove("hidden");
                }

                twofaSetupBox.classList.add("hidden");
                recoveryBox.classList.add("hidden");
                twofaQr.innerHTML = "";
                twofaCode.value = "";
            })
            .catch(() => {
                securityEl.innerText = "Token invalid ❌";
                showToast("error", "Session expired or token invalid.");
            });
    }
    refreshProfile();

    /* Profile update */
    $("profileForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const btn = e.target.querySelector("button[type='submit']");
        setLoading(btn, true);
        axios.put("/api/admin/profile", {
            name: $("name").value,
            email: $("email").value
        })
        .then(() => showToast("success", "Profile updated"))
        .catch(err => showToast("error", err.response?.data?.message || "Update failed"))
        .finally(() => setLoading(btn, false));
    });

    /* Password update */
    $("passwordForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const btn = e.target.querySelector("button[type='submit']");
        setLoading(btn, true);
        axios.post("/api/admin/change-password", {
            current_password: $("current_password").value,
            password: $("password").value,
            password_confirmation: $("password_confirmation").value
        })
        .then(() => {
            $("current_password").value = "";
            $("password").value = "";
            $("password_confirmation").value = "";
            showToast("success", "Password changed");
        })
        .catch(err => showToast("error", err.response?.data?.message || "Password update failed"))
        .finally(() => setLoading(btn, false));
    });

    /* Delete account */
    $("deleteForm").addEventListener("submit", (e) => {
        e.preventDefault();
        if (!confirm("Delete admin account permanently?")) return;
        const btn = e.target.querySelector("button[type='submit']");
        setLoading(btn, true);
        axios.post("/api/admin/delete", {
            confirm_password_for_delete: $("confirm_password_for_delete").value
        })
        .then(() => {
            showToast("success", "Account deleted");
            localStorage.removeItem("admin_token");
            setTimeout(() => window.location.href = "/admin/login", 800);
        })
        .catch(err => showToast("error", err.response?.data?.message || "Delete failed"))
        .finally(() => setLoading(btn, false));
    });

    /* 2FA enable -> QR */
    $("btnStartEnable2fa").addEventListener("click", () => {
        axios.post("/api/admin/2fa/enable")
            .then(res => {
                const data = res.data || {};
                twofaQr.innerHTML = data.qr_svg || "<p class='text-sm text-gray-600'>QR unavailable.</p>";
                twofaSetupBox.classList.remove("hidden");
                showToast("success", "Scan the QR and enter the code");
            })
            .catch(() => showToast("error", "Could not start 2FA setup"));
    });

    $("btnCancel2fa").addEventListener("click", () => {
        twofaSetupBox.classList.add("hidden");
        twofaQr.innerHTML = "";
        twofaCode.value = "";
    });

    /* 2FA confirm */
    $("btnConfirm2fa").addEventListener("click", () => {
        const code = twofaCode.value.trim();
        if (!code) { showToast("warn", "Enter the 6-digit code."); return; }
        axios.post("/api/admin/2fa/confirm", { code })
            .then(() => { showToast("success", "2FA enabled"); refreshProfile(); })
            .catch(() => showToast("error", "Invalid code"));
    });

    /* Recovery codes */
    $("btnShowRecovery").addEventListener("click", () => {
        axios.get("/api/admin/2fa/recovery-codes")
            .then(res => {
                const list = res.data?.codes || [];
                recoveryCodes.textContent = list.join("\n");
                recoveryBox.classList.remove("hidden");
            })
            .catch(() => showToast("error", "Could not load recovery codes"));
    });

    const btnCopy = document.getElementById("btnCopyRecovery");
    if (btnCopy) {
      btnCopy.addEventListener("click", async () => {
        const text = recoveryCodes?.textContent?.trim();
        if (!text) { showToast("warn", "No codes to copy."); return; }
        try { await navigator.clipboard.writeText(text); showToast("success", "Recovery codes copied"); }
        catch { showToast("error", "Copy failed"); }
      });
    }

    /* Regenerate codes */
    $("btnRegenerateRecovery").addEventListener("click", () => {
        if (!confirm("Regenerate recovery codes? Old codes will stop working.")) return;
        axios.post("/api/admin/2fa/recovery-codes")
            .then(res => {
                const list = res.data?.codes || [];
                recoveryCodes.textContent = list.join("\n");
                recoveryBox.classList.remove("hidden");
                showToast("success", "Recovery codes regenerated");
            })
            .catch(() => showToast("error", "Could not regenerate recovery codes"));
    });

    /* Disable 2FA */
    $("btnDisable2fa").addEventListener("click", () => {
        if (!confirm("Disable 2FA for this account?")) return;
        axios.post("/api/admin/2fa/disable")
            .then(() => { showToast("success", "2FA disabled"); refreshProfile(); })
            .catch(() => showToast("error", "Could not disable 2FA"));
    });
});
</script>
