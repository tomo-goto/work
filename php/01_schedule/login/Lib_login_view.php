<?php

// ------------------------------------------------------------------------

// Import the necessary classes
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Capsule\Manager as Capsule;

// Include the composer autoload file
require 'Login/vendor/autoload.php';

// ------------------------------------------------------------------------

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function view_login(){

// --------------------------    Login check    --------------------------
    // Setup a new Eloquent Capsule instance
    $LC_capsule = new Capsule;

    $LC_capsule->addConnection([
        'driver'    => 'pgsql',
        'host'      => 'localhost',
        'database'  => 'postgres',
        'username'  => 'postgres',
        'password'  => '',
        'charset'   => 'utf8',
    ]);

    $LC_capsule->bootEloquent();

    if ($LC_user = Sentinel::check()){
        // Already logged in
        return;
    }
// --------------------------    Login check    --------------------------

    // class name
    $LC_class_form = 'form';

    // [Input] name
    $LC_input_name_id = 'login_id';
    $LC_input_name_pw = 'login_pw';

    // html
    $LC_html = <<<EOF
<html>
<head>
<title>PHP TEST</title>
<link rel="stylesheet" type="text/css" href="CS_outer_frame.css" />
<link rel="stylesheet" type="text/css" href="login/login.css" />
</head>
<body>
<div id="header">header</div>

<div id="menu_and_content">
    <div class="$LC_class_form">
        <p>Login</p>
        <form action="login/login.php" method="post">
            <label>ID:<input type="text" name="$LC_input_name_id"></label>
            <label>PW:<input type="text" name="$LC_input_name_pw"></label>
            <input type="submit" value="Shoot!">
        </form>
    </div>
</div>

<div id="footer">footer</div>
</body>
</html>
EOF;
echo $LC_html . "\n";

    exit;

    return;
}

?>
