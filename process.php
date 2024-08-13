<?php

// use Razorpay\Api\Api;
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    require_once("include/initialize.php");
    // require 'razorpay-php/Razorpay.php';

    
    $qry = "SELECT `ORDEREDNUM` FROM `tblsummary` ORDER by `SUMMARYID` DESC LIMIT 1";
	$mydb->setQuery($qry);
    $cur = $mydb->loadSingleResult();
    // $user= session_id();
    $user= $_SESSION["USER"];

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $adr1 = $_POST['adr1'];
    $adr2 = $_POST['adr2'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $roi = $_POST['roi'];
    $pai = $_POST['pai'];
    $total = $_POST['total']-$_SESSION["user_promocode"];
    $delfee = $_POST['delfee'];
    $terms = "1";
    $date = date("Y-m-d h:i:s");


    $ordernum = $cur->ORDEREDNUM+1;
    $db = New Database();
    $sql = $db->conn->prepare("INSERT INTO tblorder(PROID, ORDEREDQTY, ORDEREDPRICE, ORDEREDNUM, size, height, chest, sleeve_length, shoulder, belly, bicep, waist, hip, thigh, calf, gender, fit, USERID) select c.PROID,c.CARTQTY,p.PROPRICE,?,c.size,c.height, c.chest, c.sleeve_length, c.shoulder, c.belly, c.bicep, c.waist, c.hip, c.thigh, c.calf, c.gender, c.fit,'0' from tblcart c,tblproduct p where c.PROID=p.PROID and c.USER = ?");
    $sql->bind_param("ss",$ordernum,$user);
    $sql->execute();
    if($sql->affected_rows > 0)
    {
        // $sql = $db->conn->prepare("INSERT INTO `tblcustomer`(`FNAME`, `LNAME`,`STREETADD`, `BRGYADD`, `CITYADD`, `COUNTRY`, `PROVINCE`,`PHONE`, `EMAILADD`, `ZIPCODE`,`TERMS`, `DATEJOIN`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
        // $sql->bind_param("ssssssssssss",$fname,$lname,$adr1,$adr2,$city,$country,$state,$phone,$email,$zipcode,$terms,$date);
        // $sql->execute();
        $billaddressid=$_POST["neworderaddress"];
        $shippingaddressid=$_POST["newshippingaddress"];
        if($_POST["neworderaddress"]=="yes"){
            if($_POST["ordereqshipping"]=="yes"){
                $query='INSERT INTO tblshippingaddress (CUSTOMERID, FNAME, LNAME, PHONENO, EMAIL, STREETADD, BRGYADD, CITYADD, PROVINCE, COUNTRY, ZIPCODE) VALUES ('.$_SESSION["USER"].',"'.$fname.'","'.$lname.'","'.$phone.'","'.$email.'","'.$adr1.'","'.$adr2.'","'.$city.'","'.$state.'","'.$country.'",'.$zipcode.')';
                $mydb->setQuery($query);
                $mydb->executeQuery();
                $query='SELECT * FROM tblshippingaddress WHERE CUSTOMERID ='.$_SESSION["USER"].' ORDER BY SHIPPINGADDRESSID DESC LIMIT 1';
                $mydb->setQuery($query);
                $cur = $mydb->loadSingleResult();
                $billaddressid = $cur->SHIPPINGADDRESSID;
            }
        }
        if($_POST["newshippingaddress"]=="yes"){
            if($_POST["ordereqshipping"]=="no"){
                $query='INSERT INTO tblshippingaddress (CUSTOMERID, FNAME, LNAME, PHONENO, EMAIL, STREETADD, BRGYADD, CITYADD, PROVINCE, COUNTRY, ZIPCODE) VALUES ('.$_SESSION["USER"].',"'.$_POST["shipfname"].'","'.$_POST["shiplname"].'","'.$_POST["shipphone"].'","'.$_POST["shipemail"].'","'.$_POST["shipadr1"].'","'.$_POST["shipadr2"].'","'.$_POST["shipcity"].'","'.$_POST["shipstate"].'","'.$_POST["shipcountry"].'",'.$_POST["shipzipcode"].')';
                $mydb->setQuery($query);
                $mydb->executeQuery();
                $query='SELECT * FROM tblshippingaddress WHERE CUSTOMERID ='.$_SESSION["USER"].' ORDER BY SHIPPINGADDRESSID DESC LIMIT 1';
                $mydb->setQuery($query);
                $cur = $mydb->loadSingleResult();
                $shippingaddressid = $cur->SHIPPINGADDRESSID;
            }
        }
        if($sql->affected_rows > 0)
        {
        $customer = $_SESSION["USER"];
        $summary = New summary();
		$summary->ORDEREDDATE = date("Y-m-d h:i:s");
		$summary->CUSTOMERID = $customer;
		$summary->ORDEREDNUM  = $ordernum;
        $summary->SHIPPINGADDRESSID = $shippingaddressid;
        $summary->BILLADDRESSID = $billaddressid;
		$summary->DELFEE = $delfee;
		$summary->PAYMENT = $total;
        $summary->COUPONID = $_SESSION["user_promocodeid"];
		$summary->ORDEREDSTATS = "Received";
		$summary->ORDEREDREMARKS = "Your order has been confirmed.";
		$summary->CLAIMEDDATE = date("Y-m-d h:i:s");
        $summary->roi = $roi;
        $summary->pai = $pai;
		// $summary->USERID  = '0';
        // $summary->PAYMETHOD = $paymethod;
        // $summary->PAYMENTDETAILS = $paydetails;
        if(str_starts_with($pai, 'pay')){
        $keyId = 'rzp_test_U69zpSNmMVKSaT';
        $keySecret = 'h61iFO2YT2aeVEvAhZVrXIWs';

        $url = "https://api.razorpay.com/v1/payments/".$pai;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic " . base64_encode("$keyId:$keySecret")
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $decodedResponse = json_decode($response, true); // Decoding JSON response to associative array
            $summary->PAYMENTMETHOD = $decodedResponse["method"];
            if($decodedResponse["method"]=="card"){
                $cardurl = "https://api.razorpay.com/v1/payments/".$pai."/?expand[]=card";
                $chc = curl_init();

                curl_setopt($chc, CURLOPT_URL, $cardurl);
                curl_setopt($chc, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chc, CURLOPT_HTTPHEADER, [
                    "Authorization: Basic " . base64_encode("$keyId:$keySecret")
                ]);

                $cardresponse = curl_exec($chc);
                if (curl_errno($chc)) {
                    echo 'Error: ' . curl_error($ch);
                } else { 
                    $decodedCardResponse = json_decode($cardresponse, true); // Decoding JSON response to associative array
                    $summary->PAYMENTDETAILS = $decodedCardResponse["card"]["network"]."/".$decodedCardResponse["card"]["name"]."/".$decodedCardResponse["card"]["last4"]."/".$decodedCardResponse["card"]["type"]."/".$decodedCardResponse["card"]["issuer"];
                }
            } else if($decodedResponse["method"]=="upi") {
                $summary->PAYMENTDETAILS = $decodedResponse["vpa"];
            } else if($decodedResponse["method"]=="netbanking") {
                $summary->PAYMENTDETAILS = $decodedResponse["bank"];
            } else if($decodedResponse["method"]=="wallet") {
                $summary->PAYMENTDETAILS = $decodedResponse["wallet"];
            } else if($decodedResponse["method"]=="emi") {
                $emiurl = "https://api.razorpay.com/v1/payments/".$pai."/?expand[]=emi";
                $chc = curl_init();

                curl_setopt($chc, CURLOPT_URL, $emiurl);
                curl_setopt($chc, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chc, CURLOPT_HTTPHEADER, [
                    "Authorization: Basic " . base64_encode("$keyId:$keySecret")
                ]);

                $emiresponse = curl_exec($chc);
                if (curl_errno($chc)) {
                    echo 'Error: ' . curl_error($ch);
                } else { 
                    $decodedEmiResponse = json_decode($emiresponse, true); // Decoding JSON response to associative array
                    $summary->PAYMENTDETAILS = $decodedEmiResponse["emi"]["issuer"]."/".$decodedEmiResponse["emi"]["rate"]."/".$decodedEmiResponse["emi"]["duration"];
                }
                // $summary->PAYMENTDETAILS = $decodedResponse["emi"]["issuer"]."/".$decodedResponse["emi"]["rate"]."/".$decodedResponse["emi"]["duration"];
            }
        }
       
        // echo "Order Placed Succesfully <br> <a href='index.php'>Go to Home</a>";

        } else {
            $summary->PAYMENTMETHOD = "Paypal";
            $summary->PAYMENTDETAILS = "-";
        }
        $summary->create();
        $sql = $db->conn->prepare("Delete from tblcart where user = ?");
        $sql->bind_param("s",$user);
        // $sql->execute();
        if($sql->execute()){
            $qry = "SELECT * FROM `tblcustomer` WHERE CUSTOMERID = (SELECT `CUSTOMERID` FROM `tblsummary` WHERE ORDEREDNUM = ".$ordernum.")";
            $db->setQuery($qry);
            $cur = $db->loadSingleResult();
            $query = "SELECT * 
                    FROM  `tblproduct` p,  `tblcustomer` c,  `tblorder` o,  `tblsummary` s, `tblcoupon` d
                    WHERE p.`PROID` = o.`PROID` 
                    AND o.`ORDEREDNUM` = s.`ORDEREDNUM` 
                    AND s.`CUSTOMERID` = c.`CUSTOMERID`
                    AND s.`COUPONID` = d.`COUPONID` 
                    AND o.`ORDEREDNUM`=".$ordernum;
            $mydb->setQuery($query);
            $order = $mydb->loadResultList();
            $qry = "SELECT * FROM `tblshippingaddress` WHERE SHIPPINGADDRESSID = ".$order[0]->SHIPPINGADDRESSID;
            $mydb->setQuery($qry);
            $ship = $mydb->loadSingleResult();
            function getSpecifications($cart) {
                $specs = [
                    'Size' => $cart->size,
                    'Height' => $cart->height,
                    'Chest' => $cart->chest,
                    'Sleeve Length' => $cart->sleeve_length,
                    'Shoulder' => $cart->shoulder,
                    'Belly' => $cart->belly,
                    'Bicep' => $cart->bicep,
                    'Hip' => $cart->hip,
                    'Waist' => $cart->waist,
                    'Thigh' => $cart->thigh,
                    'Calf' => $cart->calf,
                    'Gender' => $cart->gender,
                    'Fit' => $cart->fit
                ];
                $count = 0;
                $output = '<table class=\'table table-bordered\'>';
                $output .= '<tr>';
        
        
                foreach ($specs as $spec => $value) {
                    if ($value != 0 && $value != "") {
                        if ($count % 2 == 0) {
                            $output .= '<tr>';
                        }
                        $output .= "<td style=\"font-size:0.65rem;padding:2px;width:120px;\">$spec ".(is_numeric($value)?"(cm)":"")."</th>";
                        $output .= "<td style=\"font-size:0.65rem;padding:2px;\">$value</td>";
                        if ($count % 2 == 1) {
                            $output .= '</tr>';
                        }
                        $count++;
        
                    }
                }
        
                if ($count % 2 == 1) {
                    $output .= '<td style=\"font-size:0.65rem;padding:2px;\"></td></tr>';
                }
        
                $output .= '</table>';
                return $output;
            } 
            $ordertable='<table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th class="text-left">Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>';
                
                    
            $count = 0;
            foreach($order as $product){
                $ordertable.='
                <tr>
                <td class="no" style="text-align:center">'.++$count.'</td>
                <td class="text-left"><div><h3>'.$product->PROTITLE.'</h3>'.getSpecifications($product).'<div></td>
                <td class="unit">'.number_format($product->PROPRICE/1.12, 2, '.', '').'</td>
                <td class="qty">'.$product->ORDEREDQTY.'</td>
                <td class="total">&#8377;'.number_format($product->PROPRICE * $product->ORDEREDQTY / 1.12 , 2, '.', '').'</td>
                </tr>
                ';
            }
                    
                    
                
            $ordertable.='</tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td>&#8377;'.number_format($order[0]->PAYMENT/1.12, 2, '.' ,'').'</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">DISCOUNT</td>
                    <td>- &#8377;'.number_format($order[0]->COUPON_TYPE == "percentage" ? min($order[0]->PAYMENT*$order[0]->COUPON_VALUE/112, $order[0]->COUPON_MAX_VALUE) : $order[0]->COUPON_VALUE, 2, '.', '').'</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">TAX (12%)</td>
                    <td>&#8377;'.number_format(0.12*($order[0]->PAYMENT/1.12 - ($order[0]->COUPON_TYPE == "percentage" ? min($order[0]->PAYMENT*$order[0]->COUPON_VALUE/112, $order[0]->COUPON_MAX_VALUE) : $order[0]->COUPON_VALUE)), 2, '.', '').'</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">GRAND TOTAL</td>
                    <td>&#8377;'.number_format(1.12*($order[0]->PAYMENT/1.12 - ($order[0]->COUPON_TYPE == "percentage" ? min($order[0]->PAYMENT*$order[0]->COUPON_VALUE/112, $order[0]->COUPON_MAX_VALUE) : $order[0]->COUPON_VALUE)), 2, '.', '').'</td>
                </tr>
            </tfoot>
        </table>';
            $mail = require "mailer.php";
            $mail->setFrom(smtp_username);
            $mail->addAddress($cur->EMAILADD);     
            $mail->Subject = 'Order Received';
            $site_host=site_host;
            $mailhtml = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <title>Order Received</title>
                <link href=\"".web_root."admin/css/invoice.css\" rel=\"stylesheet\">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                    }
                    .container {
                        width: 80%;
                        margin: auto;
                        overflow: hidden;
                    }
                    header {
                        background: #fff;
                        color: #333;
                        padding: 10px 0;
                        border-bottom: 1px solid #ccc;
                    }
                    main {
                        padding: 20px 0;
                    }
                    footer {
                        background: #333;
                        color: #fff;
                        text-align: center;
                        padding: 10px 0;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        border-spacing: 0;
                        margin-bottom: 20px
                    }
                    
                    table td,table th {
                        padding: 15px;
                        background: #eee;
                        border-bottom: 1px solid #fff
                    }
                    
                    table th {
                        white-space: nowrap;
                        font-weight: 400;
                        font-size: 16px
                    }
                    
                    table td h3 {
                        margin: 0;
                        font-weight: 400;
                        color: #3989c6;
                        font-size: 1.2em
                    }
                    
                    table .qty,table .total,table .unit {
                        text-align: center;
                        font-size: 1.2em
                    }
                    
                    table .no {
                        color: #fff;
                        font-size: 1.6em;
                        background: #3989c6
                    }
                    
                    table .unit {
                        background: #ddd
                    }
                    
                    table .total {
                        background: #3989c6;
                        color: #fff
                    }
                    
                    table tbody tr:last-child td {
                        border: none
                    }
                    
                    table tfoot td {
                        background: 0 0;
                        border-bottom: none;
                        white-space: nowrap;
                        text-align: center;
                        padding: 10px 20px;
                        font-size: 1.2em;
                        border-top: 1px solid #aaa
                    }
                    
                    table tfoot tr:first-child td {
                        border-top: none
                    }
                    
                    table tfoot tr:last-child td {
                        color: #3989c6;
                        font-size: 1.4em;
                        border-top: 1px solid #3989c6
                    }
                    
                    table tfoot tr td:first-child {
                        border: none
                    }
                </style>
            </head>
            <body>
                <div class=\"container\">
                    <header>
                        <h1>Order Received</h1>
                    </header>
                    <main>
                        <p>Dear $cur->FNAME $cur->LNAME,</p>
                        <p>Thank you for placing your order! We're happy to confirm that we've received it and it's currently in the processing stage. You can expect to hear back from us with the order confirmation in the next few days.</p>
                        <h2>Order Details:</h2>
                        <p><strong>Order Number:</strong> $ordernum</p>
                        <p><strong>Order Date:</strong>".date_format(date_create($order[0]->ORDEREDDATE),"M d,Y")."</p>
                        <p><strong>Shipping Address:</strong>".$ship->STREETADD.", ".$ship->BRGYADD.", ".$ship->CITYADD.", ".$ship->PROVINCE.", ".$ship->COUNTRY." - ".$ship->ZIPCODE."</p>
                        <h2>Order Summary:</h2>
                        ".$ordertable."
                        <p>Thank you for choosing our store. If you have any questions about your order, please contact us.</p>
                        <p>Best Regards,<br> FinerFits</p>
                    </main>
                    <footer>
                        &copy; 2024 FinerFits. All rights reserved.
                    </footer>
                </div>
            </body>
            </html>
            ";
            $mail->Body = $mailhtml;
            try {
                $mail->send();
                // redirect(web_root); 
                header('Location: '.web_root.'bill.php?orderid='.$ordernum);

            } catch (Exception $e){
                message("Message could not be sent! Please contact Administrator. Mailer error:{$mail->ErrorInfo}", "error");
                redirect(web_root); 
            }
        }

        // header('Location: '.web_root);
        }else{
            echo 'user creation failed';
        }
    }else{
        echo 'Payment Failed'; 
    }

}

?>