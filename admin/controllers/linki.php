<?
    global $category, $active_category, $default_action, $category_db, $category_db2;
    $active_category = SECTION_LINKI;
    $category = 'linki';
    
    if(empty($_SESSION['sections'][$active_category])) { // autoryzacja
        include('controllers/limit.php');
        exit();
    }

    
    $category_db = 'urls';
    $default_action = 'edit';

    function generuj_rekord($history = false, $url = '') {
        global $category_db, $category_db2, $active_category;

        if(!empty($url)) {
            $sql = "SELECT id, DATE(date) date, url, nick, email, deleted FROM `$category_db` WHERE `url` LIKE '%$url%' ORDER BY `date` DESC";
        } elseif($history) {
            $sql = "SELECT id, DATE(date) date, url, nick, email, deleted FROM `$category_db` ORDER BY `date` DESC";
        } else {
            $sql = "SELECT id, DATE(date) date, url, nick, email, deleted FROM `$category_db` WHERE `deleted` = '0' ORDER BY `date` DESC";
        }
        $wynik = mysql_query($sql);
        while($w = mysql_fetch_array($wynik)) {
            if((substr($w['url'],0,7)!='http://') && (substr($w['url'],0,8)!='https://') && (substr($w['url'],0,6)!='ftp://')) {
                $w['url'] = 'http://'.$w['url'];
            }
            $record[] = $w;
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
                $t['record'] = generuj_rekord();
                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;

            case 'delete':
                $id = (int)escape_data($_GET['id']);
                //$sql = "DELETE FROM `$category_db` WHERE `id`= '$id' LIMIT 1";
                $sql = "UPDATE `$category_db` SET `deleted` = '1' WHERE `id` = '$id' LIMIT 1";
                $wynik=mysql_query ($sql);
                if($wynik) $t['message'] = LANG_LINKI_KOMUNIKAT2;
                else $t['message'] = LANG_LINKI_KOMUNIKAT3;
                $continue = true;
                $action = 'edit';
                break;

            case 'search':
                $url = escape_data($_GET['url']);
                if(empty($url)) $url = escape_data($_POST['url']);
                if(substr($url,-1)=='/') $url = substr($url, 0, -1);
                if(substr($url,0,7)=='http://') $url = substr($url, 7);
                elseif(substr($url,0,8)=='https://') $url = substr($url, 8);
                elseif(substr($url,0,6)=='ftp://') $url = substr($url, 6);
                if(substr($url,0,4)=='www.') $url = substr($url, 4);
                $t['url'] = $url;
                if(empty($url)) {
                    $t['message'] = LANG_LINKI_HISTORIA_WSZYSTKICH;
                } else {
                    $t['message'] = LANG_LINKI_HISTORIA_LINKA.$url;
                }
                $t['record'] = generuj_rekord(true, $url);
                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;

            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>