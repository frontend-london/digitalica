<?php
    global $category;
    $category = 'interviews';
    $category_db = 'interviews';
    $category_db2 = 'interviews_content';
    //Bartek Jagniątkowski
//    echo $second_url;
    
    if(!empty($second_url)) {
        $sql = "SELECT * FROM `$category_db` WHERE `url` = '$second_url' LIMIT 1";
        $wynik = mysql_query($sql);
        $w = mysql_fetch_array($wynik);
        if(!$w) {
            $category = 404;
            include("templates/pages/$category.phtml");
            exit();
        }
        
        $id = $w['id'];
        $sql = "SELECT * FROM `$category_db2` WHERE `id_interview` = '$id' ORDER BY `id` ASC";
        $wynik = mysql_query($sql);
        $content = array();
        while($w2 = mysql_fetch_array($wynik)) {
                $content[] = $w2;
        }
        
        $w['content'] = $content;
        
        $interview = $w;
        
        include("templates/pages/interview.phtml");
    } else {
        $sql = "SELECT * FROM `$category_db` ORDER BY `order` DESC";
        $wynik = mysql_query($sql);
        $interviews = array();
        while($w = mysql_fetch_array($wynik)) {
                $interviews[] = $w;
        }
        include("templates/pages/interviews.phtml");
    }    
    
    
    /*if($second_url=='Bartek-Jagniatkowski' || $second_url=='Jason-Holland' || $second_url=='Greg-Hojna') {
        include("templates/pages/$category/$second_url.phtml");
    } else {
        include("templates/pages/$category.phtml");
    }*/
    
?>