<?php include 'header.php';?>
<!--begin::Wrapper-->
<div class="app-wrapper d-flex" id="kt_app_wrapper">
	<!--begin::Sidebar-->
	<?php include 'sidebar.php';?>
	<!--end::Sidebar-->
	<!--begin::Main-->
	<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
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
										<img src="assets/media/avatars/300-1.jpg" alt="image" />
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
													class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">Gramedia
													Pustaka Utama</a>
												<a href="#">
													<i class="ki-outline ki-verify fs-1 text-primary"></i>
												</a>
											</div>
											<!--end::Name-->
											<!--begin::Info-->
											<div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
												<a href="#"
													class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
													<i class="ki-outline ki-geolocation fs-4 me-1"></i>Jakarta Pusat,
													DKI Jakarta</a>
												<a href="#"
													class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
													<i class="ki-outline ki-sms fs-4"></i>gramediabooks@mail.com</a>
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
									<div class="d-flex flex-wrap flex-stack">
										<!--begin::Wrapper-->
										<div class="d-flex flex-column flex-grow-1 pe-8">
											<!--begin::Stats-->
											<div class="d-flex flex-wrap">
												<!--begin::Stat-->
												<div
													class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
													<!--begin::Number-->
													<div class="d-flex align-items-center">
														<div class="fs-2 fw-bold" data-kt-countup="true"
															data-kt-countup-value="1205" data-kt-countup-prefix="">0
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
															data-kt-countup-value="502">0</div>
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
															data-kt-countup-value="60" data-kt-countup-prefix="">0
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
												<span class="fw-bold fs-6">35%</span>
											</div>
											<div class="h-5px mx-3 w-100 bg-light mb-3">
												<div class="bg-success rounded h-5px" role="progressbar"
													style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
													aria-valuemax="100"></div>
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
											<form id="kt_account_profile_details_form" class="form">
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
																	<input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Nama Penerbit" value="Gramedia Pustaka Utama" />
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
															<input type="text" name="username" class="form-control form-control-lg form-control-solid" placeholder="username" value="grampustaka" />
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
															<input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="+62 3276 454 935" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Website</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="website" class="form-control form-control-lg form-control-solid" placeholder="Website" value="website.com" />
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
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Communication</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<!--begin::Options-->
															<div class="d-flex align-items-center mt-3">
																<!--begin::Option-->
																<label class="form-check form-check-custom form-check-inline form-check-solid me-5">
																	<input class="form-check-input" name="communication[]" type="checkbox" value="1" />
																	<span class="fw-semibold ps-2 fs-6">Email</span>
																</label>
																<!--end::Option-->
																<!--begin::Option-->
																<label class="form-check form-check-custom form-check-inline form-check-solid">
																	<input class="form-check-input" name="communication[]" type="checkbox" value="2" />
																	<span class="fw-semibold ps-2 fs-6">Phone</span>
																</label>
																<!--end::Option-->
															</div>
															<!--end::Options-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-0">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Allow Marketing</label>
														<!--begin::Label-->
														<!--begin::Label-->
														<div class="col-lg-8 d-flex align-items-center">
															<div class="form-check form-check-solid form-switch form-check-custom fv-row">
																<input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing" checked="checked" />
																<label class="form-check-label" for="allowmarketing"></label>
															</div>
														</div>
														<!--begin::Label-->
													</div>
													<!--end::Input group-->
												</div>
												<!--end::Card body-->
												<!--begin::Actions-->
												<div class="card-footer d-flex justify-content-end py-6 px-9">
													<button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
													<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
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
												<h3 class="fw-bold m-0">Sign-in Method</h3>
											</div>
										</div>
										<!--end::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_signin_method" class="collapse show">
											<!--begin::Card body-->
											<div class="card-body border-top p-9">
												<!--begin::Email Address-->
												<div class="d-flex flex-wrap align-items-center">
													<!--begin::Label-->
													<div id="kt_signin_email">
														<div class="fs-6 fw-bold mb-1">Email Address</div>
														<div class="fw-semibold text-gray-600">support@keenthemes.com</div>
													</div>
													<!--end::Label-->
													<!--begin::Edit-->
													<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
														<!--begin::Form-->
														<form id="kt_signin_change_email" class="form" novalidate="novalidate">
															<div class="row mb-6">
																<div class="col-lg-6 mb-4 mb-lg-0">
																	<div class="fv-row mb-0">
																		<label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New Email Address</label>
																		<input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="emailaddress" value="support@keenthemes.com" />
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
												<!--begin::Separator-->
												<div class="separator separator-dashed my-6"></div>
												<!--end::Separator-->
												<!--begin::Password-->
												<div class="d-flex flex-wrap align-items-center mb-10">
													<!--begin::Label-->
													<div id="kt_signin_password">
														<div class="fs-6 fw-bold mb-1">Password</div>
														<div class="fw-semibold text-gray-600">************</div>
													</div>
													<!--end::Label-->
													<!--begin::Edit-->
													<div id="kt_signin_password_edit" class="flex-row-fluid d-none">
														<!--begin::Form-->
														<form id="kt_signin_change_password" class="form" novalidate="novalidate">
															<div class="row mb-1">
																<div class="col-lg-4">
																	<div class="fv-row mb-0">
																		<label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current Password</label>
																		<input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
																	</div>
																</div>
																<div class="col-lg-4">
																	<div class="fv-row mb-0">
																		<label for="newpassword" class="form-label fs-6 fw-bold mb-3">New Password</label>
																		<input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
																	</div>
																</div>
																<div class="col-lg-4">
																	<div class="fv-row mb-0">
																		<label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
																		<input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" />
																	</div>
																</div>
															</div>
															<div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
															<div class="d-flex">
																<button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">Update Password</button>
																<button id="kt_password_cancel" type="button" class="btn btn-color-gray-500 btn-active-light-primary px-6">Cancel</button>
															</div>
														</form>
														<!--end::Form-->
													</div>
													<!--end::Edit-->
													<!--begin::Action-->
													<div id="kt_signin_password_button" class="ms-auto">
														<button class="btn btn-light btn-active-light-primary">Reset Password</button>
													</div>
													<!--end::Action-->
												</div>
												<!--end::Password-->
												<!--begin::Notice-->
												<div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
													<!--begin::Icon-->
													<i class="ki-outline ki-shield-tick fs-2tx text-primary me-4"></i>
													<!--end::Icon-->
													<!--begin::Wrapper-->
													<div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
														<!--begin::Content-->
														<div class="mb-3 mb-md-0 fw-semibold">
															<h4 class="text-gray-900 fw-bold">Secure Your Account</h4>
															<div class="fs-6 text-gray-700 pe-7">Two-factor authentication adds an extra layer of security to your account. To log in, in addition you'll need to provide a 6 digit code</div>
														</div>
														<!--end::Content-->
														<!--begin::Action-->
														<a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication">Enable</a>
														<!--end::Action-->
													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Notice-->
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
		<!--begin::Footer-->
		<div id="kt_app_footer" class="app-footer">
			<!--begin::Footer container-->
			<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
				<!--begin::Copyright-->
				<div class="text-gray-900 order-2 order-md-1">
					<span class="text-muted fw-semibold me-1">2024&copy;</span>
					<a href="https://perpusnas.go.id" target="_blank"
						class="text-gray-800 text-hover-primary">Perpustakaan Nasional RI</a>
				</div>
				<!--end::Copyright-->
				<!--begin::Menu-->
				<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
					<li class="menu-item">
						<a href="faq.php" target="_blank" class="menu-link px-2">FAQ</a>
					</li>
					<li class="menu-item">
						<a href="template.php" target="_blank" class="menu-link px-2">Template Surat</a>
					</li>
					<li class="menu-item">
						<a href="berita.php" target="_blank" class="menu-link px-2">Berita</a>
					</li>
				</ul>
				<!--end::Menu-->
			</div>
			<!--end::Footer container-->
		</div>
		<!--end::Footer-->
	</div>
	<!--end:::Main-->
	<?php include 'sidebar_aside.php';?>
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::App-->
<?php include 'log_aktifitas.php';?>
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->
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
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="assets/js/custom/account/settings/signin-methods.js"></script>
		<script src="assets/js/custom/account/settings/profile-details.js"></script>
		<script src="assets/js/custom/account/settings/deactivate-account.js"></script>
		<script src="assets/js/custom/pages/user-profile/general.js"></script>
		<script src="assets/js/widgets.bundle.js"></script>
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="assets/js/custom/utilities/modals/create-campaign.js"></script>
		<script src="assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
		<script src="assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
		<script src="assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
		<script src="assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
		<script src="assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
		<script src="assets/js/custom/utilities/modals/two-factor-authentication.js"></script>
		<script src="assets/js/custom/utilities/modals/users-search.js"></script>
		<!--end::Custom Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="assets/js/widgets.bundle.js"></script>
