{{-- ======= HEADER (glass, fixed, responsive) ======= --}}
<div>
  <!-- ===== Fixed header container ===== -->
  <div class="fixed top-0 left-0 right-0 z-40 ml-0 md:ml-72">
    {{-- Mini strip --}}
    <div class="flex flex-wrap items-center justify-between gap-y-1 px-4 md:px-6 py-2
                bg-slate-900/90 text-slate-200 text-sm border-b border-slate-700/60 backdrop-blur-md">
      <div class="flex flex-wrap items-center gap-x-4 gap-y-1 min-w-0">
        <span class="truncate">🎮 Admin Panel · Secure Access</span>
        <span class="hidden sm:inline">📧 admin@gamerz.com</span>
      </div>
      <span class="px-3 py-1 text-xs bg-green-600 text-white rounded-full whitespace-nowrap">● System Active</span>
    </div>

    {{-- Main bar --}}
    <div class="flex items-center justify-between px-4 md:px-6 py-3
                bg-slate-900/100 text-white border-b border-slate-700/60 backdrop-blur-md">
      {{-- Hamburger (mobile) --}}
      <button id="menu-btn" class="md:hidden p-2 rounded-lg bg-slate-800/80 hover:bg-slate-700/80 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      {{-- Search (compact + icon + responsive width) --}}
      <div class="mx-2 w-40 sm:w-56 md:w-72 lg:w-96 xl:w-[420px] min-w-0">
        <div class="relative">
          <input type="text" placeholder="Search products, customers, orders..."
                 class="w-full pl-10 pr-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-900
                        focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z"/>
          </svg>
        </div>
      </div>

      {{-- Right controls --}}
      <div class="flex items-center gap-3 shrink-0">
        {{-- Calendar --}}
        <button id="calendar-btn" class="p-2 rounded-lg bg-slate-800/80 hover:bg-slate-700/80">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3M7 11h10m-12 8h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </button>

        {{-- Notes --}}
        <button id="notes-btn" class="p-2 rounded-lg bg-slate-800/80 hover:bg-slate-700/80">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6M7 20h10a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v14l4-4z"/>
          </svg>
        </button>

        {{-- Profile dropdown --}}
        <div class="relative">
          <button id="profile-btn" class="flex items-center gap-2 bg-slate-800/80 px-3 py-2 rounded-lg hover:bg-slate-700/80">
            <img src="{{ asset('images/adminlogo.png') }}" class="h-8 w-8 rounded-full" alt="Admin">
            <div class="hidden md:block text-left">
              <p class="text-sm font-semibold">Admin</p>
              <p class="text-xs text-slate-400">Administrator</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          {{-- Wider, grey dropdown; Logout removed --}}
          <div id="profile-dropdown"
               class="hidden absolute right-0 mt-2 w-64 bg-slate-100 text-slate-800 rounded-lg shadow-xl border border-slate-200 z-[85] py-2">
            <a href="{{ route('admin.profile') }}" class="block px-4 py-2 hover:bg-slate-200 rounded-md">My Profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== Spacer: ONLY on mobile/sm; none on desktop ===== -->
  <div aria-hidden="true" class="h-10 sm:h-8 md:h-0"></div>

  {{-- ======= CENTERED MODALS + OVERLAY (blur) ======= --}}
  <div id="overlay-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[70]"></div>

  {{-- Calendar Modal --}}
  <div id="modal-calendar" class="hidden fixed inset-0 z-[80] p-4">
    <div class="min-h-full flex items-center justify-center">
      <div class="w-full max-w-lg max-h-[85vh] overflow-auto bg-white rounded-2xl shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between p-4 border-b">
          <div>
            <h3 class="font-semibold text-lg">September 2025</h3>
            <p class="text-xs text-slate-500">Today: Sep 16, 2025</p>
          </div>
          <div class="flex items-center gap-2">
            <button class="px-2 py-1 rounded border text-slate-600">&lt;</button>
            <button class="px-2 py-1 rounded border text-slate-600">&gt;</button>
            <button class="px-3 py-1 rounded bg-slate-100 text-slate-700">Today</button>
            <button id="close-calendar" class="p-2 text-slate-500 hover:text-red-500">✕</button>
          </div>
        </div>
        <div class="p-4">
          <div class="grid grid-cols-7 gap-2 text-center text-sm mb-2">
            <span class="font-semibold">Sun</span><span class="font-semibold">Mon</span><span class="font-semibold">Tue</span>
            <span class="font-semibold">Wed</span><span class="font-semibold">Thu</span><span class="font-semibold">Fri</span><span class="font-semibold">Sat</span>
          </div>
          <div class="grid grid-cols-7 gap-2 text-center text-sm">
            <span class="opacity-0">31</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span>
            <span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span>
            <span>13</span><span class="ring-2 ring-indigo-400 rounded-lg">15</span><span>16</span><span>17</span><span>18</span><span>19</span>
            <span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
            <span>27</span><span>29</span><span>30</span><span class="opacity-0">1</span><span class="opacity-0">2</span><span class="opacity-0">3</span><span class="opacity-0">4</span>
          </div>
          <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
            <span>No date selected</span>
            <button class="px-4 py-2 rounded-lg bg-cyan-600 text-white hover:bg-cyan-700">Select</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Notes Modal --}}
  <div id="modal-notes" class="hidden fixed inset-0 z-[80] p-4">
    <div class="min-h-full flex items-center justify-center">
      <div class="w-full max-w-lg max-h-[85vh] overflow-auto bg-white rounded-2xl shadow-2xl border border-slate-200">
        <div class="flex items-center justify-between p-4 border-b">
          <h3 class="font-semibold text-lg">Notes</h3>
          <div class="flex gap-2">
            <button id="clear-notes" class="px-3 py-1 rounded bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm">Clear</button>
            <button id="close-notes" class="p-2 text-slate-500 hover:text-red-500">✕</button>
          </div>
        </div>
        <div class="p-4">
          <ul class="space-y-2 text-sm">
            <li class="p-2 bg-slate-50 border rounded-lg">⚡ Check server logs today</li>
            <li class="p-2 bg-slate-50 border rounded-lg">📦 Verify new product upload</li>
            <li class="p-2 bg-slate-50 border rounded-lg">👥 Team meeting at 4PM</li>
          </ul>
          <textarea id="note-area" class="mt-3 w-full border border-slate-300 rounded-lg p-2" rows="4" placeholder="Write a new note..."></textarea>
          <button class="mt-3 w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Save</button>
          <p class="mt-2 text-xs text-slate-500">Manage quick reminders right from the header.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- ======= Header JS (sidebar, dropdown, modals) ======= --}}
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Sidebar toggle (elements come from sidebar partial)
    const menuBtn = document.getElementById("menu-btn");
    const sidebar = document.getElementById("sidebar");
    const overlaySide = document.getElementById("overlay-side");

    menuBtn?.addEventListener("click", () => {
      sidebar?.classList.remove("-translate-x-full");
      overlaySide?.classList.remove("hidden");
    });
    overlaySide?.addEventListener("click", () => {
      sidebar?.classList.add("-translate-x-full");
      overlaySide?.classList.add("hidden");
    });

    // Profile dropdown
    const profileBtn = document.getElementById("profile-btn");
    const dropdown = document.getElementById("profile-dropdown");
    profileBtn?.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("hidden");
    });
    document.addEventListener("click", (e) => {
      if (!dropdown.classList.contains("hidden") && !profileBtn.contains(e.target)) {
        dropdown.classList.add("hidden");
      }
    });

    // Modals (open one at a time)
    const overlayModal = document.getElementById("overlay-modal");
    const openCal = document.getElementById("calendar-btn");
    const openNotes = document.getElementById("notes-btn");
    const modalCal = document.getElementById("modal-calendar");
    const modalNotes = document.getElementById("modal-notes");
    const closeCal = document.getElementById("close-calendar");
    const closeNotes = document.getElementById("close-notes");

    function openOnly(which) {
      modalCal.classList.add("hidden");
      modalNotes.classList.add("hidden");
      if (which === "cal") modalCal.classList.remove("hidden");
      if (which === "notes") modalNotes.classList.remove("hidden");
      overlayModal.classList.remove("hidden");
      document.documentElement.classList.add("overflow-hidden");
    }
    function closeAllModals() {
      modalCal.classList.add("hidden");
      modalNotes.classList.add("hidden");
      overlayModal.classList.add("hidden");
      document.documentElement.classList.remove("overflow-hidden");
    }

    openCal?.addEventListener("click", () => openOnly("cal"));
    openNotes?.addEventListener("click", () => openOnly("notes"));
    closeCal?.addEventListener("click", closeAllModals);
    closeNotes?.addEventListener("click", closeAllModals);
    overlayModal?.addEventListener("click", closeAllModals);
    window.addEventListener("keydown", (e) => { if (e.key === "Escape") closeAllModals(); });
  });
  </script>
</div>
