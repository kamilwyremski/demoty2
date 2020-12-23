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

session_start();

require_once('../../config/config.php');

$admin = new admin();

if(!_ADMIN_TEST_MODE_ and $admin->is_logged() and isset($_POST['data'])){
	$post = $_POST['data'];
	if($post['action']=='activate_user' and isset($post['id']) and $post['id']>0){
		user::activate($post['id']);
	}elseif($post['action']=='set_moderator' and isset($post['id']) and $post['id']>0){
		user::setModerator($post['id']);
	}elseif($post['action']=='unset_moderator' and isset($post['id']) and $post['id']>0){
		user::unSetModerator($post['id']);
	}elseif($post['action']=='position_categories' and isset($post['id']) and isset($post['position']) and isset($post['plusminus'])){
		setPosition('category',$post['id'],$post['position'],$post['plusminus']);
	}elseif($post['action']=='arrange_categories_alphabetically'){
		arrangeAlphabetically('category');
	}elseif($post['action']=='position_mem_pattern' and isset($post['id']) and isset($post['position']) and isset($post['plusminus'])){
		setPosition('mem_pattern',$post['id'],$post['position'],$post['plusminus']);
	}
}else{
	die('Access denied!');
}
