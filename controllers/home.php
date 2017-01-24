<?php
    global $category;
    $category = 'home';
//    $category_db = 'threads';

    $section = SECTION_DESIGN_STUFF; // 1 = design stuff
    $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC, t.`id` DESC LIMIT ".NEWS_LIMIT_LEFT;
    $wynik = mysql_query($select);
    while($w = mysql_fetch_array($wynik)) {
            $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
            $t['design_stuff'][] = $w;
    }

    $section = SECTION_SOUND_STUFF; // 2 = sound stuff
    $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC, t.`id` DESC LIMIT ".NEWS_LIMIT_LEFT;
    $wynik = mysql_query($select);
    while($w = mysql_fetch_array($wynik)) {
            $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
            $t['sound_stuff'][] = $w;
    }

    include("templates/pages/$category.phtml");

?>