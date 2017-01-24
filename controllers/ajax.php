<?php
    global $category;
    $category = 'ajax';
    $section = (int)$second_url;
    $limit = (int)$third_url;
    if((($section!=SECTION_DESIGN_STUFF) && ($section!=SECTION_SOUND_STUFF)) || $limit<0) { // zabezpieczenie przed niewłaściwym użyciem
        exit();
    }
    $limit+=NEWS_LIMIT_LEFT;
    $limit_to = (AJAX_LIMIT+1); // +1 by sprawdzic czy to ostatnie

    if($section==SECTION_DESIGN_STUFF) {
        $t['color'] = 'pink';
        $t['section'] = 'design';
    } else {
        $t['color'] = 'brown';
        $t['section'] = 'sound';
    }

    $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC, t.`id` DESC LIMIT $limit, $limit_to";
//    echo $select; exit();
    $wynik = mysql_query($select);
    $counter=0;
    while($w = mysql_fetch_array($wynik)) {
        $counter++;
        $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
        $t['ajax'][] = $w;
    }
    if($counter==$limit_to) {
        $t['nomore'] = false;
        unset($t['ajax'][AJAX_LIMIT]);
    } else {
        $t['nomore'] = true;
    }

    include("templates/pages/$category.phtml");

?>