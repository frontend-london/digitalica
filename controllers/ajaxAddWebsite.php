<?php
        if(!empty ($_POST['sent'])) {
            $name = unescape_data($_POST['name']);
            $email = unescape_data($_POST['email']);
            $url = unescape_data($_POST['url']);

            if(empty($name) || empty($email) || empty($url)) {
                $t['message'] = 'Wszystkie pola muszą zostać wypełnione';
            } elseif(!check_email($email)) {
                $t['message'] = 'Nieprawidłowy adres email';
            } else {
                $name = escape_data($_POST['name']);
                $email = escape_data($_POST['email']);
                $url = escape_data($_POST['url']);

                $category_db = 'urls';
                $select = "INSERT INTO `$category_db`(`url`,`nick`, `email`) VALUES(
                                    '$url', '$name', '$email')";
                $wynik=mysql_query($select);
                $t['message'] = 'Webstite has been put in the air!';
                $name = '';
                $email = '';
                $url = '';
            }
        }

?>
