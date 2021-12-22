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

$controller = 'add';
include_once('controller/'.$controller.'.php');

if(isset($_GET['id']) and $_GET['id']>0 and picture::checkPermissions($_GET['id'])){

	if(isset($_POST['action']) and $_POST['action']=='edit' and !empty($_POST['title']) and checkToken('edit_picture')){

		$generate_picture = picture::generatePicture($_POST);

		chmod(_FOLDER_PICTURES_, 0777);
		copy(_FOLDER_PICTURES_TMP_.$_POST['filename'], _FOLDER_PICTURES_.$_POST['filename']);
		chmod(_FOLDER_PICTURES_, 0755);

    if(!$generate_picture['status']){
			$render_variables['alert_danger'][] = lang('Error while added picture');
			$render_variables['picture'] = $_POST;
    }else{
			$result = picture::edit($_POST,$_GET['id']);
			if(!empty($result['error'])){
				$render_variables['alert_danger'][] = $result['error'];
				$render_variables['picture'] = $_POST;
			}elseif($result['status'] and !empty($result['path'])){
				$_SESSION['flash'] = 'picture_saved';
				header('Location: '.$result['path']);
				die('redirect');
			}
		}
	}

	$picture = picture::getPicture($_GET['id'], 'edit');

	if(!empty($picture['tags'])){
		$picture['tags'] = implode(', ', array_map(function ($entry) {
			return $entry['name'];
		}, $picture['tags']));
	}

	$render_variables['picture'] = $picture;
	$render_variables['edit_picture'] = true;

	$settings['title'] = lang('Edit picture').' - '.$settings['title'];
	$settings['description'] = lang('Edit picture').' - '.$settings['description'];
}else{
	header("Location: ".path('add'));
	die('redirect');
}
