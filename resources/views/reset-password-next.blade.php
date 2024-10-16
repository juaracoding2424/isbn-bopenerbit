<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: MetronicProduct Version: 8.2.6
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
<base href="../../../" />
<title>ISBN Indonesia - Reset Password</title>
		<meta charset="utf-8" />
		<meta name="description" content="Portal ISBN" />
		<meta name="keywords" content="isbn, perpusnas, buku" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
		<meta property="og:url" content="https://isbn.perpusnas.go.id" />
		<meta property="og:site_name" content="ISBN Indonesia" />
		<link rel="canonical" href="https://isbn.perpusnas.go.id/reset-password" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/assets/css/style-admin.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank" onkeypress="clickPress(event)">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - New password -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<!--begin::Form-->
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-500px p-10">
						
						@if($status == 'Failed')
						<div class="alert alert-danger d-flex align-items-center p-5 mb-10">
								<i class="ki-solid ki-shield-cross fs-4hx text-danger me-0"></i>
								<div class="rounded border p-10  d-flex flex-column">
									<div class="d-flex flex-column">
										<p class="mb-1 text-danger">{{ $message }}</p>								
									</div>
								</div>
							</div>
						@endif
							<!--begin::Form-->
							<form class="form w-100" novalidate="novalidate" id="kt_new_password_form" data-kt-redirect-url="{{ url('/login') }}" action="{{ url('/reset-password-next') }}" method="post">
							@csrf
							<input type="hidden" name="reset-token" value="{{$resetToken}}">
								<!--begin::Heading-->
								<div class="text-center mb-10">
									<!--begin::Title-->
									<h1 class="text-gray-900 fw-bolder mb-3">Setup New Password</h1>
									<!--end::Title-->
									<!--begin::Link-->
									<div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ? 
									<a href="{{url ('/login') }}" class="link-primary fw-bold">Sign in</a></div>
									<!--end::Link-->
								</div>
								<!--begin::Heading-->
								<!--begin::Input group-->
								<div class="fv-row mb-8" data-kt-password-meter="true">
									<!--begin::Wrapper-->
									<div class="mb-1">
										<!--begin::Input wrapper-->
										<div class="position-relative mb-3">
											<input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" />
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="ki-outline ki-eye-slash fs-2"></i>
												<i class="ki-outline ki-eye fs-2 d-none"></i>
											</span>
										</div>
										<!--end::Input wrapper-->
										<!--begin::Meter-->
										<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
										<!--end::Meter-->
									</div>
									<!--end::Wrapper-->
									<!--begin::Hint-->
									<div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
									<!--end::Hint-->
								</div>
								<!--end::Input group=-->
								<!--end::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Repeat Password-->
									<input type="password" placeholder="Repeat Password" name="confirm-password" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Repeat Password-->
								</div>
								<!--end::Input group=-->
								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<label class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="toc" value="1" />
										<span class="form-check-label fw-semibold text-gray-700 fs-6 ms-1">I Agree & 
										<a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
									</label>
								</div>
								<!--end::Input group=-->
								<!--begin::Action-->
								<div class="d-grid mb-10">
									<button type="button" id="kt_new_password_submit" class="btn btn-primary">
										<!--begin::Indicator label-->
										<span class="indicator-label">Submit</span>
										<!--end::Indicator label-->
										<!--begin::Indicator progress-->
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
										<!--end::Indicator progress-->
									</button>
								</div>
								<!--end::Action-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Form-->
					<!--begin::Footer-->
					<div class="w-lg-500px d-flex flex-stack px-10 mx-auto">
						<!--begin::Links-->
						<div class="d-flex fw-semibold text-primary fs-base gap-5">
							<a href="{{ config('app.fo')}}detail_fnq" class="link-primary" target="_blank">FAQ</a>
							<a href="{{ config('app.fo')}}isbn_info" class="link-primary" target="_blank">INFO</a>
							<a href="{{ config('app.fo')}}home#section_2" class="link-primary" target="_blank">BIP</a>
							<a href="{{ config('app.fo')}}home#section_2" class="link-primary" target="_blank">SURAT</a>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Body-->
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('{{asset('/assets/media/misc/auth-bg.png')}}')">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
						<!--begin::Logo-->
						<a href="index.html" class="mb-0 mb-lg-12">
							<img alt="Logo" src="{{asset('assets/media/logos/isbn.jpg')}}" class="h-60px h-lg-75px" />
						</a>
						<!--end::Logo-->
						<!--begin::Image-->
						<!--img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="assets/media/misc/auth-screens.png" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Layanan ISBN Perpustakaan Nasional RI</h1>
						<!--end::Title-->
						
					</div>
					<!--end::Content-->
				</div>
				<!--end::Aside-->
			</div>
			<!--end::Authentication - New password-->
		</div>
		<!--end::Root-->

		<!--begin::Javascript-->
        <script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script>
		var clickPress =  function(event) {
			if (event.keyCode == 13) {
				submitForm(document.querySelector("#kt_new_password_form"),document.querySelector("#kt_new_password_submit"))
			}
		}
		var submitForm = function(t, e){
			axios.post(e.closest("form").getAttribute("action"), new FormData(t)).then((function(e) {
								if (e) {
									t.reset();
									const e = t.getAttribute("data-kt-redirect-url");
									e && (location.href = e)
								} else Swal.fire({
									text: "Sorry, the email is incorrect, please try again.",
									icon: "error",
									buttonsStyling: !1,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								})
							})).catch((function(t) {
								Swal.fire({
									text: "Sorry, looks like there are some errors detected, please try again. " + t.response.data.message,
									icon: "error",
									buttonsStyling: !1,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								})
							})).then((() => {
								e.removeAttribute("data-kt-indicator"), e.disabled = !1
							}))
		}
		"use strict";
		var KTAuthNewPassword = function() {
			var t, e, r, o, n = function() {
				return o.getScore() > 50
			};
			
			return {
				init: function() {
					t = document.querySelector("#kt_new_password_form"), e = document.querySelector("#kt_new_password_submit"), o = KTPasswordMeter.getInstance(t.querySelector('[data-kt-password-meter="true"]')), r = FormValidation.formValidation(t, {
						fields: {
							password: {
								validators: {
									notEmpty: {
										message: "The password is required"
									},
									callback: {
										message: "Please enter valid password",
										callback: function(t) {
											if (t.value.length > 0) return n()
										}
									}
								}
							},
							"confirm-password": {
								validators: {
									notEmpty: {
										message: "The password confirmation is required"
									},
									identical: {
										compare: function() {
											return t.querySelector('[name="password"]').value
										},
										message: "The password and its confirm are not the same"
									}
								}
							},
							toc: {
								validators: {
									notEmpty: {
										message: "You must accept the terms and conditions"
									}
								}
							}
						},
						plugins: {
							trigger: new FormValidation.plugins.Trigger({
								event: {
									password: !1
								}
							}),
							bootstrap: new FormValidation.plugins.Bootstrap5({
								rowSelector: ".fv-row",
								eleInvalidClass: "",
								eleValidClass: ""
							})
						}
					}), t.querySelector('input[name="password"]').addEventListener("input", (function() {
						this.value.length > 0 && r.updateFieldStatus("password", "NotValidated")
					})), ! function(t) {
						try {
							return new URL(t), !0
						} catch (t) {
							return !1
						}
					}, e.addEventListener("click", (function(o) {
						o.preventDefault(), r.revalidateField("password"), r.validate().then((function(r) {
							"Valid" == r ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, submitForm(t, e)) : Swal.fire({
								text: "Sorry, looks like there are some errors detected, please try again.",
								icon: "error",
								buttonsStyling: !1,

								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn btn-primary"
								}
							})
						}))
					}))
				}
			}
		}();
		KTUtil.onDOMContentLoaded((function() {
			KTAuthNewPassword.init()
		}));
		</script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>