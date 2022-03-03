<?php
include __DIR__ . "/../server.php";
?>

<!DOCTYPE html>
<html lang="es-VE">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title>Nómina</title>

    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="./build/bundle.css" />

    <script defer src="./build/bundle.js"></script>
</head>

<body>
    <h2><?= $info; ?></h2>

    <h3>Luis Barreto</h3>
    <hr>
    <div class="luis">
        <button>Luis Barreto</button>
    </div>
    <pre><?php $dl404->checked(); ?></pre>
</body>

</html>