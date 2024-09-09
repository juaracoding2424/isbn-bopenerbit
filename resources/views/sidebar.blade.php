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
                <a class="menu-link" href="{{ url('/penerbit/dashboard') }}">
                    <span class="menu-icon"><i class="ki-outline ki-element-11 fs-2"></i></span> Home
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{ url('/penerbit/isbn/permohonan')}}">
                    <span class="menu-icon"><i class="ki-outline ki-plus-circle fs-2"></i></span> Permohonan ISBN
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{ url('/penerbit/isbn/masalah')}}">
                    <span class="menu-icon"><i class="ki-outline ki-file-deleted fs-2"></i></span> ISBN Bermasalah
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="{{ url('/penerbit/isbn/data')}}">
                    <span class="menu-icon"><i class="ki-outline ki-questionnaire-tablet fs-2"></i></span> Data ISBN
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="support.php">
                    <span class="menu-icon"><i class="ki-outline ki-chart fs-2"></i></span> Support
                </a>
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Secondary menu-->
    </div>
    <!--end::Sidebar wrapper-->
</div>