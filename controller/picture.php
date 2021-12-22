<?php
/************************************************************************
 * The script of website with demotivators DEMOTY2
 * Copyright (c) 2018 - 2022 by IT Works Better https://itworksbetter.net
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

if(isset($_GET['id']) and $_GET['id']>0 and !empty($_GET['slug'])){

	if(isset($_POST['action'])){
		if($_POST['action']=='remove_picture' and isset($_POST['id']) and $_POST['id']>0 and checkToken('remove_picture')){
			if(picture::checkPermissions($_POST['id'])){
				picture::remove($_POST['id']);
				$_SESSION['flash'] = 'picture_removed';
				header('Location: '.$settings['base_url']);
        die('redirect');
			}
		}elseif($_POST['action']=='set_main_page' and isset($_POST['id']) and $_POST['id']>=0 and $user->moderator and checkToken('set_main_page')){
			if(picture::checkPermissions($_POST['id'])){
				picture::setMainPage($_POST['id']);
				$_SESSION['flash'] = 'picture_main_page';
			}
		}
	}

	$picture = picture::getPicture($_GET['id']);

	if($picture){
		if($picture['slug']!=$_GET['slug']){
			header('Location: '.path('picture',$picture['id'],$picture['slug']));
      die('redirect');
		}

		$picture['view_all']++;
		if(!$picture['view_unique']){
			$picture['view_unique'] = 1;
		}

		$render_variables['picture'] = $picture;

		$settings['title'] = $picture['title'].' - '.$settings['title'];
		$settings['description'] = $picture['description'];
		$settings['logo_facebook'] = $settings['base_url'].'/upload/pictures/'.$picture['filename'];

	}else{
		include('controller/404.php');
	}
}else{
	include('controller/404.php');
}
