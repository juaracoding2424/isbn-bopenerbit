@extends('layouts.index')
@section('content')
		<!--begin::Content wrapper-->
		<div class="d-flex flex-column flex-column-fluid">
			<!--begin::Toolbar-->
			<div id="kt_app_toolbar" class="app-toolbar pt-7 pt-lg-10">
				<!--begin::Toolbar container-->
				<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
					<!--begin::Toolbar wrapper-->
					<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
						<!--begin::Page title-->
						<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
							<!--begin::Title-->
							<h1
								class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
								Ikhtisar akun</h1>
							<!--end::Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">
									<a href="index.php" class="text-muted text-hover-primary">Home</a>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item">
									<span class="bullet bg-gray-500 w-5px h-2px"></span>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">Akun</li>
								<!--end::Item-->
							</ul>
							<!--end::Breadcrumb-->
						</div>
						<!--end::Page title-->
					</div>
					<!--end::Toolbar wrapper-->
				</div>
				<!--end::Toolbar container-->
			</div>
			<!--end::Toolbar-->
			<!--begin::Content-->
			<div id="kt_app_content" class="app-content">
				<!--begin::Content container-->
				<div id="kt_app_content_container" class="app-container container-fluid">
					<!--begin::Navbar-->
					<div class="card mb-5 mb-xl-10">
						<div class="card-body pt-9 pb-0">
							<!--begin::Details-->
							<div class="d-flex flex-wrap flex-sm-nowrap">
								<!--begin: Pic-->
								<div class="me-7 mb-4">
									<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
										<img src="/assets/media/avatars/300-1.jpg" alt="image" />
										<div
											class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
										</div>
									</div>
								</div>
								<!--end::Pic-->
								<!--begin::Info-->
								<div class="flex-grow-1">
									<!--begin::Title-->
									<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
										<!--begin::User-->
										<div class="d-flex flex-column">
											<!--begin::Name-->
											<div class="d-flex align-items-center mb-2">
												<a href="#"
													class="text-gray-900 text-hover-primary fs-2 fw-bold me-1" id="aName"></a>
												<a href="#" id="aStatus"></a>
											</div>
											<!--end::Name-->
											<!--begin::Info-->
											<div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
												<a href="#"
													class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
													<i class="ki-outline ki-geolocation fs-4 me-1"></i><span id="spanLocation"></span></a>
												<a href="#"
													class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
													<i class="ki-outline ki-sms fs-4" id="aEmail"></i></a>
												<a href="#"
													class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
													<i class="fa fa-phone fs-4 me-1"></i><span id="spanPhone"></span></a>
											</div>
											<!--end::Info-->
										</div>
										<!--end::User-->
										<!--begin::Actions-->
										<div class="d-flex my-4">
											<a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
												<i class="ki-outline ki-check fs-3 d-none"></i>
												<!--begin::Indicator label-->
												<span class="indicator-label">Follow</span>
												<!--end::Indicator label-->
												<!--begin::Indicator progress-->
												<span class="indicator-progress">Please wait...
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
												<!--end::Indicator progress-->
											</a>
										</div>
										<!--end::Actions-->
									</div>
									<!--end::Title-->
									<!--begin::Stats-->
									<div class="d-flex flex-wrap flex-stack" id="divIsbnStat" style="display:none !important">
										<!--begin::Wrapper-->
										<div class="d-flex flex-column flex-grow-1 pe-8">
											<!--begin::Stats-->
											<div class="d-flex flex-wrap" >
												<!--begin::Stat-->
												<div
													class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<div class="fs-2 fw-bold" data-kt-countup="true"
															data-kt-countup-value="0" data-kt-countup-prefix="" id="divIsbn">0
														</div>
													</div>
													<!--end::Number-->
													<!--begin::Label-->
													<div class="fw-semibold fs-6 text-gray-500">ISBN</div>
													<!--end::Label-->
												</div>
												<!--end::Stat-->
												<!--begin::Stat-->
												<div
													class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<div class="fs-2 fw-bold" data-kt-countup="true"
															data-kt-countup-value="0" id="divKckrPerpusnas">0</div>
													</div>
													<!--end::Number-->
													<!--begin::Label-->
													<div class="fw-semibold fs-6 text-gray-500">KCKR Perpusnas</div>
													<!--end::Label-->
												</div>
												<!--end::Stat-->
												<!--begin::Stat-->
												<div
													class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<div class="fs-2 fw-bold" data-kt-countup="true"
															data-kt-countup-value="0" data-kt-countup-prefix="" id="divKckrProvinsi">0
														</div>
													</div>
													<!--end::Number-->
													<!--begin::Label-->
													<div class="fw-semibold fs-6 text-gray-500">KCKR Provinsi</div>
													<!--end::Label-->
												</div>
												<!--end::Stat-->
											</div>
											<!--end::Stats-->
										</div>
										<!--end::Wrapper-->
										<!--begin::Progress-->
										<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
											<div class="d-flex justify-content-between w-100 mt-auto mb-2">
												<span class="fw-semibold fs-6 text-gray-500">Kepatuhan Penerbit</span>
												<span class="fw-bold fs-6" id="divKepatuhan">35%</span>
											</div>
											<div class="h-5px mx-3 w-100 bg-light mb-3">
												<div class="bg-success rounded h-5px" role="progressbar"
													style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
													aria-valuemax="100" id="progressKepatuhan"></div>
											</div>
										</div>
										<!--end::Progress-->
									</div>
									<!--end::Stats-->
								</div>
								<!--end::Info-->
							</div>
							<!--end::Details-->
						</div>
					</div>
					<!--end::Navbar-->
					<!--begin::details View-->
					<div class="row mb-5 mb-xl-10" id="kt_profile_details_view">
						<div class="mb-xl-10 col-lg-12 col-md-12">
							<div class="flex flex-col gap-5 lg:gap-7.5">
								<div class="card min-w-full">
									<div class="card-header">
										<h3 class="card-title">
											General Info
										</h3>
									</div>
									<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form id="form_akun" class="form">
											@csrf
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8">
															<!--begin::Image input-->
															<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
																<!--begin::Preview existing avatar-->
																<div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
																<!--end::Preview existing avatar-->
																<!--begin::Label-->
																<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																	<i class="ki-outline ki-pencil fs-7"></i>
																	<!--begin::Inputs-->
																	<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
																	<input type="hidden" name="avatar_remove" />
																	<!--end::Inputs-->
																</label>
																<!--end::Label-->
																<!--begin::Cancel-->
																<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																	<i class="ki-outline ki-cross fs-2"></i>
																</span>
																<!--end::Cancel-->
																<!--begin::Remove-->
																<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																	<i class="ki-outline ki-cross fs-2"></i>
																</span>
																<!--end::Remove-->
															</div>
															<!--end::Image input-->
															<!--begin::Hint-->
															<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
															<!--end::Hint-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Penerbit</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8">
															<!--begin::Row-->
															<div class="row">
																<!--begin::Col-->
																<div class="col-lg-8 fv-row">
																	<input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Nama Penerbit" value="" />
																</div>
																<!--end::Col-->
															</div>
															<!--end::Row-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Username</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="username" class="form-control form-control-lg form-control-solid" placeholder="username" value="" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">
															<span class="required">Nomor Telepon</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Alamat</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="alamat_penerbit" class="form-control form-control-lg form-control-solid" placeholder="Alamat / Nama Jalan" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Nama Gedung</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="nama_gedung" class="form-control form-control-lg form-control-solid" placeholder="Nama Gedung" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">
															<span class="required">Provinsi</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Provinsi">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-provinsi" name="provinsi" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih provinsi..." class="form-select form-select-solid form-select-lg fw-semibold">
																<option value="">Pilih Provinsi...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">
															<span class="required">Kabupaten / Kota</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kabupaten/Kota">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-kabupaten" name="kabkot" aria-label="Pilih Kabupaten/kota" data-control="select2" data-placeholder="Pilih kabupaten/kota..." class="form-select form-select-solid form-select-lg fw-semibold">
																<option value="">Pilih Kabupaten/Kota...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">
															<span class="required">Kecamatan</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kecamatan">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-kecamatan" name="kecamatan" aria-label="Pilih kecamatan" data-control="select2" data-placeholder="Pilih kecamatan" class="form-select form-select-solid form-select-lg fw-semibold">
																<option value="">Pilih Kecamatan...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">
															<span class="required">Kelurahan</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kelurahan">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-kelurahan" name="kelurahan" aria-label="Pilih kelurahan" data-control="select2" data-placeholder="Pilih Kelurahan..." class="form-select form-select-solid form-select-lg fw-semibold">
																<option value="">Pilih Kelurahan...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Card body-->
												<!--begin::Actions-->
												<div class="card-footer d-flex justify-content-end py-6 px-9">
													<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
													<button type="submit" class="btn btn-primary" >Save Changes</button>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Form-->
										</div>
										<!--end::Content-->
								</div>
							</div>
							<!--begin::Sign-in Method-->
							<div class="card mb-5 mb-xl-10">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Akun Email</h3>
											</div>
										</div>
										<!--end::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_signin_method" class="collapse show">
											<!--begin::Card body-->
											<div class="card-body border-top p-9">
												<!--begin::Alternate Email Address-->
												<div class="d-flex flex-wrap align-items-center">
													<div id="alternateemail">
														<div class="fs-6 fw-bold mb-1">Primary Email</div>
														<div class="fw-semibold text-gray-600" id="email1"></div>
													</div>
												</div>
												<!--end::Alternate Email Address-->
												<div class="separator separator-dashed my-6"></div>
												<!--begin::Email Address-->
												<div class="d-flex flex-wrap align-items-center">
													<!--begin::Label-->
													<div id="kt_signin_email">
														<div class="fs-6 fw-bold mb-1">Alternate Email</div>
														<div class="fw-semibold text-gray-600" id="email2"></div>
													</div>
													
													<!--end::Label-->
													<!--begin::Edit-->
													<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
														<!--begin::Form-->
														<form id="change_email" class="form" novalidate="novalidate">
															<div class="row mb-6">
																<div class="col-lg-6 mb-4 mb-lg-0">
																	<div class="fv-row mb-0">
																		<label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New Alternate Email Address</label>
																		<input type="email" class="form-control form-control-lg form-control-solid" id="alternateemailaddress" placeholder="Email Address" name="alternateemailaddress" value="" />
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="fv-row mb-0">
																		<label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
																		<input type="password" class="form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" />
																	</div>
																</div>
															</div>
															<div class="d-flex">
																<button id="kt_signin_submit" type="button" class="btn btn-primary me-2 px-6">Update Email</button>
																<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
															</div>
														</form>
														<!--end::Form-->
													</div>
													<!--end::Edit-->
													<!--begin::Action-->
													<div id="kt_signin_email_button" class="ms-auto">
														<button class="btn btn-light btn-active-light-primary">Change Email</button>
													</div>
													<!--end::Action-->
												</div>
												<!--end::Email Address-->
												
												<div class="separator separator-dashed my-6"></div>
												
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Content-->
									</div>
									<!--end::Sign-in Method-->
						</div>
					</div>
					<!--end::details View-->
				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Content wrapper-->
		<!--begin::Modal - Two-factor authentication-->
		<div class="modal fade" id="kt_modal_two_factor_authentication" tabindex="-1" aria-hidden="true">
			<!--begin::Modal header-->
			<div class="modal-dialog modal-dialog-centered mw-650px">
				<!--begin::Modal content-->
				<div class="modal-content">
					<!--begin::Modal header-->
					<div class="modal-header flex-stack">
						<!--begin::Title-->
						<h2>Choose An Authentication Method</h2>
						<!--end::Title-->
						<!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<i class="ki-outline ki-cross fs-1"></i>
						</div>
						<!--end::Close-->
					</div>
					<!--begin::Modal header-->
					<!--begin::Modal body-->
					<div class="modal-body scroll-y pt-10 pb-15 px-lg-17">
						<!--begin::Options-->
						<div data-kt-element="options">
							<!--begin::Notice-->
							<p class="text-muted fs-5 fw-semibold mb-10">In addition to your username and password, you’ll have to enter a code (delivered via app or SMS) to log into your account.</p>
							<!--end::Notice-->
							<!--begin::Wrapper-->
							<div class="pb-10">
								<!--begin::Option-->
								<input type="radio" class="btn-check" name="auth_option" value="apps" checked="checked" id="kt_modal_two_factor_authentication_option_1" />
								<label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="kt_modal_two_factor_authentication_option_1">
									<i class="ki-outline ki-setting-2 fs-4x me-4"></i>
									<span class="d-block fw-semibold text-start">
										<span class="text-gray-900 fw-bold d-block fs-3">Authenticator Apps</span>
										<span class="text-muted fw-semibold fs-6">Get codes from an app like Google Authenticator, Microsoft Authenticator, Authy or 1Password.</span>
									</span>
								</label>
								<!--end::Option-->
								<!--begin::Option-->
								<input type="radio" class="btn-check" name="auth_option" value="sms" id="kt_modal_two_factor_authentication_option_2" />
								<label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="kt_modal_two_factor_authentication_option_2">
									<i class="ki-outline ki-message-text-2 fs-4x me-4"></i>
									<span class="d-block fw-semibold text-start">
										<span class="text-gray-900 fw-bold d-block fs-3">SMS</span>
										<span class="text-muted fw-semibold fs-6">We will send a code via SMS if you need to use your backup login method.</span>
									</span>
								</label>
								<!--end::Option-->
							</div>
							<!--end::Options-->
							<!--begin::Action-->
							<button class="btn btn-primary w-100" data-kt-element="options-select">Continue</button>
							<!--end::Action-->
						</div>
						<!--end::Options-->
						<!--begin::Apps-->
						<div class="d-none" data-kt-element="apps">
							<!--begin::Heading-->
							<h3 class="text-gray-900 fw-bold mb-7">Authenticator Apps</h3>
							<!--end::Heading-->
							<!--begin::Description-->
							<div class="text-gray-500 fw-semibold fs-6 mb-10">Using an authenticator app like 
							<a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google Authenticator</a>, 
							<a href="https://www.microsoft.com/en-us/account/authenticator" target="_blank">Microsoft Authenticator</a>, 
							<a href="https://authy.com/download/" target="_blank">Authy</a>, or 
							<a href="https://support.1password.com/one-time-passwords/" target="_blank">1Password</a>, scan the QR code. It will generate a 6 digit code for you to enter below. 
							<!--begin::QR code image-->
							<div class="pt-5 text-center">
								<img src="assets/media/misc/qr.png" alt="" class="mw-150px" />
							</div>
							<!--end::QR code image--></div>
							<!--end::Description-->
							<!--begin::Notice-->
							<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-10 p-6">
								<!--begin::Icon-->
								<i class="ki-outline ki-information fs-2tx text-warning me-4"></i>
								<!--end::Icon-->
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack flex-grow-1">
									<!--begin::Content-->
									<div class="fw-semibold">
										<div class="fs-6 text-gray-700">If you having trouble using the QR code, select manual entry on your app, and enter your username and the code: 
										<div class="fw-bold text-gray-900 pt-2">KBSS3QDAAFUMCBY63YCKI5WSSVACUMPN</div></div>
									</div>
									<!--end::Content-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Notice-->
							<!--begin::Form-->
							<form data-kt-element="apps-form" class="form" action="#">
								<!--begin::Input group-->
								<div class="mb-10 fv-row">
									<input type="text" class="form-control form-control-lg form-control-solid" placeholder="Enter authentication code" name="code" />
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="d-flex flex-center">
									<button type="reset" data-kt-element="apps-cancel" class="btn btn-light me-3">Cancel</button>
									<button type="submit" data-kt-element="apps-submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Options-->
						<!--begin::SMS-->
						<div class="d-none" data-kt-element="sms">
							<!--begin::Heading-->
							<h3 class="text-gray-900 fw-bold fs-3 mb-5">SMS: Verify Your Mobile Number</h3>
							<!--end::Heading-->
							<!--begin::Notice-->
							<div class="text-muted fw-semibold mb-10">Enter your mobile phone number with country code and we will send you a verification code upon request.</div>
							<!--end::Notice-->
							<!--begin::Form-->
							<form data-kt-element="sms-form" class="form" action="#">
								<!--begin::Input group-->
								<div class="mb-10 fv-row">
									<input type="text" class="form-control form-control-lg form-control-solid" placeholder="Mobile number with country code..." name="mobile" />
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="d-flex flex-center">
									<button type="reset" data-kt-element="sms-cancel" class="btn btn-light me-3">Cancel</button>
									<button type="submit" data-kt-element="sms-submit" class="btn btn-primary">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait... 
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::SMS-->
					</div>
					<!--begin::Modal body-->
				</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal header-->
		</div>
		<!--end::Modal - Two-factor authentication-->
