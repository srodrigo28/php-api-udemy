<?php
// set the content type for he API response
header("Content-Type:application/json; charset=utf-8");

//get all data;
$data = require_once('../_data/data.php');

// check if there is e max value on $_GET
if(!isset($_GET['max']) || $_GET['max'] > count($data)){
    $response['status'] = 'error';
    $response['message'] = 'Max animals is not correctly defined.';
    $response['time_response'] = time();
    echo json_decode($reponse, JSON_UNESCAPED_UNICODE);
    exit();
}

// defines the maximum number os animls to return
$max = $_GET['max'];

// 7:01 aula 530

$response['status'] = 'success';
$response['animals'] = array_slice($data, 0, $max);
$response['time_response'] =  time();

// sends the response in JSON format
echo json_encode($response, JSON_UNESCAPED_UNICODE);