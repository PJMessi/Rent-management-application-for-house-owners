<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item">
        <router-link to="/home" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt blue"></i>
            <p>Dashboard</p>
        </router-link>
    </li>

    @can('isAdmin')
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs green"></i>
            <p>
                Management
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <router-link to="users" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Users</p>
                </router-link>
            </li>
        </ul>
    </li>   
    <li class="nav-item">
        <router-link to="developer" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Developer</p>
        </router-link>
    </li>
    @endcan

    <li class="nav-item">
        <router-link to="profile" class="nav-link">
            <i class="nav-icon fas fa-user orange"></i>
            <p>Profile</p>
        </router-link>
    </li>

    <li class="nav-item">
        <router-link to="renter" class="nav-link">
            <i class="nav-icon fas fa-money-bill-alt green"></i>
            <p>Renters</p>
        </router-link>
    </li>

    <li class="nav-item">
        <router-link to="room" class="nav-link">
            <i class="nav-icon fas fa-bed purple"></i>
            <p>Rooms</p>
        </router-link>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link" href="{{ route('logout') }}"
        onclick="logout()">
            <i class="nav-icon fas fa-power-off red"></i>
            <p>Logout</p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
        
</ul>