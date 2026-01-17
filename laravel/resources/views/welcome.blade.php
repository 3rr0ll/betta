<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BettaMart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --slate-gray: #1F2A37;
            --teal-ocean: #2CB1BC;
            --soft-mint: #B5F3E8;
            --bone-white: #FDFDFC;
            --golden-amber: #F59E42;
        }
    html {
        scroll-behavior: smooth;
    }
    </style>
</head>

<body class="bg-bone-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-soft-mint sticky top-0 z-50" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="#hero" class="flex items-center gap-2 nav-link">
                        <div class="w-8 h-8 rounded-full" style="background-color: var(--teal-ocean)"></div>
                        <span class="text-xl font-bold" style="color: var(--slate-gray)">BettaMart</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex gap-8">
                    <a href="#hero" class="text-sm font-medium nav-link" style="color: var(--slate-gray)">Dashboard</a>
                    <a href="#featured" class="text-sm font-medium nav-link" style="color: var(--slate-gray)">Shop</a>
                    <a href="#about" class="text-sm font-medium nav-link" style="color: var(--slate-gray)">About</a>
                    <a href="#contact" class="text-sm font-medium nav-link" style="color: var(--slate-gray)">Contact</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded focus:outline-none" aria-label="Open main menu">
                        <svg :class="{ 'hidden': mobileMenu, 'inline': !mobileMenu }" class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg :class="{ 'inline': mobileMenu, 'hidden': !mobileMenu }" class="hidden h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Auth Buttons / Profile Dropdown -->
                <div class="hidden md:flex items-center gap-4">
                    @php
                    $email = session('user')['email'] ?? (Auth::check() ? Auth::user()->email : null);
                    @endphp
                    
                    @if($email)
                    <div
                        x-data="{ open: false }"
                        @keydown.escape.window="open = false"
                        class="relative"
                    >
                        <!-- Trigger -->
                        <button
                            @click="open = !open"
                            class="flex items-center gap-2 px-4 py-2 rounded font-medium text-sm focus:outline-none"
                            style="background-color: var(--teal-ocean); color: var(--bone-white)"
                            type="button"
                            aria-haspopup="true"
                            :aria-expanded="open"
                        >
                            <!-- User Icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                <path d="M12 18c-4 0-7 2-7 3v1h14v-1c0-1-3-3-7-3z"/>
                            </svg>
                    
                            <!-- Email (Gmail-style truncation) -->
                            <span class="max-w-[160px] truncate">
                                {{ $email }}
                            </span>
                    
                            <!-- Caret -->
                            <svg class="w-4 h-4 transition-transform duration-200"
                                :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    
                        <!-- Dropdown -->
                        <div
                            x-cloak
                            x-show="open"
                            x-transition.origin.top.right
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-56 bg-white border rounded-lg shadow-lg z-50"
                            style="display: none"
                        >
                            <!-- Header -->
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $email }}
                                </p>
                            </div>
                    
                            <!-- Links -->
                            <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 text-sm hover:bg-teal-50"
                            style="color: var(--slate-gray)">
                                Dashboard
                            </a>
                    
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-teal-50"
                                    style="color: var(--slate-gray)"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded font-medium text-sm"
                    style="background-color: var(--slate-gray); color: var(--bone-white)">
                        Sign Up
                    </a>
                    <a href="{{ route('login') }}"
                    class="px-4 py-2 rounded font-medium text-sm"
                    style="background-color: var(--teal-ocean); color: var(--bone-white)">
                        Login
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <!-- Mobile Menu (Dropdown) -->
        <div x-show="mobileMenu" x-transition class="md:hidden bg-white border-b border-soft-mint shadow-sm">
            <div class="flex flex-col px-4 pt-3 pb-4 gap-1">
                <a href="#hero" class="block py-2 text-base font-medium nav-link" style="color: var(--slate-gray)">Dashboard</a>
                <a href="#featured" class="block py-2 text-base font-medium nav-link" style="color: var(--slate-gray)">Shop</a>
                <a href="#about" class="block py-2 text-base font-medium nav-link" style="color: var(--slate-gray)">About</a>
                <a href="#contact" class="block py-2 text-base font-medium nav-link" style="color: var(--slate-gray)">Contact</a>
                <div class="flex flex-col gap-1 mt-2">
                    @if($email)
                        <span class="block py-2 px-2 text-sm text-gray-500 truncate">{{ $email }}</span>
                        <a href="{{ route('dashboard') }}" class="block px-2 py-2 text-base font-medium nav-link" style="color: var(--slate-gray)">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left px-2 py-2 text-base hover:bg-teal-50"
                                style="color: var(--slate-gray)"
                            >
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('register') }}"
                        class="block px-2 py-2 rounded font-medium text-base text-center"
                        style="background-color: var(--slate-gray); color: var(--bone-white)">
                            Sign Up
                        </a>
                        <a href="{{ route('login') }}"
                        class="block px-2 py-2 rounded font-medium text-base text-center"
                        style="background-color: var(--teal-ocean); color: var(--bone-white)">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section id="hero" class="flex flex-col md:flex-row items-center justify-between max-w-7xl mx-auto px-6 py-16 gap-8">
        <!-- Hero Text -->
        <div class="flex-1">
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="color: var(--slate-gray)">
                Discover Premium<br>Betta Fish
            </h1>
            <p class="text-base md:text-lg mb-8" style="color: var(--slate-gray)">
                Explore our carefully curated collection of stunning betta fish. Each fish is handpicked for its vibrant
                colors and unique personality.
            </p>
            <div class="flex gap-4">
                <a href="#featured" class="px-6 py-2 rounded font-medium transition-colors duration-200 nav-link"
                    style="background-color: var(--teal-ocean); color: var(--bone-white)">
                    Browse Collection
                </a>
                <a href="#about"
                    class="px-6 py-2 rounded font-medium border border-teal-ocean transition-colors duration-200 nav-link"
                    style="color: var(--teal-ocean); border-color: var(--teal-ocean); background-color: var(--bone-white)">
                    Learn More
                </a>
            </div>
        </div>
        <!-- Hero Image -->
        <div class="flex-1 flex justify-center">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80"
                alt="Red betta fish swimming in green aquatic plants"
                class="rounded-xl shadow-lg w-full max-w-md object-cover">
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured" class="py-16 px-4" style="background-color: var(--bone-white)">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold mb-12 text-center" style="color: var(--slate-gray)">
                Featured Beauties
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Static Product 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-64 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=500&q=80"
                            alt="Ruby Delta" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2" style="color: var(--slate-gray)">Ruby Delta</h3>
                        <p class="text-sm mb-4" style="color: var(--slate-gray)">Brilliant red fins with subtle
                            iridescence—an energetic tank star, perfect for hobbyists.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold" style="color: var(--golden-amber)">
                                $24.99
                            </span>
                            <a href="/products/ruby-delta" class="px-4 py-2 rounded-lg text-white font-medium"
                                style="background-color: var(--teal-ocean)">
                                View
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Static Product 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-64 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=500&q=80"
                            alt="Blue Marble" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2" style="color: var(--slate-gray)">Blue Marble</h3>
                        <p class="text-sm mb-4" style="color: var(--slate-gray)">Stunning blue and white marbling with
                            calm temperament; a striking centerpiece.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold" style="color: var(--golden-amber)">
                                $29.50
                            </span>
                            <a href="/products/blue-marble" class="px-4 py-2 rounded-lg text-white font-medium"
                                style="background-color: var(--teal-ocean)">
                                View
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Static Product 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="h-64 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=500&q=80"
                            alt="Golden Crown" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2" style="color: var(--slate-gray)">Golden Crown</h3>
                        <p class="text-sm mb-4" style="color: var(--slate-gray)">Rare yellow and gold coloring
                            reminiscent of a royal crown; majestic and unique.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold" style="color: var(--golden-amber)">
                                $32.00
                            </span>
                            <a href="/products/golden-crown" class="px-4 py-2 rounded-lg text-white font-medium"
                                style="background-color: var(--teal-ocean)">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section -->
    <section id="about" class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Sample Betta Collection" class="rounded-lg">
                <div>
                    <h2 class="text-4xl font-bold mb-6" style="color: var(--slate-gray)">About BettaMart</h2>
                    <p class="mb-4 text-lg" style="color: var(--slate-gray)">
                        We're passionate about betta fish and dedicated to providing the highest quality specimens to
                        our community.
                    </p>
                    <p class="mb-4 text-lg" style="color: var(--slate-gray)">
                        Every betta in our collection is hand-selected for color, health, and temperament. We work
                        directly with local breeders to ensure the best genetics.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full" style="background-color: var(--teal-ocean)"></span>
                            <span style="color: var(--slate-gray)">Premium quality fish</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full" style="background-color: var(--teal-ocean)"></span>
                            <span style="color: var(--slate-gray)">Local pickup & meetup</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full" style="background-color: var(--teal-ocean)"></span>
                            <span style="color: var(--slate-gray)">Expert care guidance</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-10 px-4" style="background-color: var(--teal-ocean)">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg md:p-16 flex flex-col">
            <h2 class="text-4xl font-bold mb-8 text-center" style="color: var(--slate-gray)">Contact Us</h2>
            <div class="w-full bg-soft-mint rounded-lg p-8 shadow flex flex-col gap-6">
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-teal-ocean bg-opacity-10">
                        <svg class="w-6 h-6 text-teal-ocean" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0c0-2.21 3.582-5.198 3.798-5.382a.999.999 0 011.404 0C12.418 6.802 16 9.79 16 12z" />
                        </svg>
                    </span>
                    <span class="text-lg" style="color: var(--slate-gray)">
                        info@bettamart.local
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-teal-ocean bg-opacity-10">
                        <svg class="w-6 h-6 text-teal-ocean" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a7 7 0 0014 0"></path>
                            <circle cx="12" cy="5" r="2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v13"></path>
                        </svg>
                    </span>
                    <span class="text-lg" style="color: var(--slate-gray)">
                        +1 (555) 123-4567
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-teal-ocean bg-opacity-10">
                        <svg class="w-6 h-6 text-teal-ocean" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.242a8 8 0 1111.314 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </span>
                    <span class="text-lg" style="color: var(--slate-gray)">
                        123 Aqua Lane, Fishville, ST 90210
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-0" style="background-color: var(--slate-gray)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">BettaMart</h3>
                    <p class="text-gray-300 text-sm">Premium betta fish for enthusiasts and collectors.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#featured" class="hover:text-white nav-link">Shop</a></li>
                        <li><a href="#about" class="hover:text-white nav-link">About Us</a></li>
                        <li><a href="#faq" class="hover:text-white nav-link">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#contact" class="hover:text-white nav-link">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Care Guide</a></li>
                        <li><a href="#" class="hover:text-white">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <p class="text-gray-300 text-sm">Email: info@bettamart.local</p>
                    <p class="text-gray-300 text-sm">Local Pickup & Meetup Available</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300 text-sm">
                <p>&copy; 2025 BettaMart. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>