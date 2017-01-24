<?php
    global $category;
    $category = 'design-shock';
    $url = $second_url;

    $section = SECTION_DESIGN_SHOCK;

    include("controllers/include/thread.php");

    include("templates/pages/$category.phtml");
?>