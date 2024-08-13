<?php
require_once("include/initialize.php");
if(!isset($_SESSION["USER"])){
    redirect(web_root);
} 
$mydb->setQuery("SELECT * FROM tblsummary WHERE CUSTOMERID =".$_SESSION["USER"]);
$cursumids=$mydb->loadResultList();
$summflag = false;
foreach($cursumids as $summ){
    if($summ->ORDEREDNUM == $_GET['orderid']){
        $summflag = true;
    }
}
if(!$summflag){
    redirect(web_root);
}
?>
<html><head><title>Print</title><link href="<?php echo web_root; ?>admin/css/invoice.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head><body>
<?php
  if(isset($_GET['orderid']))
  {
  $customer = New customer;
  $res = $customer->single_customer($_GET['orderid']); 

  $query = "SELECT * 
							FROM  `tblproduct` p,  `tblcustomer` c,  `tblorder` o,  `tblsummary` s, `tblcoupon` d
							WHERE p.`PROID` = o.`PROID` 
							AND o.`ORDEREDNUM` = s.`ORDEREDNUM` 
							AND s.`CUSTOMERID` = c.`CUSTOMERID` 
                            AND s.`COUPONID` = d.`COUPONID` 
							AND o.`ORDEREDNUM`=".$_GET['orderid'];
				  		$mydb->setQuery($query);
				  		$cur = $mydb->loadResultList(); 
                        $qry = "SELECT * FROM `tblshippingaddress` WHERE SHIPPINGADDRESSID = ".$cur[0]->SHIPPINGADDRESSID;
                        $mydb->setQuery($qry);
                        $ship = $mydb->loadSingleResult();
                        $qry = "SELECT * FROM `tblshippingaddress` WHERE SHIPPINGADDRESSID = ".$cur[0]->BILLADDRESSID;
                        $mydb->setQuery($qry);
                        $bill = $mydb->loadSingleResult();

                        $name = $bill->FNAME." ".$bill->LNAME;
                        $address = $bill->STREETADD.", ".$bill->BRGYADD.",<br>".$bill->CITYADD.", ".$bill->PROVINCE.",<br>".$bill->COUNTRY." - ".$bill->ZIPCODE;
                        $phone = $bill->PHONENO;
                        $shipname = $ship->FNAME." ".$ship->LNAME;
                        $shipaddress = $ship->STREETADD.", ".$ship->BRGYADD.",<br>".$ship->CITYADD.", ".$ship->PROVINCE.",<br>".$ship->COUNTRY." - ".$ship->ZIPCODE ;
                        $shipphone = $ship->PHONENO;
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

?> 

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-right">
            <a class="btn btn-secondary" href='index.php'>Go to Home</a>
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto table-responsive">
        <div style="min-width: 600px">
            <header style="border-bottom:none;">
                <div class="row">
                    <div class="col" style="display:flex;height:100px;padding: 0 15px;">
                        <img src="<?php echo web_root; ?>img/logo.png" data-holder-rendered="true" />
                        <div class="adrress">
                            <p>FinerFits</p>
                            <p>97, Ganpati nagar, Ratidang,</p>
                            <p>Ajmer, Rajasthan, India - 305001</p>
                            <p>+91 9461594551 | +91 7014983905</p>
                            <p>shilpajaipur25185@gmail.com</p>
                        </div>
                        <div class="links invoice-details">
                            <p>&nbsp;</p>
                            <a>www.finerfits.com</a>
                            <div class="date">Date of Invoice: <?php echo date_format(date_create($cur[0]->ORDEREDDATE),"M d,Y h:i A"); ?></div>
                            <h1 class="invoice-id">INVOICE #<?= $_GET['orderid'] ?></h1>
                        </div>
                    </div>
                </div>
            </header>
            <hr style="color:#aaa;">
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to"><?= $name ?></h2>
                        <div class="address"><?= $address ?></div>
                        <div class="phone"><?= $phone ?></div>
                        <h3 class="to">Payment Details :</h3>
                        <div class="phone">Payment Method : <?php echo $cur[0]->PAYMENTMETHOD;?></div>
                    </div>
                    <div class="col invoice-to invoice-details">
                    <div class="text-gray-light">SHIPPING TO:</div>
                        <h2 class="to"><?= $shipname ?></h2>
                        <div class="address"><?= $shipaddress ?></div>
                        <div class="phone"><?= $shipphone ?></div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0" >
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th class="text-left">Description</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                            <?php
                             $count = 0;
                             foreach($cur as $product)
                              echo '
                              <tr>
                              <td class="no" style="text-align:center">'.++$count.'</td>
                              <td class="text-left"><div><h3>'.$product->PROTITLE.'</h3>'.getSpecifications($product).'<div></td>
                              <td class="unit">'.number_format($product->PROPRICE/1.12, 2, '.', '').'</td>
                              <td class="qty">'.$product->ORDEREDQTY.'</td>
                              <td class="total">&#8377;'.number_format($product->PROPRICE * $product->ORDEREDQTY / 1.12, 2, '.', '').'</td>
                              </tr>
                              ';
                            ?>
                            
                        
                    </tbody>
                    <tfoot>
                        <?php
                        $query = "SELECT * FROM `tblsummary` s ,`tblcustomer` c, `tblcoupon` d 
                        WHERE   s.`CUSTOMERID`=c.`CUSTOMERID` and ORDEREDNUM=".$_GET['orderid']." AND s.COUPONID = d.COUPONID ";
                $mydb->setQuery($query);
                $cur = $mydb->loadSingleResult();
                        ?>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>&#8377;<?= number_format($cur->PAYMENT/1.12, 2, '.' ,'') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">DISCOUNT</td>
                            <td style="color:red">(-) &#8377; <?=number_format($cur->COUPON_TYPE == "percentage" ? min($cur->PAYMENT*$cur->COUPON_VALUE/112, $cur->COUPON_MAX_VALUE) : $cur->COUPON_VALUE, 2, '.', '')?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">TAX (12%)</td>
                            <td>&#8377;<?=number_format(0.12*($cur->PAYMENT/1.12 - ($cur->COUPON_TYPE == "percentage" ? min($cur->PAYMENT*$cur->COUPON_VALUE/112, $cur->COUPON_MAX_VALUE) : $cur->COUPON_VALUE)), 2, '.', '')?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>&#8377;<?=number_format(1.12*($cur->PAYMENT/1.12 - ($cur->COUPON_TYPE == "percentage" ? min($cur->PAYMENT*$cur->COUPON_VALUE/112, $cur->COUPON_MAX_VALUE) : $cur->COUPON_VALUE)), 2, '.', '')?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script>
     $('#printInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                var printWindow = window.open("", "_blank");
                printWindow.document.write('<html><head><title>Print</title><link href="<?php echo web_root; ?>admin/css/invoice.css" rel="stylesheet"></head><body>');
                printWindow.document.write(data);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                setTimeout(function () {
                    printWindow.print();
                 }, 1000)
                
                return true;
            }
        });
</script>
<?php
  }
?>
</body></html>