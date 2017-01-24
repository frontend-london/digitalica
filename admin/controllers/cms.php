<?
    global $category, $default_action;
    $category = 'cms';
    $default_action = 'login';

    if(empty($action) && isset($_POST['action'])) $action = $_POST['action'];
    if(empty($action) && isset($_GET['action'])) $action = $_GET['action'];
    if(empty($action)) $action = $default_action;

    $continue = true;

    while($continue):
        $continue = false;

        switch($action):
            case 'login':
                $username = escape_data(isset($_POST['username'])?$_POST['username']:'');
                $password = escape_data(isset($_POST['password'])?$_POST['password']:'');
                $password_md5 = md5($password);

                if(!zalogowany() && !empty($username) && !empty($password)) {

                    $category_db = 'users';
                    $sql = "SELECT * FROM `$category_db` WHERE `login` = '$username' AND `pass` = '$password_md5' AND `active` = '1' LIMIT 1";
                    $wynik = mysql_query($sql);
                    $w = mysql_fetch_array($wynik);
                    if($w) {
                        $_SESSION['id']=$w['id'];
                        $_SESSION['login']=$w['login'];
                        $_SESSION['lang']=$w['lang'];
                        $_SESSION['name']=$w['name'];
                        $_SESSION['pass_session']=$w['pass_session'];
                        $_SESSION['zalogowany'] = true;
                    } else {
                        $t['message2'] = LANG_LOGIN_ERR;
                        $_SESSION['id']='';
                        $_SESSION['login']='';
                        $_SESSION['name']='';
                        $_SESSION['pass_session']='';
                        $_SESSION['zalogowany']=false;
                    }

                }
                if(!(zalogowany())) {
                    $t['action'] = SCRIPT;
                        include('templates/login.phtml');
                    } else {
                        include_default();
                    }
                break;
            case 'logout':
                $_SESSION['id']='';
                $_SESSION['login']='';
                $_SESSION['name']='';
                $_SESSION['pass_session']='';
                $_SESSION['zalogowany']=false;
                include("templates/logout.phtml");
                break;
            case 'recover':
                $login = escape_data($_GET['l']);
                $password_recover = escape_data($_GET['r']);
                $error_message = LANG_LOGIN_ERR2;
                $category_db = 'users';

                if(!empty($login) && !empty($password_recover)) { // step 1
                    $sql = "SELECT * FROM `$category_db` WHERE `login` = '$login' AND `pass_recover` = '$password_recover' AND `active` = '1' LIMIT 1";
                    $wynik = mysql_query($sql);
                    $w = mysql_fetch_array($wynik);
                    if($w) {
                        $t['username'] = $w['login'];
                        $t['password_recover'] = $password_recover;
                    } else {
                        $t['message'] = $error_message;
                    }
                                        
                } elseif(!empty($_POST['continue']) ) { // step 2
                    
                    $username = escape_data($_POST['username']);
                    $password = escape_data($_POST['password']);
                    $password2 = escape_data($_POST['password2']);
                    $password_recover = escape_data($_POST['password_recover']);

                    $t['username'] = $username;
                    $t['password_recover'] = $password_recover;
                    
                    if(empty($username) ||empty($password) || empty($password2) || empty($password_recover)) {
                            $t['message2'] = LANG_LOGIN_ERR3;
                    } elseif($password!=$password2) {
                        $t['message2'] = LANG_LOGIN_ERR4;
                    } else {
                        $sql = "SELECT * FROM `$category_db` WHERE `login` = '$username' AND `pass_recover` = '$password_recover' AND `active` = '1' LIMIT 1";
                        $wynik = mysql_query($sql);
                        $w = mysql_fetch_array($wynik);
                        if($w) {
                            $password_md5 = md5($password);
                            $pass_session = generate_random_string(32);
                            $sql = "UPDATE `$category_db` SET `pass`= '$password_md5', `pass_recover`= NULL, `pass_session`= '$pass_session' WHERE `login` = '$username' LIMIT 1";
                            $wynik=mysql_query ($sql);

                            $_SESSION['username']='';
                            $_SESSION['zalogowany']=false;

                            $t['message'] = LANG_LOGIN_OK;

                        } else {
                            $t['message'] = $error_message;
                        }
                    }
                } else {
                    $t['message'] = $error_message;
                }
                include("templates/recover.phtml");
                break;
            case 'remind':
                $email = escape_data($_POST['email']);
                $category_db = 'users';
                if (!empty($email)) {
                    $sql = "SELECT * FROM `$category_db` WHERE `email` = '$email' AND `active` = '1' LIMIT 1";
                    $wynik = mysql_query($sql);
                    $w = mysql_fetch_array($wynik);
                    if($w) {
                        $login = $w['login'];
                        $email = $w['email'];
                        $pass_recover = generate_random_string(24);
                        $sql = "UPDATE `$category_db` SET `pass_recover`= '$pass_recover' WHERE `email` = '$email' LIMIT 1";
                        $wynik=mysql_query ($sql);
                        
                        $t['message'] = LANG_LOGIN_OK2;

                        $wiadomosc = '
                            <html>
                            <head>
                              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                              <title>'.LANG_MAIL_TITLE.'</title>
                            </head>
                            <body>
                                <p>
                                    '.LANG_MAIL_CONTENT1.'<br>
                                    <a href="'.ADRES.SCRIPT."?category=$category&action=recover&l=$login&r=$pass_recover".'">'.ADRES.SCRIPT."?category=$category&action=recover&l=$login&r=$pass_recover".'</a><br><br>
                                    '.LANG_MAIL_CONTENT2.'
                                </p>
                            </body>
                            </html>
                        ';
                        $pass_recover = '';
                        mail_utf8($email,LANG_MAIL_TITLE, $wiadomosc, 'no-reply@digitalica.pl');
                    } else {
                        $t['message'] = LANG_MAIL_ERR;
                    }
                }


                include("templates/remind.phtml");
                break;
            case 'lang':
                switch_lang($_GET['lang']);
                redirect_default();
                break;
            default:
                $action = $default_action;
                $continue = true;
        endswitch;
    endwhile;



?>