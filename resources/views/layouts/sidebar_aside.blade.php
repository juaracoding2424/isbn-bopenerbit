	<div id="kt_app_aside" class="app-aside flex-column" data-kt-drawer="true" data-kt-drawer-name="app-aside"
		data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
		data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_aside_toggle" >
		<!--begin::Aside wrapper-->
		<div id="kt_app_aside_wrapper" class="app-aside-wrapper hover-scroll-y my-4" data-kt-scroll="true"
			data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-offset="5px">
			<!--begin::Primary menu-->
			<div id="kt_app_aside_menu" class="menu menu-sub-indention menu-rounded menu-column fw-semibold fs-6 px-2"
				data-kt-menu="true" @php if(session('penerbit')['STATUS'] == "notvalid") { echo "style='display:none;'"; } @endphp>
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/dashboard') ? 'active' : '' }}" href="{{ url('/penerbit/dashboard') }}">
						<span class="menu-icon">
							<i class="ki-outline ki-element-11 fs-2"></i>
						</span>
						<span class="menu-title">Dashboards</span>

                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/isbn/permohonan/new') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/permohonan/new')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-plus fs-2"></i>
						</span>
						<span class="menu-title">Permohonan Baru</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/isbn/permohonan') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/permohonan')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-plus-circle fs-2"></i>
						</span>
						<span class="menu-title">Data Permohonan</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/isbn/masalah') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/masalah')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-file-deleted fs-2"></i>
						</span>
						<span class="menu-title">Data Permohonan Bermasalah</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/isbn/batal') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/batal')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-file-deleted fs-2 text-danger"></i>
						</span>
						<span class="menu-title">Permohonan Batal</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/isbn/data') ? 'active' : '' }}" href="{{ url('/penerbit/isbn/data')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-questionnaire-tablet fs-2"></i>
						</span>
						<span class="menu-title">Data ISBN</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/kdt/data') ? 'active' : '' }}" href="{{ url('/penerbit/kdt/data')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-book fs-2"></i>
						</span>
						<span class="menu-title">KDT</span>
                    </a>
					<!--end:Menu link-->
					<!--begin:Menu link-->
					<a class="menu-link {{ request()->is('penerbit/report/isbn') ? 'active' : '' }}" href="{{ url('/penerbit/report/isbn')}}">
						<span class="menu-icon">
							<i class="ki-outline ki-chart fs-2"></i>
						</span>
						<span class="menu-title">Laporan</span>
                    </a>
					<!--end:Menu link-->
				</div>
			</div>
			<!--end::Primary menu-->
		</div>
		<!--end::Aside wrapper-->
	</div>