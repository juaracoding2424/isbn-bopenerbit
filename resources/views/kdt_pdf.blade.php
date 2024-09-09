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
    body {
        margin-top: 2cm;
        margin-left: 2cm;
        margin-bottom: 2cm;
        margin-right:2cm;
        font-family: 'Open Sans', sans-serif;
    }
    .main {
        font-size:12pt;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 1cm;
        right: 1cm;
        height: 2cm;

        /** Extra personal styles **/
        background-color: #fff;
        color: #000;
        text-align: center;
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
        color: #fff;
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
    th, td {
        border-bottom: 1px solid #ddd;
    }
</style>
<body>
	<header>
		<table width="100%" style="font-size:x-small;">
			<tr>
				<td align="left" style="width: 40%;">
					<h2>KATALOG DALAM TERBITAN</h2>
				</td
			</tr>

		</table>
	</header>
	<footer>
		<table style="font-size:x-small;">
			<tr>
				<td align="right" style="vertical-align: bottom;">Created at {{ date('d-M-Y H:m:s')}}</td>
			</tr>
		</table>
	</footer>
	<div class="main">
        <u style="margin-bottom:0px">Perpustakaan Nasional RI. Data Katalog dalam Terbitan (KDT).</u>
        <pre style="overflow-y:scroll; max-width:700px; height:300px; white-space:pre-wrap;text-align:left; font-size:10pt; margin-top:0px">
        {{$data}}</pre>

	</div>
</body>
</html>