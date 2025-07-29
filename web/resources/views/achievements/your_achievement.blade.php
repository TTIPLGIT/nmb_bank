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
        ? 'bg-gradient-to-br from-indigo-400 to-indigo-600'
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

        <!-- Filter Buttons (Right Corner) -->
        <div class="flex justify-end mb-6">
            <div class="flex gap-3">
                <button onclick="filterBadges('all')"
                    class="filter-btn px-4 py-2 rounded bg-white text-black font-bold active">All</button>
                <button onclick="filterBadges('unlocked')"
                    class="filter-btn px-4 py-2 rounded bg-white text-black font-bold">Unlocked</button>
                <button onclick="filterBadges('locked')"
                    class="filter-btn px-4 py-2 rounded bg-white text-black font-bold">Locked</button>
            </div>
        </div>


        <h2 class="text-2xl font-bold text-white mb-4">🔥 Streaks</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-12">
            @forelse ($streaks as $streak)
            @php
            $cardStyle = $streak['unlocked']
            ? $streak['color'] . ' text-white shadow-xl'
            : 'bg-gray-100 text-gray-800 border border-gray-300';
            $badgeTitle = $streak['unlocked'] ? '' : 'title="Complete to unlock!"';
            $status = $streak['unlocked'] ? 'unlocked' : 'locked';
            @endphp

            <div class="relative p-6 rounded-2xl flex flex-col items-center justify-center transition transform hover:scale-105 duration-300 ease-in-out {{ $cardStyle }} badge-card"
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


        <h2 class="text-2xl font-bold text-white mb-4">🏅 Badges</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="badgeContainer">
            @forelse ($badges as $badge)
            @php
            $cardStyle = $badge['unlocked']
            ? $badge['color'] . ' text-white shadow-xl'
            : 'bg-gray-100 text-gray-800 border border-gray-300';
            $badgeTitle = $badge['unlocked'] ? '' : 'title="Complete to unlock!"';
            $status = $badge['unlocked'] ? 'unlocked' : 'locked';
            @endphp

            <div class="relative p-6 rounded-2xl flex flex-col items-center justify-center transition transform hover:scale-105 duration-300 ease-in-out {{ $cardStyle }} badge-card"
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
<script>
AOS.init({
    duration: 800,
    once: true
});

function filterBadges(filter) {
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
</script>

@endsection