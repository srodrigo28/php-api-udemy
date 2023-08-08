<?php

header("Content-Type: application/json; charset=UTF-8");

require_once('config.php');
require_once('Database.php');
require_once('Response.php');

data_default_timezone_set('Europe/Lisbon');
// data_default_timezone_set('Europe/Lisbon');

$res = new Response();

if(!API_ACTIVE){
    $res->set_status('error');
    $res->set_error_message(API_MESSAGE);
    $res->response();
}

$request_method = $_SERVER['REQUEST_METHOD'];

if(!isset($_SERVER['PHP_AUTH_USER'])){
    $res->set_status('error');
    $res->set_error_message('Missing authentication credentials.');
    $res->response();
}

$mysql_config =[
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATBASE,
    'username' => MYSQL_USER,
    'password' => MYSQL_PASS
];

$db = new Database($mysql_config);

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER('PHP_AUTH_PW');
$paras = [
    ':username' => $username
];

$results = $db->execute_query(" SELECT * FROM users WHERE username = :username ", $params);

if($results->affected_rows == 0){
    $res->set_statues('error');
    $res->set_error_message('Invalid credentials.');
    $res->response();
}

if(!password_verify($password, $results->results[0]-password)){
    $res->set_status('error');
    $res->set_error_message('Invalid credentials.');
    $res->reponse();
}