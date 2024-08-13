<?php
require_once("include/initialize.php");
header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $couponCode = isset($_GET['coupon']) ? $_GET['coupon'] : '';
    $subtotal = isset( $_POST["subtotal"] ) ? $_GET['subtotal'] : 0;
    $db = new Database();
    $sql = $db->conn->prepare("SELECT * FROM tblcoupon WHERE COUPON_TITLE = ?");
    $sql->bind_param("s", $couponCode);
    $sql->execute();
    $result = $sql->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if($data["COUPON_TYPE"]=="Flat" && $data["COUPON_VALUE"]>$subtotal){
            $response = array('error' => 'Coupon inapplicable');
            echo json_encode($response);
        } else {
            $response = array(
                'coupon_value' => $data["COUPON_VALUE"],
                'coupon_max_value' => $data["COUPON_MAX_VALUE"],
                'coupon_type' => $data["COUPON_TYPE"],
                'title' => $data["COUPON_TITLE"]
            );
            $_SESSION["user_promocode"] = $data["COUPON_VALUE"];
            $_SESSION["user_promocodeid"] = $data["COUPONID"];
            $_SESSION["user_promocodetitle"] = $data["COUPON_TITLE"];
            $_SESSION["user_promocodetype"] = $data["COUPON_TYPE"]; 
            $_SESSION["user_promocodemax"] = $data["COUPON_MAX_VALUE"];
            echo json_encode($response);
        }
    } else {
        $response = array('error' => 'Invalid coupon code');
        echo json_encode($response);
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
