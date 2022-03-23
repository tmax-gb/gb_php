<?php

include_once 'm/M_Admin.php';

class C_Admin extends C_Base {
    protected $model;

    function __construct() {
        $this->model = new M_Admin();
    }

    function action_goodCart() {
		$good  =$this->model->getGood($this->getProductId());
		echo json_encode($good);
	}

    function action_addGood() {
		$id = $this->model->addGood($this->getGoodValues());
		echo json_encode($this->model->getGood($id));
	}

	function action_returnGood() {
		$this->model->returnGood($this->getProductId());
	}

	function action_changeGood() {
		$this->model->changeGood($this->getProductId(), $this->getGoodValues());
		echo json_encode($this->model->getGood($this->getProductId()));
	}

	function action_removeGood() {
		$this->model->removeGood($this->getProductId());
	}

	function action_deleteGood() {
		$this->model->deleteGood($this->getProductId());
	}

	function action_changeStatus() {
		$this->model->changeStatus($this->getIdOrder(), $this->getOrderStatus());
		echo json_encode($this->model->getStatus($this->getIdOrder()));
		
	}
}