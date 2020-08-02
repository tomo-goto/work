<html>
    <head>
        <title>Knowledge Base</title>
        <link rel="stylesheet" type="text/css" href="basic.css" />
    </head>
    <body>
        <div class="row top head"></div>
        <div class="column bot side menu">
            <h5>Menu</h5>
<?php
    require_once(dirname(__FILE__) . '/lib.php');
    view_menu();
?>
        </div>

        <div class="column bot middle article">
<!---------- [START] Get html from DB [START] ---------->
<?php
    $LC_category = 'category';
    $LC_title    = 'title';
    if( isset($_GET[$LC_category]) && isset($_GET[$LC_title]) ){
        view_article( $_GET[$LC_category], $_GET[$LC_title] );
    }
    else if( isset($_GET[$LC_category]) ){
        view_title( $_GET[$LC_category] );
    }
    else{
        // Homepage
        echo "HOME\n";
    }
?>
<!---------- [END] Get html from DB [END] ---------->
        </div>
        <div class="column bot side navi">
            <h5>Navi</h5>
<?php
    if( isset($_GET[$LC_category]) && isset($_GET[$LC_title]) ){
        view_navi( $_GET[$LC_category], $_GET[$LC_title]);
    }
?>
        </div>
    </body>
</html>

