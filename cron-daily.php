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

require_once(realpath(dirname(__FILE__)).'/config/config.php');

function cron(){
	global $db, $settings;

	$db->query('DELETE FROM '._DB_PREFIX_.'user WHERE active=0 and date<(CURDATE() - INTERVAL 1 DAY)');

	$db->query('DELETE FROM '._DB_PREFIX_.'session_user WHERE date<(CURDATE() - INTERVAL 1 DAY)');

	$sth = $db->query('SELECT * FROM `'._DB_PREFIX_.'picture_tmp` WHERE date<(CURDATE() - INTERVAL 1 DAY) AND filename NOT IN (SELECT filename FROM `'._DB_PREFIX_.'picture`)');
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
		if(file_exists(_FOLDER_PICTURES_ORIGINAL_.$row['filename'])){
			chmod(_FOLDER_PICTURES_ORIGINAL_, 0777);
			unlink(_FOLDER_PICTURES_ORIGINAL_.$row['filename']);
			chmod(_FOLDER_PICTURES_ORIGINAL_, 0755);
		}
		if(file_exists(_FOLDER_PICTURES_TMP_.$row['filename'])){
			chmod(_FOLDER_PICTURES_TMP_, 0777);
			unlink(_FOLDER_PICTURES_TMP_.$row['filename']);
			chmod(_FOLDER_PICTURES_TMP_, 0755);
		}
	 	$db->query('DELETE FROM `'._DB_PREFIX_.'picture_tmp` WHERE id='.$row['id'].' LIMIT 1');
	}

	$db->query('DELETE FROM '._DB_PREFIX_.'admin_session WHERE date<(CURDATE() - INTERVAL 1 DAY)');
	
	if($settings['generate_sitemap']){
		include(realpath(dirname(__FILE__)).'/php/sitemap_generator.php');
		sitemap_generator();
	}

}
cron();


