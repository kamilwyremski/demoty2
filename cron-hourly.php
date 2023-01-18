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

function cron_hourly(){
	global $db, $settings;

	if($settings['automation_randomly'] and $settings['automation_randomly_pictures']){
		$sth = $db->query('SELECT id FROM `'._DB_PREFIX_.'picture` WHERE waiting_room=1 ORDER BY rand() LIMIT '.$settings['automation_randomly_pictures']);
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
			picture::setMainPage($row['id']);
		}
	}

	if($settings['automation_added'] and $settings['automation_added_pictures'] and $settings['automation_added_days']){
		$sth = $db->query('SELECT id FROM `'._DB_PREFIX_.'picture` WHERE waiting_room=1 AND date<=(CURDATE() - INTERVAL '.$settings['automation_added_days'].' DAY) ORDER BY rand() LIMIT '.$settings['automation_added_pictures']);
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
			picture::setMainPage($row['id']);
		}
	}

	if($settings['automation_votes_plus'] and $settings['automation_votes_plus_pictures'] and $settings['automation_votes_plus_votes']){
		$sth = $db->query('SELECT p.id FROM `'._DB_PREFIX_.'picture` p WHERE p.waiting_room=1 AND (SELECT count(1) FROM '._DB_PREFIX_.'voice v WHERE v.voice="1" AND v.picture_id=p.id)>='.$settings['automation_votes_plus_votes'].' ORDER BY rand() LIMIT '.$settings['automation_votes_plus_pictures']);
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
			picture::setMainPage($row['id']);
		}
	}

	if($settings['automation_votes_minus'] and $settings['automation_votes_minus_pictures'] and $settings['automation_votes_minus_votes']){
		$sth = $db->query('SELECT p.id FROM `'._DB_PREFIX_.'picture` p WHERE p.waiting_room=1 AND (SELECT count(1) FROM '._DB_PREFIX_.'voice v WHERE v.voice="-1" AND v.picture_id=p.id)>='.$settings['automation_votes_minus_votes'].' ORDER BY rand() LIMIT '.$settings['automation_votes_minus_pictures']);
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
			picture::setMainPage($row['id']);
		}
	}

}
cron_hourly();
