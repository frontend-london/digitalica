<?php
    global $category;
    $category = 'good-events';
    $url = $second_url;

    $section = SECTION_GOOD_EVENTS;

    include("controllers/include/thread.php");

    include("templates/pages/$category.phtml");
?>