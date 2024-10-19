@extends('layouts.index')
@section('content')
<style>
    .swal2-container.swal2-center>.swal2-popup {
        height: 80vh !important;
    }
    .swal2-container .swal2-html-container{
        max-height: 700px !important;
    }
    .invalid-feedback {
        font-weight: 500 !important
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
                        Tambah Permohonan ISBN</h1>
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
                        <li class="breadcrumb-item text-muted">Tambah permohonan ISBN</li>
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
                            </div>

                            <!--begin::Content-->
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <!--begin::Form-->
                                <form id="form_isbn" class="form" enctype="multipart/form-data">
                                    @csrf
                                    <!--begin::Card body-->
                                    <div class="card-body border-top p-9">
                                        <!--begin::Input group-->
                                        <div class="row mb-2">
                                            <!--begin::Col-->
                                            <div class="col-lg-3">
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
                                            <div class="col-lg-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status" value="lepas">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Lepas</span>
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
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status" value="jilid">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Jilid</span>
                                                                <span class="fw-semibold fs-8 text-gray-600">Untuk permohonan jilid baru, penerbit akan menerima minimal 2 ISBN : yaitu 1 ISBN jilid lengkap, serta 1 ISBN yang spesifik untuk jilidnya.</span>
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
                                        <div class="row mb-2" id="row-isbnjilid">
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
                                                <select id="isbn-jilid" name="isbn-jilid" data-control="select2"
                                                    data-placeholder="Masukan nomor ISBN Jilid..."
                                                    class="form-select form-select-solid form-select-lg fw-semibold fs-8">
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-2">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 required fw-semibold fs-8">Judul
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
                                        <div class="row mb-2">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
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
                                                            <select name="authorRole[]" class="select2 form-select fs-8">
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
                                                            <input type="text" name="namaPengarang[]"
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
                                        <div class="row mb-2">
                                            <!--begin::Col-->
                                            <div class="col-lg-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Media
                                                        Terbitan ISBN </span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis media terbitan ISBN">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Cetak</span>
                                                                <span
                                                                    class="fw-semibold fs-8 text-gray-600 onhover">Sesuai
                                                                    UU 13.th 2018: Penerbit wajib mengirimkan sebanyak 2
                                                                    eks buku cetak kepada Perpusnas, dan 1 eks buku
                                                                    cetak kepada Perpustakaan Provinsi sesuai
                                                                    domisili</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Digital
                                                                    (PDF)</span>
                                                                <span
                                                                    class="fw-semibold fs-8 text-gray-600 onhover">Sesuai
                                                                    UU 13.th 2018: Penerbit wajib serah simpan dengan
                                                                    cara mengunggah mandiri file PDF melalui
                                                                    https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="3">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Digital
                                                                    (EPUB)</span>
                                                                <span
                                                                    class="fw-semibold fs-8 text-gray-600 onhover">Sesuai
                                                                    UU 13.th 2018: Penerbit wajib serah simpan dengan
                                                                    cara mengunggah mandiri file EPUB melalui
                                                                    https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="4">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Audio
                                                                    Book</span>
                                                                <span
                                                                    class="fw-semibold fs-8 text-gray-600 onhover">Sesuai
                                                                    UU 13.th 2018: Penerbit wajib serah simpan dengan
                                                                    cara mengunggah mandiri file MP3/WAV melalui
                                                                    https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4 hoverEvent">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_media" value="5">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Audio
                                                                    Visual</span>
                                                                <span
                                                                    class="fw-semibold fs-8 text-gray-600 onhover">Sesuai
                                                                    UU 13.th 2018: Penerbit wajib serah simpan dengan
                                                                    cara mengunggah mandiri file MP4/MPEG melalui
                                                                    https://edeposit.perpusnas.go.id</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <span class="fw-semibold fs-7 text-gray-600"
                                                        id="notes_jenis_media"></span>
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-2">
                                            <!--begin::Col-->
                                            <div class="col-lg-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Kelompok
                                                        Pembaca</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih kelompok pembaca">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelompok" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Anak</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelompok" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Dewasa</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kelompok" value="3">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Semua Umur
                                                                    (SU)</span>
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
                                        <div class="row mb-2">
                                            <!--begin::Col-->
                                            <div class="col-lg-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Jenis
                                                        Pustaka</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis pustaka">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_pustaka" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Fiksi</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_pustaka" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Non Fiksi</span>
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
                                        <div class="row mb-2">
                                            <!--begin::Col-->
                                            <div class="col-lg-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Kategori
                                                        Jenis Pustaka</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Pilih jenis pustaka">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kategori" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span
                                                                    class="fs-8 fw-bold mb-1 d-block">Terjemahan</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-6">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="jenis_kategori" value="2">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Non
                                                                    Terjemahan</span>
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
                                        <div class="row mb-2">
                                            <!--begin::Col-->
                                            <div class="col-lg-3">
                                                <div class="fs-8 fw-semibold mt-2 mb-3"><span class="required">Permohonan KDT?</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                        title="Apakah Anda membutuhkan KDT?">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-lg-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                    data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                                                    <!--begin::Col-->
                                                    <div class="col-md-6 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="pengajuan_kdt" value="1">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span
                                                                    class="fs-8 fw-bold mb-1 d-block">Ya</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-success d-flex text-start p-2"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                                                <input class="form-check-input" type="radio"
                                                                    name="pengajuan_kdt" value="0">
                                                            </span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
                                                                <span class="fs-8 fw-bold mb-1 d-block">Tidak</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-2">
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
                                                        <select name="bulan_terbit" class="select2 form-select fs-8" id="bulan_terbit">
                                                            <option value="">--Pilih Bulan Terbit--</option>
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
                                                    <div class="col-lg-4 fv-row">
                                                        <select name="tahun_terbit" class="select2 form-select fs-8" id="tahun_terbit">
                                                            <option>2024</option>
                                                            <option>2025</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-2">
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span class="required">Provinsi Tempat Terbit Buku</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Provinsi tempat terbit akan mengikuti domisili kantor penerbit">
													<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
												</span>
                                            </label>
                                            <div class="col-lg-9 fv-row">
                                                <input type="hidden" name="tempat_terbit">
                                                <select id="select2-provinsi" aria-label="Pilih provinsi tempat terbit buku" name="publication_prov_id"
                                                data-control="select2" data-placeholder="Pilih provinsi.." class="form-select  form-control form-select-solid fs-8 form-select-lg fw-semibold">
													<option value="">Pilih Provinsi Tempat Terbit<option>
												</select>
                                            </div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="row mb-2">
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                <span class="required">Kota/Kabupaten Tempat Terbit</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Kota/Kabupaten tempat terbit akan mengikuti domisili kantor penerbit">
													<i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
												</span>
                                            </label>
                                            <div class="col-lg-9 fv-row">
                                                <input type="hidden" name="tempat_terbit">
                                                <select id="select2-kabupaten" aria-label="Pilih tempat terbit buku" 
                                                data-control="select2" data-placeholder="Pilih kabupaten/kota..." class="form-select  form-control form-select-solid fs-8 form-select-lg fw-semibold" name="publication_city_id">
													<option value="">Pilih Tempat Terbit<option>
												</select>
                                            </div>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="row mb-2">
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
                                        <div class="row mb-2">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold">
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
                                        <div class="row mb-2">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 required fw-semibold" id="labelJumlahHalaman">Jumlah
                                                    Halaman</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-xl-2 col-lg-9 fv-row">
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
                                        <div class="row mb-2">
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Edisi Buku</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-2 fv-row">
                                                <input type="text" name="edisi"
                                                    class="form-control fs-8 form-control-lg form-control-solid"
                                                    placeholder="Edisi buku" value="" />
                                            </div>
                                            <label class="col-lg-1 col-form-label fw-semibold fs-8"></label>
                                            <!--end::Col-->
                                            <!--begin::Label-->
                                            <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8"
                                                style="text-align:right">Seri buku</label>
                                            <!--end::Label-->
                                            <!--begin::Col-->
                                            <div class="col-lg-2 fv-row">
                                                <input type="text" name="seri"
                                                    class="form-control fs-8 form-control-lg form-control-solid"
                                                    placeholder="seri buku" value="" />
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Input group-->

                                        <div id="isbn_detail">
                                            <span id="judul_buku_1">
                                                <h4>Data Buku jilid 1 </h4>
                                                <hr />
                                            </span>
                                            <input type='hidden' name='keterangan_jilid[]' value='jilid 1' id="keterangan_jilid_1">
                                            <input type="hidden" name="file_cover[]" id="file_cover1">

                                            <div class="row mb-2">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Dummy Buku yang
                                                    akan
                                                    terbit</label>
                                                <!-- <div class="col-lg-3 col-form-label fs-8 ">
                                                    <a><i class="bi bi-filetype-pdf fs-1"></i> DummyBuku.pdf</a>
                                                </div>-->
                                                <!--end:: Label-->
                                                <div class="col-lg-9 d-flex align-items-center">
                                                <input type="hidden" name="file_lampiran[]" id="file_lampiran1">
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
                                                                    dummy buku</h3>
                                                                <span class="fw-semibold fs-7 text-gray-500">Accepted Files: .pdf,.epub,.mp3,.mp4,.wav Max:
                                                                    10MB</span>
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
                                            <div class="row mb-2">
                                                <!--begin::Label-->

                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">File
                                                    Attachment</label>
                                                <!--
                                                <div class="col-lg-3 col-form-label fs-8 ">
                                                    <a><i class="bi bi-filetype-pdf fs-1"></i> SuratPernyataan.pdf</a>
                                                    <br />
                                                    <a><i class="bi bi-filetype-pdf fs-1"></i> SuratKeaslianKarya.pdf</a>
                                                </div>-->
                                                <!--end:: Label-->
                                                <div class="col-lg-9 d-flex align-items-center">
                                                <input type="hidden" name="file_dummy[]" id="file_dummy1">
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
                                                                    attachment</h3>
                                                                <span class="fw-semibold fs-7 text-gray-500">Max:15MB</span>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                    </div>
                                                    <!--end::Dropzone-->
                                                </div>
                                            </div>
                                            <!--end::Input group-->
                                            <div class="row mb-2">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Cover Buku</label>
                                                <!-- <div class="col-lg-3 col-form-label fs-8 ">
                                                    <a><i class="bi bi-filetype-pdf fs-1"></i> DummyBuku.pdf</a>
                                                </div>-->
                                                <!--end:: Label-->
                                                <div class="col-lg-6 d-flex align-items-center">
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone p-0" id="cover1" style="width:100%">
                                                        <!--begin::Message-->
                                                        <div class="dz-message needsclick align-items-center">
                                                            <!--begin::Icon-->
                                                            <i class="ki-outline ki-file-up fs-2hx text-primary"></i>
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <div class="ms-4">
                                                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan file
                                                                    cover buku</h3>
                                                                <span class="fw-semibold fs-7 text-gray-500">Max:
                                                                    5MB</span>
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
                                            <div class="row mb-2">
                                                <!--begin::Label-->
                                                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                                                    <span class="required">URL / LINK publikasi buku</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip" title="url">
                                                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                                                    </span>
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-9 fv-row">
                                                    <input type="text" name="url[]"
                                                        class="form-control fs-8 form-control-lg form-control-solid"
                                                        placeholder="url/link buku" />
                                                </div>
                                                <div class="col-lg-3 fv-row" id="btnTambahJilid">
                                                    <span class="btn btn-success p-2 fs-8">Tambah Jilid</span>
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
    var urlJilid = "{{ url('penerbit/isbn/permohonan/jilid-lengkap') }}";
    var urlProvinsi = "{{url('location/province')}}" + "/";
    var urlKabupaten = "{{url('location/kabupaten')}}" + "/";

    function clearOptions(id) {
        $('#' + id).empty().trigger('change');
    }
    FormValidation.formValidation(
			document.getElementById('form_isbn'),
			{
                    fields: {
                        title: {
                            validators: {
                                notEmpty: {
                                    message: "Judul tidak boleh kosong!"
                                },
                                remote: {
                                    method: 'POST',
                                    data: function(validator) {
                                        return {
                                            penerbit_terbitan_id: $('#isbn-jilid').val() == '' ? 0 : $('#isbn-jilid').val()
                                        };
                                    },
                                    url: "{{ url('penerbit/isbn/permohonan/check/title') }}",
                                },
                            }
                        },
                        bulan_terbit: {
                            validators : {
                                remote: {
                                    method: 'POST',
                                    data: function(validator) {
                                        return {
                                            tahun_terbit: $('#tahun_terbit').val()
                                        };
                                    },
                                    url: "{{ url('penerbit/isbn/permohonan/check/bulan-terbit-min') }}",
                                },
                            }
                        },
                        tahun_terbit: {
                            validators : {
                                remote: {
                                    method: 'POST',
                                    url: "{{ url('penerbit/isbn/permohonan/check/tahun-terbit-min') }}",
                                },
                            }
                        },
                        status :{
                            validators: {
                                notEmpty: {
                                    message: "Pilih jenis permohonan ISBN! (lepas / jilid)"
                                },
                            }
                        },
                        jenis_media :{
                            validators: {
                                notEmpty: {
                                    message: "Pilih media terbitan ISBN! (cetak, pdf, epub, audio book, audio visual)"
                                },
                            }
                        },
                        jenis_kelompok :{
                            validators: {
                                notEmpty: {
                                    message: "Pilih kelompok pembaca ISBN! (anak/dewasa/semua umur)"
                                },
                            }
                        },
                        jenis_pustaka :{
                            validators: {
                                notEmpty: {
                                    message: "Pilih jenis pustaka ISBN! (fiksi/non fiksi)"
                                },
                            }
                        },
                        jenis_kategori :{
                            validators: {
                                notEmpty: {
                                    message: "Pilih kategori jenis pustaka ISBN! (terjemahan/non terjemahan)"
                                },
                            }
                        },
                        ketebalan :{
                            validators: {
                                notEmpty: {
                                    message: "Isi tinggi buku!"
                                },
                            }
                        },
                        jml_hlm :{
                            validators: {
                                notEmpty: {
                                    message: "Isi jumlah halaman!"
                                },
                            }
                        },
                        pengajuan_kdt :{
                            validators: {
                                notEmpty: {
                                    message: "Pilih apakah Anda memerlukan KDT atau tidak"
                                },
                            }
                        },
                        tempat_terbit :{
                            validators: {
                                notEmpty: {
                                    message: "Anda belum mengisi tempat terbit"
                                },
                            }
                        },
                        deskripsi :{
                            validators: {
                                notEmpty: {
                                    message: "Anda belum mengisi deskripsi / sinopsis buku"
                                },
                                stringLength: {
									min: 50,
									message: 'Deskripsi buku minimal terdiri dari 50 karakter'
								},
                            }
                        },
                        'url[]' :{
                            validators: {
                                notEmpty: {
                                    message: "Anda belum mengisi URL buku"
                                },
                            }
                        },
                        'namaPengarang[]' :{
                            validators: {
                                notEmpty: {
                                    message: "Anda wajib mengisi minimal 1 nama pengarang/orang"
                                },
                            }
                        },
                        'file_lampiran[]' : {
                            validators: {
                                notEmpty: {
                                    message: "Anda wajib mengunggah File Lampiran"
                                },
                            }
                        },
                        'file_dummy[]' : {
                            validators: {
                                notEmpty: {
                                    message: "Anda wajib mengunggah File Dummy buku"
                                },
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            columnSelector: ".form-control"
                        }),
						submitButton: new FormValidation.plugins.SubmitButton(),
						icon: new FormValidation.plugins.Icon({
                            valid: 'fa fa-check',
                            invalid: 'fa fa-times',
                            validating: 'fa fa-refresh',
                        }),
                    }
            }).on('core.form.valid', function() {
                formSubmit();
            });
    $.getJSON(urlJilid, function (res) {
        res = $.map(res, function (obj) {
            return obj;
        });

        data = [{
            id: "",
            nama: "- Pilih Jilid Lengkap -",
            text: "- Pilih Jilid Lengkap -"
        }].concat(res);

        //implemen data ke select provinsi
        $("#isbn-jilid").select2({
            dropdownAutoWidth: true,
            width: '100%',
            data: data
        })
    });
    var province_id = "{{session('penerbit')['PROVINCE_ID']}}";
    $.getJSON(urlProvinsi, function (res) {
			data = [{
				id: "",
				nama: "- Pilih Provinsi Tempat Terbit -",
				text: "- Pilih Provinsi Tempat Terbit -"
			}].concat(res);

					//implemen data ke select provinsi
		$("#select2-provinsi").select2({
			dropdownAutoWidth: true,
			width: '100%',
			data: data
		}) ;
		$('#select2-provinsi').val(province_id).trigger('change'); 
	});
    var city_id = "{{session('penerbit')['CITY_ID']}}";
	var selectProv = $('#select2-provinsi');
	$(selectProv).change(function () {
		var value = $(selectProv).val();
		clearOptions('select2-kabupaten');
		if (value) {
			var text = $('#select2-provinsi :selected').text();
			$.getJSON(urlKabupaten + value, function(res) {
				data = [{
					id: "",
					nama: "- Pilih Kab/Kota tempat terbit -",
					text: "- Pilih Kab/Kota tempat terbit -"
				}].concat(res);

				//implemen data ke select provinsi
				$("#select2-kabupaten").select2({
					dropdownAutoWidth: true,
					width: '100%',
					data: data,
					async : false,
				});
				$('#select2-kabupaten').val(city_id).trigger('change');
							
			})
		}
	});   
    $('#select2-kabupaten').change(function () {
        if($(this).select2('data').length > 0){
            $('input[name="tempat_terbit"]').val($(this).select2('data')[0]['text']);
        }
    });

    var dropZoneJilid = function(jilid_ke, file_type){
        let dropzoneId = "", inputFileId ="", acceptedFiles = "", maxFilesize = 5;
        switch(file_type){
            case "lampiran": 
                dropzoneId = "#attachments"+jilid_ke; 
                inputFileId = "#file_lampiran"+jilid_ke; 
                acceptedFiles = ".pdf";
                maxFilesize = 15;
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
                maxFilesize = 10;
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
                    //console.log('Sending file:', file);
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
                                console.log("File deleted successfully");
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
    $('#btnTambahJilid').on('click', function () {
        jumlah_buku += 1;
        let idJilid = jumlah_buku;
        if($('#isbn-jilid').val() != ""){
            idJilid = jumlah_buku - jml_jilid + 1;
            $('#keterangan_jilid_1').val('jilid ' + (jumlah_buku - 1));
        }
        $('#jml_hlm').val(jumlah_buku);
        let html =
            `<div class='jilidbaru'><span><h4>Data buku jilid ` + jumlah_buku + `</h4><hr/></span>
            <input type='hidden' name='keterangan_jilid[]' value='jilid `+jumlah_buku+`'>
            <input type='hidden' id='file_cover`+ idJilid + `' name='file_cover[]'>
            <div class="row mb-2">
                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">File
                    Attachment</label>
                <div class="col-lg-9 d-flex align-items-center">
                    <input type='hidden' id='file_lampiran`+ idJilid + `' name='file_lampiran[]' class="file_lampiran`+ idJilid + `">
                    <div class="dropzone p-0" id="attachments`+ idJilid + `" style="width:100%">
                        <div class="dz-message needsclick align-items-center">
                            <i class="ki-outline ki-file-up fs-2hx text-primary"></i>
                            <div class="ms-4">
                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan
                                    attachment</h3>
                                <span class="fw-semibold fs-7 text-gray-500">Max:15MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Dummy Buku yang akan
                    terbit</label>
                <div class="col-lg-9 d-flex align-items-center">
                <input type='hidden' id='file_dummy`+ idJilid + `' name='file_dummy[]' class="file_dummy`+ idJilid + `">
                    <div class="dropzone p-0" id="dummy`+ idJilid + `" style="width:100%">
                        <div class="dz-message needsclick align-items-center">
                            <i class="ki-outline ki-file-up fs-2hx text-primary"></i>
                            <div class="ms-4">
                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan file
                                    dummy buku</h3>
                                <span class="fw-semibold fs-7 text-gray-500">Accepted Files: .pdf,.epub,.mp3,.mp4,.wav, Max:
                                    10MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">Cover Buku</label>
                <div class="col-lg-9 d-flex align-items-center">
                <input type='hidden' id='file_cover`+ idJilid + `' name='file_cover[]' class="file_cover`+ idJilid + `">
                    <div class="dropzone p-0" id="cover`+ idJilid + `" style="width:100%">
                        <div class="dz-message needsclick align-items-center">
                            <i class="ki-outline ki-file-up fs-2hx text-primary"></i>
                            <div class="ms-4">
                                <h3 class="fs-8 fw-bold text-gray-900 mb-1">Masukan
                                    File Cover Buku</h3>
                                <span class="fw-semibold fs-7 text-gray-500">Max:5MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-lg-3 col-form-label fs-8 fw-semibold fs-8">
                    <span class="required">URL / LINK publikasi buku</span>
                    <span class="ms-1" data-bs-toggle="tooltip" title="url">
                        <i class="ki-outline ki-information-5 text-gray-500 fs-8"></i>
                    </span>
                </label>
                <div class="col-lg-9 fv-row">
                    <input type="text" name="url[]" class="form-control fs-8 form-control-lg form-control-solid link_buku`+ idJilid + `"
                        placeholder="url/link buku" />
                </div>
                <div class="col-lg-3 fv-row hapusJilid">
                    <span class="btn btn-danger active p-2 fs-8">Hapus Jilid</span>
                </div>
            </div></div>`;
        $('#isbn_detail').append(html);
        if (jumlah_buku > 2) {
            var objJilids = $('.jilidbaru').find();
            for (var i = 0; i <= objJilids.prevObject.length; i++) {
                if($('#isbn-jilid').val()!=""){
                    if (i < jumlah_buku - jml_jilid - 1) {
                        var btnHapus = $(objJilids.prevObject[i]).find('.btn-danger').first();
                        btnHapus.removeClass("active");
                        btnHapus.addClass('disabled');
                    }
                } else {
                    if (i < jumlah_buku - 2) {
                        var btnHapus = $(objJilids.prevObject[i]).find('.btn-danger').first();
                        btnHapus.removeClass("active");
                        btnHapus.addClass('disabled');
                    }
                }
            }
        }
        $('.btn.btn-danger.active').on('click', function () {
            $(this).parent().parent().parent().remove();
            jumlah_buku -= 1;
            var objJilids = $('.jilidbaru').find();
            for (var i = 0; i <= objJilids.prevObject.length; i++) {
                var btnHapus = $(objJilids.prevObject[i]).find('.btn-danger').first();
                if($('#isbn-jilid').val()!=""){
                    if (i < idJilid) {
                        btnHapus.removeClass("active");
                        btnHapus.addClass('disabled');
                    }
                    if (i == idJilid) {
                        btnHapus.addClass('active');
                        btnHapus.removeClass("disabled");
                    }
                } else {
                    if (i < jumlah_buku - 2) {
                        btnHapus.removeClass("active");
                        btnHapus.addClass('disabled');
                    }
                    if (i == jumlah_buku - 2) {
                        btnHapus.addClass('active');
                        btnHapus.removeClass("disabled");
                    }
                }
            }
            $('#jml_hlm').val(jumlah_buku);
        });
        if($('#isbn-jilid').val()!=""){ 
            dropZoneJilid(idJilid, "lampiran");
            dropZoneJilid(idJilid, "cover");
            dropZoneJilid(idJilid, "dummy");
        } else {
            dropZoneJilid(jumlah_buku, "lampiran");
            dropZoneJilid(jumlah_buku, "cover");
            dropZoneJilid(jumlah_buku, "dummy");
        }

        FormValidation.formValidation(
			document.getElementById('form_isbn'), { 
                fields : {
                    'file_lampiran[]' : {
                        selector: '.file_lampiran'+idJilid,
                        validators: {
                            notEmpty: {
                                 message: "Anda wajib mengunggah File Lampiran jilid " + idJilid
                            },
                        }
                    },
                    'file_dummy[]' : {
                        selector: '.file_dummy'+idJilid,
                        validators: {
                            notEmpty: {
                                message: "Anda wajib mengunggah File Dummy buku jilid " + idJilid
                            },
                        }
                    },
                    'url[]' : {
                        selector: '.link_buku'+idJilid,
                        validators: {
                            notEmpty: {
                                message: "Anda belum mengisi link buku jilid " + idJilid
                            },
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
        });
    });
    $('#isbn-jilid').on("change", function(){
        $.getJSON("{{url('/penerbit/isbn/permohonan/detail-jilid') }}" + "/" +$(this).val(), function (res) {
            $('textarea[name=title]').val(res['detail']['TITLE']);
            var kepeng =res['detail']['KEPENG'];
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
            var jenis_media = res['detail']['JENIS_MEDIA'];
            var jenis_terbitan = res['detail']['JENIS_TERBITAN'];
            var jenis_penelitian = res['detail']['JENIS_PENELITIAN'];
            var jenis_kategori = res['detail']['JENIS_KATEGORI'];
            var jenis_pustaka = res['detail']['JENIS_PUSTAKA'];
            var jenis_kelompok = res['detail']['JENIS_KELOMPOK'];
            if(jenis_media != ''){
                $('input[type=radio][name="jenis_media"][value="'+jenis_media+'"]').prop('checked', true);
            }
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
            $('textarea[name="deskripsi"]').val(res['detail']['SINOPSIS']);
            $('select[name="bulan_terbit"]').val(res['detail']['BULAN_TERBIT']);
            $('select[name="tahun_terbit"]').val(res['detail']['TAHUN_TERBIT']);
            $('input[type=text][name="distributor"]').val(res['detail']['DISTRIBUTOR']);
            $('input[type=text][name="tempat_terbit"]').val(res['detail']['TEMPAT_TERBIT']);  
            $('#jml_hlm').attr("type", "text").attr('readonly', true);
            jml_jilid = parseInt(res['detail']['JML_JILID']);
            $('#jml_hlm').val(jml_jilid);
            $('#labelJumlahHalaman').text('Jumlah Jilid');
            $('#labelKetJumlahHalaman').text('Jilid');
            //$('input[type="radio"][name="status"]').prop('disabled', true);
            $('input[type=radio][name="status"][value="jilid"]').prop('checked', true);           
            $('#edisi').val(res['detail']['EDISI']);
            $('#seri').val(res['detail']['SERI']);
            var ketebalan = res['detail']['KETEBALAN'];
            ketebalan = ketebalan.replace(' cm', '');
            $('#ketebalan').val(ketebalan);
            jumlah_buku = jml_jilid;
            $('#judul_buku_1').html('<h4>Data Buku jilid '+jumlah_buku+' </h4><hr />');
            $('#judul_buku_1').css('display', 'block');
            $('#btnTambahJilid').css('display', 'block');
            $('#labelJumlahHalaman').text('Jumlah Jilid');
            $('#labelKetJumlahHalaman').text('Jilid');
	    });
    });

    $('.onhover').css('display', 'none');
    $('.hoverEvent').hover(function () {
        var objSpan = $(this).find('.onhover').first();
        objSpan.css('display', 'block');
    }, function () {
        var objSpan = $(this).find('.onhover').first();
        objSpan.css('display', 'none');
        //stuff to do on mouse leave
    });
    $('input[type=radio][name="jenis_media"]').on('change', function () {
        var objSpan = $(this).parent().parent().find('.onhover').first();
        var notes = objSpan[0].innerHTML;
        $('#notes_jenis_media').html(notes);
    });
    $('input[type=radio][name="status"]').on('change', function () {
        if ($(this).val() == 'lepas') {
            $('#judul_buku_1').css('display', 'none');
            $('#btnTambahJilid').css('display', 'none');
            $('#labelJumlahHalaman').text('Jumlah Halaman');
            $('#labelKetJumlahHalaman').text('Halaman');
            $('#jml_hlm').attr("type", "text");
            $('#jml_hlm').val(0);
            $('#jml_hlm').removeAttr("disabled");
            $('#row-isbnjilid').hide();
            $('#isbn-jilid').val('').trigger('change');
        } else {
            $('#judul_buku_1').css('display', 'block');
            $('#btnTambahJilid').css('display', 'block');
            $('#labelJumlahHalaman').text('Jumlah Jilid');
            $('#labelKetJumlahHalaman').text('Jilid');
            $('#jml_hlm').attr("type", "text");
            $('#jml_hlm').val(jumlah_buku);
            $('#jml_hlm').attr("disabled", "disabled");
            $('#row-isbnjilid').show();
        }
    });
    $('#row-isbnjilid').hide();
    $('#judul_buku_1').css('display', 'none');
    $('#btnTambahJilid').css('display', 'none');
    var kepengarangan = 1;
    var jumlah_buku = 1;
    $('#btnTambahPengarang').on("click", function () {
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
    var formSubmit = function () {
        event.preventDefault();
        let htmlSwal = 
        Swal.fire({
                    html: `<h2>Anda yakin akan mengajukan permohonan ISBN baru?</h2> <br/> <div class="flex-column" style="text-align: left;">
                    <h5> Sesuai <b>Undang-Undang Nomor 13 Tahun 2018 tentang Serah Simpan Karya Cetak dan Karya Rekam</b></h5> <br/>
                    <b>PASAL 4</b><br/> (1) Setiap Penerbit dan Produsen Karya Rekam wajib menyerahkan <b>2 (dua) eksemplar</b> dari setiap judul Karya Cetak kepada 
                            <b>Perpustakaan Nasional</b> dan <b>1 (satu) eksemplar</b> kepada <b>Perpustakaan Provinsi</b> tempat domisili Penerbit.<br/>
                            (2) Dalam hal Perpustakaan Nasional memerlukan salinan digital atas Karya Cetak untuk kepentingan penyandang disabilitas, 
                            Penerbit wajib menyerahkan salinan digital kepada Perpustakaan Nasional.<br/>
                            (3) Karya Cetak sebagaimana dimaksud pada ayat (1) diserahkan untuk disimpan di Perpustakaan 
Nasional dan Perpustakaan Provinsi, termasuk edisi revisi.<br/>
                            (4) Penyerahan Karya Cetak sebagaimana dimaksud pada ayat (1) dilakukan <b> paling lama 3 (tiga) bulan setelah diterbitkan</b>.<br/><br/>
                    <b>PASAL 5</b><br/>(1) Setiap Produsen Karya Rekam yang mempublikasikan Karya Rekam wajib menyerahkan <b>1 (satu) 
                            salinan rekaman</b> dari setiap judul Karya Rekam kepada <b>Perpustakaan Nasional</b> dan <b>1 (satu) salinan</b> kepada <b>Perpustakaan Provinsi</b> 
                            tempat domisili Produsen Karya Rekam<br/>
                            (2) Penyerahan Karya Rekam sebagaimana dimaksud pada ayat (1) dilakukan <b> paling lama 1 (satu) tahun setelah dipublikasikan</b></div>`,
					icon: "warning",
                    width: "900px",
                    height: "80vh",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Ya, ajukan permohonan!",
                    cancelButtonText: "Tidak",
                    
                    customClass: {
                        confirmButton: "btn fw-bold btn-success",
                        cancelButton: "btn fw-bold btn-active-light-danger"
                    }
            	}).then(function(e) {
					if(e.isConfirmed == true) {
                        postForm()
                    } else {
                        $('.loader').css('display', 'none');
                    }
        })
        $('.loader').css('display', 'block');
        
    };
    var postForm = function(){
        let form = document.getElementById('form_isbn');
        let formData = new FormData(form);
        formData.append('jumlah_jilid', jumlah_buku);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });
        $.ajax({
            url: "{{ url('penerbit/isbn/permohonan/new/submit') }}",
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            statusCode: {
                422: function (xhr) {
                    var error = '<div class="alert alert-danger d-flex align-items-center p-5 mb-10"><div class="d-flex flex-column" style="text-align: left;"><ul>';
                    $.each(xhr.responseJSON.err, function (key, value) {
                        error += '<li>' + value[0] + '</li>';
                    });
                    error += '</ul></div></div>';
                    Swal.fire({
                        title: "Validation Error!",
                        html: error,
                        buttonsStyling: !1,
                        confirmButtonText: "Ok!",
                        width: '800px',
                        heightAuto: false,
                        height: '800px',
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                            content: "swal-height"
                        }
                    });
                },
                200: function (xhr) {
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
                    }).then(function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = '{{ url("/penerbit/isbn/permohonan/detail/") }}' + '/'+ xhr.noresi
                        }
                    });
                },
                500: function (xhr) {
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
            complete: function () {
                $('.loader').css('display', 'none');
            },
        });
    }
    var deleteKepengarangan = function (numb) {
        $('#kepengarangan_' + numb).remove();
    };
    dropZoneJilid(jumlah_buku, "lampiran");
    dropZoneJilid(jumlah_buku, "cover");
    dropZoneJilid(jumlah_buku, "dummy");
</script>
@stop