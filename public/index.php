<?php
session_start();
use App\RMVC\App;

require_once "../vendor/autoload.php";
require_once "../routes/api.php";
require_once "../app/helpers.php";
$_SESSION['logged_in_user_id'] = '1';
App::run();

//header('Content-Type: application/json; charset=utf-8');
//echo json_encode($data);