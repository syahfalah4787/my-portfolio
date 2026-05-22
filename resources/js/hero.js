// Interactive Hanging ID-Card Lanyard & 3D Spring Physics
// Computes all calculations and rendering inside container-local space.
// Since the Hero section has a high z-index (z-30) and overflow-visible, the card is natively
// rendered above the subsequent sections (e.g. About Me) without complex viewport conversions.
document.addEventListener('DOMContentLoaded', () => {
    // --------------------------------------------------------------------------
    // ID CARD LANYARD PHYSICS SECTION
    // --------------------------------------------------------------------------
    const containerEl = document.querySelector('#hero-interactive-container');
    const anchorEl = document.querySelector('#lanyard-anchor');
    const cardEl = document.querySelector('#id-card');
    const pathEl = document.querySelector('#lanyard-path');

    if (!containerEl || !anchorEl || !cardEl || !pathEl) {
        console.warn('Lanyard interactive elements not found in the DOM.');
        return;
    }

    // Set CSS properties for 3D rendering on the card
    cardEl.style.transformOrigin = '50% 0%';

    // Container dimensions & anchor coordinates in local container-space
    // Use fallback dimensions if clientWidth is initially 0
    let w = containerEl.clientWidth || 340;
    let h = containerEl.clientHeight || 600;
    let anchorX = w / 2;
    let anchorY = 20; // Anchor is at fixed 20px from top of container

    const cardLength = 120; // Length of the lanyard/string
    const cardWidth = 310;

    // Physics state (local to container)
    let x = anchorX;
    let y = anchorY + cardLength;
    let vx = 18; // Give an initial impulse on page load to showcase the swing!
    let vy = 0;
    let lastX = x;
    let lastY = y;

    // Physics parameters
    const gravity = 0.55;
    const springK = 0.015; // Spring stiffness
    const damping = 0.965;  // Velocity retention

    // Interaction state
    let isDragging = false;
    let grabX = 0;
    let grabY = 0;
    let mouseX = x;
    let mouseY = y + 230;

    // Rotation state (pitch, yaw, roll)
    let rx = 0;
    let ry = 0;
    let rz = 0;

    // Update dimensions on resize
    const updateBounds = () => {
        const clientW = containerEl.clientWidth;
        const clientH = containerEl.clientHeight;
        if (clientW > 0) {
            w = clientW;
            h = clientH;
            anchorX = w / 2;

            // If the card was in the default center state, sync it
            if (!isDragging && vx === 0 && vy === 0 && Math.abs(x - anchorX) < 1) {
                x = anchorX;
            }
        }
    };
    window.addEventListener('resize', updateBounds);

    // Periodically update bounds during load to align properly when styles mount
    setTimeout(updateBounds, 100);
    setTimeout(updateBounds, 500);

    // Event handler: Drag Start
    const onDragStart = (clientX, clientY) => {
        isDragging = true;
        const rect = containerEl.getBoundingClientRect();
        const mx = clientX - rect.left;
        const my = clientY - rect.top;
        grabX = mx - x;
        grabY = my - y;
        lastX = x;
        lastY = y;
        cardEl.style.transition = 'none'; // Disable any CSS transitions during physics
    };

    // Event handler: Drag Move / Mouse Move
    const onDragMove = (clientX, clientY) => {
        const rect = containerEl.getBoundingClientRect();
        const mx = clientX - rect.left;
        const my = clientY - rect.top;

        if (isDragging) {
            x = mx - grabX;
            y = my - grabY;

            // Calculate velocity based on drag distance
            vx = x - lastX;
            vy = y - lastY;
            lastX = x;
            lastY = y;
        } else {
            mouseX = mx;
            mouseY = my;
        }
    };

    // Event handler: Drag End
    const onDragEnd = () => {
        isDragging = false;
    };

    // Mouse listeners
    cardEl.addEventListener('mousedown', (e) => {
        if (e.button === 0) { // Left click only
            onDragStart(e.clientX, e.clientY);
        }
    });

    window.addEventListener('mousemove', (e) => {
        onDragMove(e.clientX, e.clientY);
    });

    window.addEventListener('mouseup', onDragEnd);

    // Touch listeners for mobile support
    cardEl.addEventListener('touchstart', (e) => {
        if (e.touches.length > 0) {
            onDragStart(e.touches[0].clientX, e.touches[0].clientY);
        }
    });

    window.addEventListener('touchmove', (e) => {
        if (e.touches.length > 0) {
            onDragMove(e.touches[0].clientX, e.touches[0].clientY);
        }
    });

    window.addEventListener('touchend', onDragEnd);

    // Main Physics & Render Loop
    const tick = () => {
        requestAnimationFrame(tick);

        if (!isDragging) {
            // Apply spring-mass-damper physics
            const dx = x - anchorX;
            const dy = y - anchorY;
            const dist = Math.sqrt(dx * dx + dy * dy) || 0.001;

            // Spring force pulls back to lanyard length
            const fSpring = -springK * (dist - cardLength);

            const ax = (dx / dist) * fSpring;
            const ay = (dy / dist) * fSpring + gravity;

            vx = (vx + ax) * damping;
            vy = (vy + ay) * damping;

            x += vx;
            y += vy;
        }

        // Calculate card rotations
        const dx = x - anchorX;
        const dy = y - anchorY;
        const dist = Math.sqrt(dx * dx + dy * dy) || 0.001;

        // Roll (rotateZ) - follows the angle of the lanyard string
        const targetRoll = Math.atan2(dx, dy);

        // Pitch & Yaw (rotateX & rotateY)
        // 1. Inertial tilt: card tilts backward/forward when moving fast
        let targetPitch = -vy * 0.4;
        let targetYaw = vx * 0.6;

        // 2. Parallax tilt: card tilts toward the cursor when hovering nearby
        const cardCenterX = x;
        const cardCenterY = y + 230; // Center is 230px down from connection point
        const toMouseX = mouseX - cardCenterX;
        const toMouseY = mouseY - cardCenterY;
        const mouseDist = Math.sqrt(toMouseX * toMouseX + toMouseY * toMouseY) || 0.001;

        if (mouseDist < 300 && !isDragging) {
            const strength = (1 - mouseDist / 300) * 18; // Max 18 degrees tilt
            targetYaw += (toMouseX / mouseDist) * strength;
            targetPitch -= (toMouseY / mouseDist) * strength;
        }

        // Smoothly interpolate current rotations to targets
        rx = rx * 0.88 + targetPitch * 0.12;
        ry = ry * 0.88 + targetYaw * 0.12;
        rz = rz * 0.88 + (targetRoll * (180 / Math.PI)) * 0.12;

        // Clamp rotations to keep it natural
        rx = Math.max(-30, Math.min(30, rx));
        ry = Math.max(-30, Math.min(30, ry));

        // Render card position (translated relative to top-center connection point) and rotation
        cardEl.style.transform = `translate3d(${x - cardWidth / 2}px, ${y}px, 0px) rotateX(${rx}deg) rotateY(${ry}deg) rotateZ(${rz}deg)`;

        // Render lanyard SVG path using local container coordinates (perfectly matched)
        const mx = (anchorX + x) / 2;
        const my = (anchorY + y) / 2;

        // String bends slightly due to gravity and drag velocity
        const ctrlX = mx - vx * 0.6;
        const ctrlY = my + 15 + Math.max(0, cardLength - dist) * 0.2;

        pathEl.setAttribute('d', `M ${anchorX} ${anchorY} Q ${ctrlX} ${ctrlY} ${x} ${y}`);
    };

    tick();

    // --------------------------------------------------------------------------
    // THEME LIGHT PULL CORD INTERACTION SECTION (VERLET ROPE PHYSICS)
    // --------------------------------------------------------------------------
    const cordEl = document.querySelector('#theme-pull-cord');
    const cordPathEl = document.querySelector('#cord-line-path');
    const handleEl = document.querySelector('#cord-handle');

    if (cordEl && cordPathEl && handleEl) {
        const numPoints = 8;
        const points = [];
        const segmentLength = 20; // 20 * 7 segments = 140px total length
        const gravity = 0.45;
        const friction = 0.982;
        const anchorX = 24; // Center of the w-12 ceiling container
        const anchorY = 0;

        // Initialize rope node positions
        for (let i = 0; i < numPoints; i++) {
            points.push({
                x: 0, // relative to anchorX
                y: i * segmentLength,
                px: 0,
                py: i * segmentLength
            });
        }

        let pulling = false;
        let dragX = 0;
        let dragY = (numPoints - 1) * segmentLength;
        let triggeredThisPull = false;
        const triggerDistance = 190; // pulled down by ~50px
        const maxPullY = 240;

        // Initialize saved theme preferences from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.body.classList.add('light-theme');
        }

        const toggleTheme = () => {
            document.body.classList.toggle('light-theme');
            const isLight = document.body.classList.contains('light-theme');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
        };

        const onPullStart = (clientX, clientY) => {
            pulling = true;
            triggeredThisPull = false;
        };

        const onPullMove = (clientX, clientY) => {
            if (!pulling) return;
            const rect = cordEl.getBoundingClientRect();
            const mx = clientX - (rect.left + anchorX);
            const my = clientY - rect.top;

            // Restrict movement to a realistic boundary zone
            dragX = Math.max(-75, Math.min(75, mx));
            dragY = Math.max(10, Math.min(maxPullY, my));

            // Pin the last node directly to the cursor drag coordinates
            const handlePoint = points[numPoints - 1];
            handlePoint.x = dragX;
            handlePoint.y = dragY;

            if (dragY >= triggerDistance && !triggeredThisPull) {
                triggeredThisPull = true;
                toggleTheme();
            }
        };

        const onPullEnd = () => {
            pulling = false;
        };

        // Attach mouse listeners
        handleEl.addEventListener('mousedown', (e) => {
            if (e.button === 0) {
                onPullStart(e.clientX, e.clientY);
            }
        });

        window.addEventListener('mousemove', (e) => {
            if (pulling) {
                onPullMove(e.clientX, e.clientY);
            } else {
                // Apply subtle swing/shake physics when cursor moves near nodes
                const rect = cordEl.getBoundingClientRect();
                const mx = e.clientX - (rect.left + anchorX);
                const my = e.clientY - rect.top;

                for (let i = 1; i < numPoints; i++) {
                    const node = points[i];
                    const dx = mx - node.x;
                    const dy = my - node.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 45) {
                        const factor = (45 - dist) / 45;
                        node.x += e.movementX * 0.15 * factor;
                        node.y += e.movementY * 0.15 * factor;
                    }
                }
            }
        });

        window.addEventListener('mouseup', onPullEnd);

        // Attach mobile touch listeners
        handleEl.addEventListener('touchstart', (e) => {
            if (e.touches.length > 0) {
                onPullStart(e.touches[0].clientX, e.touches[0].clientY);
            }
        });

        window.addEventListener('touchmove', (e) => {
            if (e.touches.length > 0) {
                onPullMove(e.touches[0].clientX, e.touches[0].clientY);
            }
        });

        window.addEventListener('touchend', onPullEnd);

        // Tick loop executing physics simulation frame-by-frame
        const tick = () => {
            // 1. Verlet Integration
            for (let i = 1; i < numPoints; i++) {
                const p = points[i];
                if (pulling && i === numPoints - 1) continue; // Pinned by drag

                const vx = (p.x - p.px) * friction;
                const vy = (p.y - p.py) * friction;

                p.px = p.x;
                p.py = p.y;

                p.x += vx;
                p.y += vy + gravity;
            }

            // 2. Constraints Solver
            const iterations = 8;
            for (let iter = 0; iter < iterations; iter++) {
                points[0].x = 0;
                points[0].y = 0;

                if (pulling) {
                    points[numPoints - 1].x = dragX;
                    points[numPoints - 1].y = dragY;
                }

                for (let i = 0; i < numPoints - 1; i++) {
                    const p1 = points[i];
                    const p2 = points[i + 1];
                    const dx = p2.x - p1.x;
                    const dy = p2.y - p1.y;
                    const dist = Math.sqrt(dx * dx + dy * dy) || 1;

                    const targetLen = segmentLength;
                    const error = targetLen - dist;
                    const percent = (error / dist) * 0.5;
                    const offsetX = dx * percent;
                    const offsetY = dy * percent;

                    if (i === 0) {
                        p2.x += offsetX * 2;
                        p2.y += offsetY * 2;
                    } else if (i === numPoints - 2 && pulling) {
                        p1.x -= offsetX * 2;
                        p1.y -= offsetY * 2;
                    } else {
                        p1.x -= offsetX;
                        p1.y -= offsetY;
                        p2.x += offsetX;
                        p2.y += offsetY;
                    }
                }
            }

            // 3. Render path coordinates and handle position
            let pathD = `M ${anchorX} ${anchorY}`;
            for (let i = 1; i < numPoints; i++) {
                pathD += ` L ${anchorX + points[i].x} ${anchorY + points[i].y}`;
            }
            cordPathEl.setAttribute('d', pathD);

            const lastPoint = points[numPoints - 1];
            handleEl.style.left = `${anchorX + lastPoint.x}px`;
            handleEl.style.top = `${anchorY + lastPoint.y + 6}px`;

            requestAnimationFrame(tick);
        };

        tick();
    }

    // --------------------------------------------------------------------------
    // MANUAL SMOOTH SCROLL ANIMATION LOOP SECTION
    // --------------------------------------------------------------------------
    // Easing: starts fast, decelerates smoothly (no sluggish ease-in delay)
    const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

    const smoothScrollToTop = (duration = 450) => {
        const startPosition = window.pageYOffset;
        let startTime = null;

        const animation = (currentTime) => {
            if (startTime === null) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const eased = easeOutCubic(progress);
            window.scrollTo(0, startPosition * (1 - eased));
            if (progress < 1) {
                requestAnimationFrame(animation);
            } else {
                window.scrollTo(0, 0); // ensure perfect landing at top
            }
        };

        requestAnimationFrame(animation);
    };

    const smoothScrollTo = (targetSelector, duration = 450) => {
        const target = document.querySelector(targetSelector);
        if (!target) return;

        // Perfect offset for the sticky navbar height
        const offset = 76;
        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        let startTime = null;

        const animation = (currentTime) => {
            if (startTime === null) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const eased = easeOutCubic(progress);
            window.scrollTo(0, startPosition + distance * eased);
            if (progress < 1) {
                requestAnimationFrame(animation);
            } else {
                window.scrollTo(0, targetPosition); // ensure perfect final landing
            }
        };

        requestAnimationFrame(animation);
    };

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        // Skip contact triggers — they open the modal, not scroll
        if (anchor.classList.contains('contact-trigger')) return;

        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            e.preventDefault();
            if (targetId === '#') {
                smoothScrollToTop(450);
            } else {
                smoothScrollTo(targetId, 450);
            }
        });
    });

    // --------------------------------------------------------------------------
    // CONTACT MODAL OPEN / CLOSE
    // --------------------------------------------------------------------------
    const contactModalEl = document.getElementById('contact-modal');
    const contactCardEl = document.getElementById('contact-card');
    const closeBtn = document.getElementById('close-modal-btn');
    const contactTriggers = document.querySelectorAll('.contact-trigger');

    if (contactModalEl && contactCardEl) {
        const openModal = () => {
            contactModalEl.classList.remove('pointer-events-none', 'opacity-0');
            contactModalEl.classList.add('opacity-100');
            setTimeout(() => {
                contactCardEl.classList.remove('scale-95', 'opacity-0');
                contactCardEl.classList.add('scale-100', 'opacity-100');
            }, 50);
        };

        const closeModal = () => {
            contactCardEl.classList.remove('scale-100', 'opacity-100');
            contactCardEl.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                contactModalEl.classList.remove('opacity-100');
                contactModalEl.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        };

        contactTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                openModal();
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        contactModalEl.addEventListener('click', (e) => {
            if (e.target === contactModalEl) {
                closeModal();
            }
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !contactModalEl.classList.contains('pointer-events-none')) {
                closeModal();
            }
        });
    }
});
