<!-- Font Awesome versi 6 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .sidebar-custom .nav-link,
    .sidebar-custom .sidebar-heading,
    .sidebar-custom .sidebar-brand-text {
        color: #fff !important;
    }
</style>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #2e9323;">


    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-text mx-3">Assets Management</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Management
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->is('item*') ? 'active' : '' }}">
        <a class="nav-link " href="/item">
            <i class="fa-solid fa-list"></i>
            <span>Locations</span></a>
    </li>
    <li class="nav-item {{ request()->is('item*') ? 'active' : '' }}">
        <a class="nav-link " href="/item">
            <i class="fa-solid fa-list"></i>
            <span>Rooms</span></a>
    </li>
    <li class="nav-item {{ request()->is('item*') ? 'active' : '' }}">
        <a class="nav-link " href="/item">
            <i class="fa-solid fa-list"></i>
            <span>Assets</span></a>
    </li>
    <li class="nav-item {{ request()->is('category*') ? 'active' : '' }}">
        <a class="nav-link " href="/category">
            <i class="fas fa-fw fa-table"></i>
            <span>Categories</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Loan Management
    </div>
    <li class="nav-item {{ request()->is('borrow*') ? 'active' : '' }}">
        <a class="nav-link " href="/borrow">
            <i class="fa-solid fa-table-cells-large"></i>
            <span>List Loans</span></a>
    </li>

    @if (Auth::user()->role === 'super_admin')
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            User Management
        </div>
        <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
            <a class="nav-link " href="/user">
                <i class="fa-solid fa-users"></i>
                <span>Users</span></a>
        </li>
    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <a href="{{ url('/') }}">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </a>
    </div>

</ul>
