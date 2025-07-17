@extends('layouts.elearningmain')

@section('content')

<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- Page Background -->
<style>
body {
    margin: 0 !important;
    padding: 0 !important;
    height: 100%;
    background: linear-gradient(-45deg, #1e3c72, #2a5298, #3a7bd5, #1e3c72) !important;
    background-size: 400% 400% !important;
    animation: gradientBG 20s ease infinite !important;
}

@keyframes gradientBG {
    0% {
        background-position: 0% 50% !important;
    }

    50% {
        background-position: 100% 50% !important;
    }

    100% {
        background-position: 0% 50% !important;
    }
}
</style>

<div class="main-content min-h-screen py-12 px-6">
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold mb-10 text-center text-white tracking-wide">
            🏆 Your Achievements
        </h1>

        @php
        $badges = [
        ['name' => 'Compliance Champion', 'desc' => 'Complete all Compliance courses', 'icon' => 'fa-balance-scale',
        'color' => 'bg-gradient-to-br from-green-400 to-green-600', 'unlocked' => true],
        ['name' => 'Relationship Builder', 'desc' => 'Complete all Soft Skills courses', 'icon' => 'fa-handshake-angle',
        'color' => 'bg-gradient-to-br from-blue-400 to-blue-600', 'unlocked' => false],
        ['name' => 'Digital Defender', 'desc' => 'Complete 3 Cybersecurity courses', 'icon' => 'fa-shield-halved',
        'color' => 'bg-gradient-to-br from-indigo-400 to-indigo-600', 'unlocked' => true],
        ['name' => 'Learning Streak', 'desc' => '7 days of continuous learning', 'icon' => 'fa-certificate', 'color' =>
        'bg-gradient-to-br from-yellow-400 to-yellow-600', 'unlocked' => false],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($badges as $badge)
            @php
            $cardStyle = $badge['unlocked']
            ? $badge['color'] . ' text-white shadow-xl'
            : 'bg-gray-100 text-gray-800 border border-gray-300';
            $badgeTitle = $badge['unlocked'] ? '' : 'title="Complete to unlock!"';
            @endphp

            <div class="relative p-6 rounded-2xl flex flex-col items-center justify-center transition transform hover:scale-105 duration-300 ease-in-out {{ $cardStyle }}"
                data-aos="fade-up" {!! $badgeTitle !!}>

                <div class="w-20 h-20 flex items-center justify-center rounded-full bg-white shadow-md">
                    <i class="fas {{ $badge['icon'] }} text-black text-5xl font-extrabold"></i>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-xl font-bold">{{ $badge['name'] }}</p>
                    <p class="text-sm mt-1">{{ $badge['desc'] }}</p>
                </div>

                <span class="absolute top-2 right-2 text-xs font-bold px-3 py-1 rounded-full
                        {{ $badge['unlocked'] ? 'bg-white text-green-600' : 'bg-gray-400 text-white' }}">
                    {{ $badge['unlocked'] ? 'Unlocked' : 'Locked' }}
                </span>
            </div>
            @endforeach
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
</script>

@endsection