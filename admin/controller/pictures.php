<?php
/************************************************************************
 * The script of website with demotivators DEMOTY2
 * Copyright (c) 2018 - 2020 by IT Works Better https://itworksbetter.net
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

if($admin->is_logged()){

	if(!_ADMIN_TEST_MODE_ and isset($_POST['action'])){
		if($_POST['action']=='remove_picture' and isset($_POST['id']) and $_POST['id']>0){
			if(isset($_POST['add_ip_black_list']) and !empty($_POST['ip'])){
				addIpToBlackList($_POST['ip']);
			}
			picture::remove($_POST['id']);
			$render_variables['alert_danger'][] = lang('The picture has been deleted');
		}elseif($_POST['action']=='set_main_page' and isset($_POST['id']) and $_POST['id']>0){
			picture::setMainPage($_POST['id']);
			$render_variables['alert_success'][] = lang('Changes have been saved');
		}elseif($_POST['action']=='remove_pictures' and isset($_POST['pictures']) and is_array($_POST['pictures'])){
			foreach($_POST['pictures'] as $key => $value){
				if($value>0){
					picture::remove($value);
				}
			}
			$render_variables['alert_danger'][] = lang('The picture has been deleted');
		}elseif($_POST['action']=='set_main_page_pictures' and isset($_POST['pictures']) and is_array($_POST['pictures'])){
			foreach($_POST['pictures'] as $key => $value){
				if($value>0){
					picture::setMainPage($value);
				}
			}
			$render_variables['alert_success'][] = lang('Changes have been saved');
		}
	}

	$render_variables['pictures'] = picture::getPictures(50,'admin');

	$sth = $db->query('SELECT * FROM '._DB_PREFIX_.'user where active = 1 order by username');
	foreach($sth as $row){$users[] = $row;}
	if(isset($users)){$render_variables['users'] = $users;}

	$title = lang('Pictures').' - '.$title_default;

}
