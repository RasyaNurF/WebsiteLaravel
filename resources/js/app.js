// Drawer navigasi seluler, garis bawah header, dan animasi reveal saat menggulir.

const drawer = document.querySelector('[data-drawer]');
const toggle = document.querySelector('[data-toggle]');

if (toggle && drawer) {
    toggle.addEventListener('click', () => {
        const open = drawer.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', String(!open));
    });

    drawer.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            drawer.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        });
    });
}

// Navbar kaca: transparan di atas lalu berkaca gelap setelah menggulir (hanya
// beranda; halaman lain selalu berkaca dari server dan tidak diubah di sini).
const glassHeader = document.getElementById('glass-header');

if (glassHeader && glassHeader.hasAttribute('data-transparent-top')) {
    const glassClasses = ['bg-navy-950/80', 'backdrop-blur', 'shadow-sm', 'border-b', 'border-white/10'];

    const onGlassScroll = () => {
        const scrolled = window.scrollY > 24;
        glassClasses.forEach((cls) => glassHeader.classList.toggle(cls, scrolled));
    };

    window.addEventListener('scroll', onGlassScroll, { passive: true });
    onGlassScroll();
}

// --- Chat admin (halaman kontak) ---
const chatForm = document.getElementById('chat-form');
const chatMessages = document.getElementById('chat-messages');

if (chatForm && chatMessages) {
    const chatBody = document.getElementById('chat-body');
    const chatIdentity = document.getElementById('chat-identity');
    const chatError = document.getElementById('chat-error');
    const submitButton = chatForm.querySelector('button[type="submit"]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const scrollChatToBottom = () => {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    const appendBubble = (message) => {
        document.getElementById('chat-empty')?.remove();

        const row = document.createElement('div');
        row.className = message.sender === 'guest' ? 'flex justify-end' : 'flex justify-start';

        const bubble = document.createElement('div');
        bubble.className =
            message.sender === 'guest'
                ? 'max-w-[80%] rounded-2xl rounded-br-sm bg-navy-800 px-4 py-2.5 text-sm leading-relaxed text-white'
                : 'max-w-[80%] rounded-2xl rounded-bl-sm bg-white px-4 py-2.5 text-sm leading-relaxed ring-1 ring-neutral-200';

        if (message.sender !== 'guest') {
            const label = document.createElement('p');
            label.className = 'text-[11px] font-bold text-navy-700';
            label.textContent = message.is_auto ? 'Admin Nusakode (otomatis)' : 'Admin Nusakode';
            bubble.appendChild(label);
        }

        const text = document.createElement('p');
        if (message.sender !== 'guest') {
            text.className = 'mt-0.5';
        }
        text.textContent = message.body;
        bubble.appendChild(text);

        const time = document.createElement('p');
        time.className =
            message.sender === 'guest'
                ? 'mt-1 text-right text-[11px] text-neutral-300'
                : 'mt-1 text-[11px] text-neutral-400';
        time.textContent = message.time;
        bubble.appendChild(time);

        row.appendChild(bubble);
        chatMessages.appendChild(row);
        scrollChatToBottom();
    };

    scrollChatToBottom();

    chatForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        chatError?.classList.add('hidden');
        submitButton.disabled = true;

        try {
            const response = await fetch(chatForm.action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: new FormData(chatForm),
            });

            if (response.status === 422) {
                const data = await response.json();
                const firstError = Object.values(data.errors ?? {}).flat()[0];
                throw new Error(firstError ?? 'Pesan belum valid. Periksa kembali isian Anda.');
            }

            if (!response.ok) {
                throw new Error('Pesan gagal terkirim. Coba lagi sebentar lagi.');
            }

            const data = await response.json();
            data.messages.forEach(appendBubble);

            chatBody.value = '';
            chatIdentity?.classList.add('hidden');
        } catch (error) {
            if (chatError) {
                chatError.textContent = error.message;
                chatError.classList.remove('hidden');
            }
        } finally {
            submitButton.disabled = false;
        }
    });
}

// --- Intip kata sandi (halaman login) ---
document.querySelectorAll('[data-pw-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const eye = button.querySelector('[data-eye]');
        const eyeOff = button.querySelector('[data-eye-off]');

        if (!input) {
            return;
        }

        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(show));
        button.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        eye?.classList.toggle('hidden', show);
        eyeOff?.classList.toggle('hidden', !show);
    });
});

// Reveal on scroll: blok section muncul halus, item daftar menyusul berurutan.
const listItems = document.querySelectorAll(
    '#layanan [data-service-item], #proses ol > li, #insight .divide-y > a'
);

listItems.forEach((el) => {
    const siblings = [...el.parentElement.children];
    el.style.transitionDelay = `${(siblings.indexOf(el) % 4) * 80}ms`;
});

const revealTargets = document.querySelectorAll(
    'main section > div:not([data-no-reveal]), #layanan [data-service-item], #solusi .divide-y > div'
);

if ('IntersectionObserver' in window && revealTargets.length > 0) {
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -48px 0px' }
    );

    revealTargets.forEach((el) => {
        el.classList.add('reveal');
        io.observe(el);
    });
}
