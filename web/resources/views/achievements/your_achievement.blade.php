@extends('layouts.elearningmain')

@section('content')

<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
body {
    margin: 0 !important;
    padding: 0 !important;
    background: linear-gradient(to right, #000428, #004e92) !important;
}

.filter-btn.active {
    background-color: #facc15;
    color: #000;
}

/* Hide native scrollbar */
.scroll-container::-webkit-scrollbar {
    display: none;
}

.scroll-container {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}

/* Scroll container styles */
.scroll-container {
    overflow-x: auto;
    display: flex;
    flex-wrap: nowrap;
    /* no wrap */
    -webkit-overflow-scrolling: touch;
    /* smooth on iOS */
}

/* Card fixed width, no shrink */
.badge-card {
    flex-shrink: 0;
    width: 16rem;
    /* 256px */
}

/* Arrow buttons styling */
.arrow-btn {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 9999px;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
    color: white;
}

.arrow-btn:hover {
    background-color: rgba(255, 255, 255, 0.6);
    color: black;
}
</style>

<div class="main-content min-h-screen py-12 px-6">
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold mb-10 text-center text-white tracking-wide">
            🏆 Your Achievements
        </h1>

        @php
        $badges = [];
        $streaks = [];

        foreach ($rawResults['rawResults'] as $item) {
        $entry = [
        'name' => $item['name'] ?? 'Unnamed',
        'desc' => (bool) $item['unlocked']
        ? '🎉 Congratulations! You unlocked this reward!'
        : $item['description'],
        'icon' => $item['icon'] ?? 'fa-award',
        'type' => $item['type'] ?? '',
        'color' => ($item['type'] ?? '') === 'badge'
        ? 'bg-gradient-to-br from-green-400 to-green-600'

        : 'bg-gradient-to-br from-yellow-300 to-yellow-400',
        'unlocked' => (bool) $item['unlocked']
        ];

        if ($item['type'] === 'streak') {
        $streaks[] = $entry;
        } else {
        $badges[] = $entry;
        }
        }
        @endphp

        <!-- Filter Buttons -->
        <div class="flex justify-end mb-6">
            <div class="flex gap-3">
                <button onclick="filterBadges('all', event)"
                    class="filter-btn px-4 py-2 rounded bg-white text-black font-bold active">All</button>
                <button onclick="filterBadges('unlocked', event)"
                    class="filter-btn px-4 py-2 rounded bg-white text-black font-bold">Unlocked</button>
                <button onclick="filterBadges('locked', event)"
                    class="filter-btn px-4 py-2 rounded bg-white text-black font-bold">Locked</button>
            </div>
        </div>

        <!-- Streaks Section -->
        <h2 class="text-2xl font-bold text-white mb-4 flex items-center justify-between">
            <span>🔥 Streaks</span>
            <div class="flex gap-2">
                <button id="scrollLeftStreaks" class="arrow-btn" aria-label="Scroll Left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="scrollRightStreaks" class="arrow-btn" aria-label="Scroll Right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </h2>

        <div id="streaksScroll" class="scroll-container space-x-6 px-6 mb-12">
            @forelse ($streaks as $streak)
            @php
            $cardStyle = $streak['unlocked']
            ? $streak['color'] . ' text-white shadow-xl'
            : 'bg-gray-100 text-gray-800 border border-gray-300';
            $badgeTitle = $streak['unlocked'] ? '' : 'title="Complete to unlock!"';
            $status = $streak['unlocked'] ? 'unlocked' : 'locked';
            @endphp

            <div class="badge-card relative p-6 rounded-2xl flex flex-col items-center justify-center transition transform hover:scale-105 duration-300 ease-in-out {{ $cardStyle }} badge-card"
                data-aos="fade-up" data-status="{{ $status }}" data-type="streak" {!! $badgeTitle !!}>
                <div class="w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-md">
                    <i class="fas {{ $streak['icon'] }} text-black text-5xl font-extrabold"></i>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-xl font-bold">{{ $streak['name'] }}</p>
                    <p class="text-sm mt-1">{{ $streak['desc'] }}</p>
                </div>

                <span class="absolute top-2 right-2 text-xs font-bold px-3 py-1 rounded-full
                            {{ $streak['unlocked'] ? 'bg-white text-green-600' : 'bg-gray-400 text-white' }}">
                    <i class="fas {{ $streak['unlocked'] ? 'fa-lock-open' : 'fa-lock' }}"></i>
                    {{ $streak['unlocked'] ? 'Unlocked' : 'Locked' }}
                </span>
            </div>
            @empty
            <p class="text-white">No streaks found.</p>
            @endforelse
        </div>

        <!-- Badges Section -->
        <h2 class="text-2xl font-bold text-white mb-4 flex items-center justify-between">
            <span>🏅 Badges</span>
            <div class="flex gap-2">
                <button id="scrollLeftBadges" class="arrow-btn" aria-label="Scroll Left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="scrollRightBadges" class="arrow-btn" aria-label="Scroll Right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </h2>

        <div id="badgesScroll" class="scroll-container space-x-6 px-6">
            @forelse ($badges as $badge)
            @php
            $cardStyle = $badge['unlocked']
            ? $badge['color'] . ' text-white shadow-xl'
            : 'bg-gray-100 text-gray-800 border border-gray-300';
            $badgeTitle = $badge['unlocked'] ? '' : 'title="Complete to unlock!"';
            $status = $badge['unlocked'] ? 'unlocked' : 'locked';
            @endphp

            <div class="badge-card relative p-6 rounded-2xl flex flex-col items-center justify-center transition transform hover:scale-105 duration-300 ease-in-out {{ $cardStyle }} badge-card"
                data-aos="fade-up" data-status="{{ $status }}" data-type="badge" {!! $badgeTitle !!}>
                <div class="w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-md">
                    <i class="fas {{ $badge['icon'] }} text-black text-5xl font-extrabold"></i>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-xl font-bold">{{ $badge['name'] }}</p>
                    <p class="text-sm mt-1">{{ $badge['desc'] }}</p>
                </div>

                <span class="absolute top-2 right-2 text-xs font-bold px-3 py-1 rounded-full
                            {{ $badge['unlocked'] ? 'bg-white text-green-600' : 'bg-gray-400 text-white' }}">
                    <i class="fas {{ $badge['unlocked'] ? 'fa-lock-open' : 'fa-lock' }}"></i>
                    {{ $badge['unlocked'] ? 'Unlocked' : 'Locked' }}
                </span>
            </div>
            @empty
            <p class="text-white">No badges found.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<!-- Canvas Confetti CDN -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

<script>
AOS.init({
    duration: 800,
    once: true
});

// Shared direction state per container id for auto-scroll
const scrollDirections = {};

function filterBadges(filter, event) {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    const cards = document.querySelectorAll('.badge-card');
    cards.forEach(card => {
        const status = card.getAttribute('data-status');
        if (filter === 'all' || status === filter) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function scrollContainerLeft(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        const scrollAmount = container.clientWidth / 2;
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
        restartAutoScroll(containerId);
    }
}

function scrollContainerRight(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        const scrollAmount = container.clientWidth / 2;
        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
        restartAutoScroll(containerId);
    }
}

// Helper to resume auto-scroll after 2 seconds pause
function restartAutoScroll(containerId) {
    scrollDirections[containerId] = 0;
    if (window.autoScrollTimeouts && window.autoScrollTimeouts[containerId]) {
        clearTimeout(window.autoScrollTimeouts[containerId]);
    } else {
        window.autoScrollTimeouts = window.autoScrollTimeouts || {};
    }

    window.autoScrollTimeouts[containerId] = setTimeout(() => {
        scrollDirections[containerId] = 1;
    }, 2000);
}

function autoScroll(containerId, speed = 0.5) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (!(containerId in scrollDirections)) {
        scrollDirections[containerId] = 1;
    }

    function step() {
        if (scrollDirections[containerId] !== 0) {
            container.scrollLeft += scrollDirections[containerId] * speed;

            if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                scrollDirections[containerId] = -1;
            } else if (container.scrollLeft <= 0) {
                scrollDirections[containerId] = 1;
            }
        }
        requestAnimationFrame(step);
    }
    step();

    container.addEventListener('mouseenter', () => {
        scrollDirections[containerId] = 0;
    });
    container.addEventListener('mouseleave', () => {
        if (container.scrollLeft <= 0) scrollDirections[containerId] = 1;
        else if (container.scrollLeft + container.clientWidth >= container.scrollWidth) scrollDirections[
            containerId] = -1;
        else scrollDirections[containerId] = 1;
    });
}

