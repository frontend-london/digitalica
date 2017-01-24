<?
    global $category, $active_category;
    $active_category = SECTION_SOUND_STUFF;
    $category = 'sound-stuff';
    
    if(!empty($_SESSION['sections'][$active_category])) {
        include('controllers/threads.php');
    } else {
        include('controllers/limit.php');
    }
?>