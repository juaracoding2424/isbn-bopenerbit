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
    .swal2-container.swal2-center>.swal2-popup {
        height: 80vh !important;
    }
    .swal2-container .swal2-html-container{
        max-height: 700px !important;
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
								Katalog Dalam Terbitan</h1>
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
								<li class="breadcrumb-item text-muted">Katalog Dalam Terbitan (KDT)</li>
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
								<div class="row"><!--begin::Search-->
								<div class="col-md-6">Advance Filter:
									<div id="advanceSearch">
										<div class="d-flex align-items-center position-relative my-0" id="advanceSearch_0">
											<select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectParameter">
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
											<div id="btnSearch">
												<span class="btn btn-success p-1 m-0 py-1 me-2">search</span>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">Filter
									<div class="row mb-1">
										<div class="col-md-3 fs-8">Jenis Terbitan</div>
										<div class="col-md-9"><select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectJenis"
												id="selectJenis">
												<option value="">--pilih jenis terbitan--</option>
												<option value="lepas">terbitan lepas</option>
												<option value="jilid">terbitan berjilid</option>
											</select></div>
									</div>
									<div class="row md-6">
										<div class="col-md-3 fs-8">Sumber</div>
										<div class="col-md-9"><select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectSumber" id="selectSumber">
												<option value="">--pilih sumber data--</option>
												<option value="web">Web</option>
												<option value="api">API</option>
												<option value="bulk">Bulk</option>
											</select></div>
									</div>
								</div>
								<!--end::Search-->
							</div>
						</div>
							<!--end::Card Body title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar flex-row-fluid justify-content-end gap-5">
								<!--begin::Add product-->
								<span id="unduhExcel"></span>
								<a href="http://localhost:83/penerbit/isbn/permohonan/new" class="btn btn-light-primary p-2 m-0">Tambah Permohonan ISBN</a>
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
										<th class="text-inline min-w-150px">Actions</th>
										<th class="min-w-150px">ISBN</th>
										<th class="min-w-200px">Judul</th>
										<th class="min-w-200px">Kepengarangan</th>
										<th class="min-w-200px">Bulan/Tahun Terbit</th>
										<th class="min-w-100px">Nomor Panggil</th>
										<th class="min-w-150px">Subyek</th>
										<th class="min-w-200px">Sinopsis</th>
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
	var cetakBarcode = function(){
		Swal.fire({
                    text: "Kami sudah mengirimkan barcode melalui email Anda!",
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                    	confirmButton: "btn fw-bold btn-primary"
                        }
                })
	};
	var cetakKDT = function(id){
		$.ajax({
            url: "{{ url('penerbit/isbn/data/kdt/') }}" + '/' + id,
            type: 'GET',
            contentType: false,
            processData: false,
			beforeSend: function(){
                $('.loader').css('display','block');
            },
            complete: function(){
                $('.loader').css('display','none');
            },
            success: function(response) {
				Swal.fire({
					html: `<div id='kdt'><pre style="overflow-y:scroll; max-width:700px; height:300px; border:0.5px solid lightgray; padding:5px; white-space:pre-wrap;text-align:left; font-size:10pt;">`+response + `</pre></div>
							<div>
							<button class="btn btn-primary" onclick="onBtnClicked('print',`+ id + `)">Print KDT</button>
							<button class="btn btn-danger" onclick="onBtnClicked('copy',`+ id + `)">Copy</button>
							<button class="btn btn-secondary" onclick="onBtnClicked('view',`+ id + `)">View on Web</button>
							</div>`,
                    icon: "success",
					width: "800px",
                    buttonsStyling: !1,
					showConfirmButton: false,
  					showCloseButton: true,
                    //confirmButtonText: "Ok, got it!",
                    //customClass: {
                    //	confirmButton: "btn fw-bold btn-primary"
                    //    }
                });
            },
            error: function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Server Error!'
                });
            }
        });
	}

	var onBtnClicked = function(ev, id){
		switch(ev) {
			case 'print' : 
				location.href = "{{url('/penerbit/isbn/data/generate-pdf')}}" + "/"+ id;
				break;
			case 'copy' : break;
			case 'view' : 
				location.href = "{{url('/penerbit/isbn/data/view-kdt')}}" + "/"+id;
				break;
			}
	}
	var extractColumn = function(arr, column) {
		return arr.map(x => x[column]);
	}

	var changeStatus = function(selectId){
		if($('#changeStatus_' + selectId).val() == 'batal'){
			let arrNomor = extractColumn(dataSet, 0);
			let position = arrNomor.indexOf((selectId+1).toString());
			r = dataSet[position][2];
			r = r.replace("d-flex ", "");
			Swal.fire({
                    html: "Anda yakin akan membatalkan ISBN berikut? "+r,
					icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Ya, batalkan!",
                    cancelButtonText: "Tidak",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
				}).then(function(e){
					if(e.isConfirmed == true) {
						Swal.fire({
							title: 'Konfirmasi alasan pembatalan',
							html: '<textarea id="alasan" cols="40" class="swal2-input" placeholder="Masukan alasan pembatalan ISBN" style="height:150px"></textarea>',
							width:600,
							showCancelButton: true,
							confirmButtonColor: '#DD6B55',
							confirmButtonText: 'Simpan Alasan Pembatalan ISBN',
							preConfirm: () => {
								const alasan = $('#alasan').val();
								if (alasan.length < 150) {
									Swal.showValidationMessage('Alasan pembatalan ISBN harus lebih dari 150 karakter!');
								}
								return { alasan }
							},
						}).then(
							function(e){
								if(e.isConfirmed == true){
									dataSet[selectId][5] = '<span class="badge badge-danger fs-5" tooltip="true" title="'+$('#alasan').val()+'">ISBN DIBATALKAN</span>';
									t.destroy();
									loadDataTable();
									Swal.fire({
										html: r + " <h1>TELAH DIBATALKAN</h1> <br/> <b>Alasan</b>: <span class='text-grey-400'>" + $('#alasan').val() + "</span>",
										width: 600,
										icon: "success",
										buttonsStyling: !1,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton: "btn fw-bold btn-primary"
										}
									});
								} else {
									Swal.fire({
										html: r + " tidak jadi dibatalkan.",
										icon: "error",
										buttonsStyling: !1,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton: "btn fw-bold btn-primary"
										}
									});
								}
							}
						)
					} else {
						Swal.fire({
                            html: r + " tidak jadi dibatalkan.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary"
                            }
                        });
					}
				});
		} else {
			Swal.fire({
				html: "Berhasil mengubah status penerbitan",
				icon: "success",
				timer: 1000,
				customClass: {
					confirmButton: "btn fw-bold btn-primary"
				},
				showCancelButton: false,
				showConfirmButton: false
			})	
		}		
	};
	
	var t;
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
			order: [[7, 'desc']],
			lengthMenu: [
				[10, 25, 50, 100, 500, -1],
				[10, 25, 50, 100, 500, 'All']
			],
			ajax: {
				url: '{{ url("penerbit/kdt/data/datatable") }}',
				data: {
					advSearch : advSearch,
					jenisTerbitan: $('#selectJenis').val(),
					kdtValid : $('#selectKdt').val(),
					statusKckr : $('#selectKckr').val(),
					sumber : $('#selectSumber').val(),
				}
			},
		});
	};
	loadDataTable();
	var exportButtons = () => {
		var myInt = Number(new Date()).toString();
        const documentTitle = 'ISBN Report ' + myInt + " {{ session('penerbit')['NAME'] }}";
        var buttons = new $.fn.dataTable.Buttons(t, {
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: documentTitle,
					text:'<i class="ki-outline ki-exit-up fs-2"></i>Export Data',
					className: 'btn btn-light-success p-2 m-0',
					customize: function( xlsx ) {
						var sheet = xlsx.xl.worksheets["sheet1.xml"];
                		$('row:first c', sheet).attr( 's', '42' );
						var freezePanes =
							'<sheetViews><sheetView tabSelected="2" workbookViewId="0"><pane xSplit="1" ySplit="1" topLeftCell="B3"  activePane="bottomRight" state="frozen"/></sheetView></sheetViews>';
						var current = sheet.children[0].innerHTML;
						current = freezePanes + current;
						sheet.children[0].innerHTML = current;
					}
                },
            ]
        }).container().appendTo($('#unduhExcel'));
		const target = document.querySelector('#unduhExcel');
        target.click();
    }
	var createCellPos = function( n ){
		var ordA = 'A'.charCodeAt(0);
		var ordZ = 'Z'.charCodeAt(0);
		var len = ordZ - ordA + 1;
		var s = "";
	
		while( n >= 0 ) {
			s = String.fromCharCode(n % len + ordA) + s;
			n = Math.floor(n / len) - 1;
		}
	
		return s;
	}
	exportButtons();
	var advSearch = 1;
	$('#btnTambahFilter').on("click", function(){
		let htmlAppend = '<div id="advanceSearch_'+advSearch+'" class="d-flex align-items-center position-relative my-0"><select class="select2 form-select w-200px fs-8 p-2 m-0" name="selectParameter">';
		htmlAppend +='<option value="isbn">ISBN</option><option value="title">Judul</option><option value="kepeng">Kepengarangan</option><option value="tahun_terbit">Tahun Terbit</option></select>';
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
		exportButtons();
	});
	$('#selectJenis').on("change", function(){
		loadDataTable();
		exportButtons();
	});
	$('#selectKdt').on("change", function(){
		loadDataTable();
		exportButtons();
	});
	$('#selectKckr').on("change", function(){
		loadDataTable();
		exportButtons();
	});
	$('#selectSumber').on("change", function(){
		loadDataTable();
		exportButtons();
	});
	$('input[type="text"][name="searchValue[]"]').on("focusout", function(){
		loadDataTable();
		exportButtons();
	})
</script>
@endsection