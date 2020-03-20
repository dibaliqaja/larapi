<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i><span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ url('/province') }}">List Province</a></li>
                    <li><a class="nav-link" href="{{ url('/city') }}">List City</a></li>
                    <li><a class="nav-link" href="{{ url('/area') }}">List Area</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link" href="{{ url('/user') }}"><i class="fas fa-user"></i>
                    <span>Data Admin</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ url('/logs') }}"><i class="fas fa-history"></i>
                    <span>Logs Activity</span>
                </a>
            </li>
        </ul>

    </aside>
</div>
