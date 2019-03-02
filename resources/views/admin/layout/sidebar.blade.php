<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                <img src="{{ asset('admin/images/faces/face1.jpg') }}" alt="profile">
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
                </div>
                <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">David Grey. H</span>
                <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-customer" aria-expanded="false" aria-controls="ui-customer">
                <span class="menu-title">Customer Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-circle menu-icon"></i>
            </a>
            <div class="collapse" id="ui-customer">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('getCustomer')}}">Index</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('createCustomer')}}">Add Customer</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-vendor" aria-expanded="false" aria-controls="ui-vendor">
                <span class="menu-title">Vendor Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="ui-vendor">
                <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('getVendor')}}">Index</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('createVendor')}}">Add Vendor</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-admin" aria-expanded="false" aria-controls="ui-admin">
                <span class="menu-title">Admin Management</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="ui-admin">
                <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="#">Index</a></li>
                <li class="nav-item"> <a class="nav-link" href="#">Add Vendor</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-master" aria-expanded="false" aria-controls="ui-master">
                    <span class="menu-title">Master Management</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-book-multiple-variant menu-icon"></i>
                </a>
                <div class="collapse" id="ui-master">
                    <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('getKategori')}}">Kategori Management</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('getBank')}}">Bank Management</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('getRekening')}}">Rekening Management</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('getSubscribe')}}">Subscribe Management</a></li>
                    </ul>
                </div>
            </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('getTransaksi')}}">
                <span class="menu-title">Transaksi Management</span>
                <i class="mdi mdi-file-chart menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('getPayment')}}">
                <span class="menu-title">Payment Management</span>
                <i class="mdi mdi-credit-card menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>