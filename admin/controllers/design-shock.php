<?
    global $category, $active_category;
    $active_category = SECTION_DESIGN_SHOCK;
    $category = 'design-shock';
    if(!empty($_SESSION['sections'][$active_category])) {
        include('controllers/threads.php');
    } else {
        include('controllers/limit.php');
    }

?>