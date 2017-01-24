<?php
    global $category;
    $category = 'sound-stuff';
    $url = $second_url;

    $section = SECTION_SOUND_STUFF;

    include("controllers/include/thread.php");

    include("templates/pages/$category.phtml");
?>