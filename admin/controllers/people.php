<?

    global $category, $default_action, $category_db, $category_db2, $active_category;
    $active_category = SECTION_PEOPLE;
    $category = 'people';
    $category_db = 'people';
    $category_db2 = '';
    $default_action = 'edit';
	

    if(empty($_SESSION['sections'][$active_category])) { // autoryzacja
        include('controllers/limit.php');
        exit();
    }

    function generuj_menu() {
            global $category_db;
            $sql = "SELECT * FROM `$category_db` ORDER BY `order` ASC";
            $wynik = mysql_query($sql);
            $menu = array();
            while($w = mysql_fetch_array($wynik)) {
                    $menu[] = $w;
            }
            return $menu;
    }

    

    function generuj_rekord($id='') {
        global $category_db;

        if(!empty($id)) {
            $sql = "SELECT * FROM `$category_db` WHERE `id` = '$id' LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        } else {
            $w = false;

        }

        if(!$w) {
            $sql = "SELECT * FROM `$category_db` ORDER BY `order` ASC LIMIT 1";
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
                if($t['record']) {
                    $t['action'] = 'edit-save';
                } else {
                    $t['action'] = 'add-save';
                }
                include("templates/$category.phtml");
                break;    

            case 'edit-save':
                $id = escape_data($_POST['id']);
                $title = escape_data($_POST['title']);
                $long_text = escape_data($_POST['long_text']);
                $img_big = escape_data($_POST['is_img_big']);
                if(!empty($_FILES['img_big']['name'])) {
                    $filename_m = "../images/people/{$id}.jpg";
                    @unlink($filename_m);
                    stworz_miniature(CMS_PEOPLE_WIDTH, CMS_PEOPLE_HEIGHT, $_FILES['img_big']['tmp_name'], $_FILES['img_big']['type'], $filename_m, 'jpg', true, true, true);
                    $img_big = true;
                }
                $sql = "UPDATE `$category_db` SET `title`= '$title', `long_text` = '$long_text', `img_big` = '$img_big', `author` = '{$_SESSION['id']}' WHERE `id`= '$id'";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT;
                else $t['message'] = LANG_WPIS_KOMUNIKAT2;
                $continue = true;
                $action = 'edit';
                break;


            case 'add':
                $t['record']['id'] =  'new';
                $t['record']['img_big'] =  false;
                $t['menu'] = generuj_menu();
                $t['action'] = 'add-save';
                include("templates/$category.phtml");
                break;

            case 'add-save':
                $id = $_POST['id'];
                $title = escape_data($_POST['title']);
                $long_text = escape_data($_POST['long_text']);
                $img_big = false;
                $order = generuj_order($category_db);
                $wynik=mysql_query("INSERT INTO `$category_db`(`title`, `long_text`, `author`, `img_big`, `order`) VALUES(
                                                    '$title', '$long_text', '{$_SESSION['id']}', '$img_big', '$order')");
                if($wynik) {
                        $id = mysql_insert_id();
                        $t['message'] = LANG_WPIS_KOMUNIKAT3;

                        if(!empty($_FILES['img_big']['name'])) {
                            $filename_m = "../images/people/{$id}.jpg";
                            @unlink($filename_m);
                            stworz_miniature(CMS_PEOPLE_WIDTH, CMS_PEOPLE_HEIGHT, $_FILES['img_big']['tmp_name'], $_FILES['img_big']['type'], $filename_m, 'jpg', true, true, true);
                            $img_big = true;
                        }
                        
                        $wynik=mysql_query ("UPDATE `$category_db` SET `img_big` = '$img_big' WHERE `id`= '$id'");
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
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT5;
                else $t['message'] = LANG_WPIS_KOMUNIKAT6;
                $continue = true;
                $action = 'edit';
                break;


            case 'delete-img_big':
                $id = (int)escape_data($_GET['id']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `img_big`= '0' WHERE `id`= '$id' LIMIT 1");
                $filename_m = "../images/people/{$id}.jpg";
                @unlink($filename_m);
                if($wynik) $t['message'] = LANG_WPIS_KOMUNIKAT7;
                else $t['message'] = LANG_WPIS_KOMUNIKAT8;
                $continue = true;
                $action = 'edit';
                break;

            case 'turnOn':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '1' WHERE `id`= '$id_s'  LIMIT 1");
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