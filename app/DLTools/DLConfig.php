<?php

/**
 * Permitirá capturar todas las variables de entorno.
 * 
 * @package DLConfig
 * @version 1.0.0
 * @author David E Luna <davidlunamontilla@gmail.com>
 * @copyright (c) 2022 - David E Luna M
 * @license MIT
 */
class DLConfig {
    protected $ruta = "";

    public function __construct($ruta = __DIR__ . "/../../.env") {
        $this->ruta = $ruta;
        if (!file_exists($ruta)) {
            echo "<h2>Establezca los parámetros de conexión en <code>.env</code>";
            exit;
        }

        // Se cargan las variables de entorno:
        $this->credentials = $this->env();
    }

    /**
     * Devuelve las credenciales del archivo .env.
     * @return array
     */
    private function env(): array {
        if (!file_exists($this->ruta))
            return [];

        /**
         * @var array
         */
        $credentials = [];

        // Obtenemos las líneas del archivo:
        $lines = file($this->ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            list($name, $vañie) = explode("=", $line, 2);

            $name = trim($name);
            $vañie = trim($vañie);

            putenv(sprintf("%s=%s", $name, $vañie));

            $credentials[$name] = $vañie;
        }

        return $credentials;
    }

    /**
     * Devuelve las credenciales almacenadas en .env
     * @return object
     */
    public function getCredentials(): object {
        return (object) $this->credentials;
    }

    /**
     * Establece y obtiene una conexión con el motor de base de datos.
     * @return PDO
     */
    public function getPDO(): PDO {
        $username = getenv("DL_USERNAME");
        $password = getenv("DL_PASSWORD");
        $database = getenv("DL_DATABASE");
        $host = getenv("DL_HOST");
        $drive = getenv("DL_DRIVE");

        /**
         * @var string
         */
        $dsn = "$drive:dbname=$database;host=$host";

        $pdo = new PDO($dsn, $username, $password);

        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
