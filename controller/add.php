<?php
/************************************************************************
 * The script of website with demotivators DEMOTY2
 * Copyright (c) 2018 - 2021 by IT Works Better https://itworksbetter.net
 * Project by Kamil Wyremski https://wyremski.pl
 *
 * All right reserved
 *
 * *********************************************************************
 * THIS SOFTWARE IS LICENSED - YOU CAN MODIFY THESE FILES BUT YOU CAN NOT REMOVE OF ORIGINAL COMMENTS!
 * ACCORDING TO THE LICENSE YOU CAN USE THE SCRIPT ON ONE DOMAIN.
 * *********************************************************************/

if(!isset($settings['base_url'])){
	die('Access denied!');
}

if(!$settings['add_picture_not_logged'] and !$user->logged_in){
	$_SESSION['flash'] = 'login_to_add';
	header('Location: '.path('login').'?redirect='.path('add'));
	die('redirect');
}

if(isset($_POST['action'])){
 	if($_POST['action']=='add' and !empty($_POST['title']) and (!empty($_FILES['picture']['name']) or $_POST['type']=='mem_pattern') and checkToken('add_picture')){
		$result = picture::add($_POST);
		if(!empty($result['error'])){
			$render_variables['alert_danger'][] = $result['error'];
			$render_variables['picture'] = $_POST;
		}elseif($result['status'] and !empty($result['path'])){
			$_SESSION['flash'] = 'picture_added';
			header('Location: '.$result['path']);
			die('redirect');
		}
	}
}

if(!$user->getId()){
	$render_variables['alert_danger'][] = lang('You are not logged in - you will not be able to edit the picture');
}

$render_variables['title_sizes'] = picture::$title_sizes;
$render_variables['title_border_sizes'] = picture::$title_border_sizes;
$render_variables['description_sizes'] = picture::$description_sizes;
$render_variables['description_border_sizes'] = picture::$description_border_sizes;

if(empty($render_variables['picture'])){
	$picture = [];
	$picture['filename'] = picture::newPictureFilename();
	$picture['title_size'] = picture::$title_default_size;
	$picture['title_color'] = picture::$title_default_color;
	$picture['title_border_size'] = picture::$title_default_border_size;
	$picture['title_border_color'] = picture::$title_default_border_color;
	$picture['description_size'] = picture::$description_default_size;
	$picture['description_color'] = picture::$description_default_color;
	$picture['description_border_size'] = picture::$description_default_border_size;
	$picture['description_border_color'] = picture::$description_default_border_color;
	$picture['background_color'] = picture::$background_color;
	$picture['border_color'] = picture::$border_color;

	$render_variables['picture'] = $picture;
}

$render_variables['mem_patterns'] = getMemPatterns();

$settings['title'] = lang('Add new picture').' - '.$settings['title'];
$settings['description'] = lang('Add new picture').' - '.$settings['description'];
