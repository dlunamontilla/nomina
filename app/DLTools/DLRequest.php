<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

/**
 * @package DLRequest
 * @author David E Luna M <davidlunamontilla@gmail.com>
 * @copyright (c) 2022 - David E Luna M
 * @version 0.0.1B
 * @license MIT
 */

class DLRequest {
    /**
     * @var string
     */
    private string $method = "";

    /**
     * @var object
     */
    private object $values;

    /**
     * @var array $request Métodos $_GET o $_POST
     */
    private array $request;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->request = $this->method == "POST"
            ? $_POST
            : $_GET;

        $this->values = (object) [];
    }

    /**
     * @param Array<string, bool> $requests Array de parámetros de una
     * petición realizada por el usuario para validarlos con el formulario
     * o una ruta.
     * 
     * @param bool $distribute Definir si se distribuirá en varios módulos
     * o debe llevar varios parámetros en una petición para realizar una 
     * acción solicitada por el usuario.
     */
    private function validate(array $requests, bool $distribute = false): bool {

        /**
         * @var array Capturar los valores de las peticiones ya
         * depuradas.
         */
        $values = [];

        /**
         * @var int Contar coincidencias para una acción distribuidas
         * en diferentes módulos. No se permite realizar una acción en
         * varios módulos activos simultáneamente si $distribute es «true».
         */
        $count = 0;

        /** No se permite que el método POST esté vacío */

        /**
         * No se permite que el método POST esté vacío o que esté
         * combinado con $distribute establecido a «true»
         */
        if (
            ($this->method === "POST" && !count($_POST) > 0) ||
            ($this->method === "POST" && $distribute)
        ) {
            $this->values = (object) [];
            return false;
        }

        if (!$distribute) foreach ($requests as $key => $require) {

            if (!array_key_exists($key, $this->request)) return false;

            if ($require) {
                if (empty($this->request[$key])) return false;
            }

            $value = $this->request[$key];

            if (is_numeric($value)) {
                $values[$key] = (double) $value;
                continue;
            }

            $values[$key] = (string) $value;
        }

        /**
         * Si el usuario elige realizar una acción en varios módulos de 
         * forma no simultánea.
         */
        if ($distribute) {
            foreach ($requests as $key => $require) {
                if (array_key_exists($key, $this->request)) $count++;

                if (array_key_exists($key, $this->request)) {
                    $values[$key] = $this->request[$key];
                }
            }

            return $count === 1;
        }

        $this->values = (object) $values;

        return true;
    }

    /**
     * 
     * @param Array<string, bool> $requests Se pasa como parámetro un 
     * Array asociativo para validar los campos del formulario o parámetros
     * de una petición mediante este método de envío.
     * 
     * @return bool
     * 
     * Esta función permite validar las peticiones hechas a través
     * del método de envío «POST».
     */
    public function post(array $requests): bool {
        return $this->method === "POST"
            ? $this->validate($requests)
            : false;
    }

    /**
     * @param Array<string, bool> $requests Se pasa como parámetro un array
     * asociativo para validar los parámetros de la petición get con éste.
     * 
     * @param bool $distribute En ella se define de qué forma se va a validar
     * los parámetros de la petición. Si es «false» (valor por defecto) deben
     * coincidir los parámetros de la petición con las claves del array que se 
     * pasa como argumento. En el caso contrario, solo debe debe coincidir de 
     * forma excluyente un parámetro de la petición con la clave del array 
     * asociativo.
     */
    public function get(array $requests, $distribute = false): bool {
        return $this->method === "GET"
            ? $this->validate($requests, $distribute)
            : false;
    }

    /**
     * @param string $module Validar el módulo. Se trata de un parámetro de
     * una petición mediante GET.
     * 
     * @return bool
     */
    public function module(string $module): bool {
        return $this->get([$module => false], true);
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    public function getValues(): object {
        return $this->values;
    }
}

/** @var \DLRequest */
$request = new DLRequest;

$form = [
    "name" => true,
    "probar" => true,
    "gipsemar" => false
];

if ($request->post($form)) {
    echo json_encode($request->getValues());
    print_r($request->getValues());
}

if ($request->get($form, true)) {
    // echo json_encode($request->getValues());
}

// echo json_encode($request->getValues($form));

// Comprobar los tipos de datos: