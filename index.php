<?php
/************************************************************************
 * The script of website with demotivators DEMOTY2.6
 * Copyright (c) 2018 - 2021 by IT Works Better https://itworksbetter.net
 * Project by Kamil Wyremski https://wyremski.pl
 *
 * All right reserved
 *
 * *********************************************************************
 * THIS SOFTWARE IS LICENSED - YOU CAN MODIFY THESE FILES BUT YOU CAN NOT REMOVE OF ORIGINAL COMMENTS!
 * ACCORDING TO THE LICENSE YOU CAN USE THE SCRIPT ON ONE DOMAIN.
 * *********************************************************************/

session_start();

header('Content-Type: text/html; charset=utf-8');
header('X-Frame-Options: SAMEORIGIN');

require_once('config/config.php');

$loader = new \Twig\Loader\FilesystemLoader('views/'.$settings['template']);
$twig = new \Twig\Environment($loader, [
    'cache' => 'tmp',
]);

$twig->addFilter(new \Twig\TwigFilter('lang', 'lang'));
$twig->addFunction(new \Twig\TwigFunction('path', 'path'));
$twig->addFunction(new \Twig\TwigFunction('generateToken', 'generateToken'));

$controller = 'index';
if(isset($_GET['controller']) and isSlug($_GET['controller'])){
	$controller = array_search($_GET['controller'], $links);
	if($controller==''){
		if($_GET['controller']=='picture'){
			$controller = 'picture';
		}else{
			$controller = '404';
		}
	}elseif($controller=='waiting_room' or $controller=='top' or $controller=='search' or $controller=='category' or $controller=='tag' or $controller=='profile_pictures' or $controller=='random'){
		$module_subpage = $controller;
		$controller = 'index';
	}
}

$render_variables = [];
$user = new user();

require_once('controller/'.$controller.'.php');

checkInfo();

$render_variables['categories'] = getCategories();

if(!empty($_GET['q'])){
	$render_variables['search'] = $_GET['q'];
}

$settings['logo_facebook'] = getFullUrl($settings['logo_facebook']);

echo $twig->render($controller.'.html', array_merge($render_variables, array('settings' => $settings, 'user' => $user->user_data, 'controller'=>$controller)));