<script src="assets/js/custom/widgets.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
<script>
		var urlProvinsi = "https://ibnux.github.io/data-indonesia/provinsi.json";
		var urlKabupaten = "https://ibnux.github.io/data-indonesia/kabupaten/";
		var urlKecamatan = "https://ibnux.github.io/data-indonesia/kecamatan/";
		var urlKelurahan = "https://ibnux.github.io/data-indonesia/kelurahan/";

		function clearOptions(id) {
			console.log("on clearOptions :" + id);
			//$('#' + id).val(null);
			$('#' + id).empty().trigger('change');
		}

		console.log('Load Provinsi...');
		$.getJSON(urlProvinsi, function (res) {

		res = $.map(res, function (obj) {
			obj.text = obj.nama
			return obj;
		});

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
		})
		});
		var selectProv = $('#select2-provinsi');
        $(selectProv).change(function () {
            var value = $(selectProv).val();
            clearOptions('select2-kabupaten');

            if (value) {
                console.log("on change selectProv");

                var text = $('#select2-provinsi :selected').text();
                console.log("value = " + value + " / " + "text = " + text);

                console.log('Load Kabupaten di '+text+'...')
                $.getJSON(urlKabupaten + value + ".json", function(res) {

                    res = $.map(res, function (obj) {
                        obj.text = obj.nama
                        return obj;
                    });

                    data = [{
                        id: "",
                        nama: "- Pilih Kabupaten -",
                        text: "- Pilih Kabupaten -"
                    }].concat(res);

                    //implemen data ke select provinsi
                    $("#select2-kabupaten").select2({
                        dropdownAutoWidth: true,
                        width: '100%',
                        data: data
                    })
                })
            }
        });

        var selectKab = $('#select2-kabupaten');
        $(selectKab).change(function () {
            var value = $(selectKab).val();
            clearOptions('select2-kecamatan');

            if (value) {
                console.log("on change selectKab");

                var text = $('#select2-kabupaten :selected').text();
                console.log("value = " + value + " / " + "text = " + text);

                console.log('Load Kecamatan di '+text+'...')
                $.getJSON(urlKecamatan + value + ".json", function(res) {

                    res = $.map(res, function (obj) {
                        obj.text = obj.nama
                        return obj;
                    });

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
                    })
                })
            }
        });

        var selectKec = $('#select2-kecamatan');
        $(selectKec).change(function () {
            var value = $(selectKec).val();
            clearOptions('select2-kelurahan');

            if (value) {
                console.log("on change selectKec");

                var text = $('#select2-kecamatan :selected').text();
                console.log("value = " + value + " / " + "text = " + text);

                console.log('Load Kelurahan di '+text+'...')
                $.getJSON(urlKelurahan + value + ".json", function(res) {

                    res = $.map(res, function (obj) {
                        obj.text = obj.nama
                        return obj;
                    });

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
                })
            }
        });

        var selectKel = $('#select2-kelurahan');
        $(selectKel).change(function () {
            var value = $(selectKel).val();

            if (value) {
                console.log("on change selectKel");

                var text = $('#select2-kelurahan :selected').text();
                console.log("value = " + value + " / " + "text = " + text);
            }
        });
</script>

</html>