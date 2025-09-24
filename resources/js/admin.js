// ========= Axios (Sanctum) =========
import axios from "axios";

// send cookies with every request (needed for Sanctum session auth)
axios.defaults.withCredentials = true;
// your local app base URL (match what you see in the browser)
axios.defaults.baseURL = "http://127.0.0.1:8000";
// standard headers
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["Accept"] = "application/json";

// (optional) if you also use Bearer tokens anywhere, keep this
const token = localStorage.getItem("token");
if (token) {
  axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

// expose globally
window.axios = axios;

// ✅ Warm up Sanctum CSRF cookie ASAP (so /api/* calls won’t 401)
(async () => {
  try {
    await axios.get("/sanctum/csrf-cookie");
  } catch (e) {
    console.warn("Could not set CSRF cookie:", e);
  }
})();

// ========= Charts / UI =========
import Chart from "chart.js/auto";

/* ========= Utilities ========= */
function gradient(ctx, color1, color2, alpha = 0.5) {
  const g = ctx.createLinearGradient(0, 0, 0, 260);
  g.addColorStop(0, color1);
  g.addColorStop(1, `rgba(255,255,255,${alpha})`);
  return g;
}

function animateNumber(el, end, duration = 1200) {
  if (!el) return;
  const start = 0;
  let startTs = null;
  const step = (ts) => {
    if (!startTs) startTs = ts;
    const progress = Math.min((ts - startTs) / duration, 1);
    const val = Math.floor(progress * (end - start) + start);
    el.textContent = val.toLocaleString();
    if (progress < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}
function animateCurrency(el, end, duration = 1200) {
  if (!el) return;
  const start = 0;
  let startTs = null;
  const step = (ts) => {
    if (!startTs) startTs = ts;
    const progress = Math.min((ts - startTs) / duration, 1);
    const val = Math.floor(progress * (end - start) + start);
    el.textContent = `$${val.toLocaleString()}`;
    if (progress < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

/* ========= Charts ========= */
function salesChart() {
  const el = document.getElementById("salesChart");
  if (!el) return;
  const ctx = el.getContext("2d");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      datasets: [
        {
          label: "Keyboards",
          data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
          borderColor: "#8b5cf6",
          backgroundColor: gradient(ctx, "rgba(139,92,246,0.3)", "rgba(139,92,246,0.1)"),
          tension: 0.4,
          fill: true,
          pointRadius: 4,
          pointBackgroundColor: "#8b5cf6",
          pointBorderColor: "#fff",
          pointBorderWidth: 2
        },
        {
          label: "Headsets",
          data: [8000, 12000, 10000, 18000, 16000, 21000, 19000],
          borderColor: "#ec4899",
          backgroundColor: gradient(ctx, "rgba(236,72,153,0.3)", "rgba(236,72,153,0.1)"),
          tension: 0.4,
          fill: true,
          pointRadius: 4,
          pointBackgroundColor: "#ec4899",
          pointBorderColor: "#fff",
          pointBorderWidth: 2
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          mode: "index",
          intersect: false,
          callbacks: {
            label: (ctx) => `${ctx.dataset.label}: $${ctx.parsed.y.toLocaleString()}`
          }
        }
      },
      interaction: { mode: "index", intersect: false },
      scales: {
        x: { grid: { display: false } },
        y: {
          ticks: {
            callback: (value) => "$" + value / 1000 + "k"
          }
        }
      }
    }
  });
}

function orderStatusChart() {
  const el = document.getElementById("orderStatusChart");
  if (!el) return;
  const ctx = el.getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Delivered", "Processing", "Pending"],
      datasets: [{
        data: [68, 45, 14],
        backgroundColor: ["#10b981", "#f59e0b", "#ef4444"],
        borderWidth: 0
      }]
    },
    options: { cutout: "70%", plugins: { legend: { display: false } } }
  });
}

function topProductsChart() {
  const el = document.getElementById("topProductsChart");
  if (!el) return;
  const ctx = el.getContext("2d");

  const values = [234, 189, 156, 142, 98, 76];
  const maxVal = Math.max(...values);

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Mouse", "Keyboard", "Headset", "Mousepad", "Controller", "Webcam"],
      datasets: [{
        label: "Units Sold",
        data: values,
        backgroundColor: [
          "rgba(139,92,246,0.8)",
          "rgba(236,72,153,0.8)",
          "rgba(59,130,246,0.8)",
          "rgba(16,185,129,0.8)",
          "rgba(245,158,11,0.8)",
          "rgba(239,68,68,0.8)"
        ],
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: {
          min: 0,
          max: maxVal,
          ticks: { stepSize: Math.ceil(maxVal / 5) },
          grid: { color: "rgba(0,0,0,0.05)" }
        },
        x: {
          ticks: { font: { size: 12, weight: "600" } },
          grid: { display: false }
        }
      }
    }
  });
}

/* ========= Promo Modal ========= */
window.openPromoModal = function () {
  document.getElementById("promoModal")?.classList.remove("hidden");
};
window.closePromoModal = function () {
  document.getElementById("promoModal")?.classList.add("hidden");
};
window.savePromo = function () {
  window.closePromoModal();
  const t = document.getElementById("promoToast");
  if (!t) return;
  t.classList.remove("hidden");
  setTimeout(() => t.classList.add("hidden"), 2000);
};

/* ========= Init ========= */
window.addEventListener("load", () => {
  // charts
  salesChart();
  orderStatusChart();
  topProductsChart();

  // KPI animations (read final values from data-end)
  const prodEl = document.getElementById("kpiProducts");
  const orderEl = document.getElementById("kpiOrders");
  const userEl  = document.getElementById("kpiUsers");
  const revEl   = document.getElementById("kpiRevenue");

  animateNumber(prodEl, Number(prodEl?.dataset.end || 0));
  animateNumber(orderEl, Number(orderEl?.dataset.end || 0));
  animateNumber(userEl,  Number(userEl?.dataset.end || 0));
  animateCurrency(revEl, Math.round(Number(revEl?.dataset.end || 0)));
});
