<html>
<head>
<title>PHP TEST</title>
<link rel="stylesheet" type="text/css" href="CS_outer_frame.css" />
<link rel="stylesheet" type="text/css" href="weekly_cal/weekly_cal.css" />
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
    require_once(dirname(__FILE__) . '/weekly_cal/Lib_weekly_cal_view.php');

    //view_weekly_todo_week('2018-12-19', 'dynamic');
    view_weekly_todo_week('2018-11-19', 'static');
?>
    <!-- End of id: content -->
    </div>

<!-- End of id: menu_and_content -->
</div>

<div id="footer">footer</div>

</body>
</html>
