<?
    global $category, $active_category;
    $active_category = SECTION_WYWIADY;
    $category = 'wywiady';
    if(empty($_SESSION['sections'][$active_category])) {
        include('controllers/limit.php');
        exit();
    }
    
    
    $category_db = 'interviews';
    $category_db2 = 'interviews_content';
    $default_action = 'edit';
	
	

    function generuj_menu() {
            global $category_db, $active_category;
            $sql = "SELECT * FROM `$category_db` ORDER BY `order` DESC, `id` DESC";
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
            $sql = "SELECT * FROM `$category_db` WHERE `id` = '$id' LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        } else {
            $w = false;
        }

        if(!$w) {
            $sql = "SELECT * FROM `$category_db` ORDER BY `order` DESC, `id` DESC LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        }
        
        $id = $w['id'];
        $sql = "SELECT * FROM `$category_db2` WHERE `id_interview` = '$id' ORDER BY `id` ASC";
        $wynik = mysql_query($sql);
        $content = array();
        while($w2 = mysql_fetch_array($wynik)) {
                $content[] = $w2;
        }
        
        $w['content'] = $content;

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
                $url = generate_url($title, $category_db, 0, $id);
                $short_text = escape_data($_POST['short_text']);
                $beginning = escape_data($_POST['beginning']);
                $ending = escape_data($_POST['ending']);
                $img_small = escape_data($_POST['is_img_small']);
                $img_big = escape_data($_POST['is_img_big']);
                /* TWITTER START */
//                $tweet = '.. - '.ADRES.'n/'.$id;
//                $tweet_len = strlen($tweet);
//                $tweet = substr($title, 0, 140-$tweet_len).$tweet;
//                post_tweet($tweet);                
                /* TWITTER STOP */
                if(!empty($_FILES['img_small']['name'])) {
                    $filename = "../images/interviews/$id.jpg";
                    @unlink($filename);
                    stworz_miniature(CMS_TH_WIDTH, CMS_TH_HEIGHT, $_FILES['img_small']['tmp_name'], $_FILES['img_small']['type'], $filename, 'jpg', true, true, true);
                    $img_small = true;
                }
                if(!empty($_FILES['img_big']['name'])) {
                    $filename_m = "../images/interviews/{$id}_b.jpg";
                    @unlink($filename_m);
                    stworz_miniature(CMS_IMG_WIDTH, CMS_IMG_HEIGHT, $_FILES['img_big']['tmp_name'], $_FILES['img_big']['type'], $filename_m, 'jpg', true, false, false);
                    $img_big = true;
                }
                $sql = "UPDATE `$category_db` SET `title`= '$title', `url`= '$url', `short_text` = '$short_text', `beginning` = '$beginning', `ending` = '$ending', `img_small` = '$img_small', `img_big` = '$img_big' WHERE `id`= '$id'";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT;
                else $t['message'] = LANG_WPIS_KOMUNIKAT2;
                
                
                
                /* CONTENT */
                $sql2 = "SELECT * FROM `$category_db2` WHERE `id_interview` = '$id' ORDER BY `id` DESC";
                $wynik2 = mysql_query($sql2);
                while($w2 = mysql_fetch_array($wynik2)) {
                    $id_interview = $w2['id'];
                    $question = escape_data($_POST['content_question'][$id_interview]);
                    $answer = escape_data($_POST['content_answer'][$id_interview]);
                    if(!empty($question) && !empty($answer)) {
                        $sql = "UPDATE `$category_db2` SET `question`= '$question', `answer`= '$answer' WHERE `id`= '$id_interview'";
                    } else {
                        $sql = "DELETE FROM `$category_db2` WHERE `id`= '$id_interview' LIMIT 1";
                    }
                    $wynik=mysql_query ($sql);
                    
                }

                if(!empty($_POST['content_question']['new'])) {
                    $question = escape_data($_POST['content_question']['new']);
                    $answer = escape_data($_POST['content_answer']['new']);
                    $sql = "INSERT INTO `$category_db2`(`id_interview`, `question`, `answer`) VALUES(
                                                        '$id', '$question', '$answer')";
                    $wynik=mysql_query($sql);
                    $id_interview = mysql_insert_id();
                }
                
                
                
                
                $continue = true;
                $action = 'edit';
                break;

            case 'add':
                $t['record']['id'] =  'new';
                $t['record']['title'] =  '';
                $t['record']['beginning'] =  '';
                $t['record']['ending'] =  '';
                $t['record']['short_text'] =  '';
                $t['record']['img_small'] =  false;
                $t['record']['img_big'] =  false;
                $t['menu'] = generuj_menu();
                $t['action'] = 'add-save';
                include("templates/$category.phtml");
                break;

            case 'add-save':
                $id = $_POST['id'];
                $title = escape_data($_POST['title']);
                $url = generate_url($title, $category_db);
                $order = generuj_order($category_db);
                $short_text = escape_data($_POST['short_text']);
                $beginning = escape_data($_POST['beginning']);
                $ending = escape_data($_POST['ending']);
                $img_small = false;
                $img_big = false;

                $wynik=mysql_query("INSERT INTO `$category_db`(`order`, `title`, `url`, `short_text`, `beginning`, `ending`, `img_small`, `img_big`) VALUES(
                                                    '$order', '$title', '$url', '$short_text', '$beginning', '$ending', '$img_small', '$img_big')");
                if($wynik) {
                        $id = mysql_insert_id();
                        /* TWITTER START */
//                        $tweet = '.. - '.ADRES.'n/'.$id;
//                        $tweet_len = strlen($tweet);
//                        $tweet = substr($title, 0, 140-$tweet_len).$tweet;
//                        post_tweet($tweet);
                        /* TWITTER STOP */
                        $t['message'] = LANG_WPIS_KOMUNIKAT3;

                        if(!empty($_FILES['img_small']['name'])) {
                            $filename = "../images/interviews/$id.jpg";
                            @unlink($filename);
                            stworz_miniature(CMS_TH_WIDTH, CMS_TH_HEIGHT, $_FILES['img_small']['tmp_name'], $_FILES['img_small']['type'], $filename, 'jpg', true, true, true);
                            $img_small = true;
                        }

                        if(!empty($_FILES['img_big']['name'])) {
                            $filename_m = "../images/interviews/{$id}_b.jpg";
                            @unlink($filename_m);
                            stworz_miniature(CMS_IMG_WIDTH, CMS_IMG_HEIGHT, $_FILES['img_big']['tmp_name'], $_FILES['img_big']['type'], $filename_m, 'jpg', true, false, false);
                            $img_big = true;
                        }
                        
                        $wynik=mysql_query ("UPDATE `$category_db` SET `img_small` = '$img_small', `img_big` = '$img_big' WHERE `id`= '$id'");
                        
                        if(!empty($_POST['content_question']['new'])) {
                            $question = escape_data($_POST['content_question']['new']);
                            $answer = escape_data($_POST['content_answer']['new']);
                            $sql = "INSERT INTO `$category_db2`(`id_interview`, `question`, `answer`) VALUES(
                                                                '$id', '$question', '$answer')";
                            $wynik=mysql_query($sql);
                            $id_interview = mysql_insert_id();
                        }
                        
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
                $sql = "DELETE FROM `$category_db` WHERE `id`= '$id_s' LIMIT 1";
                $wynik=mysql_query ($sql);
                $sql2 = "DELETE FROM `$category_db2` WHERE `id_interview`= '$id_s'";
                $wynik2=mysql_query ($sql2);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT5;
                else $t['message'] = LANG_WPIS_KOMUNIKAT6;
                $continue = true;
                $action = 'edit';
                break;

            case 'delete-img_big':
                $id = (int)escape_data($_GET['id']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `img_big`= '0' WHERE `id`= '$id' LIMIT 1");
                $filename_m = "../images/interviews/{$id}_b.jpg";
                @unlink($filename_m);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT7;
                else $t['message'] = LANG_WPIS_KOMUNIKAT8;
                $continue = true;
                $action = 'edit';
                break;

            case 'delete-img_small':
                $id = (int)escape_data($_GET['id']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `img_small`= '0' WHERE `id`= '$id' LIMIT 1");
                $filename = "../images/interviews/$id.jpg";
                @unlink($filename);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT9;
                else $t['message'] = LANG_WPIS_KOMUNIKAT10;
                $continue = true;
                $action = 'edit';
                break;

            case 'turnOn':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '1' WHERE `id`= '$id_s' LIMIT 1");
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT11;
                else $t['message'] = LANG_WPIS_KOMUNIKAT12;
                $continue = true;
                $action = 'edit';
                break;
            case 'turnOff':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '0' WHERE `id`= '$id_s' LIMIT 1");
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT13;
                else $t['message'] = LANG_WPIS_KOMUNIKAT14;
                $continue = true;
                $action = 'edit';
                break;
            case 'swap':
                if(isset($_GET['id1']) && isset($_GET['id2'])) {
                    $id1 = $_GET['id1'];
                    $id2 = $_GET['id2'];
                    $wynik = mysql_query("SELECT * FROM `$category_db` WHERE `id` = '$id1' OR `id` = '$id2' LIMIT 2");
                    if($w = mysql_fetch_array($wynik)) {
                        $id1 = $w['id'];
                        $order1 = $w['order'];
                    }

                    if($w = mysql_fetch_array($wynik)) {
                        $id2 = $w['id'];
                        $order2 = $w['order'];
                    }

                    if(!empty($order1) && !empty($order2)) {
                        $wynik=mysql_query ("UPDATE `$category_db` SET `order`= $order1 WHERE id= $id2");
                        $wynik=mysql_query ("UPDATE `$category_db` SET `order`= $order2 WHERE id= $id1");
                    }
                }

                $continue = true;
                $action = 'edit';
                break;
            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;    

?>