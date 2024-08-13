<?php
  require_once("include/initialize.php");
  if (isset($_POST["trackingSubmit"])) {
    $query = "SELECT * FROM `tblsummary` WHERE ORDEREDNUM = ".$_POST["orderid"];
    $mydb->setQuery($query);
    $trackingDetails = $mydb->loadSingleResult();
    header('Content-Type: application/json');
    echo json_encode(['trackingdetails' => $trackingDetails]);
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tracking @ FinerFits</title>
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
     <?php
     include('header.php');
    ?> 
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Track your Order</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a class="text-dark" href="<?php echo web_root;?>">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Track your Order</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <!-- Page Main Start -->
    <section>
        <form method="post" id="trackingForm"></form>
        <div class="container-fluid mb-5">
            <div class="d-flex align-items-center justify-content-center row">
                <div class="input-group mb-3 col-12 col-lg-6">
                    <span class="input-group-text" id="basic-addon3">Order ID :</span>
                    <input type="text" class="form-control" name="orderid" id="orderId" form="trackingForm" placeholder="Enter Order ID..." aria-label="Order ID" value="<?php echo (isset($_GET["id"])?$_GET["id"]:"");?>" required/>
                    <button class="btn btn-outline-dark" type="submit" id="trackingSubmit" name="trackingSubmit" form="trackingForm">Enter</button>
                </div>
            </div>
        </div>
        <div class="container-fluid mb-5" >
            <div class="d-flex flex-column align-items-center justify-content-center row" id="trackingDetails">
            </div>
        </div>
    </section>
    <!-- Page Main End -->


    <!-- Footer Start -->
    <?php
    include('footer.php');
    ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>


    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> -->
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <!-- <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script> -->

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('trackingSubmit').addEventListener('click', function(e) {
                e.preventDefault();

                const form = document.getElementById('trackingForm');
                const formData = new FormData(form);
                formData.append(`trackingSubmit`,"true");

                fetch('tracking.php', {
                method: 'POST',
                body: formData
                })
                .then(response => response.json()) 
                .then(data => {
                    // document.getElementById("category_form_close").click();
                    // alert('Category added successfully!');
                    // updateCategorySelect(data.categories);
                    updateTrackingDetails(data.trackingdetails);
                })
                .catch(error => {
                alert(`Network error.${error}`);
                });
            });
            <?php if(isset($_GET["id"])) { ?>
                document.getElementById('trackingSubmit').click();
            <?php } ?>
            function updateTrackingDetails(trackingDetails) {
                const trackingDetailsContainer = document.getElementById('trackingDetails');
                if (!trackingDetails) {
                    trackingDetailsContainer.innerHTML = '<p>No such order ID exists.</p>';
                    return;
                }

                
                switch (trackingDetails.ORDEREDSTATS) {
                    case 'Received':
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info">Your order has not been confirmed yet.</p>';
                        break;
                    case 'Confirmed':
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info">Your order is processing.</p>';
                        break;
                    case 'Ready For Dispatch':
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info">Your order is ready for dispatch. We\'ll notify you as soon as it dispatches.</p>';
                        break;
                    case 'Dispatched':
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info text-center">Your order has been dispatched.<br>Your Tracking ID '+(trackingDetails.SHIPMENTPARTNER==='Shiprocket'&&'(AWB)')+': '+trackingDetails.SHIPMENTTRACKINGID+'</p>';
                        openTrackingPage(trackingDetails.SHIPMENTPARTNER);
                        break;
                    case 'Fulfilled':
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info">Your order has reached.</p>';
                        break;
                    case 'Cancelled':
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info">Your order has been cancelled.</p>';
                        break;
                    default:
                        trackingDetailsContainer.innerHTML = '<p class="alert alert-info">Invalid order status.</p>';
                        break;
                }
            }
            function openTrackingPage(shippingPartner) {
                let trackingUrl = '';

                switch (shippingPartner) {
                    case 'Shiprocket':
                        trackingUrl = 'https://www.shiprocket.in/shipment-tracking/';
                        break;
                    case 'DHL':
                        trackingUrl = 'https://www.dhl.com/tracking.html';
                        break;
                    case 'FedEx':
                        trackingUrl = 'https://www.fedex.com/en-us/tracking.html';
                        break;
                    default:
                        trackingUrl = '#';
                        break;
                }

                // Open the tracking page in a new tab
                if (trackingUrl !== '#') {
                    setTimeout(function () {
                        window.open(trackingUrl, '_blank');
                    }, 1200); 
                }
            }
        });

    </script>
</body>

</html>