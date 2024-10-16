@extends('layouts.index')
@section('content')
<style>
.input-group{
	width:initial;
}
</style>
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Content-->
	<div id="kt_app_content" class="app-content">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-fluid">
			<!--begin::Row-->
			<div class="row g-5 gx-xl-10">
				<div class="card min-w-full">
                    <div class="card-header">
                        <h3 class="card-title text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                            Ubah Password
                        </h3>
                    </div>
					<div id="change_password" class="collapse show">
                        <!--begin::Form-->
                        <form id="form_change_password" class="form">
							@csrf
							<div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                	<!--begin::Label-->
									<label class="col-lg-2 col-form-label fw-semibold fs-8">Password Saat Ini</label>
									<!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-9 input-group">
                                        <input type="password" name="current_password" id="current_password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Isi password lama">
                                    </div>
                                    <!--end::Col-->	
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
                                <div class="row mb-6">
                                	<!--begin::Label-->
									<label class="col-lg-2 col-form-label fw-semibold fs-8">Password Baru</label>
									<!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-9 input-group">
                                        <input type="password" name="new_password" id="new_password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Isi password baru">
                                    </div>
                                    <!--end::Col-->	
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
                                <div class="row mb-6">
                                	<!--begin::Label-->
									<label class="col-lg-2 col-form-label fw-semibold fs-8">Konfirmasi Password Baru</label>
									<!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-9 input-group">
                                        <input type="password" name="confirm_password" id="confirm_password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="Isi konfirmasi password">
                                    </div>
                                    <!--end::Col-->	
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="card-footer d-flex py-6 px-9">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit" >Simpan</button>
                                </div>
                                <!--end::Actions-->
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--end::Row-->

		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>
<!--end::Content wrapper-->
@stop
@section('script')

<script>
	var togglePasswordEye = '<span class="input-group-text" ><i class="fa fa-eye toggle-password-eye"></i></span>';
	var togglePasswordEyeSlash = '<span class="input-group-text" ><i class="fa fa-eye-slash toggle-password-eye"></i></span>';

	$(togglePasswordEyeSlash).insertAfter('input[type=password]');
	$('input[type=password]').addClass('hidden-pass-input');

	$('.toggle-password-eye').on('click', function (e) {
			let password = $(this).parent().prev();

			if (password.attr('type') === 'password') {
				password.attr('type', 'text');
				$(this).addClass('fa-eye').removeClass('fa-eye-slash');
			} else {
				password.attr('type', 'password');
				$(this).addClass('fa-eye-slash').removeClass('fa-eye');
			}
	});
	document.addEventListener('DOMContentLoaded', function(e) {
		FormValidation.formValidation(
			document.getElementById('form_change_password'),
			{
                    fields: {
                        current_password: {
                            validators: {
                                notEmpty: {
                                    message: "Password lama diperlukan. Tidak boleh kosong!"
                                }
                            }
                        },
                        new_password: {
                            validators: {
                                notEmpty: {
                                    message: "Password baru diperlukan. Tidak boleh kosong!"
                                },
								stringLength: {
									min: 8,
									message: 'Password baru minimal terdiri dari 8 karakter'
								},
								regexp: {
									//regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
									regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/,
									message: 'Password wajib terdiri dari huruf besar, huruf kecil, angka, dan karakter khusus'
								}
                            }
                        },
                        confirm_password: {
                            validators: {
                                notEmpty: {
                                    message: "Konfirmasi password baru diperlukan. Tidak boleh kosong!"
                                },
                                identical: {
                                    compare: function() {
                                        return $('input[name="new_password"]').val()
                                    },
                                    message: "Password baru dan konfirmasi password tidak sama"
                                },
								stringLength: {
									min: 8,
									message: 'Password baru minimal terdiri dari 8 karakter'
								},
								regexp: {
									//regexp: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
									regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/,
									message: 'Password wajib terdiri dari huruf besar, huruf kecil, angka, dan karakter khusus'
								}
                            }
                        }
                    },
					
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".col-lg-9"
                        }),
						submitButton: new FormValidation.plugins.SubmitButton(),
						icon: new FormValidation.plugins.Icon({
                            valid: 'fa fa-check',
                            invalid: 'fa fa-times',
                            validating: 'fa fa-refresh',
                        }),
                    }
            }).on('core.form.valid', function() {
				let form = document.getElementById('form_change_password');
				let formData = new FormData(form); 
			
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('input[name="_token"]').val()
					}
				});
				$.ajax({
							url :'{{ url('/penerbit/change-password/submit') }}',
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
												$('#new_password').val(''),$('#current_password').val(''), $('#confirm_password').val('')
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
@stop