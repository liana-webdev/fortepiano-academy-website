// scripts/script.js

// Mobile nav toggle
(() => {
  const btn = document.querySelector(".nav__toggle");
  const menu = document.getElementById("navMenu");
  if (!btn || !menu) return;

  const close = () => {
    menu.classList.remove("is-open");
    btn.setAttribute("aria-expanded", "false");
  };

  const toggle = () => {
    const open = menu.classList.toggle("is-open");
    btn.setAttribute("aria-expanded", open ? "true" : "false");
  };

  btn.addEventListener("click", (e) => {
    e.preventDefault();
    e.stopPropagation();
    toggle();
  });

  // close when clicking a link
  menu.querySelectorAll("a").forEach((a) => a.addEventListener("click", close));

  // close on outside click
  document.addEventListener("click", (e) => {
    if (!menu.classList.contains("is-open")) return;
    if (menu.contains(e.target) || btn.contains(e.target)) return;
    close();
  });

  // close on Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") close();
  });
})();

// Theme toggle (2-state: light <-> dark)
(() => {
  const btn = document.getElementById("themeToggle");
  if (!btn) return;

  const KEY = "theme"; // stores: "light" or "dark"

  const apply = (mode) => {
    document.body.classList.remove("theme-dark", "theme-light");
    document.body.classList.add(mode === "light" ? "theme-light" : "theme-dark");

    // aria-pressed: true = "active" (useful for screen readers)
    btn.setAttribute("aria-pressed", mode === "dark" ? "true" : "false");

    // helps native form controls match
    document.documentElement.style.colorScheme = mode;
  };

  // initial mode: saved > system preference
  const saved = localStorage.getItem(KEY);
  const systemDark =
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches;

  const initial =
    saved === "light" || saved === "dark"
      ? saved
      : systemDark
      ? "dark"
      : "light";

  apply(initial);

  btn.addEventListener("click", () => {
    const next = document.body.classList.contains("theme-dark") ? "light" : "dark";
    localStorage.setItem(KEY, next);
    apply(next);
  });
})();
