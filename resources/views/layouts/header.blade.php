<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<title>ISBN - Back Office Penerbit</title>
	<meta charset="utf-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="canonical" href="http://isbn.perpusnas.go.id" />
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	<!--begin::Fonts(mandatory for all pages)-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Vendor Stylesheets(used for this page only)-->
	<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css ') }}" rel="stylesheet" type="text/css" />
	<!--end::Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css ') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
	<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<style> 
.loader {
    position: fixed;
    background-color: #FFF;
    opacity: 0.8;
    height: 100%;
    width: 100%;
    z-index: 10;
    background-image: url("{{ asset('/assets/media/loader.gif') }}");
    background-repeat: no-repeat;
    background-size: cover;
	display:none;
}
</style>
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
	data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true"
	data-kt-app-sidebar-push-footer="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="false"
	class="app-default">
	<div class="loader"></div>
	<!--begin::Theme mode setup on page load-->
	<script>var defaultThemeMode = "light"; var themeMode; if (document.documentElement) { if (document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if (localStorage.getItem("data-bs-theme") !== null) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
	<!--end::Theme mode setup on page load-->
	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			<div id="kt_app_header" class="app-header">
				<!--begin::Header logo-->
				<div class="app-header-logo d-flex align-items-center ps-lg-10 gap-4 gap-lg-6">
					<!--begin::Aside toggle-->
					<button id="kt_app_aside_toggle"
						class="btn btn-icon bg-gray-300 bg-opacity-75 btn-color-gray-700 btn-active-color-primary rounded-1 w-30px h-30px ms-n3 ms-lg-0">
						<i class="ki-outline ki-burger-menu-6 fs-3"></i>
					</button>
					<!--end::Aside toggle-->
					<!--begin::Logo image-->
					<a href="index.php">
						<img alt="Logo" src="https://www.isbn-international.org/themes/isbn8/logo.png"
							class="h-35px d-sm-none d-inline theme-light-show" />
						<img alt="Logo" src="https://www.isbn-international.org/themes/isbn8/logo.png"
							class="h-35px h-lg-35px theme-light-show d-none d-sm-inline" />
						<img alt="Logo" src="https://www.isbn-international.org/themes/isbn8/logo.png"
							class="h-35px h-lg-35px theme-dark-show" />
					</a>
					<!--end::Logo image-->
				</div>
				<!--end::Header logo-->
				<!--begin::Header wrapper-->
				<div class="app-header-wrapper">
					<div class="app-container container-fluid">
						<!--begin::Search-->
						<div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-1 me-lg-0">
							<!--begin::Search-->
							<!--end::Search-->
						</div>
						<!--end::Search-->
						<!--begin::Navbar-->
						<div class="app-navbar flex-shrink-0">
							<!--begin::Activities-->
							<div class="app-navbar-item ms-1 ms-lg-3">
								<!--begin::Drawer toggle-->
								<div class="btn btn-icon w-35px h-35px w-md-40px h-md-40px" id="kt_activities_toggle">
									<i class="ki-outline ki-notification-status fs-1"></i>
									<div
										class="badge badge-circle badge-danger position-absolute translate-middle bottom-0 ms-10 mt-7 mt-lg-10 h-15px w-15px fs-9">
										</div>
								</div>
								<!--end::Drawer toggle-->
							</div>
							<!--end::Activities-->
							<!--begin::User menu-->
							<div class="app-navbar-item ms-1 ms-lg-3 me-2 me-lg-6" id="kt_header_user_menu_toggle">
								<!--begin::Menu wrapper-->
								<div class="cursor-pointer symbol symbol-35px symbol-md-40px"
									data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
									data-kt-menu-placement="bottom-end">
									<img class="symbol symbol-circle symbol-35px symbol-md-40px"
										src="{{ asset('assets/media/avatars/300-1.jpg') }}" alt="user" />
								</div>
								<!--begin::User account menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
									data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3">
											<!--begin::Avatar-->
											<div class="symbol symbol-50px me-5">
												<img alt="Logo" src="{{ asset('assets/media/avatars/300-1.jpg') }}" />
											</div>
											<!--end::Avatar-->
											<!--begin::Username-->
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5">{{ session('penerbit')['NAME'] }}</div>
												<a href="#"
													class="fw-semibold text-muted text-hover-primary fs-7">{{ session('penerbit')['EMAIL'] }}</a>
											</div>
											<!--end::Username-->
										</div>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="{{url('penerbit/profile')}}" class="menu-link px-5">Akun</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
										data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
										<a href="#" class="menu-link px-5">
											<span class="menu-title position-relative">Mode
												<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
													<i class="ki-outline ki-night-day theme-light-show fs-2"></i>
													<i class="ki-outline ki-moon theme-dark-show fs-2"></i>
												</span></span>
										</a>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
											data-kt-menu="true" data-kt-element="theme-mode-menu">
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
													data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-night-day fs-2"></i>
													</span>
													<span class="menu-title">Light</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
													data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-moon fs-2"></i>
													</span>
													<span class="menu-title">Dark</span>
												</a>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
													data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-outline ki-screen fs-2"></i>
													</span>
													<span class="menu-title">System</span>
												</a>
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Menu item-->

									<!--begin::Menu item-->
									<div class="menu-item px-5 my-1">
										<a href="{{url('penerbit/change-password')}}" class="menu-link px-5">Ubah Password</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="{{url('auth/logout')}}" class="menu-link px-5">Sign Out</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::User account menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::User menu-->
							<div class="app-navbar-item ms-1 ms-lg-3 me-n4 d-flex d-lg-none">
								<!--begin::Sidebar toggle-->
								<button id="kt_app_sidebar_mobile_toggle"
									class="btn btn-icon w-35px h-35px w-md-40px h-md-40px">
									<i class="ki-outline ki-burger-menu-2 fs-2"></i>
								</button>
								<!--end::Sidebar toggle-->
							</div>
						</div>
						<!--end::Navbar-->
					</div>
				</div>
			</div>
			<!--end::Header-->