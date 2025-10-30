<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
    .button {
	box-shadow:inset 0px 1px 0px 0px #a4e271;
	background:linear-gradient(to bottom, #89c403 5%, #77a809 100%);
	background-color:#89c403;
	border:2px solid #74b807;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:12px;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #528009;
    }
    .button:hover {
        background:linear-gradient(to bottom, #77a809 5%, #89c403 100%);
        background-color:#77a809;
    }
    .button:active {
        position:relative;
        top:1px;
    }
    a:visited {
    color: white;
    }
    p{
    font-size:16px;
    }


    </style>
</head>
<body>
    <p>Assalamualaikum Wr Wb, {{ $nama }}</p>
    <p>Anda Memiliki Disposisi baru yang harus ditindaklanjuti.</p>
    <p>Silakan masuk ke Web Surat RSI Sultan Agung Banjarbaru untuk menindaklanjuti disposisi</p>
    <p><a href="https://surat.rsisabanjarbaru.com/" class="button">Masuk Aplikasi Surat RSI</a></p>
    <p>Berikut detail disposisinya:</p>
    <p>Oleh: {{ $pengirim }}</p>
    <p>Kepada: {{ $penerima }}</p>
    <p>Tanggal: {{ $tanggal }}</p>
    <p>Instruksi: {{ $instruksi }}</p>
</body>
</html>