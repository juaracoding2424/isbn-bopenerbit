@extends('layouts.index')
@section('content')
<style>
    swal-height {
height: 100vh !important;
}
</style>
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
                        Ubah Permohonan ISBN</h1>
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
                        <li class="breadcrumb-item text-muted">Ubah permohonan ISBN</li>
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
                                    General Info 
                                </h3>
                                <h4 class="card-title"><span id="noresi">{{$noresi}}</span></h4>
                                @if(isset($masalah["Data"]["Items"][0]))
                                <div class="d-flex align-items-center p-5 mb-10" style="width:100%">
                                    <i class="ki-solid ki-shield-cross fs-4hx text-danger me-4"><span
                                            class="path1"></span><span class="path2"></span></i>
                                    <div class="rounded border p-10  d-flex flex-column">
                                        <div class="d-flex flex-column">
                                            <h2 class="mb-1 text-danger">Detail masalah</h2>
                                                <span>{!! $masalah["Data"]["Items"][0]["ISI"] !!}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!--begin::Content-->
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <!--begin::Form-->
                                <form id="form_isbn" class="form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name='penerbit_isbn_masalah_id' @if(isset($masalah["Data"]["Items"][0])) value="{{$masalah['Data']['Items'][0]['ID']}}" @endif>
                                
                                <input type="hidden" name='noresi' value="{{$noresi}}">
                                <input type="hidden" name='penerbit_terbitan_id' value="{{$detail['PENERBIT_TERBITAN_ID']}}">
                                <input type="hidden" name='isbn_resi_id' value="{{$detail['ID']}}">
                                    <!--begin::Card body-->
                                    <div class="card-body border-top p-9">
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 required fw-semibold">Judul
                                                Buku</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9">
                                                <textarea row="3" type="text" name="title" id="title"
                                                    class="form-control fs-8 form-control-lg form-control-solid"
                                                    placeholder="Isi judul buku"></textarea>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold">
                                                <span class="required">Kepengarangan</span>
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                    title="Minimal mengisi satu nama kepengarangan">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <div class="col-lg-9">
                                                <div id="kepengarangan">
                                                    <!--begin::Col-->
                                                    <div id="kepengarangan_0" class="row">
                                                        <div class="col-lg-4 fv-row mb-1">
                                                            <select name="authorRole[]" class="select2 form-select fs-8" id="authorRole0">
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
                                                            <input type="text" name="namaPengarang[]" id="namaPengarang0" 
                                                                class="form-control fs-8 form-control-lg"
                                                                placeholder="Nama orang" value="" />
                                                        </div>
                                                        <div class="col-lg-2 fv-row mb-1">
                                                            <span class="btn btn-primary" id="btnTambahPengarang"><i
                                                                    class="ki-outline ki-plus"></i></span>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        
										<!--begin::Input group-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Media Terbitan ISBN </span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis media terbitan ISBN">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Cetak</span>
                                                                <span class="fw-semibold fs-8 text-gray-600 onhover">Sesuai UU 13.th 2018: Penerbit wajib mengirimkan sebanyak 2 eks buku cetak kepada Perpusnas, dan 1 eks buku cetak kepada Perpustakaan Provinsi sesuai domisili</span>
                                                             </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Digital (PDF)</span>
                                                                <span class="fw-semibold fs-8 text-gray-600 onhover">Sesuai UU 13.th 2018: Penerbit wajib serah simpan dengan cara mengunggah mandiri file PDF melalui https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
													<!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="3">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Digital (EPUB)</span>
                                                                <span class="fw-semibold fs-8 text-gray-600 onhover">Sesuai UU 13.th 2018: Penerbit wajib serah simpan dengan cara mengunggah mandiri file EPUB melalui https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
													<!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="4">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Audio Book</span>
                                                                <span class="fw-semibold fs-8 text-gray-600 onhover">Sesuai UU 13.th 2018: Penerbit wajib serah simpan dengan cara mengunggah mandiri file MP3/WAV melalui https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="5">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Audio Visual</span> 
                                                                <span class="fw-semibold fs-8 text-gray-600 onhover">Sesuai UU 13.th 2018: Penerbit wajib serah simpan dengan cara mengunggah mandiri file MP4/MPEG melalui https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <span class="fw-semibold fs-7 text-gray-600" id="notes_jenis_media"></span>
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Kelompok Pembaca</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih kelompok pembaca">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelompok" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Anak</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelompok" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Dewasa</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
													<!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelompok" value="3">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Semua Umur (SU)</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
													
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                         <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Jenis Pustaka</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis pustaka">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_pustaka" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Fiksi</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_pustaka" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Non Fiksi</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->													
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Kategori Jenis Pustaka</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis pustaka">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kategori" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Terjemahan</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kategori" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Non Terjemahan</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->													
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Golongan Terbitan ISBN </span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih golongan terbitan ISBN">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_terbitan" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Pemerintah</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_terbitan" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Perguruan Tinggi</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
													<!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_terbitan" value="3">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Swasta</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Apakah termasuk penelitian? </span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih golongan terbitan ISBN">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_penelitian" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Penelitian</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_penelitian" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Non Penelitian</span>
                                                            </span>
                                                        </label>
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
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span class="required">Perkiraan bulan dan tahun terbit</span>
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                    title="Isi perkiraan tanggal terbit">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-4 fv-row">
                                                        <select name="bulan_terbit" class="select2 form-select fs-8">
                                                            <option value="01">Januari</option>
                                                            <option value="02">Februari</option>
                                                            <option value="03">Maret</option>
                                                            <option value="04">Aprit</option>
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
                                                    <div class="col-lg-4 fv-row">
                                                        <select name="tahun_terbit" class="select2 form-select fs-8">
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
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span class="required">Tempat Terbit</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="tempat_terbit">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9 fv-row">
                                                <input type="text" name="tempat_terbit"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="Tempat terbit buku" />
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span >Distributor</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Distributor buku">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9 fv-row">
                                                <input type="text" name="distributor"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="Distributor buku" />
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span class="required">Deskripsi / Abstrak buku</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="deskripsi">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9 fv-row">
                                                <textarea row="5" type="text" name="deskripsi"
                                                    class="form-control fs-8 form-control-lg form-control-solid"
                                                    placeholder="Isi deskripsi / abstrak buku minimal 200 karakter"></textarea>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-6" id="divIsbnLanjutan">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span>ISBN lanjutan</span>
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                    title="masukan ISBN jilid jika merupakan lanjutan dari jilid sebelumnya">
                                                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9 fv-row">
                                                <input type="text" value="" id="isbn-jilid-lanjutan" class="form-control fs-6 form-control-lg form-control-solid">
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 required fw-semibold fs-8" id="labelJumlahHalaman">Jumlah
                                                    Halaman</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-2 fv-row">
                                                    <input type="number" name="jml_hlm" id="jml_hlm"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="Jumlah Halaman" value="" />
                                                </div>
                                                <label class="col-lg-1 col-form-label fw-semibold fs-8" id="labelKetJumlahHalaman">halaman</label>
                                                <!--end::Col-->
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8" style="text-align:right">Tinggi Buku</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-2 fv-row">
                                                    <input type="number" name="ketebalan" id="ketebalan"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="tinggi buku" value="" />
                                                </div>
                                                <!--end::Col-->
                                                <label class="col-lg-1 col-form-label fw-semibold fs-8">cm</label>
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Edisi Buku</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-2 fv-row">
                                                    <input type="text" name="edisi" id="edisi"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="Edisi buku" value="" />
                                                </div>
                                                <label class="col-lg-1 col-form-label fw-semibold fs-8"></label>
                                                <!--end::Col-->
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8" style="text-align:right">Seri buku</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-2 fv-row">
                                                    <input type="text" name="seri" id="seri"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="seri buku" value="" />
                                                </div>
                                                <!--end::Col-->
                                            </div>

                                        <!--begin::Input group-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Jenis
                                                        Permohonan ISBN </span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis permohonan ISBN">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status" value="lepas">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Lepas</span>
                                                                <span class="fw-semibold fs-8 text-gray-600">Penerbit
                                                                    akan mendapatkan 1 nomor ISBN untuk setiap judul
                                                                    yang diminta.</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status" value="jilid">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-6 fw-bold mb-1 d-block">Jilid</span>
                                                                <span class="fw-semibold fs-8 text-gray-600">Anda wajib
                                                                    memasukan minimal 2 jilid untuk permohonan ISBN
                                                                    berjilid.</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <div id="isbn_detail">
                                            <span id="judul_buku_1"><h4>Data Buku 1 </h4><hr/></span>
                                            <input type="hidden" name="file_lampiran[]" id="file_lampiran1">
                                            <input type="hidden" name="file_dummy[]" id="file_dummy1">
                                            <input type="hidden" name="file_cover[]" id="file_cover1">

                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">File
                                                    Attachment</label>
                                                <div class="col-lg-3 col-form-label fs-8 " id="viewlampiran_1">
                                                    <!--<a><i class="bi bi-filetype-pdf fs-1"></i> SuratPernyataan.pdf</a>
                                                    <br />
                                                    <a><i class="bi bi-filetype-pdf fs-1"></i> SuratKeaslianKarya.pdf</a>-->
                                                </div>
                                                <!--end:: Label-->
                                                <div class="col-lg-6 d-flex align-items-center">
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="attachments1" style="width:100%">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick align-items-center">
                                                            <!--begin::Icon-->
                                                            <i class="ki-outline ki-file-up fs-3hx text-primary"></i>
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <div class="ms-4">
                                                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan
                                                                    attachment</h3>
                                                                <span class="fw-semibold fs-7 text-gray-500">Upload up to 10
                                                                    files, Max:150MB</span>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                    </div>
                                                    <!--end::Dropzone-->
                                                </div>
                                            </div>
                                            <!--end::Input group-->
                                            <!--end::Input group-->
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Dummy Buku yang akan
                                                    terbit</label>
                                                <div class="col-lg-3 col-form-label fs-8 " id="viewdummy_1">
                                                    <!--<a><i class="bi bi-filetype-pdf fs-1"></i> DummyBuku.pdf</a>-->
                                                </div>
                                                <!--end:: Label-->
                                                <div class="col-lg-6 d-flex align-items-center">
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="dummy1">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick align-items-center">
                                                            <!--begin::Icon-->
                                                            <i class="ki-outline ki-file-up fs-3hx text-primary"></i>
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <div class="ms-4">
                                                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan file
                                                                    dummy buku</h3>
                                                                <span class="fw-semibold fs-7 text-gray-500">Max:
                                                                    100MB</span>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                    </div>
                                                    <!--end::Dropzone-->
                                                </div>
                                                <!--begin::Label-->
                                            </div>
                                            <!--end::Input group-->
                                             <!--end::Input group-->
                                             <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">File Cover Buku </label>
                                                <div class="col-lg-3 col-form-label fs-8 " id="viewcover_1">
                                                    <!--<a><i class="bi bi-filetype-pdf fs-1"></i> DummyBuku.pdf</a>-->
                                                </div>
                                                <!--end:: Label-->
                                                <div class="col-lg-6 d-flex align-items-center">
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="cover1">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick align-items-center">
                                                            <!--begin::Icon-->
                                                            <i class="ki-outline ki-file-up fs-3hx text-primary"></i>
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <div class="ms-4">
                                                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan file
                                                                    cover buku</h3>
                                                                <span class="fw-semibold fs-7 text-gray-500">Max:
                                                                    100MB</span>
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
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                    <span class="required">URL / LINK publikasi buku</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="url">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-6 fv-row">
                                                <input type="text" name="url[]" id="url1"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="url/link buku"/>
                                                </div>
                                                <div class="col-lg-3 fv-row" id="btnTambahJilid">
                                                    <span class="btn btn-success">Tambah Jilid</span>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>

                                    </div>
                                    <!--end::Card body-->
                                    <!--begin::Actions-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
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
@stop

