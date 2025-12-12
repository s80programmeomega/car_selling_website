<header class="navbar">
    <div class="container navbar-content">
        <a href="{{ route('car.index') }}" class="logo-wrapper">
            <img src="{{ asset('img/logoipsum-265.svg') }}" alt="Logo" />
        </a>

        <!-- Desktop Navigation -->
        <nav class="navbar-nav-links">
            <a href="{{ route('car.index') }}"
                class="navbar-nav-link {{ request()->routeIs('car.index') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>

            <!-- Browse Dropdown -->
            <div class="navbar-menu navbar-browse-menu">
                <a href="javascript:void(0)" class="navbar-nav-link">
                    <i class="fas fa-car"></i>
                    <span>Browse</span>
                    <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('car.search') }}">All Cars</a></li>
                    <li><a href="{{ route('car.search') }}?type=suv">SUVs</a></li>
                    <li><a href="{{ route('car.search') }}?type=sedan">Sedans</a></li>
                    <li><a href="{{ route('car.search') }}?type=truck">Trucks</a></li>
                    <li><a href="{{ route('car.search') }}?featured=1">Featured Cars</a></li>
                </ul>
            </div>

            <a href="{{ route('car.search') }}"
                class="navbar-nav-link {{ request()->routeIs('car.search') ? 'active' : '' }}">
                <i class="fas fa-search"></i>
                <span>Search</span>
            </a>
            <a href="{{ route('contact') }}"
                class="navbar-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </a>
        </nav>

        <button class="btn btn-default btn-navbar-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 24px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <div class="navbar-auth">
            <!-- Mobile Navigation Links (for both auth and guest) -->
            <div class="mobile-nav-links">
                <a href="{{ route('car.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('car.index') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('car.search') }}"
                    class="mobile-nav-link {{ request()->routeIs('car.search') ? 'active' : '' }}">
                    <i class="fas fa-search"></i> Search
                </a>
                <a href="{{ route('contact') }}"
                    class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Contact
                </a>
                <hr style="margin: 1rem 0; border-color: #e0e0e0;">
            </div>

            @auth

            <!-- Favorites with Counter -->
            @livewire('car.favorites-counter')

            <!-- Notification Bell -->
            <livewire:notification-bell />

            <a href="{{ route('car.create') }}" class="btn btn-add-new-car">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px; margin-right: 4px">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="btn-text">Add new Car</span>
            </a>
            <div class="navbar-menu" tabindex="-1">
                <a href="javascript:void(0)" class="navbar-menu-handler">
                    {{ auth()->user()->username }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width: 20px">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('my-cars') }}">My Cars</a></li>
                    <li><a href="{{ route('favorites') }}">My Favorites</a></li>
                    <hr>
                    <li><a href="{{ route('profile.edit') }}">Settings</a></li>
                    <hr>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth

            @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-signup">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px; margin-right: 4px">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                Signup
            </a>
            <a href="{{ route('login') }}" class="btn btn-login flex items-center">
                <svg style="width: 18px; fill: currentColor; margin-right: 4px" viewBox="0 0 1024 1024" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M426.666667 736V597.333333H128v-170.666666h298.666667V288L650.666667 512 426.666667 736M341.333333 85.333333h384a85.333333 85.333333 0 0 1 85.333334 85.333334v682.666666a85.333333 85.333333 0 0 1-85.333334 85.333334H341.333333a85.333333 85.333333 0 0 1-85.333333-85.333334v-170.666666h85.333333v170.666666h384V170.666667H341.333333v170.666666H256V170.666667a85.333333 85.333333 0 0 1 85.333333-85.333334z"
                        fill="" />
                </svg>
                Login
            </a>
            @endguest
        </div>
    </div>
</header>

<style>
    /* ===== DESKTOP NAVIGATION ===== */
    .navbar-nav-links {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-left: 1rem;
    }

    .navbar-nav-links .navbar-nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--navbar-link-color);
        white-space: nowrap;
        font-size: 14px;
    }

    /* Hover effect - white text on primary background */
    .navbar-nav-links .navbar-nav-link:hover {
        color: white !important;
        background-color: var(--primary-color) !important;
    }

    .navbar-nav-links .navbar-nav-link:hover i {
        color: white;
    }

    /* Active page indicator - white text on primary background */
    .navbar-nav-links .navbar-nav-link.active {
        color: white !important;
        background-color: var(--primary-color) !important;
    }

    .navbar-nav-links .navbar-nav-link.active i {
        color: white;
    }

    /* ===== BROWSE DROPDOWN ===== */
    .navbar-browse-menu {
        position: relative;
    }

    .navbar-browse-menu .submenu {
        min-width: 180px;
    }

    /* ===== FAVORITES BUTTON ===== */
    .btn-favorites {
        position: relative;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-favorites:hover {
        background-color: rgba(233, 88, 12, 0.1);
    }

    .favorites-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background-color: #e11d48;
        color: white;
        font-size: 11px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    /* ===== MOBILE NAVIGATION ===== */
    .mobile-nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        color: var(--navbar-link-color);
        transition: all 0.3s;
        font-size: 15px;
    }

    .mobile-nav-link:hover {
        background-color: rgba(233, 88, 12, 0.1);
        color: var(--primary-color);
    }

    /* Active state for mobile - white text on primary background */
    .mobile-nav-link.active {
        background-color: var(--primary-color) !important;
        color: white !important;
    }

    .mobile-nav-link.active i {
        color: white !important;
    }

    /* ===== RESPONSIVE BREAKPOINTS ===== */

    /* Tablet: Hide text on smaller buttons, reduce gaps */
    @media screen and (max-width: 992px) {
        .navbar-nav-links {
            gap: 0.25rem;
        }

        .navbar-nav-links .navbar-nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 13px;
        }

        .btn-add-new-car .btn-text {
            display: none;
        }

        .btn-add-new-car {
            padding: 0.5rem;
            min-width: auto;
        }
    }

    /* Small tablet: Further reduce navigation */
    @media screen and (max-width: 768px) {
        .navbar-nav-links .navbar-nav-link span {
            display: none;
        }

        .navbar-nav-links .navbar-nav-link {
            padding: 0.5rem;
            width: 36px;
            height: 36px;
            justify-content: center;
        }

        .navbar-browse-menu .navbar-nav-link .fa-chevron-down {
            display: none;
        }
    }

    /* Mobile: Show mobile menu, hide desktop nav */
    @media screen and (max-width: 680px) {
        .navbar-nav-links {
            display: none;
        }

        .mobile-nav-links {
            display: flex;
        }

        .btn-favorites {
            order: -1;
        }

        .btn-add-new-car {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .btn-add-new-car .btn-text {
            display: inline;
        }
    }
</style>
