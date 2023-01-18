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

session_start();

require_once('../config/config.php');

$user = new user();

if(isset($_POST['action'])){
	if($_POST['action']=='set_voice' and isset($_POST['picture_id']) and $_POST['picture_id']>0 and !empty($_POST['voice']) and ($_POST['voice']=='-1' or $_POST['voice']=='1') and checkToken('set_voice') and (!$settings['voice_only_logged'] or $user->getId())){
		picture::setVoice($_POST['picture_id'], $_POST['voice']);
		echo json_encode(picture::getVoice($_POST['picture_id']));
	}elseif($_POST['action']=='generate_picture' and !empty($_POST['filename']) and !empty($_POST['title']) and ($settings['add_picture_not_logged'] or $user->getId())){
		echo json_encode(picture::generatePicture($_POST));
	}else{
		die('Access denied!');
	}
}else{
	die('Access denied!');
}
