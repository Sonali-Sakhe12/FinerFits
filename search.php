<?php
require_once("include/initialize.php");
$whereClause = '';
if(isset($_GET['qry']))
{
    $qry=$_GET['qry'];
    $whereClause .= " AND PROTITLE like '%$qry%'";
}
if(isset($_GET['availability']) && is_array($_GET['availability'])) {
    $availabilityConditions = array();
    if(in_array('available', $_GET['availability'])) {
        $availabilityConditions[] = "p.PROQTY > 0";
    }
    if(in_array('out-of-stock', $_GET['availability'])) {
        $availabilityConditions[] = "p.PROQTY = 0";
    }
    if(!empty($availabilityConditions)) {
        $whereClause .= " AND (" . implode(" OR ", $availabilityConditions) . ")";
    }
}

if(isset($_GET['colour']) && is_array($_GET['colour'])) {
    $colours = implode("','", $_GET['colour']);
    $whereClause .= " AND p.COLOUR IN ('$colours')";
}

if(isset($_GET['fit']) && is_array($_GET['fit'])) {
    $fit = implode("','", $_GET['fit']);
    $whereClause .= " AND p.FITTYPE IN ('$fit')";
}

if(isset($_GET['fabric']) && is_array($_GET['fabric'])) {
    $fabric = implode("','", $_GET['fabric']);
    $whereClause .= " AND p.FABRICTYPE IN ('$fabric')";
}

if(isset($_GET['pricefrom']) && isset($_GET['priceto']) && $_GET['pricefrom'] != '' && $_GET['priceto'] != '') {
    $priceFrom = $_GET['pricefrom'];
    $priceTo = $_GET['priceto'];
    $whereClause .= " AND p.PROPRICE BETWEEN $priceFrom AND $priceTo";
}

$query = "SELECT p.*, CASE WHEN c.id IS NULL THEN '0' ELSE '1' END AS cart_status 
          FROM tblproduct p 
          LEFT JOIN tblcart c ON c.PROID = p.PROID AND c.USER = '" . (isset($_SESSION["USER"]) ? $_SESSION["USER"] : '-') . "'";
$orderByClause = "ORDER BY p.PROID ASC";

if(isset($_GET['sort'])) {
    switch($_GET['sort']) {
        case 'featured':
            break;
        case 'bestselling':
            $query .= " LEFT JOIN (
                            SELECT PROID, COUNT(*) AS order_count 
                            FROM tblorder 
                            GROUP BY PROID
                        ) o ON o.PROID = p.PROID";
            $orderByClause = "ORDER BY CASE WHEN o.order_count IS NULL THEN 0 ELSE 1 END DESC, 
                            o.order_count DESC, 
                            p.PROID ASC";
            break;
        case 'alphaasc':
            $orderByClause = "ORDER BY p.PROTITLE ASC";
            break;
        case 'alphadesc':
            $orderByClause = "ORDER BY p.PROTITLE DESC";
            break;
        case 'priceasc':
            $orderByClause = "ORDER BY p.PROPRICE ASC";
            break;
        case 'pricedesc':
            $orderByClause = "ORDER BY p.PROPRICE DESC";
            break;
        case 'dateasc':
            $orderByClause = ""; 
            break;
        case 'datedesc':
            $orderByClause = ""; 
            break;
    }
}

if (!empty($whereClause)) {
    $query .= " WHERE 1 $whereClause";
}
$query .= " $orderByClause";
$mydb->setQuery($query); 

// $mydb->setQuery("SELECT p.*,CASE when c.id is null THEN '0' ELSE '1' END AS cart_status FROM tblproduct p left join tblcart c on c.PROID=p.PROID and c.USER= '" . (isset($_SESSION["USER"])?$_SESSION["USER"]:'-') . "' ORDER by PROID asc");
$cur = $mydb->loadResultList();
if(isset($_GET['sort']) && $_GET['sort']=='datedesc'){
    $cur = array_reverse($cur);
}
$mydb->setQuery("SELECT * FROM tbltags where tagtype = 'colour'");
$colours = $mydb->loadResultList();
$mydb->setQuery("SELECT * FROM tbltags where tagtype = 'fittype'");
$fits = $mydb->loadResultList();
$mydb->setQuery("SELECT * FROM tbltags where tagtype = 'fabrictype'");
$fabrics = $mydb->loadResultList();
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

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .filter-btn::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <?php
    include('header.php');
    ?>
    <!-- Topbar End -->


   <hr>
