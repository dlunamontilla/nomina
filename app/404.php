<?php
/**
 * @author David E Luna M <dlunamontilla@gmail.com>
 * @see Las rutas no registradas las marcará como no encontradas.
 */
class DL404 {
    public function __construnct() {}

    /**
     * 
     */
    public function checked() {
        print_r($_SERVER);
        print_r($_REQUEST);
    }
}

$dl404 = new DL404;