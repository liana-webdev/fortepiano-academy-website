// scripts/script.js

// Mobile nav toggle
(() => {
  const btn = document.querySelector(".nav__toggle");
  const menu = document.getElementById("navMenu");
  if (!btn || !menu) return;

  const close = () => {
    menu.classList.remove("is-open");
    btn.classList.remove("is-open");
    btn.setAttribute("aria-expanded", "false");
    document.body.classList.remove("nav-open");
  };

  const toggle = () => {
    const open = menu.classList.toggle("is-open");
    btn.classList.toggle("is-open", open);
    btn.setAttribute("aria-expanded", open ? "true" : "false");
    document.body.classList.toggle("nav-open", open);
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

// Scroll-to-reveal blocks
(() => {
  const autoRevealSelector = [
    "main .section__header",
    "main .hero .stack",
    "main .hero__media",
    "main .blog-hero .stack",
    "main .blog-hero__media",
    "main .article-header",
    "main .article-hero",
    "main .article-body > h2",
    "main .article-body > h3",
    "main .article-body > p",
    "main .article-cta",
    "main .card",
    "main .timeline__item",
    "main .tags",
    "main .program__item",
    "main .ribbon__item",
    "main .center.pad-top-m",
    ".reveal-block",
  ].join(",");

  let didInitRevealBlocks = false;

  const initRevealBlocks = () => {
    if (didInitRevealBlocks) return;

    const blocks = Array.from(new Set(document.querySelectorAll(autoRevealSelector)))
      .filter((block) => !block.closest(".site-header, .site-footer"));

    if (!blocks.length) return;
    didInitRevealBlocks = true;

    if (!("IntersectionObserver" in window)) {
      blocks.forEach((block) => block.classList.add("is-revealed"));
      return;
    }

    blocks.forEach((block) => block.classList.add("reveal-block", "is-reveal-ready"));

    const revealQueue = [];
    const queuedBlocks = new Set();
    let revealFrame = null;

    const flushRevealQueue = () => {
      revealFrame = null;

      const visibleBlocks = revealQueue
        .splice(0)
        .sort(
          (a, b) =>
            a.getBoundingClientRect().top - b.getBoundingClientRect().top ||
            a.getBoundingClientRect().left - b.getBoundingClientRect().left
        );

      visibleBlocks.forEach((block, index) => {
        queuedBlocks.delete(block);
        block.style.setProperty("--reveal-delay", `${index * 0.1}s`);
        block.classList.add("is-revealed");
      });
    };

    const observer = new IntersectionObserver(
      (entries, currentObserver) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;

          const block = entry.target;
          if (!queuedBlocks.has(block)) {
            queuedBlocks.add(block);
            revealQueue.push(block);
          }
          currentObserver.unobserve(block);
        });

        if (revealQueue.length && !revealFrame) {
          revealFrame = window.requestAnimationFrame(flushRevealQueue);
        }
      },
      {
        threshold: 0.18,
        rootMargin: "0px 0px -8% 0px",
      }
    );

    blocks.forEach((block) => observer.observe(block));
  };

  initRevealBlocks();
  document.addEventListener("DOMContentLoaded", initRevealBlocks, { once: true });
})();

// Theme toggle (2-state: light <-> dark)
(() => {
  const btn = document.getElementById("themeToggle");
  if (!btn) return;

  const KEY = "theme"; // stores: "light" or "dark"
  let userSet = false;

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
  userSet = saved === "light" || saved === "dark";
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

  // react to system changes if user hasn't set a manual preference yet
  if (!userSet && window.matchMedia) {
    const mq = window.matchMedia("(prefers-color-scheme: dark)");
    mq.addEventListener("change", (e) => {
      if (userSet) return;
      apply(e.matches ? "dark" : "light");
    });
  }

  btn.addEventListener("click", () => {
    const next = document.body.classList.contains("theme-dark") ? "light" : "dark";
    userSet = true;
    localStorage.setItem(KEY, next);
    apply(next);
  });
})();
