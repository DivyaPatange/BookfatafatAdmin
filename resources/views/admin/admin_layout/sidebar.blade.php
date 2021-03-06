<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/admin') }}">
    <div class="sidebar-brand-icon">
        <img src="{{ asset('img/122.png') }}">
    </div>
    <!-- <div class="sidebar-brand-text mx-3">Book Fatafat</div> -->
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
    <a class="nav-link" href="{{ url('/admin') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
    Features
    </div>
    <?php 
        $userRole = Auth::guard('admin')->user()->role_access;
        $explodeRole = explode(",", $userRole);
        // dd($explodeRole);
    ?>
    @if(in_array("User", $explodeRole))
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
            aria-controls="collapsePage">
            <i class="fas fa-fw fa-columns"></i>
            <span>Users</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Users</h6>
                <a class="collapse-item" href="{{ route('admin.users.create') }}">Add User</a>
                <a class="collapse-item" href="{{ route('admin.users.index') }}">User List</a>
            </div>
        </div>
    </li>
    @endif
    @if(in_array("Vendor", $explodeRole))
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Vendor</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Vendor</h6>
            <a class="collapse-item" href="{{ route('admin.vendorUser.create') }}">Add Vendor</a>
            <a class="collapse-item" href="{{ route('admin.vendorUser.index') }}">Vendor List</a>
            </div>
        </div>
    </li>
    @endif
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
            aria-controls="collapseForm">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Forms</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Forms</h6>
            <a class="collapse-item" href="form_basics.html">Form Basics</a>
            <a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
            aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tables</h6>
            <a class="collapse-item" href="simple-tables.html">Simple Tables</a>
            <a class="collapse-item" href="datatables.html">DataTables</a>
            </div>
        </div>
    </li> -->
    @if(in_array("Category", $explodeRole))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Category</span>
        </a>
    </li>
    @endif
    @if(in_array("Sub-Category", $explodeRole))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.sub-category.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Sub Category</span>
        </a>
    </li>
    @endif
    @if(in_array("Product", $explodeRole))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.products.index') }}">
            <i class="fas fa-fw fa-palette"></i>
            <span>Product</span>
        </a>
    </li>
    @endif
    @if(in_array("Services", $explodeRole))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.services.index') }}">
            <i class="fas fa-fw fa-palette"></i>
            <span>Services</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage1" aria-expanded="true"
            aria-controls="collapsePage1">
            <i class="fas fa-fw fa-columns"></i>
            <span>Orders</span>
        </a>
        <div id="collapsePage1" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Orders</h6>
                <a class="collapse-item" href="{{ route('admin.placed-order') }}">Placed Order</a>
                <a class="collapse-item" href="{{ route('admin.confirmed-order') }}">Confirmed Order</a>
                <a class="collapse-item" href="{{ route('admin.shipped-order') }}">Shipped Order</a>
                <a class="collapse-item" href="{{ route('admin.delivered-order') }}">Delivered Order</a>
                <a class="collapse-item" href="{{ route('admin.rejected-order') }}">Rejected Order</a>
            </div>
        </div>
    </li>
    <!-- <div class="sidebar-heading">
        Examples
    </div>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div> -->
</ul>