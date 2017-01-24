<?
    global $category, $active_category, $default_action, $category_db, $category_db2;
    $active_category = SECTION_KONTA;
    $category = 'konta';
    
    if(empty($_SESSION['sections'][$active_category])) { // autoryzacja
        include('controllers/limit.php');
        exit();
    }

    
    $category_db = 'users';
    $category_db2= 'privileges';
    $category_db3= 'sections';
    $default_action = 'edit';
    $section_amount = SECTION_AMOUNT;

    function generuj_menu() {
            global $category_db, $active_category;
            $sql = "SELECT id, name, active FROM `$category_db` ORDER BY `name` ASC";
            $wynik = mysql_query($sql);
            $menu = array();
            while($w = mysql_fetch_array($wynik)) {
                    $menu[] = $w;
            }
            return $menu;
    }

    

    function generuj_rekord($id='') {
        global $category_db, $category_db2, $category_db3, $active_category, $section_amount;

        if(!empty($id)) {
            $sql = "SELECT id, name, login, email FROM `$category_db` WHERE `id` = '$id' LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        } else {
            $w = false;

        }

        if(!$w) {
            $id = $_SESSION['id'];
            $sql = "SELECT id, name, login, email FROM `$category_db` WHERE `id` = '$id' LIMIT 1";
            $wynik = mysql_query($sql);
            $w = mysql_fetch_array($wynik);
        }



        $sql2 = "SELECT `section` FROM `$category_db2` WHERE `user`='$id' AND `active` = 1";
        $wynik2 = mysql_query($sql2);
        $w['sections'] = array();
        $default_controller = '';
        while($w2 = mysql_fetch_array($wynik2)) {
            $w['sections'][$w2['section']] = true;
        }

        return $w;
    }

    function generuj_kategorie() {
        global $category_db3, $section_amount;
        $sql3 = "SELECT * FROM `$category_db3` WHERE `id`<='$section_amount'";
        $wynik3 = mysql_query($sql3);
        $w = array();
        while($w3 = mysql_fetch_array($wynik3)) {
            $w[] = $w3;
        }

        return $w;
    }
    
    if(empty($action) && isset($_POST['action'])) $action = $_POST['action'];
    if(empty($action) && isset($_GET['action'])) $action = $_GET['action'];
    if(empty($action)) $action = $default_action;

    $continue = true;
    
    while($continue):
        $continue = false;

        switch($action):
            case 'edit':
                $t['menu'] = generuj_menu();
                if(empty($id) && isset($_GET['id'])) $id = (int)$_GET['id']; else $id = 0;
                $t['record'] = generuj_rekord($id);
                $t['record']['all_sections'] = generuj_kategorie();
                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;

            case 'edit-save':
                $id = escape_data($_POST['id']);
                $name = escape_data($_POST['name']);
                $login = escape_data($_POST['login']);
                $email = escape_data($_POST['email']);
                $wynik_multiple = true;

                $sql = "UPDATE `$category_db` SET `name`= '$name', `login`= '$login', `email` = '$email', `author` = '{$_SESSION['id']}' WHERE `id`= '$id'";
                $wynik=mysql_query ($sql);
                if(!$wynik) $wynik_multiple = false;
                for($i=1;$i<=$section_amount;$i++) {
                    ($_POST['section_'.$i]=='on')?$active = true:$active = false;

                    $sql = "SELECT * FROM `$category_db2` WHERE `user`= '$id' AND `section`= '$i'";
                    $wynik = mysql_query($sql);
                    $w = mysql_fetch_array($wynik);
                    if($w) {
                        $sql2= "UPDATE `$category_db2` SET `active`= '$active' WHERE `user`= '$id' AND `section`= '$i'";
                    } else {
                        $sql2="INSERT INTO `$category_db2`(`user`,`section`, `active`) VALUES('$id', '$i', '$active')";
                    }
                    $wynik2=mysql_query ($sql2);
                    if(!$wynik2) $wynik_multiple = false;
                }
                if($wynik_multiple) {
                    $t['message'] = LANG_KONTO_KOMUNIKAT;
                    if($id==$_SESSION['id']) generuj_menu_top();
                }
                else $t['message'] = LANG_KONTO_KOMUNIKAT2;
                $continue = true;
                $action = 'edit';
                break;

            case 'add':
                $t['record']['id'] =  'new';
                $t['menu'] = generuj_menu();
                $t['record']['all_sections'] = generuj_kategorie();
                $t['action'] = 'add-save';
                include("templates/$category.phtml");
                break;

            case 'add-save':
                $name = escape_data($_POST['name']);
                $login = escape_data($_POST['login']);
                $email = escape_data($_POST['email']);

                $wynik=mysql_query("INSERT INTO `$category_db`(`login`,`name`, `email`, `author`) VALUES(
                                                    '$login', '$name', '$email', '{$_SESSION['id']}')");
                if($wynik) {
                    $id = mysql_insert_id();
                    $t['message'] = LANG_KONTO_KOMUNIKAT3;

                    for($i=1;$i<=$section_amount;$i++) {
                        ($_POST['section_'.$i]=='on')?$active = true:$active = false;
                        $wynik=mysql_query("INSERT INTO `$category_db2`(`user`,`section`, `active`) VALUES(
                                                            '$id', '$i', '$active')");
                    }
                } else {
                    unset($id);
                    $t['message'] = LANG_KONTO_KOMUNIKAT4;
                }

                $continue = true;
                $action = 'edit';
                break;

            case 'delete':
                $id_s = (int)escape_data($_GET['id_s']);
                $t['record'] = generuj_rekord($id_s);
                $sql = "DELETE FROM `$category_db` WHERE `id`= '$id_s' LIMIT 1";
                $wynik=mysql_query ($sql);
                $sql = "DELETE FROM `$category_db2` WHERE `user`= '$id_s'";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_KONTO_KOMUNIKAT5;
                else $t['message'] = LANG_KONTO_KOMUNIKAT6;
                $continue = true;
                $action = 'edit';
                break;

            case 'turnOn':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '1' WHERE `id`= '$id_s' LIMIT 1");
                if($wynik) $t['message'] = LANG_KONTO_KOMUNIKAT7;
                else $t['message'] = LANG_KONTO_KOMUNIKAT8;
                $continue = true;
                $action = 'edit';
                break;
            case 'turnOff':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `active`= '0' WHERE `id`= '$id_s' LIMIT 1");
                if($wynik) $t['message'] = LANG_KONTO_KOMUNIKAT9;
                else $t['message'] = LANG_KONTO_KOMUNIKAT10;
                $continue = true;
                $action = 'edit';
                break;
            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>