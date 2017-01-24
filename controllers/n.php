<?php
    global $category;
    $id = (int)$second_url;
    
    $select = "SELECT t.*, s.url s_url FROM `threads` t, `sections` s WHERE t.`id`= '$id' AND t.`active`='1' AND t.`section` = s.`id` ORDER BY t.`date` DESC LIMIT 1";

    $wynik = mysql_query($select);
    if($w = mysql_fetch_array($wynik)) {
         $adres = ADRES.$w['s_url'].'/'.$w['url'];
         header("Location: $adres");
    } else {
        $category = 404;
        include("templates/pages/$category.phtml");
    }
?>