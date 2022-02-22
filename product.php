<?php

// Esto es un array de objetos:
$phones = [
    [
        "product_title" => "iPhone 7",
        "product_description" => "Descripción del producto",
        "product_image" => "",
        "product_price" => 0,
        "product_color" => "color del producto",
        "product_money" => "USD"
    ],

    [
        "product_title" => "Samsung Galaxy S7",
        "product_description" => "Descripción del producto",
        "product_image" => "",
        "product_price" => 0,
        "product_color" => "color del producto",
        "product_money" => "USD"
    ]
];

if (isset($_GET['phones'])) {
    header("content-type: application/json; charset=utf-8");

    // Y se parsea aquí:
    echo json_encode($phones);
}