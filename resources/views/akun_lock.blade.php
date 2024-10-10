@extends('layouts.index')
@section('content')
		<!--begin::Content wrapper-->
		<div class="d-flex flex-column flex-column-fluid">
			<!--begin::Content-->
			<div id="kt_app_content" class="app-content">
				<!--begin::Content container-->
				<div id="kt_app_content_container" class="app-container container-fluid">
					<!--begin::Card-->
					<div class="card">
						<!--begin::Card body-->
						<div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
							<div class="alert alert-warning d-flex align-items-center p-5 mb-10">
								<i class="ki-solid ki-shield-cross fs-4hx text-warning me-4"><span
										class="path1"></span><span class="path2"></span></i>
								<div class="rounded border p-10  d-flex flex-column">
									@if(session('penerbit')['IS_LOCK'] == '1')
									<div class="d-flex flex-column">
										<h2 class="mb-1 text-warning">Akun anda terkunci. </h2>
										<br/>
										<span>Akun Anda terkunci karena belum menyerahkan KCKR (Karya Cetak dan Karya Rekam) yang diwajibkan. 
                                            Silakan serahkan KCKR terlebih dahulu untuk membuka kembali akses ke akun dan dapat melakukan permohonan ISBN. <br/>
                                            Jika Anda memerlukan bantuan atau informasi lebih lanjut, hubungi tim ISBN.</span>									
									</div>
									@endif
								</div>
							</div>
							<div class="text-center px-4">
								<img class="mw-100 mh-300px" alt="" src="{{ url('assets/media/auth/account-deactivated.png') }}" />
							</div>
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Content wrapper-->
@stop
@section('script')
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ url('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ url('assets/js/custom/widgets.js') }}"></script>
@stop