<?
    global $category, $active_category, $default_action, $category_db, $category_db2;
    $active_category = SECTION_FORUM;
    $category = 'forum';
    
    if(empty($_SESSION['sections'][$active_category])) { // autoryzacja
        include('controllers/limit.php');
        exit();
    }

    
    $category_db = 'forum';
    $category_db2 = 'users';
    $default_action = 'add';

    function generuj_rekord($id='') {
        global $category_db, $category_db2, $active_category;

        $record['action'] = 'add-save';
        $sql = "SELECT f.id, f.date, f.user, f.comment, u.name FROM `$category_db` f, `$category_db2` u WHERE u.id = f.user ORDER BY f.`date` DESC";
        $wynik = mysql_query($sql);
        while($w = mysql_fetch_array($wynik)) {
            if(!empty($id) && $w['id']==$id && $w['user']==$_SESSION['id']) {
                $record['selected'] = $w;
                $record['action'] = 'edit-save';
            }

            $record['records'][] = $w;
        }

        return $record;
    }
    
    if(empty($action)) $action = $_POST['action'];
    if(empty($action)) $action = $_GET['action'];
    if(empty($action)) $action = $default_action;

    $continue = true;
    
    while($continue):
        $continue = false;

        switch($action):
            case 'edit':
                if(empty($id)) $id = (int)$_GET['id'];
                $t['record'] = generuj_rekord($id);
                $t['record']['id'] =  $id;
                $t['action'] = $t['record']['action'];
                include("templates/$category.phtml");
                break;

            case 'edit-save':
                $id = escape_data($_POST['id']);
                $comment = escape_data($_POST['comment']);

                $sql = "UPDATE `$category_db` SET `comment`= '$comment' WHERE `id`= '$id' AND `user`= '{$_SESSION['id']}'";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_KOMENTARZE_KOMUNIKAT2;
                else $t['message'] = LANG_KOMENTARZE_KOMUNIKAT3;
                $continue = true;
                $action = 'add';
                break;

            case 'add':
                $t['record'] = generuj_rekord();
                $t['record']['id'] =  'new';
                $t['action'] = 'add-save';
                include("templates/$category.phtml");
                break;

            case 'add-save':
                $id = $_POST['id'];
                $comment = escape_data($_POST['comment']);
                $wynik=mysql_query("INSERT INTO `$category_db`(`user`,`comment`) VALUES(
                                                    '{$_SESSION['id']}', '$comment')");
                if($wynik) {
                        $t['message'] = LANG_KOMENTARZE_KOMUNIKAT4;
                } else {
                        $t['message'] = LANG_KOMENTARZE_KOMUNIKAT5;
                }

                $continue = true;
                $action = 'add';
                break;

            case 'delete':
                $id = (int)escape_data($_GET['id']);
                $sql = "DELETE FROM `$category_db` WHERE `id`= '$id' AND `user`= '{$_SESSION['id']}' LIMIT 1";
                $wynik=mysql_query ($sql);
                //echo mysql_affected_rows (); exit();
                if($wynik && mysql_affected_rows ()==1) {
                    $t['message'] = LANG_KOMENTARZE_KOMUNIKAT6;
                } else $t['message'] = LANG_KOMENTARZE_KOMUNIKAT7;
                $continue = true;
                $action = 'edit';
                break;

            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>