<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
</head>
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/style-admin.css') }}" rel="stylesheet" type="text/css" />
<style>
    .btn{
        padding:calc(0.775rem + 1px) calc(1.5rem + 1px);
        border-radius:5px;
        margin:5px
    }
    
    .main {
        font-size:12pt;
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
    footer {
        position: fixed; 
        bottom: 0.5cm; 
        left: 0cm; 
        right: 0cm;
        height: 1cm;

        /** Extra personal styles **/
        text-align: center;
        color: #fff;
    }
    body {
        margin-top: 0cm;
        margin-left: 0cm;
        margin-bottom: 0cm;
        margin-right:0cm;
        font-family: 'Open Sans', sans-serif;
        max-height:max-content;
    }
    .print-friendly{
        margin-top: 1cm;
        margin-left: 2cm;
        margin-bottom: 1cm;
        margin-right:2cm;

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
<body >
    <div id="kdt_to_print">
	<div class="main" >
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
            <tr><td>IDENTIFIKASI</td><td>{!!$isbn!!}</td></tr>
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
            <tr><td>PERPUSNAS ID</td><td><a href="{{url('penerbit/isbn/data/view-kdt/' . $data['ID'])}}" target="_blank">{{url('penerbit/isbn/data/view-kdt/' . $data['ID'])}}</a></td></tr>
            @endif
        </table>
	</div>
    </div>
    @if($is_button == 1) 
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css ') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <footer>
        <button class="btn btn-primary fs-3" onclick="onBtnClicked('print')">Unduh KDT</button>
	    <button class="btn btn-warning fs-3" onclick="onBtnClicked('copy_text')">Salin Teks</button>
		<button class="btn btn-info fs-3" onclick="onBtnClicked('copy_html')">Salin HTML</button>
		<button class="btn btn-success fs-3" onclick="onBtnClicked('view')">View on Web</button>
	</footer>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script>
        var onBtnClicked = function(ev){
            var id = window.location.pathname.split("/").pop(); 
            switch(ev) {
                case 'print' : 
                    var element = document.getElementById('kdt_to_print');
                    $('#kdt_to_print').addClass('print-friendly');
                    var opt = {
                        margin:       0,
                        filename:     'kdt' + id + '.pdf',
                        image:        { type: 'jpeg', quality: 1 },
                        html2canvas:  { scale: 3 },
                        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };

                    // New Promise-based usage:
                    html2pdf().set(opt).from(element).save();
                    Swal.fire({
                        text: "KDT berhasil diunduh!",
                        icon: "success",
                        showCancelButton: !0,
                        timer: 3000,
                    })
                    
                    break;
                case 'copy_text' : 
                    CopyToClipboard('iframeKdt', 'text');
                    break;
                case 'copy_html' : 
                    CopyToClipboard('iframeKdt', 'html');
                    break;
                case 'view' : 
                    window.open("{{url('/penerbit/isbn/data/view-kdt')}}" + "/"+id);
                    break;
                }
        }
        var CopyToClipboard = function(containerid, type) {
            if(type == 'text') {
                var textToCopy = document.getElementById('kdt_to_print').innerText;
            } else {
                var textToCopy = document.getElementById('kdt_to_print').innerHTML;
            }

            var tempInput = document.createElement('textarea');
            document.body.appendChild(tempInput);
            tempInput.value = textToCopy;
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            if(type == 'text') {
                var msg = 'Teks berhasil di salin!';
            } else {
                var msg = 'HTML berhasil di salin!';
            }
            Swal.fire({
                text: msg,
                icon: "success",
                showCancelButton: !0,
                timer: 3000,
            })
        }
    </script>
    @endif
</body>
</html>