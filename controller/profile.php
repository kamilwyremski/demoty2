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

if(!empty($_GET['slug'])){
	$profile = user::getProfile($_GET['slug']);

	if($profile){
		$settings['title'] = lang('Profile of').': '.$profile['username'].' - '.$settings['title'];
		$settings['description'] = lang('Profile of').': '.$profile['username'].' - '.$settings['description'];
		$render_variables['profile'] = $profile;

		if($settings['show_contact_form_profile'] and isset($_POST['action']) and $_POST['action']=='send_message' and !empty($_POST['name']) and (!empty($_POST['email']) or $user->getId()) and !empty($_POST['message']) and !empty($_POST['captcha']) and isset($_POST['rules'])){

			if($_POST['captcha']!=$_SESSION['captcha']){
				$render_variables['alert_danger'][] = lang('The message was not sent');
				$render_variables['alert_danger'][] = lang('Invalid captcha code.');
				$render_variables['input'] = ['name'=>$_POST['name'], 'email'=>$_POST['email'], 'message'=>$_POST['message']];
			}else{

				if($user->getId()){
					$email = $user->email;
				}else{
					$email = $_POST['email'];
				}
			
				if(sendMail('profile',$profile['email'],['name'=>$_POST['name'], 'email'=>$email, 'message'=>$_POST['message'], 'username'=>$profile['username'], 'user_id'=>$user->getId()])){
					$render_variables['alert_success'][] = lang('The message was correctly sent');
				}else{
					$render_variables['alert_danger'][] = lang('The message was not sent');
				}
			}
		}
	}else{
		include('controller/404.php');
	}
}else{
	include('controller/404.php');
}
