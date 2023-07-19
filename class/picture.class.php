<?php
/************************************************************************
 * The script of website with demotivators DEMOTY2
 * Copyright (c) 2018 - 2023 by IT Works Better https://itworksbetter.net
 * Project by Kamil Wyremski https://wyremski.pl
 *
 * All right reserved
 *
 * *********************************************************************
 * THIS SOFTWARE IS LICENSED - YOU CAN MODIFY THESE pictureS BUT YOU CAN NOT REMOVE OF ORIGINAL COMMENTS!
 * ACCORDING TO THE LICENSE YOU CAN USE THE SCRIPT ON ONE DOMAIN.
 * *********************************************************************/

class picture
{

  public static $title_sizes = [10, 15, 18, 21, 25, 30, 35, 40, 45, 50];
  public static $title_default_size = 40;
  public static $title_default_color = '#FFFFFF';
  public static $title_border_sizes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
  public static $title_default_border_size = 2;
  public static $title_default_border_color = '#000000';

  public static $description_sizes = [10, 15, 18, 21, 25, 30, 35, 40, 45, 50];
  public static $description_default_size = 15;
  public static $description_default_color = '#FFFFFF';
  public static $description_border_sizes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
  public static $description_default_border_size = 0;
  public static $description_default_border_color = '#000000';

  public static $background_color = '#000000';
  public static $border_color = '#FFFFFF';

  public static $picture_width = 600;
  public static $demot_padding = 35;

