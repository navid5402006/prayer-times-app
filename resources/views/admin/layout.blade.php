<nav id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-mosque"></i> Admin Panel</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
            <a href="{{ route('admin.blogs.index') }}">
                <i class="fas fa-blog"></i> Blog Management
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
            <a href="{{ route('admin.blog-categories.index') }}">
                <i class="fas fa-folder"></i> Blog Categories
            </a>
        </li>

         <li class="{{ request()->is('admin/blog-tags*') ? 'active' : '' }}">
    <a href="{{ url('admin/blog-tags') }}">
        <i class="fas fa-folder"></i> Blog Tags
    </a>
</li>

        <li class="{{ request()->routeIs('admin.prayer-searches.*') ? 'active' : '' }}">
            <a href="{{ route('admin.prayer-searches.index') }}">
                <i class="fas fa-calendar-alt"></i> Prayer Times
            </a>
        </li>

         <li class="{{ request()->routeIs('admin.qibla-searches.*') ? 'active' : '' }}">
    <a href="{{ route('admin.qibla-searches.index') }}">
        <i class="fas fa-compass"></i> Qibla Directions
    </a>
</li>

<li class="{{ request()->routeIs('admin.ramadan-searches.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ramadan-searches.index') }}">
        <i class="fas fa-moon"></i> Ramadan Cities
    </a>
</li>

        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a href="#">
                <i class="fas fa-users"></i> Users
            </a>
        </li>
        <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <a href="#">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
        <li>
            <a href="{{ route('admin.logout') }}">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>
