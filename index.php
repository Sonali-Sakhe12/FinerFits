<?php
require_once("include/initialize.php");
$mydb->setQuery("SELECT p.*,CASE when c.id is null THEN '0' ELSE '1' END AS cart_status FROM tblproduct p left join tblcart c on c.PROID=p.PROID and c.USER= '" . session_id() . "' ORDER by PROID asc");
$cur = $mydb->loadResultList();

$mydb->setQuery("SELECT * From tblbanner where status=1 and banner_text is  null and type='image'");
$baner = $mydb->loadResultList();
error_log("test log.", 3, "error_log");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home @ FinerFits</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="#" name="keywords">
    <meta content="#" name="description">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/favicons/android-icon-192x192.png">
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
        body,
        html {
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <?php
    include('header.php');
    ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <!-- <div class="container-fluid mb-5">
        <div class="row"> -->
            <!--<div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100 img-product" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 img-product overflow-hidden" style="height: 410px">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">Men's Apparel <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 img-product m-0">
                                <a href="" class="nav-item nav-link">Shirts</a>
                        <a href="" class="nav-item nav-link">Blazers</a>
                        <a href="" class="nav-item nav-link">Jackets</a>
                        <a href="" class="nav-item nav-link">Combos</a>
                    </div>
                            </div>
                        </div>
                </nav>
            </div>-->
            <?php if(count($baner)>0){ ?>
            <div class="col-lg-12 p-0">
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $x="active";
                        foreach ($baner as $value) {
                            
                            echo'<div class="carousel-item '.$x.'">
                            <img class="img-fluid" src="admin/cms/banner/'.$value->banner_url.'" alt="Image">
                        </div>';
                        $x="";
                        }
                        ?>


                       
                    </div>
                    <!-- <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a> -->
                </div>
            </div>
            <div style="width:100vw; display:flex; justify-content:center; gap:20px;">
                <a href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>   
        <?php } ?>
<!-- <button type="button" class="slider-button slider-button--prev" name="previous" aria-label="Previous slide" aria-controls="Slider-template--17946625376537__d7118a97-d657-4f28-8972-1b296bcb0d11"><svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
</path></svg>
</button> -->
        </div>
    </div>
   
    <!-- Navbar End -->
  

    <!-- Featured Start -->
    <div class="container-fluid pt-2">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px; align:center,text-align: center;">
                     <h1><i class="fas fa-check"></i></h1>
                     <i class="bi bi-0-circle"></i>
                    <h5 class="font-weight-semi-bold m-0 pl-5" style="text-align:center;">Our collection</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                      <h1><i class="fas fa-ruler-combined"></i></h1>
                    <h5 class="font-weight-semi-bold m-0 pl-5" style="">Made to measure</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                 <h1><i class="fas fa-briefcase"></i></h1>  
                 <i class="fa-solid fa-reel"></i> 
                <h5 class="font-weight-semi-bold m-0 pl-4" >How we work</h5>
                </div>
            </div>
            <!-- <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div> -->
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <!--<div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">15 Products</p>
                    <a href="shop.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-1.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Jackets</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">15 Products</p>
                    <a href="shop.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-2.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Suits</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">15 Products</p>
                    <a href="shop.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-3.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Shirts</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">15 Products</p>
                    <a href="shop.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-4.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Trousers</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">15 Products</p>
                    <a href="shop.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-5.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">3 Piece Suit</h5>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">15 Products</p>
                    <a href="shop.html" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="img/cat-6.jpg" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">Tuxedo</h5>
                </div>
            </div>
        </div>
    </div>-->
    <!-- Categories End -->


    <!-- Offer Start -->
  <!--  <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="img/offer-1.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">10% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="img/offer-2.png" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">10% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 px-0">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">NEW ARRIVALS</span></h2>
        </div>
        <div class="row px-xl-5 pb-3" style="justify-content:center;">
            
        <?php
        $i=0;
        foreach($cur as $result)
        
        {
            if($i<4) {
            if($_SESSION["country"] == "India")
            {
                $mrpprice = $result->ORIGINALPRICE;
                $dpprice = $result->PROPRICE;
            }else{
                $mrpprice = $result->USDMRP;
                $dpprice = $result->USDPRICE;
            }
            $image = New Image();
			$img = $image->single_image($result->PROID);
            
        echo'<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                       <a href="product.php?id='.$result->PROID.'"> <img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/'.$img->file_name.'" alt=""></a>
                    </div>
                    <br>
                   <div class="d-flex justify-content-center"> <h6 class="text-truncate mb-3" style="font-size: 15px; justify-content:center;">'.$result->PROTITLE.'</h6></div>
                    </br>
                    <div class="d-flex justify-content-center">
                         <h6>'.$currencysymbol,$dpprice.'.00</h6><h6 class="text-muted ml-2"></h6>
                    </div>
            </div>
        </div>';
        } 
        $i++;
    }
      
     ?>
        <div class="button" style="padding: 10px 20px;text-align: center;align-items: center;margin-left: 10px;">
         <a href="allproduct.php" class="button" aria-label="View all products in the Products collection"style="background-color: black; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;text-align: center; display: flex; align-items: center;">
          View all
        </a>
        </div>
    </div>
    
    <!-- Products End -->


    <!-- Subscribe Start -->
    <!-- <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid px-0 mt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">COLLECTIONS</span></h2>
        </div>
        <div class="row px-xl-4 pb-3">
        
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/20171002C5A2892.JPG" alt=""></a>
                    </div>
                    <br>
                    <h6 class="text-truncate mb-3" style="text-align:center">SUIT-2 PEICE</h6>
                    </br>
                    
            </div>
        </div>

        <div class="col-lg-3 col-md-5 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="font-size: 20px;">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/20171012C5A2882.JPG" alt=" "></a>
                    </div>
                    <br>
                    <h6 class="text-truncate mb-3" style="text-align:center;">SUIT 3 PEICE</h6>
                    </br>
                    
            </div>
        </div>

        <div class="col-lg-3 col-md-5 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/2017962C5A2434.JPG" alt=""></a>
                    </div>
                    <br>
                    <h6 class="text-truncate mb-3" style="text-align:center;">TUXEDOS</h6>
                    </br>
                    
            </div>
        </div>

        <div class="col-lg-3 col-md-5 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/201765DSC_7200.JPG" alt=""></a>
                    </div>
                    <br>
                    <h6 class="text-truncate mb-3" style="text-align:center">VELVET</h6>
                    </br>
                    
            </div>
        </div>
       </div>
    </div>

    <!-- <div class="col-lg-12 p-0" style="margin: 0; padding: 0;">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent  p-0">
                <a href="#">
                    <img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/wedding.png" alt="" style="width: 300px;">
                    <div class="overlay-text">
                        <h2 class="banner__heading h0" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; padding: 10px; font-size: 40px; text-align: center;">
                            
                             <span style="display: block; white-space: nowrap;">WEDDING SUITS</span> 
                            <p></br>
                            <div class="button" style="padding: 10px 20px;text-align: center;align-items: center;margin-left: 10px; width:fit-content">
                     <div class="button justify-content-left"  aria-label="View all products in the Products collection"style="background-color: black; color: smoke white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;text-align: center; display: flex; align-items: center;">
                      shop now
                            
                            </div>
                           </div>
                        </h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> -->
      

                    
 
<!-- <div class="col-lg-12 p-0" style="margin: 0; padding: 0;">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent  p-0">
                <a href="#">
                    <img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/wedding2.png" alt="" style="width=2000;height=1080.0" loading="lazy" sizes="100vw";>
                    <div class="overlay-text">
                        <h2 class="banner__heading h0" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; padding: 10px; font-size: 40px; text-align: center;"> <span style="display: block; white-space: nowrap;">SHOP TUXEDOS</span>
                        <p></br>
                        <div class="button" style="padding: 10px 20px;text-align: center;align-items: center;margin-left: 10px; width:fit-content">
                     <div class="button justify-content-left"  aria-label="View all products in the Products collection"style="background-color: black; color: smoke white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;text-align: center; display: flex; align-items: center;">
                      shop now
                            </div>
                           </div>
                        </h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> -->
      

      


<!-- <div class="col-lg-12 p-0">
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/wedding2.png" alt=""></a>
                    </div>
                    <br>
                        
        
        </div>
    </div>
</div> -->
                    
   
<!-- <div class="col-lg-12 p-0" style="margin: 0; padding: 0;">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent  p-0">
                <a href="#">
                    <img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/wedding3.png" alt="" style="width:20px">
                    <div class="overlay-text">
                        <h2 class="banner__heading h0" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; padding: 10px; font-size: 40px; text-align: center;">
                        <span style="display: block; white-space: nowrap;">BUSINESS SUITS</span>
                            </p></br>
                     <div class="button" style="padding: 10px 20px;text-align: center;align-items: center;margin-left: 10px; width:fit-content">
                     <div class="button justify-content-left"  aria-label="View all products in the Products collection"style="background-color: black; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;text-align: center; display: flex; align-items: center;">
                      shop now
                            </div>
                           </div>
                        </h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> -->

<?php
$mydb->setQuery("SELECT * From tblbanner where status=1 and banner_text is not null and type='image'");
$ctabanner = $mydb->loadResultList();
$count=0;
foreach ($ctabanner as $result) {
    if($count<count($ctabanner)-1) {

    
    echo '<div class="col-lg-12 p-0">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0" style="border-bottom: 0px;">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/cms/banner/'.$result->banner_url.'" alt="" style="filter: brightness(50%);"></a>
                <!-- <h2 class="banner__heading h0"> -->
                <!-- <div class="overlay-text d-flex justify-content-center align-items-center"> -->
                <div class="banner__heading h0 overlay-text d-flex justify-content-center align-items-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; padding: 10px; font-size: 40px; text-align: center; flex-direction:column; gap: 4rem;">
                    <span style="display: block; white-space: nowrap; font-weight:400; font-size:3.5rem; text-transform:uppercase;">'.$result->banner_text.'</span>
                    <a class="btn btn-outline-light" style="padding: 20px 40px;text-align: center;align-items: right; width:fit-content; border-radius: 5px; font-weight:bold; border: 4px #fff solid">  
                        SHOP NOW
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>';
$count++;
    }   
  
} 


?>
<!--  -->
      








<!-- <div class="col-lg-12 p-0">
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/wedding3.png" alt=""></a>
                    </div>
                    <br>
                        
        
        </div>
    </div>
</div> -->
                    
   
    
<div class="row mt-3 px-5 d-flex justify-content-between">
    <div class="col-lg-4" style="margin-top:50px;">
         <div class="img-card">
            <img src="admin/products/uploaded_photos/20171012C5A2882.JPG" class="card-img-top" alt="Card Image 1">
            <div class="card-body">
            </div>
        </div> 
    </div>

    <div class="col-lg-7 px-5 justify-content-between">
      <div class="text-beside-card" style="text-align:left;">
      <h2 class="image-with-text__heading h0" style="margin-top:50px;">
                THE FIRE ON INTERNET -<br> CHAMPAGNE WEDDING SUIT </br>
              </h2>
              
              <p>THIS CHAMPAGNE WEDDING SUIT IS ONE OF THE MOST VIRAL SUITS <br> AMONG THE COUPLES PREPARING FOR THERE MARRIAGE - BACK IN STOCK, BUY NOW</p></br>
      <div class="button" style="padding: 10px 20px;text-align: center;align-items: center;margin-center: 10px; width:fit-content">
         <a href="allproduct.php" class="button justify-content-left"  aria-label="View all products in the Products collection"style="background-color: black; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;text-align: center; display: flex; align-items: center;">
          shop now
        </a>
        </div>
    </div>
  </div>
</div> 
<br>
        <?php
        if(count($ctabanner)>3){
        echo '<div class="col-lg-12 p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0" style="border-bottom: 0px;">
                    <a href="#"><img class="img-fluid w-100 img-product" src="admin/cms/banner/'.$ctabanner[count($ctabanner)-1]->banner_url.'" alt="" style="filter: brightness(50%);"></a>
                    <!-- <h2 class="banner__heading h0"> -->
                    <!-- <div class="overlay-text d-flex justify-content-center align-items-center"> -->
                    <div class="banner__heading h0 overlay-text d-flex justify-content-center align-items-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; padding: 10px; font-size: 40px; text-align: center; flex-direction:column; gap: 4rem;">
                        <span style="display: block; white-space: nowrap; font-weight:400; font-size:3.5rem; text-transform:uppercase;">'.$ctabanner[count($ctabanner)-1]->banner_text.'</span>
                        <a class="btn btn-outline-light" style="padding: 20px 40px;text-align: center;align-items: right; width:fit-content; border-radius: 5px; font-weight:bold; border: 4px #fff solid">  
                            SHOP NOW
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>';}
    
        ?>
        <!-- <div class="col-lg-12 p-0">
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0">
                        <a href="#"><img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/wedding5.png" alt="" style="filter: brightness(50%);"></a>
                        <div class="banner__heading h0 overlay-text d-flex justify-content-center align-items-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; padding: 10px; font-size: 40px; text-align: center; flex-direction:column; gap: 4rem;">
                            <span style="display: block; white-space: nowrap; font-weight:400; font-size:3.5rem;">TWO PEICE SUITS</span>
                            <a class="btn btn-outline-light" style="padding: 20px 40px;text-align: center;align-items: right; width:fit-content; border-radius: 5px; font-weight:bold; border: 4px #fff solid">  
                                SHOP NOW
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
          
          
                        
        
        <br><br>



<div class="container-fluid">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">REASONS WHY PEOPLE LOVE US</span></h2>
        </div>
        <div class="row px-xl-5 pb-3" style="justify-content:center;">
            
        <?php
        $i=0;
        foreach($cur as $result)
        
        {
            if($i<4) {
            if($_SESSION["country"] == "India")
            {
                $mrpprice = $result->ORIGINALPRICE;
                $dpprice = $result->PROPRICE;
            }else{
                $mrpprice = $result->USDMRP;
                $dpprice = $result->USDPRICE;
            }
            $image = New Image();
			$img = $image->single_image($result->PROID);
            
        echo'<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                       <a href="product.php?id='.$result->PROID.'"> <img class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/'.$img->file_name.'" alt=""></a>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center"> <h6 class="text-truncate mb-3" style="font-size: 15px;">'.$result->PROTITLE.'</h6></div>
                    </br>
                    <div class="d-flex justify-content-center">
                        <h6>'.$currencysymbol,$dpprice.'.00</h6><h6 class="text-muted ml-2"></h6>
                    </div>
            </div>
        </div>';
        } 
        $i++;
    }
      
     ?>
        <div class="button" style="padding: 10px 20px;text-align: center;align-items: center;margin-left: 10px;">
         <a href="allproduct.php" class="button" aria-label="View all products in the Products collection"style="background-color: black; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;text-align: center; display: flex; align-items: center;">
          View all
        </a>
        </div>
    </div>


    
<!-- <div class = "row">  
    <iframe width="100%" style="aspect-ratio: 16/9;" src="https://www.youtube.com/embed/tyBJioe8gOs?si=XkYHr6Poe2PVFg4I&mute=1 "title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;" allowfullscreen></iframe>
</div> -->
<?php
$mydb->setQuery("SELECT * From tblbanner where status=1 and type = 'video'");
$vidbanner = $mydb->loadResultList();
$count=0;
foreach ($vidbanner as $result) {
    echo '<div class = "row">  
            <iframe width="100%" style="aspect-ratio: 16/9;" src="'.$result->banner_text.'&mute=1 "title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;" allowfullscreen></iframe>
        </div>';  
} 


?>





<!-- Products End -->

 <div class="container-fluid  mt-5" style="height: 400px;">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class=" px-2">Subscribe</span></h2>
                    <p>Be the first to know about new collections and exclusive offers.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
 

 <!-- <div style="text-align: center;">
 <h2 class="h1">
            Subscribe to our emails
        </h2>
<div class="newsletter__subheading rte">
    <p>Be the first to know about new collections and exclusive offers.</p>
</div>  
<form>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="email">
</form> -->

<!-- Subscribe Start -->
    <!-- <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <!-- Subscribe End




    <!-- Vendor Start -->
    <!-- <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-1.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-2.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-3.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-4.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-5.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-6.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-7.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Vendor End -->


    <!-- Footer Start -->
    <?php
    include('footer.php');
    ?>
    <!-- <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><a href="index.html"><img src="img/logo.png"></a>FireFits</h1>
                <p>THE GENTLEMEN'S CHOICE.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">FireFits</a>. All Rights Reserved. Designed
                    by <a class="text-dark font-weight-semi-bold" href="https://tractionshastra.com">Traction Shastra</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div> -->
    <!-- Footer End -->


        <!-- Back to Top -->
        <a class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // session_start();
        if (isset($_SESSION['country']) && $_SESSION['country'] != "Error getting country name.") {
            // // echo "Country from session: " . $_SESSION['country'];
            // error_log("Country from session: " . $_SESSION['country'],3,"error_log");
            echo '<script>console.log("' . $_SESSION['country'] . '")</script>';

        } else {
            echo '<script>console.log("' . $_SESSION['country'] . '")</script>';
            echo "<script>
                viewmap();
                </script>";
        }
        ?>


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

</body>

</html>