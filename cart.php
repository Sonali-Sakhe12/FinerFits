<?php
require_once("include/initialize.php");
$mydb->setQuery("SELECT * FROM tblcart c,tblproduct p where USER = '".(isset($_SESSION["USER"])?$_SESSION["USER"]:'-')."' and c.PROID=p.PROID");
$cur = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home @ FinerFits</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .table-cart a {
            color: #1C1C1C;
        }
        .table-cart a:hover, .table-cart a:focus {
            color: #1C1C1C !important; 
            text-decoration: underline;
        }
        .tooltip-inner {
            max-width: none !important; /* Ensure the tooltip can expand */
            width: fit-content !important;     /* Let the tooltip take the width it needs */
        }

    </style>
</head>

<body>
    <!-- Topbar Start -->
    <?php
    include('header.php');
    ?>
    <!-- Topbar End -->
    
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a class="text-dark" href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

<?php
if($cartcount <= 0)
{
    echo '
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" >
            <h1 class="py-2">Nothing In Cart</h1>
        </div>
    </div>
    ';
}else{
?>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0 table-cart">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                        $subtotal = 0;
                        $shipping = 10;
                        // function getSpecifications($cart) {
                        //     $showSize = true;
                        //     $specs = [
                        //         'Size' => $cart->size,
                        //         'Height' => $cart->height,
                        //         'Chest' => $cart->chest,
                        //         'Sleeve Length' => $cart->sleeve_length,
                        //         'Shoulder' => $cart->shoulder,
                        //         'Belly' => $cart->belly,
                        //         'Bicep' => $cart->bicep,
                        //         'Hip' => $cart->hip,
                        //         'Waist' => $cart->waist,
                        //         'Thigh' => $cart->thigh,
                        //         'Calf' => $cart->calf,
                        //         'Gender' => $cart->gender,
                        //         'Fit' => $cart->fit
                        //     ];
                        
                        //     $output = '<table class=\'table table-bordered\'>';
                        //     $output .= '<tr>';

                        //     foreach ($specs as $spec => $value) {
                        //         if ($value != 0 && $value != "") {
                        //             if (in_array($spec, ['Height', 'Chest', 'Sleeve Length', 'Shoulder', 'Belly', 'Bicep', 'Hip', 'Thigh', 'Calf', 'Gender', 'Fit'])) {
                        //                 $showSize = false;
                        //             }
                                    
                        //         }
                        //     }

                        //     if(!$showSize){
                        //         foreach ($specs as $spec => $value) {
                        //             if ($value != 0 && $value != "") {
                        //                 if (in_array($spec, ['Height', 'Chest', 'Sleeve Length', 'Shoulder', 'Belly', 'Bicep', 'Hip', 'Thigh', 'Calf', 'Gender', 'Fit', 'Waist'])) {
                        //                     $output .= "<th style=\"font-size:0.65rem;padding:2px;\">$spec</th>";
                        //                 }
                        //             }
                        //         }
                        //     } else {
                        //         $output .= "<th style=\"font-size:0.65rem;padding:2px;\">Size</th><th style=\"font-size:0.65rem;padding:2px;\">Waist</th>";
                        //     }
                        //     $output .= '</tr><tr>';

                            

                        //     if ($showSize) {
                        //         $output .= "<td style=\"font-size:0.65rem; padding:2px;\">" . $specs['Size'] . "</td>";
                        //         $output .= "<td style=\"font-size:0.65rem; padding:2px;\">" . $specs['Waist'] . "</td>";
                        //     } else {
                        //         foreach ($specs as $spec => $value) {
                        //             if ($value != 0 && $value != "" && in_array($spec, ['Height', 'Chest', 'Sleeve Length', 'Shoulder', 'Belly', 'Bicep', 'Hip', 'Thigh', 'Calf', 'Gender', 'Fit', 'Waist'])) {
                        //                 $output .= "<td style=\"font-size:0.65rem; padding:5px;\">$value</td>";
                        //             }
                        //         }
                        //     }

                        //     $output .= '</tr>';
                        //     $output .= '</table>';
                        //     return $output;
                        // }
                        function getSpecifications($cart) {
                            $specs = (($cart->height!=0&&$cart->chest!=0&&$cart->sleeve_length!=0&&$cart->shoulder!=0&&$cart->belly!=0&&$cart->bicep!=0&&$cart->hip!=0&&$cart->thigh!=0&&$cart->calf!=0&&$cart->gender!=""&&$cart->fit!="")?[
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
                            ]:['Size' => $cart->size,
                                'Waist' => $cart->waist]);
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
                        function getTooltipContent($cart, $img, $currencysymbol, $dpprice) {
                            $specificationTable = getSpecifications($cart);
                            
                            $output = '<div class="d-flex text-left align-items-start flex-column" style="gap:10px;">
                                <div class="d-flex text-left align-items-start" href="product.php?id=' . $cart->PROID . '" style="gap:10px;">
                                <img src="admin/products/uploaded_photos/' . $img->file_name . '" alt="" style="width: 50px;">
                                <div class="d-flex text-left align-items-start flex-column" style="gap:10px;">
                                <a class="m-0" href="product.php?id=' . $cart->PROID . '">' . $cart->PROTITLE . '</a>
                                '.$specificationTable.'
                                </div>
                                
                                </div>
                            </a>';
                            // echo'<script>console.log(`'.$output.'`)</script>';
                            return $output;
                        }
            //             foreach($cur as $cart)
            //             {
                            
            //                 if($_SESSION["country"] == "India")
            // {
            //     $mrpprice = $cart->ORIGINALPRICE;
            //     $dpprice = $cart->PROPRICE;
            // }else{
            //     $mrpprice = $cart->USDMRP;
            //     $dpprice = $cart->USDPRICE;
            // }
            //             $total = $dpprice *$cart->CARTQTY;
            //             $subtotal += $total;
            //             $image = New Image();
			//             $img =  $image->single_image($cart->PROID);
            //             echo'
            //                 <tr>
            //                 <td class="align-middle"><a class="d-flex text-left align-items-center" data-toggle="tooltip" data-placement="right" data-html="true" title="" style="gap:10px;" href="product.php?id='.$cart->PROID.'"><img src="admin/products/uploaded_photos/'.$img->file_name.'" alt="" style="width: 50px;"><p class="m-0">'.$cart->PROTITLE.'</p></a></td>
            //                 <td class="align-middle">'.$currencysymbol,$dpprice.'</td>
            //                 <td class="align-middle">
            //                     <div class="input-group quantity mx-auto" style="width: 100px;">
            //                         <div class="input-group-btn">
            //                             <button class="btn btn-sm btn-primary btn-minus" onclick="'.($cart->CARTQTY == 1?"remove":"minus").'('.$cart->id.')">
            //                             <i class="fa fa-minus"></i>
            //                             </button>
            //                         </div>
            //                         <input type="text" class="form-control form-control-sm bg-secondary text-center" value="'.$cart->CARTQTY.'">
            //                         <div class="input-group-btn">
            //                             <button class="btn btn-sm btn-primary btn-plus" onclick="plus('.$cart->id.')">
            //                                 <i class="fa fa-plus"></i>
            //                             </button>
            //                         </div>
            //                     </div>
            //                 </td>
            //                 <td class="align-middle">'.$currencysymbol,$dpprice *$cart->CARTQTY.'</td>
            //                 <td class="align-middle"><button class="btn btn-sm btn-primary" onclick="remove('.$cart->id.')"><i class="fa fa-times"></i></button></td>
            //             </tr>
            //                 ';
            //             }
                        
                        foreach ($cur as $cart) {
                            // ... your logic for getting $img, $currencysymbol, and $dpprice ...
                            if($_SESSION["country"] == "India")
                            {
                                $mrpprice = $cart->ORIGINALPRICE;
                                $dpprice = $cart->PROPRICE;
                            }else{
                                $mrpprice = $cart->USDMRP;
                                $dpprice = $cart->USDPRICE;
                            }
                            $total = $dpprice *$cart->CARTQTY;
                            $subtotal += $total;
                            $image = New Image();
                            $img =  $image->single_image($cart->PROID);
                        
                            
                            echo '<tr>';
                            echo '<td class="align-middle">' . getTooltipContent($cart, $img, $currencysymbol, $dpprice) . '</td>';
                            echo '<td class="align-middle">' . $currencysymbol,$dpprice . '</td>
                                        <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus" onclick="'.($cart->CARTQTY == 1?"remove":"minus").'('.$cart->id.')">
                                                <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary text-center" value="'.$cart->CARTQTY.'">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus" onclick="plus('.$cart->id.')">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">'.$currencysymbol,$dpprice *$cart->CARTQTY.'</td>
                                    <td class="align-middle"><button class="btn btn-sm btn-primary" onclick="remove('.$cart->id.')"><i class="fa fa-times"></i></button></td>';
                            // ... rest of your HTML ...
                        
                            echo '</tr>';
                        }
                        ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="mb-5" class="position-relative" >
                    <p class="position-absolute rounded px-2" id="coupon-status" style="top:-25px"></p>
                    <div class="input-group">
                        <input type="text" class="form-control p-4" id="coupon" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="applycoupon-button">Apply Coupon</button>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium" id="subtotal"><?= $currencysymbol,number_format($subtotal/1.12, 2 ,'.', '') ?></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Discount</h6>
                            <h6 class="font-weight-medium text-danger" id="discount">--</h6>
                        </div>
                        <div class="d-flex justify-content-between pt-1">
                            <h6 class="font-weight-medium">Tax (12%)</h6>
                            <h6 class="font-weight-medium" id="tax"><?= $currencysymbol,number_format($subtotal*0.12/1.12, 2 ,'.', '') ?></h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="total"><?= $currencysymbol,$subtotal ?></h5>
                        </div>
                        <a href="checkout.php" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
    <?php } ?>

    

    <!-- Footer Start -->
    <?php
    include('footer.php');
    ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> -->
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <!-- <script src="js/main.js"></script> -->
    <script>
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

        
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl,{sanitize: false}))
    });

    
    </script>

    <script>
        $(document).ready(function () {
            $("#applycoupon-button").click(function () {
                var couponCode = $("#coupon").val();
                var subtotal = <?=number_format($subtotal/1.12,2,'.','')?>;

                $.ajax({
                    url: 'getPromoCode.php',
                    method: 'GET',
                    data: {coupon: couponCode, subtotal: subtotal},
                    dataType: 'json', 
                    success: function (response) {
                        if ('error' in response) {
                            $("#coupon-status").text(response.error).removeClass('text-bg-success').addClass('text-bg-danger');
                        } else {
                            var couponStatus = response.title + ' applied!🎉';
                            $("#coupon-status").text(couponStatus).removeClass('text-bg-danger').addClass('text-bg-success');
                            updateBillingDetails(response.coupon_value, response.coupon_max_value, response.coupon_type);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error: " + error);
                    }
                });
            });
        });
        function updateBillingDetails(discount, max_discount, type) {
            var subtotal = parseFloat($("#subtotal").text().replace(/[^0-9.-]+/g, ""));
            var discountamount = type=="Flat"?discount:Math.min((discount*subtotal)/100, max_discount);
            var tax = (subtotal - discountamount) * 0.12;
            var total = subtotal - discountamount + tax;

            $("#subtotal").text('<?php echo $currencysymbol ?>' + subtotal.toFixed(2));
            $("#discount").text('(-) <?php echo $currencysymbol ?>' + discountamount.toFixed(2));
            $("#tax").text('<?php echo $currencysymbol ?>' + tax.toFixed(2));
            $("#total").text('<?php echo $currencysymbol ?>' + total.toFixed(2));
        }
    </script>

</body>

</html>

