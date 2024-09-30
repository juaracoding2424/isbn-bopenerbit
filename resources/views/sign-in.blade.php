<html lang="en">
	<!--begin::Head-->
	<head>
		<title>ISBN Indonesia</title>
		<meta charset="utf-8" />
		<meta name="description" content="Portal ISBN" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="id_ID" />
		<meta property="og:title" content="Portal ISBN" />
		<meta property="og:url" content="https://isbn.perpusnas.go.id" />
		<meta property="og:site_name" content="Portal ISBN Perpusnas" />
		<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center" onkeypress="clickPress(event)">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url("{{asset('assets/media/auth/bg10.jpeg') }}"); } [data-bs-theme="dark"] body { background-image: url("{{asset ('/assets/media/auth/bg10-dark.jpeg') }}"); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{asset ('assets/media/auth/agency.png') }}" alt="" />
						<img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('assets/media/auth/agency-dark.png') }}" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">Selamat datang, para penerbit di Indonesia!</h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="text-gray-600 fs-base text-center fw-semibold">Penerbitan buku ber-ISBN berguna untuk memastikan identifikasi global,
						 mempermudah distribusi internasional, serta meningkatkan kredibilitas dan profesionalisme dalam penerbitan. 
						 <br/>
						Mari, bersama-sama kita tingkatkan standar dalam industri penerbitan, dengan menggunakan nomor standar buku internasional (ISBN).</div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->
								<form class="form w-100" id="signin_form" action="#">
								@csrf
									<!--begin::Heading-->
									<div class="text-center mb-11">
										<!--begin::Title-->
										<h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
										<!--end::Title-->
										<!--begin::Subtitle-->
										<div class="text-gray-500 fw-semibold fs-6">Akun Penerbit</div>
										<!--end::Subtitle=-->
									</div>
									<!--begin::Heading-->
									<!--begin::Input group=-->
									<div class="fv-row mb-8">
										<!--begin::Email-->
										<input type="text" placeholder="Email or Username" name="username" autocomplete="off" class="form-control bg-transparent" />
										<!--end::Email-->
									</div>
									<!--end::Input group=-->
									<div class="fv-row mb-3">
										<!--begin::Password-->
										<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
										<!--end::Password-->
									</div>
									<!--end::Input group=-->
									<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
										<div></div>
										<!--begin::Link-->
										<a href="{{url('/reset-password')}}" class="link-primary">Forgot Password ?</a>
										<!--end::Link-->
									</div>
									<!--end::Wrapper-->
									<!--begin::Submit button-->
									<div class="d-grid mb-10">
										<span id="submitBtn" class="btn btn-primary" onclick="submitBtnClick(event)">
											<!--begin::Indicator label-->
											<span class="indicator-label">Sign In</span>
											<!--end::Indicator label-->
											<!--begin::Indicator progress-->
											<span class="indicator-progress">Please wait... 
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											<!--end::Indicator progress-->
										</span>
									</div>
									<!--end::Submit button-->
									<!--begin::Sign up-->
									<div class="text-gray-500 text-center fw-semibold fs-6">Belum memiliki akun? 
									<a href="{{config('app.pendaftaran')}}" class="link-primary">Pendaftaran penerbit</a></div>
									<!--end::Sign up-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Footer-->
							<div class="d-flex flex-stack">
								<!--begin::Links-->
								<div class="d-flex fw-semibold text-primary fs-base gap-5">
									<a href="pages/team.html" target="_blank">Terms</a>
									<a href="pages/pricing/column.html" target="_blank">Plans</a>
									<a href="pages/contact.html" target="_blank">Contact Us</a>
								</div>
								<!--end::Links-->
							</div>
							<!--end::Footer-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<script>
		var clickPress =  function(event) {
			if (event.keyCode == 13) {
				submitBtnClick(event);
			}
		}
		var submitBtnClick = function(e){
			e.preventDefault();
			let form = document.getElementById('signin_form');
			let formData = new FormData(form); 
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			});
			$.ajax({
                url :'{{ url('auth/submit') }}',
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType:  false,
                data: formData,
                statusCode: {
                    422: function(xhr) {
                        var error = '<div class="alert alert-danger d-flex align-items-center p-5 mb-10"><div class="d-flex flex-column" style="text-align: left;"><ul>';
                        $.each(xhr.responseJSON.err, function(key, value){
                            error+='<li>'+value[0]+'</li>';
                        }); 
                        error+='</ul></div></div>';
                        Swal.fire({
                                title: "Validation Error!",
                                html: error,
                                buttonsStyling: !1,
                                confirmButtonText: "Ok!",
                                width: '800px',
                                heightAuto:false,
                                height: '800px',
                                customClass: { 
                                    confirmButton: "btn fw-bold btn-primary",
                                    content: "swal-height"
                                }
                            });
                    },
                    500: function(xhr) {
                        Swal.fire({
                                text: xhr.responseJSON.message,
                                icon: "failed",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                    }
                            });
                    },
					200: function(response) {
						if(response.penerbitstatus == 'valid'){
							location.href = '{{url('penerbit/dashboard')}}';
						} else {
							location.href = '{{url('penerbit/dashboard/notvalid')}}';
						}
					}
                }
        	});
		}
		</script>
	</body>
</html>