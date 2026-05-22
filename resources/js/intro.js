document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('intro-loader');
    const logsContainer = document.getElementById('intro-logs');
    const progressBar = document.getElementById('intro-progress');
    const skipBtn = document.getElementById('intro-skip');

    if (!loader || !logsContainer || !progressBar) return;

    // Check if the user prefers reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Check if this session has already viewed the intro
    const hasLoaded = sessionStorage.getItem('intro-loaded');

    const finishIntro = () => {
        sessionStorage.setItem('intro-loaded', 'true');

        // Subtle glitch flicker before smooth fade-out
        let flickerCount = 0;
        const flicker = setInterval(() => {
            loader.style.opacity = flickerCount % 2 === 0 ? '0.6' : '1';
            flickerCount++;
            if (flickerCount >= 4) {
                clearInterval(flicker);
                loader.style.opacity = '1';
                // Now do the smooth fade-out
                loader.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    loader.style.display = 'none';
                    loader.remove();
                }, 700);
            }
        }, 60);
    };

    if (hasLoaded || prefersReducedMotion) {
        loader.style.display = 'none';
        loader.remove();
        return;
    }

    // Log sequence with types: 'log', 'warn', 'resolve', 'success'
    const logs = [
        { text: 'initializing syahfalah4787.dev ...', type: 'log', progress: 10 },
        { text: 'loading theme engine configurations ...', type: 'log', progress: 22 },
        { text: 'establishing secure handshake with api.github.com ...', type: 'log', progress: 38 },
        { text: 'warn: cached repository data expired — refetching ...', type: 'warn', progress: 50 },
        { text: 'resolved: fresh data loaded successfully.', type: 'resolve', progress: 60 },
        { text: 'compiling verlet physics engine ...', type: 'log', progress: 72 },
        { text: 'mounting interface components ...', type: 'log', progress: 88 },
        { text: 'status: all systems ready.', type: 'success', progress: 100 }
    ];

    let currentStep = 0;
    let cursorEl = null;

    // Create or move the blinking cursor
    const createCursor = () => {
        if (!cursorEl) {
            cursorEl = document.createElement('span');
            cursorEl.className = 'inline-block w-[6px] h-[13px] bg-white/70 ml-0.5 align-middle';
            cursorEl.style.animation = 'blink-cursor 0.8s step-end infinite';
        }
        return cursorEl;
    };

    // Inject the CSS keyframe for cursor blinking
    const style = document.createElement('style');
    style.textContent = `
        @keyframes blink-cursor {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    const typeLog = (item, callback) => {
        const logLine = document.createElement('div');
        logLine.className = 'flex items-start gap-2';

        const arrow = document.createElement('span');
        arrow.className = 'select-none font-bold shrink-0';

        // Style arrow based on log type
        if (item.type === 'warn') {
            arrow.className += ' text-yellow-500/80';
            arrow.textContent = '!';
        } else if (item.type === 'resolve') {
            arrow.className += ' text-green-500/80';
            arrow.textContent = '✓';
        } else if (item.type === 'success') {
            arrow.className += ' text-green-500';
            arrow.textContent = '>';
        } else {
            arrow.className += ' text-white';
            arrow.textContent = '>';
        }
        logLine.appendChild(arrow);

        const textSpan = document.createElement('span');
        textSpan.className = 'font-mono';

        // Style text based on type
        if (item.type === 'warn') {
            textSpan.className += ' text-yellow-500/70';
        } else if (item.type === 'resolve') {
            textSpan.className += ' text-green-500/70';
        } else if (item.type === 'success') {
            textSpan.className += ' text-white';
        } else {
            textSpan.className += ' text-gray-400';
        }

        logLine.appendChild(textSpan);
        logsContainer.appendChild(logLine);

        // Auto scroll to bottom of logs
        logsContainer.scrollTop = logsContainer.scrollHeight;

        let charIndex = 0;
        const text = item.text;

        // Attach blinking cursor to current text span
        const cursor = createCursor();
        textSpan.appendChild(cursor);

        const typeChar = () => {
            if (charIndex < text.length) {
                // Insert character before cursor
                textSpan.insertBefore(document.createTextNode(text.charAt(charIndex)), cursor);
                charIndex++;
                setTimeout(typeChar, 12 + Math.random() * 18);
            } else {
                // Remove cursor from this line after typing finishes
                if (cursor.parentNode === textSpan) {
                    textSpan.removeChild(cursor);
                }

                // Highlight the keyword "ready" in success line
                if (item.type === 'success') {
                    textSpan.innerHTML = text.replace('all systems ready', '<span class="text-green-400 font-bold uppercase">all systems ready</span>');
                }

                // Update progress bar
                progressBar.style.width = `${item.progress}%`;

                // Small delay between log lines for cinematic pacing
                const delay = item.type === 'warn' ? 400 : item.type === 'resolve' ? 200 : 180;
                setTimeout(callback, delay);
            }
        };

        typeChar();
    };

    const runSequence = () => {
        if (currentStep < logs.length) {
            typeLog(logs[currentStep], () => {
                currentStep++;
                runSequence();
            });
        } else {
            // Wait at 100% for organic feel before triggering the glitch-out
            setTimeout(finishIntro, 500);
        }
    };

    if (skipBtn) {
        skipBtn.addEventListener('click', (e) => {
            e.preventDefault();
            finishIntro();
        });
    }

    // Start boot sequence after a short initial delay
    setTimeout(runSequence, 400);
});
