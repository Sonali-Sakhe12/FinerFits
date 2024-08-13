<?php

require 'razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

require_once("include/initialize.php");

$mydb->setQuery("SELECT * FROM tblcart c,tblproduct p where user = '".$_SESSION["USER"]."' and c.PROID=p.PROID");
$cur = $mydb->loadResultList();
$mydb->setQuery("SELECT * FROM tblcustomer where CUSTOMERID = ".$_SESSION["USER"]);
$curcust = $mydb->loadSingleResult();
$mydb->setQuery("SELECT * FROM tblshippingaddress where CUSTOMERID = ".$_SESSION["USER"]);
$curcustadds = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Checkout @ FinerFits</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="#" name="keywords">
    <meta content="#" name="description">
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="img/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicons/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link
            href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <?php
    include('header.php');
    if($cartcount == 0)
    {
        redirect("cart.php");
    }
    ?>


    <!-- Navbar Start -->
    <!-- <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">Men's Apparel <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                <a href="" class="nav-item nav-link">Shirts</a>
                        <a href="" class="nav-item nav-link">Blazers</a>
                        <a href="" class="nav-item nav-link">Jackets</a>
                        <a href="" class="nav-item nav-link">Combos</a>
                    </div>
                            </div>
                        </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.html" class="nav-item nav-link active">Home</a>
                            <a href="shop.html" class="nav-item nav-link">Shop</a>
                            <a href="detail.html" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="" class="nav-item nav-link">Login</a>
                            <a href="" class="nav-item nav-link">Register</a>
                        </div>
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-1.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a class="text-dark" href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">

            <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
            <div id="alladdressbill">
            <?php
            foreach ($curcustadds as $key=>$address) {
                echo '<div class="d-flex align-items-center border p-3"><input type="radio" name="addressRadio" id="addressRadio' . $key . '" value="' . $key . '" data-id="'.$address->SHIPPINGADDRESSID.'" '.($address->SHIPPINGADDRESSID===$curcust->DEFAULTADDRESSID?"checked":"").'>';
                echo '<label class="pl-3" for="addressRadio' . $key . '"><strong>' . $address->FNAME . ' ' . $address->LNAME . '</strong><br>';
                echo $address->STREETADD . ', ' . $address->BRGYADD . '<br>';
                echo $address->CITYADD . ', ' . $address->PROVINCE . ', ' . $address->COUNTRY . ' - ('.$address->ZIPCODE.')<br>';
                echo 'Mobile: ' . $address->PHONENO . '<br>';
                echo 'Email: ' . $address->EMAIL . '</label></div>';
            }
            ?>
            </div>

            <div class="btn-group">
                <button class="btn btn-primary mt-3" id="addNewAddressBtn">Add New Address</button>
                <button class="btn btn-primary ml-1 mt-3" id="discardNewAddressBtn" style="display:none;">Discard</button>
            </div>


            <form id="shipdetail" class="px-2" action="process.php" method="post" style="display:none;">
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" placeholder="John" name="fname" id="fname">
                            <p class="text-danger" id="v_fname"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" placeholder="Doe" name="lname" id="lname">
                            <p class="text-danger" id="v_lname"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" placeholder="example@email.com" name="email" id="email">
                            <p class="text-danger" id="v_email"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control" type="text" placeholder="+123 456 789" name="phone" id="mobile">
                            <p class="text-danger" id="v_mobile"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1</label>
                            <input class="form-control" type="text" placeholder="123 Street" name="adr1" id="adr1">
                            <p class="text-danger" id="v_adr1"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="123 Street" name="adr2" id="adr2">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Pincode</label>
                            <input class="form-control" type="text" placeholder="pincode" name="zipcode" id="zipcode" >
                            <p class="text-danger" id="v_zipcode"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <input class="form-control" type="text" placeholder="City" name="city" id="city" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State</label>
                            <input class="form-control" type="text" placeholder="State" name="state" id="state" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <input class="form-control" type="text" placeholder="Country" name="country" id="country" readonly>
                        </div>
                        
                        
                        <input type="hidden" id="neworderaddress" name="neworderaddress" value="no">
                        <input type="hidden" id="newshippingaddress" name="newshippingaddress" value="no">
                        <input type="hidden" id="ordereqshipping" name="ordereqshipping" value="yes">
                        <input type="hidden" id="roi" name="roi">
                        <input type="hidden" id="pai" name="pai">
                        <input type="hidden" id="total" name="total">
                        <input type="hidden" id="delfee" name="delfee">
                        <input type="hidden" id="paymethod" name="paymethod">
                        <input type="hidden" id="paydetails" name="paydetails">
                        
                        
                    </div>
                </div>
            </form>

            <h4 class="font-weight-semi-bold mb-4 mt-4">Shipping Address</h4>


            <div class="col-md-12 form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="shippingaddresscheck" checked>
                    <label class="custom-control-label" for="shippingaddresscheck">Same as billing address</label>
                </div>
            </div>

            <div id="shippingaddressdetails" style="display:none;">
                <div id="alladdressship">
                <?php
                foreach ($curcustadds as $key=>$address) {
                    echo '<div class="d-flex align-items-center border p-3"><input type="radio" name="shipAddressRadio" id="shipAddressRadio' . $key . '" value="' . $key . '" data-id="'.$address->SHIPPINGADDRESSID.'"'.($address->SHIPPINGADDRESSID===$curcust->DEFAULTADDRESSID?"checked":"").'>';
                    echo '<label class="pl-3" for="shipAddressRadio' . $key . '"><strong>' . $address->FNAME . ' ' . $address->LNAME . '</strong><br>';
                    echo $address->STREETADD . ', ' . $address->BRGYADD . '<br>';
                    echo $address->CITYADD . ', ' . $address->PROVINCE . ', ' . $address->COUNTRY . ' - ('.$address->ZIPCODE.')<br>';
                    echo 'Mobile: ' . $address->PHONENO . '<br>';
                    echo 'Email: ' . $address->EMAIL . '</label></div>';
                }
                ?>
                </div>

                <div class="btn-group">
                    <button class="btn btn-primary mt-3" id="addNewShipAddressBtn">Add New Address</button>
                    <button class="btn btn-primary ml-1 mt-3" id="discardNewShipAddressBtn" style="display:none;">Discard</button>
                </div>

                <div id="shipadddetail" class="px-2" style="display:none;">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="John" name="shipfname" id="shipfname">
                                <p class="text-danger" id="v_fname"></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="Doe" name="shiplname" id="shiplname">
                                <p class="text-danger" id="v_lname"></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="example@email.com" name="shipemail" id="shipemail">
                                <p class="text-danger" id="v_email"></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="+123 456 789" name="shipphone" id="shipmobile">
                                <p class="text-danger" id="v_mobile"></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="123 Street" name="shipadr1" id="shipadr1">
                                <p class="text-danger" id="v_adr1"></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="123 Street" name="shipadr2" id="shipadr2">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Pincode</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="pincode" name="shipzipcode" id="shipzipcode" >
                                <p class="text-danger" id="v_zipcode"></p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="City" name="shipcity" id="shipcity" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="State" name="shipstate" id="shipstate" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <input class="form-control" type="text" form="shipdetail" placeholder="Country" name="shipcountry" id="shipcountry" readonly>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>

                
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <?php
                         $subtotal = 0;
                         $shipping = 10;
                         $sum = 0;
                         foreach($cur as $cart)
                         {
                            if($_SESSION["country"] == "India")
                            {
                                $mrpprice = $cart->ORIGINALPRICE;
                                $dpprice = $cart->PROPRICE;
                            }else{
                                $mrpprice = $cart->USDMRP;
                                $dpprice = $cart->USDPRICE;
                            }
                            $sum = $dpprice *$cart->CARTQTY;
                            $subtotal += $sum;
                            echo '
                            <div class="d-flex justify-content-between">
                            <p>'.$cart->PROTITLE.'</p>
                            <p>'.$currencysymbol,number_format($dpprice * $cart->CARTQTY,2,'.','').'</p>
                            </div>
                            ';
                         }
                         $discount = isset($_SESSION["user_promocode"])?($_SESSION["user_promocodetype"]=='Flat'?$_SESSION["user_promocode"]:min($subtotal*$_SESSION["user_promocode"]/112, $_SESSION["user_promocodemax"])):0;
                         $tax = ($subtotal/1.12 - $discount)*0.12;
                         $total = $subtotal/1.12 - $discount + $tax;
                        ?>
                        
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium"><?= $currencysymbol,number_format($subtotal,2,'.','') ?></h6>
                        </div>
                        <?php if(isset($_SESSION["user_promocode"])) { ?>
                        <div class="d-flex justify-content-between align-items-end mb-3 pt-1">
                            <div>
                                <h6 class="font-weight-medium">Discount</h6>
                                <h6 class="font-weight-medium"><?=$_SESSION['user_promocodetitle']?></h6>
                            </div>
                            <h6 class="font-weight-medium text-danger">(-) <?= $currencysymbol,number_format($discount, 2, '.', '') ?></h6>
                        </div>
                        <?php } ?>
                        <div class="d-flex justify-content-between pt-1">
                            <h6 class="font-weight-medium">Tax (12%)</h6>
                            <h6 class="font-weight-medium"><?= $currencysymbol,number_format($tax, 2 ,'.', '') ?></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold"><?= $currencysymbol,number_format($total, 2, '.', '') ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <!--<div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="xpaypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                    </div>-->
                    <?php 
                    if($_SESSION["country"] == "India")
                    {
                    ?>
                    <div class="card-footer border-secondary bg-transparent px-0">
                        <button class="btn btn-lg btn-block btn-info font-italic rounded font-weight-bold text-white" onclick="startPayment()">Razorpay</button>
                    </div>
                    <div id="paypal-button-container"></div>
                    <?php } else { ?>
                    <div id="paypal-button-container"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->


    <!-- Footer Start -->
    <?php
    include('footer.php');
    $keyId = 'rzp_test_U69zpSNmMVKSaT';
    $keySecret = 'h61iFO2YT2aeVEvAhZVrXIWs';
    $api = new Api($keyId, $keySecret);

// Create an order
     $orderData = [
    'amount' => $total*100,  // Amount in paise (example: 1000 paise = ₹10)
    'currency' => 'INR',
    'receipt' => 'order_rcptid_' . time(),
    'payment_capture' => 1 // Auto-capture the payment
    ];

$order = $api->order->create($orderData);

// Get the order ID
$orderId = $order['id'];
    ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>



    <!--  validate  -->
    <!-- <script>
    fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(data => {
            const countryDropdown = document.getElementById('country');
            data.forEach(country => {
                const option = document.createElement('option');
                option.value = country.name.common.toLowerCase();
                option.textContent = country.name.common;
                countryDropdown.appendChild(option);
            });
        })
        .catch(error => console.error(error));
</script> -->
<script>
    function updateCityState(pincode) {
        $.ajax({
            url: 'https://api.postalpincode.in/pincode/' + pincode,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data[0].Status === 'Success') {
                    var postOffice = data[0].PostOffice[0];
                    $('#city').val(postOffice.District);
                    $('#state').val(postOffice.State);
                    $('#country').val(postOffice.Country);

                } else {
                    console.error('Invalid Pincode');
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
    function updateShipCityState(pincode) {
        $.ajax({
            url: 'https://api.postalpincode.in/pincode/' + pincode,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data[0].Status === 'Success') {
                    var postOffice = data[0].PostOffice[0];
                    $('#shipcity').val(postOffice.District);
                    $('#shipstate').val(postOffice.State);
                    $('#shipcountry').val(postOffice.Country);

                } else {
                    console.error('Invalid Pincode');
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    $('#zipcode').on('blur', function () {
        var pincode = $(this).val();
        updateCityState(pincode);
    });
    $('#shipzipcode').on('blur', function () {
        var pincode = $(this).val();
        updateShipCityState(pincode);
    });
</script>

    <script>

        function validate(){
            var fname = document.getElementById('fname').value
            var lname = document.getElementById('lname').value
            var email = document.getElementById('email').value
            var mobile = document.getElementById('mobile').value
            var adr1 = document.getElementById('adr1').value
            var zipcode = document.getElementById('zipcode').value


            if(fname.length == 0){
                document.getElementById('v_fname').innerText = "*required feild"
                
                return false
            }

            if(lname.length == 0){
                document.getElementById('v_lname').innerText = "*required feild"
                return false
            }

            if(email.length == 0){
                document.getElementById('v_email').innerText = "*required feild"
                return false
            }

            if(mobile.length == 0){
                document.getElementById('v_mobile').innerText = "*required feild"
                return false
            }

            if(adr1.length ==0){
                document.getElementById('v_adr1').innerText = "*required feild"
                return false
            }

            if(zipcode.length == 0){
                document.getElementById('v_zipcode').innerText = "*required feild"
                return false
            }


              return true
        }

    
    </script>

    
    <!-- Paypal -->

    <script src="https://www.paypal.com/sdk/js?client-id=AfFWfZFy_JfBvNl83FVqlwqZgMGa-KlOKK--yxn9lCTF8sK_KDZf-GKNgCYFRG0WWa9FT154cQnG22Fs&currency=<?=$currency ?>"></script>
     <script>
        paypal.Buttons({
            style: {
                layout: 'horizontal'
            },

            onClick(){
                return validate()
            },
    // Sets up the transaction when a payment button is clicked
    createOrder: (data, actions) => {
        return actions.order.create({
            "purchase_units": [{
                "amount": {
                    "currency_code": '<?=$currency ?>',
                    "value": <?= $total ?>
                }
            }]
        });
    },
    // Finalize the transaction after payer approval
    onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
            // console.log(orderData)
            document.getElementById('roi').value= orderData.id
                    document.getElementById('pai').value = orderData.payer.payer_id
                    document.getElementById('total').value = '<?= number_format($total, 2, '.', '') ?>'
                    document.getElementById('delfee').value = '<?= $shipping ?>'
                    document.getElementById('shipdetail').submit()
        })
        
    }
}).render('#paypal-button-container');
     </script>

    <!-- razorpay-->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function startPayment() {
            if(validate()){
            var options = {
                "key": "<?php echo $keyId; ?>",
                "amount": "<?php echo $orderData['amount']; ?>",
                "currency": "<?php echo $orderData['currency']; ?>",
                "name": "FinerFits",
                "description": "Test Payment",
                "order_id": "<?php echo $orderId; ?>",
                "handler": function (response){
                    // Handle the payment success response
                    document.getElementById('roi').value= response.razorpay_order_id
                    document.getElementById('pai').value = response.razorpay_payment_id
                    document.getElementById('total').value = '<?= number_format($total, 2, '.', '') ?>'
                    document.getElementById('delfee').value = '<?= $shipping ?>'
                    document.getElementById('shipdetail').submit()
                    //alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }
    }
    
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentSelectedAddress = getSelectedAddress();
        var currenSelectedShippingAddress = getSelectedAddress();
        var shippingAddressCheckbox = document.getElementById('shippingaddresscheck');
        var shippingAddressDetails = document.getElementById('shippingaddressdetails');
        restoreSelectedAddress(currentSelectedAddress);
        document.getElementById("neworderaddress").value=currentSelectedAddress.SHIPPINGADDRESSID;
        document.getElementById("newshippingaddress").value=currenSelectedShippingAddress.SHIPPINGADDRESSID;
        toggleShippingAddressDetails();

        function getSelectedAddress() {
            var selectedRadio = document.querySelector('input[name="addressRadio"]:checked');
            var selectedIndex = selectedRadio ? selectedRadio.value : null;
            return selectedIndex !== null ? <?php echo json_encode($curcustadds); ?>[selectedIndex] : null;
        }
        function getSelectedShippingAddress() {
            var selectedRadio = document.querySelector('input[name="shipAddressRadio"]:checked');
            var selectedIndex = selectedRadio ? selectedRadio.value : null;
            return selectedIndex !== null ? <?php echo json_encode($curcustadds); ?>[selectedIndex] : null;
        }
        
        function clearFormValues() {
            document.getElementById('fname').value = "";
            document.getElementById('lname').value = "";
            document.getElementById('email').value = "";
            document.getElementById('mobile').value = "";
            document.getElementById('adr1').value = "";
            document.getElementById('adr2').value = "";
            document.getElementById('zipcode').value = "";
            document.getElementById('city').value = "";
            document.getElementById('state').value = "";
            document.getElementById('country').value = "";
            // console.log(currentSelectedAddress);
            if(shippingAddressCheckbox.checked){
                clearShippingFormValues();
            }

        }
        function clearShippingFormValues() {
            document.getElementById('shipfname').value = "";
            document.getElementById('shiplname').value = "";
            document.getElementById('shipemail').value = "";
            document.getElementById('shipmobile').value = "";
            document.getElementById('shipadr1').value = "";
            document.getElementById('shipadr2').value = "";
            document.getElementById('shipzipcode').value = "";
            document.getElementById('shipcity').value = "";
            document.getElementById('shipstate').value = "";
            document.getElementById('shipcountry').value = "";
        }
        function restoreSelectedAddress(address) {
            if (address !== null) {
                document.getElementById('fname').value = address.FNAME;
                document.getElementById('lname').value = address.LNAME;
                document.getElementById('email').value = address.EMAIL;
                document.getElementById('mobile').value = address.PHONENO;
                document.getElementById('adr1').value = address.STREETADD;
                document.getElementById('adr2').value = address.BRGYADD;
                document.getElementById('zipcode').value = address.ZIPCODE;
                document.getElementById('city').value = address.CITYADD;
                document.getElementById('state').value = address.PROVINCE;
                document.getElementById('country').value = address.COUNTRY;
                // console.log(currentSelectedAddress);
                // console.log("BILL",address);

                if(shippingAddressCheckbox.checked){
                    restoreSelectedShippingAddress(address);
                }

            }
        }
        function restoreSelectedShippingAddress(address) {
            document.getElementById('shipfname').value = address.FNAME;
            document.getElementById('shiplname').value = address.LNAME;
            document.getElementById('shipemail').value = address.EMAIL;
            document.getElementById('shipmobile').value = address.PHONE;
            document.getElementById('shipadr1').value = address.STREETADD;
            document.getElementById('shipadr2').value = address.BRGYADD;
            document.getElementById('shipzipcode').value = address.ZIPCODE;
            document.getElementById('shipcity').value = address.CITYADD;
            document.getElementById('shipstate').value = address.PROVINCE;
            document.getElementById('shipcountry').value = address.COUNTRY;
            // console.log("SHIP",address);
        }
        function toggleShippingAddressDetails() {
            shippingAddressDetails.style.display = shippingAddressCheckbox.checked ? 'none' : 'block';
            if(shippingAddressCheckbox.checked){
                restoreSelectedShippingAddress(currentSelectedAddress);
                currenSelectedShippingAddress=getSelectedAddress();
                document.getElementById("ordereqshipping").value = "yes";
            } else {
                if (document.getElementById('shipadddetail').style.display !== 'block') {
                    currenSelectedShippingAddress =getSelectedShippingAddress();
                    restoreSelectedShippingAddress(currenSelectedShippingAddress);
                }
                document.getElementById("ordereqshipping").value = "no";
            }
        }
        document.getElementById('addNewAddressBtn').addEventListener('click', function () {
            currentSelectedAddress = getSelectedAddress();
            document.getElementById('shipdetail').style.display = 'block';
            document.getElementById('alladdressbill').style.display = 'none';
            document.getElementById('discardNewAddressBtn').style.display = 'block';
            document.getElementById("neworderaddress").value="yes";
            clearFormValues();
            // console.log("BILL",document.getElementById("neworderaddress"));

        });
        document.getElementById('discardNewAddressBtn').addEventListener('click', function () {
            document.getElementById('shipdetail').style.display = 'none';
            document.getElementById('alladdressbill').style.display = 'block';
            document.getElementById('discardNewAddressBtn').style.display = 'none';
            document.getElementById("neworderaddress").value="no";
            document.getElementById("neworderaddress").value=currentSelectedAddress.SHIPPINGADDRESSID;
            restoreSelectedAddress(currentSelectedAddress); 
            // console.log("BILL",document.getElementById("neworderaddress"));
        });
        document.getElementById('addNewShipAddressBtn').addEventListener('click', function () {
            document.getElementById('shipadddetail').style.display = 'block';
            document.getElementById('alladdressship').style.display = 'none';
            document.getElementById('discardNewShipAddressBtn').style.display = 'block';
            document.getElementById("newshippingaddress").value="yes";
            clearShippingFormValues();
            // console.log("SHIP",document.getElementById("newshippingaddress"));

        });
        document.getElementById('discardNewShipAddressBtn').addEventListener('click', function () {
            currentSelectedShippingAddress = getSelectedShippingAddress();
            document.getElementById('shipadddetail').style.display = 'none';
            document.getElementById('alladdressship').style.display = 'block';
            document.getElementById('discardNewShipAddressBtn').style.display = 'none';
            document.getElementById("newshippingaddress").value="no";
            document.getElementById("newshippingaddress").value=currenSelectedShippingAddress.SHIPPINGADDRESSID;
            restoreSelectedShippingAddress(currentSelectedShippingAddress);
            // console.log("SHIP",document.getElementById("newshippingaddress"));

        });
        var radioButtons = document.querySelectorAll('input[name="addressRadio"]');
        radioButtons.forEach(function (radioButton) {
            radioButton.addEventListener('change', function () {
                if (document.getElementById('shipdetail').style.display !== 'block') {
                    // Update form values only if the form is not displayed
                    var selectedIndex = this.value;
                    currentSelectedAddress = <?php echo json_encode($curcustadds); ?>[selectedIndex]
                    restoreSelectedAddress(currentSelectedAddress);
                    document.getElementById("neworderaddress").value=currentSelectedAddress.SHIPPINGADDRESSID;
                    console.log("BILL",document.getElementById("neworderaddress"));
                    if(shippingAddressCheckbox.checked){
                        currenSelectedShippingAddress = <?php echo json_encode($curcustadds); ?>[selectedIndex]
                        document.getElementById("newshippingaddress").value=currenSelectedShippingAddress.SHIPPINGADDRESSID;
                        restoreSelectedShippingAddress(currenSelectedShippingAddress);
                        // console.log("SHIP",document.getElementById("newshippingaddress"));
                    }
                }
            });
        });
        var radioButtonsShip = document.querySelectorAll('input[name="shipAddressRadio"]');
        radioButtonsShip.forEach(function (radioButton) {
            radioButton.addEventListener('change', function () {
                if (document.getElementById('shipadddetail').style.display !== 'block') {
                    // Update form values only if the form is not displayed
                    var selectedIndex = this.value;
                    currentSelectedShippingAddress = <?php echo json_encode($curcustadds); ?>[selectedIndex]
                    restoreSelectedShippingAddress(currentSelectedShippingAddress);
                    document.getElementById("newshippingaddress").value=currenSelectedShippingAddress.SHIPPINGADDRESSID;
                    // console.log("SHIP",document.getElementById("newshippingaddress"));
                }
            });
        });
        shippingAddressCheckbox.addEventListener('change', function () {
            toggleShippingAddressDetails();
        });
    });
</script>
</body>

</html>
