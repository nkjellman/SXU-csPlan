<?php
require_once '../project.properties.php';
header("Content-Type: application/json");
if (session_status() == PHP_SESSION_NONE) {
      session_start();
}
if (isset($_SESSION['id']) ? $_SESSION['id'] != session_id() : true) {
    header('location: ../Content/Index.php');
}
        $pdo = $DI->Resolve("PDO");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $obj = json_decode(file_get_contents('php://input'), true);
        $image = getimagesize($obj['Image']);

    if ($image && strlen($obj['Image']) < 2000000) {
        switch ($image['mime']) {
            case "image/png":
                $src = imagecreatefrompng($obj['Image']);
                break;
            case "image/jpg":
            case "image/jpeg":
                $src = imagecreatefromjpeg($obj['Image']);
                break;
            case "image/bmp":
                $src = imagecreatefromwbmp($obj['Image']);
                break;
        }

        $resampledImg = imagecreatetruecolor(128, 128);
        imagecopyresampled($resampledImg, $src, 0, 0, 0, 0, 128, 128, $image[0], $image[1]);
        ob_start();
        switch ($image['mime']) {
            case "image/png":
                        imagepng($resampledImg);
                break;
            case "image/jpg":
            case "image/jpeg":
                        imagejpeg($resampledImg);
                break;
            case "image/bmp":
                        imagewbmp($resampledImg);
                break;
        }
        $image_data = ob_get_contents();
        ob_end_clean();
        if (($DI->Resolve("IUserService")->UpdateImage($_SESSION['net_id'], explode(',', $obj['Image'])[0] . "," .   base64_encode($image_data), $pdo))) {
            echo json_encode(array("Valid" => true));
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode($DI->Resolve("IUserService")->GetUser($_SESSION['net_id'], $pdo));
}
