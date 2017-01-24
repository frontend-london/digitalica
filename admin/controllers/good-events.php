<?
    global $category, $active_category;
    $active_category = SECTION_GOOD_EVENTS;
    $category = 'good-events';

    if(!empty($_SESSION['sections'][$active_category])) {
        include('controllers/threads.php');
    } else {
        include('controllers/limit.php');
    }
?>