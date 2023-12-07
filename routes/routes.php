<?php

require_once '../controllers/birthdays_controller.php';
require_once '../utils/database.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uriSegments = explode('/', parse_url($uri, PHP_URL_PATH));

$dbConnection = (new Database())->getConnection();
$controller = new BirthdayController($dbConnection);

if ($uriSegments[1] === 'birthdays') {
    $arg = isset($uriSegments[2]) ? intval($uriSegments[2]) : null;

    switch ($requestMethod) {
        case 'GET':
            if ($arg) {
                $response = $controller->get($arg);
            } else {
                $response = $controller->getAll();
            }
            break;
        case 'POST':
            $response = $controller->create();
            break;
        case 'PUT':
            if ($arg) {
                $response = $controller->update($arg);
            } else {
                $response = ['status' => 'error', 'message' => 'Invalid birthday ID'];
            }
            break;
        case 'DELETE':
            if ($arg) {
                $response = $controller->delete($arg);
            } else {
                $response = ['status' => 'error', 'message' => 'Invalid birthday ID'];
            }
            break;
        default:
            $response = ['status' => 'error', 'message' => 'Invalid request method'];
            break;
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid API endpoint'];
}

header('Content-Type: application/json');
echo json_encode($response);
