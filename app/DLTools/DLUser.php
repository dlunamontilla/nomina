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
     * Por ahora, en esta versión no se pueden cambiar los campos, por lo que deberían utilizar
     * los campos :username y :password. 
     * 
     * @param ?string $token El nombre del token donde se almacenó el hash
     * que permite comprobar que efectivamente el acceso es legítimo. El valor
     * por defecto es «token», pero puede tener otro valor.
     * 
     * @return bool;
     */
    public function createUserSession(?string $token = "token"): bool {
        /** @var \DLSessions */
        $hash = new DLSessions;

        /** @var bool ¿Es un token válido para continuar? */
        $is_valid_token = $hash->isValidToken($token);

        if (!$is_valid_token) return $is_valid_token;

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

        /**
         * @var bool Almacena información sobre si se creo o no una cookie.
         */
        $A0110 = FALSE;

        /** @var bool Almacena información sobre si se creó o no una cookie*/
        $B0110 = FALSE;

        
        /**
         * @var \DLCookies
         */
        $cookies = new DLCookies;

        if ($this->request->domainTest(["lunamontilla.net","localhost"])) {
            $cookies->setConfig([
                "secure" => false
            ]);
        }

        if ($is_valid_password) {
            $session = new DLSessions;

            $cookies->setConfig(["httponly" => true]);


            $session->set("auth");
            $auth = $session->get("auth");
            $this->setHash($auth);

            $A0110 = $cookies->set("A0110", $this->hashPassword);
            $B0110 = $cookies->set("B0110", $this->hashPassword);
        }
        
        /** 
         * Si la comprobación de la contraseña es válida se procederá
         * a actualizar el token del usuario.
         */
        if ($A0110 && $B0110) {
            $stmt = $this->pdo->prepare("UPDATE dl_user SET hash = :token WHERE user_username = :username");
            
            $this->setHash($A0110 . $B0110);

            
            echo "Comprobar datos: " . $this->hashPassword . "\n";
        }

        return $A0110 && $B0110;
    }

    public function updatePassword(): bool {
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

        /** 
         * La contraseña no se actualizará si de forma explícita
         * no se indica que se va a realizar dicha acción.
         */
        if ($credentials->actions !== "update" ) return false;

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