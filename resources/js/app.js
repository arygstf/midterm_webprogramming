

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function tick() {
    document.querySelectorAll('.countdown').forEach((el) => {
        const ms = new Date(el.dataset.deadline) - Date.now();

        if (ms <= 0) {
            el.textContent = 'overdue';
            return;
        }

        const totalSeconds = Math.floor(ms / 1000);
        const days = Math.floor(totalSeconds / 86400);
        const hours = Math.floor((totalSeconds % 86400) / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        const pad = (n) => String(n).padStart(2, '0');

        if (days >= 1) {
            el.textContent = `${days}d ${hours}h ${pad(minutes)}m`;
        } else {
            el.textContent = `${hours} : ${pad(minutes)} : ${pad(seconds)}`;
        }
    });
}

tick();
setInterval(tick, 1000);

tick();
setInterval(tick, 1000);