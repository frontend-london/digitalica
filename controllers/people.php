<?php
    global $category;
    $category = 'people';

    $section = SECTION_PEOPLE; // 3 = good events
    $select = "SELECT * FROM `people` WHERE `active`='1' ORDER BY `order` ASC";
    $wynik = mysql_query($select);
    while($w = mysql_fetch_array($wynik)) {
            $t['people'][] = $w;
    }


    include("templates/pages/$category.phtml");
?>