<?
    global $category, $default_action, $category_db;
    $active_category = SECTION_BANERY;
    $category = 'banery';

    if(empty($_SESSION['sections'][$active_category])) { // autoryzacja
        include('controllers/limit.php');
        exit();
    }

    $category_db = 'banners';
    $default_action = 'edit';

    function generuj_galeria() {
        global $category_db;

        $sql = "SELECT * FROM `$category_db`  ORDER BY `id` DESC";
        $wynik = mysql_query($sql);
        $galeria = array();
        while($w = mysql_fetch_array($wynik)) {
                $galeria[] = $w;
        }
        return $galeria;
    }

    if(empty($action)) $action = $_POST['action'];
    if(empty($action)) $action = $_GET['action'];
    if(empty($action)) $action = $default_action;

    $continue = true;

    while($continue):
        $continue = false;

        switch($action):
            case 'edit':
                $t['galeria'] = generuj_galeria();
                $t['action'] = 'edit-save';
                include("templates/$category.phtml");
                break;

            case 'edit-save':
                /* GALERIA */
                $sql = "SELECT * FROM `$category_db` ORDER BY `id` DESC";
                $wynik = mysql_query($sql);
                while($w = mysql_fetch_array($wynik)) {
                    $id_gallery = $w['id'];
                    $url = escape_data($_POST['gallery-url'][$id_gallery]);
                    $sql2 = "UPDATE `$category_db` SET `url`= '$url' WHERE `id`= '$id_gallery'";
                    $wynik2=mysql_query($sql2);
                }

                if(!empty($_FILES['image-gallery']['name'])) {
                    $url = escape_data($_POST['gallery-url']['new']);
                    //$order = generuj_order($category_db);
                    $sql = "INSERT INTO `$category_db`(`url`) VALUES(
                                                        '$url')";
                    $wynik=mysql_query($sql);
                    $id_gallery = mysql_insert_id();

                    $filename = "../images/banners/$id_gallery.jpg";
                    @unlink($filename);
                    stworz_miniature(CMS_BANNER_WIDTH, CMS_BANNER_HEIGHT, $_FILES['image-gallery']['tmp_name'], $_FILES['image-gallery']['type'], $filename, 'jpg', true, true, true);
                }

                $t['message'] = 'Banery zostały poprawnie zmienione';

                $continue = true;
                $action = 'edit';
                break;

            case 'delete-gallery':
                $id_s = escape_data($_GET['id_s']);
                $wynik=mysql_query ("DELETE FROM `$category_db` WHERE `id`= '$id_s' LIMIT 1");
                if($wynik) $t['message'] = LANG_BANERY_USUN_OK;
                else $t['message'] = LANG_BANERY_USUN_ERR;
                $filename = "../images/gallery/$id_s.jpg";
                @unlink($filename);
                $continue = true;
                $action = 'edit';
                break;

            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>