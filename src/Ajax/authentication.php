<?php
require_once __DIR__.'/../project.properties.php';
require_once PROJECT_ROOT . 'PHP/Models/Enums/AccountType.enum.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header("Content-Type: application/json");
    $obj = json_decode(file_get_contents('php://input'), true);
    if (!is_null($obj)) {
        if (!is_string($obj["username"]) || !is_string($obj["password"])) {
            throw new InvalidArgumentException();
        }
        $pdo = $DI->Resolve("PDO");
        if ($DI->Resolve("IAuthorizationService")->Login($obj["username"], $obj["password"], $pdo)) {
            if (!is_null($DI->Resolve("IUserService")->GetUser($_SESSION['net_id'], $pdo))) {
                        echo json_encode(array("URL" => 'dash.php'));
            }
        } else {
             header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.1 401 Unauthorized');
        }
    } else {
         header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.1 401 Unauthorized');
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $DI->Resolve("IAuthorizationService")->Logout();
}
