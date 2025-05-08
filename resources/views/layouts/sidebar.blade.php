<style>
    .sidebar-custom .nav-link,
    .sidebar-custom .sidebar-heading,
    .sidebar-custom .sidebar-brand-text {
        color: #fff !important;
    }
</style>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #2e9323;">


    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
            <i class="fas fa-fw fa-table"></i>
            <span>Assets</span></a>
    </li>
    <li class="nav-item {{ request()->is('category*') ? 'active' : '' }}">
        <a class="nav-link " href="/category">
            <i class="fas fa-fw fa-table"></i>
            <span>Categories</span></a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <a href="{{ url('/') }}">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </a>
    </div>

</ul>
