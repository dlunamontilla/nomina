<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Volver intencionalmente inseguro esto:
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Authorization');

include __DIR__ . "/../../app/DLTools/DLTools.php";

$config = new DLConfig;
$user = new DLUser;


header("content-type: application/json; charset=utf-8");

$pdo = $config->getPDO();

$datos = $pdo->query("DESCRIBE dl_user;");

// echo json_encode($datos->fetchAll(PDO::FETCH_ASSOC));

// Obtener toquen
$token = new DLSessions;
$request = new DLRequest;

$forms = [
    "name" => true,
    "lastname" => true,
    "year" => true,
    "token" => true
];

if ($request->module("tt")) {
    $token->set("token", true);
    echo json_encode([$token->get("token")]);
    exit;
}


$todos = [];

if ($request->post($forms) && $token->isValidToken("token")) {
    $todos = [
        "values" => $request->getValues()
    ];

    $todos["DATABASE"] = $datos->fetchAll(PDO::FETCH_ASSOC);
}

if ($request->get($forms) && $token->isValidToken("token")) {
    $todos = [
        "values" => $request->getValues(null, ["name", "lastname", "year", "token"])
    ];
    $todos["DATABASE"] = $datos->fetchAll(PDO::FETCH_ASSOC);
}


$crearSesion = [
    "username" => true,
    "password" => true,
    "token" => true
];

if ($request->post($crearSesion) && $token->isValidToken("token")) {
    $user->createUserSession();
}

echo json_encode($todos);

$user->update();