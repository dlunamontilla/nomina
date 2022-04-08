<?php
  // Procesar recapcha de Google:
  function reCAPTCHA( $response, $ruta = __DIR__ . "/../../../../.google" ) {
    
    // Ruta de la petición:
    $url = "https://www.google.com/recaptcha/api/siteverify";
    
    // $ip = @$_SERVER['REMOTE_ADDR'];

    if ( !file_exists($ruta) )
      return false;

    $clave = file_get_contents($ruta);

    // Datos de envío:
    $datos = [
      "secret" => $clave,
      "response" => $response
    ];
    // $datos = [
    //   "secret" => "6LfNtGkaAAAAAJE-tAHy73yDPlVMjjwVERRZ7Az0",
    //   "response" => $response
    // ];

    // Opciones de envío:
    $opciones = [
      "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($datos)
      ]
    ];

    // Preparando la petición:
    $contexto = stream_context_create($opciones);

    // Enviar la petición:
    $resultados = file_get_contents($url, false, $contexto);
    $resultados = json_decode($resultados);

    return $resultados -> success;
  }
?>