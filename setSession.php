<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $content = json_decode(trim(file_get_contents("php://input")));
    $country = $content->country;
    $_SESSION['country'] = $country;
    $response = array('status'=>1,'msg'=>$country);
    // $_SESSION = [];
    // if(isset($_SESSION['country'])) {
    //     // echo "Country from session: " . $_SESSION['country'];
    //     error_log("Country from session: " . $_SESSION['country'],3,"error_log");

    // } else {
    //     error_log("Country session variable is not set.");
    //     // echo "Country session variable is not set.";
    // }
    // session_destroy();
    echo json_encode($response);
}