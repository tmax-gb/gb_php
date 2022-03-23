<?php

include_once 'm/M_Basket.php';

abstract class C_Base extends C_Controller
{
	protected $title;

	protected $idUser;
	protected $userName;
	protected $userPhone;
	protected $userLogin;
	protected $password;

	protected $productId;
	protected $countGoods;
	protected $remove;
	
	protected $goodValues;
	protected $idOrder;
	protected $orderStatus;
	
	
	protected function before() {
		$this->title = 'Shop';
		$this->content = '';

		$this->userName = $_SESSION['userName'];
		
		$this->countGoods = 16;
        if ($this->isPost()) {
			$this->userName = $_POST['userName'];
			$this->userPhone = $_POST['userPhone'];
    		$this->userLogin = $_POST['login'];
			$this->password = $_POST['password'];
			
            $this->productId = $_POST['productId'];
			$this->countGoods = $_POST['countGoods'];
			$this->remove = $_POST['prodRemove'];

			$this->goodValues = $_POST['goodVal'];
			$this->idOrder = $_POST['orderId'];
			$this->orderStatus = $_POST['orderStatus'];

		}
		
		if (!isset($_COOKIE['idUser'])) {
			setcookie('idUser', DataBase::insert('INSERT INTO user (user_name, user_role) VALUES (:guest, :userRole)', ['guest' => 'Guest', 'userRole'=> 0]), time() + 3600 * 24 * 7);
			$this->idUser = $_COOKIE['idUser'];
		} elseif (isset($_SESSION['idUser'])) {
			setcookie('idUser', $_SESSION['idUser'], time() + 3600 * 24 * 7);
			$this->idUser = $_COOKIE['idUser'];
		} else {
			$this->idUser = $_COOKIE['idUser'];
		}
	
	}

	function getTitle() {
		return $this->title;
	}
	function getIdUser() {
        return $this->idUser;
	}
	function getUserName() {
        return $this->userName;
	}
	function getUserPhone() {
        return $this->userPhone;
	}
	function getUserLogin() {
        return $this->userLogin;
	}
	function getPassword() {
        return $this->password;
	}
	
    function getProductId() {
        return $this->productId;
    }
	function getCountGoods() {
        return $this->countGoods;
	}
	function getRemove() {
        return $this->remove;
    }
	function getCountProd($idUser) {
		$basket = new M_Basket;
		return $basket->getCount($idUser);
	}
	function getAmountOrder($idUser) {
		$amountOrder = new M_Basket;
		return $amountOrder->amountOrder($idUser);
	}

	function getGoodValues() {
		return $this->goodValues;
	}

	function getIdOrder() {
		return $this->idOrder;
	}
	function getOrderStatus() {
		return $this->orderStatus;
	}
	
	protected function render($template, $varsForContent){
		$var = $varsForContent;
		$var['user'] = $_SESSION['isAuth'];
		$var['role'] = $_SESSION['isAdmin'];
		$var['status'] = $_SESSION['status'];
		$var['title'] = $this->getTitle();
		$var['userName'] = $this->getUserName();
		$var['countProd'] = $this->getCountProd($this->getIdUser());
		$loader = new \Twig\Loader\FilesystemLoader('./view/');
		$twig = new \Twig\Environment($loader);
		echo $twig->render($template, $var);	
	}
}
