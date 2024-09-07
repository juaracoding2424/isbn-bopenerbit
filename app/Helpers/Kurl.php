<?php

use Illuminate\Support\Facades\Http;

/*
params kurl
$method = post/get
$action = add, getlist, update, delete
$table = table yang akan dieksekusi
$data = data filter atau data update atau data add yang berupa array
$kategori = dari backend ada ListAddItem, ListUpdateItem
$params = untuk penambahan params pada saat req api (pagination dll)
*/

function kurl($method, $action, $table, $data, $kategori, $params = null) { 

    $body = $action == 'getlistraw' ? $data : json_encode($data);
    $form_data = [
        'token' => config('app.inlis_api_token'),
        'op' => $action,
        'table' => $table,
        $kategori => $body
    ];

    //page
    if (!empty($params)) {
        $form_data = array_merge($form_data, $params);
    }
    $response = Http::asForm()->$method(config('app.inlis_api_url'), $form_data);

    if ($response->successful()) {
        $data = $response->json();
        return $data;

    } else {
        // Handle the error
        $status = $response->status();
        $error = $response->body();
        return $status;
    }
}

function kurl_upload($method, $penerbit, $terbitan_id, $jenis, $file, $ip_user) {
    //$jenis : lampiran_permohonan, dummy_buku, lampiran_pending
    $response = Http::asMultipart()->$method(config('app.inlis_api_url'), [
        [
            'name'     => 'token',
            'contents' => config('app.inlis_api_token'),
        ],
        [
            'name'     => 'op',
            'contents' => 'uploadfilelampiran',
        ],
        [
            'name'     => 'jenis',
            'contents' => $jenis,
        ],
        /*[
            'name'     => 'penerbitisbnid',
            'contents' => $penerbit['ID'],
        ],*/
        [
            'name'     => 'penerbitterbitanid',
            'contents' => $terbitan_id,
        ],
        [
            'name'     => 'actionby',
            'contents' => $penerbit['USERNAME'],
        ],
        [
            'name'     => 'terminal',
            'contents' => $ip_user,
        ],
        [
            'name'     => 'file',
            'contents' => fopen($file->getRealPath(), 'r'),
            'filename' => $file->getClientOriginalName(),
        ],
    ]);
    \Log::info($response);
    if ($response->successful()) {
        $data = $response->json();
        return $data;

    } else {
        // Handle the error
        $status = $response->status();
        $error = $response->body();
        return $status;
    }
}