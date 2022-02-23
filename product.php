<?php

// Esto es un array de objetos:
$phones = [
    [
        "product_title" => "iPhone 7",
        "product_description" => "Descripción del producto",

        "attributes" => [
            "image" => "",
            "price" => 0,
            "color" => "",
            "money" => "USD"
        ]
    ],

    [
        "product_title" => "Samsung Galaxy S7",
        "product_description" => "Descripción del producto",

        "attributes" => [
            "image" => "",
            "price" => 0,
            "color" => "",
            "money" => "USD"
        ]
    ]
];

if (isset($_GET['phones'])) {
    header("content-type: application/json; charset=utf-8");

    // Y se parsea aquí:
    echo json_encode($phones);
}
