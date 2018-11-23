<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 22/11/2018
 * Time: 17:19
 */

require_once 'config.php';
require_once 'Connection.php';
require_once 'Pmweb_Orders_Stats.php';

class Controller{


    /**
     * Envia os valores para Pmweb_Orders_Stats.php, armazena os resultados em um array e por fim gera um JSON.
     * @param $startDate
     * @param $endDate
     */
    public function setValues($startDate, $endDate){

        $pmwebOrderStats = new Pmweb_Orders_Stats();
        $pmwebOrderStats->setStartDate($startDate);
        $pmwebOrderStats->setEndDate($endDate);

        $data = array(
            'orders' => array(
                'count'             => $pmwebOrderStats->getOrdersCount(),
                'revenue'           => $pmwebOrderStats->getOrdersRevenue(),
                'quantity'          => $pmwebOrderStats->getOrdersQuantity(),
                'averageRetailPrice'=> $pmwebOrderStats->getOrdersRetailPrice(),
                'averageOrderValue' => $pmwebOrderStats->getOrdersAverageOrderValue()
            )

        );

        $json = json_encode($data);
        print_r($json);

    }


}