<!-- filters -->
<div class="container-fluid d-flex justify-content-between pt-3 px-5">
        <p>
            <button class="btn btn-link text-dark filter-btn" type="button" data-toggle="collapse"
                data-target="#filters" aria-expanded="false" aria-controls="filters">
                Filters
            </button>
        </p>

        <div class="d-flex align-items-center">
            <label for="id" class="mb-0 mr-2" >Sort:</label>
            <select class="form-select custom-select-sm" form="filter-form" id="sort" name="sort" aria-label="Default select example" style="cursor:pointer;">
                <option value="featured" <?php echo isset($_GET['sort'])&&$_GET['sort']=='featured'?'selected':''; ?>>Featured</option>
                <option value="bestselling" <?php echo isset($_GET['sort'])&&$_GET['sort']=='bestselling'?'selected':''; ?>>Best Selling</option>
                <option value="alphaasc" <?php echo isset($_GET['sort'])&&$_GET['sort']=='alphaasc'?'selected':''; ?>>Alphabetically, A-Z</option>
                <option value="alphadesc" <?php echo isset($_GET['sort'])&&$_GET['sort']=='alphadesc'?'selected':''; ?>>Alphabetically, Z-A</option>
                <option value="priceasc" <?php echo isset($_GET['sort'])&&$_GET['sort']=='priceasc'?'selected':''; ?>>Price, low to high</option>
                <option value="pricedesc" <?php echo isset($_GET['sort'])&&$_GET['sort']=='pricedesc'?'selected':''; ?>>Price, high to low</option>
                <option value="dateasc" <?php echo isset($_GET['sort'])&&$_GET['sort']=='dateasc'?'selected':''; ?>>Date, old to new</option>
                <option value="datedesc" <?php echo isset($_GET['sort'])&&$_GET['sort']=='datedesc'?'selected':''; ?>>Date, new to old</option>
            </select>
        </div>

    </div>
    <div class="container-fluid px-5">
        <div class="collapse" id="filters">
            <div class="container-fluid pt-5">
                <form id="filter-form" class="row">
                    <div class="form-group col-md-3">
                        <label for="availability">Availability:</label><br>
                        <select id="availability" class="form-select border border-primary" name="availability[]" multiple="multiple"
                            style="width: 100%;">
                            <option value="available" <?= isset($_GET['availability']) && in_array('available', $_GET['availability']) ? 'selected': ''?>>Available</option>
                            <option value="out-of-stock" <?= isset($_GET['availability']) && in_array('out-of-stock', $_GET['availability']) ? 'selected': ''?>>Out of Stock</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="colour">Colour:</label><br>
                        <select id="colour" class="form-select border border-primary" name="colour[]" multiple="multiple" style="width: 100%;">
                            <?php 
                            foreach($colours as $colour){
                                echo '<option value="'.$colour->TAGTITLE.'" '.(isset($_GET['colour']) && in_array($colour->TAGTITLE, $_GET['colour'])?'selected':'').'>'.ucfirst($colour->TAGTITLE).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fit">Fit:</label><br>
                        <select id="fit" class="form-select border border-primary" name="fit[]" multiple="multiple" style="width: 100%;">
                            <?php 
                            foreach($fits as $fit){
                                echo '<option value="'.$fit->TAGTITLE.'" '.(isset($_GET['fit']) && in_array($fit->TAGTITLE, $_GET['fit'])?'selected':'').'>'.ucfirst($fit->TAGTITLE).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fabric">Fabric:</label><br>
                        <select id="fabric" class="form-select border border-primary" name="fabric[]" multiple="multiple" style="width: 100%;">
                            <?php 
                            foreach($fabrics as $fabric){
                                echo '<option value="'.$fabric->TAGTITLE.'" '.(isset($_GET['fabric']) && in_array($fabric->TAGTITLE, $_GET['fabric'])?'selected':'').'>'.ucfirst($fabric->TAGTITLE).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="price-range">Price Range:</label><br>
                        <div class="input-group rounded" style="border: 1px #aaa solid; overflow: hidden;">
                            <input type="number" class="form-control border border-0" name="pricefrom" id="price-from" placeholder="From" value="<?=isset($_GET['pricefrom'])?$_GET['pricefrom']:''?>">
                            <span class="input-group-text" id="basic-addon1">-</span>
                            <input type="number" class="form-control border border-0" name="priceto" id="price-to" placeholder="To" value="<?=isset($_GET['priceto'])?$_GET['priceto']:''?>">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a class="btn btn-outline-primary" href="allproduct.php">Clear All</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- filters end -->
  



    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <!-- <h2 class="section-title px-5"><span class="px-2"></span></h2> -->
        </div>
        <div class="row px-xl-5 pb-3">
        <?php
        if(!isset($_GET['priceto']) && count($cur) == 0) {
            echo '<div class="col-12 d-flex flex-column align-items-center"> ';
            echo '<h5>No results found for "'.$qry.'". Check the spelling or use a different word or phrase</h5>';
            echo '</div>';
        } else if(count($cur) == 0){
            echo '<div class="col-12 d-flex flex-column align-items-center"> ';
            echo '<h3>No Products Found</h3>';
            echo '<div class="d-flex align-items-center"><h3>Use fewer filters or&nbsp;</h3><a class="btn btn-link p-0" href="allproduct.php"><h3>remove all</h3></a></div>';
            echo '</div>';
        } else {
        foreach($cur as $result)
        {
           
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
                    <h6 class="text-truncate mb-3">'.$result->PROTITLE.'</h6>
                    </br>
                    <div class="d-flex justify-content-center">
                        <h6>'.$currencysymbol,$dpprice.'.00</h6><h6 class="text-muted ml-2"><del>'.$currencysymbol,$mrpprice.'.00</del></h6>
                    </div>
            </div>
        </div>';
        } 
       
    
    }
     ?>
        
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
    
    
    
    

<!-- Products End -->


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
    