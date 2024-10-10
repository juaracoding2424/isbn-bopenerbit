@extends('layouts.index')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
<link rel="stylesheet" href="{{ asset('assets/css/swal-forms.css') }}">
<style>
	.select-costum {
		padding-top: 3px;
		padding-bottom: 3px;
	}
	.ajax-loader {
		visibility: hidden;
		background-color: rgba(255,255,255,0.7);
		position: absolute;
		z-index: +100 !important;
		width: 100%;
		height:100%;
	}

	.ajax-loader img {
		position: relative;
		top:50%;
		left:50%;
	}
    
</style>
	<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
		<!--begin::Content wrapper-->
		<div class="d-flex flex-column flex-column-fluid">
			<!--begin::Content-->
			<div id="kt_app_content" class="app-content">
			<div id="kt_app_toolbar" class="app-toolbar pt-7 pt-lg-10">
				<!--begin::Toolbar container-->
				<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
					<!--begin::Toolbar wrapper-->
					<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
						<!--begin::Page title-->
						<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
							<!--begin::Title-->
							<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
								Laporan Data ISBN</h1>
							<!--end::Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">
									<a href="{{ url('penerbit/dashboard') }}" class="text-muted text-hover-primary">Home</a>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item">
									<span class="bullet bg-gray-500 w-5px h-2px"></span>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">Laporan Data ISBN</li>
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
				<!--begin::Content container-->
				<div id="kt_app_content_container" class="app-container container-fluid">
					<!--begin::Products-->
					<div class="card card-flush">
						<!--begin::Card Body header-->
						<div class="card-body align-items-center ">
							<!--begin::Card title-->
							<div class="card-title">
								<div class="row mb-5"><!--begin::Search-->
									<div class="col-md-6">Advance Filter:
										<div id="advanceSearch">
											<div class="d-flex align-items-center position-relative my-0">
												<div class="w-200px fs-8 p-2 m-0">Jenis Media</div>
												<select class="select2 form-select w-400px fs-8 p-2 m-0" name="selectJenisMedia" id="selectJenisMedia">
															<option value="">--Semua--</option>
															<option value="1">Cetak</option>
															<option value="2">Digital (PDF)</option>
															<option value="3">Digital (EPUB)</option>
															<option value="4">Audio Book</option>
															<option value="5">Audio Visual</option>
												</select>
											</div>
											<div class="d-flex align-items-center position-relative my-0" id="advanceSearch_0">
												<select class="select2  w-200px fs-8 p-2 m-0" name="selectParameter">
													<option value="isbn">ISBN</option>
													<option value="title">Judul</option>
													<option value="kepeng">Kepengarangan</option>
													<option value="tahun_terbit">Tahun Terbit</option>
												</select>

												<input type="text" id="txtAdvanceSearch_0" class="form-control w-400px fs-8 p-2 m-0"
													placeholder="Masukan kata kunci pencarian" name="searchValue[]">
												<div id="btnTambahFilter">
													<span class="btn btn-primary p-1 m-0"><i class="ki-outline ki-plus fs-2"></i></span>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">Filter
										<div class="row mb-1">
											<div class="col-md-3 fs-8">Jenis Terbitan</div>
											<div class="col-md-9"><select class="select2  w-200px fs-8 p-2 m-0" name="selectJenis"
													id="selectJenis">
													<option value="">--pilih jenis terbitan--</option>
													<option value="lepas">terbitan lepas</option>
													<option value="jilid">terbitan berjilid</option>
												</select></div>
										</div>
										<div class="row md-6">
											<div class="col-md-3 fs-8">KDT</div>
											<div class="col-md-9"><select class="select2  w-200px fs-8 p-2 m-0" name="selectKdt" id="selectKdt">
													<option value="">--pilih status KDT--</option>
													<option value="1">Valid</option>
													<option value="0">Belum Valid</option>
												</select></div>
										</div>
										<div class="row md-6">
											<div class="col-md-3 fs-8">Status SS KCKR</div>
											<div class="col-md-9"><select class="select2  w-200px fs-8 p-2 m-0" name="selectKckr" id="selectKckr">
													<option value="">--pilih status SS KCKR--</option>
													<option value="1-perpusnas">Sudah Serah Simpan Perpusnas</option>
													<option value="0-perpusnas">Belum Serah Simpan Perpusnas</option>
													<option value="1-prov">Sudah Serah Simpan Provinsi</option>
													<option value="0-prov">Belum Serah Simpan Provinsi</option>
												</select></div>
										</div>
										<div class="row md-6">
											<div class="col-md-3 fs-8">Sumber</div>
											<div class="col-md-9"><select class="select2  w-200px fs-8 p-2 m-0" name="selectSumber" id="selectSumber">
													<option value="">--pilih sumber data--</option>
													<option value="web">Web</option>
													<option value="api">API</option>
													<option value="bulk">Bulk</option>
												</select></div>
										</div>
									</div>
								<!--end::Search-->
								</div>
								<!--end::Card Body title-->
								<!--begin::Card toolbar-->
								<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
									Berdasarkan Tanggal Disetujui
									<div class="row mb-1">
											<label class="col-lg-1 fs-8 fw-semibold">
													<span class="required">Tahunan</span>
												</label>
											<div class="col-lg-2 fv-row">
														<select id="year_start" class="select2  fs-8" style="width:100%">
															<option value="">--Tahun--</option>
															<option>2012</option>
															<option>2013</option>
															<option>2014</option>
															<option>2015</option>
															<option>2016</option>
															<option>2017</option>
															<option>2018</option>
															<option>2019</option>
															<option>2020</option>
															<option>2021</option>
															<option>2022</option>
															<option>2023</option>
															<option>2024</option>
														</select>
											</div>
											<div class="col-lg-1">s / d </div>
											<div class="col-lg-2 fv-row">
													<select id="year_end" class="select2  fs-8" style="width:100%">
														<option value="">--Tahun--</option>
															<option>2012</option>
															<option>2013</option>
															<option>2014</option>
															<option>2015</option>
															<option>2016</option>
															<option>2017</option>
															<option>2018</option>
															<option>2019</option>
															<option>2020</option>
															<option>2021</option>
															<option>2022</option>
															<option>2023</option>
															<option>2024</option>
													</select>
											</div>
											<div class="col-lg-6">
												<!--span class="btn btn-light-primary p-2 m-0 fs-8" onclick="showFrequency('tahunan')">Tampilkan Frekuensi</span-->
												<span class="btn btn-light-success p-2 m-0 fs-8" onclick="showData('tahunan')">Tampilkan Data</span>
											</div>
									</div>
									<div class="row mb-1">
											<label class="col-lg-1  fs-8 fw-semibold">
													<span class="required">Bulanan</span>
												</label>
											<div class="col-lg-1 fv-row">
												<select id="month_start" class="select2  fs-8" style="width:100%">
															<option value="">--Bulan--</option>
															<option value="01">Januari</option>
															<option value="02">Februari</option>
															<option value="03">Maret</option>
															<option value="04">April</option>
															<option value="05">Mei</option>
															<option value="06">Juni</option>
															<option value="07">Juli</option>
															<option value="08">Agustus</option>
															<option value="09">September</option>
															<option value="10">Oktober</option>
															<option value="11">November</option>
															<option value="12">Desember</option>
												</select>
											</div>
											<div class="col-lg-1 fv-row">
												<select id="year_start2" class="select2  fs-8" style="width:100%">
															<option value="">--Tahun--</option>
															<option>2012</option>
															<option>2013</option>
															<option>2014</option>
															<option>2015</option>
															<option>2016</option>
															<option>2017</option>
															<option>2018</option>
															<option>2019</option>
															<option>2020</option>
															<option>2021</option>
															<option>2022</option>
															<option>2023</option>
															<option>2024</option>
												</select>
											</div>
											<div class="col-lg-1">s / d </div>
											<div class="col-lg-1 fv-row">
												<select id="month_end" class="select2  fs-8" style="width:100%">
												<option value="">--Bulan--</option>
															<option value="01">Januari</option>
															<option value="02">Februari</option>
															<option value="03">Maret</option>
															<option value="04">April</option>
															<option value="05">Mei</option>
															<option value="06">Juni</option>
															<option value="07">Juli</option>
															<option value="08">Agustus</option>
															<option value="09">September</option>
															<option value="10">Oktober</option>
															<option value="11">November</option>
															<option value="12">Desember</option>
												</select>
											</div>
											<div class="col-lg-1 fv-row">
													<select id="year_end2" class="select2  fs-8" style="width:100%">
															<option value="">--Tahun--</option>
															<option>2012</option>
															<option>2013</option>
															<option>2014</option>
															<option>2015</option>
															<option>2016</option>
															<option>2017</option>
															<option>2018</option>
															<option>2019</option>
															<option>2020</option>
															<option>2021</option>
															<option>2022</option>
															<option>2023</option>
															<option>2024</option>
													</select>
											</div>
											<div class="col-lg-6">
												<!--span class="btn btn-light-primary p-2 m-0 fs-8" onclick="showFrequency('bulanan')">Tampilkan Frekuensi</span-->
												<span class="btn btn-light-success p-2 m-0 fs-8" onclick="showData('bulanan')">Tampilkan Data</span>
											</div>
									</div>
									<div class="row mb-1">
											<label class="col-lg-1 fs-8 fw-semibold">
													<span class="required">Harian</span>
												</label>
											<div class="col-lg-2 fv-row">
												<input type="date" id="date_start" class="fs-8" style="width:100%">
											</div>
											<div class="col-lg-1">s / d </div>
											<div class="col-lg-2 fv-row">
												<input type="date" id="date_end" class="fs-8" style="width:100%">
											</div>
											<div class="col-lg-6">
												<!--span class="btn btn-light-primary p-2 m-0 fs-8" onclick="showFrequency('harian')">Tampilkan Frekuensi</span-->
												<span class="btn btn-light-success p-2 m-0 fs-8" onclick="showData('harian')">Tampilkan Data</span>
											</div>
									</div>
								</div>
								<!--end::Card toolbar-->
							</div>
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<iframe id="iFrameReport" width="100%" url=""></iframe>
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Products-->
				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Content wrapper-->
	</div>
	@stop
	<!--end:::Main-->

