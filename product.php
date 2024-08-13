<?php
require_once("include/initialize.php");

if (isset($_POST['proId']) && isset($_POST['action'])) {
    $proId = $_POST['proId'];
    $action = $_POST['action'];
    error_log($proId.$action, 3, "logfile.log");

    if ($action === 'add') {
        $mydb->setQuery("INSERT INTO tblwishlist(CUSTOMERID, PROID) VALUES (".$_SESSION["USER"].",".$proId.")");
        $result = $mydb->executeQuery(); 
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'isWishlisted' => true]);
        }
    } elseif ($action === 'remove') {
        $mydb->setQuery("DELETE FROM tblwishlist WHERE PROID = ".$proId." AND CUSTOMERID = ".$_SESSION["USER"]);
        $result = $mydb->executeQuery(); 
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'isWishlisted' => false]);
        }
    }
    exit;
}

// If any error occurs or if the request is not valid
// echo json_encode(['success' => false, 'isWishlisted' => false]);
// exit;
if (isset($_POST["submit"])) {
    $db = new Database();
    $qty = $_POST["quantity"];
    $status = 1;
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $fit = isset($_POST["fit"]) ? $_POST["fit"] : "";
    $waist = $_POST["waist"] == "" ? $_POST["waist-size"] : $_POST["waist"];
    // $user = session_id();
    $user = $_SESSION["USER"];
    $sql = $db->conn->prepare("INSERT INTO `tblcart`(`USER`, `PROID`, `CARTQTY`, `size`, `height`, `chest`, `sleeve_length`, `shoulder`, `belly`, `bicep`, `waist`, `hip`, `thigh`, `calf`, `gender`, `fit`, `status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql->bind_param("sssssssssssssssss", $user, $_GET['id'], $qty, $_POST["sizeSelect"], $_POST["height"], $_POST["chest"], $_POST["sleeve"], $_POST["shoulder"], $_POST["belly"], $_POST["bicep"], $waist, $_POST["hip"], $_POST["thigh"], $_POST["calf"], $gender, $fit, $status);
    $sql->execute();
}
if (isset($_POST["review_submit"])) {
    function getImageDimensionsAndOrientation($imagePath) {
        $info = getimagesize($imagePath);
        $width = $info[0];
        $height = $info[1];
        $exif = @exif_read_data($imagePath);
        $orientation = isset($exif['Orientation']) ? $exif['Orientation'] : null;
    
        return [$width, $height, $orientation];
    }
    // File upload configuration 
    $targetDir = "admin/products/uploaded_photos/reviews/";
    $allowTypes = array('jpg', 'png', 'jpeg');
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    $fileNames = [];
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $fileNames = array_filter($_FILES['image']['name']);
    } else {
        $fileNames = array();
    }
    $db = new Database();
    $user = isset($_POST["name"]) ? $_POST["name"] : "";
    $product_id = isset($_GET['id']) ? $_GET['id'] : 0;  
    $review = isset($_POST["message"]) ? $_POST["message"] : "";
    $status = 1;  
    $date = date("Y-m-d-h-i-sa");  // Current date
    $ratings = isset($_POST["ratingValue"]) ? $_POST["ratingValue"] : 0;  
    $email = isset($_POST["email"]) ? $_POST["email"] : "a@a.a";
    
    // error_log("Received email: " . $email, 3, "error_log");
    $sql = $db->conn->prepare("INSERT INTO `tbl_addreviews` (`product_id`, `review`, `user`, `status`, `date`, `ratings`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssss", $product_id, $review, $user, $status, $date, $ratings, $email);
    if ($sql->execute()) {
        $review_id = $db->conn->insert_id;
        
        if (!empty($fileNames)) {
            foreach ($_FILES['image']['name'] as $key => $val) {
                // File upload path 
                $fileName = $product_id. $date.$user. basename($_FILES['image']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                // Check whether file type is valid 
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                if (in_array($fileType, $allowTypes)) {
                    
                    $tempFilePath = $_FILES["image"]["tmp_name"][$key];

                    // Get original dimensions
                    list($width, $height, $orientation) = getImageDimensionsAndOrientation($tempFilePath);
                    switch ($orientation) {
                        case 6:
                            $temp = $width;
                            $width = $height;
                            $height = $temp;
                            break;
                        case 8:
                            $temp = $width;
                            $width = $height;
                            $height = $temp;
                            break;
                    }
                    $newHeight=0;
                    $newWidth=0;
                    // Calculate new dimensions (e.g., set width to 800 pixels)
                    if($height<=$width){
                        $newWidth = 500;
                        $newHeight = ($height / $width) * $newWidth;
                    } else {
                        $newHeight = 500;
                        $newWidth = ($width / $height) * $newHeight;
                    }
                    $logMessage = $height.'/'.$width.'='.$newHeight.'/'.$newWidth;
                    // error_log($logMessage, 3, 'logfile.log');


                    // Create a new image resource
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);

                    // Create the image from the uploaded file
                    if ($fileType == "jpg" || $fileType == "jpeg") {
                        $source = imagecreatefromjpeg($tempFilePath);
                    } elseif ($fileType == "png") {
                        $source = imagecreatefrompng($tempFilePath);
                    }

                    // Rotate the image if needed
                    switch ($orientation) {
                        case 3:
                            $source = imagerotate($source, 180, 0);
                            break;
                        case 6:
                            $source = imagerotate($source, -90, 0);
                            break;
                        case 8:
                            $source = imagerotate($source, 90, 0);
                            break;
                    }
                    // Resize the image
                    imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    // Save the resized image back to the temporary file path
                    if ($fileType == "jpg" || $fileType == "jpeg") {
                        imagejpeg($newImage, $tempFilePath, 80); // 80 is the compression quality
                    } elseif ($fileType == "png") {
                        imagepng($newImage, $tempFilePath, 9); // 9 is the compression level for PNG (0-9)
                    }

                    // Upload file to server 
                    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
    
                        // Image db insert sql 
                        $insertValuesSQL .= "('" . $product_id . "','" . $review_id ."','" . $fileName . "', NOW()),";
    
                    } else {
                        $errorUpload .= $_FILES['image']['name'][$key] . ' | ';
                    }
                } else {
                    $errorUploadType .= $_FILES['image']['name'][$key] . ' | ';
                }
            }
    
            // Error message 
            $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
            $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
            $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;
        }
        if (!empty($insertValuesSQL)) {
            $insertValuesSQL = trim($insertValuesSQL, ',');
            // Insert image file name into database
            $db = new DATABASE();
            $db->QUERY = "INSERT INTO tblreviewimages (proid,review_id,file_name, uploaded_on) VALUES $insertValuesSQL";
            $insert1 = $db->addimage(); 
            if ($insert1) {
                // echo "success0000000000000000<br>";
                $statusMsg = "Files are uploaded successfully." . $errorMsg;
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }
        echo json_encode(['redirect' => 'product.php?id='.$product_id]);
        exit;
    }
}
if (isset($_GET['id'])) {
    $mydb->setQuery("SELECT DISTINCT p.*,CASE when c.id is null THEN '0' ELSE '1' END AS cart_status FROM tblproduct p left join tblcart c on c.PROID=p.PROID and c.USER= '" . (isset($_SESSION["USER"])?$_SESSION["USER"]:'-') . "' ORDER by PROID asc");
    $cur = $mydb->loadResultList();
    $PROID = $_GET['id'];
    $product = new Product();
    $mydb->setQuery("SELECT * FROM tblproduct where  PROID= '" . $PROID . "'");
    // $singleproduct = $product->single_product($PROID);
    $singleproduct = $mydb->loadSingleResult();

    $query = "SELECT * FROM tbl_addreviews WHERE product_id = ".$PROID;
    $mydb->setQuery($query);
    $reviews = $mydb->loadResultList();
    $reviews = array_reverse($reviews);

    $totalReviews = count($reviews);
    $totalStars = 0;

    foreach ($reviews as $review) {
        $totalStars += $review->ratings;
    }

    // Calculate the average rating.
    $averageRating = $totalReviews !=0 ? $totalStars / $totalReviews:0;

    $man = "";
    $woman = "";
    $slim = "";
    $regular = "";

    // if ($singleproduct->gender == "Man")
    //     $man = "checked";
    // else if ($singleproduct->gender == "Woman")
    //     $woman = "checked";

    // if ($singleproduct->fit == "regular fit")
    //     $regular = "checked";
    // else if ($singleproduct->fit == "slim fit")
    //     $slim = "checked";

    if ($_SESSION["country"] == "India") {
        $mrpprice = $singleproduct->ORIGINALPRICE;
        $dpprice = $singleproduct->PROPRICE;
    } else {
        $mrpprice = $singleproduct->USDMRP;
        $dpprice = $singleproduct->USDPRICE;
    }

    $mydb->setQuery("SELECT * from tblwishlist WHERE CUSTOMERID = ".(isset($_SESSION["USER"])?$_SESSION["USER"]:"0"));
    $wishes = $mydb->loadResultList();
    $wishProdIds = array();
    foreach ($wishes as $wish) {
        $wishProdIds[] = $wish->PROID;
    }
    $wishflag=in_array($singleproduct->PROID, $wishProdIds);

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Product @ FinerFits</title>
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
        <link
            href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">


        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="https://vjs.zencdn.net/8.6.1/video-js.css" rel="stylesheet" />

        <link rel="stylesheet" href="lib/slick-loader/slick-loader.min.css" />
        

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/style.css" rel="stylesheet">

        <style>
            .d-flex{
                gap:20px;
            }
            .carousel-control-prev,
            .carousel-control-next {
                height: 800px;
            }

            .img-display {
                height: 800px;
                object-fit: cover;
            }

            select.form-control {
                border: 2px solid #ccc;
                /* Adjust the width and color as needed */
                border-radius: 4px;
                /* Optional: Add rounded corners */
            }

            .sizes-container .col-4 {
                padding-left: 0px;
                padding-right: 6px;
            }

            .sizes-container .size-label {
                text-transform: uppercase;
                font-size: small;
            }

            .size-custom-radio {
                position: relative;
                display: inline-block;
                cursor: pointer;
                font-size: 16px;
                /* Adjust font size as needed */
            }

            .size-custom-radio input[type="radio"] {
                display: none;
            }

            .size-custom-radio .radio-label {
                width: 50px;
                height: 50px;
                border: 2px solid #D19C97;
                /* Adjust border styles as needed */
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .size-custom-radio input[type="radio"]:checked+.radio-label {
                background-color: #c5837c;
                /* Adjust the background color for the checked state */
                color: #fff;
                /* Adjust the text color for the checked state */
            }

            #image-123 {
                border: 3px solid white;
                transition: border-color 0.3s;
                width: 53.7px;
                height: 70px;
                border-radius: 8px;
                object-fit: cover;
            }

            #image-123:hover {
                border-color: #58ddd6e0;
            }

            .box-123 {
                width: 53.7px;
                height: 75px;
                display: inline-grid;
                border-radius: 8px;
            }
            .review-sidebar-container {
                height: 100%;
                width: 40vw;
                position: fixed;
                z-index: 1100;
                top: 0;
                right: -150vw;
                background-color: #f5f5f5;
                transition: 0.3s;
            }
            .review-sidebar {
                height: 100%;
                width: 40vw;
                position: fixed;
                z-index: 1100;
                top: 0;
                right: -150vw;
                background-color: #f5f5f5;
                transition: 0.3s;
                padding-top: 20px;
                overflow-y: auto;
                overflow-x: visible;
            }
            @media (max-width: 700px) {
                .review-sidebar-container{
                    width: 70vw;
                }
                .review-sidebar {
                    width: 70vw;
                }
            }
            .overlay {
                height: 100%;
                width: 100%;
                position: fixed;
                z-index: 1090;
                top: 0;
                left: 0;
                background-color: rgba(0, 0, 0, 0.6); /* Adjust the opacity as needed */
                display: none; /* Initially hidden */
            }
            .review-sidebar-container .btn-danger {
                position: absolute;
                margin-top: 20px;
                left:-40px;
            }

            /* Color for nav-links that are not active */
            .nav-item.nav-link:not(.active) {
                color: #D1D3D4;
            }

            /* input[type="radio"]:checked{
                background-color: #D1D3D4 !important;
            } */
            .custom-control-input:checked ~ .custom-control-label::before {
                color: #fff;
                border-color: #C1C1C1 !important;
                background-color: #D1D3D4 !important;
            }
            
            form .select {
                color: #000000;
                cursor: pointer;
            }

            form #image {
                display: none;
            }

            .inner {
                border: 1px solid gray;
                padding: 3px;
            }

            .container1 {
                width: 60%;
                display: flex;
                justify-content: start;
                align-items: center;
                flex-wrap: wrap;
                position: relative;
                height: auto;
                margin-top: 20px;
                max-height: 300px;
                overflow-y: auto;
                /* margin-left: 266px; */
            }

            .container1 .image {
                height: 85px;
                width: 85px;
                border-radius: 5px;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                position: relative;
                margin-bottom: 7px;
                margin-right: 7px;
                justify-content: center;
            }

            .container1 .image:nth-child(4n){
                margin-right: 0;
            }

            .container1 .image img {
                height: 100%;
                width: 100%;
                object-fit: contain;
                
            }

            .container1 .image span {
                position: absolute;
                top: -4px;
                right: 5px;
                cursor: pointer;
                font-size: 22px;
                color: #fff;
            }

            .container1 .image span:hover {
                opacity: 0.8;
            }

        </style>
        
        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>

    </head>

    <body>
        <!-- Topbar Start -->
        <?php
        include('header.php');
        ?>
        <!-- Topbar End -->

        <!-- Page Header Start -->
        <div class="container-fluid bg-secondary">
            <div class="d-flex flex-column justify-content-center" style="height: 40px;">
                <!-- <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>-->
                <div class="d-inline-flex">
                    <p class="m-0"><a class="text-dark" href="index.php">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">
                        <?= $singleproduct->PROID ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Shop Detail Start -->
        <div class="container-fluid py-5">
            <div class="row px-xl-5">
                <div class="col-lg-5 pb-5">
                    <div class="d-flex">
                        <!-- Side Images -->
                        <div class="col-1 mt-3 d-none d-lg-block">
                            <div class="w-100">
                                <?php
                                $flag = 0;
                                $images = new Image();
                                $imagelist = $images->listofimages($singleproduct->PROID);
                                $image_counter = 0;
                                foreach ($imagelist as $image) {
                                    if ($flag == 0) {
                                        $flag = 1;
                                    } else {
                                    }
                                    // echo '
                                    // <div class="box-123" onmouseover="showData(\'admin/products/uploaded_photos/' . $image->file_name . '\')" 
                                    // onclick="showData(\'admin/products/uploaded_photos/' . $image->file_name . '\')">
                                    //     <img id="image-123" 
                                    //             src="admin/products/uploaded_photos/' . $image->file_name . '" 
                                    //             alt="Image" >
                                    // </div>';
                                    $file_extension = pathinfo($image->file_name, PATHINFO_EXTENSION);
                                    if ($file_extension === 'mp4' || $file_extension === 'avi' || $file_extension === 'mov') {
                                        echo '
                                        <div class="box-123">
                                           
                                            <video class="image-123" id="image-123" alt="Image">
                                                <source src="admin/products/uploaded_videos/' . $image->file_name . '" type="video/mp4">
                                            </video>
                                        </div>';

                                    } else {
                                        // This is a regular image.
                                        echo '
                                        <div class="box-123">
                                            <img loading="lazy" id="image-123" class="image-123"
                                                src="admin/products/uploaded_photos/' . $image->file_name . '" 
                                                alt="Image" >
                                        </div>';
                                    }
                                    $image_counter++;
                                }
                                ?>
                                <!-- <div class="box-123">
                                    
                                </div> -->
                            </div>
                        </div>
                        <!-- Main Image -->
                        <div class="col" style="padding-right:12px;">
                            <div id="product-carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                                <div class="carousel-inner border">
                                    <?php
                                    $flag = 0;
                                    $images = new Image();
                                    $imagelist = $images->listofimages($singleproduct->PROID);
                                    foreach ($imagelist as $image) {
                                        if ($flag == 0) {
                                            echo '<div class="carousel-item active">';
                                            $flag = 1;
                                        } else {
                                            echo '<div class="carousel-item ">';
                                        }
                                        $file_extension = pathinfo($image->file_name, PATHINFO_EXTENSION);
                                        if (in_array($file_extension, ['mp4', 'webm', 'ogg'])) {
                                            echo '
                                                <div class="product-img--main">
                                                <video
                                                    class="video-js w-100 img-display product-img--main__image"
                                                    controls muted
                                                    preload="auto"
                                                    data-setup="{}"
                                                >
                                                    <source src="admin/products/uploaded_videos/' . $image->file_name . '" type="video/' . $file_extension . '">
                                                    </p>
                                                </video>
                                                </div>';
                                        } else {
                                            echo '
                                                <div class="product-img--main" data-scale="2.2">
                                                    <img loading="lazy" class="w-100 img-display product-img--main__image" src="admin/products/uploaded_photos/' . $image->file_name . '" alt="Image">
                                                </div>';
                                        }

                                        echo '</div>';
                                        // echo '<script>console.log("'.pathinfo($image->file_name, PATHINFO_EXTENSION).'")</script>';
                                    }
                                    ?>
                                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                                    </a>
                                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                                    </a>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <!-- </div> -->

                <div class="col-lg-7 pb-5 pl-5 pr-5">
                    <h3 class="font-weight-semi-bold">
                        <?= $singleproduct->PROTITLE ?>
                    </h3>
                    <p class="font-weight-semi-bold mb-1">product id: #
                        <?= $singleproduct->PROID ?>
                    </p>
                    <div class="d-flex mb-4">
                        <div class="text-primary mr-2">
                            <!-- <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small> -->
                            <?php
                            // Display full stars
                            for ($i = 1; $i <= floor($averageRating); $i++) {
                                echo '<small class="fas fa-star text-warning"></small>';
                            }

                            // Display half star if applicable
                            if ($averageRating - floor($averageRating) >= 0.5) {
                                echo '<small class="fas fa-star-half-alt text-warning"></small>';
                                for ($i = 1; $i <= 5 - ceil($averageRating); $i++) {
                                    echo '<small class="far fa-star text-warning"></small>';
                                }
                            } else {
                                for ($i = 1; $i <= 5 - floor($averageRating); $i++) {
                                    echo '<small class="far fa-star"></small>';
                                }
                            }
                            // Display empty stars if applicable
                            
                            ?>
                        </div>
                        <small class="pt-1">
                            <a href="#tab-pane-3" class="reviews-link text-dark"> (<?php echo $totalReviews; ?> Reviews)</a>
                        </small>
                        <!-- <div class="text-primary mr-2">
                            <?php
                            // Display full stars
                            for ($i = 1; $i <= floor($averageRating); $i++) {
                                echo '<small class="fas fa-star"></small>';
                            }

                            // Display half star if applicable
                            if ($averageRating - floor($averageRating) >= 0.5) {
                                echo '<small class="fas fa-star-half-alt"></small>';
                            }

                            // Display empty stars if applicable
                            for ($i = 1; $i <= 5 - ceil($averageRating); $i++) {
                                echo '<small class="far fa-star"></small>';
                            }
                            ?>
                        </div>
                        <small class="pt-1">
                            <a href="#tab-pane-3" class="reviews-link"> (<?php echo $totalReviews; ?> Reviews)</a>
                        </small> -->
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">
                        <?= $currencysymbol, $dpprice ?>.00
                    </h3>

                    <ul style="padding: 0; ">
                        <?php if (!empty($singleproduct->PRODESC)): ?>
                            <li class="mb-4" style="list-style-type:none;">
                                <?= $singleproduct->PRODESC ?>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($singleproduct->PRODESCRIPTION1)): ?>
                            <li class="mb-4">
                                <?= $singleproduct->PRODESCRIPTION1 ?>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($singleproduct->PRODESCRIPTION2)): ?>
                            <li class="mb-4">
                                <?= $singleproduct->PRODESCRIPTION2 ?>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($singleproduct->PRODESCRIPTION3)): ?>
                            <li class="mb-4">
                                <?= $singleproduct->PRODESCRIPTION3 ?>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($singleproduct->PRODESCRIPTION4)): ?>
                            <li class="mb-4">
                                <?= $singleproduct->PRODESCRIPTION4 ?>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($singleproduct->PRODESCRIPTION5)): ?>
                            <li class="mb-4">
                                <?= $singleproduct->PRODESCRIPTION5 ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <form id="cartForm" method="post">
                        
                        <div class="sizes-container container">
                            <div class="row">
                                <div id="size" class="col-4">

                                    <label for="sizeSelect" class="size-label">Size :</label>
                                    <select class="form-control" id="sizeSelect" name="sizeSelect">
                                        <?php
                                        for ($i = 36; $i <= 50; $i++) {
                                            echo '<option value="' . $i . 'S">' . $i . 'S</option>';
                                            echo '<option value="' . $i . 'R">' . $i . 'R</option>';
                                            echo '<option value="' . $i . 'L">' . $i . 'L</option>';
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div id="waistSize" class="col-4">

                                    <label for="waistSizeSelect" class="size-label">Waist Size (in):</label>
                                    <select class="form-control" id="waistSizeSelect" name="waist-size">
                                        <?php
                                        for ($i = 26; $i <= 56; $i = $i + 2) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>


                        <!-- PHP START HERE -->
                        <?php if(isset($_SESSION["USER"])) { ?>
                        <div class="form-check mb-2 mt-3 px-0">
                            <!-- <input class="form-check-input" type="checkbox" id="customcheck" onclick="custom()"
                                id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Custom Size</label> -->
                            <button type="button" class="btn btn-primary" onclick="custom()" style="width:153.6px;">Custom Size</button>
                        </div>
                        <div id="custom" style="display:none;">
                            <div class="mb-3">
                                <p class="text-dark font-weight-medium mb-1 mr-3">This suit is made for:-</p>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="man" name="gender" value="Man">
                                    <label class="custom-control-label" for="man">Man</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="woman" name="gender" value="Woman">
                                    <label class="custom-control-label" for="woman">Woman</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="text-dark font-weight-medium mb-1 mr-3">What fit you need:-</p>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="fit-1" name="fit" value="slim fit">
                                    <label class="custom-control-label" for="fit-1">Slim fit</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="fit-2" name="fit"
                                        value="regular fit">
                                    <label class="custom-control-label" for="fit-2">Regular fit</label>
                                </div>
                            </div>

                            <div class="mb-1">
                                <p class="text-dark font-weight-medium mb-1 mr-3">For coat and vest:-</p>
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Height (cm)</label>
                                        <input class="form-control" name="height" type="number"
                                            value="" placeholder="Height">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Chest (cm)</label>
                                        <input class="form-control" name="chest" type="number"
                                            value="" placeholder="Chest">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Sleeve length (cm)</label>
                                        <input class="form-control" name="sleeve" type="number"
                                            value="" placeholder="Sleeve length">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Shoulder (cm)</label>
                                        <input class="form-control" name="shoulder" type="number"
                                            value="" placeholder="Shoulder">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Belly (cm)</label>
                                        <input class="form-control" name="belly" type="number"
                                            value="" placeholder="Belly">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Bicep (cm)</label>
                                        <input class="form-control" name="bicep" type="number"
                                            value="" placeholder="Bicep">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="text-dark font-weight-medium mb-1 mr-3">For pants:-</p>
                                <div class="row">
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Waist (cm)</label>
                                        <input class="form-control" name="waist" type="number"
                                            value="" placeholder="Waist">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Hip (cm)</label>
                                        <input class="form-control" name="hip" type="number"
                                            value="" placeholder="Hip">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Thigh (cm)</label>
                                        <input class="form-control" name="thigh" type="number"
                                            value="" placeholder="Thigh">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="" class="mb-0">Calf (cm)</label>
                                        <input class="form-control" name="calf" type="number"
                                            value="" placeholder="Calf">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- 
                            <div class="d-flex mb-4">
                                <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                                <form>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="color-1" name="color">
                                        <label class="custom-control-label" for="color-1">Black</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="color-2" name="color">
                                        <label class="custom-control-label" for="color-2">White</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="color-3" name="color">
                                        <label class="custom-control-label" for="color-3">Red</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="color-4" name="color">
                                        <label class="custom-control-label" for="color-4">Blue</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="color-5" name="color">
                                        <label class="custom-control-label" for="color-5">Green</label>
                                    </div>
                                </form>
                            </div> -->
                        <div class="d-flex align-items-start mb-4 pt-2 flex-column">
                            <div class="input-group quantity mr-3" style="width: 153.6px;">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-minus" onclick="decrementQuantity()"><i class="fa fa-minus"></i></button>
                                </div>
                                <input name="quantity" type="text" class="form-control bg-secondary text-center"
                                    value="1">
                                <div class="input-group-btn">
                                    <button  type="button" class="btn btn-primary btn-plus" onclick="incrementQuantity()">
                                    <!-- <button class="btn btn-primary btn-plus" type="submit" name="submit" <?php echo'onclick="addcart(this,' . $singleproduct->PROID . ')"';?>> -->
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="btn-grp">
                                <button class="btn btn-primary px-3" type="submit" name="submit" onclick="addcart(this,' . $singleproduct->PROID . ')"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                                <button class="btn <?php echo($wishflag?'btn-primary':'btn-outline-primary');?> px-3" type="button" name="wishlist" data-action="<?php echo ($wishflag ? 'remove' : 'add'); ?>" onclick="addwishlist(this,'<?php echo $singleproduct->PROID;?>')"><i class="fa fa-heart mr-1"></i><?php echo($wishflag?'Wishlisted':'Wishlist');?></button>
                            </div>
                        </div>

                            <!-- <?php
                            if ($singleproduct->cart_status == 1) {
                                ?>
                                <div class="input-group quantity mr-3" style="width: 153.6px;">
                                    <div class="input-group-btn">
                                        <?php 
                                        if ($singleproduct->CARTQTY == 1) {
                                            ?>
                                        <button class="btn btn-primary btn-minus" onclick="remove(<?= $singleproduct->id ?>)">
                                        <?php 
                                        } else {?>
                                        <button class="btn btn-primary btn-minus" onclick="minus(<?= $singleproduct->id ?>)">
                                        <?php } ?>
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control bg-secondary text-center"
                                        value="<?= $singleproduct->CARTQTY ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus" onclick="plus(<?= $singleproduct->id ?>)">
                                        <button class="btn btn-primary btn-plus" type="submit" name="submit" <?php echo'onclick="addcart(this,' . $singleproduct->PROID . ')"';?>>
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            } 
                                echo '<button class="btn btn-primary px-3" type="submit" name="submit" onclick="addcart(this,' . $singleproduct->PROID . ')"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>';
                            
                            ?> -->
                            <?php } else { ?>
                                <a class="mt-4 btn btn-outline-info" href="login.php">Login to add to cart</a>
                            <?php } ?>
                            <!-- PHP END HERE -->
                    </form>
                </div>
            </div>
        </div>
        <!-- Product Detail Start -->
        <div class="row px-xl-5" id="tab-content">
            <div class="col" >
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (<?=$totalReviews ?>)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <ul style="padding: 0; ">
                            <?php if (!empty($singleproduct->PRODESC)): ?>
                                <li class="mb-4" style="list-style-type:none;">
                                    <?= $singleproduct->PRODESC ?>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($singleproduct->PRODESCRIPTION1)): ?>
                                <li class="mb-4">
                                    <?= $singleproduct->PRODESCRIPTION1 ?>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($singleproduct->PRODESCRIPTION2)): ?>
                                <li class="mb-4">
                                    <?= $singleproduct->PRODESCRIPTION2 ?>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($singleproduct->PRODESCRIPTION3)): ?>
                                <li class="mb-4">
                                    <?= $singleproduct->PRODESCRIPTION3 ?>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($singleproduct->PRODESCRIPTION4)): ?>
                                <li class="mb-4">
                                    <?= $singleproduct->PRODESCRIPTION4 ?>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($singleproduct->PRODESCRIPTION5)): ?>
                                <li class="mb-4">
                                    <?= $singleproduct->PRODESCRIPTION5 ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>❤If you have any questions, feel free to leave us a message, and we'll respond within 12 hours.
                            However, please note that size and measurement, address, custom duty, and contact points are the
                            buyer's responsibility. Also, keep in mind that there may be a slight variation in color due to
                            different screening and photographic resolutions.❤</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row mx-2">
                            <div class="col-md-6">
                                <h4 class="mb-4"><?=$totalReviews != 0 ? $totalReviews : 'No' ?> <?=$totalReviews != 1 ? 'reviews': 'review' ?> for "<?= $singleproduct->PROTITLE ?>"</h4>
                                <?php
                                    $review_counter = 0;
                                    foreach ($reviews as $review) {
                                        if($review_counter == 3){
                                            break;
                                        }
                                        $review_counter++;
                                        echo '<div class="media mb-4">';
                                        echo '<img loading="lazy" src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">';
                                        echo '<div class="media-body">';
                                        echo '<h6>' . $review->user . '<small> - <i>' . date("d M Y", strtotime($review->date)) . '</i></small></h6>';
                                        
                                        $fullStars = floor($review->ratings);
                                        $halfStar = ($review->ratings - $fullStars) > 0 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;

                                        echo '<div class="text-primary mb-2">';
                                        for ($i = 0; $i < $fullStars; $i++) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                        }
                                        if ($halfStar) {
                                            echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                        }
                                        for ($i = 0; $i < $emptyStars; $i++) {
                                            echo '<i class="far fa-star text-warning"></i>';
                                        }
                                        echo '</div>';

                                        echo '<p>' . $review->review . '</p>';
                                        $query = "SELECT * FROM tblreviewimages WHERE review_id = ".$review->id;
                                        $mydb->setQuery($query);
                                        $revimages = $mydb->loadResultList();
                                        echo '<div style="display: flex; flex-direction:row; gap: 5px;">';
                                        foreach($revimages as $reviewimage){
                                            echo '<div style="width:85px;height:85px;border: 1px #eee solid; border-radius:7px;">';
                                            echo '<img loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:7px;"src="admin/products/uploaded_photos/reviews/'.$reviewimage->file_name.'" />';
                                            echo'</div>';
                                        }
                                        echo '</div></div>';
                                        
                                        echo '</div>';
                                    }
                                    if($review_counter == 3){
                                        echo '<button class="btn btn-primary mt-3" onclick="openReviewSidebar()">View All Reviews</button>';
                                    }
                                    ?>
                                
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <?php if(isset($_SESSION["USER"])) {?>
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3 ">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-warning reviews-stars-ctr">
                                        <i class="far fa-star fa-star-rev" data-value="1"></i>
                                        <i class="far fa-star fa-star-rev" data-value="2"></i>
                                        <i class="far fa-star fa-star-rev" data-value="3"></i>
                                        <i class="far fa-star fa-star-rev" data-value="4"></i>
                                        <i class="far fa-star fa-star-rev" data-value="5"></i>
                                    </div>
                                </div>
                                <form method="post" class="formReview" enctype="multipart/form-data">
                                    <input type="hidden" id="ratingValue" name="ratingValue" value="0">

                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" name="message" cols="30" rows="5" class="form-control" style="resize:none;" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" name="name" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <p class="mb-0 mr-2">Your Images :</p>
                                        <div class="container1"></div>
                                        <div class="col-md-12 container" style="margin: 0;">
                                            <div class="dropContainerImage d-flex flex-column justify-content-center align-items-center" style="border:2px solid #d1d3d4; border-style:dashed; border-radius: 20px; width:100%; height: 150px; ">
                                            <span>Drag your photo here or <span class="inner"><span class="select">Browse from device</span> </span></span>
                                            <input type="file" name="imageList" value="" id="image" class="input-img" accept="image/*" multiple />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" id="reviewSubmitButton" name="review_submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                                <?php } else { ?>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h4 class="mb-4">Login to leave a review</h4>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="overlay" onclick="closeReviewSidebar()"></div>
                            <div id="reviewSidebarContainer" class="review-sidebar-container">
                                <button class="btn btn-danger" onclick="closeReviewSidebar()">X</button>
                                
                                <div id="reviewSidebar" class="review-sidebar px-3">
                                    
                                    <h4 class="mb-4"><?= $singleproduct->PROTITLE ?></h4>
                                    <?php
                                        
                                        foreach ($reviews as $review) {
                                            echo '<hr class="mt-3 mb-3"/>';
                                            echo '<div class="media mb-4">';
                                            echo '<img loading="lazy" src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">';
                                            echo '<div class="media-body">';
                                            echo '<h6>' . $review->user . '<small> - <i>' . date("d M Y", strtotime($review->date)) . '</i></small></h6>';
                                            
                                            $fullStars = floor($review->ratings);
                                            $halfStar = ($review->ratings - $fullStars) > 0 ? 1 : 0;
                                            $emptyStars = 5 - $fullStars - $halfStar;

                                            echo '<div class="text-primary mb-2">';
                                            for ($i = 0; $i < $fullStars; $i++) {
                                                echo '<i class="fas fa-star text-warning"></i>';
                                            }
                                            if ($halfStar) {
                                                echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                            }
                                            for ($i = 0; $i < $emptyStars; $i++) {
                                                echo '<i class="far fa-star text-warning"></i>';
                                            }
                                            echo '</div>';

                                            echo '<p>' . $review->review . '</p>';
                                            $query = "SELECT * FROM tblreviewimages WHERE review_id = ".$review->id;
                                            $mydb->setQuery($query);
                                            $revimages = $mydb->loadResultList();
                                            echo '<div style="display: flex; flex-direction:row; gap: 5px;">';
                                            foreach($revimages as $reviewimage){
                                                echo '<div style="width:85px;height:85px;border: 1px #eee solid; border-radius:7px;">';
                                                echo '<img loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:7px;"src="admin/products/uploaded_photos/reviews/'.$reviewimage->file_name.'" />';
                                                echo'</div>';
                                            }
                                            echo '</div></div>';
                                            echo '</div>';
                                        }
                                        ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row px-xl-5">
            <div class="col-12 text-center mb-4">
                <h4 class="section-title px-5"><span class="px-2">Reviews</span></h4>
            </div>
            <div class="col-md-6">
                <h4 class="mb-4"><?=$totalReviews != 0 ? $totalReviews : 'No' ?> <?=$totalReviews != 1 ? 'reviews': 'review' ?> for "<?= $singleproduct->PROTITLE ?>"</h4>
                <?php
                    $review_counter = 0;
                    foreach ($reviews as $review) {
                        if($review_counter == 3){
                            break;
                        }
                        $review_counter++;
                        echo '<div class="media mb-4">';
                        echo '<img loading="lazy" src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">';
                        echo '<div class="media-body">';
                        echo '<h6>' . $review->user . '<small> - <i>' . date("d M Y", strtotime($review->date)) . '</i></small></h6>';
                        
                        $fullStars = floor($review->ratings);
                        $halfStar = ($review->ratings - $fullStars) > 0 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;

                        echo '<div class="text-primary mb-2">';
                        for ($i = 0; $i < $fullStars; $i++) {
                            echo '<i class="fas fa-star text-warning"></i>';
                        }
                        if ($halfStar) {
                            echo '<i class="fas fa-star-half-alt text-warning"></i>';
                        }
                        for ($i = 0; $i < $emptyStars; $i++) {
                            echo '<i class="far fa-star text-warning"></i>';
                        }
                        echo '</div>';

                        echo '<p>' . $review->review . '</p>';
                        $query = "SELECT * FROM tblreviewimages WHERE review_id = ".$review->id;
                        $mydb->setQuery($query);
                        $revimages = $mydb->loadResultList();
                        echo '<div style="display: flex; flex-direction:row; gap: 5px;">';
                        foreach($revimages as $reviewimage){
                            echo '<div style="width:85px;height:85px;border: 1px #eee solid; border-radius:7px;">';
                            echo '<img loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:7px;"src="admin/products/uploaded_photos/reviews/'.$reviewimage->file_name.'" />';
                            echo'</div>';
                        }
                        echo '</div></div>';
                        
                        echo '</div>';
                    }
                    if($review_counter == 3){
                        echo '<button class="btn btn-primary mt-3" onclick="openReviewSidebar()">View All Reviews</button>';
                    }
                    ?>
                
            </div>
            <div class="col-md-6 col-sm-12">
                <h4 class="mb-4">Leave a review</h4>
                <small>Your email address will not be published. Required fields are marked *</small>
                <div class="d-flex my-3 ">
                    <p class="mb-0 mr-2">Your Rating * :</p>
                    <div class="text-warning reviews-stars-ctr">
                        <i class="far fa-star fa-star-rev" data-value="1"></i>
                        <i class="far fa-star fa-star-rev" data-value="2"></i>
                        <i class="far fa-star fa-star-rev" data-value="3"></i>
                        <i class="far fa-star fa-star-rev" data-value="4"></i>
                        <i class="far fa-star fa-star-rev" data-value="5"></i>
                    </div>
                </div>
                <form method="post" class="formReview" enctype="multipart/form-data">
                    <input type="hidden" id="ratingValue" name="ratingValue" value="0">

                    <div class="form-group">
                        <label for="message">Your Review *</label>
                        <textarea id="message" name="message" cols="30" rows="5" class="form-control" style="resize:none;" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <p class="mb-0 mr-2">Your Images :</p>
                        <div class="container1"></div>
                        <div class="col-md-12 container" style="margin: 0;">
                            <div class="dropContainerImage d-flex flex-column justify-content-center align-items-center" style="border:2px solid #d1d3d4; border-style:dashed; border-radius: 20px; width:100%; height: 150px; ">
                            <span>Drag your photo here or <span class="inner"><span class="select">Browse from device</span> </span></span>
                            <input type="file" name="imageList" value="" id="image" class="input-img" accept="image/*" multiple />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email *</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group mb-0">
                        <input type="submit" id="reviewSubmitButton" name="review_submit" value="Leave Your Review" class="btn btn-primary px-3">
                    </div>
                </form>
            </div>
            <div class="overlay" onclick="closeReviewSidebar()"></div>
            <div id="reviewSidebarContainer" class="review-sidebar-container">
                <button class="btn btn-danger" onclick="closeReviewSidebar()">X</button>
                
                <div id="reviewSidebar" class="review-sidebar px-3">
                    
                    <h4 class="mb-4"><?= $singleproduct->PROTITLE ?></h4>
                    <?php
                        
                        foreach ($reviews as $review) {
                            echo '<hr class="mt-3 mb-3"/>';
                            echo '<div class="media mb-4">';
                            echo '<img loading="lazy" src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">';
                            echo '<div class="media-body">';
                            echo '<h6>' . $review->user . '<small> - <i>' . date("d M Y", strtotime($review->date)) . '</i></small></h6>';
                            
                            $fullStars = floor($review->ratings);
                            $halfStar = ($review->ratings - $fullStars) > 0 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;

                            echo '<div class="text-primary mb-2">';
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<i class="fas fa-star text-warning"></i>';
                            }
                            if ($halfStar) {
                                echo '<i class="fas fa-star-half-alt text-warning"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<i class="far fa-star text-warning"></i>';
                            }
                            echo '</div>';

                            echo '<p>' . $review->review . '</p>';
                            $query = "SELECT * FROM tblreviewimages WHERE review_id = ".$review->id;
                            $mydb->setQuery($query);
                            $revimages = $mydb->loadResultList();
                            echo '<div style="display: flex; flex-direction:row; gap: 5px;">';
                            foreach($revimages as $reviewimage){
                                echo '<div style="width:85px;height:85px;border: 1px #eee solid; border-radius:7px;">';
                                echo '<img loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:7px;"src="admin/products/uploaded_photos/reviews/'.$reviewimage->file_name.'" />';
                                echo'</div>';
                            }
                            echo '</div></div>';
                            echo '</div>';
                        }
                        ?>
                </div>
            </div>
                
            
        </div> -->
        <!-- Product Detail Start -->
        </div>
        <!-- Shop Detail End -->


        <!-- Products Start -->
        <div class="container-fluid py-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel" data-autoplay="false">
                        <?php
                        $count = 0;
                        foreach ($cur as $result) {
                            if ($_SESSION["country"] == "India") {
                                $mrpprice = $result->ORIGINALPRICE;
                                $dpprice = $result->PROPRICE;
                            } else {
                                $mrpprice = $result->USDMRP;
                                $dpprice = $result->USDPRICE;
                            }
                            $image = new Image();
                            $img = $image->single_image($result->PROID);
                            echo '<div class="card product-item border-0">
                        <a href="product.php?id=' . $result->PROID . '"><div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                           <img loading="lazy" class="img-fluid w-100 img-product" src="admin/products/uploaded_photos/' . $img->file_name . '" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">' . $result->PROTITLE . '</h6>
                            <div class="d-flex flex-column" style="gap:0px;">
                                <h6 class="text-muted"><del>' . $currencysymbol,$mrpprice . '.00</del></h6><h6>' . $currencysymbol, $dpprice . '.00</h6>
                            </div>
                        </div></a>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="product.php?id=' . $result->PROID . '" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>';
                            if ($result->cart_status == 0)
                                echo '<a href="product.php?id=' . $result->PROID . '" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>';
                            else
                                echo '<a href="cart.php" class="btn btn-sm text-dark p-0"><i class="fas  text-primary mr-1"></i>Go to cart</a>';
                            echo '</div>
                    </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Products End -->


        <!-- Footer Start -->
        <?php
        include('footer.php');
        ?>

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/slick-loader/slick-loader.min.js"></script>

        <!-- Contact Javascript File -->
        <!-- <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script> -->

        <!-- Template Javascript -->

        <script>
            // Function to reset the form
            
        </script>
        <script>
            // window.addEventListener("load", (event) => {
            //     function resetForm() {
            //         // document.getElementById("custom").style.display = "block";
            //         document.getElementById("cartForm").reset();
            //         document.getElementById("custom").style.display = "none";
            //         console.log("Form reset"); 
            //     }
            //     resetForm();
            // });
            document.addEventListener("DOMContentLoaded", function() {
                const reviewsLink = document.querySelector('.reviews-link');
                reviewsLink.addEventListener('click', function(event) {
                    event.preventDefault(); 

                    // Get the reviews tab content element
                    const reviewsTab = document.getElementById('tab-content');
                    const reviewsTabContent = document.getElementById('tab-pane-3');

                    const reviewsTabLink = document.querySelector('.nav-link[href="#tab-pane-3"]');

                    // If the tab content is not already shown, toggle the tab and scroll
                    if (!reviewsTabContent.classList.contains('show')) {
                        reviewsTabLink.click();

                    }
                    // Get the top position of the reviews section
                    const reviewsSectionTop = reviewsTab.offsetTop-160;

                    window.scrollTo({
                        top: reviewsSectionTop,
                        behavior: 'smooth' 
                    });
                });
                <?php if(isset($_SESSION["USER"])) { ?>
                let form = document.querySelector('.formReview');
                
                const stars = document.querySelectorAll('.fa-star-rev');
                const starsctr = document.querySelector('.reviews-stars-ctr')
                starsctr.addEventListener('mouseout', function() {
                    let total = document.getElementById('ratingValue').value;
                    for(let i = 0; i < stars.length; i++) {
                        if(i < total) {
                            stars[i].classList.remove('far');
                            stars[i].classList.add('fas');
                        } else {
                            stars[i].classList.remove('fas');
                            stars[i].classList.add('far');
                        }
                    }
                    
                });
                stars.forEach(star => {
                    star.addEventListener('mouseover', function() {
                        const value = this.getAttribute('data-value');
                        for(let i = 0; i < stars.length; i++) {
                            if(i < value) {
                                stars[i].classList.remove('far');
                                stars[i].classList.add('fas');
                            } else {
                                stars[i].classList.remove('fas');
                                stars[i].classList.add('far');
                            }
                        }
                    });
                    star.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        document.getElementById('ratingValue').value = value;
                    });
                });

                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission
                    SlickLoader.enable();
                    // console.log("Enter")
                    const formData = new FormData(form);
                    files.forEach((e, i) => {
                        formData.append(`image[]`, e);
                    });
                    formData.append('review_submit', 'Review data');

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'product.php?id=<?php echo $_GET['id'];?>', true);
                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 400) {
                            // Parse JSON response
                            console.log(xhr.responseText);
                            const response = JSON.parse(xhr.responseText.substring(xhr.responseText.indexOf("{"),xhr.responseText.indexOf("}")+1));
                            if (response.redirect) {
                            // Redirect to the specified URL

                            window.location.href = response.redirect;

                            } else {
                            console.error('Invalid redirect URL');
                            }
                        } else {
                            console.error('Error:', xhr.statusText);
                        }
                    };

                    xhr.send(formData);
                    // window.location.href = 'product.php?id=<?php echo $_GET['id'];?>';
                });

                <?php } ?>

                function showData(index) {
                    var carousel = document.querySelector('#product-carousel');
                    carousel.setAttribute('data-slide-to', index);
                    $('.carousel').carousel(index); // Using jQuery for easier carousel control
                }

                var smallImages = document.querySelectorAll('.image-123')
                smallImages.forEach((small,index)=>{
                    small.addEventListener('mouseover', function(event) {
                        if(event.target && event.target.nodeName == "IMG") {
                            var imagePath = 'admin/products/uploaded_photos/' + event.target.getAttribute('src').split('/').pop();
                            showData(index);
                            // console.log(imagePath)
                        } else if(event.target && event.target.nodeName == "VIDEO") {
                            var imagePath = 'admin/products/uploaded_videos/' + event.target.querySelector('source').getAttribute('src').split('/').pop();
                            showData(index);
                            // console.log(imagePath)
                        }
                    });
                })
                
            });

            <?php if(isset($_SESSION["USER"])) {?>
            let files = [],
                container = document.querySelector(".container1"),
                form = document.querySelector('.formReview'),
                text = document.querySelector('.inner'),
                browse = document.querySelector('.select'),
                input = document.querySelector('form .input-img'),
                dropContainer = document.querySelector('.dropContainerImage');


            browse.addEventListener('click', () => input.click());
            input.addEventListener('change', () => {
                let file = input.files;

                for (let i = 0; i < file.length; i++) {
                if (files.every(e => e.name != file[i].name))
                    files.push(file[i])
                }
                // form.reset();
                showImages();
            })
            const showImages = () => {
                let images = '';
                files.forEach((e, i) => {
                images += `<div class="image" style="margin-right: 7px;">
                                <img loading="lazy" src="${URL.createObjectURL(e)}" alt="image">
                                <span onclick="delImage(${i})" class="text-dark">&#11198;</span>
                                </div>`;
                });
                container.innerHTML = images;
            }
            const delImage = index => {
                files.splice(index, 1)
                showImages();
            }
            dropContainer.addEventListener('dragover', function(evt) {
                evt.preventDefault();
            });

            dropContainer.addEventListener('dragenter', function(evt) {
                evt.preventDefault();
            });

            dropContainer.addEventListener('drop', function(evt) {
                // input.files = evt.dataTransfer.files;
                files.push(evt.dataTransfer.files[0]);
                showImages();
                evt.preventDefault();
            });
            function checkForm() {
                var reviewValue = document.getElementById('message').value;
                var emailValue = document.getElementById('email').value;
                var ratingValue = document.getElementById('ratingValue').value;

                // Regular expression for email validation
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                if (reviewValue.trim() !== '' && emailPattern.test(emailValue) && ratingValue.trim() !== '0') {
                    document.getElementById('reviewSubmitBtn').disabled = false;
                } else {
                    document.getElementById('reviewSubmitBtn').disabled = true;
                }
            }
            <?php } ?>
            function showData(imagePath) {
                document.querySelector('.product-img--main__image').src = imagePath;
            }


            function incrementQuantity() {
                const input = document.querySelector('input[name="quantity"]');
                if (input) {
                    input.value = parseInt(input.value) + 1;
                }
            }

            function decrementQuantity() {
                const input = document.querySelector('input[name="quantity"]');
                if (input && input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }
            function custom() {
                // var custom = document.getElementById("custom");
                // var checkBox = document.getElementById("customcheck");
                var customSection = document.getElementById("custom");
                var Size = document.getElementById("size");
                var WaistSize = document.getElementById("waistSize");
                var man = document.getElementById("man");
                var fit = document.getElementById("fit-1");
                
                // var size = document.getElementById("size-1");

                // if (checkBox.checked == true) {
                //     custom.style.display = "block";
                //     Size.style.display = "none";
                //     WaistSize.style.display = "none";
                //     man.required = true;
                //     fit.required = true;
                //     size.required = false;
                // } else {
                //     custom.style.display = "none";
                //     Size.style.display = "block";
                //     WaistSize.style.display = "block";
                //     man.required = false;
                //     fit.required = false;
                //     size.required = true;
                // }
                if (customSection.style.display === "none") {
                    customSection.style.display = "block";
                    Size.style.display = "none";
                    WaistSize.style.display = "none";
                    // man.required = true;
                    // fit.required = true;
                    document.getElementById('cartForm').reset();

                    // size.required = false;
                } else {
                    customSection.style.display = "none";
                    Size.style.display = "block";
                    WaistSize.style.display = "block";
                    // man.required = false;
                    // fit.required = false;
                    // size.required = true;
                }
            }
            function addwishlist(button, proId) {
                var action = button.dataset.action;

                fetch('product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'proId=' + encodeURIComponent(proId) + '&action=' + encodeURIComponent(action),
                })
                .then(response => {console.log(response);return response.json();})
                .then(data => {
                    if (data.success) {
                        button.dataset.action = (data.isWishlisted ? 'remove' : 'add');

                        if (data.isWishlisted) {
                            button.classList.remove('btn-outline-primary');
                            button.classList.add('btn-primary');
                            button.innerHTML = '<i class="fa fa-heart mr-1"></i>Wishlisted';
                        } else {
                            button.classList.remove('btn-primary');
                            button.classList.add('btn-outline-primary');
                            button.innerHTML = '<i class="fa fa-heart mr-1"></i>Wishlist';
                        }
                    } else {
                        console.error('Failed to update wishlist status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            let scrollPosition = 0;
            function openReviewSidebar() {
                scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                // document.getElementById("reviewSidebar").style.width = "50vw";
                document.getElementById("reviewSidebarContainer").style.right = "0";
                document.getElementById("reviewSidebar").style.right = "0";
                document.querySelector(".overlay").style.display = "block";
                document.body.style.overflowY = "hidden";
                document.getElementsByTagName('html')[0].style.overflow = "hidden";

                
                setTimeout(() => {
                    window.scrollTo(0, scrollPosition);
                }, 5);
            }

            function closeReviewSidebar() {
                // document.getElementById("reviewSidebar").style.width = "0";
                document.getElementById("reviewSidebarContainer").style.right = "-150vw";
                document.getElementById("reviewSidebar").style.right = "-150vw";
                document.querySelector(".overlay").style.display = "none";
                document.body.style.overflowY = "auto";
                document.getElementsByTagName('html')[0].style.overflow = "auto";
            }
            // var owl = $(document).ready(function(){
            //     $(".owl-carousel").owlCarousel({
            //         autoplay: false
            //     });
            // });
            
            // owl.trigger('stop.owl.autoplay');
            
            function plus(id){
                const base = window.location.origin
                fetch(base+"/FinerFits/cartfunction.php", {
                method:'post',
                body: JSON.stringify({
                id: id,
                user: '<?= session_id()?>',
                mode: 'plus'
                }),
                headers: {
                'Content-Type': 'application/json'
                }
                }).then((response)=>{
                return response.json()
                }).then((res)=>{
                if(res.status == 1){
                location.reload()
                }else{
                alert(res.msg)
                }
                }).catch((error)=>{
                console.log(error)
                })
            }

            function minus(id){
                const base = window.location.origin
                fetch(base+"/FinerFits/cartfunction.php", {
                method:'post',
                body: JSON.stringify({
                id: id,
                user: '<?= session_id()?>',
                mode: 'minus'
                }),
                headers: {
                'Content-Type': 'application/json'
                }
                }).then((response)=>{
                return response.json()
                }).then((res)=>{
                if(res.status == 1){
                location.reload()
                }else{
                alert(res.msg)
                }
                }).catch((error)=>{
                console.log(error)
                })
            }


            function remove(id){
                const base = window.location.origin
                fetch(base+"/FinerFits/cartfunction.php", {
                method:'post',
                body: JSON.stringify({
                id: id,
                user: '<?= session_id()?>',
                mode: 'remove'
                }),
                headers: {
                'Content-Type': 'application/json'
                }
                }).then((response)=>{
                return response.json()
                }).then((res)=>{
                if(res.status == 1){
                location.reload()
                }else{
                alert(res.msg)
                }
                }).catch((error)=>{
                console.log(error)
                })
            }

            function addcart(e,proid){
                const base = window.location.origin
                // console.log(window.location.origin)
                // document.getElementById('cartForm').reset();
            //     fetch(base+"/FinerFits/cartfunction.php", {
            //     method:'post',
            //     body: JSON.stringify({
            //         id: proid,
            //         user: '<?= session_id()?>',
            //         mode: 'add'
            //     }),
            //     headers: {
            //         'Content-Type': 'application/json'
            //     }
            //     }).then((response)=>{
            //     document.getElementById('cartForm').reset();
            //     return response.json();
            // }).then((res)=>{
            //     if(res.status == 1){
            //     e.innerText = "Added"
            //     }else{
            //     alert(res.msg)
            //     }
            // }).catch((error)=>{
            //     console.log(error)
            // })
            
            }
            $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:2
            },
            576:{
                items:3
            },
            768:{
                items:4
            },
            992:{
                items:5
            },
            1200:{
                items:6
            }
        }
    });


    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        autoplayHoverPause: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });
        </script>
        <!-- <script src="js/main.js"></script> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://vjs.zencdn.net/8.6.1/video.min.js"></script>
        <script id="rendered-js">
            $('.product-img--main')
                // tile mouse actions
                .on('mouseover', function () {
                    $(this).children('.product-img--main__image').css({ 'transform': 'scale(' + $(this).attr('data-scale') + ')' });
                }).
                on('mouseout', function () {
                    $(this).children('.product-img--main__image').css({ 'transform': 'scale(1)' });
                }).
                on('mousemove', function (e) {
                    $(this).children('.product-img--main__image').css({ 'transform-origin': (e.pageX - $(this).offset().left) / $(this).width() * 100 + '% ' + (e.pageY - $(this).offset().top) / $(this).height() * 100 + '%' });
                })
            // tiles set up
            /*.each(function () {
                $(this)
                    // add a image container
                    .append('<div class="product-img--main__image"></div>')
                    // set up a background image for each tile based on data-image attribute
                    .children('.product-img--main__image').css({ 'background-image': 'url(' + $(this).attr('data-image') + ')' });
            });*/
            //# sourceURL=pen.js
        </script>
        

    </body>

    </html>
    <?php
} else {
    echo "404 NOT FOUND";
}
?>