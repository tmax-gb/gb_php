<?php

include_once 'm/M_Page.php';

class C_Page extends C_Base {
	protected $model;

	function __construct() {
		$this->model = new M_Page();
	}

	public function action_index() {
		$this->title .= ' | Каталог';
		$goods = $this->model->getGoods($this->getCountGoods());
		$this->render('v_index.html', ['goods' => $goods]);
	
	}

	function action_loadMore() {
		$goods = $this->model->getMoreGoods($this->getCountGoods());
		echo json_encode($goods);
	}

	public function action_reg() {
		$this->title .= ' | Регистрация';
		$this->render('v_reg.html', []);
		$_SESSION['status'] = false;
	}

	public function action_auth() {
		$this->title .= ' | Авторизация';
		$this->render('v_auth.html', []);
		$_SESSION['status'] = false;	
	}

	public function action_prof() {
		$this->title .= ' | Профиль';
		$userOrders = $this->model->getOrders($this->getIdUser());
		if($userOrders) {
			$_SESSION['isOrder'] = true;
		} else {
			$_SESSION['isOrder'] = false;
		}					
		
		$this->render('v_profile.html', ['userOrders' => $userOrders, 'isOrder' => $_SESSION['isOrder']]);
		$_SESSION['status'] = false;
	}

	public function action_basket() {
		$this->title .= ' | Корзина';
		$userBasket = $this->model->getBasket($this->getIdUser());
		(count($userBasket) == 0) ? $_SESSION['status'] = true : $_SESSION['status'] = false;
		$this->render('v_basket.html', ['userBasket' => $userBasket, 'amountOrder' => $this->getAmountOrder($this->getIdUser())]);						
		
	}

	function action_order() {
		$this->title .= ' | Заказ подтвержден';
		$this->render('v_order.html', []);
	}

	function action_remGoods() {
		$this->title .= ' | Архив товаров';
		$goods = $this->model->getArchive();
		(count($goods) == 0) ? $_SESSION['status'] = true : $_SESSION['status'] = false;
		$this->render('v_archive.html', ['goods' => $goods]);
	}

	function action_useOrd() {
		$this->title .= ' | Заказы пользователей';
		$orders = $this->model->getUseOrders();
		(count($orders) == 0) ? $_SESSION['status'] = true : $_SESSION['status'] = false;
		$this->render('v_user_orders.html', ['orders' => $orders]);
	}

	
}
