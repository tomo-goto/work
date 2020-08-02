<html>
<head>
<title>PHP TEST</title>
<link rel="stylesheet" type="text/css" href="CS_outer_frame.css" />
<link rel="stylesheet" type="text/css" href="milestone/milestone.css" />
</head>
<body>

<div id="header">header</div>

<div id="menu_and_content">
<!-- Start of "menu_and_content" -->
    <div id="menu">menu
    <!-- Start of "menu" -->
    <!-- End of "menu" -->
    </div>

    <div id="content"><h4>content</h4>
    <!-- Start of id: content-->
<?php
    require_once(dirname(__FILE__) . '/milestone/Lib_milestone_view.php');

    $LC_start = '2018-11-19';
    $LC_end   = '2018-12-19';
/*
    view_milestone_head($LC_start, $LC_end);

    $LC_start_datetime = new DateTime($LC_start);
    $LC_end_datetime   = new DateTime($LC_end);
*/
    //view_milestone_child(0, $LC_start_datetime, $LC_end_datetime, '2018-11-15', '2018-12-05');
    view_milestone($LC_start, $LC_end);
?>
    <!-- End of id: content -->
    </div>

<!-- End of id: menu_and_content -->
</div>

<div id="footer">footer</div>

</body>
</html>
