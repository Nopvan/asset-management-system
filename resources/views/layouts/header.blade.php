<style>
    .nav-link:hover {
        text-decoration: none;
        color: #2e9323 !important;
        transform: scale(1.10);
    }
</style>

<nav class="navbar navbar-expand-lg bg-light bg-gradient shadow">
    <div class="container">
        <a class="navbar-brand text-white d-flex align-items-center" href="/">
            <img src="{{ asset('images/smk.png') }}" alt="Logo Sekolah" height="40" class="me-2">
            <span class="fw-semibold fs-5 text-black">SMK NAGRAK PURWAKARTA</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                <a class="nav-link text-black px-3" href="/">Home</a>
                <a class="nav-link text-black px-3" href="/rooms-borrow">Rooms</a>
                <a class="nav-link text-black px-3" href="/assets">Assets</a>

                @guest
                    <a class="nav-link text-black px-3" href="/login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @else
                    <div class="dropdown px-3">
                        <a class="nav-link text-black dropdown-toggle" href="#" id="navbarUserDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i>Halo, {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            @if (Auth::user()->role === 'super_admin' || Auth::user()->role === 'resepsionis')
                                <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                            @elseif (Auth::user()->role === 'user')
                                <li><a class="dropdown-item" href="{{ route('assets.borrow.index') }}">List Peminjaman</a>
                                </li>
                            @endif
                            <li><a class="dropdown-item" href="/customerservice">Customer Service</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
