<?php
  require_once("include/initialize.php");
  if(!isset($_SESSION["USER"])){
    redirect(web_root);
    // $_SESSION["USER"]=31;
  } 
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
  if(isset($_POST["customerid"]) && isset($_SESSION["USER"]) && $_SESSION["USER"]==$_POST["customerid"]){
    $response = array();
    $query = 'UPDATE tblcustomer SET EMAILADD = "'.$_POST["email"].'", PHONE = "'.$_POST["phone"].'", FNAME = "'.$_POST["fname"].'", CUSERNAME = "'.$_POST["username"];
    if($_POST["password"]!==""){
        $hashPassword = hash('sha256', $_POST["password"]);
        $query .= '", CPASSWORD = "'.$hashPassword;
    }
    $query .= '"  WHERE CUSTOMERID = '.$_POST["customerid"].';';
    $mydb->setQuery($query);
    $result = $mydb->executeQuery();

    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Profile updated successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to update profile';
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }
  if(isset($_POST["useridaddress"]) && isset($_SESSION["USER"]) && $_SESSION["USER"]==$_POST["useridaddress"]){
    $response = array();
    if(isset($_POST["add_address_submit"])){
        $query='INSERT INTO tblshippingaddress (CUSTOMERID, FNAME, LNAME, PHONENO, EMAIL, STREETADD, BRGYADD, CITYADD, PROVINCE, COUNTRY, ZIPCODE) VALUES ('.$_POST["useridaddress"].',"'.$_POST["firstnameaddress"].'","'.$_POST["lastnameaddress"].'","'.$_POST["phoneaddress"].'","'.$_POST["emailaddress"].'","'.$_POST["line1address"].'","'.$_POST["line2address"].'","'.$_POST["cityaddress"].'","'.$_POST["stateaddress"].'","'.$_POST["countryaddress"].'",'.$_POST["pincodeaddress"].')';
        $mydb->setQuery($query);
        $result = $mydb->executeQuery();

        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Address added successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to add address';
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else if (isset($_POST["edit_address_submit"])){
        $query = 'UPDATE tblshippingaddress SET ' .
                    'CUSTOMERID=0,' .
                    ' WHERE SHIPPINGADDRESSID=' . $_POST["idaddress"];
        $mydb->setQuery($query);
        $mydb->executeQuery();
        $query='INSERT INTO tblshippingaddress (CUSTOMERID, FNAME, LNAME, PHONENO, EMAIL, STREETADD, BRGYADD, CITYADD, PROVINCE, COUNTRY, ZIPCODE) VALUES ('.$_POST["useridaddress"].',"'.$_POST["firstnameaddress"].'","'.$_POST["lastnameaddress"].'","'.$_POST["phoneaddress"].'","'.$_POST["emailaddress"].'","'.$_POST["line1address"].'","'.$_POST["line2address"].'","'.$_POST["cityaddress"].'","'.$_POST["stateaddress"].'","'.$_POST["countryaddress"].'",'.$_POST["pincodeaddress"].')';
        $mydb->setQuery($query);
        $result = $mydb->executeQuery();

        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Address updated successfully';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to update address';
        }

        // Send JSON response
        if($_POST["defaultaddress"]=="yes"){
            $query = 'UPDATE tblcustomer SET ' .
            'STREETADD="' . $_POST["line1address"] . '",' .
            'BRGYADD="' . $_POST["line2address"] . '",' .
            'CITYADD="' . $_POST["cityaddress"] . '",' .
            'PROVINCE="' . $_POST["stateaddress"] . '",' .
            'COUNTRY="' . $_POST["countryaddress"] . '",' .
            'ZIPCODE="' . $_POST["pincodeaddress"] . '"' .
            ' WHERE CUSTOMERID=' . $_POST["useridaddress"];
            $mydb->setQuery($query);
            $mydb->executeQuery();
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    exit;
  }
  if(isset($_POST["userid"]) && isset($_SESSION["USER"]) && $_SESSION["USER"]==$_POST["userid"] && isset($_POST["make_default_address"])){
    $response = array();
    $mydb->setQuery("SELECT * FROM tblshippingaddress where SHIPPINGADDRESSID = ".$_POST["address_id"]);
    $curAddress=$mydb->loadSingleResult();
    $query = 'UPDATE tblcustomer SET ' .
            'STREETADD="' . $curAddress->STREETADD . '",' .
            'BRGYADD="' . $curAddress->BRGYADD . '",' .
            'CITYADD="' . $curAddress->CITYADD . '",' .
            'PROVINCE="' . $curAddress->PROVINCE . '",' .
            'COUNTRY="' . $curAddress->COUNTRY . '",' .
            'ZIPCODE="' . $curAddress->ZIPCODE . '",' .
            'DEFAULTADDRESSID=' . $_POST["address_id"] .
            ' WHERE CUSTOMERID=' . $_POST["userid"];
    $mydb->setQuery($query);
    $result = $mydb->executeQuery();

    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Default address updated successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to update default address';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }
  if(isset($_POST["userid"]) && isset($_SESSION["USER"]) && $_SESSION["USER"]==$_POST["userid"] && isset($_POST["delete_address"])){
    $response = array();
    $query = 'UPDATE tblshippingaddress SET ' .
            'CUSTOMERID=0'.
            ' WHERE SHIPPINGADDRESSID=' . $_POST["address_id"];
    $mydb->setQuery($query);
    $result = $mydb->executeQuery();

    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Default address updated successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to update default address';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }
  if(isset($_POST["orderid"]) && isset($_SESSION["USER"]) && isset($_POST["cancel_order_user"])){
    $response = array();
    $query = 'UPDATE tblsummary SET ' .
            'ORDEREDSTATS="Cancelled",'.
            'ORDEREDREMARKS="Order was cancelled by user"'.
            ' WHERE ORDEREDNUM=' . $_POST["orderid"];
    $mydb->setQuery($query);
    $result = $mydb->executeQuery();

    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Order Cancelled successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to cancel order';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }
    $mydb->setQuery("SELECT * FROM tblcustomer where CUSTOMERID = ".$_SESSION["USER"]);
    $curCustomer=$mydb->loadSingleResult();
    $mydb->setQuery("SELECT * FROM tblshippingaddress where CUSTOMERID = ".$_SESSION["USER"]);
    $curCustomerAddresses=$mydb->loadResultList();
    $query = 'SELECT s.CUSTOMERID, MIN(s.ORDEREDNUM) AS ORDEREDNUM, s.*, o.*
        FROM tblsummary s
        JOIN tblorder o ON o.ORDEREDNUM = s.ORDEREDNUM
        WHERE s.CUSTOMERID = '.$_SESSION["USER"].'
        GROUP BY s.CUSTOMERID, o.ORDEREDNUM 
        ORDER BY s.ORDEREDDATE DESC;';
    $mydb->setQuery($query);
    $curOrders = $mydb->loadResultList();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Contact @ FinerFits</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .accordion-button:focus{
            background-color: #fff !important;
        }
        .accordion-button:not(.collapsed){
            background-color: #fff !important;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
     <?php
     include('header.php');
    ?> 
    <!-- customer details -->

    <form id="addressAEForm" method="post"></form>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddressTitle">Add address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <input name="defaultaddress" id="defaultaddress" type="hidden" form="addressAEForm" value="" />
                            <input name="useridaddress" id="useridaddress" type="hidden" form="addressAEForm" value="<?php echo $curCustomer->CUSTOMERID; ?>" />
                            <input name="idaddress" id="idaddress" type="hidden" form="addressAEForm" value="" />
                            <label for="firstnameddress">First name</label>
                            <input class="form-control" type="text" name="firstnameaddress" id="firstnameaddrress" placeholder="Enter first name.." form="addressAEForm" value=""/>
                        </div>
                        <div class="col-6">
                            <label for="lastnameaddress">Last name</label>
                            <input class="form-control" type="text" name="lastnameaddress" id="lastnameaddress" placeholder="Enter last name.." form="addressAEForm" value=""/>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="emailaddress">Email</label>
                            <input class="form-control" type="email" name="emailaddress" id="emailaddress" placeholder="Enter email.." form="addressAEForm" value=""/>
                        </div>
                        <div class="col-6">
                            <label for="phoneaddress">Phone no.</label>
                            <input class="form-control" type="text" name="phoneaddress" id="phoneaddress" placeholder="Enter phone.." form="addressAEForm" value=""/>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="line1address">Address Line 1</label>
                            <input class="form-control" type="text" name="line1address" id="line1address" placeholder="Flat, Building" form="addressAEForm" value=""/>
                        </div>
                        <div class="col-12">
                            <label for="line2address">Address Line 2</label>
                            <input class="form-control" type="text" name="line2address" id="line2address" placeholder="Street, Area" form="addressAEForm" value=""/>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="pincodeaddress">Pincode</label>
                            <input class="form-control" type="text" name="pincodeaddress" id="pincodeaddress" placeholder="Enter pincode.." form="addressAEForm" value=""/>
                        </div>
                        <div class="col-12">
                            <label for="cityaddress">City</label>
                            <input class="form-control" type="text" name="cityaddress" id="cityaddress" placeholder="City" form="addressAEForm" value="" readonly/>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <label for="stateaddress">State</label>
                            <input class="form-control" type="text" name="stateaddress" id="stateaddress" placeholder="State" form="addressAEForm" value="" readonly/>
                        </div>
                        <div class="col-12">
                            <label for="countryaddress">Country</label>
                            <input class="form-control" type="text" name="countryaddress" id="countryaddress" placeholder="Country" form="addressAEForm" value="" readonly/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="addressAEsubmit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-11 col-lg-2 border p-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-addresses" role="tab" aria-controls="v-pills-addressses" aria-selected="false">Addresses</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">Orders</a>
                    </div>
                </div>
                <div class="col-11 col-lg-6 border">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <h4 class="p-2">Profile Details</h4>
                            <table class="table table-borderless" id="profileDisplay">
                                <tbody>
                                    <tr>
                                        <td>Full Name:</td>
                                        <td><?php echo $curCustomer->FNAME." ".$curCustomer->LNAME;?></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><?php echo $curCustomer->EMAILADD;?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td><?php echo $curCustomer->PHONE;?></td>
                                    </tr>
                                    <tr>
                                        <td>Username:</td>
                                        <td><?php echo $curCustomer->CUSERNAME;?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="profileEditForm" class="px-3" style="display:none;">
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <label for="firstname">First name</label>
                                        <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter first name.." value="<?php echo $curCustomer->FNAME;?>"/>
                                    </div>
                                    <div class="col-4">
                                        <label for="lastname">Last name</label>
                                        <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Enter last name.." value="<?php echo $curCustomer->LNAME;?>"/>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <label for="email">Email<span id="warningEmailText" class="text-danger" style="font-size: 6px;"></span></label>
                                        <input class="form-control" type="email" name="email" id="email" placeholder="Enter email.." value="<?php echo $curCustomer->EMAILADD;?>"/>
                                    </div>
                                    <div class="col-4">
                                        <label for="phone">Phone no.<span id="warningPhoneText" class="text-danger" style="font-size: 6px;"></span></label>
                                        <input class="form-control" type="text" name="phone" id="phone" placeholder="Enter phone.." value="<?php echo $curCustomer->PHONE;?>"/>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <label for="username">Username<span id="warningUsernameText" class="text-danger" style="font-size: 6px;"></span></label>
                                        <input class="form-control" type="text" name="username" id="username" placeholder="Enter username.." value="<?php echo $curCustomer->CUSERNAME;?>"/>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Enter password.." value=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-2 mb-4">
                                <button class="btn btn-primary col-7" id="profileToggle" onclick="handleProfileToggle()" type="button">EDIT</button>
                            </div>
                            <div class="row mx-2 mb-4">
                                <a class="btn btn-secondary col-7" id="logoutToggle" href="logout.php">LOGOUT</a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-addresses" role="tabpanel" aria-labelledby="v-pills-addresses-tab">
                            <h4 class="p-2">Saved Addresses</h4>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-add-type="add"><i class="fa fa-plus"></i> ADD NEW ADDRESS</button>
                            <div>
                                <div class="accordion" id="accordionAddresses">
                                    <h6>Default Address</h6>
                                    <div class="accordion-item border">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button pb-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div>
                                                    <strong class="mb-3"><?php echo $curCustomer->FNAME.' '.$curCustomer->LNAME; ?></strong>
                                                    <p class="mb-1"><?php echo $curCustomer->STREETADD; ?>,</p>
                                                    <p class="mb-1"><?php echo $curCustomer->BRGYADD; ?>,</p>
                                                    <p class="mb-1"><?php echo $curCustomer->CITYADD.' - '.$curCustomer->ZIPCODE; ?></p>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionAddresses">
                                            <div class="accordion-body pt-0">
                                                <p class="mb-1"><?php echo $curCustomer->PROVINCE.', '.$curCustomer->COUNTRY; ?></p>
                                                <p class="mb-1">Mobile Number : <?php echo $curCustomer->PHONE; ?></p>
                                                <p class="mb-1">Email : <?php echo $curCustomer->EMAILADD; ?></p>
                                                <div class="btn-group container-fluid p-0" role="group">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-add-type="edit" data-bs-add-id="<?php echo $curCustomer->DEFAULTADDRESSID; ?>" data-bs-add-fname="<?php echo $curCustomer->FNAME; ?>" data-bs-add-lname="<?php echo $curCustomer->LNAME; ?>" data-bs-add-add1="<?php echo $curCustomer->STREETADD; ?>" data-bs-add-add2="<?php echo $curCustomer->BRGYADD; ?>" data-bs-add-city="<?php echo $curCustomer->CITYADD; ?>" data-bs-add-pincode="<?php echo $curCustomer->ZIPCODE; ?>" data-bs-add-state="<?php echo $curCustomer->PROVINCE; ?>" data-bs-add-country="<?php echo $curCustomer->COUNTRY; ?>" data-bs-add-phone="<?php echo $curCustomer->PHONE; ?>" data-bs-add-email="<?php echo $curCustomer->EMAILADD; ?>" data-bs-add-default="yes">EDIT</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="mt-4">All Addresses</h6>
                                    <?php 
                                    foreach ($curCustomerAddresses as $address) {
                                        // Extract address details
                                        $fname = $address->FNAME;
                                        $lname = $address->LNAME;
                                        $street = $address->STREETADD;
                                        $brgy = $address->BRGYADD;
                                        $city = $address->CITYADD;
                                        $pincode = $address->ZIPCODE;
                                        $state = $address->PROVINCE;
                                        $country = $address->COUNTRY;
                                        $phone = $address->PHONENO;
                                        $email = $address->EMAIL;
                                        $addressId = $address->SHIPPINGADDRESSID;
                                        $customerId = $curCustomer->CUSTOMERID;
                                    
                                        // Output the HTML for each address
                                        echo '
                                        <div class="accordion-item border mb-3">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button pb-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $addressId . '" aria-expanded="false" aria-controls="collapse' . $addressId . '">
                                                    <div>
                                                        <strong class="mb-3">' . $fname . ' ' . $lname . '</strong>
                                                        <p class="mb-1">' . $street . '</p>
                                                        <p class="mb-1">' . $brgy . '</p>
                                                        <p class="mb-1">' . $city . ' - ' . $pincode . '</p>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse' . $addressId . '" class="accordion-collapse collapse" data-bs-parent="#accordionAddresses">
                                                <div class="accordion-body pt-0">
                                                    <p class="mb-1">' . $state . ', ' . $country . '</p>
                                                    <p class="mb-1">Mobile Number: ' . $phone . '</p>
                                                    <p class="mb-1">Email: ' . $email . '</p>'.
                                                    ($addressId !== $curCustomer->DEFAULTADDRESSID ? '<button class="btn btn-outline-info mb-2 makeDefaultAddress" data-bs-add-id="' . $addressId . '" data-bs-add-userid="' . $customerId . '">MAKE THIS DEFAULT</button>' : "")
                                                    .'<div class="btn-group container-fluid p-0" role="group">
                                                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-add-type="edit" data-bs-add-id="' . $addressId . '" data-bs-add-fname="' . $fname . '" data-bs-add-lname="' . $lname . '" data-bs-add-add1="' . $street . '" data-bs-add-add2="' . $brgy . '" data-bs-add-city="' . $city . '" data-bs-add-pincode="' . $pincode . '" data-bs-add-state="' . $state . '" data-bs-add-country="' . $country . '" data-bs-add-phone="' . $phone . '" data-bs-add-email="' . $email . '" data-bs-add-default="no">EDIT</button>'.
                                                        ($addressId !== $curCustomer->DEFAULTADDRESSID ?'<button type="button" class="btn btn-primary ms-1 deleteAddress" data-bs-add-id="' . $addressId . '" data-bs-add-userid="' . $customerId . '">REMOVE</button>':"")
                                                    .'</div>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                    ?>
                                    <!-- <div class="accordion-item border mb-3">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button pb-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <div>
                                                    <strong class="mb-3">John Doe</strong>
                                                    <p class="mb-1">123 Street</p>
                                                    <p class="mb-1">123 Area</p>
                                                    <p class="mb-1">City - PINCODE</p>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionAddresses">
                                            <div class="accordion-body pt-0">
                                                <p class="mb-1">State, Country</p>
                                                <p class="mb-1">Mobile Number : Mobile</p>
                                                <p class="mb-1">Email : Email</p>
                                                <button class="btn btn-outline-info mb-2 makeDefaultAddress" data-bs-add-id="2" data-bs-add-userid="<?php //echo $curCustomer->CUSTOMERID; ?>">MAKE THIS DEFAULT</button>
                                                <div class="btn-group container-fluid p-0" role="group">
                                                    <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-add-type="edit" data-bs-add-id="2" data-bs-add-fname="John" data-bs-add-lname="Doe" data-bs-add-add1="123 Street" data-bs-add-add2="123 Area" data-bs-add-city="City" data-bs-add-pincode="PINCODE" data-bs-add-state="State" data-bs-add-country="Country" data-bs-add-phone="Mobile" data-bs-add-email="Email" data-bs-add-default="no">EDIT</button>
                                                    <button type="button" class="btn btn-primary ms-1" data-bs-add-id="2">REMOVE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- Add more cards as needed -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                            <h4 class="p-2">Orders</h4>
                            <div id="ordersContainer">
                                <?php

                                foreach ($curOrders as $order) {
                                    $query = "SELECT * FROM `tblproduct` p, `tblorder` o WHERE p.`PROID` = o.`PROID` AND o.`ORDEREDNUM` = " . $order->ORDEREDNUM;
                                    $mydb->setQuery($query);
                                    $items = $mydb->loadResultList();
                                    echo'<table class="table table-bordered">';
                                    echo'<tr><td colspan="2">Order #'.$order->ORDEREDNUM.' ['.($order->ORDEREDSTATS === "Received"?"Not yet confirmed":($order->ORDEREDSTATS === "Fulfilled"?"Delivered":($order->ORDEREDSTATS === "Confirmed"?"Processing":$order->ORDEREDSTATS))).']</td></tr>';
                                    foreach ($items as $item) {
                                        $image = New Image();
                                        $img =  $image->single_image($item->PROID);
                                        echo '
                                        <tr>
                                        <td class="align-middle white-space-nowrap py-2"><a style="display:flex;justify-content:center; align-items:center;" class="border border-translucent rounded-2" href="product.php?id='.$item->PROID.'" target="_blank"><img class="rounded-1" style="margin:5px;" src="admin/products/uploaded_photos/'.$img->file_name.'" alt="" width="50" /></a></td>
                                        <td><a class="fw-semibold text-dark mb-0" href="product.php?id='.$item->PROID.'" target="_blank">'.$item->PROTITLE.'</a>'.getSpecifications($item).'</td>
                                        </tr>
                                        ';
                                    }
                                    echo'<tr><td colspan="2"><a class="btn btn-outline-info mb-2" href="bill.php?orderid='.$order->ORDEREDNUM.'" target="_blank">GET INVOICE</a><div class="col-12 p-0 btn-group"><a class="btn btn-primary me-1" href="tracking.php?id='.$order->ORDEREDNUM.'">TRACK ORDER</a><button class="btn btn-primary ms-1 cancelOrderUserBtn" data-bs-orderid="'.$order->ORDEREDNUM.'" '.($order->ORDEREDSTATS === "Received"?"":"disabled").'>'.($order->ORDEREDSTATS === "Received"?"CANCEL ORDER":"ORDER NOT CANCELLABLE").'</button></div></td></tr>';
                                    echo'</table><hr>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php
    include('footer.php');
    ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <!-- <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script> -->

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        function updateCityState(pincode) {
            $.ajax({
                url: 'https://api.postalpincode.in/pincode/' + pincode,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data[0].Status === 'Success') {
                        var postOffice = data[0].PostOffice[0];
                        $('#cityaddress').val(postOffice.District);
                        $('#stateaddress').val(postOffice.State);
                        $('#countryaddress').val(postOffice.Country);

                    } else {
                        console.error('Invalid Pincode');
                    }
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
        function handleProfileToggle(){
            const view = document.getElementById("profileDisplay");
            const edit = document.getElementById("profileEditForm");
            const button = document.getElementById("profileToggle");
            if(edit.style.display==="none"){
            edit.style.display= "block";
            view.style.display= "none";
            button.innerHTML = 'SAVE'
            } else {
                var confirmation = confirm('Are you sure you want to your profile details?');
                if(confirmation) {
                    const id = "<?php echo $_SESSION["USER"];?>"
                    const email =document.getElementById("email").value;
                    const phone =document.getElementById("phone").value;
                    const fname =document.getElementById("firstname").value;
                    const lname =document.getElementById("lastname").value;
                    const username =document.getElementById("username").value;
                    const password =document.getElementById("password").value;

                    const xhr = new XMLHttpRequest();
                    xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        edit.style.display="none";
                        view.style.display= "block";
                        button.innerHTML = 'EDIT';
                        location.reload();
                    } else {
                        console.error("Resquest failed with status: " + xhr.status);
                    }
                    };
                    xhr.open('POST', 'useraccount.php', true);
                    const formData = new FormData();
                    formData.append('customerid', id);
                    formData.append('email', email);
                    formData.append('phone', phone);
                    formData.append('fname', fname);
                    formData.append('lname', lname);
                    formData.append('username', username);
                    formData.append('password', password);
                    xhr.send(formData);
                } else {
                edit.style.display="none";
                view.style.display= "block";
                button.innerHTML = 'EDIT';
                location.reload();
                }
            }
        }
        $(document).ready(function() {
            $('#pincodeaddress').on('blur', function () {
                var pincode = $(this).val();
                updateCityState(pincode);
            });
            $('#staticBackdrop').on('show.bs.modal', function(event) {
                $('body').css({
                    'overflow-y': 'hidden',
                    'width': '100vw',
                    'position': 'fixed'
                });
                $('#headerContainer').css({
                    'z-index': '1028',
                });
                const button = $(event.relatedTarget);
                const type = button.data('bs-add-type');
                if(type==="edit"){

                    const defaultflag = button.data('bs-add-default');
                    const addid = button.data('bs-add-id');
                    const fname = button.data('bs-add-fname');
                    const lname = button.data('bs-add-lname');
                    const add1 = button.data('bs-add-add1');
                    const add2 = button.data('bs-add-add2');
                    const city = button.data('bs-add-city');
                    const state = button.data('bs-add-state');
                    const country = button.data('bs-add-country');
                    const pincode = button.data('bs-add-pincode');
                    const phone = button.data('bs-add-phone');
                    const email = button.data('bs-add-email');
                    const modalTitle = $('#staticBackdrop').find('.modal-title');
                    modalTitle.text(`Edit Address`);
                    // Update input values
                    const modalBodyInput = $('#staticBackdrop').find('.modal-body input');
                    modalBodyInput.filter('[name="defaultaddress"]').val(defaultflag);
                    modalBodyInput.filter('[name="idaddress"]').val(addid);
                    modalBodyInput.filter('[name="firstnameaddress"]').val(fname);
                    modalBodyInput.filter('[name="lastnameaddress"]').val(lname);
                    modalBodyInput.filter('[name="line1address"]').val(add1);
                    modalBodyInput.filter('[name="line2address"]').val(add2);
                    modalBodyInput.filter('[name="cityaddress"]').val(city);
                    modalBodyInput.filter('[name="stateaddress"]').val(state);
                    modalBodyInput.filter('[name="countryaddress"]').val(country);
                    modalBodyInput.filter('[name="pincodeaddress"]').val(pincode);
                    modalBodyInput.filter('[name="phoneaddress"]').val(phone);
                    modalBodyInput.filter('[name="emailaddress"]').val(email);
                } else {
                    const modalTitle = $('#staticBackdrop').find('.modal-title');
                    modalTitle.text(`Add Address`);
                    const modalBodyInput = $('#staticBackdrop').find('.modal-body input');
                    modalBodyInput.filter('[name="idaddress"]').val("");
                    modalBodyInput.filter('[name="firstnameaddress"]').val("");
                    modalBodyInput.filter('[name="lastnameaddress"]').val("");
                    modalBodyInput.filter('[name="line1address"]').val("");
                    modalBodyInput.filter('[name="line2address"]').val("");
                    modalBodyInput.filter('[name="cityaddress"]').val("");
                    modalBodyInput.filter('[name="stateaddress"]').val("");
                    modalBodyInput.filter('[name="countryaddress"]').val("");
                    modalBodyInput.filter('[name="pincodeaddress"]').val("");
                    modalBodyInput.filter('[name="phoneaddress"]').val("");
                    modalBodyInput.filter('[name="emailaddress"]').val("");
                }
            });

            $('#staticBackdrop').on('hidden.bs.modal', function() {
                $('body').css({
                    'overflow-y': 'auto',
                    'width': 'auto',
                    'position': 'static'
                });
                $('#headerContainer').css({
                    'z-index': '1030',
                });
            });
            $('.cancelOrderUserBtn').on('click', function() {
                const orderId = $(this).data('bs-orderid');
                var formData = new FormData();
                formData.append('orderid', orderId);
                formData.append('cancel_order_user', 'true');

                $.ajax({
                    url: 'useraccount.php',
                    type: 'POST',
                    data: formData,
                    processData: false,  // important
                    contentType: false,  // important
                    dataType: 'json',
                    success: function(data) {
                    location.reload();
                    },
                    error: function(e) {
                    console.log(e);
                    alert(e);
                    }
                });
            });
            $('.makeDefaultAddress').on('click', function() {
                const addressId = $(this).data('bs-add-id');
                const userId = $(this).data('bs-add-userid');
                var formData = new FormData();
                formData.append('address_id', addressId);
                formData.append('userid', userId);
                formData.append('make_default_address', 'true');

                $.ajax({
                    url: 'useraccount.php',
                    type: 'POST',
                    data: formData,
                    processData: false,  // important
                    contentType: false,  // important
                    dataType: 'json',
                    success: function(data) {
                    location.reload();
                    },
                    error: function(e) {
                    console.log(e);
                    alert(e);
                    }
                });
            });
            $('.deleteAddress').on('click', function() {
                const addressId = $(this).data('bs-add-id');
                const userId = $(this).data('bs-add-userid');
                var formData = new FormData();
                formData.append('address_id', addressId);
                formData.append('userid', userId);
                formData.append('delete_address', 'true');

                $.ajax({
                    url: 'useraccount.php',
                    type: 'POST',
                    data: formData,
                    processData: false,  // important
                    contentType: false,  // important
                    dataType: 'json',
                    success: function(data) {
                    location.reload();
                    },
                    error: function(e) {
                    console.log(e);
                    alert(e);
                    }
                });

            });
        });
        <?php
        $query = "SELECT EMAILADD, PHONE, CUSERNAME FROM `tblcustomer`";
        $mydb->setQuery($query);
        $cur = $mydb->loadResultList(); 
        $emails="const existingEmails = [";
        $phones="const existingPhones = [";
        $usernames="const existingUsernames = [";
        foreach ($cur as $result) { 
        $emails.="'".$result->EMAILADD."',";
        $phones.="'".$result->PHONE."',";
        $usernames.="'".$result->CUSERNAME."',";
        }
        $emails.="];";
        $phones.="];";
        $usernames.="];";
        echo $emails;
        echo $phones;
        echo $usernames;
        ?>
        
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('email').addEventListener('input', function() {
                let inputId = this.value.toLowerCase().trim();
                const warningText = document.getElementById('warningEmailText');
                const submitButton = document.getElementById('profileToggle');

                if (existingEmails.includes(inputId) && inputId !== "<?php echo $curCustomer->EMAILADD;?>") {
                    warningText.textContent = 'This email is already associated with another account.';
                    submitButton.disabled = true;  
                    // this.value = '';
                } else {
                    warningText.textContent = '';
                    submitButton.disabled = false;  
                }
            }); 
            document.getElementById('phone').addEventListener('input', function() {
                let inputId = this.value.toLowerCase().trim();
                const warningText = document.getElementById('warningPhoneText');
                const submitButton = document.getElementById('profileToggle');

                if (existingPhones.includes(inputId) && inputId !== "<?php echo $curCustomer->PHONE;?>") {
                    warningText.textContent = 'This phone is already associated with another account.';
                    submitButton.disabled = true;  
                    // this.value = '';
                } else {
                    warningText.textContent = '';
                    submitButton.disabled = false;  
                }
            }); 
            document.getElementById('username').addEventListener('input', function() {
                let inputId = this.value.toLowerCase().trim();
                const warningText = document.getElementById('warningUsernameText');
                const submitButton = document.getElementById('profileToggle');

                if (existingUsernames.includes(inputId) && inputId !== "<?php echo $curCustomer->CUSERNAME;?>") {
                    warningText.textContent = 'This username is already being used.';
                    submitButton.disabled = true;  
                    // this.value = '';
                } else {
                    warningText.textContent = '';
                    submitButton.disabled = false;  
                }
            }); 
            document.getElementById('addressAEsubmit').addEventListener('click', function(e) {
                e.preventDefault();

                const form = document.getElementById('addressAEForm');
                const formData = new FormData(form);

                const idaddress = formData.get('idaddress');
                if (idaddress !== "") {
                    formData.append('edit_address_submit', 'true');
                } else {
                    formData.append('add_address_submit', 'true');
                }
                fetch('useraccount.php', {
                method: 'POST',
                body: formData
                })
                .then(response => response.json()) 
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    alert('Network error.');
                });
            });
        });
    </script>
</body>
</html>