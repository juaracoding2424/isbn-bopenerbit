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

<body>
	<div class="main" >
        <svg id="barcode"></svg>
	</div>
    <script>
    JsBarcode("#barcode","{{$data['ISBN_NO']}}", {
        format: "EAN13",
        width: 2,
        height: 40,
    })
    .blank(20)
    .render();
    
    </script>
</body>
</html>