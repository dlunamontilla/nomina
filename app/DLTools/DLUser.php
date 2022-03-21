<?php
/**
 * @package DLUser
 * @version 2.0.0
 * @author David E Luna <davidlunamontilla@gmail.com>
 * @copyright (c) 2022 - David E Luna M
 * @license MIT
 * 
 * En ella se incluyen una serie de clases y funciones para facilitar
 * el desarrollo de aplicaciones Web dinámicas.
 * 
 */

class DLUser extends DLConfig {
    /**
     * @var \PDO Obtiene un objeto PDO.
     */
    private $pdo;

    /**
     * @var string Almacenar el hash generado por password_hash
     */
    private $hashPassword;

    /**
     * @var \DLRequest Instancia de la clase DLRequest
     */
    private $request;

    public function __construct() {
        parent::__construct();
        $this->pdo = $this->getPDO();

        $this->request = new DLRequest;
    }

    /**
     * @param string $password Contraseña de usuario.
     */
    public function setHash(string $password): void {
        $this->hashPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password Verificar la contraseña de usuario.
     */
    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->hashPassword);
    }

    /**
     * @param array $fields Campos del formulario para introducir las credenciales
     * @param ?string $passwordField Campo de contraseña. El valor por defecto es
     * :password. Si desea utilizar otro nombre de campo puede optar por colocarle un
     * nombre.
     * 
     * Por ahora, en esta versión no se pueden cambiar los campos, por lo que deberían utilizar
     * los campos :username y :password. 
     * 
     * @return mixed;
     */
    public function createUserSession(): mixed {
        // $this->request->values[$passwordField] = $this->request->values[$passwordField];

        /**
         * @var object Array asociativo con las credenciales de usuario.
         */
        $values = (object) $this->request->getValues(null, [
            "username",
            "password"
        ]);


        $stmt = $this->pdo->prepare("SELECT user_password as password FROM dl_user WHERE user_username = :username LIMIT 1");
        $stmt->execute([":username" => $values->username]);
        $user = (object) $stmt->fetch(PDO::FETCH_ASSOC);
        
        $password = isset($user->password)
            ? $user->password
            : "";

        $this->hashPassword = $password;
        $is_valid_password = $this->verifyPassword($values->password);

        if ($is_valid_password) {
            echo "El usuario tiene una contraseña válida " . json_encode($_SERVER['PHP_AUTH_USER']);
            setcookie($name = "dfad");
        }
        return "";
    }

    public function update(): bool {
        /**
         * @var array Campos del formulario.
         */
        $update = [
            "token" => true,
            "username" => true,
            "password" => true,
            "actions" => true
        ];

        if (!$this->request->post($update)) return false;


        /**
         * @var array Credenciales de usuarios
         */
        $values = $this->request->getValues(null, [
            "username", "password"
        ]);

        /** @var object */
        $credentials = (object) $values;

        if (array_key_exists("password", $values)) {
            $this->setHash($credentials->password);
            $credentials->password = $this->hashPassword;
        }

        $stmt = $this->pdo->prepare("UPDATE dl_user SET user_password = :password where user_username = :username");
        return $stmt->execute([
            ":username" => $credentials->username,
            ":password" => $credentials->password
        ]);
    }
}