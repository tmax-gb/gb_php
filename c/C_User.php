<?php

include_once 'm/M_User.php';

class C_User extends C_Base {
	protected $model;
	protected $user;

	function __construct(){
		$this->model = new M_User;
		if ($this->isPost()) {
			$this->user = $this->model->getUser($_POST['login']);
		}
	}

	function action_auth() {
		if (!$this->getUserLogin() || !$this->getPassword()) {
			$_SESSION['status'] = 3;
			header ('location: index.php?act=auth');
		} else {
			if ($this->user) {
				if (password_verify ($this->getPassword(), $this->user['user_password'])) {
					($this->user['user_role'] == 1) ? $_SESSION['isAdmin'] = true : false;
					
					$_SESSION['isAuth'] = true;
					$_SESSION['idUser'] = $this->user['id_user'];
					$_SESSION['userName'] = $this->user['user_name'];
					$_SESSION['status'] = 0;
					header ('location: ../index.php');
				}else{
					$_SESSION['status'] = 1;
					header ('location: index.php?act=auth');
				}
	
			}else{
				$_SESSION['status'] = 2;
				header ('location: index.php?act=auth');
			}
		}
	}

	function action_ext() {
		if (isset($_POST['logout'])) {
			session_start ();
			session_destroy ();
		
			header ('location: ../index.php');
			die;
		}
	}

	function action_reg() {
			
    		if (!$this->getUserName() || !$this->getUserLogin() || !$this->getPassword() || !$this->getUserPhone()) {
				$_SESSION['status'] = 2;
				header ('location: index.php?act=reg');
				
    		} else {
        		if (!$this->user) {
					$passwordHash = password_hash ($this->getPassword(), PASSWORD_DEFAULT);
					$this->model->regUser($this->getUserName(), $this->getUserLogin(), $passwordHash, $this->getUserPhone(), $this->getIdUser());
					$_SESSION['status'] = 0;
            		header ('location: index.php?act=auth');

        		} else {
					$_SESSION['status'] = 1;
					header ('location: index.php?act=reg');
        		}
			}
			
		
	}

	function action_prof() {
		if ($this->getUserName() != "") {
			$this->model->changeName($this->getUserName(), $this->getIdUser());
			$_SESSION['userName'] = $this->getUserName();
			$_SESSION['status'] = 1;
		} else {
			$_SESSION['status'] = 2;
		}
		header ('location: index.php?act=prof');
	}	
	

}
