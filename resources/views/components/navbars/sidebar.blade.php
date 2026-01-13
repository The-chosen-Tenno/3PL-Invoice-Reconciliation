@props(['activePage'])
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="">
            {{-- <img src="" class="navbar-brand-img h-100" alt="main_logo"> --}}
            <span class="ms-2 font-weight-bold text-white">3PL Invoice-Reconciliation</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="/pages/dashboard">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">home</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'orders' ? ' active bg-gradient-primary' : '' }} "
                    href="/pages/orders">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">All Orders</span>
                </a>
            </li>
            </li>
            @if (auth()->user()->role === 'admin')
            @endif
            <div class="sidenav-footer position-absolute w-100 bottom-0 ">
                <div class="mx-3">
                    <a class="btn bg-gradient-primary w-100" href="/pages/profile"> <i
                            class="material-icons opacity-10">account_circle</i>
                        <span class="nav-link-text ms-1">Profile</span></a>
                </div>
            </div>
        </ul>
    </div>
</aside>