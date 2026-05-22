<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syahfalah4787 | Beginner Programmer Student Portfolio</title>
    <meta name="description" content="Professional portfolio of Syahfalah Muchtar, a XI grade Software Engineering student specializing in backend architectures and interactive interfaces.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#050505] text-[#e5e5e5] overflow-x-hidden">
    <!-- Cinematic Developer Intro/Loader (pure inline styles — zero CSS dependency) -->
    <style>
        @keyframes intro-blink{0%,100%{opacity:1}50%{opacity:0}}
        @keyframes intro-pulse{0%,100%{opacity:1}50%{opacity:.4}}
    </style>
    <div id="intro-loader" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:99999;background:#050505;display:flex;flex-direction:column;justify-content:center;align-items:center;font-family:'Courier New',monospace;font-size:12px;padding:24px;transition:opacity 0.7s ease-out;user-select:none;">
        <!-- Terminal Container -->
        <div style="max-width:460px;width:100%;display:flex;flex-direction:column;gap:16px;">
            <!-- Header bar -->
            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.05);padding-bottom:10px;color:#6b7280;font-size:10px;letter-spacing:2px;text-transform:uppercase;">
                <span style="display:flex;align-items:center;gap:8px;">
                    <span style="width:7px;height:7px;background:#22c55e;border-radius:50%;animation:intro-pulse 1.5s ease-in-out infinite;"></span>
                    sys-boot.log
                </span>
                <span style="font-weight:bold;">v1.0.0</span>
            </div>

            <!-- Terminal Logs Feed -->
            <div id="intro-logs" style="min-height:160px;display:flex;flex-direction:column;gap:10px;color:#9ca3af;font-family:'Courier New',monospace;line-height:1.7;overflow-y:auto;">
                <!-- Lines will be injected dynamically by the inline script -->
            </div>

            <!-- Progress bar -->
            <div style="width:100%;height:2px;background:rgba(255,255,255,0.05);border-radius:4px;overflow:hidden;margin-top:12px;">
                <div id="intro-progress" style="height:100%;width:0%;background:#fff;transition:width 0.3s ease;"></div>
            </div>
        </div>

        <!-- Skip Button -->
        <button id="intro-skip" style="position:fixed;bottom:24px;right:24px;color:#6b7280;background:none;border:none;border-bottom:1px solid transparent;cursor:pointer;font-family:'Courier New',monospace;font-size:9px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;padding:0 0 2px 0;transition:color 0.3s,border-color 0.3s;" onmouseover="this.style.color='#fff';this.style.borderBottomColor='rgba(255,255,255,0.2)'" onmouseout="this.style.color='#6b7280';this.style.borderBottomColor='transparent'">
            SKIP INTRO &rarr;
        </button>
    </div>
    <!-- Intro Boot Script (runs immediately after loader element is parsed) -->
    <script>
    (function() {
        var loader = document.getElementById('intro-loader');
        var logsContainer = document.getElementById('intro-logs');
        var progressBar = document.getElementById('intro-progress');
        var skipBtn = document.getElementById('intro-skip');

        if (!loader || !logsContainer || !progressBar) return;

        var isLocal = window.location.hostname === 'localhost' || 
                      window.location.hostname === '127.0.0.1' || 
                      window.location.hostname.endsWith('.test') || 
                      window.location.hostname.endsWith('.local');
        var isForced = window.location.search.indexOf('force-intro') !== -1 || window.location.search.indexOf('intro=true') !== -1;

        var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches && !isForced;
        var hasLoaded = sessionStorage.getItem('intro-loaded') && !isLocal && !isForced;

        function finishIntro() {
            sessionStorage.setItem('intro-loaded', 'true');
            var flickerCount = 0;
            var flicker = setInterval(function() {
                loader.style.opacity = flickerCount % 2 === 0 ? '0.5' : '1';
                flickerCount++;
                if (flickerCount >= 4) {
                    clearInterval(flicker);
                    loader.style.opacity = '0';
                    loader.style.pointerEvents = 'none';
                    setTimeout(function() { loader.remove(); }, 700);
                }
            }, 70);
        }

        if (hasLoaded || prefersReducedMotion) {
            loader.remove();
            return;
        }

        var logs = [
            { text: 'initializing syahfalah4787.dev ...', type: 'log', progress: 12 },
            { text: 'loading theme engine configurations ...', type: 'log', progress: 25 },
            { text: 'establishing handshake with api.github.com ...', type: 'log', progress: 40 },
            { text: 'warn: cached data expired \u2014 refetching ...', type: 'warn', progress: 52 },
            { text: 'resolved: fresh data loaded successfully.', type: 'resolve', progress: 62 },
            { text: 'compiling verlet physics engine ...', type: 'log', progress: 75 },
            { text: 'mounting interface components ...', type: 'log', progress: 88 },
            { text: 'status: all systems ready.', type: 'success', progress: 100 }
        ];

        var currentStep = 0;
        var cursorEl = document.createElement('span');
        cursorEl.style.cssText = 'display:inline-block;width:6px;height:13px;background:rgba(255,255,255,0.7);margin-left:2px;vertical-align:middle;animation:intro-blink 0.8s step-end infinite;';

        function typeLog(item, callback) {
            var logLine = document.createElement('div');
            logLine.style.cssText = 'display:flex;align-items:flex-start;gap:8px;';

            var arrow = document.createElement('span');
            arrow.style.cssText = 'flex-shrink:0;font-weight:bold;';
            if (item.type === 'warn') { arrow.style.color = '#eab308cc'; arrow.textContent = '!'; }
            else if (item.type === 'resolve') { arrow.style.color = '#22c55ecc'; arrow.textContent = '\u2713'; }
            else if (item.type === 'success') { arrow.style.color = '#22c55e'; arrow.textContent = '>'; }
            else { arrow.style.color = '#fff'; arrow.textContent = '>'; }
            logLine.appendChild(arrow);

            var textSpan = document.createElement('span');
            textSpan.style.fontFamily = "'Courier New',monospace";
            if (item.type === 'warn') textSpan.style.color = '#eab308b3';
            else if (item.type === 'resolve') textSpan.style.color = '#22c55eb3';
            else if (item.type === 'success') textSpan.style.color = '#fff';
            else textSpan.style.color = '#9ca3af';
            logLine.appendChild(textSpan);

            logsContainer.appendChild(logLine);
            logsContainer.scrollTop = logsContainer.scrollHeight;

            var charIndex = 0;
            var text = item.text;
            textSpan.appendChild(cursorEl);

            function typeChar() {
                if (charIndex < text.length) {
                    textSpan.insertBefore(document.createTextNode(text.charAt(charIndex)), cursorEl);
                    charIndex++;
                    setTimeout(typeChar, 12 + Math.random() * 20);
                } else {
                    if (cursorEl.parentNode === textSpan) textSpan.removeChild(cursorEl);
                    if (item.type === 'success') {
                        textSpan.innerHTML = text.replace('all systems ready', '<span style="color:#4ade80;font-weight:bold;text-transform:uppercase;">ALL SYSTEMS READY</span>');
                    }
                    progressBar.style.width = item.progress + '%';
                    var delay = item.type === 'warn' ? 400 : item.type === 'resolve' ? 200 : 200;
                    setTimeout(callback, delay);
                }
            }
            typeChar();
        }

        function runSequence() {
            if (currentStep < logs.length) {
                typeLog(logs[currentStep], function() {
                    currentStep++;
                    runSequence();
                });
            } else {
                setTimeout(finishIntro, 500);
            }
        }

        if (skipBtn) {
            skipBtn.addEventListener('click', function(e) {
                e.preventDefault();
                finishIntro();
            });
        }

        setTimeout(runSequence, 300);
    })();
    </script>

    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-[100] w-full backdrop-blur-md bg-[#050505]/80 border-b border-white/5 py-4 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-12 flex justify-between items-center">
            <!-- Left: Brand Logo -->
            <a href="#" class="text-lg font-bold tracking-wider text-white hover:opacity-80 transition-opacity">
                SYAHFALAH4787<span class="text-gray-500 font-mono">.DEV</span>
            </a>

            <!-- Center: Menu -->
            <div class="hidden md:flex gap-8 text-xs font-semibold tracking-widest uppercase text-gray-400">
                <a href="#" class="hover:text-white transition-colors">Home</a>
                <a href="#about" class="hover:text-white transition-colors">About</a>
                <a href="#projects" class="hover:text-white transition-colors">Projects</a>
                <a href="#journey" class="hover:text-white transition-colors">Journey</a>
                <a href="https://github.com/{{ env('GITHUB_USERNAME', 'syahfalah4787') }}" target="_blank" class="hover:text-white transition-colors">GitHub</a>
            </div>

            <!-- Right: Contact CTA Button with simple border -->
            <div>
                <a href="#" class="contact-trigger px-5 py-2 text-xs font-bold tracking-widest uppercase border border-white/10 hover:border-white/40 rounded-lg text-white transition-all duration-300">
                    Contact Me
                </a>
            </div>
        </div>
    </nav>

    <!-- Hanging Theme Pull Switch Cord -->
    <div id="theme-pull-cord" class="fixed top-0 right-8 md:right-16 z-[999] w-12 h-[350px] flex flex-col items-center select-none" style="pointer-events: none;">
        <!-- Ceiling Plate (allows clicks to initiate drag if cursor hits plate/handle) -->
        <div class="w-6 h-1.5 bg-slate-800 rounded-b-md shadow-md" style="pointer-events: auto;"></div>

        <!-- SVG Rope Line -->
        <svg class="absolute top-[6px] left-0 w-full h-full overflow-visible" style="pointer-events: none;">
            <path id="cord-line-path" d="" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" />
        </svg>

        <!-- Pull Handle (minimalist cylinder bead) -->
        <div id="cord-handle" class="absolute w-5 h-5 bg-gradient-to-b from-slate-700 to-slate-900 border border-white/20 rounded-full shadow-[0_0_12px_rgba(255,255,255,0.05)] cursor-grab active:cursor-grabbing flex items-center justify-center" style="pointer-events: auto; transform: translate(-50%, -50%); transition: background-color 0.15s, border-color 0.15s;">
            <!-- Little metallic dot accent inside handle -->
            <div class="w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_6px_#ffffff]"></div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative min-h-[calc(100vh-76px)] flex items-center justify-center overflow-visible py-12 lg:py-0 select-none z-30">
        <!-- Background watermark -->
        <div class="absolute inset-0 z-0 flex items-center justify-center opacity-5 select-none pointer-events-none">
            <h1 class="text-[12vw] font-bold text-white tracking-tighter">PORTFOLIO</h1>
        </div>

        <!-- Responsive Grid Layout -->
        <div class="relative z-20 w-full max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <!-- Left Column: Interactive ID Card Name Tag -->
            <div class="lg:col-span-5 flex justify-center items-center relative">
                <div id="hero-interactive-container" class="relative w-[340px] h-[600px] flex items-center justify-center overflow-visible">

                    <!-- SVG Lanyard String -->
                    <svg id="lanyard-svg" class="absolute inset-0 w-full h-full pointer-events-none overflow-visible">
                        <!-- Glowing lanyard line -->
                        <path id="lanyard-path" d="" fill="none" stroke="url(#lanyard-glow)" stroke-width="2" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="lanyard-glow" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#8E8E93" />
                                <stop offset="100%" stop-color="#3A3A3C" />
                            </linearGradient>
                        </defs>
                    </svg>

                    <!-- Anchor node -->
                    <div id="lanyard-anchor" class="absolute top-[20px] left-1/2 -translate-x-1/2 w-3 h-3 bg-white/20 rounded-full border border-white/30 shadow-[0_0_8px_rgba(255,255,255,0.2)] pointer-events-none"></div>

                    <!-- The ID Card -->
                    <div id="id-card" class="absolute left-0 top-0 cursor-grab active:cursor-grabbing select-none" style="transform-style: preserve-3d; width: 310px; height: 460px; transform: translate3d(15px, 140px, 0px);">

                        <!-- Clip at the top of the card connecting it to the lanyard -->
                        <div class="absolute -top-[22px] left-1/2 -translate-x-1/2 w-12 h-6 bg-[#1a1a1a] rounded border border-white/5 flex items-center justify-center shadow-lg" style="transform: translateZ(10px);">
                            <div class="w-5 h-2 bg-[#050505] rounded-full border border-white/5"></div>
                        </div>

                        <!-- Main Card Body (Matte Black / Frosted Glass) -->
                        <div class="w-full h-full rounded-2xl border border-white/5 backdrop-blur-xl bg-[#0d0d0c]/85 p-6 flex flex-col justify-between shadow-[0_10px_35px_rgba(0,0,0,0.4)] relative overflow-hidden">

                            <!-- Elegant side border accent line -->
                            <div class="absolute top-0 left-0 w-[2px] h-full bg-white/10"></div>

                            <!-- Top Ribbon info -->
                            <div class="flex justify-between items-center text-[9px] font-bold tracking-widest text-gray-500 border-b border-white/5 pb-3">
                                <span>STUDENT BADGE</span>
                                <span class="text-white flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    ACTIVE
                                </span>
                            </div>

                            <!-- Profile Photo -->
                            <div class="flex flex-col items-center mt-4">
                                <div class="relative w-28 h-28 rounded-xl p-[1px] bg-white/10 shadow-lg">
                                    <div class="w-full h-full rounded-[10px] overflow-hidden bg-[#050505] flex items-center justify-center">
                                        @if(!empty($profile['avatar_url']))
                                            <img src="{{ $profile['avatar_url'] }}" alt="Profile Photo" class="w-full h-full object-cover pointer-events-none select-none" />
                                        @else
                                            <svg class="w-14 h-14 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-tr from-white/5 to-transparent pointer-events-none rounded-xl"></div>
                                </div>

                                <!-- User name and role -->
                                <h3 class="text-lg font-bold mt-4 tracking-wide text-white font-sans text-center">
                                    {{ $profile['name'] }}
                                </h3>
                                <p class="text-[9px] text-gray-400 mt-1 font-semibold uppercase tracking-widest text-center">
                                    {{ $profile['bio'] }}
                                </p>
                            </div>

                            <!-- Statistics & Tech Tags -->
                            <div class="bg-white/5 rounded-xl p-3 border border-white/5 flex justify-around items-center text-center mt-3" style="transform: translateZ(15px);">
                                <div>
                                    <span class="block text-xs font-bold text-white font-mono">{{ $profile['repos'] }}</span>
                                    <span class="text-[8px] text-gray-500 uppercase tracking-wider">Repos</span>
                                </div>
                                <div class="w-px h-6 bg-white/10"></div>
                                <div>
                                    <span class="block text-xs font-bold text-white font-mono">{{ $profile['followers'] }}</span>
                                    <span class="text-[8px] text-gray-500 uppercase tracking-wider">Followers</span>
                                </div>
                                <div class="w-px h-6 bg-white/10"></div>
                                <div>
                                    <span class="block text-xs font-bold text-white font-mono">XI</span>
                                    <span class="text-[8px] text-gray-500 uppercase tracking-wider">Grade</span>
                                </div>
                            </div>

                            <!-- Barcode and Brand info -->
                            <div class="border-t border-white/5 pt-3 mt-4 flex items-center justify-between">
                                <div class="flex flex-col gap-0.5 opacity-40">
                                    <div class="flex gap-[2px] items-end h-8">
                                        <span class="w-[2px] h-full bg-white"></span>
                                        <span class="w-[1px] h-3/4 bg-white"></span>
                                        <span class="w-[3px] h-full bg-white"></span>
                                        <span class="w-[1px] h-1/2 bg-white"></span>
                                        <span class="w-[2px] h-3/4 bg-white"></span>
                                        <span class="w-[4px] h-full bg-white"></span>
                                        <span class="w-[1px] h-full bg-white"></span>
                                        <span class="w-[2px] h-1/2 bg-white"></span>
                                        <span class="w-[1px] h-3/4 bg-white"></span>
                                        <span class="w-[3px] h-full bg-white"></span>
                                        <span class="w-[1px] h-1/2 bg-white"></span>
                                    </div>
                                    <span class="text-[7px] font-mono text-center tracking-widest text-gray-500">DEV-XI-PPLG</span>
                                </div>

                                <div class="text-right text-[8px] text-gray-500 font-mono flex flex-col justify-end">
                                    <span class="font-bold text-white">PPLG DEPT</span>
                                    <span>SYS-OP: ROSS.V1</span>
                                </div>
                            </div>

                            <div class="shimmer-effect"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Info & Greeting -->
            <div class="lg:col-span-7 flex flex-col justify-center text-center lg:text-left">
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-3 bg-white/5 px-3 py-1.5 rounded-full w-fit mx-auto lg:mx-0 border border-white/5">
                    Grade XI Software Engineering Student
                </span>

                <h2 class="text-4xl md:text-6xl font-bold mb-6 text-white leading-tight">
                    Hi, I'm <span class="text-white font-mono">{{ $profile['name'] }}</span>
                </h2>
                <p class="text-gray-400 text-base md:text-lg leading-relaxed mb-8 max-w-2xl font-sans">
                    A vocational high school student exploring software development, backend scripting, database layouts, and basic systems. I enjoy making small tools, automating tasks, and figuring out how things work under the hood.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#about" class="px-8 py-4 bg-white text-black font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300 text-center text-sm tracking-wider uppercase">
                        Explore My Projects
                    </a>
                    <a href="https://github.com/{{ env('GITHUB_USERNAME', 'syahfalah4787') }}" target="_blank" class="px-8 py-4 border border-white/10 rounded-xl hover:bg-white/5 hover:border-white/30 transition-all duration-300 flex items-center justify-center gap-2 text-center text-white text-sm tracking-wider uppercase">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        GitHub Profile
                    </a>
                </div>

              
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 px-6 relative md:px-12 max-w-7xl mx-auto border-t border-white/5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
            <div>
                <span class="text-xs font-mono tracking-widest text-gray-500 block mb-2">// 01. INTRODUCTION</span>
                <h2 class="text-3xl font-bold mb-6 text-white">About Me</h2>
                <p class="text-gray-400 text-base leading-relaxed mb-8">
                    I am currently in Grade 11 majoring in Software Engineering (PPLG) at vocational high school. I got into programming because I wanted to understand how apps and sites are built. Right now, I'm mostly focused on coding with PHP, Node.js, and C++, setting up local databases, and experimenting with scripts. I don't know everything yet, but I love solving bugs and learning something new every day.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="contact-trigger px-6 py-3 bg-white text-black font-semibold rounded-lg hover:bg-gray-200 transition-all duration-300 text-xs tracking-wider uppercase">Contact Me</a>
                    <a href="https://github.com/{{ env('GITHUB_USERNAME', 'syahfalah4787') }}" target="_blank" class="px-6 py-3 border border-white/10 rounded-lg hover:bg-white/5 transition-all duration-300 text-white text-xs tracking-wider uppercase">View GitHub</a>
                </div>
            </div>

            <!-- Grouped Tech Stack by Confidence Levels -->
            <div class="glass p-8 rounded-2xl border border-white/5 bg-[#0d0d0c]/40 flex flex-col gap-6">
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">// Comfortable With</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            PHP
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4" />
                            </svg>
                            SQL (MySQL)
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            HTML / CSS
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" />
                            </svg>
                            C++ (Basics)
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">// Currently Learning</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Laravel
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            Node.js
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7a3 3 0 100-6 3 3 0 000 6zm0 10a3 3 0 100-6 3 3 0 000 6zm8-10a3 3 0 100-6 3 3 0 000 6zm-8 4v-4m0 4v4m0-4h8" />
                            </svg>
                            Git & GitHub
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">// Interested In</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Linux & Bash Scripts
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Basic Cybersecurity
                        </span>
                        <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/5 rounded-lg text-xs font-mono text-white">
                            <svg class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            API Integration
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-t border-white/5">
        <div class="mb-12">
            <span class="text-xs font-mono tracking-widest text-gray-500 block mb-2">// 02. CODE REPOSITORIES</span>
            <h2 class="text-3xl font-bold mb-4 text-white">Featured Projects</h2>
            <p class="text-gray-400">Live data fetched directly from GitHub API.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($projects as $project)
                @if(is_array($project))
                    <div class="glass overflow-hidden rounded-2xl group hover:border-white/20 transition-all duration-300 flex flex-col h-full bg-[#0d0d0c]/30">
                        <!-- Project Showcase Image -->
                        <div class="relative w-full aspect-[16/9] bg-white/5 border-b border-white/5 overflow-hidden">
                            <img src="{{ $project['image'] ?? '' }}" 
                                 alt="{{ $project['name'] ?? 'Project' }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <!-- Beautiful Gradient Fallback Placeholder -->
                            <div class="absolute inset-0 flex flex-col justify-between p-5 bg-gradient-to-br from-zinc-950 to-[#0c0c0b] select-none" style="display: none;">
                                <div class="flex justify-between items-start">
                                    <span class="text-[9px] font-mono tracking-widest text-zinc-600 uppercase">{{ $project['language'] ?? 'CODE' }}</span>
                                    <div class="p-1.5 rounded bg-white/5 border border-white/5 text-zinc-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-[9px] font-mono text-zinc-500 block mb-0.5">// NO IMAGE PREVIEW</span>
                                    <h4 class="text-xs font-bold text-zinc-400 font-mono tracking-tight uppercase truncate">{{ $project['name'] ?? 'untitled' }}</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 flex flex-col flex-grow justify-between">
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-[9px] font-mono text-zinc-500 uppercase tracking-widest bg-white/5 px-2.5 py-1 rounded-md border border-white/5">
                                        {{ $project['language'] ?? 'Code' }}
                                    </span>
                                    <div class="flex items-center gap-1 text-gray-500 text-xs">
                                        <span>⭐</span>
                                        <span class="font-mono text-[10px]">{{ $project['stars'] ?? 0 }}</span>
                                    </div>
                                </div>

                                <h3 class="text-base font-bold mb-2 text-white group-hover:text-white transition-colors">{{ $project['name'] ?? 'Project' }}</h3>
                                <p class="text-gray-400 text-xs mb-6 line-clamp-3 leading-relaxed">{{ $project['description'] ?? '' }}</p>
                            </div>

                            <div class="flex justify-between items-center border-t border-white/5 pt-4">
                                <span class="text-[9px] font-mono text-gray-500 uppercase tracking-widest">Repository</span>
                                <a href="{{ $project['url'] ?? '#' }}" target="_blank" class="text-white hover:underline text-xs font-semibold transition-colors flex items-center gap-1 group/btn">
                                    View Repo 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform duration-300 group-hover/btn:translate-x-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Learning Journey Section -->
    <section id="journey" class="py-24 px-6 md:px-12 max-w-7xl mx-auto border-t border-white/5">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Left Column: Section Intro -->
            <div class="lg:col-span-5">
                <span class="text-xs font-mono tracking-widest text-gray-500 block mb-2">// 03. LEARNING ROUTE</span>
                <h2 class="text-3xl font-bold mb-6 text-white">My Journey</h2>
                <p class="text-gray-400 text-base leading-relaxed mb-6">
                    A timeline of how I started learning technology and programming in high school. I try to focus on hands-on coding rather than just reading theory.
                </p>
                <div class="glass p-6 rounded-xl border border-white/5 bg-[#0d0d0c]/30">
                    <span class="text-xs font-bold text-white block mb-2">⚡ Recent Experiment</span>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        Currently playing around with local Linux systems (Debian) inside virtual machines to learn shell scripting and basic web server setup (Nginx).
                    </p>
                </div>
            </div>

            <!-- Right Column: Minimalist Timeline -->
            <div class="lg:col-span-7 space-y-8 relative before:absolute before:left-3.5 before:top-2 before:bottom-2 before:w-px before:bg-white/5">
                <!-- Timeline item 1 -->
                <div class="relative pl-10 group">
                    <div class="absolute left-2 top-2.5 w-3 h-3 rounded-full bg-zinc-800 border border-white/10 group-hover:bg-white transition-colors duration-300"></div>
                    <span class="text-[10px] font-bold text-gray-500 font-mono block mb-1">GRADE X (10) — VOCATIONAL HIGH SCHOOL</span>
                    <h3 class="text-white font-bold text-sm mb-2">Introduction to Programming & Logic</h3>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        Started my vocational path in PPLG (Software Engineering). Learned programming fundamentals, algorithms, and logical thinking using basic C++. Created several CLI-based calculators and interactive command-line tools.
                    </p>
                </div>

                <!-- Timeline item 2 -->
                <div class="relative pl-10 group">
                    <div class="absolute left-2 top-2.5 w-3 h-3 rounded-full bg-zinc-800 border border-white/10 group-hover:bg-white transition-colors duration-300"></div>
                    <span class="text-[10px] font-bold text-gray-500 font-mono block mb-1">GRADE XI (11) — CURRENT FOCUS</span>
                    <h3 class="text-white font-bold text-sm mb-2">Dynamic Web Apps & Databases</h3>
                    <p class="text-gray-400 text-xs leading-relaxed">
                        Moving into backend development. Studying PHP, learning database design using MySQL, and currently learning Laravel as our first MVC web framework. Pushing repositories to GitHub regularly to manage code structure.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 bg-[#050505] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                <!-- Branding Column -->
                <div class="md:col-span-6 flex flex-col gap-4 text-left">
                    <a href="#" class="text-lg font-bold tracking-wider text-white hover:opacity-80 transition-opacity">
                        SYAHFALAH4787<span class="text-gray-500 font-mono">.DEV</span>
                    </a>
                    <p class="text-gray-400 text-xs leading-relaxed max-w-sm">
                        Grade XI Software Engineering student exploring software development, backend scripting, database layouts, and basic systems. Learning by building.
                    </p>
                </div>

                <!-- Navigation Links Column -->
                <div class="md:col-span-3 flex flex-col gap-4 text-left">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest">// NAVIGATION</h4>
                    <div class="flex flex-col gap-2 text-xs text-gray-400">
                        <a href="#" class="hover:text-white transition-colors">Home</a>
                        <a href="#about" class="hover:text-white transition-colors">About</a>
                        <a href="#projects" class="hover:text-white transition-colors">Projects</a>
                        <a href="#journey" class="hover:text-white transition-colors">Journey</a>
                    </div>
                </div>

                <!-- Socials & Platforms Column -->
                <div class="md:col-span-3 flex flex-col gap-4 text-left">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest">// FIND ME ON</h4>
                    <div class="flex flex-col gap-2 text-xs text-gray-400">
                        <a href="https://github.com/{{ env('GITHUB_USERNAME', 'syahfalah4787') }}" target="_blank" class="flex items-center gap-2 hover:text-white transition-colors group">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                            GitHub
                        </a>
                        <a href="https://linkedin.com/in/syahfalah-fatah-28a17b28a" target="_blank" class="flex items-center gap-2 hover:text-white transition-colors group">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                            LinkedIn
                        </a>
                        <a href="https://linkedin.com/in/syahfalah-fatah-28a17b28a" target="_blank" class="flex items-center gap-2 hover:text-white transition-colors group">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                            Instagram
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright / Thin Bar -->
            <div class="mt-16 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Syahfalah Muchtar. Built with Laravel & Vite.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Minimalist Contact Modal -->
    <div id="contact-modal" class="fixed inset-0 z-[1000] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 bg-black/60 backdrop-blur-md">
        <!-- Modal Card -->
        <div id="contact-card" class="glass max-w-xl w-full mx-4 p-6 md:p-8 rounded-2xl border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform scale-95 opacity-0 transition-all duration-300 bg-[#0d0d0c]/95 max-h-[90vh] overflow-y-auto scrollbar-thin">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6 border-b border-white/5 pb-4">
                <span class="text-[10px] font-mono tracking-widest text-gray-500 uppercase">// CONNECT & COLLABORATE</span>
                <button id="close-modal-btn" class="text-gray-400 hover:text-white transition-colors text-lg font-bold select-none cursor-pointer focus:outline-none">&times;</button>
            </div>
            <!-- Options List (2-Column Grid) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Email -->
                <a href="mailto:syahfalah4787@gmail.com" class="flex items-center justify-between p-4 rounded-xl border border-white/5 hover:border-white/20 hover:bg-white/5 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-white">Email</span>
                    </div>
                    <span class="text-[10px] text-gray-500 font-mono group-hover:text-gray-300 transition-colors">Direct Mail</span>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/6282276944787" target="_blank" class="flex items-center justify-between p-4 rounded-xl border border-white/5 hover:border-white/20 hover:bg-white/5 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="text-sm font-semibold text-white">WhatsApp</span>
                    </div>
                    <span class="text-[10px] text-gray-500 font-mono group-hover:text-gray-300 transition-colors">Direct Chat</span>
                </a>

                <!-- LinkedIn -->
                <a href="https://linkedin.com/in/syahfalah-fatah-28a17b28a" target="_blank" class="flex items-center justify-between p-4 rounded-xl border border-white/5 hover:border-white/20 hover:bg-white/5 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        <span class="text-sm font-semibold text-white">LinkedIn</span>
                    </div>
                    <span class="text-[10px] text-gray-500 font-mono group-hover:text-gray-300 transition-colors">Connect</span>
                </a>

                <!-- GitHub -->
                <a href="https://github.com/{{ env('GITHUB_USERNAME', 'syahfalah4787') }}" target="_blank" class="flex items-center justify-between p-4 rounded-xl border border-white/5 hover:border-white/20 hover:bg-white/5 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-semibold text-white">GitHub</span>
                    </div>
                    <span class="text-[10px] text-gray-500 font-mono group-hover:text-gray-300 transition-colors">Repositories</span>
                </a>

                <!-- Instagram -->
                <a href="https://instagram.com/syahfalah_" target="_blank" class="flex items-center justify-between p-4 rounded-xl border border-white/5 hover:border-white/20 hover:bg-white/5 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                        <span class="text-sm font-semibold text-white">Instagram</span>
                    </div>
                    <span class="text-[10px] text-gray-500 font-mono group-hover:text-gray-300 transition-colors">Follow</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
