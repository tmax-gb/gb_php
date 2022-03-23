<?php
//
// Базовый класс контроллера.
//
abstract class C_Controller {
	
	// Функция отрабатывающая до основного метода
	protected abstract function before();
	
	public function Request($action){
		session_start();
		$this->before();
		$this->$action();   //$this->action_index
		session_write_close();
	}
	
	protected function IsGet() {
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	protected function IsPost() {
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	public function __call($name, $params){
		$this->title .= ' | Страница не найдена';
        $loader = new \Twig\Loader\FilesystemLoader('./view/');
        $twig = new \Twig\Environment($loader);
		echo $twig->render('404.html', ['title' => $this->title]);
	}
}
