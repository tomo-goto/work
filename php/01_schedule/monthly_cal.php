<html>
<head>
<title>PHP TEST</title>
<link rel="stylesheet" type="text/css" href="CS_outer_frame.css" />
<link rel="stylesheet" type="text/css" href="monthly_cal/monthly_cal.css" />
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
    require_once(dirname(__FILE__) . '/monthly_cal/Lib_monthly_cal_view.php');

    view_monthly_cal('2018-12');
?>
    <!-- End of id: content -->
    </div>

<!-- End of id: menu_and_content -->
</div>

<div id="footer">footer</div>

</body>
</html>