  public static function getPictures(int $limit = 10, $subpage = '', $subpage_data = [])
  {
    global $db, $user;
    $pictures = [];
    $where_statement = ' true ';
    $bind_values = [];
    $sort = ' main_page_date desc ';
    if ($subpage == 'main_page') {
      $where_statement .= ' AND waiting_room=0 ';
    } elseif ($subpage == 'waiting_room') {
      $where_statement .= ' AND waiting_room=1 ';
      $sort = ' date desc ';
    } elseif ($subpage == 'top') {
      $sort = ' voices_plus desc, main_page_date desc ';
    } elseif ($subpage == 'random') {
      $sort = ' rand() ';
    } elseif ($subpage == 'category' and !empty($subpage_data['category_id'])) {
      $where_statement .= ' AND category_id=' . $subpage_data['category_id'] . ' ';
    } elseif ($subpage == 'search' and !empty($_GET['q'])) {
      $where_statement .= ' AND (f.slug LIKE :q OR f.id IN (SELECT tf.picture_id FROM ' . _DB_PREFIX_ . 'tag t, ' . _DB_PREFIX_ . 'tag_picture tf WHERE t.slug LIKE :q AND t.id = tf.tag_id)) ';
      $bind_values['q'] = '%' . slug($_GET['q']) . '%';
    } elseif ($subpage == 'profile_pictures' and !empty($subpage_data['username'])) {
      $where_statement .= ' AND user_id=(SELECT id FROM ' . _DB_PREFIX_ . 'user u WHERE u.id=f.user_id LIMIT 1) ';
    } elseif ($subpage == 'tag' and !empty($subpage_data['tag_id'])) {
      $where_statement .= ' AND (SELECT count(1) FROM ' . _DB_PREFIX_ . 'tag_picture tf, ' . _DB_PREFIX_ . 'tag t WHERE tf.tag_id=t.id AND t.id="' . $subpage_data['tag_id'] . '" AND tf.picture_id=f.id LIMIT 1) > 0 ';
    } elseif ($subpage == 'my_pictures') {
      $where_statement .= ' AND user_id=' . $user->getId() . ' ';
    } elseif ($subpage == 'admin') {
      $sort = sortBy();
      if (isset($_GET['search'])) {
        if (isset($_GET['id']) and $_GET['id'] > 0) {
          $where_statement .= ' AND id = :id ';
          $bind_values['id'] = $_GET['id'];
        }
        if (!empty($_GET['title'])) {
          $where_statement .= ' AND slug LIKE :title ';
          $bind_values['title'] = '%' . slug($_GET['title']) . '%';
        }
        if (isset($_GET['user_id']) and $_GET['user_id'] > 0) {
          $where_statement .= ' AND user_id = :user_id ';
          $bind_values['user_id'] = $_GET['user_id'];
        }
        if (!empty($_GET['main_page'])) {
          if ($_GET['main_page'] == 'yes') {
            $where_statement .= ' AND waiting_room="0" ';
          } elseif ($_GET['main_page'] == 'no') {
            $where_statement .= ' AND waiting_room="1" ';
          }
        }
        if (!empty($_GET['date_from'])) {
          $where_statement .= ' AND date >= :date_from ';
          $bind_values['date_from'] = $_GET['date_from'];
        }
        if (!empty($_GET['date_to'])) {
          $where_statement .= ' AND date <= :date_to ';
          $bind_values['date_to'] = $_GET['date_to'] . '  23:59:59';
        }
        if (!empty($_GET['ip'])) {
          $where_statement .= ' AND ip LIKE :ip ';
          $bind_values['ip'] = '%' . $_GET['ip'] . '%';
        }
      }
    }

    $sth = $db->prepare('SELECT SQL_CALC_FOUND_ROWS *,
      (SELECT username FROM ' . _DB_PREFIX_ . 'user WHERE id=f.user_id) AS username,
      (SELECT count(1) FROM ' . _DB_PREFIX_ . 'voice v WHERE v.voice="1" AND v.picture_id=f.id) AS voices_plus, (SELECT count(1) FROM ' . _DB_PREFIX_ . 'voice v WHERE v.voice="-1" AND v.picture_id=f.id) AS voices_minus,
      (SELECT count(1) FROM ' . _DB_PREFIX_ . 'logs_picture lf WHERE lf.picture_id=f.id) AS view_all,
      (SELECT count(distinct lf.ip) FROM ' . _DB_PREFIX_ . 'logs_picture lf WHERE lf.picture_id=f.id) AS view_unique
      FROM ' . _DB_PREFIX_ . 'picture f WHERE ' . $where_statement . ' ORDER BY ' . $sort . ' LIMIT :limit_from, :limit_to');
    $sth->bindValue(':limit_from', paginationPageFrom($limit), PDO::PARAM_INT);
    $sth->bindValue(':limit_to', $limit, PDO::PARAM_INT);
    foreach ($bind_values as $key => $value) {
      $sth->bindValue(':' . $key, $value, PDO::PARAM_STR);
    }
    $sth->execute();

    generatePagination($limit);

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
      if ($row['category_id'] > 0) {
        $sth2 = $db->prepare('SELECT slug, name FROM ' . _DB_PREFIX_ . 'category WHERE id=:category_id LIMIT 1');
        $sth2->bindValue(':category_id', $row['category_id'], PDO::PARAM_INT);
        $sth2->execute();
        $row['category'] = $sth2->fetch(PDO::FETCH_ASSOC);
      }
      $pictures[] = $row;
    }

    return $pictures;
  }

