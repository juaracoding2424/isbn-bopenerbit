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
							<div class="alert alert-danger d-flex align-items-center p-5 mb-10">
								<i class="ki-solid ki-shield-cross fs-4hx text-danger me-4"><span
										class="path1"></span><span class="path2"></span></i>
								<div class="rounded border p-10  d-flex flex-column">
									@if(session('penerbit')['VALIDASI'] == 'P')
									<div class="d-flex flex-column">
										<h2 class="mb-1 text-danger">Pendaftaran akun Anda bermasalah, dengan alasan sebagai berikut. </h2>
										<br/>
										<span>{!!session('penerbit')['KETERANGAN']!!}</span>
										<br/>
										Harap perbaiki data Anda pada link berikut ini : <br/>
										<a href='{{url("penerbit/profile")}}' class="btn btn-primary">PERBAIKI PENDAFTARAN</a>										
									</div>
									@else 
										<div class="d-flex flex-column">
											<h2 class="mb-1 text-danger">Akun Anda saat ini belum diverifikasi oleh administrator website ISBN. </h2>
											<span>Proses verifikasi akun memerlukan waktu maksimal <b>1x24 jam</b>. <br/>
											Jika akun Anda belum terverifikasi dalam jangka waktu tersebut, silakan hubungi Customer Service kami untuk bantuan lebih lanjut.
											<br/><br/>Terima kasih atas kesabaran dan pengertiannya</span>										
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