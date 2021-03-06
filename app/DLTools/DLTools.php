<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

session_start();

/**
 * @package DLTools
 * @version 2.0.0
 * @author David E Luna <davidlunamontilla@gmail.com>
 * @copyright (c) 2022 - David E Luna M
 * @license MIT
 * 
 * En ella se incluyen una serie de clases y funciones para facilitar
 * el desarrollo de aplicaciones Web dinámicas.
 * 
 */

include __DIR__ . "/DLConfig.php";
include __DIR__ . "/DLCookies.php";
include __DIR__ . "/DLProtocol.php";
include __DIR__ . "/DLRequest.php";
include __DIR__ . "/DLSessions.php";
include __DIR__ . "/DLUser.php";