<?
    global $category, $active_category;
    $active_category = SECTION_POP_STUFF;
    $category = 'pop-stuff';
    if(!empty($_SESSION['sections'][$active_category])) {
        include('controllers/threads.php');
    } else {
        include('controllers/limit.php');
    }
?>