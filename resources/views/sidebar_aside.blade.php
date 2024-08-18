	<div id="kt_app_aside" class="app-aside flex-column" data-kt-drawer="true" data-kt-drawer-name="app-aside"
		data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
		data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_aside_toggle">
		<!--begin::Aside wrapper-->
		<div id="kt_app_aside_wrapper" class="app-aside-wrapper hover-scroll-y my-4" data-kt-scroll="true"
			data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-offset="5px">
			<!--begin::Primary menu-->
			<div id="kt_app_aside_menu" class="menu menu-sub-indention menu-rounded menu-column fw-semibold fs-6 px-2"
				data-kt-menu="true">
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ url('/penerbit/dashboard') }}">
						<span class="menu-icon">
							<i class="ki-outline ki-element-11 fs-2"></i>
						</span>
						<span class="menu-title">Dashboards</span>

                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ url('/penerbit/isbn/permohonan')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-plus-circle fs-2"></i>
						</span>
						<span class="menu-title">Permohonan ISBN</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ url('/penerbit/isbn/masalah')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-file-deleted fs-2"></i>
						</span>
						<span class="menu-title">ISBN Bermasalah</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ url('/penerbit/isbn/data')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-questionnaire-tablet fs-2"></i>
						</span>
						<span class="menu-title">Data ISBN</span>
                    </a>
					<!--end:Menu link-->
				</div>
			</div>
			<!--end::Primary menu-->
		</div>
		<!--end::Aside wrapper-->
	</div>