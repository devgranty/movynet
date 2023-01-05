<?php
session_start();

use Classes\Session;
use Classes\Router;

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

if(Session::exists('id')) Session::delete();

Router::redirect('login.php');
