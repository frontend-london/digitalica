<?
    global $category, $default_action, $category_db, $category_db2;
    $category_db = 'threads';
    $category_db2 = '';
    $default_action = 'edit';
	
	

    function generuj_menu() {
            global $category_db, $active_category;
            $sql = "SELECT * FROM `$category_db` WHERE `section` = '$active_category' ORDER BY `date` DESC, `id` DESC";
            $wynik = mysql_query($sql);
            $menu = array();
            while($w = mysql_fetch_array($wynik)) {
                    $menu[] = $w;
            }
            return $menu;
    }

    

    function generuj_rekord($id='') {
        global $category_db, $category_db2, $active_category;

        if(!empty($id)) {
            $sql = "SELECT * FROM `$category_db` WHERE `section` = '$active_category' AND `id` = '$id' LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        } else {
            $w = false;

        }

        if(!$w) {
            $sql = "SELECT * FROM `$category_db` WHERE `section` = '$active_category' ORDER BY `date` DESC, `id` DESC LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        }

        return $w;
    }
    
    if(empty($action) && isset($_POST['action'])) $action = $_POST['action'];
    if(empty($action) && isset($_GET['action'])) $action = $_GET['action'];
    if(empty($action)) $action = $default_action;    
	
	//echo $action; exit();
	//echo $id; exit();

    $continue = true;
    
    while($continue):
        $continue = false;

        switch($action):
            case 'edit':
                $t['menu'] = generuj_menu();
                if(empty($id)) $id = (int)isset($_GET['id'])?$_GET['id']:0;
				
                $t['record'] = generuj_rekord($id);
                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;

            case 'edit-save':
                $id = escape_data($_POST['id']);
                $title = escape_data($_POST['title']);
                $url = generate_url($title, $category_db, $active_category, $id);
                $date = escape_data($_POST['date']);
                $short_text = escape_data($_POST['short_text']);
                $long_text = escape_data($_POST['long_text']);
                $img_small = escape_data($_POST['is_img_small']);
                $img_big = escape_data($_POST['is_img_big']);
                /* TWITTER START */
                $tweet = '.. - '.ADRES.'n/'.$id;
                $tweet_len = strlen($tweet);
                $tweet = substr($title, 0, 140-$tweet_len).$tweet;
                post_tweet($tweet);                
                /* TWITTER STOP */
                if(!empty($_FILES['img_small']['name'])) {
                    $filename = "../images/threads/$id.jpg";
                    @unlink($filename);
                    stworz_miniature(CMS_TH_WIDTH, CMS_TH_HEIGHT, $_FILES['img_small']['tmp_name'], $_FILES['img_small']['type'], $filename, 'jpg', true, true, true);
                    $img_small = true;
                }
                if(!empty($_FILES['img_big']['name'])) {
                    $filename_m = "../images/threads/{$id}_b.jpg";
                    @unlink($filename_m);
                    stworz_miniature(CMS_IMG_WIDTH, CMS_IMG_HEIGHT, $_FILES['img_big']['tmp_name'], $_FILES['img_big']['type'], $filename_m, 'jpg', true, false, false);
                    $img_big = true;
                }
                $sql = "UPDATE `$category_db` SET `title`= '$title', `url`= '$url', `date` = '$date', `short_text` = '$short_text', `long_text` = '$long_text', `img_small` = '$img_small', `img_big` = '$img_big', `author` = '{$_SESSION['id']}' WHERE `id`= '$id' AND `section` = '$active_category'";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT;
                else $t['message'] = LANG_WPIS_KOMUNIKAT2;
                $continue = true;
                $action = 'edit';
                break;

            case 'add':
                $t['record']['id'] =  'new';
                $t['record']['img_small'] =  false;
                $t['record']['img_big'] =  false;
                $t['record']['date'] = gmdate ("Y-m-d");
                $t['menu'] = generuj_menu();
                $t['action'] = 'add-save';
                include("templates/$category.phtml");
                break;

            case 'add-save':
                $id = $_POST['id'];
                $title = escape_data($_POST['title']);
                $url = generate_url($title, $category_db, $active_category);
                $date = escape_data($_POST['date']);
                $short_text = escape_data($_POST['short_text']);
                $long_text = escape_data($_POST['long_text']);
                $img_small = false;
                $img_big = false;

                $wynik=mysql_query("INSERT INTO `$category_db`(`section`,`date`, `title`, `url`, `short_text`, `long_text`, `author`, `img_small`, `img_big`) VALUES(
                                                    '$active_category', '$date', '$title', '$url', '$short_text', '$long_text', '{$_SESSION['id']}', '$img_small', '$img_big')");
                if($wynik) {
                        $id = mysql_insert_id();
                        $tweet = '.. - '.ADRES.'n/'.$id;
                        $tweet_len = strlen($tweet);
                        $tweet = substr($title, 0, 140-$tweet_len).$tweet;
                        post_tweet($tweet);
                        $t['message'] = LANG_WPIS_KOMUNIKAT3;

                        if(!empty($_FILES['img_small']['name'])) {
                            $filename = "../images/threads/$id.jpg";
                            @unlink($filename);
                            stworz_miniature(CMS_TH_WIDTH, CMS_TH_HEIGHT, $_FILES['img_small']['tmp_name'], $_FILES['img_small']['type'], $filename, 'jpg', true, true, true);
                            $img_small = true;
                        }

                        if(!empty($_FILES['img_big']['name'])) {
                            $filename_m = "../images/threads/{$id}_b.jpg";
                            @unlink($filename_m);
                            stworz_miniature(CMS_IMG_WIDTH, CMS_IMG_HEIGHT, $_FILES['img_big']['tmp_name'], $_FILES['img_big']['type'], $filename_m, 'jpg', true, false, false);
                            $img_big = true;
                        }
                        
                        $wynik=mysql_query ("UPDATE `$category_db` SET `img_small` = '$img_small', `img_big` = '$img_big' WHERE `id`= '$id'");
                } else {
                        unset($id);
                        $t['message'] = LANG_WPIS_KOMUNIKAT4;
                }

                $continue = true;
                $action = 'edit';
                break;

            case 'delete':
                $id_s = escape_data($_GET['id_s']);
                $t['record'] = generuj_rekord($id_s);
                $sql = "DELETE FROM `$category_db` WHERE `id`= '$id_s' AND `section` = '$active_category' LIMIT 1";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT5;
                else $t['message'] = LANG_WPIS_KOMUNIKAT6;
                $continue = true;
                $action = 'edit';
                break;

            case 'delete-img_big':
                $id = (int)escape_data($_GET['id']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `img_big`= '0' WHERE `id`= '$id' AND `section` = '$active_category' LIMIT 1");
                $filename_m = "../images/threads/{$id}_b.jpg";
                @unlink($filename_m);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT7;
                else $t['message'] = LANG_WPIS_KOMUNIKAT8;
                $continue = true;
                $action = 'edit';
                break;

            case 'delete-img_small':
                $id = (int)escape_data($_GET['id']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `img_small`= '0' WHERE `id`= '$id' AND `section` = '$active_category' LIMIT 1");
                $filename = "../images/threads/$id.jpg";
                @unlink($filename);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT9;
                else $t['message'] = LANG_WPIS_KOMUNIKAT10;
                $continue = true;
                $action = 'edit';
                break;

            case 'turnOn':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '1' WHERE `id`= '$id_s' AND `section` = '$active_category' LIMIT 1");
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT11;
                else $t['message'] = LANG_WPIS_KOMUNIKAT12;
                $continue = true;
                $action = 'edit';
                break;
            case 'turnOff':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '0' WHERE `id`= '$id_s' AND `section` = '$active_category' LIMIT 1");
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT13;
                else $t['message'] = LANG_WPIS_KOMUNIKAT14;
                $continue = true;
                $action = 'edit';
                break;
            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>