# Sistema de pedidos en línea

## Instalación del proyecto.

Primero debe clonarse el proyecto:

```bash
git clone https://github.com/dlunamontilla/nomina.git
```

Luego de eso, ingrese al directorio `nomina/`

```bash
cd nomina
```

Y desde allí solo tiene que instalar las dependencias con el siguiente comando:

```bash
npm install
npm install --save rollup-plugin-scss@3 sass scss
```

Luego de eso, corra el proyecto con la siguiente línea:

```bash
npm run dev
```

Sin embargo, no corra el proyecto directamente con **NodeJS**, porque incluye _backend_. En su lugar, cree un acceso directo con el nombre `nomina` de la carpeta `public/` desde el servidor donde lo va a correr y luego, desde la barra de direcciones de su navegador escriba:

```none
http://localhost/nomina/
```

Lo que verá allí son formularios que no son parte del proyecto. Se utilizarán básicamente para probar el código.




## Descripción de las entidades (tablas) de la base de datos

<br>

En este documento se describe la función de cada entidad de la base de datos `nomina` en la siguiente tabla descriptiva:

| Nombre de la tabla (entidad) | ¿Qué se almacena en ella?                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **`dl_VAT`**                 | En ella se mantiene un registro actualizado del `IVA`. Esta tabla es una dependencia de la tabla `dl_product_details`.                                                                                                                                                                                                                                                                                                                                                                                                                     |
| **`dl_client`**              | En ella se mantiene un registro actualizado de clientes.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| **`dl_document`**            | En ella de definirá el tipo de documento que se va a registrar en el sistema.                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| **`dl_employee`**            | En ella se mantendrá un registro de empleados.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| **`dl_employee_status`**     | Almacena los estados de los empleados, por ejemplo: Activo, Egresado. Esta opción puede actualizarse en el futuro o para cualquier interesado en obtener el sistema.                                                                                                                                                                                                                                                                                                                                                                       |
| **`dl_income_tax`**          | En ella se registrarán anualmente el impuesto sobre la renta. El sistema no permitirá que se registren impuestos más de una vez en un mismo año en esta tabla, pero si permitirá actualizarlo en caso de registrar información con errores.                                                                                                                                                                                                                                                                                                |
| **`dl_model`**               | En ella se almacenan los modelos del producto que se encuentra asociada a una marca mediante el `id` de la tabla `dl_trademark`.                                                                                                                                                                                                                                                                                                                                                                                                           |
| **`dl_order`**               | Se deja un registro de pedidos y ventas de productos. Es decir, inicialmente, el cliente realiza en un pedido que el **vendedor registra** en el sistema. El sistema lo registrará en la tabla `dl_order` y después de confirmar la entrega del producto se actualiza el estado a **Vendido**. Esa tarea lo hace el mensajero cuando entrega la mercancía.                                                                                                                                                                                 |
| **`dl_order_status`**        | Contiene un registro de los estados disponibles de los pedidos.                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| **`dl_position`**            | En ella se registran los cargos disponibles en la empresa.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| **`dl_product`**             | En ella se almacenan los nombres de los productos. No tiene una marca o modelo asociado a ella porque es donde se crea el concepto del producto.                                                                                                                                                                                                                                                                                                                                                                                           |
| **`dl_product_category`**    | Como su nombre lo indica, se almacenarán las categorías asociadas al producto. Por lo tanto, es una dependencia del producto.                                                                                                                                                                                                                                                                                                                                                                                                              |
| **`dl_product_details`**     | Como su nombre lo indica. Es una tabla creada como resultado de una relación existente a partir de las tablas `dl_product` y `dl_model`. En esta tabla se almacenan las compras que realice la empresa o persona a su proveedor. Además, quedarán registradas en ella los siguientes datos: `id` de la tabla `dl_product` y del usuario, marca y modelo, proveedor (quien le suministró el producto), costo y fecha de registro de la compra, además del estatus de la compra; que puede ser: **Adquirido**, **Devuelto** o **Eliminado**. |
| **`dl_product_gallery`**     | En ella se almacenan las fotos del producto que se han creado. La foto tiene asociada el `id` del producto.                                                                                                                                                                                                                                                                                                                                                                                                                                |
| **`dl_product_status`**      | En ella se almacenarán el estado de la compra del producto al proveedor, además de ser una dependencia de la tabla `dl_product_details` para el almacenamiento del estado de la compra.                                                                                                                                                                                                                                                                                                                                                    |
| **`dl_provider`**            | En esta tabla se almacenarán los proveedores de los productos.                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| **`dl_trademark`**           | Esta tabla permite almacenar marcas o fabricantes de productos.                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| **`dl_user`**                | En ella se mantiene un registro de usuarios del sistema. Sin ella no se pueden realizar transacciones dentro del sistema.                                                                                                                                                                                                                                                                                                                                                                                                                  |
| **`dl_user_role`**           | Se mantiene un registro de roles de usuario.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |
| **`dl_user_status`**         | Se lleva un registro de estado de usuarios.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
