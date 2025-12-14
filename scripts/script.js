 // Tiny nav toggle (kept simple)
        const btn = document.querySelector('.nav__toggle');
        const list = document.getElementById('navMenu');
        if (btn) {
            btn.addEventListener('click', () => {
                const open = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', String(!open));
                list.classList.toggle('is-open');
            });
        }