  public static function getPicture(int $id, $type = '')
  {
    global $db, $user;
    $sth = $db->prepare('SELECT *,
      (SELECT username FROM ' . _DB_PREFIX_ . 'user WHERE id=f.user_id) AS username,
      (SELECT count(1) FROM ' . _DB_PREFIX_ . 'voice v WHERE v.voice="1" AND v.picture_id=f.id) AS voices_plus, (SELECT count(1) FROM ' . _DB_PREFIX_ . 'voice v WHERE v.voice="-1" AND v.picture_id=f.id) AS voices_minus,
      (SELECT count(1) FROM ' . _DB_PREFIX_ . 'logs_picture lf WHERE lf.picture_id=f.id) AS view_all,
      (SELECT count(distinct lf.ip) FROM ' . _DB_PREFIX_ . 'logs_picture lf WHERE lf.picture_id=f.id) AS view_unique
      FROM ' . _DB_PREFIX_ . 'picture f WHERE id=:id LIMIT 1');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $picture = $sth->fetch(PDO::FETCH_ASSOC);
    if ($picture) {
      if ($type != 'admin') {
        if ($picture['category_id'] > 0) {
          $sth = $db->prepare('SELECT slug, name FROM ' . _DB_PREFIX_ . 'category WHERE id=:category_id LIMIT 1');
          $sth->bindValue(':category_id', $picture['category_id'], PDO::PARAM_INT);
          $sth->execute();
          $picture['category'] = $sth->fetch(PDO::FETCH_ASSOC);
        }

        $sth = $db->prepare('SELECT name, slug FROM ' . _DB_PREFIX_ . 'tag, ' . _DB_PREFIX_ . 'tag_picture WHERE id=tag_id AND picture_id=:picture_id');
        $sth->bindValue(':picture_id', $id, PDO::PARAM_INT);
        $sth->execute();
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
          $picture['tags'][] = $row;
        }

        $sth = $db->prepare('INSERT INTO `' . _DB_PREFIX_ . 'logs_picture`(`picture_id`, `user_id`, `ip`, `date`) VALUES (:picture_id,:user_id,:ip,NOW())');
        $sth->bindValue(':picture_id', $id, PDO::PARAM_INT);
        $sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
        $sth->bindValue(':ip', getClientIp(), PDO::PARAM_STR);
        $sth->execute();
      }
    }
    return $picture;
  }

  public static function add($data)
  {
    global $db, $user, $settings;

    if (checkIpBlackList(getClientIp())) {
      return ['status' => false, 'error' => lang('Picture cannot be added')];
    }

    $generate_picture = static::generatePicture($data);
    if (!$generate_picture['status']) {
      return ['status' => false, 'error' => lang('Error while added picture')];
    }

    $sth = $db->prepare('DELETE FROM `' . _DB_PREFIX_ . 'picture_tmp` WHERE filename=:filename LIMIT 1');
    $sth->bindValue(':filename', $data['filename'], PDO::PARAM_STR);
    $sth->execute();

    chmod(_FOLDER_PICTURES_, 0777);
    copy(_FOLDER_PICTURES_TMP_ . $data['filename'], _FOLDER_PICTURES_ . $data['filename']);
    chmod(_FOLDER_PICTURES_, 0755);

    if (!empty($data['category_id'])) {
      $category_id = $data['category_id'];
    } else {
      $category_id = 0;
    }

    $title = checkWordsBlackList(substr(strip_tags($data['title']), 0, $settings['number_char_title']));

    $sth = $db->prepare('INSERT INTO `' . _DB_PREFIX_ . 'picture`(`user_id`, `title`, `slug`, `waiting_room`, `filename`, `ip`, `date`) VALUES (:user_id,:title,:slug,1,:filename,:ip,NOW())');
    $sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
    $sth->bindValue(':title', $title, PDO::PARAM_STR);
    $sth->bindValue(':slug', slug($title), PDO::PARAM_STR);
    $sth->bindValue(':filename', $data['filename'], PDO::PARAM_STR);
    $sth->bindValue(':ip', getClientIp(), PDO::PARAM_STR);
    $sth->execute();
    $id = $db->lastInsertId();

    static::edit($data, $id);

    return ['status' => true, 'path' => path('picture', $id, slug($title))];
  }

