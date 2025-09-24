<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    {{-- Back button --}}
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center px-3 py-2 rounded bg-gray-800 text-white hover:bg-gray-900">
            ← Back to Dashboard
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Profile</h1>

    {{-- Security check --}}
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <h2 class="text-lg font-semibold mb-2">Security</h2>
        <p id="security" class="text-gray-700">Checking...</p>
    </div>

    {{-- ===== 2FA (Two-Factor Authentication) ===== --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Two-Factor Authentication (2FA)</h2>
            <span id="twofaStatusBadge" class="text-sm px-3 py-1 rounded-full bg-gray-100 text-gray-700">—</span>
        </div>

        {{-- When 2FA is disabled: show "Enable" flow --}}
        <div id="twofaDisabled" class="mt-4 hidden">
            <p class="text-gray-600">2FA adds an extra layer of security to your admin account.</p>
            <button id="btnStartEnable2fa"
                    class="mt-3 px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                Enable 2FA
            </button>

            {{-- Setup box (QR + code entry) --}}
            <div id="twofaSetupBox" class="mt-5 hidden border rounded-lg p-4">
                <p class="text-gray-700 mb-3">Scan this QR with Google Authenticator (or Authy), then enter the 6-digit code.</p>
                <div id="twofaQr" class="bg-white p-3 rounded border inline-block"></div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Authenticator code</label>
                    <input id="twofaCode" type="text"
                           class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                           placeholder="123456"/>
                </div>
                <div class="mt-3 flex items-center gap-3">
                    <button id="btnConfirm2fa"
                            class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                        Confirm & Activate
                    </button>
                    <button id="btnCancel2fa"
                            class="px-4 py-2 rounded bg-gray-200 text-gray-800 hover:bg-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        {{-- When 2FA is enabled: show management actions --}}
        <div id="twofaEnabled" class="mt-4 hidden">
            <p class="text-gray-700">2FA is currently enabled for this account.</p>

            <div class="mt-4 flex flex-wrap items-center gap-3">
                <button id="btnShowRecovery"
                        class="px-4 py-2 rounded bg-slate-700 text-white hover:bg-slate-800">
                    Show recovery codes
                </button>
                <button id="btnRegenerateRecovery"
                        class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                    Regenerate recovery codes
                </button>
                <button id="btnDisable2fa"
                        class="px-4 py-2 rounded bg-rose-600 text-white hover:bg-rose-700">
                    Disable 2FA
                </button>
            </div>

            <div id="recoveryBox" class="mt-4 hidden border rounded-lg p-4">
                <h3 class="font-semibold mb-2">Recovery codes</h3>
                <p class="text-sm text-gray-600 mb-3">
                    Store these codes securely. Each code can be used once if you lose access to your authenticator app.
                </p>
                <pre id="recoveryCodes" class="bg-gray-50 p-3 rounded text-sm leading-6"></pre>
            </div>
        </div>
    </div>

    {{-- Account Info --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Account Info</h2>
        <form id="profileForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input id="name" type="text"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                    Save changes
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Change Password</h2>
        <form id="passwordForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Current password</label>
                <input id="current_password" type="password"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">New password</label>
                <input id="password" type="password"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm new password</label>
                <input id="password_confirmation" type="password"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                    Update password
                </button>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-red-700">Danger Zone</h2>
        <p class="text-gray-600 mb-4">Deleting your admin account is permanent.</p>
        <form id="deleteForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm with password</label>
                <input id="confirm_password_for_delete" type="password"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
            </div>
            <button type="submit"
                    class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                Delete account
            </button>
        </form>
    </div>
</div>

{{-- Axios + Token Handling --}}
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

    if (!token) {
        securityEl.innerText = "Not logged in (no admin token).";
        return;
    }

    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

    // ---------- Load profile & 2FA status ----------
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

                // hide setup/recovery blocks on refresh
                twofaSetupBox.classList.add("hidden");
                recoveryBox.classList.add("hidden");
                twofaQr.innerHTML = "";
                twofaCode.value = "";
            })
            .catch(err => {
                console.error(err);
                securityEl.innerText = "Token invalid ❌";
            });
    }
    refreshProfile();

    // ---------- Profile update ----------
    $("profileForm").addEventListener("submit", (e) => {
        e.preventDefault();
        axios.put("/api/admin/profile", {
            name: $("name").value,
            email: $("email").value
        })
        .then(() => alert("Profile updated ✅"))
        .catch(err => {
            console.error(err);
            alert("Update failed ❌");
        });
    });

    // ---------- Password update ----------
    $("passwordForm").addEventListener("submit", (e) => {
        e.preventDefault();
        axios.post("/api/admin/change-password", {
            current_password: $("current_password").value,
            password: $("password").value,
            password_confirmation: $("password_confirmation").value
        })
        .then(() => {
            alert("Password changed ✅");
            $("current_password").value = "";
            $("password").value = "";
            $("password_confirmation").value = "";
        })
        .catch(err => {
            console.error(err);
            const msg = err.response?.data?.message || "Password update failed ❌";
            alert(msg);
        });
    });

    // ---------- Delete account ----------
    $("deleteForm").addEventListener("submit", (e) => {
        e.preventDefault();
        axios.post("/api/admin/delete", {
            confirm_password_for_delete: $("confirm_password_for_delete").value
        })
        .then(() => {
            alert("Account deleted ✅");
            localStorage.removeItem("admin_token");
            window.location.href = "/admin/login";
        })
        .catch(err => {
            console.error(err);
            alert("Delete failed ❌");
        });
    });

    // ---------- 2FA: start enable flow (get QR) ----------
    $("btnStartEnable2fa").addEventListener("click", () => {
        axios.post("/api/admin/2fa/enable")
            .then(res => {
                // Expect: { qr_svg: "<svg ...>", secret: "JBSWY3DPEHPK3PXP" }
                const data = res.data || {};
                twofaQr.innerHTML = data.qr_svg || "<p class='text-sm text-gray-600'>QR unavailable.</p>";
                twofaSetupBox.classList.remove("hidden");
            })
            .catch(err => {
                console.error(err);
                alert("Could not start 2FA setup ❌");
            });
    });

    $("btnCancel2fa").addEventListener("click", () => {
        twofaSetupBox.classList.add("hidden");
        twofaQr.innerHTML = "";
        twofaCode.value = "";
    });

    // ---------- 2FA: confirm code ----------
    $("btnConfirm2fa").addEventListener("click", () => {
        const code = twofaCode.value.trim();
        if (!code) { alert("Enter the 6-digit code."); return; }

        axios.post("/api/admin/2fa/confirm", { code })
            .then(() => {
                alert("2FA enabled ✅");
                refreshProfile();
            })
            .catch(err => {
                console.error(err);
                alert("Invalid code ❌");
            });
    });

    // ---------- 2FA: show recovery codes ----------
    $("btnShowRecovery").addEventListener("click", () => {
        axios.get("/api/admin/2fa/recovery-codes")
            .then(res => {
                const list = res.data?.codes || [];
                recoveryCodes.textContent = list.join("\n");
                recoveryBox.classList.remove("hidden");
            })
            .catch(err => {
                console.error(err);
                alert("Could not load recovery codes ❌");
            });
    });

    // ---------- 2FA: regenerate recovery codes ----------
    $("btnRegenerateRecovery").addEventListener("click", () => {
        if (!confirm("Regenerate recovery codes? Old codes will stop working.")) return;
        axios.post("/api/admin/2fa/recovery-codes")
            .then(res => {
                const list = res.data?.codes || [];
                recoveryCodes.textContent = list.join("\n");
                recoveryBox.classList.remove("hidden");
                alert("Recovery codes regenerated ✅");
            })
            .catch(err => {
                console.error(err);
                alert("Could not regenerate recovery codes ❌");
            });
    });

    // ---------- 2FA: disable ----------
    $("btnDisable2fa").addEventListener("click", () => {
        if (!confirm("Disable 2FA for this account?")) return;
        axios.post("/api/admin/2fa/disable")
            .then(() => {
                alert("2FA disabled ✅");
                refreshProfile();
            })
            .catch(err => {
                console.error(err);
                alert("Could not disable 2FA ❌");
            });
    });
});
</script>