@section('script')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
<script src="{{ asset('assets/js/swal-forms.js') }}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('/assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('/assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('/assets/js/custom/apps/chat/chat.js') }}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
<script>

	var advSearch = 1;
	$('#btnTambahFilter').on("click", function(){
		let htmlAppend = '<div id="advanceSearch_'+advSearch+'" class="d-flex align-items-center position-relative my-0"><select class="select2  w-200px fs-8 p-2 m-0" name="selectParameter">';
		htmlAppend +='<option value="isbn">ISBN</option><option value="title">Judul</option><option value="kepeng">Kepengarangan</option><option value="tahun_terbit">Tahun Terbit</option></select>';
		htmlAppend +='<input type="text" id="txtAdvanceSearch_0" name="searchValue[]" class="form-control w-400px p-2 m-0 fs-8" placeholder="Masukan kata kunci pencarian" />';
		htmlAppend +='<span class="btn btn-light-danger p-1 m-0"><i class="ki-outline ki-trash fs-2" onclick="deleteFilter('+advSearch+')" id="btnDeleteFilter"></i></span></div>';
		$('#advanceSearch').append(htmlAppend);
		advSearch += 1;
	});
	var deleteFilter = function(numb){
		$('#advanceSearch_' + numb).remove();
	};

	var showData = function(param){
		let selectParameter = $('select[name="selectParameter"] option:selected').map(function() {
											return $(this).val();
										}).get();
		let searchValue = $('input[type="text"][name="searchValue[]"').get().map(function takeValue(input) {
									return input.value;
								});
		let advSearch = [];
		for(var i = 0; i < selectParameter.length; i++){
			if(searchValue.length > 0) {
				advSearch.push({
					'param' : selectParameter[i],
					'value' : searchValue[i]
					})
			}
		}
		let advSearchString = JSON.stringify(advSearch);
		var year_start       = $('#year_start');
		var year_end         = $('#year_end');
		var month_start      = $('#month_start');
		var month_end        = $('#month_end');
		var year_start2 	 = $('#year_start2');
		var year_end2   	 = $('#year_end2');
		var date_start       = $('#date_start');
		var date_end         = $('#date_end');
		var jenisTerbitan 	 = $('#selectJenis').val();
		var kdtValid 		 = $('#selectKdt').val();
		var statusKckr 		 = $('#selectKckr').val();
		var sumber 			 = $('#selectSumber').val();
		var jenisMedia 		 = $('#selectJenisMedia').val();

		if(param == 'tahunan') {
			month_start.val('');
			month_end.val('');
			year_start2.val('');
			year_end2.val('');
			date_start.val('');
			date_end.val('');

			if(year_start.val() && year_end.val()) {
				$('#iFrameReport').attr('src', "{{ url('/penerbit/report/isbn/show-data?action=datatable') }}" + "&param=tahunan&date_start=" + year_start.val() + 
				"&date_end=" + year_end.val() + '&jenisTerbitan=' +jenisTerbitan + '&=kdtValid=' + kdtValid + '&statusKckr=' + statusKckr + 
				'&jenisMedia='+ jenisMedia + '&sumber=' + sumber + '&advSearch=' + advSearchString + '&periode=tahunan');
				set_size(1000);
			} else {
				Swal.fire('Ooopss!!', 'Harap mengisi tahun awal dan tahun akhir.', 'warning');
			}
		} else if(param == 'bulanan') {
			year_start.val('');
			year_end.val('');
			date_start.val('');
			date_end.val('');

			if(month_start.val() && year_start2.val() && month_end.val() && year_end2.val()) {
				$('#iFrameReport').attr('src', "{{ url('/penerbit/report/isbn/show-data?action=datatable') }}" + "&param=bulanan&date_start=" + year_start2.val() +'-'+month_start.val() + 
				"&date_end=" + year_end2.val() +'-'+ month_end.val()  + '&jenisTerbitan=' +jenisTerbitan + '&=kdtValid=' + kdtValid + 
				'&jenisMedia='+ jenisMedia + '&statusKckr=' + statusKckr + '&sumber=' + sumber + '&advSearch=' + advSearchString + '&periode=bulanan');
				set_size(1000);
			} else {
				Swal.fire('Ooopss!!', 'Harap mengisi bulan tahun awal dan bulan tahun akhir.', 'warning');
			}
		} else if(param == 'harian') {
			year_start.val('');
			year_end.val('');
			month_start.val('');
			month_end.val('');
			year_start2.val('');
			year_end2.val('');

			if(date_start.val() && date_end.val()) {
				//loadDataTable(param);
				$('#iFrameReport').attr('src', "{{ url('/penerbit/report/isbn/show-data?action=datatable') }}" + "&param=tahunan&date_start=" + date_start.val() + "&date_end=" + date_end.val() +
				'&jenisTerbitan=' +jenisTerbitan + '&=kdtValid=' + kdtValid + '&statusKckr=' + statusKckr + 
				'&jenisMedia='+ jenisMedia + '&sumber=' + sumber + '&advSearch=' + advSearchString + '&periode=harian');	
				set_size(1000);
			} else {
				Swal.fire('Ooopss!!', 'Harap mengisi harian awal dan harian akhir.', 'warning');
			}
		} else {
			//loadDataTable(param);
		}
	}
	var  set_size = function (ht){
		$("#iFrameReport").css('height',ht);
	}
</script>
@endsection
