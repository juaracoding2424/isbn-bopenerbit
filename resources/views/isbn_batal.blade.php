@extends('layouts.index')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css">
<style>
	.select-costum {
		padding-top: 3px;
		padding-bottom: 3px;
	}
</style>
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
								Permohonan batal</h1>
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
								<li class="breadcrumb-item text-muted">Data ISBN</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item">
									<span class="bullet bg-gray-500 w-5px h-2px"></span>
								</li>
								<!--end::Item-->
								<!--begin::Item-->
								<li class="breadcrumb-item text-muted">Permohonan batal</li>
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
						<!--begin::Card header-->
						<div class="card-body align-items-center ">
							<!--begin::Card title-->
							<div class="card-title">
								<div class="row">
									<!--begin::Search-->
									<div class="col-md-6">
										Advance Filter:
										<div  id="advanceSearch">
											<div class="d-flex align-items-center position-relative my-0" id="advanceSearch_0">
												<select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectParameter">
													<option value="title">Judul</option>
													<option value="kepeng">Kepengarangan</option>
													<option value="no_resi">Nomor Resi</option>
													<option value="tahun_terbit">Tahun Terbit</option>
												</select>
												<input type="text" id="txtAdvanceSearch_0" class="form-control w-400px fs-8 p-2 m-0" 
													placeholder="Masukan kata kunci pencarian" name="searchValue[]" />
												<div id="btnTambahFilter">
													<span class="btn btn-primary p-1 m-0"><i class="ki-outline ki-plus fs-2" ></i></span>
												</div>
												<div id="btnSearch">
													<span class="btn btn-success p-1 m-0 py-1 me-2">search</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row mb-1">
											<div class="col-md-3 fs-8">Jenis Terbitan</div>
											<div class="col-md-9">
												<select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectJenis" id="selectJenis">
														<option value="">--pilih jenis terbitan--</option>
														<option value="lepas">terbitan lepas</option>
														<option value="jilid">terbitan berjilid</option>
												</select>
											</div>
										</div>
										<div class="row mb-1">
											<div class="col-md-3 fs-8">Sumber Data</div>
											<div class="col-md-9">
												<select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectSumber" id="selectSumber">
														<option value="">--pilih sumber data--</option>
														<option value="web">Web</option>
														<option value="api">API</option>
														<option value="bulk">Bulk</option>
												</select>
											</div>
										</div>
									</div>
									<!--end::Search-->
								</div>
							</div>
							<!--end::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
								<!--begin::Add product-->
								<a href="{{url('penerbit/isbn/permohonan/new')}}" class="btn btn-light-primary">Tambah Permohonan ISBN</a>
								<!--end::Add product-->
							</div>
							<!--end::Card toolbar-->
						</div>
						<!--end::Card header-->
						<!--begin::Card body-->
						<div class="card-body pt-0">
							<!--begin::Table-->
							<div class ="table-responsive">
							<table class="table table-row-dashed table-hover no-wrap fs-8 gy-5" id="example" style="width:100%">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-8 text-uppercase gs-0">
										<th class="text-start min-w-60px pe-2">No</th>
										<th class="min-w-100px">Actions</th>	
										<th class="min-w-150px">NORESI</th>
										<th class="min-w-200px">Judul</th>
										<th class="min-w-200px">Kepengarangan</th>
										<th class="min-w-175px">Bulan/Tahun Terbit</th>
										<th class="min-w-175px">Tanggal Permohonan</th>
									</tr>
								</thead>

							</table>
							</div>
							<!--end::Table-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Products-->
				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
</div>
@stop
@section('script')
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<!--script src="assets/js/custom/apps/ecommerce/sales/listing.js"></script-->
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/randomtitle.js') }}"></script>
<script src="{{ asset('assets/js/custom/randomname.js') }}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
<script>
	var pulihkanPermohonan = function(id){
		var title = '';
		$.ajax({
            url: '/penerbit/isbn/batal/detail/'+id+'/get',
            type: 'GET',
			async:false,
			beforeSend: function(){
                $('.loader').css('display','block');
            },
            complete: function(){
                $('.loader').css('display','none');
            },
			success: function(response){
				title = response['detail']['TITLE'];
				Swal.fire({
                    html: "Anda yakin akan memulihkan permohonan ISBN, dengan <b>judul</b>: <span class='badge badge-info'> "+response['detail']['TITLE']+" </span>?",
					icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Ya, pulihkan!",
                    cancelButtonText: "Tidak",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                        cancelButton: "btn fw-bold btn-active-light-danger"
                    }
            	}).then(function(e) {
						if(e.isConfirmed == true) {
							$.ajax({
								url: '/penerbit/isbn/batal/pulihkan-permohonan/'+id,
								type: 'GET',
								async:false,
								beforeSend: function(){
									$('.loader').css('display','block');
								},
								complete: function(){
									$('.loader').css('display','none');
								},
								success: function(response){
									Swal.fire({
										html: "Anda memulihkan permohonan ISBN, dengan <b>judul</b>: <span class='badge badge-info'>" + title + "</span>!.",
										icon: "success",
										buttonsStyling: !1,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton: "btn fw-bold btn-primary"
										}
									})
									loadDataTable();
								}
							});
						} else {
							Swal.fire({
								html: "<span class='badge badge-info'>" + title + "</span> tidak jadi dipulihkan.",
								icon: "error",
								buttonsStyling: !1,
								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn fw-bold btn-primary"
								}
                        	});
						}
           	 	});
			}
		})
	}

	var loadDataTable = function(){
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
		t = new DataTable('#example', {
			scrollX: true,
			processing: true,
			"searching": true,
			filter: false,
			serverSide: true,
			destroy: true,
			order: [[4, 'desc']],
			ajax: {
				url: '{{ url("penerbit/isbn/batal/datatable") }}',
				data: {
					advSearch : advSearch,
					jenisTerbitan: $('#selectJenis').val(),
					sumber : $('#selectSumber').val(),
				}
			},
		});
	}
	loadDataTable();
	var advSearch = 1;
	$('#btnTambahFilter').on("click", function(){
		let htmlAppend = '<div id="advanceSearch_'+advSearch+'" class="d-flex align-items-center position-relative my-0"><select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectParameter">';
		htmlAppend +='<option value="title">Judul</option><option value="kepeng">Kepengarangan</option><option value="no_resi">Nomor Resi</option><option value="tahun_terbit">Tahun Terbit</option></select>';
		htmlAppend +='<input type="text" id="txtAdvanceSearch_0" name="searchValue[]" class="form-control w-400px p-2 m-0 fs-8" placeholder="Masukan kata kunci pencarian" />';
		htmlAppend +='<span class="btn btn-light-danger p-1 m-0"><i class="ki-outline ki-trash fs-2" onclick="deleteFilter('+advSearch+')" id="btnDeleteFilter"></i></span></div>';
		$('#advanceSearch').append(htmlAppend);
		advSearch += 1;
	});
	var deleteFilter = function(numb){
		$('#advanceSearch_' + numb).remove();
	};
	$('#btnSearch').on("click", function(){
		loadDataTable();
	});
	$('#selectJenis').on("change", function(){
		loadDataTable();
	});
	$('#selectSumber').on("change", function(){
		loadDataTable();
		exportButtons();
	});
</script>

@stop