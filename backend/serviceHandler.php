<?php
include("businesslogic/simpleLogic.php");

$type = "";
$param = "";
$method = "";

if (isset($_GET["type"])) {
    $type = $_GET["type"];
    isset($_GET["method"]) ? $method = $_GET["method"] : false;
    isset($_GET["param"]) ? $param = $_GET["param"] : false;
} else {
    $type = $_POST["type"];
    isset($_POST["method"]) ? $method = $_POST["method"] : false;
    isset($_POST["param"]) ? $param = $_POST["param"] : false;
}
//error_log(var_export($param, true));

//isset($_GET["type"]) ? $type = $_GET["type"] : false;
//isset($_GET["method"]) ? $method = $_GET["method"] : false;
//isset($_GET["param"]) ? $param = $_GET["param"] : false;

$logic = new SimpleLogic();

$result = $logic->handleRequest($method, $param);
if ($result === null) {
    response($type, 400, null);
} else {
    response($type, 200, $result);
}

function response($type, $httpStatus, $data)
{
    //error_log($type);
    //error_log($httpStatus);
    //error_log($data);
    switch ($type) {
        case "GET":
            header('Content-Type: application/json');
            http_response_code($httpStatus);
            echo (json_encode($data));
            break;
        case "POST":
            http_response_code(200);
            echo (json_encode("Die Daten wurden erfolgreich hochgeladen!"));
            break;
        default:
            http_response_code(405);
            echo ("Method not supported yet!");
    }
}