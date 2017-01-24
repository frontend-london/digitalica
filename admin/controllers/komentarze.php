<?
    global $category, $active_category, $default_action, $category_db, $category_db2;
    $active_category = SECTION_KOMENTARZE;
    $category = 'komentarze';
    
    if(empty($_SESSION['sections'][$active_category])) { // autoryzacja
        include('controllers/limit.php');
        exit();
    }

    
    $category_db = 'comments';
    $category_db2= 'threads';
    $category_db3= 'sections';
    $default_action = 'edit';

    function generuj_menu() {
            global $category_db, $category_db2;
            $sql = "SELECT DISTINCT t.id, t.title, t.section FROM `$category_db2` t, `$category_db` c WHERE c.validated = '0' AND c.thread = t.id ORDER BY `section` ASC, `title` ASC";
            $wynik = mysql_query($sql);
            $menu = array();
            while($w = mysql_fetch_array($wynik)) {
                    $section = $w['section'];
                    $menu[$section][] = $w;
            }
            return $menu;
    }

    function generuj_menu_all() {
            global $category_db, $category_db2;
            $sql = "SELECT DISTINCT t.id, t.title, t.section FROM `$category_db2` t, `$category_db` c WHERE c.thread = t.id ORDER BY `section` ASC, `title` ASC";
            $wynik = mysql_query($sql);
            $menu = array();
            while($w = mysql_fetch_array($wynik)) {
                    $section = $w['section'];
                    $menu[$section][] = $w;
            }
            return $menu;
    }

    

    function generuj_rekord($id='') {
        global $category_db, $category_db2;

        if(empty($id)) {
            $sql = "SELECT DISTINCT t.id FROM `$category_db2` t, `$category_db` c WHERE c.validated = '0' AND c.thread = t.id ORDER BY `section` ASC, `title` ASC LIMIT 1";
            $wynik = mysql_query($sql);
            if($w = mysql_fetch_array($wynik)) {
                    $id = $w['id'];
            }
        }

        if(!empty($id)) {
            $sql2 = "SELECT  `id`, `date`, `name`, `email`, `comment`, `thread` FROM `$category_db` WHERE `thread` = '$id' AND `validated` = '0'";
            $wynik2 = mysql_query($sql2);
            while($w2 = mysql_fetch_array($wynik2)) {
                    $comments[] = $w2;
            }
        } else {
            $comments = '';
        }

        return $comments;
    }

    function generuj_rekord_all($id='') {
        global $category_db, $category_db2;

        if(empty($id)) {
            $sql = "SELECT DISTINCT t.id FROM `$category_db2` t, `$category_db` c WHERE c.thread = t.id ORDER BY `section` ASC, `title` ASC LIMIT 1";
            $wynik = mysql_query($sql);
            if($w = mysql_fetch_array($wynik)) {
                    $id = $w['id'];
            }
        }

        if(!empty($id)) {
            $sql2 = "SELECT  `id`, `date`, `name`, `email`, `comment`, `thread`, `validated` FROM `$category_db` WHERE `thread` = '$id'";
            $wynik2 = mysql_query($sql2);
            while($w2 = mysql_fetch_array($wynik2)) {
                    $comments[] = $w2;
            }
        } else {
            $comments = '';
        }

        return $comments;
    }

    function generuj_watek($id) {
        global $category_db2, $category_db3;
        $sql = "SELECT t.id, t.title, t.url, t.short_text, s.url s_url FROM `$category_db2` t, `$category_db3` s WHERE s.id = t.section AND t.id = '$id' LIMIT 1";
        $wynik = mysql_query($sql);
        $w = mysql_fetch_array($wynik);
        return $w;
    }
    
    if(empty($action)) $action = $_POST['action'];
    if(empty($action)) $action = $_GET['action'];
    if(empty($action)) $action = $default_action;

    $continue = true;
    
    while($continue):
        $continue = false;

        switch($action):
            case 'edit':
                $t['show_all'] = false;
                $t['url_all'] = '';
                $t['menu'] = generuj_menu();
                if(empty($id)) $id = (int)$_GET['id'];
                $t['comments'] = generuj_rekord($id);
                if(!empty($t['comments'][0]['thread'])) {
                    $id = $t['comments'][0]['thread'];
                    $t['thread'] = generuj_watek($id);
                } elseif($id) {
                    $t['thread'] = generuj_watek($id);
                    $t['message2'] = LANG_KOMENTARZE_KOMUNIKAT8;
                } else {
                    $t['message'] = LANG_KOMENTARZE_KOMUNIKAT9;
                }
                
                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;
            case 'edit-all':
                $t['show_all'] = true;
                $t['url_all'] = '-all';
                $t['menu'] = generuj_menu_all();
                if(empty($id)) $id = (int)$_GET['id'];
                $t['comments'] = generuj_rekord_all($id);

                if(!empty($t['comments'][0]['thread'])) {
                    $id = $t['comments'][0]['thread'];
                    $t['thread'] = generuj_watek($id);
                } elseif($id) {
                    $t['thread'] = generuj_watek($id);
                    $t['message2'] = LANG_KOMENTARZE_KOMUNIKAT10;
                } else {
                    $t['message'] = LANG_KOMENTARZE_KOMUNIKAT11;
                }

                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;
            case 'delete':
                $id_s = (int)escape_data($_GET['id_s']);
                $sql = "DELETE FROM `$category_db` WHERE `id`= '$id_s' LIMIT 1";
                $wynik=mysql_query ($sql);
                $continue = true;
                $action = 'edit';
                break;
            case 'delete-all':
                $id_s = (int)escape_data($_GET['id_s']);
                $sql = "DELETE FROM `$category_db` WHERE `id`= '$id_s' LIMIT 1";
                $wynik=mysql_query ($sql);

                if(empty($id)) $id = (int)$_GET['id'];
                $sql = "SELECT COUNT(*) ilosc FROM `$category_db` WHERE `thread` = '$id' AND `validated` = '1'";
                $wynik = mysql_query($sql);
                if($w = mysql_fetch_array($wynik)) {
                    $ilosc = $w['ilosc'];
                    $wynik=mysql_query ("UPDATE `$category_db2` SET `comments`= '$ilosc' WHERE `id`= '$id' LIMIT 1");
                }

                $continue = true;
                $action = 'edit-all';
                break;
            case 'accept':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `validated`= '1' WHERE `id`= '$id_s' LIMIT 1");

                if(empty($id)) $id = (int)$_GET['id'];
                $sql = "SELECT COUNT(*) ilosc FROM `$category_db` WHERE `thread` = '$id' AND `validated` = '1'";
                $wynik = mysql_query($sql);
                if($w = mysql_fetch_array($wynik)) {
                    $ilosc = $w['ilosc'];
                    $wynik=mysql_query ("UPDATE `$category_db2` SET `comments`= '$ilosc' WHERE `id`= '$id' LIMIT 1");
                }
                
                $continue = true;
                $action = 'edit';
                break;
            case 'accept-all':
                $id_s = (int)escape_data($_GET['id_s']);
                $wynik=mysql_query ("UPDATE `$category_db` SET `validated`= '1' WHERE `id`= '$id_s' LIMIT 1");

                if(empty($id)) $id = (int)$_GET['id'];
                $sql = "SELECT COUNT(*) ilosc FROM `$category_db` WHERE `thread` = '$id' AND `validated` = '1'";
                $wynik = mysql_query($sql);
                if($w = mysql_fetch_array($wynik)) {
                    $ilosc = $w['ilosc'];
                    $wynik=mysql_query ("UPDATE `$category_db2` SET `comments`= '$ilosc' WHERE `id`= '$id' LIMIT 1");
                }

                $continue = true;
                $action = 'edit-all';
                break;
            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>