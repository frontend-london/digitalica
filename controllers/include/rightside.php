<?php

/*
 * SEARCH-SECTION START
 */
        $section = SECTION_GOOD_EVENTS; // 3 = good events
        $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC LIMIT ".NEWS_LIMIT_RIGHT;
        $wynik = mysql_query($select);
        while($w = mysql_fetch_array($wynik)) {
                $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
                $w['short_text'] = add_url($w['short_text'], 'good-events/'.$w['url']);
                $t['good_events'][] = $w;
        }

        $section = SECTION_DESIGN_SHOCK; // 4 = design shock
        $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC LIMIT ".NEWS_LIMIT_RIGHT;
        $wynik = mysql_query($select);
        while($w = mysql_fetch_array($wynik)) {
                $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
                $w['short_text'] = add_url($w['short_text'], 'design-shock/'.$w['url']);
                $t['design_shock'][] = $w;
        }

        $section = SECTION_POP_STUFF; // 5 = pop stuff
        $select = "SELECT t.*, u.name author_name FROM `threads` t, `users` u WHERE t.`section`='$section' AND t.`active`='1' AND t.`author` = u.`id` ORDER BY t.`date` DESC LIMIT ".NEWS_LIMIT_RIGHT;
        $wynik = mysql_query($select);
        while($w = mysql_fetch_array($wynik)) {
                $w['date'] = gmdate('d.m.Y',strtotime($w['date']));
                $w['short_text'] = add_url($w['short_text'], 'pop-stuff/'.$w['url']);
                $t['pop_stuff'][] = $w;
        }


        // banery
        $select = "SELECT * FROM `banners` ORDER BY RAND() LIMIT 1";
        $wynik = mysql_query($select);
        if($w = mysql_fetch_array($wynik)) {
            $t['banner'] = $w;
        }

/*
 * SEARCH-SECTION END
 */

?>