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
								@php
								if(session('penerbit')['STATUS'] == 'notvalid'){
									$href = url('penerbit/dashboard/notvalid');
								} else {
									$href = url('penerbit/dashboard');
								}
								@endphp
								<li class="breadcrumb-item text-muted">
									<a href="{{$href}}" class="text-muted text-hover-primary">Home</a>
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
										<img src="{{ asset('/assets/media/avatars/300-1.jpg') }}" alt="image" />
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
											<div class="d-flex flex-wrap fw-semibold fs-8 mb-4 pe-2">
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
													<div class="fw-semibold fs-8 text-gray-500">ISBN</div>
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
													<div class="fw-semibold fs-8 text-gray-500">KCKR Perpusnas</div>
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
													<div class="fw-semibold fs-8 text-gray-500">KCKR Provinsi</div>
													<!--end::Label-->
												</div>
												<!--end::Stat-->
											</div>
											<!--end::Stats-->
										</div>
										<!--end::Wrapper-->
										<!--begin::Progress-->
										<div class="d-flex align-items-center w-300px w-sm-500px flex-column mt-3">
											<div class="d-flex justify-content-between w-100 mt-auto mb-2">
												<span class="fw-semibold fs-8 text-gray-500">Serah Simpan ke Perpusnas</span>
												<span class="fw-bold fs-8" id="divKepatuhanPerpusnas">35%</span>
											</div>
											<div class="h-5px mx-3 w-100 bg-light mb-3">
												<div class="bg-success rounded h-5px" role="progressbar"
													style="width: 35%;" aria-valuenow="35" aria-valuemin="0"
													aria-valuemax="100" id="progressKepatuhanPerpusnas"></div>
											</div>
											<div class="d-flex justify-content-between w-100 mt-auto mb-2">
												<span class="fw-semibold fs-8 text-gray-500">Serah Simpan ke Provinsi</span>
												<span class="fw-bold fs-8" id="divKepatuhanProvinsi">20%</span>
											</div>
											<div class="h-5px mx-3 w-100 bg-light mb-3">
												<div class="bg-primary rounded h-5px" role="progressbar"
													style="width: 20%;" aria-valuenow="20" aria-valuemin="0"
													aria-valuemax="100" id="progressKepatuhanProvinsi"></div>
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
														<label class="col-lg-4 col-form-label fw-semibold fs-8">Avatar</label>
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
														<label class="col-lg-4 col-form-label required fw-semibold fs-8">Nama Penerbit</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8">
															<!--begin::Row-->
															<div class="row">
																<!--begin::Col-->
																<div class="col-lg-8 fv-row">
																	<input type="text" name="name" class="form-control form-control-lg form-control-solid fs-8" placeholder="Nama Penerbit" value="" readonly="true"/>
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
														<label class="col-lg-4 col-form-label required fw-semibold fs-8">Username</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="username" class="form-control form-control-lg form-control-solid fs-8" placeholder="username" value="" readonly="true"/>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">
															<span class="required">Nomor Telepon</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
																<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="tel" name="phone" class="form-control form-control-lg form-control-solid fs-8" placeholder="Phone number" value="" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">Alamat</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="alamat_penerbit" class="form-control form-control-lg form-control-solid fs-8" placeholder="Alamat / Nama Jalan" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">Nama Gedung</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="nama_gedung" class="form-control form-control-lg form-control-solid fs-8" placeholder="Nama Gedung" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">
															<span class="required">Provinsi</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Provinsi">
																<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-provinsi" name="provinsi" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih provinsi..." class="form-select form-select-solid fs-8 form-select-lg fw-semibold">
																<option value="">Pilih Provinsi...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">
															<span class="required">Kabupaten / Kota</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kabupaten/Kota">
																<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-kabupaten" name="kabkot" aria-label="Pilih Kabupaten/kota" data-control="select2" data-placeholder="Pilih kabupaten/kota..." class="form-select form-select-solid fs-8 form-select-lg fw-semibold">
																<option value="">Pilih Kabupaten/Kota...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">
															<span class="required">Kecamatan</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kecamatan">
																<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-kecamatan" name="kecamatan" aria-label="Pilih kecamatan" data-control="select2" data-placeholder="Pilih kecamatan" class="form-select form-select-solid fs-8 form-select-lg fw-semibold">
																<option value="">Pilih Kecamatan...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-8">
															<span class="required">Kelurahan</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kelurahan">
																<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<select id="select2-kelurahan" name="kelurahan" aria-label="Pilih kelurahan" data-control="select2" data-placeholder="Pilih Kelurahan..." class="form-select form-select-solid fs-8 form-select-lg fw-semibold">
																<option value="">Pilih Kelurahan...</option>
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fs-8 fw-semibold fs-8">File Akta Notaris</label>
														<!-- <div class="col-lg-3 col-form-label fs-8 ">
															<a><i class="bi bi-filetype-pdf fs-1"></i> DummyBuku.pdf</a>
														</div>-->
														<!--end:: Label-->
														<div class="col-lg-3 col-form-label fs-8 " id="view_file_akta_notaris"></div>
														<div class="col-lg-5 d-flex align-items-center">
														<input type="hidden" name="file_akta_notaris" id="file_akta_notaris">
															<!--begin::Dropzone-->
															<div class="dropzone p-0" id="dummy1" style="width:100%">
																<!--begin::Message-->
																<div class="dz-message needsclick align-items-center">
																	<!--begin::Icon-->
																	<i class="ki-outline ki-file-up fs-2hx text-primary"></i>
																	<!--end::Icon-->
																	<!--begin::Info-->
																	<div class="ms-4">
																		<h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan file
																			akta notaris</h3>
																		<span class="fw-semibold fs-7 text-gray-500">Accepted Files: .pdf Max:
																			20MB</span>
																	</div>
																	<!--end::Info-->
																</div>
															</div>
															<!--end::Dropzone-->
														</div>
														<!--begin::Label-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->

														<label class="col-lg-4 col-form-label fs-8 fw-semibold fs-8">File
															Surat Pernyataan</label>
														<div class="col-lg-3 col-form-label fs-8 " id="view_file_surat_pernyataan"></div>
														<!--end:: Label-->
														<div class="col-lg-5 d-flex align-items-center">
														<input type="hidden" name="file_surat_pernyataan" id="file_surat_pernyataan">
															<!--begin::Dropzone-->
															<div class="dropzone p-0" id="attachments1" style="width:100%">
																<!--begin::Message-->
																<div class="dz-message needsclick align-items-center">
																	<!--begin::Icon-->
																	<i class="ki-outline ki-file-up fs-2hx text-primary"></i>
																	<!--end::Icon-->
																	<!--begin::Info-->
																	<div class="ms-4">
																		<h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan
																			Surat Pernyataan</h3>
																		<span class="fw-semibold fs-7 text-gray-500">Max:15MB</span>
																	</div>
																	<!--end::Info-->
																</div>
															</div>
															<!--end::Dropzone-->
														</div>
													</div>
												</div>
												<!--end::Card body-->
												<!--begin::Actions-->
												<div class="card-footer d-flex justify-content-end py-6 px-9">
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
														<div class="fs-8 fw-bold mb-1">Primary Email</div>
														<div class="fw-semibold text-gray-600" id="email1"></div>
													</div>
												</div>
												<!--end::Alternate Email Address-->
												<div class="separator separator-dashed my-6"></div>
												<!--begin::Email Address-->
												<div class="d-flex flex-wrap align-items-center">
													<!--begin::Label-->
													<div id="kt_signin_email">
														<div class="fs-8 fw-bold mb-1">Alternate Email</div>
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
																		<label for="emailaddress" class="form-label fs-8 fw-bold mb-3">Enter New Alternate Email Address</label>
																		<input type="email" class="form-control form-control-lg fs-8" id="alternateemailaddress" placeholder="Email Address" name="alternateemailaddress" value="" />
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="fv-row mb-0">
																		<label for="confirmemailpassword" class="form-label fs-8 fw-bold mb-3">Confirm Password</label>
																		<input type="password" class="form-control form-control-lg fs-8" name="confirmemailpassword" id="confirmemailpassword" />
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
@stop
		