  public static function edit($data, int $id)
  {
    global $db, $settings;

    if (empty($data['category_id'])) {
      $data['category_id'] = 0;
    }
    $title = checkWordsBlackList(substr(strip_tags($data['title']), 0, $settings['number_char_title']));

    $sth = $db->prepare('UPDATE `' . _DB_PREFIX_ . 'picture` SET `title`=:title, `slug`=:slug, `category_id`=:category_id, `type`=:type, `version`=version+1, `description`=:description, `title_size`=:title_size, `title_color`=:title_color, `title_border_size`=:title_border_size, `title_border_color`=:title_border_color, `description_size`=:description_size, `description_color`=:description_color, `description_border_size`=:description_border_size, `description_border_color`=:description_border_color, `background_color`=:background_color, `border_color`=:border_color WHERE id=:id LIMIT 1');
    $sth->bindValue(':title', $title, PDO::PARAM_STR);
    $sth->bindValue(':slug', slug($title), PDO::PARAM_STR);
    $sth->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
    $sth->bindValue(':type', $data['type'], PDO::PARAM_STR);
    $sth->bindValue(':description', checkWordsBlackList(substr(strip_tags($data['description']), 0, $settings['number_char_description'])), PDO::PARAM_STR);
    $sth->bindValue(':title_size', $data['title_size'], PDO::PARAM_INT);
    $sth->bindValue(':title_color', $data['title_color'], PDO::PARAM_STR);
    $sth->bindValue(':title_border_size', $data['title_border_size'], PDO::PARAM_INT);
    $sth->bindValue(':title_border_color', $data['title_border_color'], PDO::PARAM_STR);
    $sth->bindValue(':description_size', $data['description_size'], PDO::PARAM_INT);
    $sth->bindValue(':description_color', $data['description_color'], PDO::PARAM_STR);
    $sth->bindValue(':description_border_size', $data['description_border_size'], PDO::PARAM_INT);
    $sth->bindValue(':description_border_color', $data['description_border_color'], PDO::PARAM_STR);
    $sth->bindValue(':background_color', $data['background_color'], PDO::PARAM_STR);
    $sth->bindValue(':border_color', $data['border_color'], PDO::PARAM_STR);
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();

    $sth = $db->prepare('DELETE FROM ' . _DB_PREFIX_ . 'tag_picture WHERE `picture_id`=:picture_id');
    $sth->bindValue(':picture_id', $id, PDO::PARAM_INT);
    $sth->execute();

    static::saveTags($id, $data['tags']);

    return ['status' => true, 'path' => path('picture', $id, slug($data['title']))];
  }

  public static function saveTags(int $picture_id, $tags)
  {
    global $db;
    if ($tags) {
      $tags_array = explode(',', strip_tags($tags));
      for ($i = 0; $i <= count($tags_array) - 1; $i++) {
        $name = trim($tags_array[$i]);
        $slug = slug($name);
        if ($slug) {
          $sth = $db->prepare('SELECT id FROM ' . _DB_PREFIX_ . 'tag WHERE slug=:slug LIMIT 1');
          $sth->bindValue(':slug', $slug, PDO::PARAM_STR);
          $sth->execute();
          if ($tag_database = $sth->fetch(PDO::FETCH_ASSOC)) {
            $tag_id = $tag_database['id'];
          } else {
            $sth = $db->prepare('INSERT INTO ' . _DB_PREFIX_ . 'tag (`name`, `slug`) VALUES (:name,:slug)');
            $sth->bindValue(':name', $name, PDO::PARAM_STR);
            $sth->bindValue(':slug', $slug, PDO::PARAM_STR);
            $sth->execute();
            $tag_id = $db->lastInsertId();
          }
          $sth = $db->prepare('INSERT INTO ' . _DB_PREFIX_ . 'tag_picture (`tag_id`, `picture_id`) VALUES (:tag_id,:picture_id)');
          $sth->bindValue(':tag_id', $tag_id, PDO::PARAM_INT);
          $sth->bindValue(':picture_id', $picture_id, PDO::PARAM_INT);
          $sth->execute();
        }
      }
    }
  }

