<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800,800i,900|Quicksand:300,400,500,700&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese');
    /*-------------General Style---------------------------------------*/
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFWJ0bbck.woff2) format('woff2');
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
    }
    /* cyrillic */
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFUZ0bbck.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }
    /* greek-ext */
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFWZ0bbck.woff2) format('woff2');
        unicode-range: U+1F00-1FFF;
    }
    /* greek */
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFVp0bbck.woff2) format('woff2');
        unicode-range: U+0370-03FF;
    }
    /* vietnamese */
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFWp0bbck.woff2) format('woff2');
        unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
    }
    /* latin-ext */
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFW50bbck.woff2) format('woff2');
        unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    /* latin */
    @font-face {
        font-family: 'Open Sans';
        font-style: normal;
        font-weight: 400;
        src: local('Open Sans Regular'), local('OpenSans-Regular'), url(https://fonts.gstatic.com/s/opensans/v17/mem8YaGs126MiZpBA-UFVZ0b.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    @page {
        margin: 0cm 0cm;
    }
    
    .main {
        font-size:12pt;
    }
    footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 2cm;

        /** Extra personal styles **/
        background-color: #fff;
        color: #000;
        text-align: center;
    }

    footer table{
        padding-right:  1cm;
        padding-left:   1cm;
        width : 100%;
    }
    * {
        font-family: 'Open Sans', sans-serif;
    }
    a {
        color: blue;
        text-decoration: none;
    }
    img {
        margin : 15px;
    }
    hr{
        color : #9932CC;
        background: #9932CC;
        height: 0.1cm;
    }
    td{
        padding-right:10px;
        padding-bottom:5px;
        vertical-align:top;
    }
</style>
@if($bo_penerbit != 1)
    <style>
    body {
        margin-top: 1cm;
        margin-left: 2cm;
        margin-bottom: 1cm;
        margin-right:2cm;
        font-family: 'Open Sans', sans-serif;
    }
    </style>
    @endif
<body>
	<footer>
		<table style="font-size:x-small;">
			<tr>
				<td align="right" style="vertical-align: bottom;">Created at {{ date('d-M-Y H:m:s')}}</td>
			</tr>
		</table>
	</footer>
	<div class="main" id="kdt_to_print">
        <table style=" border-collapse: collapse;border: none;">
            @if($data['AUTHOR'] != "")
            <tr><td>KREATOR</td><td>{{$data['AUTHOR']}}</td></tr>
            @endif
            <tr><td>JUDUL DAN PENANGGUNG JAWAB</td><td>{{$data['TITLE']}} / {{$data['KEPENG']}}</td></tr>
            <tr><td>PUBLIKASI</td><td>{{$data['TEMPAT_TERBIT']}} : {{$data['NAME']}}, {{$data['TAHUN_TERBIT']}}</td></tr>
            @if($data['EDISI'] != "")
            <tr><td>EDISI</td><td>{{$data['EDISI']}}</td></tr>
            @endif
            @if($data['SERI'] != "")
            <tr><td>SERI</td><td>{{$data['SERI']}}</td></tr>
            @endif
            @php
            if(!str_contains($data['JML_HLM'], 'jil')){
                if(str_contains($data['JML_HLM'], 'hlm') || str_contains($data['JML_HLM'], 'halaman')){
                    $hlm = $data['JML_HLM'];
                }else {
                    $hlm = $data['JML_HLM'] . ' halaman';
                }
            } else {
                $hlm = $data['JML_HLM'];
            }
            if($data['JENIS_MEDIA'] == 1 || $data['JENIS_MEDIA'] == 2){
                if($data['KETEBALAN'] == ""){
                    $hlm .= '; ...cm';
                } else {
                    $hlm .= '; ' . $data['KETEBALAN'] . ' cm';
                }
            }
            @endphp
            <tr><td>DESKRIPSI FISIK</td><td>{{$hlm}}</td></tr>
            @if($data['DISTRIBUTOR'] != "")
            <tr><td>DISTRIBUTOR</td><td>{{$data['DISTRIBUTOR']}}</td></tr>
            @endif
            <tr><td>IDENTIFIKASI</td><td>ISBN {{$data['PREFIX_ELEMENT']}}-{{$data['PUBLISHER_ELEMENT']}}-{{$data['ITEM_ELEMENT']}}-{{$data['CHECK_DIGIT']}}</td></tr>
            <tr>
                <td>SUBJEK</td>
                <td>{{$data['SUBJEK']}} 
                    @if($data['SUBJEK1'] !='')<br/> {{$data['SUBJEK1']}} @endif
                    @if($data['SUBJEK2'] !='')<br/> {{$data['SUBJEK2']}} @endif
                    @if($data['SUBJEK3'] !='')<br/> {{$data['SUBJEK3']}} @endif
                    @if($data['SUBJEK4'] !='')<br/> {{$data['SUBJEK4']}} @endif
                    @if($data['SUBJEK5'] !='')<br/> {{$data['SUBJEK5']}} @endif
                </td>
            </tr>
            @if($data['JEJAKAN'] != "")
            @php $k = explode(";", $data['JEJAKAN']); @endphp
            <tr>
                <td>KONTRIBUTOR</td>
                <td>
                    @foreach($k as $k_)
                    {{$k_}}<br/>
                    @endforeach
                </td>
            </tr>
            @endif
            <tr><td>KLASIFIKASI</td><td>{{$data['CALL_NUMBER']}} [DDC23]</td></tr>
            @if($bo_penerbit == 1)
            <tr><td>PERPUSNAS ID</td><td><a href="{{url('penerbit/isbn/data/view-kdt/' . $data['ID'])}}">{{url('penerbit/isbn/data/view-kdt/' . $data['ID'])}}</a></td></tr>
            @endif
        </table>
	</div>
</body>
</html>