@section('script')
<!--end::Custom Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
<script>


    function clearOptions(id) {
        //console.log("on clearOptions :" + id);
        //$('#' + id).val(null);
        $('#' + id).empty().trigger('change');
    }

    var dropZoneJilid = function(jilid_ke, file_type){
        let dropzoneId = "", inputFileId ="", acceptedFiles = "", maxFilesize = 5;
        switch(file_type){
            case "lampiran": 
                dropzoneId = "#attachments"+jilid_ke; 
                inputFileId = "#file_lampiran"+jilid_ke; 
                acceptedFiles = ".pdf";
                maxFilesize = 150;
                break;
            case "cover": 
                dropzoneId = "#cover"+jilid_ke; 
                inputFileId = "#file_cover"+jilid_ke; 
                acceptedFiles = ".jpg,.png,.jpeg";
                maxFilesize = 5;
                break;
            case "dummy": 
                dropzoneId = "#dummy"+jilid_ke; 
                inputFileId = "#file_dummy"+jilid_ke; 
                acceptedFiles = ".pdf,.epub,.mp3,.mp4,.wav";
                maxFilesize = 100;
                break;
            default:break;
        }
        new Dropzone(dropzoneId, {
            url: '{{ url("/penerbit/dropzone/store") }}',
            paramName: "file",
            maxFiles: 1,
            maxFilesize: maxFilesize, // MB
            acceptedFiles: acceptedFiles,
            autoProcessQueue: false,
            addRemoveLinks: true, // Option to remove files from the dropzone
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')// CSRF token for Laravel
            },
            init: function () {
                this.on("addedfile", function (file) {
                    // Automatically process the file when it is added
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }

                    this.processFile(file);
                });
                this.on("sending", function (file, xhr, formData) {
                    // Additional data can be sent here if required
                    console.log('Sending file:', file);
                });
                this.on("success", function (file, response) {
                    $(inputFileId).val(response[0]['name']);
                    // Handle the response from the server after the file is uploaded
                    //console.log('File uploaded successfully', response);
                });
                this.on("error", function (file, response) {
                    // Handle the errors
                    //console.error('Upload error', response);
                });
                this.on("queuecomplete", function () {
                    // Called when all files in the queue have been processed
                    //console.log('All files have been uploaded');
                });
                this.on("removedfile", function (file) {
                    //console.log(file, 'delete file', file.serverFileName)
                    if (file.serverFileName) {
                        $.ajax({
                            url: '{{ url("/penerbit/dropzone/delete") }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            data: {
                                filename: file.serverFileName[0]['name']
                            },
                            success: function (data) {
                                $(inputFileId).val('');
                                //console.log("File deleted successfully");
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                console.error('Failed to delete file:', errorThrown);
                            }
                        });
                    }
                });
                this.on("success", function (file, response) {
                    // Store the server file name for deletion purposes
                    file.serverFileName = response;
                });
            }

        });
    }
   
    var tambahJilid = function(){
        jumlah_buku +=1;
        let html = 
        `<div class='jilidbaru'><span id="judul_buku_`+jumlah_buku+`"><h4>Data Buku `+ jumlah_buku + `</h4><hr/></span>
        
        <input type='hidden' id='file_dummy`+jumlah_buku+`' name='file_dummy[]'>
        <input type='hidden' id='file_lampiran`+jumlah_buku+`' name='file_lampiran[]'>
        <input type='hidden' id='file_cover`+jumlah_buku+`' name='file_cover[]'>  
        <div class="row mb-6">
            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">File
                Attachment</label>
            <div class="col-lg-3 col-form-label fs-8 " id="viewlampiran_`+jumlah_buku+`"></div>
            <div class="col-lg-6 d-flex align-items-center">
                <div class="dropzone" id="attachments`+jumlah_buku+`" style="width:100%">
                    <div class="dz-message needsclick align-items-center">
                        <i class="ki-outline ki-file-up fs-3hx text-primary"></i>
                        <div class="ms-4">
                            <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan
                                attachment</h3>
                            <span class="fw-semibold fs-7 text-gray-500">Max:150MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Dummy Buku yang akan
                terbit</label>
            <div class="col-lg-3 col-form-label fs-8 " id="viewdummy_`+jumlah_buku+`"></div>
            <div class="col-lg-6 d-flex align-items-center">
                <div class="dropzone" id="dummy`+jumlah_buku+`">
                    <div class="dz-message needsclick align-items-center">
                        <i class="ki-outline ki-file-up fs-3hx text-primary"></i>
                        <div class="ms-4">
                            <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan file
                                dummy buku</h3>
                            <span class="fw-semibold fs-7 text-gray-500">Max:
                                100MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">File
                Cover Buku</label>
            <div class="col-lg-3 col-form-label fs-8 " id="viewcover_`+jumlah_buku+`"></div>
            <div class="col-lg-6 d-flex align-items-center">
                <div class="dropzone" id="cover`+jumlah_buku+`" style="width:100%">
                    <div class="dz-message needsclick align-items-center">
                        <i class="ki-outline ki-file-up fs-3hx text-primary"></i>
                        <div class="ms-4">
                            <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan
                                file cover buku</h3>
                            <span class="fw-semibold fs-7 text-gray-500">Max:5MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-6">
            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                <span class="required">URL / LINK publikasi buku</span>
                <span class="ms-1" data-bs-toggle="tooltip" title="url">
                    <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                </span>
            </label>
            <div class="col-lg-6 fv-row">
                <input type="text" name="url[]" class="form-control fs-8 form-control-lg form-control-solid" id="url`+jumlah_buku+`"
                    placeholder="url/link buku" />
            </div>
            <div class="col-lg-3 fv-row hapusJilid">
                <span class="btn btn-danger active">Hapus Jilid</span>
            </div>
        </div></div>`;
    
        $('#isbn_detail').append(html);
        if(jumlah_buku > 2){
            var objJilids = $('.jilidbaru').find();
            for(var i = 0; i <= objJilids.prevObject.length; i++){
                if(i < jumlah_buku -2){
                    var btnHapus = $(objJilids.prevObject[i]).find('.btn-danger').first();
                    btnHapus.removeClass("active");
                    btnHapus.addClass('disabled');
                }
            }
        }
        $('.btn.btn-danger.active').on('click', function(){
            $(this).parent().parent().parent().remove();
            jumlah_buku-=1;
            var objJilids = $('.jilidbaru').find();
            for(var i = 0; i <= objJilids.prevObject.length; i++){
                var btnHapus = $(objJilids.prevObject[i]).find('.btn-danger').first();
                if(i < jumlah_buku -2){
                    btnHapus.removeClass("active");
                    btnHapus.addClass('disabled');
                }
                if(i == jumlah_buku -2){
                    btnHapus.addClass('active');
                    btnHapus.removeClass("disabled");
                }
            }
        });  
        dropZoneJilid(jumlah_buku, "lampiran");
        dropZoneJilid(jumlah_buku, "dummy");
        dropZoneJilid(jumlah_buku, "cover");
    }
    $('#btnTambahJilid').on('click', function(){
        tambahJilid();
    });
    var jumlah_buku = 1;
    var status = "{{$detail['STATUS']}}";
    dropZoneJilid(jumlah_buku, "lampiran");
    dropZoneJilid(jumlah_buku, "dummy");
    dropZoneJilid(jumlah_buku, "cover");
    var jilid_lepas = '{{$jenis}}';
    $('textarea[name=title]').val("{{ $detail['TITLE'] }}");
    var kdt_valid = "{{ $detail['IS_KDT_VALID']}}";
    var kepeng ="{{ $detail['KEPENG'] }}";
    var kepengs = kepeng.split(";");
    if(kepengs[0].includes(',')){
        $('#authorRole0').val(kepengs[0].split(',')[0]);
        $('#namaPengarang0').val(kepengs[0].split(',')[1]);
    }else {
        $('#authorRole0').val('penulis');
        $('#namaPengarang0').val(kepengs[0]);
    }
    for(var i = 1; i < kepengs.length; i++){
        if(kepengs[i].includes(',')){
            let htmlAppend = '<div id="kepengarangan_' + kepengarangan +
                '" class="row"><div class="col-lg-4 fv-row mb-1"><select name="authorRole[]" class="select2 form-select fs-8 id="authorRole'+i+'">';
            htmlAppend +=
                '<option selected="">penulis</option><option>penyunting</option><option>penyusun</option><option>editor</option>';
            htmlAppend +=
                '<option>alih bahasa</option><option>ilustrator</option><option>desain sampul</option></select></div>';
            htmlAppend +=
                '<div class="col-lg-6 fv-row mb-1"><input type="text" name="namaPengarang[]" class="form-control fs-8 form-control-lg form-control-solid" placeholder="Nama orang" value="'+kepengs[i].split(',')[1]+'" /></div>';
            htmlAppend +=
                '<div class="col-lg-2 fv-row mb-1"><span class="btn btn-light-danger" onclick="deleteKepengarangan(' +
                kepengarangan + ')"><i class="ki-outline ki-trash" ></i></span></div></div>';
            $('#kepengarangan').append(htmlAppend);
            $('#authorRole'+i).val('penulis');
        }else {
            let htmlAppend = '<div id="kepengarangan_' + kepengarangan +
                '" class="row"><div class="col-lg-4 fv-row mb-1"><select name="authorRole[]" class="select2 form-select fs-8 id="authorRole'+i+'">';
            htmlAppend +=
                '<option selected="">penulis</option><option>penyunting</option><option>penyusun</option><option>editor</option>';
            htmlAppend +=
                '<option>alih bahasa</option><option>ilustrator</option><option>desain sampul</option></select></div>';
            htmlAppend +=
                '<div class="col-lg-6 fv-row mb-1"><input type="text" name="namaPengarang[]" class="form-control fs-8 form-control-lg form-control-solid" placeholder="Nama orang" value="'+kepengs[i]+'" /></div>';
            htmlAppend +=
                '<div class="col-lg-2 fv-row mb-1"><span class="btn btn-light-danger" onclick="deleteKepengarangan(' +
                kepengarangan + ')"><i class="ki-outline ki-trash" ></i></span></div></div>';
            $('#kepengarangan').append(htmlAppend);
            $('#authorRole'+i).val(kepengs[i].split(',')[0]);
        } 
    }
    var jenis_media = "{{$detail['JENIS_MEDIA']}}";
    var jenis_terbitan = "{{$detail['JENIS_TERBITAN']}}";
    var jenis_penelitian = "{{$detail['JENIS_PENELITIAN']}}";
    var jenis_kategori = "{{$detail['JENIS_KATEGORI']}}";
    var jenis_pustaka = "{{$detail['JENIS_PUSTAKA']}}";
    var jenis_kelompok = "{{$detail['JENIS_KELOMPOK']}}";
    $('#isbn-jilid-lanjutan').val('{{$isbnjilidlanjutan}}').attr("readonly", true);
    if('{{$isbnjilidlanjutan}}' == ''){
        $('#divIsbnLanjutan').hide();
    }
    var keterangan_jilid = "{{$detail['KETERANGAN_JILID']}}".split('¦');
    if(jenis_media != ''){
        $('input[type=radio][name="jenis_media"][value="'+jenis_media+'"]').prop('checked', true);
    }
    //$('input[type=radio][name="status"][value="{{$status}}"]').prop("checked", true);
    if(jenis_terbitan != ''){
        $('input[type=radio][name="jenis_terbitan"][value="'+jenis_terbitan+'"]').prop('checked', true);
    }
    if(jenis_penelitian != ''){
        $('input[type=radio][name="jenis_penelitian"][value="'+jenis_penelitian+'"]').prop('checked', true);
    }
    if(jenis_kategori != ''){
        $('input[type=radio][name="jenis_kategori"][value="'+jenis_kategori+'"]').prop('checked', true);
    }
    if(jenis_pustaka != ''){
        $('input[type=radio][name="jenis_pustaka"][value="'+jenis_pustaka+'"]').prop('checked', true);
    }
    if(jenis_kelompok != ''){
        $('input[type=radio][name="jenis_kelompok"][value="'+jenis_kelompok+'"]').prop('checked', true);
    }
    $('textarea[name="deskripsi"]').val(`{!!$detail['SINOPSIS']!!}`);
    $('select[name="bulan_terbit"]').val('{{$detail['BULAN_TERBIT']}}');
    $('select[name="tahun_terbit"]').val('{{$detail['TAHUN_TERBIT']}}');
    $('input[type=text][name="distributor"]').val('{{$detail['DISTRIBUTOR']}}');
    $('input[type=text][name="tempat_Terbit"]').val('{{$detail['TEMPAT_TERBIT']}}');
    if(jilid_lepas == 'lepas'){
        $('#jml_hlm').val("{{$detail['JML_HLM']}}");
        $('input[type=radio][name="status"][value="'+jilid_lepas+'"]').prop('checked', true);
    } else {
        $('#jml_hlm').attr("type", "text").val("{{$detail['JML_JILID_REQ']}}").attr('disabled', true);
        $('#labelJumlahHalaman').text('Jumlah jilid yang diminta');
        $('#labelKetJumlahHalaman').text('Jilid');
        $('input[type=radio][name="status"][value="'+jilid_lepas+'"]').prop('checked', true);
    }
    $('input[type="radio"][name="status"]').prop('disabled', true);
    $('#edisi').val("{{$detail['EDISI']}}");
    $('#seri').val("{{$detail['SERI']}}");
    var ketebalan = "{{$detail['KETEBALAN']}}";
    ketebalan = ketebalan.replace(' cm', '');
    $('#ketebalan').val(ketebalan);
    var jml_jilid = parseInt("{{$detail['JML_JILID_REQ']}}");

    getFile("{{$detail['PENERBIT_TERBITAN_ID']}}");
    function getFile(penerbit_terbitan_id){
        jumlah_jilid = parseInt("{{$detail['JML_JILID_REQ']}}");
        $.ajax({
                url: '{{ url('penerbit/isbn/permohonan/file') }}' + '/' + penerbit_terbitan_id,
                type: 'GET',
                contentType: false,
                processData: false,
                success: function(response) {
                    for(var j = 1; j < jumlah_jilid; j++){
                        tambahJilid();
                    }
                    for(var k = 1; k < jumlah_jilid + 1; k++) {
                        $('#judul_buku_'+k).html('<h4>Data buku ' + keterangan_jilid[k-1] + '</h4><hr/>');
                        for(var i = 0; i<response.length; i++){
                            if(jilid_lepas == 'jilid') {
                                if(response[i]['JENIS'] == 'lampiran_permohonan' && response[i]['FILE_STATUS'] == '0' && response[i]['KETERANGAN'] == keterangan_jilid[k-1]) {
                                    let h = `<a href="{{ config('app.isbn_file_location') }}files/isbn/lampiran/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span> 
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewlampiran_`+k+`')"></a>
                                    <input type="hidden" name="file_lampiran_id[]" value="`+response[i]["ID"]+`"></br>`;
                                    $('#viewlampiran_'+ k).append(h);
                                }  
                                if(response[i]['JENIS'] == 'lampiran_pending' && response[i]['FILE_STATUS'] == '0'  && response[i]['KETERANGAN'] == keterangan_jilid[k-1]) {
                                    $('#viewlampiran_'+ k).append(`<a href="{{ config('app.isbn_file_location') }}files/isbn/lampiran/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span> 
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewlampiran_`+k+`')"></a>
                                    <input type="hidden" name="file_pending_id[]" value="`+response[i]["ID"]+`"></br>`);
                                }  
                                if(response[i]['JENIS'] == 'dummy_buku' && response[i]['FILE_STATUS'] == '0' && response[i]['KETERANGAN'] == keterangan_jilid[k-1]) {
                                    $('#viewdummy_'+ k).append(`<a href="{{ config('app.isbn_file_location') }}files/isbn/dummy/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span>
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewdummy_`+k+`')"></a>
                                    <input type="hidden" name="file_dummy_id[]" value="`+response[i]["ID"]+`"></br>`);
                                }
                                if(response[i]['JENIS'] == 'cover' && response[i]['FILE_STATUS'] == '0' && response[i]['KETERANGAN'] == keterangan_jilid[k-1]) {
                                    $('#viewcover_'+ k).append(`<a href="{{ config('app.isbn_file_location') }}files/cover/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span>
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewcover_`+k+`')"></a>
                                    <input type="hidden" name="file_cover_id[]" value="`+response[i]["ID"]+`"></br>`);
                                }
                            } else {
                                if(response[i]['JENIS'] == 'lampiran_permohonan' && response[i]['FILE_STATUS'] == '0') {
                                    let h = `<a href="{{ config('app.isbn_file_location') }}isbn/lampiran/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span> 
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewlampiran_`+k+`')"></a>
                                    <input type="hidden" name="file_lampiran_id[]" value="`+response[i]["ID"]+`"></br>`;
                                    $('#viewlampiran_'+ k).append(h);
                                }  
                                if(response[i]['JENIS'] == 'lampiran_pending' && response[i]['FILE_STATUS'] == '0') {
                                    $('#viewlampiran_'+ k).append(`<a href="{{ config('app.isbn_file_location') }}files/isbn/lampiran/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span> 
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewlampiran_`+k+`')"></a>
                                    <input type="hidden" name="file_pending_id[]" value="`+response[i]["ID"]+`"></br>`);
                                }  
                                if(response[i]['JENIS'] == 'dummy_buku' && response[i]['FILE_STATUS'] == '0') {
                                    $('#viewdummy_'+ k).append(`<a href="{{ config('app.isbn_file_location') }}files/isbn/dummy/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span>
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewdummy_`+k+`')"></a>
                                    <input type="hidden" name="file_dummy_id[]" value="`+response[i]["ID"]+`"></br>`);
                                }
                                if(response[i]['JENIS'] == 'cover' && response[i]['FILE_STATUS'] == '0') {
                                    $('#viewcover_'+ k).append(`<a href="{{ config('app.isbn_file_location') }}files/cover/`+response[i]["FILE_NAME"]+`">
                                    <i class="bi bi-filetype-pdf fs-1"></i> `+response[i]["FILE_NAME"]+` 
                                    <span class="badge badge-light-primary">`+response[i]["CREATEDATE"]+` (`+response[i]["CREATEBY"]+`)</span>
                                    <span class="badge badge-light-success">`+response[i]["KETERANGAN"]+`</span></a><a class="bi bi-trash fs-1 text-danger" onclick="removeFile(`+response[i]['ID']+`,'#viewcover_`+k+`')"></a>
                                    <input type="hidden" name="file_cover_id[]" value="`+response[i]["ID"]+`"></br>`);
                                }
                            }
                        }
                    }
                    let urls = "{{$detail['LINK_BUKU']}}";
                    let link_buku = urls.split('¦');
                    for(var k=1; k<= jumlah_jilid; k++){
                        $('#url'+k).val(link_buku[k-1]);
                    }
                },
                error: function() {
                    Toast.fire({
                        icon: 'error',
                        title: 'Server Error!'
                    });
                }
            });
    }

    var removeFile = function(id,divId){
        Swal.fire({
                    title: "Yakin akan menghapus File ini?",
                    icon: "success",
                    buttonsStyling: !1,
                    showCancelButton: !0,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batalkan",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-light-primary"
                    }
                    }).then(function(isConfirm){
                        if (isConfirm){
                            //
                            $.get('{{ url("/penerbit/isbn/permohonan/delete-file") }}' +'/' +id);
                            $(divId).html('');
                        }
                });
    };

    $('.onhover').css('display', 'none');
    $('.hoverEvent').hover(function () {
        var objSpan = $(this).find('.onhover').first();
        objSpan.css('display', 'block');
    }, function () {
        var objSpan = $(this).find('.onhover').first();
        objSpan.css('display', 'none');
        //stuff to do on mouse leave
    });
    $('input[type=radio][name="jenis_media"]').on('change', function() {
            var objSpan = $(this).parent().parent().find('.onhover').first();
            var notes = objSpan[0].innerHTML;
            $('#notes_jenis_media').html(notes);
        });
    $('input[type=radio][name="status"]').on('change', function() {
        if($(this).val() == 'lepas'){
            $('#judul_buku_1').css('display', 'none');
            $('#btnTambahJilid').css('display', 'none');
        } else {
            $('#judul_buku_1').css('display', 'block');
            $('#btnTambahJilid').css('display', 'block');
        }
    });
    $('#judul_buku_1').css('display', 'none');
    //$('#btnTambahJilid').css('display', 'none');
    var kepengarangan = 1;
    
    $('#btnTambahPengarang').on("click", function() {
        let htmlAppend = '<div id="kepengarangan_' + kepengarangan +
            '" class="row"><div class="col-lg-4 fv-row mb-1"><select name="authorRole[]" class="select2 form-select fs-8">';
        htmlAppend +=
            '<option selected="selected">penulis</option><option>penyunting</option><option>penyusun</option><option>editor</option>';
        htmlAppend +=
            '<option>alih bahasa</option><option>ilustrator</option><option>desain sampul</option></select></div>';
        htmlAppend +=
            '<div class="col-lg-6 fv-row mb-1"><input type="text" name="namaPengarang[]" class="form-control fs-8 form-control-lg form-control-solid" placeholder="Nama orang" /></div>';
        htmlAppend +=
            '<div class="col-lg-2 fv-row mb-1"><span class="btn btn-light-danger" onclick="deleteKepengarangan(' +
            kepengarangan + ')"><i class="ki-outline ki-trash" ></i></span></div></div>';
        $('#kepengarangan').append(htmlAppend);
        kepengarangan += 1;
    });
    $('#btnSubmit').on('click', function(){
        $('form#form_isbn').submit();
    })
    $('form#form_isbn').submit(function(e){
        e.preventDefault();
        let form = document.getElementById('form_isbn');
        let formData = new FormData(form); 
        formData.append('jumlah_jilid', jumlah_buku);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
                    url :'{{ url('penerbit/isbn/permohonan/new/submit') }}',
                    type: 'post',
                    dataType: 'json',
                    processData: false,
                    contentType:  false,
                    data: formData,
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
                                    title: "Permohonan ISBN berhasil disimpan!",
                                    text: xhr.message,
                                    html: 'NOMOR RESI : <b>' + xhr.noresi + '</b>',
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary"
                                        }
                                }).then(function(isConfirm){
                                    if (isConfirm){
                                        window.location.href = "{{url('/penerbit/isbn/permohonan/detail')}}" + "/" + xhr.noresi 
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
                                        confirmButton: "btn fw-bold btn-primary"
                                        }
                                });
                        },
                    },
                    beforeSend: function(){
                        $('.loader').css('display','block');
                    },
                    complete: function(){
                        $('.loader').css('display','none');
                    },
            });
    });
    var deleteKepengarangan = function(numb) {
        $('#kepengarangan_' + numb).remove();
    };


    if(status == 'lanjutan'){
        //yang tidak boleh diubah taruh di sini ya
        $('textarea[name=title]').attr('readonly', true);
        $('#judul_buku_1').html('<h4>Data buku ' + keterangan_jilid[0] +' </h4><hr />');
        $('#judul_buku_1').css('display', 'block');
        $('#btnTambahJilid').css('display', 'block');
        $('#btnTambahJilid').css('disabled', 'disabled');
        $('#jml_hlm').attr("type", "text");
        $('#jml_hlm').attr("disabled", "disabled");
        $('#divIsbnLanjutan').show();
        $('#btnTambahJilid').css('display', 'none');
    }
</script>
@stop