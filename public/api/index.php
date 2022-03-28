<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Volver intencionalmente inseguro esto:
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Authorization');

include __DIR__ . "/../../app/DLTools/DLTools.php";

$user = new DLUser;


header("content-type: application/json; charset=utf-8");

$request = new DLRequest;

$forms = [
    "name" => true,
    "lastname" => true,
    "year" => true,
    "token" => true
];

if ($request->module("tt")) {
    $token = new DLSessions;
    $token->set("token", false);
    echo json_encode([$token->get("token")]);
    exit;
}


$todos = [];


$crearSesion = [
    "username" => true,
    "password" => true,
    "token" => true
];

if ($request->post($crearSesion)) {
    $user->createUserSession();
}

echo json_encode($todos);

$user->updatePassword();