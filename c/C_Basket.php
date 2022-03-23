<?php

// include_once 'm/M_Basket.php';

class C_Basket extends C_Base {

    protected $model;
    protected $product;

    function __construct() {
        $this->model = new M_Basket();
        
    }
    
    protected function makeResponse() {
        $this->product = $this->model->getProduct($this->getIdUser(), $this->getProductId());
        return $response = [
            'quantity' => $this->product['quantity'],
            'totalPrice' => $this->product['total_price'], 
            'countProd' => $this->getCountProd($this->getIdUser()), 
            'amountOrder' => $this->getAmountOrder($this->getIdUser())
        ];
    }

    function action_add() {
        $this->model->addProduct($this->getIdUser(), $this->getProductId());
        echo json_encode($this->makeResponse());
    }

    function action_del() {
        $this->model->removeProduct($this->getIdUser(), $this->getProductId(), $this->getRemove());        
        echo json_encode($this->makeResponse());
        
    }

    function action_sendOrder() {
        $this->model->sendOrder($this->getIdUser(), $this->getUserName(), $this->getUserPhone());
        header('location: index.php?act=order');
    }
    
}