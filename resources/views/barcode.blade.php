<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css ') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/JsBarcode.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>

<body style="width:max-content">
	<div class="main" id="content" >
        <span style="position: relative;width: 350px; display: flow;text-align: center; font-weight:600; font-size:16px; margin-bottom:-10px; z-index:99; background-color:#fff; color:#000">
            ISBN  {{ $data['PREFIX_ELEMENT'].'-'. $data['PUBLISHER_ELEMENT'] . '-' . $data['ITEM_ELEMENT'] . '-' . $data['CHECK_DIGIT']}}
        </span>
        <svg id="barcode" style="width:350px; z-index:1"></svg>
	</div>
    <script>
    JsBarcode("#barcode","{{$data['ISBN_NO']}}", {
        format: "EAN13",
        width: 2.5,
        height: 45,
    })
    .blank(20)
    .render();
    </script>
    @if($is_button == 1)
    <style>
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
    .main{
        width:max-content;
    }
    </style>
    <footer>
        <button class="btn btn-primary" onclick="barcodeSave()">Unduh KDT</button>
    </footer>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
    var barcodeSave = function() {
        var id = window.location.pathname.split("/").pop(); 
		html2canvas(document.getElementById('content')).then(canvas => {
            let link = document.createElement('a');
            link.download = id + '.jpg';
            link.href = canvas.toDataURL('image/jpeg');
            link.click();
        });
	}
    @endif
    </script>
    
</body>

</html>