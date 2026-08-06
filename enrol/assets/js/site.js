(() => {
  const navToggle = document.querySelector('[data-nav-toggle]');
  const nav = document.querySelector('[data-nav]');

  if (navToggle && nav) {
    navToggle.addEventListener('click', () => {
      const open = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', String(!open));
      nav.toggleAttribute('data-open', !open);
    });
    nav.addEventListener('click', (event) => {
      if (event.target.closest('a')) {
        navToggle.setAttribute('aria-expanded', 'false');
        nav.removeAttribute('data-open');
      }
    });
  }

  const attributionKeys = [
    'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term',
    'gclid', 'gbraid', 'wbraid', 'fbclid'
  ];
  const params = new URLSearchParams(window.location.search);

  attributionKeys.forEach((key) => {
    const incoming = (params.get(key) || '').slice(0, 300);
    if (incoming) {
      try { sessionStorage.setItem(`fpa_${key}`, incoming); } catch (_) {}
    }
    let value = incoming;
    if (!value) {
      try { value = sessionStorage.getItem(`fpa_${key}`) || ''; } catch (_) {}
    }
    const input = document.querySelector(`[data-attribution="${key}"]`);
    if (input && !input.value) input.value = value;
  });

  const landing = document.querySelector('[data-attribution="landing_url"]');
  const referrer = document.querySelector('[data-attribution="referrer_url"]');
  if (landing && !landing.value) landing.value = window.location.href.slice(0, 1000);
  if (referrer && !referrer.value) referrer.value = document.referrer.slice(0, 1000);

  document.addEventListener('click', (event) => {
    const link = event.target.closest('a');
    if (!link) return;
    let eventName = link.dataset.track || '';
    if (!eventName && link.href.startsWith('tel:')) eventName = 'phone';
    if (!eventName && link.href.startsWith('mailto:')) eventName = 'email';
    if (!eventName && /wa\.me|whatsapp/i.test(link.href)) eventName = 'whatsapp';
    if (!eventName) return;
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event: 'engagement_click', link_type: eventName, link_url: link.href });
    if (typeof window.gtag === 'function') {
      window.gtag('event', 'engagement_click', { link_type: eventName, link_url: link.href });
    }
  });

  const form = document.querySelector('[data-enquiry-form]');
  const submit = document.querySelector('[data-submit-button]');
  if (form && submit) {
    form.addEventListener('submit', () => {
      submit.disabled = true;
      submit.textContent = 'Sending enquiry…';
    });
  }

  const alert = document.querySelector('[data-form-alert]');
  if (alert) alert.focus({ preventScroll: true });
})();