  public static function setVoice(int $picture_id, $voice)
  {
    global $db, $user;
    if ($user->getId()) {
      $sth = $db->prepare('DELETE FROM ' . _DB_PREFIX_ . 'voice WHERE user_id=:user_id AND picture_id=:picture_id');
      $sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
      $sth->bindValue(':picture_id', $picture_id, PDO::PARAM_INT);
      $sth->execute();
    } else {
      $sth = $db->prepare('DELETE FROM ' . _DB_PREFIX_ . 'voice WHERE user_id=0 AND ip=:ip AND picture_id=:picture_id');
      $sth->bindValue(':ip', getClientIp(), PDO::PARAM_STR);
      $sth->bindValue(':picture_id', $picture_id, PDO::PARAM_INT);
      $sth->execute();
    }
    $sth = $db->prepare('INSERT INTO `' . _DB_PREFIX_ . 'voice`(`picture_id`, `user_id`, `voice`, `ip`, `date`) VALUES (:picture_id,:user_id,:voice,:ip,NOW())');
    $sth->bindValue(':picture_id', $picture_id, PDO::PARAM_INT);
    $sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
    $sth->bindValue(':voice', $voice, PDO::PARAM_INT);
    $sth->bindValue(':ip', getClientIp(), PDO::PARAM_STR);
    $sth->execute();
  }

