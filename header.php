<?php
// $mydb->setQuery("SELECT count(*) as count FROM tblcart where user='".session_id()."'");
// $cartcount = $mydb->loadSingleResult();
$mydb->setQuery("SELECT SUM(CARTQTY) as totalQuantity FROM tblcart WHERE user='" . (isset($_SESSION["USER"])?$_SESSION["USER"]:'-') . "'");
$result = $mydb->loadSingleResult();
$cartcount = $result->totalQuantity;
$mydb->setQuery("SELECT COUNT(*) as totalWish FROM tblwishlist WHERE CUSTOMERID =".(isset($_SESSION["USER"])?$_SESSION["USER"]:'0'));
$res = $mydb->loadSingleResult();
$wishcount = $res->totalWish;
?>

    
    <div class="container-fluid fixed-top" id="headerContainer">
        <div class="row bg-dark py-2 px-xl-5 head-insight">
            
            <div class="col-lg-12 text-center">
                <p class="text-primary px-2 mb-0">FREE SUPER EXPRESS SHIPPING WORLD WIDE | GET YOUR SUIT IN JUST 5-6 DAYS</p>
            </div>
            
        </div>
        <div class="row bg-light align-items-center justify-content-between py-3 px-xl-5" id="stickyHead">
            <nav class="col navbar navbar-expand-sm navbar-light bg-light navbar-container">
                <div class="d-block d-lg-none"> <!-- display the toggler on small screens and hide on larger screens -->
                    <button class="navbar-toggler" type="button" id="sidebarToggle">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="sidebar" id="sidebar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link justify-content-center pb-5" href="<?php echo web_root;?>index.php" style="display:flex;">
                                <img src="<?php echo web_root;?>img/website-logo.png" class="img-fluid" alt="Logo" style="max-width: 250px;">
                            </a>
                        <li>
                        <li class="nav-item">
                            <a class="nav-link justify-content-center" href="<?php echo web_root;?>index.php" style="display:flex;">Home</a>
                        </li>
                        <li class="nav-item dropdown align-items-center" style="display:flex; flex-direction:column;">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Shop
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Suits 2-Piece</a>
                                <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Suits 3-Piece</a>
                                <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Tuxedos</a>
                                <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Velvet Suits</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link justify-content-center" href="<?php echo web_root;?>allproduct.php" style="display:flex;">New Arrivals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link justify-content-center" href="<?php echo web_root;?>sizechart.php" style="display:flex;">Size Chart</a>
                        </li>
                        <li class="nav-item fixed-bottom" >
                            <a class="nav-link justify-content-center" style="display:flex;">
                            <button class="btn btn-primary justify-content-center" style="display:flex;" onclick="closeMenuSidebar()">X</button>
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-big">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Shop
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Suits 2-Piece</a>
                            <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Suits 3-Piece</a>
                            <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Tuxedos</a>
                            <a class="dropdown-item" href="<?php echo web_root;?>allproduct.php">Velvet Suits</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo web_root;?>allproduct.php">New Arrivals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo web_root;?>sizechart.php">Size Chart</a>
                    </li>
                </ul>
            </nav>
            <!-- <div class="col-lg-3 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div> -->
            <!-- <div class="col-5 d-none d-lg-block">
                <a href="index.php" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold align-items-center justify-content-center"><img src="img/logo-text.png"></h1>
                </a>
            </div> -->
            <div class="col d-none d-lg-flex justify-content-center">
                <a href="index.php" class="text-decoration-none d-flex justify-content-center align-items-center" style="height: 100%;">
                    <img src="<?php echo web_root;?>img/website-logo.png" class="img-fluid" alt="Logo" style="max-width: 320px;">
                </a>
            </div>
            <div class="user-buttons col text-right align-self-right">
                <a href="" class="btn border" data-toggle="modal" data-target="#searchModal">
                    <i class="fa fa-search  bg-transparent text-primary"></i>
                </a>
                <?php if(isset($_SESSION["USER"])){?>
                <a href="useraccount.php" class="btn border">
                    <i class="fas fa-user text-primary"></i>
                </a>
                <a href="wishlist.php" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge text-muted"><?= $wishcount>0?$wishcount:'' ?></span>
                </a>
                <?php } else { ?>
                <a href="login.php" class="btn border">
                    <i class="fas fa-user text-primary"></i>
                </a>
                <?php } ?>
                <a href="<?php echo web_root;?>cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge text-muted"><?= $cartcount ?></span>
                </a>
            </div>
            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <!-- No Modal Header -->
                        <form method="GET" id="searchForm" action="search.php"> </form>

                        <div class="modal-body d-flex justify-content-center align-items-center">
                            <!-- Search Bar Container -->
                            <div class="search-container">
                                <!-- Search Bar -->
                                <div class="input-group">
                                    <input type="text" name="qry" class="form-control" placeholder="Search for products" form="searchForm">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit" form="searchForm">
                                            <i class="fa fa-search bg-transparent" style="color: white;"></i>
                                        </button>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close" style="display:flex; justify-content:center; padding-left:20px;">
                                            <span aria-hidden="true" class="fas fa-times"></span>
                                        </button>
                                    </div>
                                </div>               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-background"></div>

    <style>
        body, html{
            overflow-x: hidden;
        }
        .text-primary{
            color: #D1D3D4 !important;
        }
        .btn-primary{
            background-color: #D1D3D4;
            border-color: #D1D3D4;
        }
        .btn-primary:hover{
            background-color: #000;
            border-color: #000;
        }
        .btn-primary:focus, .btn-primary.focus{
            background-color: #000;
            border-color: #000;
            box-shadow: 0 0 0 0.2rem #D1D3D480;
        }
        .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active,
        .show > .btn-primary.dropdown-toggle {
            background-color: #000;
            border-color: #000;
        }
        .btn-primary:not(:disabled):not(.disabled):active:focus, .btn-primary:not(:disabled):not(.disabled).active:focus,
        .show > .btn-primary.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem #D1D3D480;
        }
        body, html{
            font-family: "Montserrat", sans-serif;
            /* overflow-x:hidden; */
        }

        .navbar-big a:hover, .navbar-big a:focus {
            color: #1C1C1C !important; 
            text-decoration: underline;
        }
        .sidebar a:hover, .sidebar a:focus {
            color: #1C1C1C !important; 
            text-decoration: underline;
        }

        #stickyHead .modal-dialog {
        margin: 0;
        width: 100vw;
        max-width: 100%; 
        height: 100vh; 
        max-height: 20vh; 
        display: flex;
        align-items: center;
        justify-content: center;
        /* z-index: 1055 !important; */


    }
    #stickyHead .modal-content {
        height: 100%; 
        display: flex;
        flex-direction: column;
    }
    
    #stickyHead .modal-body {
        flex: 1;
    }
    
    .modal-backdrop {
        z-index: 1029;
    }

    
    
    .fixed-top + .header-background {
        padding-top: 152px; 
    }
    .search-container {
        width: 40%; 
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: -100vw;
        width: 100vw;
        height: 100%;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        z-index: 1001;
        padding-top: 40px; 
        transform: translateX(-100%); 
        transition: transform 0.3s ease;
        padding-left: 10px;
        padding-right: 10px;
    }

    .sidebar.show {
        left: 0;
        transform: translateX(0);
    }
    .user-buttons{
        margin-right:10px;
    }
    .cat-item .cat-img img,
    .product-item .product-img img {
        transform-origin: top center;
    }



    @media (max-width: 576px) {
        .navbar-container {
            flex: 0 0 25%; /* This will make the navbar 3 columns wide out of 12 on small screens */
            max-width: 25%;
        }
    }
    @media (max-width: 980px) {
        .navbar-container {
            flex: 0 0 40%; /* This will make the navbar 3 columns wide out of 12 on small screens */
            max-width: 40%;
        }
        .navbar-big .nav-item {
            margin-right: 20px;
        }
        
    }
    @media (max-width: 1092px) {
        .navbar-big{
            font-size: 14px;
        }
        body, html {
            scrollbar-width: none; /* Hide the scrollbar */
            -ms-overflow-style: none; /* Hide the scrollbar */
            width: 100vw;
            overflow-x:hidden;
        }
    }

    @media (min-width: 426px) {
        .d-block.d-lg-none {
            display: none !important; 
        }
        .sidebar{
            left:-550px !important; 
        }
    }
    @media (max-width: 426px) {
        .head-insight{
            font-size: 8px;
        }
        .navbar-big{
            display: none !important;
        }
        .fixed-top + .header-background {
            padding-top: 116px; 
        }
        .search-container {
            width: 90%; 
        }
        

    }
    .back-to-top{
        bottom: 70px;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#searchModal').on('show.bs.modal', function() {
                $('body').css({
                    'overflow-y': 'hidden',
                    'width': '100vw',
                    'position': 'fixed'
                });
            });

            $('#searchModal').on('hidden.bs.modal', function() {
                $('body').css({
                    'overflow-y': 'auto',
                    'width': 'auto',
                    'position': 'static'
                });
            });
        });
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
        function closeMenuSidebar() {
            document.getElementById('sidebar').classList.remove('show');
        }
        document.addEventListener("DOMContentLoaded", function() {
            var sidebar = document.getElementById('sidebar');
            var sidebarToggle = document.getElementById('sidebarToggle');

            document.addEventListener('click', function(event) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            });
        });
        // document.addEventListener("DOMContentLoaded", function() {
        //     var stickyRow = document.getElementById("stickyHead");
        //     var stickyHeader =document.getElementById("headerContainer")
        //     var stickyRowOffset = stickyRow.offsetTop;

        //     window.addEventListener("scroll", function() {
        //         if (window.pageYOffset > stickyRowOffset) {
        //             stickyRow.classList.add("fixed-top");
        //         } else {
        //             stickyRow.classList.remove("fixed-top");
        //         }
        //     });
        // });
        
    </script>
    <?php
function getIP($ipadr) {
    if(isset($ipadr)) {
        $details = file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ipadr);
        $json = json_decode($details);
        if($json->geoplugin_status == '200')
            return $json->geoplugin_countryName;
        else
            return 'Error getting country name.';
    } else {
        return 'IP is empty.';
    }
}
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
if(!isset($_SESSION['country']))
$_SESSION['country'] =  getIP(get_client_ip());

$currency ='USD';

if(isset($_SESSION['country']))
{
    if($_SESSION['country'] == 'India')
      {$currency = 'USD';
      $currencysymbol = '₹';}
    else
      {$currency = 'USD';
      $currencysymbol ='$';}
}
    ?>
    