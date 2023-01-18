<?php
/************************************************************************
 * The script of website with demotivators DEMOTY2
 * Copyright (c) 2018 - 2023 by IT Works Better https://itworksbetter.net
 * Project by Kamil Wyremski https://wyremski.pl
 *
 * All right reserved
 *
 * *********************************************************************
 * THIS SOFTWARE IS LICENSED - YOU CAN MODIFY THESE FILES BUT YOU CAN NOT REMOVE OF ORIGINAL COMMENTS!
 * ACCORDING TO THE LICENSE YOU CAN USE THE SCRIPT ON ONE DOMAIN.
 * *********************************************************************/

header('Content-Type: text/html; charset=utf-8');
header('X-XSS-Protection: 0');
header('X-Frame-Options: SAMEORIGIN');

session_start();

require_once('../config/config.php');

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
    'cache' => 'tmp',
]);
$twig->addFilter(new \Twig\TwigFilter('lang', 'lang'));
$twig->addFunction(new \Twig\TwigFunction('path', 'path'));

$admin = new admin();

$title = $title_default = 'Admin Panel created by Kamil Wyremski';

$controller = 'index';
if($admin->is_logged()){
	if(isset($_GET['controller']) and isSlug($_GET['controller'])){
		if(file_exists('controller/'.$_GET['controller'].'.php')){
			$controller = $_GET['controller'];
			$title = ucfirst($controller).' - '.$title_default;
		}else{
			$controller = '404';
		}
	}
}else{
	$controller = 'login';
}

$render_variables = [];

require_once('controller/'.$controller.'.php');

echo $twig->render($controller.'.html', array_merge($render_variables, ['title' => $title, 'settings' => $settings, 'admin' => $admin->user_data, '_ADMIN_TEST_MODE_' => _ADMIN_TEST_MODE_, 'get' => $_GET, 'controller' => $controller, 'folder_admin' => basename(dirname($_SERVER['REQUEST_URI']))]));
