<?php
    include_once "../common/fpdb.php";
    include_once "../include/credentials.php";

    define("API_ERROR_OK", 0);

    class API_Reply
    {
        public $type;
        public $payload;
        
        function __construct($type, $payload)
        {
            $this->type = $type;
            $this->payload = $payload;
        }
    }

    function return_error($msg)
    {
        $jres = new API_Reply("error", array("error" => $msg));
        //echo json_encode($jres);
        print_r($jres);
        exit(-1);
    }

    function check_credentials($cred)
    {
        if ($_SESSION["credentials"] > $cred) {
            return_error("Not enough credentails");
        }
    }

    /*
     * Functions to handle requests
     */
    function api_login($db)
    {
        $username = $_GET["username"];
        $password = $_GET["password"];
 
        echo $username;
        echo $password;

        $qres = $db->user_get($username)->next();

        if (!$qres) {
            return_error("User name not found");
        }

        if ($qres["password"] == md5($password)) {
            $_SESSION["active"] = True;
            $_SESSION["user_id"] = $qres["user_id"];
            $_SESSION["credentials"] = $qres["credentials"];
            $_SESSION["key"] = 1234;
        } else {
            return_error("Login failed");
        }
    }

    function api_inventory_get($db)
    {
        check_credentials(CRED_ADMIN);
        $qres = $db->inventory_get_all()->get_array();
        $jres = new API_Reply("inventory_get", $qres);
        //echo json_encode($jres);
        print_r($jres);

    }

    function api_iou_get($db)
    {
        check_credentials(CRED_USER);
        $user_id = $_SESSION["user_id"];
        $qres = $db->iou_get($user_id)->get_array();
        $jres = new API_Reply("iou_get", $qres);
        //echo json_encode($jres);
        print_r($jres);
    }

    function api_iou_get_all($db)
    {
        check_credentials(CRED_ADMIN);
        $qres = $db->iou_get_all()->get_array();
        $jres = new API_Reply("iou_get_all", $qres);
        //echo json_encode($jres);
        print_r($jres);
    }

    if (!session_start()) {
        return_error("Failed to start session");
    }

    $action = $_GET["action"];
    $key = $_GET["key"];

    echo "\$action: $action</br>";
    echo "\$key: $key </br>";

    if ($action != "login" and !isset($_SESSION["active"])) {
        return_error("Session timed out");
    }

    print_r($_SESSION); echo "</br>";


    if ($action != "login" and $_SESSION["key"] != $key) {
        return_error("Session key missmatch");
    }

    try {
        $cred = $_SESSION["credentials"];
        if ($action == "login" or $cred == CRED_USER) {
            $db = new FPDB_User();
        } else {
            $db = new FPDB_Admin();
        }
    } catch (FPDB_Exception $e) {
        return_error("Faild to connect to database");
    }

    try {
        switch ($action) {
            case "login":
                api_login($db);
                break;
            case "inventory_get":
                api_inventory_get($db);
                break;
            case "iou_get":
                api_iou_get($db);
                break;
            case "iou_get_all":
                api_iou_get_all($db);
                break;
            default:
                return_error("Unknown action requested");
                break;
        }
    } catch (FPDB_Exception $e) {
        return_error("Database query failed");
    }
?>
