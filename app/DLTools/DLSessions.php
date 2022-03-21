<?php

/**
 * @package DLSessions
 * @author David E Luna M <davidlunamontilla@gmail.com>
 * @copyright (c) 2022 - David E Luna M
 * @version 0.0.1B
 * @license MIT
 */
class DLSessions {
    /** @var string */
    private $host;

    /**
     * @var array | string | null Si el origen de la petición 
     * es conocida se almacenará acá para comprobar que es legítima.
     */
    private $found_origin;

    /**
     * @var array | string | null Propiedad dinámica que permite determinar
     * si la referencia legítima.
     */
    private $found_referer;


    /**
     * @var string Mensaje que será enviada a los archivos logs.
     */
    private $info = "";

    /**
     * @var string Ruta del directorio donde se encuentra alojado error_log.log
     */
    private $path;

    /**
     * @var string Ruta del archivo error_log.log
     */
    private $pathfile;

    /**
     * @var string Permite obtener de forma dinámica el método de envío
     * de la petición o formulario.
     */
    private $method;

    public function __construct() {
        session_start();

        $this->host = (string) $this->server("SERVER_NAME");
        preg_match("/$this->host/", $this->getReferer(), $this->found_referer);
        $this->found_referer = json_encode($this->found_referer);

        // Ruta del archivo error_log
        $this->path = __DIR__ . "/../../logs";
        $this->pathfile = $this->path . "/error_log.log";

        $this->method = $this->server('REQUEST_METHOD', true);
    }

    /**
     * @param string $message Permite enviar un mensaje al archivo 
     * error_log.log. Si el archivo no existe lo creará automáticamente
     * siempre que tenga los permisos de escritura.
     * 
     * @return bool
     * Devuelve true si logra almacenar datos en el archivo de destino.
     */
    public function error_log(string $message): bool {
        if (is_writable($this->path) && !file_exists($this->path)) {
            mkdir($this->path, 0755);
            
            if (!file_exists($this->pathfile)) touch($this->pathfile);
        }

        if (is_writable($this->pathfile)) {
            return error_log("$message\n", 3, $this->pathfile);
        }

        return false;
    }

    /**
     * @param string $key Pasar como argumento cualquier índice de $_SERVER.
     * @param bool $string Se indica que devuelva una cadena vacía con el valor
     * establecido a «true» en el caso de que el índice no se encuentre en 
     * $_SERVER. El valor por defecto es false.
     * 
     * @return string | array
     */
    public function server(?string $key = null, bool $string = false): string | array {
        if (!array_key_exists($key, $_SERVER) && !$string) return $_SERVER;
        if (!array_key_exists($key, $_SERVER) && $string) return "";

        return $_SERVER[$key];
    }

    /**
     * Esta función genera HASH, que es el valor del token que se envía al formulario
     * desde el cual se hará la petición.
     * 
     * @param string $key Nombre del token que se desea generar.
     * @param bool $overwrite Por defecto, sobreescribe el token si este
     * existe previamente. Cuando se establece a «true» y el token no existe
     * lo crea, de lo contrario, no realiza ninguna acción.
     */
    public function set(string $key, bool $overwrite = true): void {
        if ($overwrite) {
            $_SESSION[$key] = bin2hex(random_bytes(32));
            return;
        }
        
        if (empty($this->get($key))) {
            $_SESSION[$key] = bin2hex(random_bytes(32));
        }
    }

    /**
     * @param string $key Se pasa como parámetro el nombre del token
     * al que se le desea extraer el HASH previamente definido en DLSessions::set.
     * 
     * @return string | array Devuelve un array o una cadena en función de
     * si se pasa un parámetro o no.
     */
    public function get(string $key = null): string | array {

        if ($key) return array_key_exists($key, $_SESSION)
            ? $_SESSION[$key]
            : "";

        return $_SESSION;
    }

    /**
     * @return string Devuelve la referencia (URL) desde donde se
     * realiza la petición.
     */
    public function getReferer(): string {
        return $this->server('HTTP_REFERER', true);
    }

    /**
     * Verifica el token del formulario para determinar si la petición 
     * hecha es legítica.
     * 
     * @param string $key Clave del token que se pretende validar.
     * @param bool $extra Si se establece a «true» se le estará indicando
     * que no solamente valide el token anti csrf. También se le indica que 
     * valide si la referencia de origen es válida.
     * 
     * @return bool.
     */
    public function isValidToken($key, bool $extra = false): bool {
        /**
         * @var bool Devuelve false o true en función de si los hashes de la
         * sesión y el que se envía desde el formulario coinciden.
         */
        // $is_valid = hash_equals($this->get($key), $_POST[$key]);

        $is_valid = $this->method === "POST"
            ? hash_equals($this->get($key), $_POST[$key])
            : hash_equals($this->get($key), $_GET[$key]);

        if (array_key_exists($key, $_POST)) {
            if ($extra) {
                return $this->isValidReferer() && $is_valid;
            }

            return $is_valid;
        }

        if (array_key_exists($key, $_GET)) {

            if ($extra) {
                return $this->isValidReferer() && $is_valid;
            }

            return $is_valid;
        }

        return false;
    }

    /**
     * @return string Devuelve el origin de la petición. Es similar
     * a DLSessions::getReferer
     * 
     * Esta función solo se recomienta en peticiones POST.
     */
    public function getHttpOrigin(): string {
        return $this->server("HTTP_ORIGIN", true);
    }

    /**
     * @return bool
     * Devuelve «true» si el origen de la petición es legítima
     */
    public function isValidReferer(): bool {
        preg_match("/$this->host/", $this->getReferer(), $this->found_referer);

        if (!$this->found_referer) {
            $this->error_log("Se intentó realizar una petición desde " . $this->getReferer() . " al servidor $this->host\n");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     * Es similar a DLSession::isValidReferer, es decir, permite evaluar si la
     * petición tiene un origen legitimo para procesarla, pero con la diferencia
     * que solamente se puede utilizar con el método de envío POST.
     */
    public function isValidOrigin(): bool {
        preg_match("/$this->host/", $this->getHttpOrigin(), $this->found_origin);

        if (empty(trim($this->getHttpOrigin()))) {
            $this->error_log("Utilice solamente la función DLSessions::isValidOrigin con el método POST");
            return false;
        }

        if (!$this->found_origin) {
            $this->error_log("Se intentó realizar una petición con el método $this->method desde " . $this->getHttpOrigin() . " al servidor $this->host\n");
            return false;
        }

        return true;
    }
}