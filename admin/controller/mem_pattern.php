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

if(!isset($settings['base_url'])){
	die('Access denied!');
}

if($admin->is_logged()){

	if(!_ADMIN_TEST_MODE_ and isset($_POST['action'])){
		if($_POST['action']=='add_picture' and !empty($_FILES["image"]["type"])){

			$path_parts = pathinfo($_FILES['image']['name']);
			$path_parts['extension'] = strtolower($path_parts['extension']);

			if(in_array($path_parts['extension'] , ['jpg','jpeg','png'])){

				chmod(_FOLDER_MEM_PATTERN_, 0777);

				$url = substr(slug($path_parts['filename']), 0, 200).'.png';
				$i = 0;
				while(file_exists(_FOLDER_MEM_PATTERN_.$url)) {
					$url = substr(slug($path_parts['filename']), 0, 200).'_'.$i.'.png';
					$i++;
				}

				if($path_parts['extension']=="jpg" || $path_parts['extension']=="jpeg"){
					$src = imagecreatefromjpeg($_FILES['image']['tmp_name']);
				}else{
					$src = imagecreatefrompng($_FILES['image']['tmp_name']);
				}

				imagepng($src,_FOLDER_MEM_PATTERN_.$url);

				list($width,$height)=getimagesize(_FOLDER_MEM_PATTERN_.$url);

				if($height >= 50){
					$newheight = 50;
				}else{
					$newheight = $height;
				}
				$newwidth = round($newheight / $height * $width);
				$tmp = imagecreatetruecolor($newwidth,$newheight);
				if($path_parts['extension']=="png"){
					imagesavealpha($tmp, true);
					$color = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
					imagefill($tmp, 0, 0, $color);
				}
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
				$thumb = explode('.', $url)[0].'_thumb.'.$path_parts['extension'];

				if($path_parts['extension']=="jpg" || $path_parts['extension']=="jpeg"){
					imagejpeg($tmp,_FOLDER_MEM_PATTERN_.$thumb,100);
				}else{
					imagepng($tmp,_FOLDER_MEM_PATTERN_.$thumb);
				}
				imagedestroy($src);

				chmod(_FOLDER_MEM_PATTERN_, 0755);

				$sth = $db->prepare('INSERT INTO `'._DB_PREFIX_.'mem_pattern`(`url`, `thumb`, `position`) VALUES (:url,:thumb,:position)');
				$sth->bindValue(':url', $url, PDO::PARAM_STR);
				$sth->bindValue(':thumb', $thumb, PDO::PARAM_STR);
				$sth->bindValue(':position', getPosition('mem_pattern'), PDO::PARAM_INT);
				$sth->execute();
				$render_variables['alert_success'][] = lang('Successfully added new image');
			}

		}elseif($_POST['action']=='remove_picture' and isset($_POST['id']) and $_POST['id']>0){
			$mem = getMemPattern($_POST['id']);
			if($mem){
				chmod(_FOLDER_MEM_PATTERN_, 0777);
				unlink(_FOLDER_MEM_PATTERN_.$mem['url']);
				unlink(_FOLDER_MEM_PATTERN_.$mem['thumb']);
				chmod(_FOLDER_MEM_PATTERN_, 0755);
				$sth = $db->prepare('DELETE FROM `'._DB_PREFIX_.'mem_pattern` WHERE id=:id LIMIT 1');
				$sth->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
				$sth->execute();
				$render_variables['alert_danger'][] = lang('Successfully deleted');
			}
		}
	}

	$render_variables['mem_patterns'] = getMemPatterns();

	$title = lang('Memes patterns').' - '.$title_default;
}
