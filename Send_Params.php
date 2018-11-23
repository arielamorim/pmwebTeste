<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 23/11/2018
 * Time: 00:58
 */

/**
 * Envia os parametros para o controller.
 */

require_once 'Controller.php';

    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    $controller = new Controller();
    $controller->setValues($startDate, $endDate);
