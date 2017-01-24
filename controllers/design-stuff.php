<?php
    global $category;
    $category = 'design-stuff';
    $url = $second_url;

    $section = SECTION_DESIGN_STUFF;

    include("controllers/include/thread.php");

    include("templates/pages/$category.phtml");
?>