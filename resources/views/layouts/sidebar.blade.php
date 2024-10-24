<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle" @php if(session('penerbit')['STATUS'] == "notvalid") { echo "style='display:none;'"; } @endphp>
    <!--begin::Sidebar wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper hover-scroll-y mx-3 my-2" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header"
        data-kt-scroll-offset="5px">
        <!--begin::Secondary menu-->
        <div id="kt_app_sidebar_menu"
            class="menu menu-sub-indention menu-rounded menu-column fw-semibold fs-6 py-4 py-lg-6 px-2"
            data-kt-menu="true">
            <!--begin:Menu item-->
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/dashboard') ? 'active' : '' }}" href="{{ url('/penerbit/dashboard') }}">
                    <span class="menu-icon"><i class="ki-outline ki-element-11 fs-2"></i></span> Home
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/isbn/permohonan/new') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/permohonan/new')}}">
                    <span class="menu-icon"><i class="ki-outline ki-plus fs-2"></i></span> Permohonan Baru
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/isbn/permohonan') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/permohonan')}}">
                    <span class="menu-icon"><i class="ki-outline ki-plus-circle fs-2"></i></span> Data Permohonan <span class="badge badge-light-danger badge-circle fw-bold fs-7 ms-2" id="totalPermohonan"></span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/isbn/masalah') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/masalah')}}">
                    <span class="menu-icon"><i class="ki-outline ki-file-deleted fs-2"></i></span> Data Permohonan Bermasalah <span class="badge badge-light-danger badge-circle fw-bold fs-7 ms-2" id="totalMasalah"></span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/isbn/batal') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/batal')}}">
                    <span class="menu-icon"><i class="ki-outline ki-file-deleted fs-2 text-danger"></i></span> Permohonan Batal <span class="badge badge-light-danger badge-circle fw-bold fs-7 ms-2" id="totalBatal"></span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/isbn/data') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/data')}}">
                    <span class="menu-icon"><i class="ki-outline ki-questionnaire-tablet fs-2"></i></span> Data ISBN <span class="badge badge-light-danger badge-circle fw-bold fs-7 ms-2" id="totalDiterima"></span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/isbn/kdt/data') ? 'active' : '' }}" href="{{ url('/penerbit/kdt/data')}}">
                    <span class="menu-icon"><i class="ki-outline ki-book fs-2"></i></span> KDT
                </a>
            </div>
            <!--div class="menu-item">
                <a class="menu-link" href="support.php">
                    <span class="menu-icon"><i class="ki-outline ki-chart fs-2"></i></span> Support
                </a>
            </div-->
            <div class="menu-item">
                <a class="menu-link {{ request()->is('penerbit/report/isbn') ? 'active' : '' }}" href="{{ url('/penerbit/report/isbn')}}">
                    <span class="menu-icon"><i class="ki-outline ki-chart fs-2"></i></span> Laporan
                </a>
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Secondary menu-->
    </div>
    <!--end::Sidebar wrapper-->
</div>