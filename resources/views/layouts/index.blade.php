@include('layouts.header')
<!--begin::Wrapper-->
<div class="app-wrapper d-flex" id="kt_app_wrapper">
	<!--begin::Sidebar-->
	@include('layouts.sidebar')
	<!--end::Sidebar-->
	<!--begin::Main-->
	<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
		<!--begin::Content wrapper-->

		@yield('content')
		<!--end::Content wrapper-->
		<!--begin::Footer-->
		@include('layouts.footer')
		
		<!--end::Footer-->
	</div>
	<!--end:::Main-->
	<!--begin::aside-->
	@include('layouts.sidebar_aside')
	<!--end::aside-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::App-->
<!--begin::Activities drawer-->
@include('layouts.log_aktifitas')
<!--end::Activities drawer-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->

<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
@yield('script')
<script>
	var getHistory = function(){
	$.ajax({
            url: "{{ url('/penerbit/history/data') }}",
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(response) {
				for(var i=0; i< response.length; i++){
					let status_permohonan = "", cek_disini = "", link = "{{ config('app.isbn_file_location') }}", note="Permohonan ";
					switch(response[i]['NOTE']){
						case 'Permohonan baru': 
							status_permohonan = '<span class="badge badge-primary">BARU</span>';
							cek_disini = `<a href="{{ url('/penerbit/isbn/permohonan/detail/') }}`+'/' +response[i]['NORESI']+`">Cek disini.</a>`;
							break;
						case 'Permohonan lanjutan': 
							note = "Permohonan ";
							status_permohonan = '<span class="badge badge-primary">JILID LANJUTAN</span>';
							cek_disini = `<a href="{{ url('/penerbit/isbn/permohonan/detail/') }}`+'/'+response[i]['NORESI']+`">Cek disini.</a>`;
							break;
						case 'Set status diterima': 
							status_permohonan = '<span class="badge badge-success">DITERIMA</span>';
							cek_disini = `<a href="{{ url('/penerbit/isbn/data') }}">Cek disini.</a>`;
							break;
						case 'Set status bermasalah': 
							status_permohonan = '<span class="badge badge-danger">BERMASALAH</span>';
							cek_disini = `<a href="{{ url('/penerbit/isbn/permohonan/detail/') }}`+'/'+response[i]['NORESI']+`">Cek disini.</a>`;
							break;
						case 'Set status batal': 
							status_permohonan = '<span class="badge badge-light-danger">BATAL</span>';
							cek_disini = `<a href="{{ url('/penerbit/isbn/permohonan/batal') }}">Cek disini.</a>`;
							break;
						default: 
							note = response[i]['NOTE'].replace("href='", "href='" +link);
							status_permohonan = '' ;
							break;
					}
				
					let penerbit_terbitan = `<div class="timeline-item">
						<div class="timeline-line"></div>
						<div class="timeline-icon">
							<i class="ki-outline ki-notification-circle fs-2 text-gray-500"></i>
						</div>
						<div class="timeline-content mb-10 mt-n1">
							<div class="pe-3 mb-5"> `;
					if(response[i]['TABLENAME'] == 'PENERBIT_TERBITAN'){
						penerbit_terbitan += `<div class="fs-5 fw-semibold mb-2">`+note + status_permohonan + ` : "`+response[i]['TITLE']+`". `+cek_disini+`</div>`;
					} else {
						penerbit_terbitan += `<div class="fs-5 fw-semibold mb-2">`+note + status_permohonan + `</div>`;
					}
						penerbit_terbitan += `<div class="d-flex align-items-center mt-1 fs-6">
									<div class="text-muted me-2 fs-7">`+response[i]['ACTIONDATE']+`</div>
								</div>
							</div>
						</div>
					</div>`;

					$('#log_aktifitas').append(penerbit_terbitan);
				}
            },
            error: function() {
                //Toast.fire({
                //    icon: 'error',
                //    title: 'Server Error!'
                //});
            }
        });
	}
	getHistory();
	var refreshHistory = function(){
		$('#log_aktifitas').html('');
		getHistory();
	}

	var url = "{{ config('app.isbn_file_location') . 'files/penerbit/foto/' . session('penerbit')['ID'] . '.png' }}";
	$.ajax({
		url: url,
		type: 'HEAD',
		success: function() {
			$('#imgAvatar1').attr('src', "{{ config('app.isbn_file_location') . 'files/penerbit/foto/' . session('penerbit')['ID'] . '.png' }}");
			$('#imgAvatar2').attr('src', "{{ config('app.isbn_file_location') . 'files/penerbit/foto/' . session('penerbit')['ID'] . '.png' }}");
		},
		error: function() {
			//alert('Image does not exist');
		}
	});
</script>
<!--end::Javascript-->
</body>

</html>