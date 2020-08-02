<?php

// ------------------------------------------------------------------------

// Import the necessary classes
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Capsule\Manager as Capsule;

// Include the composer autoload file
require 'Login/vendor/autoload.php';

// ------------------------------------------------------------------------

try_login($_POST);

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT :
**************************************************************************/
function try_login($data){

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

    $LC_credentials = [
        'email'    => $data['login_id'],
        'password' => $data['login_pw'],
    ];

    if (Sentinel::authenticate($LC_credentials)){
        // Auth succeded
    }
    else{
        $LC_uri = $_SERVER['HTTP_REFERER'];
        header("Location: ". $LC_uri);
        exit;
        // Auth failed
    }

    $LC_user = Sentinel::findByCredentials($LC_credentials);
    Sentinel::login($LC_user);

    if ($LC_user = Sentinel::check()){
        $LC_uri = $_SERVER['HTTP_REFERER'];
        header("Location: ". $LC_uri);
        exit;
        // Login succeded
    }
    else{
        $LC_uri = $_SERVER['HTTP_REFERER'];
        header("Location: ". $LC_uri);
        exit;
        // Login failed
    }

    return;
}

?>