@stop
		
<!--begin::Javascript-->
@section('script')
<!--begin::Custom Javascript(used for this page only)-->

		<script src="/assets/js/widgets.bundle.js"></script>
		<script src="/assets/js/custom/widgets.js"></script>
		<!--script src="/assets/js/custom/apps/chat/chat.js"></script>
		<script src="/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="/assets/js/custom/utilities/modals/create-campaign.js"></script>
		<script src="/assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
		<script src="/assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
		<script src="/assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
		<script src="/assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
		<script src="/assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
		<script src="/assets/js/custom/utilities/modals/two-factor-authentication.js"></script>
		<script src="/assets/js/custom/utilities/modals/users-search.js"></script>
		<end::Custom Javascript-->
<!--begin::Custom Javascript(used for this page only)-->

<!--end::Body-->
<script>
		document.addEventListener('DOMContentLoaded', function(e) {
		FormValidation.formValidation(
			document.getElementById('form_akun'),
			{
                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: "Nama penerbit diperlukan. Tidak boleh kosong!"
                                },
								stringLength: {
									min: 8,
									message: 'Nama penerbit tidak boleh kurang dari 8 karakter!'
								},
                            }
                        },
						username: {
                            validators: {
                                notEmpty: {
                                    message: "Username penerbit diperlukan untuk login ke dalam layanan ISBN. Tidak boleh kosong!"
                                },
								stringLength: {
									min: 6,
									message: 'Username penerbit tidak boleh kurang dari 6 karakter!'
								},
                            }
                        },
						phone: {
                            validators: {
                                notEmpty: {
                                    message: "Telepon penerbit diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
						alamat_penerbit: {
                            validators: {
                                notEmpty: {
                                    message: "Alamat penerbit diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
						provinsi: {
                            validators: {
                                notEmpty: {
                                    message: "Provinsi diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
						kabkot: {
                            validators: {
                                notEmpty: {
                                    message: "Kabupaten/Kota diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
						kecamatan: {
                            validators: {
                                notEmpty: {
                                    message: "Kecamatan domisili penerbit diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
						kelurahan: {
                            validators: {
                                notEmpty: {
                                    message: "Kelurahan domisili penerbit diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".col-lg-8"
                        }),
						submitButton: new FormValidation.plugins.SubmitButton(),
						icon: new FormValidation.plugins.Icon({
                            valid: 'fa fa-check',
                            invalid: 'fa fa-times',
                            validating: 'fa fa-refresh',
                        }),
                    }
            }).on('core.form.valid', function() {
				let form = document.getElementById('form_akun');
				let formData = new FormData(form); 
			
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('input[name="_token"]').val()
					}
				});
				$.ajax({
							url :"{{ url('/penerbit/profile/submit') }}",
							type: 'post',
							dataType: 'json',
							processData: false,
							contentType:  false,
							async:false,
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
								200: function(xhr) {
									Swal.fire({
											title: "Berhasil Ubah Password!",
											html: xhr.message,
											icon: "success",
											buttonsStyling: !1,
											confirmButtonText: "Ok!",
											customClass: {
												confirmButton: "btn fw-bold btn-primary"
												}
										}).then(function(isConfirm){
											if (isConfirm){
												//$('#new_password').val(''),$('#current_password').val(''), $('#confirm_password').val('')
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
												confirmButton: "btn fw-bold btn-danger"
												}
										});
								},
							}
					});

				})
	})
</script>
<script>
	var status = "{{session('penerbit')['STATUS']}}";
	function getData(){
	$.ajax({
            url: "{{ url('penerbit/profile/detail') }}",
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(response) {
				$('#aName').text(response['NAMA_PENERBIT']);
				$('#aEmail').text(response['ADMIN_EMAIL']);
				$('#spanLocation').html(response['NAMAPROPINSI'] + ', ' + response['NAMAKAB'] + " | " + response['ALAMAT_PENERBIT'] + ' ' + response['NAMA_GEDUNG']);
				$('#spanPhone').html(response['ADMIN_PHONE']);
				if(response['STATUS'] == 'VALID'){
					$('#aStatus').html('<i class="ki-outline ki-verify fs-1 text-primary"></i>');
					$('#divIsbnStat').attr('style', 'display: block !important');
					
				} else {
					$('#aStatus').html('<i class="ki-outline ki-cross-circle fs-1 text-danger"></i>');
					$('#divIsbnStat').attr('style', 'display:none !important');
				}
				$('input[name="name"]').val(response['NAMA_PENERBIT']);
				$('input[name="username"]').val(response['USER_NAME']);
				$('input[name="phone"]').val(response['ADMIN_PHONE']);
				$('input[name="alamat_penerbit"]').val(response['ALAMAT_PENERBIT']);
				$('input[name="nama_gedung"]').val(response['NAMA_GEDUNG']);
				$('#email1').text(response['ADMIN_EMAIL']);
				$('#email2').text(response['ALTERNATE_EMAIL']);
				$('#alternateemailaddress').val(response['ALTERNATE_EMAIL']);
				$.getJSON(urlProvinsi, function (res) {
					data = [{
						id: "",
						nama: "- Pilih Provinsi -",
						text: "- Pilih Provinsi -"
					}].concat(res);

					//implemen data ke select provinsi
					$("#select2-provinsi").select2({
						dropdownAutoWidth: true,
						width: '100%',
						data: data
					}) ;
					$('#select2-provinsi').val(response['PROVINCE_ID']).trigger('change'); 
				});

				var selectProv = $('#select2-provinsi');
				$(selectProv).change(function () {
					var value = $(selectProv).val();
					clearOptions('select2-kabupaten');
					if (value) {

						var text = $('#select2-provinsi :selected').text();
						$.getJSON(urlKabupaten + value, function(res) {
							data = [{
								id: "",
								nama: "- Pilih Kabupaten -",
								text: "- Pilih Kabupaten -"
							}].concat(res);

							//implemen data ke select provinsi
							$("#select2-kabupaten").select2({
								dropdownAutoWidth: true,
								width: '100%',
								data: data,
								async : false,
							});
							$('#select2-kabupaten').val(response['CITY_ID']).trigger('change');
							
						})
					}
				});
				var selectKab = $('#select2-kabupaten');
				$(selectKab).change(function () {
					var value = $(selectKab).val();
					clearOptions('select2-kecamatan');

					if (value) {
						var text = $('#select2-kabupaten :selected').text();
						$.getJSON(urlKecamatan + value, function(res) {
							data = [{
								id: "",
								nama: "- Pilih Kecamatan -",
								text: "- Pilih Kecamatan -"
							}].concat(res);

							//implemen data ke select provinsi
							$("#select2-kecamatan").select2({
								dropdownAutoWidth: true,
								width: '100%',
								data: data
							});
							console.log(response['CODEKEC']);
							$('#select2-kecamatan').val(response['DISTRICT_ID']).trigger('change');
						})
					}
				});
				var selectKec = $('#select2-kecamatan');
				$(selectKec).change(function () {
					var value = $(selectKec).val();
					clearOptions('select2-kelurahan');

					if (value) {
						var text = $('#select2-kecamatan :selected').text();
						$.getJSON(urlKelurahan + value, function(res) {

							data = [{
								id: "",
								nama: "- Pilih Kelurahan -",
								text: "- Pilih Kelurahan -"
							}].concat(res);

							//implemen data ke select provinsi
							$("#select2-kelurahan").select2({
								dropdownAutoWidth: true,
								width: '100%',
								data: data
							})
							$('#select2-kelurahan').val(response['VILLAGE_ID']).trigger('change');
						})
					}
				});

				var selectKel = $('#select2-kelurahan');
				$(selectKel).change(function () {
					var value = $(selectKel).val();
					if (value) {
						var text = $('#select2-kelurahan :selected').text();
						console.log("value = " + value + " / " + "text = " + text);
					}
				});
            }
        });
	
	}

	if(status == 'valid'){
		$.ajax({
				url: "{{ url('penerbit/dashboard/total-isbn') }}" + '?status=diterima',
				type: 'GET',
				contentType: false,
				processData: false,
				success: function(response) {
					$('#divIsbn').text(response);
					$('#divIsbn').attr('data-kt-countup-value',response );
				},
				error: function() {
					Toast.fire({
						icon: 'error',
						title: 'Server Error!'
					});
				}
		});
		$.ajax({
				url: "{{ url('penerbit/dashboard/kckr-perpusnas') }}",
				type: 'GET',
				contentType: false,
				processData: false,
				success: function(response) {
					$('#divKckrPerpusnas').text(response);
					$('#divKckrPerpusnas').attr('data-kt-countup-value',response );
				},
				error: function() {
					Toast.fire({
						icon: 'error',
						title: 'Server Error!'
					});
				}
		});
		$.ajax({
				url: "{{ url('penerbit/dashboard/kckr-provinsi') }}",
				type: 'GET',
				contentType: false,
				processData: false,
				success: function(response) {
					$('#divKckrProvinsi').text(response);
					$('#divKckrProvinsi').attr('data-kt-countup-value',response );
				},
				error: function() {
					Toast.fire({
						icon: 'error',
						title: 'Server Error!'
					});
				}
		});
	}
	
	getData("{{session('penerbit')['ID']}}");
	var urlProvinsi = "{{url('location/province')}}" + "/";
	var urlKabupaten = "{{url('location/kabupaten')}}" + "/";
	var urlKecamatan = "{{url('location/kecamatan')}}" + "/";
	var urlKelurahan = "{{url('location/kelurahan')}}" + "/";
	function clearOptions(id) {
		//console.log("on clearOptions :" + id);
			//$('#' + id).val(null);
		$('#' + id).empty().trigger('change');
	}
</script>

@stop