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
     * @return void
     */
    public function setConfig(array $config): void {
        
        foreach($config as $key => $value) {
            if (array_key_exists($key, $this->config)) {
                echo "\$key: $key => " . json_encode($value) . "\n";

                $this->config[$key] = $value;
            }
        }
    }

    /**
     * @param string $name Nombre de la cookie que va a crear.
     * @param string $value Valor de la cookie.
     * 
     * @return bool Si la cookie fue creada con éxito devuelve «true», de lo
     * contrario, devolverá «false»
     */
    public function set(string $name, string $value): bool {
        return setcookie($name, $value, $this->config);
    }

    /**
     * @param string $key Nombre de la cookie.
     * @return string Valor devuelto de la cookie. Si la cookie no existe
     * devolverá una cadena vacía.
     */
    public function get(string $key): string {
        return array_key_exists($key, $_COOKIE)
            ? $_COOKIE[$key]
            : "";
    }
}

