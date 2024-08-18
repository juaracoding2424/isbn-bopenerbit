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
            <div id="kt_app_toolbar" class="app-toolbar pt-7 pt-lg-10">
				<!--begin::Toolbar container-->
				<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
					<!--begin::Toolbar wrapper-->
					<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
						<!--begin::Page title-->
						<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
							<!--begin::Title-->
							<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
								Perbaiki Permohonan ISBN</h1>
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
								<li class="breadcrumb-item text-muted">permohonan bermasalah</li>
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
			<!--begin::Content-->
			<div id="kt_app_content" class="app-content">
				<!--begin::Content container-->
				<div id="kt_app_content_container" class="app-container container-fluid">
					<!--begin::details View-->
					<div class="row mb-5 mb-xl-10" id="kt_profile_details_view">
						<div class="mb-xl-10 col-lg-12 col-md-12">
							<div class="flex flex-col gap-5 lg:gap-7.5">
								<div class="card min-w-full">
									<div class="card-header">
										<h3 class="card-title text-gray-800 text-hover-primary fs-2 fw-bold me-3">
											General Info <span class="badge badge-light-info me-3 ms-3">Perbaikan permohonan ISBN akan masuk dalam antrian permohonan baru</span>
										</h3>
										<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3 m-3">
											<!--begin::Number-->
											<div class="d-flex align-items-center">
												<div class="fs-4 fw-bold">Kuota Tersisa Hari Ini</div>
											</div>
											<!--end::Number-->
											<!--begin::Label-->
											<div class="fw-semibold fs-2x text-info fw-bold text-center">11</div>
												<!--end::Label-->
										</div>
									</div>

									<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form id="kt_account_profile_details_form" class="form">
												<!--begin::Card body-->
                                                <div class="card-header">
                                                    <div class="d-flex align-items-center p-5 mb-10">
                                                        <i class="ki-solid ki-shield-cross fs-4hx text-danger me-4"><span
                                                                class="path1"></span><span class="path2"></span></i>
                                                        <div class="rounded border p-10  d-flex flex-column">
                                                            <div class="d-flex flex-column">
                                                                <h2 class="mb-1 text-danger">Detail masalah</h2>
                                                                <span>Judul tidak sama seperti info dalam halaman judul. Penerbit atau pengarang tidak memenuhi kriteria yang ditetapkan oleh Perpustakaan Nasional RI</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="card-body border-top p-9">
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">Cover Buku</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-6">
															<!--begin::Image input-->
															<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
																<!--begin::Preview existing avatar-->
																<div class="image-input-wrapper w-150px h-225px" style="background-image: url('https://m.media-amazon.com/images/I/41CSLTOp7LL._AC_SF480,480_.jpg')"></div>
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
														<label class="col-lg-3 col-form-label required fw-semibold fs-6">Judul Buku</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-9">
															<!--begin::Row-->
															<div class="row">
																<!--begin::Col-->
																<div class="col-lg-6 fv-row">
																	<input type="text" name="title" class="form-control form-control-lg form-control-solid" placeholder="Judul Buku" value="Pangeran Cilik" />
																</div>
                                                                <div class="col-lg-1 fv-row">
                                                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">:</label>
                                                                </div>
																<!--end::Col-->
                                                                <!--begin::Col-->
																<div class="col-lg-5 fv-row">
																	<input type="text" name="subtitle" class="form-control form-control-lg form-control-solid" placeholder="Sub Judul Buku" value="Le Petit Prince" />
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
														<label class="col-lg-3 col-form-label fw-semibold fs-6">
                                                            <span class="required">Kepengarangan</span>
                                                            <span class="ms-1" data-bs-toggle="tooltip" title="Minimal mengisi satu nama kepengarangan">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
                                                        </label>
														<!--end::Label-->
                                                        <div class="col-lg-9">
                                                            <div id="kepengarangan">
                                                                <!--begin::Col-->
																<div id="kepengarangan_0" class="row">
																	<div class="col-lg-4 fv-row mb-1">
																		<select name="authorRole[]" class="select2 form-select">
																			<option selected="selected">penulis</option>
																			<option>penyunting</option>
																			<option>penyusun</option>
																			<option>editor</option>
																			<option>alih bahasa</option>
																			<option>ilustrator</option>
																			<option>desain sampul</option>
																		</select>
																	</div>
																	<div class="col-lg-6 fv-row mb-1">
																		<input type="text" name="namaPengarang[]" class="form-control form-control-lg form-control-solid" placeholder="Nama orang" value="Antoine De Saint E" />
																	</div>
																	<div class="col-lg-2 fv-row mb-1">
																		<span class="btn btn-primary" id="btnTambahPengarang"><i class="ki-outline ki-plus" ></i></span>
																	</div>
																</div>
                                                                <!--end::Col-->
                                                            </div>
                                                        </div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">
															<span class="required">Perkiraan bulan dan tahun terbit</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Isi perkiraan tanggal terbit">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<div class="col-lg-9">
                                                            <div class="row">
                                                                <!--begin::Col-->
                                                                <div class="col-lg-4 fv-row">
                                                                    <select name="bulanTerbit" class="select2 form-select">
                                                                        <option>Januari</option>
                                                                        <option>Februari</option>
                                                                        <option>Maret</option>
                                                                        <option>Aprit</option>
                                                                        <option>Mei</option>
                                                                        <option>Juni</option>
                                                                        <option>Juli</option>
                                                                        <option>Agustus</option>
                                                                        <option>September</option>
                                                                        <option>Oktober</option>
                                                                        <option>November</option>
                                                                        <option>Desember</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4 fv-row">
                                                                <select name="tahunTerbit" class="select2 form-select">
                                                                        <option>2024</option>
                                                                        <option>2025</option>
                                                                    </select>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">Jenis ISBN</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-6 fv-row">
                                                            <select name="jenisKarya" class="select2 form-select">
                                                                <option>Cetak</option>
                                                                <option>Elektronik</option>
                                                            </select>
														</div>
														<!--end::Col-->
                                                        <!--begin::Col-->
														<div class="col-lg-3 fv-row">
                                                            <input type="text" name="jenisFile" class="form-control form-control-lg form-control-solid" placeholder="PDF, Epub, WAV, dst" value="" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">
															<span class="required">Provinsi Terbit</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Provinsi">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-9 fv-row">
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
														<label class="col-lg-3 col-form-label fw-semibold fs-6">
															<span class="required">Kabupaten / Kota Terbit</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="Kabupaten/Kota">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-9 fv-row">
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
														<label class="col-lg-3 col-form-label fw-semibold fs-6">
															<span class="required">Deskripsi / Abstrak buku</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="deskripsi">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-9 fv-row">
                                                            <textarea  row="5" type="text" name="deskripsi" class="form-control form-control-lg form-control-solid" placeholder="Isi deskripsi / abstrak buku minimal 200 karakter"></textarea>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">
															<span>ISBN lanjutan</span>
															<span class="ms-1" data-bs-toggle="tooltip" title="masukan ISBN jilid jika merupakan lanjutan dari jilid sebelumnya">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-9 fv-row">
															<select id="select2-isbn-jilid" name="isbn-jilid" data-control="select2" data-placeholder="Masukan nomor ISBN Jilid..." class="form-select form-select-solid form-select-lg fw-semibold">
															</select>
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label required fw-semibold fs-6">Jumlah Halaman</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-2 fv-row">
															<input type="text" name="jml_hlm" class="form-control form-control-lg form-control-solid" placeholder="Jumlah Halaman" value="148" />
														</div>
                                            			<label class="col-lg-1 col-form-label fw-semibold fs-6">halaman</label>
														<!--end::Col-->
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">Tinggi Buku</label>
														<!--end::Label-->
                                                        <!--begin::Col-->
														<div class="col-lg-2 fv-row">
															<input type="text" name="dimensi" class="form-control form-control-lg form-control-solid" placeholder="tinggi buku" value="22" />
														</div>
														<!--end::Col-->
                                                        <label class="col-lg-1 col-form-label fw-semibold fs-6">cm</label>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label required fw-semibold fs-6">Kategori</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-9 fv-row">
															<!--begin::Options-->
															<div class="d-flex align-items-center mt-3">
                                                                <!--begin::Option-->
																<label class="form-check form-check-custom form-check-inline form-check-solid me-5">
																	<input class="form-check-input" name="categories[]" type="checkbox" value="1" />
																	<span class="fw-semibold ps-2 fs-6">Buku Anak</span>
																</label>
																<!--end::Option-->
																<!--begin::Option-->
																<label class="form-check form-check-custom form-check-inline form-check-solid me-5">
																	<input class="form-check-input" name="categories[]" type="checkbox" value="2" />
																	<span class="fw-semibold ps-2 fs-6">Fiksi</span>
																</label>
																<!--end::Option-->
																<!--begin::Option-->
																<label class="form-check form-check-custom form-check-inline form-check-solid">
																	<input class="form-check-input" name="categories[]" type="checkbox" value="3" />
																	<span class="fw-semibold ps-2 fs-6">Non Fiksi</span>
																</label>
																<!--end::Option-->
															</div>
															<!--end::Options-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
                                                    <!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-3 col-form-label fw-semibold fs-6">Dummy Buku yang akan terbit</label>
                                                        <div class="col-lg-3 col-form-label ">
															<a><i class="bi bi-filetype-pdf fs-1"></i> DummyBuku.pdf</a>
														</div>
														<!--end:: Label-->
														<div class="col-lg-6 d-flex align-items-center">
															<!--begin::Dropzone-->
															<div class="dropzone" id="dummy" >
																<!--begin::Message-->
																<div class="dz-message needsclick align-items-center">
																	<!--begin::Icon-->
																	<i class="ki-outline ki-file-up fs-3hx text-primary"></i>
																	<!--end::Icon-->
																	<!--begin::Info-->
																	<div class="ms-4">
																		<h3 class="fs-5 fw-bold text-gray-900 mb-1">Masukan file dummy buku</h3>
																		<span class="fw-semibold fs-7 text-gray-500">Max: 100MB</span>
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
														<label class="col-lg-3 col-form-label fw-semibold fs-6">File Attachment</label>
                                                        <div class="col-lg-3 col-form-label ">
															<a><i class="bi bi-filetype-pdf fs-1"></i> SuratPernyataan.pdf</a> <br/>
                                                            <a><i class="bi bi-filetype-pdf fs-1"></i> SuratKeaslianKarya.pdf</a>
														</div>
														<!--end:: Label-->
														<div class="col-lg-6 d-flex align-items-center">
															<!--begin::Dropzone-->
															<div class="dropzone" id="attachments" style="width:100%">
																<!--begin::Message-->
																<div class="dz-message needsclick align-items-center">
																	<!--begin::Icon-->
																	<i class="ki-outline ki-file-up fs-3hx text-primary"></i>
																	<!--end::Icon-->
																	<!--begin::Info-->
																	<div class="ms-4">
																		<h3 class="fs-5 fw-bold text-gray-900 mb-1">Masukan attachment</h3>
																		<span class="fw-semibold fs-7 text-gray-500">Upload up to 10 files, Max:150MB</span>
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
													<button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
													<button type="submit" class="btn btn-success ms-3" id="btnSaveNext">Simpan dan Selanjutnya</button>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Form-->
										</div>
										<!--end::Content-->
								</div>
							</div>
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
				<?php include 'menu-footer.php';?>
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
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
		
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
		$('input[type=radio][name="status"]').on("change", function(){
			if($(this).val() == "masalah"){
				$('#divMasalah').css('display','');
			} else {
				$('#divMasalah').css('display','none');
				$('textarea[name="problem"]').val('');
			}
		});
		var kepengarangan = 1;
		$('#btnTambahPengarang').on("click", function(){
			let htmlAppend = '<div id="kepengarangan_'+kepengarangan+'" class="row"><div class="col-lg-4 fv-row mb-1"><select name="authorRole[]" class="select2 form-select">';
			htmlAppend += '<option selected="selected">penulis</option><option>penyunting</option><option>penyusun</option><option>editor</option>';
            htmlAppend += '<option>alih bahasa</option><option>ilustrator</option><option>desain sampul</option></select></div>';
			htmlAppend += '<div class="col-lg-6 fv-row mb-1"><input type="text" name="namaPengarang[]" class="form-control form-control-lg form-control-solid" placeholder="Nama orang" /></div>';
			htmlAppend += '<div class="col-lg-2 fv-row mb-1"><span class="btn btn-light-danger" onclick="deleteKepengarangan('+kepengarangan+')"><i class="ki-outline ki-trash" ></i></span></div></div>';
			$('#kepengarangan').append(htmlAppend);
			kepengarangan += 1;
		});
		var deleteKepengarangan = function(numb){
			$('#kepengarangan_' + numb).remove();
		};
		new Dropzone("#attachments", {
            url: "https://keenthemes.com/scripts/void.php",
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 150,
            addRemoveLinks: !0,
            accept: function (t, e) {
                "justinbieber.jpg" == t.name ? e("Naha, you don't.") : e()
            }
        });
		new Dropzone("#dummy", {
            url: "https://keenthemes.com/scripts/void.php",
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 100,
            addRemoveLinks: !0,
            accept: function (t, e) {
                "justinbieber.jpg" == t.name ? e("Naha, you don't.") : e()
            }
        })
</script>

</html>