  public static function getVoice(int $picture_id)
  {
    global $db, $user;
    $voices = ['plus' => 0, 'minus' => 0];
    $sth = $db->prepare('SELECT voice, count(1) AS voice_count FROM `' . _DB_PREFIX_ . 'voice` WHERE picture_id=:picture_id GROUP BY voice');
    $sth->bindValue(':picture_id', $picture_id, PDO::PARAM_INT);
    $sth->execute();
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
      if ($row['voice'] == '1') {
        $voices['plus'] = $row['voice_count'];
      } elseif ($row['voice'] == '-1') {
        $voices['minus'] = $row['voice_count'];
      }
    }
    return $voices;
  }

  public static function checkPermissions(int $id)
  {
    global $user, $db;
    if ($user->getId()) {
      if ($user->moderator) {
        return true;
      }
      $sth = $db->prepare('SELECT 1 FROM ' . _DB_PREFIX_ . 'picture WHERE id=:id AND user_id=:user_id LIMIT 1');
      $sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
      $sth->bindValue(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      if ($sth->fetchColumn()) {
        return true;
      }
    }
    return false;
  }

  public static function setMainPage(int $id)
  {
    global $db;
    $sth = $db->prepare('UPDATE ' . _DB_PREFIX_ . 'picture SET waiting_room=0, main_page_date=now() WHERE id=:id LIMIT 1');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }

  public static function hex2rgb($hex, $default_color = '#000000')
  {
    $hex = str_replace("#", "", $hex);
    if (!preg_match('/^[a-f0-9]{6}$/i', $hex)) {
      $hex = str_replace("#", "", $default_color);
    }
    if (strlen($hex) == 3) {
      $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
      $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
      $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
      $r = hexdec(substr($hex, 0, 2));
      $g = hexdec(substr($hex, 2, 2));
      $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
  }

  public static function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px)
  {
    for ($c1 = ($x - abs($px)); $c1 <= ($x + abs($px)); $c1++)
      for ($c2 = ($y - abs($px)); $c2 <= ($y + abs($px)); $c2++)
        $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
    return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
  }

  public static function newPictureFilename()
  {
    global $db, $user;
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
    $alphaLength = strlen($alphabet) - 1;
    do {
      $pass = [];
      for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
      $filename = implode($pass) . '.png';
      $sth = $db->prepare('SELECT 1 FROM ' . _DB_PREFIX_ . 'picture_tmp WHERE filename=:filename LIMIT 1');
      $sth->bindValue(':filename', $filename, PDO::PARAM_STR);
      $sth->execute();
    } while ($sth->fetchColumn());

    $sth = $db->prepare('INSERT INTO `' . _DB_PREFIX_ . 'picture_tmp`(`filename`, `user_id`, `ip`, `date`) VALUES (:filename,:user_id,:ip,NOW())');
    $sth->bindValue(':filename', $filename, PDO::PARAM_STR);
    $sth->bindValue(':user_id', $user->getId(), PDO::PARAM_INT);
    $sth->bindValue(':ip', getClientIp(), PDO::PARAM_STR);
    $sth->execute();
    return $filename;
  }

  public static function checkPictureName($filename)
  {
    global $db, $user;
    $where1 = $where2 = '';
    if (!$user->getId() or !$user->moderator) {
      $where1 = ' AND p.user_id=' . $user->getId() . ' ';
      $where2 = ' AND pt.user_id=' . $user->getId() . ' ';
    }
    $sth = $db->prepare('SELECT 1 FROM ' . _DB_PREFIX_ . 'picture p WHERE p.filename=:filename ' . $where1 . ' UNION SELECT 1 FROM ' . _DB_PREFIX_ . 'picture_tmp pt WHERE pt.filename=:filename ' . $where2 . ' LIMIT 1');
    $sth->bindValue(':filename', $filename, PDO::PARAM_STR);
    $sth->execute();
    return $sth->fetchColumn();
  }

  public static function generatePicture($data)
  {
    global $db, $settings;
    if (!static::checkPictureName($data['filename'])) {
      return ['status' => 0, 'info' => lang('Error')];
    }
    if (!empty($_FILES['picture']['name']) or file_exists(_FOLDER_PICTURES_ORIGINAL_ . $data['filename']) or $data['type'] == 'demot' or $data['type'] == 'mem_pattern') {

      chmod(_FOLDER_PICTURES_TMP_, 0777);

      if (!empty($_FILES['picture']['name'])) {

        $path_parts = pathinfo($_FILES['picture']['name']);
        $path_parts['extension'] = strtolower($path_parts['extension']);

        if (!in_array($path_parts['extension'], ['jpg', 'jpeg', 'png'])) {
          return ['status' => 0, 'info' => lang('Invalid file type')];
        }
        if ($path_parts['extension'] == "jpg" || $path_parts['extension'] == "jpeg") {
          $picture_tmp = imagecreatefromjpeg($_FILES['picture']['tmp_name']);
        } else {
          $picture_tmp = imagecreatefrompng($_FILES['picture']['tmp_name']);
        }

        $newheight = round(static::$picture_width / imagesx($picture_tmp) * imagesy($picture_tmp));
        $picture_img = imagecreatetruecolor(static::$picture_width, $newheight);
        imagecopyresampled($picture_img, $picture_tmp, 0, 0, 0, 0, static::$picture_width, $newheight, imagesx($picture_tmp), imagesy($picture_tmp));

        chmod(_FOLDER_PICTURES_ORIGINAL_, 0777);
        imagepng($picture_img, _FOLDER_PICTURES_ORIGINAL_ . $data['filename']);
        chmod(_FOLDER_PICTURES_ORIGINAL_, 0755);

      } elseif ($data['type'] == 'mem_pattern' && !empty($data['picture'])) {
        $mem_pattern = getMemPattern($data['picture']);
        if ($mem_pattern) {

          $picture_tmp = imagecreatefrompng(_FOLDER_MEM_PATTERN_ . $mem_pattern['url']);

          $newheight = round(static::$picture_width / imagesx($picture_tmp) * imagesy($picture_tmp));
          $picture_img = imagecreatetruecolor(static::$picture_width, $newheight);
          imagecopyresampled($picture_img, $picture_tmp, 0, 0, 0, 0, static::$picture_width, $newheight, imagesx($picture_tmp), imagesy($picture_tmp));

          chmod(_FOLDER_PICTURES_ORIGINAL_, 0777);
          imagepng($picture_img, _FOLDER_PICTURES_ORIGINAL_ . $data['filename']);
          chmod(_FOLDER_PICTURES_ORIGINAL_, 0755);
        } else {
          return ['status' => 0, 'info' => lang('No file')];
        }
      } elseif (file_exists(_FOLDER_PICTURES_ORIGINAL_ . $data['filename'])) {
        $picture_img = imagecreatefrompng(_FOLDER_PICTURES_ORIGINAL_ . $data['filename']);
      }

      $y = 0;
      if ($data['type'] == 'mem' or $data['type'] == 'mem_pattern') {
        $newheight = imagesy($picture_img);
        $picture = $picture_img;
      } else {
        $picture = imagecreatetruecolor(static::$picture_width, 9000);
        $background_color = static::hex2rgb($data['background_color'], static::$background_color);
        imagefill($picture, 0, 0, imagecolorallocate($picture, $background_color[0], $background_color[1], $background_color[2]));
        if (!empty($picture_img)) {

          $height_picture = round((imagesy($picture_img) * (static::$picture_width - 2 * static::$demot_padding - 4)) / imagesx($picture_img));

          $picture_border = imagecreatetruecolor(static::$picture_width - 2 * static::$demot_padding + 4, $height_picture + 4);
          $border_color = static::hex2rgb($data['border_color'], static::$border_color);
          $border_color_output = imagecolorallocate($picture_border, $border_color[0], $border_color[1], $border_color[2]);
          imagefill($picture_border, 0, 0, $border_color_output);
          imagecopyresampled($picture, $picture_border, static::$demot_padding, static::$demot_padding, 0, 0, imagesx($picture_border), imagesy($picture_border), imagesx($picture_border), imagesy($picture_border));

          imagecopyresampled($picture, $picture_img, static::$demot_padding + 2, static::$demot_padding + 2, 0, 0, static::$picture_width - 2 * static::$demot_padding, $height_picture, imagesx($picture_img), imagesy($picture_img));

          $y = $height_picture + static::$demot_padding + 10;
        }
      }

      $font = realpath(dirname(__FILE__)) . '/../fonts/Roboto-Regular.ttf';
      $font_size = $data['title_size'];
      $font_color = static::hex2rgb($data['title_color'], static::$title_default_color);
      $font_color_output = imagecolorallocate($picture, $font_color[0], $font_color[1], $font_color[2]);
      $border_size = static::$title_default_border_size;
      if (isset($data['title_border_size']) and in_array($data['title_border_size'], static::$title_border_sizes)) {
        $border_color = static::hex2rgb($data['title_border_color'], static::$title_default_border_color);
        $border_color_output = imagecolorallocate($picture, $border_color[0], $border_color[1], $border_color[2]);
        $border_size = $data['title_border_size'];
      }
      $title = checkWordsBlackList(substr(strip_tags($data['title']), 0, $settings['number_char_title']));
      $title = preg_replace("/\r\n|\r|\n/", '|', $title);
      $lines = explode('|', wordwrap($title, 62 - $font_size, '|'));
      foreach ($lines as $line) {
        $y += $font_size * 1.4;
        $text_box = imagettfbbox($font_size, 0, $font, $line);
        $x = 290 - (($text_box[2] - $text_box[0]) / 2);
        imagettftext($picture, $font_size, 0, $x, $y, $font_color_output, $font, $line);
        if ($border_size) {
          static::imagettfstroketext($picture, $font_size, 0, $x, $y, $font_color_output, $border_color_output, $font, $line, $border_size);
        } else {
          imagettftext($picture, $font_size, 0, $x, $y, $font_color_output, $font, $line);
        }
      }
      $y += 10;

      $font_size = $data['description_size'];
      $font_color = static::hex2rgb($data['description_color'], static::$description_default_color);
      $font_color_output = imagecolorallocate($picture, $font_color[0], $font_color[1], $font_color[2]);
      $border_size = static::$title_default_border_size;
      if (isset($data['description_border_size']) and in_array($data['description_border_size'], static::$description_border_sizes)) {
        $border_color = static::hex2rgb($data['description_border_color'], static::$description_default_border_color);
        $border_color_output = imagecolorallocate($picture, $border_color[0], $border_color[1], $border_color[2]);
        $border_size = $data['description_border_size'];
      }
      $description = checkWordsBlackList(substr(strip_tags($data['description']), 0, $settings['number_char_description']));
      $description = preg_replace("/\r\n|\r|\n/", '|', $description);
      if ($description != '') {
        if ($data['type'] == 'mem' or $data['type'] == 'mem_pattern') {
          $lines = explode('|', wordwrap($description, 62 - $font_size, '|'));
          $y = $newheight - ($font_size * 1.25) * (count($lines) + 1) - 10;
        } else {
          $lines = explode('|', wordwrap($description, 55 - $font_size, '|'));
        }
        foreach ($lines as $line) {
          $y += $font_size * 1.4;
          $text_box = imagettfbbox($font_size, 0, $font, $line);
          $x = 290 - (($text_box[2] - $text_box[0]) / 2);
          if ($border_size) {
            static::imagettfstroketext($picture, $font_size, 0, $x, $y, $font_color_output, $border_color_output, $font, $line, $border_size);
          } else {
            imagettftext($picture, $font_size, 0, $x, $y, $font_color_output, $font, $line);
          }
        }
      }

      if ($data['type'] == 'demot') {
        $newheight = $y + $font_size;
      }

      $picture_output = imagecreatetruecolor(static::$picture_width, $newheight);
      imagecopyresized($picture_output, $picture, 0, 0, 0, 0, static::$picture_width, $newheight, static::$picture_width, $newheight);

      if (!empty($settings['watermark_add'])) {
        $settings['watermark'] = getFullUrl($settings['watermark']);
        $stamp_parts = pathinfo($settings['watermark']);
        $stamp_parts['extension'] = strtolower($stamp_parts['extension']);

        if (in_array($stamp_parts['extension'], ['jpg', 'jpeg', 'gif', 'png'])) {
          if ($stamp_parts['extension'] == "jpg" || $stamp_parts['extension'] == "jpeg") {
            $stamp = imagecreatefromjpeg($settings['watermark']);
          } elseif ($stamp_parts['extension'] == "png") {
            $stamp = imagecreatefrompng($settings['watermark']);
          } else {
            $stamp = imagecreatefromgif($settings['watermark']);
          }
          imagecopy($picture_output, $stamp, imagesx($picture_output) - imagesx($stamp) - 5, imagesy($picture_output) - imagesy($stamp) - 5, 0, 0, imagesx($stamp), imagesy($stamp));
        }
      }

      imagepng($picture_output, _FOLDER_PICTURES_TMP_ . $data['filename']);
      chmod(_FOLDER_PICTURES_ORIGINAL_, 0755);

      return ['status' => 1, 'picture' => 'upload/tmp/' . $data['filename']];

    } else {
      return ['status' => 0, 'info' => lang('No file')];
    }
  }

  public static function remove(int $id)
  {
    global $db;
    $picture = static::getPicture($id, 'admin');
    chmod(_FOLDER_PICTURES_, 0777);
    unlink(_FOLDER_PICTURES_ . $picture['filename']);
    chmod(_FOLDER_PICTURES_, 0755);
    chmod(_FOLDER_PICTURES_ORIGINAL_, 0777);
    unlink(_FOLDER_PICTURES_ORIGINAL_ . $picture['filename']);
    chmod(_FOLDER_PICTURES_ORIGINAL_, 0755);
    if (file_exists(_FOLDER_PICTURES_TMP_ . $picture['filename'])) {
      chmod(_FOLDER_PICTURES_TMP_, 0777);
      unlink(_FOLDER_PICTURES_TMP_ . $picture['filename']);
      chmod(_FOLDER_PICTURES_TMP_, 0755);
    }
    $sth = $db->prepare('DELETE FROM `' . _DB_PREFIX_ . 'tag_picture` WHERE picture_id=:id');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $sth = $db->prepare('DELETE FROM `' . _DB_PREFIX_ . 'voice` WHERE picture_id=:id');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $sth = $db->prepare('DELETE FROM `' . _DB_PREFIX_ . 'picture` WHERE id=:id LIMIT 1');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }
}