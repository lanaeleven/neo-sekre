<!-- resources/views/pdf/image-to-pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .image-container {
            text-align: center;
            margin-top: 50px;
        }
        img {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="image-container">
        <img src="data:image/jpeg;base64,{{ base64_encode($imageContent) }}" alt="Image">
    </div>
</body>
</html>
