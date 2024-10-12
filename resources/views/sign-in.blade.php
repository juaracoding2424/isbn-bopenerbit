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
	<style> 
	.loader {
		position: absolute;
		opacity: 0.8;
		height: 572px;
		width: 600px !important;
		z-index: 10;
		background-image: url("{{ asset('/assets/media/loader.gif') }}");
		background-repeat: no-repeat;
		display: none; 
		background-size: cover;
	}
	a.link-primary{
		color: #2c467e !important;
	}
	.bg-body{
		background-color: #E4EDFF !important;
	}
	.social-box{
		-moz-box-shadow: 0px 0px 20px #383844;
		box-shadow: 0px 0px 20px #383844;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
	}
	</style>
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url("{{asset('assets/media/auth/bg10.jpeg') }}"); } [data-bs-theme="dark"] body { background-image: url("{{asset ('/assets/media/auth/bg10-dark.jpeg') }}"); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid" style='
    background-image: url("{{ asset("assets/media/bg-login.jpeg") }} ");
    background-size: cover;
    background-repeat: no-repeat;
'>
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 " style=" height: 650px;">
				<div class="loader bg-body flex-column flex-center rounded-4 w-md-600px p-10"></div>
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10 social-box">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
							@if(session('status') != null)
								@if(session('status') == 200)
								<div class="alert alert-success d-flex align-items-center p-2 mb-5">
								<i class="ki-solid ki-check fs-2hx text-success me-0"></i>
									<div class="rounded  p-5  d-flex flex-column">
										<div class="d-flex flex-column">
											<h2 class="mb-1 text-success">{{session('pesan')}} </h2>										
										</div>
									</div>
								</div>
								@endif
								@if(session('status') == 500)
								<div class="alert alert-danger d-flex align-items-center p-2 mb-5">
								<i class="ki-solid ki-shield-cross fs-2hx text-danger me-0"></i>
										<div class="rounded p-2  d-flex flex-column">
											<div class="d-flex flex-column">
												<h2 class="mb-1 text-danger">{{session('pesan')}} </h2>										
											</div>
										</div>
									</div>
								@endif
							@endif
								<!--begin::Form-->
								<form class="form w-100" id="signin_form" action="#">
								@csrf
									<!--begin::Heading-->
									<div class="input-group mb-11">
									<input type="hidden" name="_token" value="e3nT8DAAOTfdovMmpIfnvqFUbThgzMMzK8eaezOM" autocomplete="off">
										<div class="logo col-md-5 input-group-text" style="
										border:  none;
										background: url('{{ asset('assets/media/logo.png') }}');
										background-size: contain;
										background-repeat: no-repeat;
										background-position: center;
									"></div>								
										<div class="text-center col-md-7 form-control bg-transparent" style="
										border: none;
										height: 120px;
										">
										<!--begin::Title-->
										<h1 class="text-gray-900 fw-bolder mb-3 mt-5">Login</h1>
										<!--end::Title-->
										<!--begin::Subtitle-->
										<div class="text-gray-700 fw-semibold fs-6">Akun Penerbit</div>
										<!--end::Subtitle=-->
										</div>
										</div>
									<!--begin::Heading-->
									<!--begin::Input group=-->
									<div class="fv-row mb-8">
										<!--begin::Email-->
										<input type="text" placeholder="Email or Username" name="username" autocomplete="off" class="form-control" />
										<!--end::Email-->
									</div>
									<!--end::Input group=-->
									<div class="fv-row mb-3">
										<!--begin::Password-->
										<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control" />
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
									<a href="{{config('app.fo')}}pendaftaran_online" class="link-primary">Pendaftaran penerbit</a></div>
									<!--end::Sign up-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Footer-->
							<div class="d-flex flex-stack">
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
				beforeSend: function(){
					$('.loader').css('display','block');
				},
				complete: function(){
					$('.loader').css('display','none');
				},
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