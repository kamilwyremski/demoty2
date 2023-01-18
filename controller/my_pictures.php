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

if(!isset($settings['base_url'])){
	die('Access denied!');
}

if($user->logged_in){

	if(isset($_POST['action'])){
		if($_POST['action']=='remove_picture' and isset($_POST['id']) and $_POST['id']>0 and checkToken('remove_picture')){
			if(picture::checkPermissions($_POST['id'])){
				picture::remove($_POST['id']);
				$_SESSION['flash'] = 'picture_removed';
			}
		}
	}

	$render_variables['pictures'] = picture::getPictures($settings['limit_page_profile'],'my_pictures');

	$render_variables['module_subpage'] = $controller;

	$settings['seo_title'] = lang('My pictures').' - '.$settings['title'];
	$settings['seo_description'] = lang('My pictures').' - '.$settings['description'];

}else{
	header("Location: ".path('login')."?redirect=".path('my_files'));
	die('redirect');
}
