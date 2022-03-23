<?php

/**
 * Permitirá crear cookies con valores predeterminados. la hora se podrá 
 * establecer de forma numérica en forma de 1 hora, es decir, cada unidad
 * representa una hora.
 * 
 * @package DLCookies
 * @version 1.0.0
 * @author David E Luna <davidlunamontilla@gmail.com>
 * @copyright (c) 2022 - David E Luna M
 * @license MIT
 */

class DLCookies {

    /** @var array Configuración por defecto de la cookie */
    private $config;

    public function __construct() {

        $this->config = [
            'expires' => time() + 60*60*24*30,
            'path' => '/',
            'domain' => $_SERVER['SERVER_NAME'], // leading dot for compatibility or use subdomain
            'secure' => true,     // or false
            'httponly' => true,    // or false
            'samesite' => 'Strict' // None || Lax || Strict
        ];
    }

    /**
     * @param array $config Opciones de creación de una cookie.
     */
    public function setConfig(array $config): void {
        
        foreach($config as $key => $value) {
            if (array_key_exists($key, $this->config)) {
                echo "\$key: $key => " . json_encode($value) . "\n";

                $this->config[$key] = $value;
            }
        }
    }

    public function set(string $name, string $value): bool {
        return setcookie($name, $value, $this->config);
    }
}

