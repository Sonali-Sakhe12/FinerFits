<style>
.whatsapp__connect {
  position: fixed;
  bottom: 20px;
  right: 15px;
  overflow: hidden;
  width: 50px;
  height: 50px;
  padding: 5px;
  background-color: #25d366;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
  border-radius: 25px;
  z-index: 1000;
}

.logo {
  width: 40px;
  height: 100%;
  margin-right: 10px;
  transition: width 0.3s ease-in-out;
}

.button-text {
  /* opacity: 0; */
  width: max-content;
  font-weight: bold;
  color: white;
  transition: opacity 0.3s ease-in-out;
}

.whatsapp__connect:hover {
  /* padding: 10px 40px; */
  width: 270px;
  /* height: 50px; */
}

.whatsapp__connect:hover .logo {
  width: 40px; /* Adjust the width of the logo as needed */
}

.whatsapp__connect:hover .button-text {
  /* opacity: 1; */
  
}
</style>
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><a href="<?php echo web_root;?>index.php"><img width="300"src="<?php echo web_root;?>img/website-logo.png"></a></h1>
                <div class="mb-2 d-flex flex-row"><i class="fa fa-map-marker-alt text-primary mr-3 mt-1"></i><p class="mb-0">97, Ganpati nagar, Ratidang,<br>Ajmer, Rajasthan,<br> India - 305001</p></div>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>shilpajaipur25185@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 9461594551 | +91 7014983905</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row d-flex justify-content-lg-between">
                    <div class="col-md-5 mb-5 d-lg-flex flex-lg-column align-items-lg-center">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>About us</a>
                            <a class="text-dark mb-2" href="<?php echo web_root;?>policies/TermsAndConditions.php"><i class="fa fa-angle-right mr-2"></i>Terms and Conditions</a>
                            <a class="text-dark mb-2" href="<?php echo web_root;?>policies/ShippingPolicy.php"><i class="fa fa-angle-right mr-2"></i>Shipping and Delivery</a>
                            <a class="text-dark mb-2" href="<?php echo web_root;?>policies/RefundPolicy.php"><i class="fa fa-angle-right mr-2"></i>Refund and Cancellation</a>
                            <a class="text-dark mb-2" href="<?php echo web_root;?>policies/PrivacyPolicy.php"><i class="fa fa-angle-right mr-2"></i>Privacy Policy</a>
                            <a class="text-dark mb-2" href="<?php echo web_root;?>contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                            <a class="text-dark" href="<?php echo web_root;?>tracking.php"><i class="fa fa-angle-right mr-2"></i>Track your Order</a>
                        </div>
                    </div>
                    <!-- <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div> -->
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
                    &copy; <a class="text-dark font-weight-semi-bold" href="<?php echo web_root;?>index.php">FinerFits</a>. All Rights Reserved. Designed
                    by <a class="text-dark font-weight-semi-bold" href="https://tractionshastra.com">Traction Shastra</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="<?php echo web_root;?>img/payments.png" alt="">
            </div>
        </div>
    </div>
    <a class="whatsapp__connect" target="_blank"style="text-decoration:none;" href="https://wa.me/+919461594551?text=Hi,%20I%20had%20an%20inquiry%20about%20your%20products%20at%20FinerFits.">
        <img src="<?php echo web_root;?>img/whatsapplogo.png" alt="Logo" class="logo">
        <span class="button-text" >Connect on Whatsapp</span>
    </a>

    <?php
    include('map.php');
    ?>