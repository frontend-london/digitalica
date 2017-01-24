<?php
    global $category;
    
    if(!empty($url)) {
        $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE `url`= '$url' AND t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC LIMIT 1";
    } else {
        $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC LIMIT 1";
    }

    $wynik = mysql_query($select);
    if($w = mysql_fetch_array($wynik)) { // gdy jest prawidlowe wywolanie strony
        $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
        $thread = $w;

        $t['title'] = $thread['title'].' - '.$category;
        $t['description'] = strip_tags($thread['short_text']);

        /* komentarze wywalone
        $select2 = "SELECT date, name, comment FROM `comments` WHERE `thread`= '{$thread['id']}' AND `validated`='1' ORDER BY `date` DESC";
        $wynik2 = mysql_query($select2);
        while($w2 = mysql_fetch_array($wynik2)) {
            $w2['date'] = gmdate('d.m.Y G:i:s',strtotime($w2['date'].'+46 minutes'));
            $comments[] = $w2;
        }

        if(!empty ($_POST['sent'])) {
            $name = unescape_data($_POST['name']);
            $email = unescape_data($_POST['email']);
            $comment = unescape_data($_POST['comment']);

            if(empty($name) || empty($email) || empty($comment)) {
                $t['message'] = 'Wszystkie pola muszą zostać wypełnione';
            } elseif(!check_email($email)) {
                $t['message'] = 'Nieprawidłowy adres email';
            } else {
                $name = escape_data($_POST['name']);
                $email = escape_data($_POST['email']);
                $comment = escape_data_text(mynl2br(strip_tags($_POST['comment'])));
                $comment = wordwrap($comment, 100, "\n", true);
                
                $category_db = 'comments';
                $select = "INSERT INTO `$category_db`(`thread`,`name`, `email`, `comment`) VALUES(
                                    '{$thread['id']}', '$name', '$email', '$comment')";
                $wynik=mysql_query($select);
                $t['message'] = 'Komentarz został dodany. Zostanie opublikowany po zweryfikowaniu przez moderatora';
                $name = '';
                $email = '';
                $comment = '';
            }
        }
        */
    } else {
        $category = 404;
    }

?>