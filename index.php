<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Загрузка классов шаблонизатора
require_once './vendor/autoload.php';

// подгрузка контроллеров
spl_autoload_register('c_autoload');
function c_autoload($classname){
	include_once("c/$classname.php");
}


//site.ru/index.php?act=auth&c=User

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

if (!empty($_GET['c'])){
	$controllerName = 'C_' . ucfirst($_GET['c']);
	if (class_exists($controllerName)){
		$controller = new $controllerName();
	} else{
		$controller = new C_Page();
	}
} else {
	$controller = new C_Page();
}

$controller->Request($action);

