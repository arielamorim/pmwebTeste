<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 22/11/2018
 * Time: 20:28
 */
require_once 'Connection.php';

class Pmweb_Orders_Stats {

    private $_startDate;
    private $_endDate;
    private $_result;
    private $_revenue;
    private $_qtdProd;
    private $_qtdOrders;
    private $_retPrice;
    private $_avTicket;

    /**
     * Retorna a conexao com o banco.
     * @return PDO
     */
    public function Conn(){
        $dao = new Connection();
        return $dao->retPdo();
    }

    /**
     * Define o período inicial da consulta.
     * @param String $date Data de início, formato `Y-m-d` (ex, 2017-08-24).
     *
     * @return void
     */
    public function setStartDate($date) {
        $this->_startDate = $date;
    }

    /**
     * Retorna período inicial da consulta.
     * @return mixed
     */
        public function getStartDate(){
        return $this->_startDate;
    }
    /**
     * Define o período final da consulta.
     *
     * @param String $date Data final da consulta, formato `Y-m-d` (ex, 2017-08-24).
     *
     * @return void
     */
    public function setEndDate($date) {
        $this->_endDate = $date;
    }

    /**
     * Retorna o período final da consulta.
     * @return mixed
     */
    public function getEndDate(){
        return $this->_endDate;
    }

    /**
     * Retorna o total de pedidos efetuados no período.
     *
     * @return integer Total de pedidos.
     */
    public function getOrdersCount() {
        try{
            $pdo = $this->Conn();

            $query = "select count(*) from order_items where order_date between '" .
                        $this->getStartDate() . "' and '" . $this->getEndDate() ."'";

            $select = $pdo->query($query);

            $this->_qtdOrders = $select->fetchAll(PDO::FETCH_ASSOC);

            return $this->_qtdOrders[0]['count(*)'];

        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

    /**
     * Retorna a receita total de pedidos efetuados no período.
     *
     * @return float Receita total no período.
     */
    public function getOrdersRevenue() {
        try{
            $pdo = $this->Conn();

            $query = "select quantity, price from order_items where order_date between '" .
                        $this->getStartDate() . "' and '" . $this->getEndDate() ."'";

            $select = $pdo->query($query);

            $this->_result = $select->fetchAll(PDO::FETCH_OBJ);

            $this->calcRevenue();

            return $this->_revenue;

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Retorna o total de produtos vendidos no período (soma de quantidades).
     *
     * @return integer Total de produtos vendidos.
     */
    public function getOrdersQuantity() {
        try {
            $pdo = $this->Conn();

            $query = "select quantity from order_items where order_date between '" .
                $this->getStartDate() . "' and '" . $this->getEndDate() . "'";

            $select = $pdo->query($query);

            $this->_result = $select->fetchAll(PDO::FETCH_OBJ);

            $this->calcQtd();

            return $this->_qtdProd;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Retorna o preço médio de vendas (receita / quantidade de produtos).
     *
     * @return float Preço médio de venda.
     */
    public function getOrdersRetailPrice() {
        try{

            $this->_retPrice = $this->_revenue / $this->_qtdProd;

            return $this->_retPrice;

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Retorna o ticket médio de venda (receita / total de pedidos).
     *
     * @return float Ticket médio.
     */
    public function getOrdersAverageOrderValue() {
        try{

            $this->_avTicket = $this->_revenue / $this->_qtdOrders;

            return $this->_avTicket;

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Calcula a receita do período conforme dados retornados pela query.
     */
    public function calcRevenue(){
        Try{

            foreach ($this->_result as $item=>$key){

                $value = intval($key->quantity) * floatval($key->price);

                $this->_revenue = $this->_revenue + $value;

            }

        }catch (Exception $e){
            echo $e->getMessage();
        }


    }

    /**
     * Calcula a qtd dos produtos
     */
    public function calcQtd(){
        try{

            $this->_qtdOrders = count($this->_result);

            foreach ($this->_result as $item=>$key){
                $this->_qtdProd = $this->_qtdProd + $key->quantity;
            }

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
}