# DLRequest

Guía de cómo utilizar la clase `DLRequest`.

La clase `DLRequest` es capaz de detectar de forma automática el método de envío del formulario.

Propiedades y métodos públicos de la clase:

```php
class DLRequest {
    /* Métodos */
    __construct()
    get(array $requests, bool $distribute = false)
    post(array $requests)
    getMethod(): string
}
```

Puede escribir la siguiente sintaxis para instanciarlo:

```php
$request = new DLRequest;
```

## Constructor

Al momento de instanciar la clase se detecta el método de envío del formulario.

```php
DLRequest::__construct();
```

## Método **`DLRequest::getMethod()`**

El método **`getMethod`** devuelte el método de envío de la petición hecha por el cliente.

## Método `DLRequest::get`

**Sintaxis:**

```php
DLRequest::get(array $requests, bool $distribute = false): bool
```

Este método se encarga de validar mediante un _array asociativo_ que los parámetros de la petición sean válidos.

### Parámetros

-   **`$requests`:** Es un _array asociativo_ que permite validar los parámetros de una petición. Es decir, si las claves del _array_ [asociativo] coinciden con los parámetros de la petición se considera válidos.

    Sin embargo, este comportamiento puede cambiar dependiendo de varios factores, por ejemplo:

    ```php
    $requests = [
        "clave" => true
    ]
    ```

    Donde **`clave`** es requerido porque se le indicó que es **`true`**. Esto significa que el parámetro de la petición debe coincidir con la clave del array asociativo, además de tener contenido de forma obligatoria para considerarse válido.

    El otro factor se explica en el siguiente inciso.

-   **`$distribute`:** Como su nombre lo indica. Se utiliza para distribuir una acción en diferentes módulos de forma no simultánea.

    -   **`false`:** Cuando tiene este valor (por defecto) se hace obligatorio que las claves del array asociativo **`$requests`** coincidan con los parámetros de la petición.

    -   **`true`:** Si tiene este valor, se le está indicando a la función que valide que está en un módulo a la vez. Cada parámetro se considera un módulo, siempre que uno de estos sean parte de la clave **`$requests`**.

### Ejemplo de uso

Ejemplo de uso de forma simple:

```php
$request = new DLRequest;

$requests = [
    "param1" => true,
    "param2" => true,
      ...
    "paramN" => false
];

if ($request->get($requests)) {
    /**
     * Realiza una acción si todos los parámetros de
     * la petición coinciden con las claves del array
     * asociativo pasados como argumento del método
     * get.
     */
}
```

Dado que las claves **`param1`** y **`param2`** del array asociativo **`$requests`** tienen el valor establecido a **`true`** hace obligatorio que el parámetro de la petición **GET** tengan algún tipo de valor. Es decir, no pueden estar vacíos.

Para el caso de la clave **`paramN`** el valor del parámetro del método **GET** es opcional.

Ejemplo de uso con el parámetro **`$distribute`:**

```php
$request = new DLRequest;

$requests = [
    "param1" => false,
    "param2" => false
];

if ($request->get($requests, true)) {
    /**
     * Realiza una acción si uno de los módulos
     * coinciden con una clave del array asociativo
     * $request.
     */
}
```

En el caso anterior se pretende distribuir una acción en diferentes módulos de forma no simultánea. Es decir, no súperpuestos.

Cuando el argumento **`$distribute`** vale **`true`** se ignoran los valores de **`param1`** y **`param2`**.

## Método **`post`**

Su sintaxis es la siguiente:

```php
DLRequest::post(array $requests): bool
```

Este método funciona de la misma manera que **GET**, pero con la diferencia de que no permite peticiones sin parámetros y no usa el argumento **`$distribute`**.
