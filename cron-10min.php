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

require_once(realpath(dirname(__FILE__)).'/config/config.php');

function cron_10min(){
	global $db;

	$sth = $db->query('SELECT * FROM '._DB_PREFIX_.'mail_queue ORDER BY priority DESC, id LIMIT 10');
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)){
		if(sendMail($row['action'], $row['receiver'], unserialize($row['data']))){
			$sth2 = $db->prepare('DELETE FROM `'._DB_PREFIX_.'mail_queue` WHERE id=:id LIMIT 1');
			$sth2->bindValue(':id', $row['id'], PDO::PARAM_INT);
			$sth2->execute();
		}
	}

}
cron_10min();
