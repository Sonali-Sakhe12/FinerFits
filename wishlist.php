<?php
  require_once("include/initialize.php");
  if (isset($_POST['wishId']) && isset($_POST['action']) && isset($_POST['userid']) && isset($_SESSION['USER']) && $_POST['userid']==$_SESSION["USER"]) {
    $wishId = $_POST['wishId'];
    $action = $_POST['action'];
    // error_log($proId.$action, 3, "logfile.log");

    if ($action === 'remove') {
        $mydb->setQuery("DELETE FROM tblwishlist WHERE WISHLISTID = ".$wishId." AND CUSTOMERID = ".$_SESSION["USER"]);
        $result = $mydb->executeQuery(); 
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'isWishlisted' => false]);
        }
    }
    exit;
}
  if(!isset($_SESSION["USER"])){
    redirect(web_root);
  }
  $mydb->setQuery("SELECT w.*, p.PROTITLE
                    FROM tblwishlist w
                    JOIN tblproduct p ON w.PROID = p.PROID
                    WHERE w.CUSTOMERID = ".$_SESSION["USER"]);
    $wishes = $mydb->loadResultList();
?>










<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wishlist @ FinerFits</title>
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
    <style>
    /* Cart or Wishlist */
.shopping-cart .cart-header{
    padding: 10px;
}
.shopping-cart .cart-header h4{
    font-size: 18px;
    margin-bottom: 0px;
}
.shopping-cart .cart-item a{
    text-decoration: none;
}
.shopping-cart .cart-item{
    background-color: #fff;
    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
    padding: 10px 10px;
    margin-top: 10px;
}
.shopping-cart .cart-item .product-name{
    font-size: 16px;
    font-weight: 600;
    width: 100%;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    cursor: pointer;
}
.shopping-cart .cart-item .price{
    font-size: 16px;
    font-weight: 600;
    padding: 4px 2px;
}
.shopping-cart .btn1{
    border: 1px solid;
    margin-right: 3px;
    border-radius: 0px;
    font-size: 10px;
}
.shopping-cart .btn1:hover{
    background-color: #2874f0;
    color: #fff;
}
.shopping-cart .input-quantity{
    border: 1px solid #000;
    margin-right: 3px;
    font-size: 12px;
    width: 40%;
    outline: none;
    text-align: center;
}
</style>
</head>

<body>
    <!-- Topbar Start -->
     <?php
     include('header.php');
    ?> 
    

    <!-- customer details -->
    
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center mb-4">Your Wishlist</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">

                    <?php if(count($wishes)==0){
                        echo '<div class="cart-item text-center">
                        Your wishlist is empty...</div>';
                    }?>
                        <?php 
                        foreach($wishes as $wish){
                            $image = New Image();
                            $img =  $image->single_image($wish->PROID);
                            echo '<div class="cart-item">
                                <div class="row">
                                    <div class="col-md-6 ml-3 my-auto">
                                        <a href="product.php?id='.$wish->PROID.'">
                                            <label class="product-name">
                                                <img src="admin/products/uploaded_photos/' . $img->file_name . '" style="width: 100px; margin-right:20px;" alt="">
                                                '.$wish->PROTITLE.'
                                            </label>
                                        </a>
                                    </div>
                                    <div class="col-5 col-md-2 ml-auto my-auto">
                                        <div class="remove">
                                            <a href="" data-id="'.$wish->WISHLISTID.'" data-userid="'.$wish->CUSTOMERID.'" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>
                        
                        
                        <!-- <div class="cart-item">
                            <div class="row">
                                <div class="col-md-6 my-auto">
                                    <a href="">
                                        <label class="product-name">
                                            <img src="hp-laptop.jpg" style="width: 50px; height: 50px" alt="">
                                            Hp Laptop
                                        </label>
                                    </a>
                                </div>
                                
                               
                                <div class="col-md-2 col-5 my-auto">
                                    <div class="remove">
                                        <a href="" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>


    $('.remove a').on('click', function(e) {
                e.preventDefault();
                var wishId = $(this).data('id');
                var userid = $(this).data('userid');
                var action = "remove";

                $.ajax({
                    url: 'wishlist.php',
                    type: 'POST',
                    contentType: 'application/x-www-form-urlencoded',
                    data: {
                        wishId: wishId,
                        action: action,
                        userid: userid
                    },
                    success: function(data) {
                        if (data.success) {
                            location.reload();
                        } else {
                            location.reload();
                            console.error('Failed to update wishlist status');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
    </script>



    <?php
    include('footer.php');
    ?>
    
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> -->
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <!-- <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script> -->

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

   </body>
</html>