<!--begin::Javascript-->
@section('script')
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('/assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('/assets/js/custom/widgets.js') }}"></script>

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
				profilSubmit();
			})
	})
	document.addEventListener('DOMContentLoaded', function(e) {
		FormValidation.formValidation(
			document.getElementById('change_email'),
			{
                    fields: {
                        confirmemailpassword: {
                            validators: {
                                notEmpty: {
                                    message: "Konfirmasi password diperlukan untuk mengubah email alternatif!"
                                },
                            }
                        },
						alternateemailaddress: {
                            validators: {
                                notEmpty: {
                                    message: "Email alternatif tidak boleh kosong!"
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".col-lg-6"
                        }),
						submitButton: new FormValidation.plugins.SubmitButton(),
						icon: new FormValidation.plugins.Icon({
                            valid: 'fa fa-check',
                            invalid: 'fa fa-times',
                            validating: 'fa fa-refresh',
                        }),
                    }
            }).on('core.form.valid', function() {
				submitForm();
		});
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
				let loc_an = "{{config('app.isbn_file_location')}}"+ "files/penerbit/akte_notaris/" + response['FILE_AKTE_NOTARIS'];
				let loc_sp = "{{config('app.isbn_file_location')}}"+ "files/penerbit/surat_pernyataan/" + response['FILE_SURAT_PERNYATAAN'];
				$('#view_file_akta_notaris').html("<a href='"+loc_an+"' target='_blank'>Akta Notaris</a>");
				$('#view_file_surat_pernyataan').html("<a href='"+loc_sp+"' target='_blank'>Surat Pernyataan</a>");
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
					$('#divKckrPerpusnas').text(response[0]);
					$('#divKckrPerpusnas').attr('data-kt-countup-value',response[0] );
					$('#divKepatuhanPerpusnas').text(response[1] + '%');
					$('#progressKepatuhanPerpusnas').attr('aria-valuenow', response[1]);
					$('#progressKepatuhanPerpusnas').css('width', response[1] + '%');
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
					$('#divKckrProvinsi').text(response[0]);
					$('#divKckrProvinsi').attr('data-kt-countup-value',response[0] );
					$('#divKepatuhanProvinsi').text(response[1] + '%');
					$('#progressKepatuhanProvinsi').attr('aria-valuenow', response[1]);
					$('#progressKepatuhanProvinsi').css('width', response[1] + '%');
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

	$('#kt_signin_email_button').on('click', function(){
		$('#kt_signin_email_edit').removeClass('d-none');
		$('#kt_signin_email').addClass('d-none');
		$(this).addClass('d-none');
	});
	$('#kt_signin_cancel').on('click', function(){
		$('#kt_signin_email_edit').addClass('d-none');
		$('#kt_signin_email').removeClass('d-none');
		$('#kt_signin_email_button').removeClass('d-none');
	});
	var profilSubmit = function(){
		//event.preventDefault();
		Swal.fire({
                    html: `<h2>Anda yakin menyimpan perubahan data akun Anda?</h2>`,
					icon: "warning",
                    width: "900px",
                    height: "80vh",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Ya, saya yakin!",
                    cancelButtonText: "Tidak",
                    
                    customClass: {
                        confirmButton: "btn fw-bold btn-success",
                        cancelButton: "btn fw-bold btn-active-light-danger"
                    }
            	}).then(function(e) {
					if(e.isConfirmed == true) {
                        postFormProfil()
                    } else {
                        $('.loader').css('display', 'none');
                    }
        })
	}
	var postFormProfil = function(){
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
									title: "Berhasil ubah data",
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
	}
	var submitForm = function(){
		let form = document.getElementById('change_email');
		let formData = new FormData(form); 
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').val()
			}
		});
		$.ajax({
							url :"{{ url('/penerbit/profile/change-email') }}",
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
											title: "Berhasil Ubah Email Alternatif!",
											html: xhr.message,
											icon: "success",
											buttonsStyling: !1,
											confirmButtonText: "Ok!",
											customClass: {
												confirmButton: "btn fw-bold btn-primary"
												}
										}).then(function(isConfirm){
											if (isConfirm){
												$('#kt_signin_email_edit').addClass('d-none');
												$('#kt_signin_email').removeClass('d-none');
												$('#kt_signin_submit').addClass('d-none');
												$('kt_signin_email_button').removeClass('d-none');
												$('#email2').text($('#alternateemailaddress').val());
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
	}
	$('#kt_signin_submit').on('click', function(){
		submitForm();
	});
</script>

@stop