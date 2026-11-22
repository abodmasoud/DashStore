<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon"><i class="fas fa-store"></i></div>
        <div class="sidebar-brand-text mx-3">DashStore</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Catalog</div>

    {{-- Links are wired up in the "Admin catalog" step. --}}
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-fw fa-box"></i><span>Products</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-fw fa-tags"></i><span>Categories</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-fw fa-copyright"></i><span>Brands</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Sales</div>

    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-fw fa-receipt"></i><span>Orders</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-fw fa-users"></i><span>Customers</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-fw fa-comments"></i><span>Messages</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Toggle sidebar"></button>
    </div>
</ul>
