<?php
    global $category;
    $category = 'pop-stuff';
    $url = $second_url;

    $section = SECTION_POP_STUFF;

    include("controllers/include/thread.php");

    include("templates/pages/$category.phtml");
?>