//   header and mobile sidebar and cart sidebar js

const overlay = document.getElementById("sidebarOverlay");
const leftSidebar = document.getElementById("leftSidebar");
const rightSidebar = document.getElementById("rightSidebar");

function openLeft() {
  leftSidebar.classList.add("show");
  overlay.classList.add("show");
  document.body.style.overflow = "hidden";
}
function closeLeft() {
  leftSidebar.classList.remove("show");
  if (!rightSidebar.classList.contains("show")) {
    overlay.classList.remove("show");
    document.body.style.overflow = "";
  }
}
function openRight() {
  rightSidebar.classList.add("show");
  overlay.classList.add("show");
  document.body.style.overflow = "hidden";
}
function closeRight() {
  rightSidebar.classList.remove("show");
  if (!leftSidebar.classList.contains("show")) {
    overlay.classList.remove("show");
    document.body.style.overflow = "";
  }
}

document.getElementById("hamburgerBtn").addEventListener("click", openLeft);
document
  .getElementById("leftSidebarClose")
  .addEventListener("click", closeLeft);
document.getElementById("cartBtnDesktop").addEventListener("click", openRight);
document.getElementById("cartBtnMobile").addEventListener("click", openRight);
document
  .getElementById("cartSidebarClose")
  .addEventListener("click", closeRight);
overlay.addEventListener("click", () => {
  closeLeft();
  closeRight();
});

// Mobile search
document.getElementById("mobileSearchBtn").addEventListener("click", () => {
  const bar = document.getElementById("mobileSearchBar");
  bar.classList.toggle("show");
  if (bar.classList.contains("show")) bar.querySelector("input").focus();
});

// Qty
let qty = 1;
function changeQty(d) {
  qty = Math.max(1, qty + d);
  document.getElementById("qtyNum").textContent = qty;
}

// Love scroll
const ls = document.getElementById("loveScroll");
document
  .getElementById("scrollLeft")
  .addEventListener("click", () =>
    ls.scrollBy({ left: -170, behavior: "smooth" }),
  );
document
  .getElementById("scrollRight")
  .addEventListener("click", () =>
    ls.scrollBy({ left: 170, behavior: "smooth" }),
  );

//   category js
// Auto duplicate করে seamless loop বানাবে
const track = document.getElementById("catTrack");
const clone = track.innerHTML;
track.innerHTML = clone + clone;

// best seller js

(function () {
  const track = document.getElementById("productTrack");
  const prevBtn = document.getElementById("prodPrev");
  const nextBtn = document.getElementById("prodNext");
  const total = track.children.length;
  let currentIndex = 0;

  function visibleCount() {
    if (window.innerWidth >= 992) return 4;
    if (window.innerWidth >= 576) return 3;
    return 2;
  }

  function updateTrack() {
    const maxIndex = total - visibleCount();
    currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));

    // percentage দিয়ে move করলে Bootstrap conflict হয় না
    const slidePercent = 100 / visibleCount();
    track.style.transform = "translateX(-" + slidePercent * currentIndex + "%)";

    prevBtn.style.opacity = currentIndex === 0 ? "0.4" : "1";
    nextBtn.style.opacity = currentIndex >= maxIndex ? "0.4" : "1";
  }

  // ── Auto Slide ──
  let autoSlideInterval;

  function startAutoSlide() {
    autoSlideInterval = setInterval(function () {
      const maxIndex = total - visibleCount();
      if (currentIndex >= maxIndex) {
        currentIndex = 0; // শেষে গেলে আবার শুরু থেকে
      } else {
        currentIndex++;
      }
      updateTrack();
    }, 3000); // প্রতি ৩ সেকেন্ডে একটা slide
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  prevBtn.addEventListener("click", function () {
    currentIndex = Math.max(0, currentIndex - 1);
    updateTrack();
    stopAutoSlide();
    setTimeout(startAutoSlide, 5000);
  });

  nextBtn.addEventListener("click", function () {
    currentIndex = Math.min(total - visibleCount(), currentIndex + 1);
    updateTrack();
    stopAutoSlide();
    setTimeout(startAutoSlide, 5000);
  });

  // Touch swipe support
  let startX = 0;
  track.addEventListener(
    "touchstart",
    function (e) {
      startX = e.touches[0].clientX;
    },
    { passive: true },
  );

  track.addEventListener("touchend", function (e) {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) {
      if (diff > 0) nextBtn.click();
      else prevBtn.click();
    }
  });

  window.addEventListener("resize", function () {
    currentIndex = 0;
    updateTrack();
  });

  // Mouse hover এ pause
  track.parentElement.addEventListener("mouseenter", stopAutoSlide);
  track.parentElement.addEventListener("mouseleave", startAutoSlide);

  updateTrack();
  startAutoSlide();
})();

// product  js

document.addEventListener("DOMContentLoaded", function () {
  const track = document.getElementById("sfTrack");
  const total = track.children.length;
  let currentIndex = 0;
  let autoTimer;

  function visibleCount() {
    if (window.innerWidth >= 992) return 5;
    if (window.innerWidth >= 576) return 3;
    return 2;
  }

  function updateTrack() {
    const maxIndex = total - visibleCount();
    currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));
    const slideWidth = track.children[0].getBoundingClientRect().width;
    track.style.transform = "translateX(-" + slideWidth * currentIndex + "px)";
  }

  function startAuto() {
    clearInterval(autoTimer);
    autoTimer = setInterval(function () {
      const maxIndex = total - visibleCount();
      currentIndex = currentIndex >= maxIndex ? 0 : currentIndex + 1;
      updateTrack();
    }, 3000);
  }

  function stopAuto() {
    clearInterval(autoTimer);
  }

  // Touch swipe
  let startX = 0;
  track.addEventListener(
    "touchstart",
    function (e) {
      startX = e.touches[0].clientX;
    },
    { passive: true },
  );

  track.addEventListener("touchend", function (e) {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 40) {
      const maxIndex = total - visibleCount();
      if (diff > 0) currentIndex = Math.min(maxIndex, currentIndex + 1);
      else currentIndex = Math.max(0, currentIndex - 1);
      updateTrack();
      stopAuto();
      setTimeout(startAuto, 5000);
    }
  });

  // Hover pause
  track.parentElement.addEventListener("mouseenter", stopAuto);
  track.parentElement.addEventListener("mouseleave", startAuto);

  window.addEventListener("resize", function () {
    currentIndex = 0;
    updateTrack();
  });

  updateTrack();
  startAuto();
});
