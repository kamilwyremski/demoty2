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

if($admin->is_logged()){

	if(!_ADMIN_TEST_MODE_ and isset($_POST['action'])){
		if($_POST['action']=='remove_logs' and !empty($_POST['type'])){
			if($_POST['type']=='only_removed'){
				$db->query('DELETE FROM '._DB_PREFIX_.'logs_picture WHERE picture_id NOT IN (SELECT id FROM '._DB_PREFIX_.'picture)');
				$render_variables['alert_danger'][] = lang('Successfully deleted');
			}elseif($_POST['type']=='all'){
				$db->query('TRUNCATE `'._DB_PREFIX_.'logs_picture`');
				$render_variables['alert_danger'][] = lang('Successfully deleted');
			}
		}
	}

	$limit = 100;

	$sth = $db->prepare('SELECT SQL_CALC_FOUND_ROWS lp.*, p.slug, p.title, u.username, u.email FROM '._DB_PREFIX_.'logs_picture lp
	LEFT JOIN '._DB_PREFIX_.'picture p ON lp.picture_id=p.id
	LEFT JOIN '._DB_PREFIX_.'user u ON lp.user_id=u.id
	ORDER BY '.sortBy().' LIMIT :limit_from, :limit_to');
	$sth->bindValue(':limit_from', paginationPageFrom($limit), PDO::PARAM_INT);
	$sth->bindValue(':limit_to', $limit, PDO::PARAM_INT);
	$sth->execute();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)){	$logs_pictures[] = $row;}
	if(isset($logs_pictures)){$render_variables['logs_pictures'] = $logs_pictures;}

	generatePagination($limit);

	$title = lang('Logs pictures').' - '.$title_default;

}