// Confetti function to celebrate unlocked badges/streaks on page load
function celebrateConfetti() {
    // Run confetti bursts from multiple angles
    const duration = 3000;
    const animationEnd = Date.now() + duration;
    const defaults = {
        startVelocity: 30,
        spread: 360,
        ticks: 60,
        zIndex: 1000
    };

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    (function frame() {
        const timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) return;

        const particleCount = 50 * (timeLeft / duration);

        // Confetti from left
        confetti(Object.assign({}, defaults, {
            particleCount,
            origin: {
                x: randomInRange(0.1, 0.3),
                y: Math.random() - 0.2
            }
        }));

        // Confetti from right
        confetti(Object.assign({}, defaults, {
            particleCount,
            origin: {
                x: randomInRange(0.7, 0.9),
                y: Math.random() - 0.2
            }
        }));

        requestAnimationFrame(frame);
    })();
}

window.addEventListener('DOMContentLoaded', () => {
    // Attach arrow button events
    document.getElementById('scrollLeftStreaks').addEventListener('click', () => {
        scrollContainerLeft('streaksScroll');
    });
    document.getElementById('scrollRightStreaks').addEventListener('click', () => {
        scrollContainerRight('streaksScroll');
    });
    document.getElementById('scrollLeftBadges').addEventListener('click', () => {
        scrollContainerLeft('badgesScroll');
    });
    document.getElementById('scrollRightBadges').addEventListener('click', () => {
        scrollContainerRight('badgesScroll');
    });

    // Start auto-scroll
    autoScroll('streaksScroll');
    autoScroll('badgesScroll');

    // Celebrate on page load
    celebrateConfetti();
});
</script>

@endsection