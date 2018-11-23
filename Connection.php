<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 22/11/2018
 * Time: 19:36
 */

class Connection{

    /**
     * Retorna conexao com o banco de dados.
     * @return PDO
     */
    function retPdo(){
        try {
            return new PDO("mysql:host=127.0.0.1;dbname=pmweb", "pmweb", "pmweb");
        }catch (Exception $e){
            print_r($e);
        }
    }

}