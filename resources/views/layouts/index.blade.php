@include('layouts.header')
<!--begin::Wrapper-->
<div class="app-wrapper d-flex" id="kt_app_wrapper">
	<!--begin::Sidebar-->
	@include('layouts.sidebar')
	<!--end::Sidebar-->
	<!--begin::Main-->
	<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
		<!--begin::Content wrapper-->

		@yield('content')
		<!--end::Content wrapper-->
		<!--begin::Footer-->
		@include('layouts.footer')
		
		<!--end::Footer-->
	</div>
	<!--end:::Main-->
	<!--begin::aside-->
	@include('layouts.sidebar_aside')
	<!--end::aside-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::App-->
<!--begin::Activities drawer-->
@include('layouts.log_aktifitas')
<!--end::Activities drawer-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->

<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
@yield('script')
<!--end::Javascript-->
</body>

</html>