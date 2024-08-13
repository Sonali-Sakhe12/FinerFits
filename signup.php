<?php
require_once("include/initialize.php");
if(isset($_SESSION["USER"])){
  redirect(web_root);
}
if(isset($_POST['submit']))
{
    $db = new Database();
    $password=hash("sha256",$_POST["pass"]);
    $date=date("Y-m-d");
    $sql = $db->conn->prepare(" INSERT INTO tblcustomer( FNAME, LNAME, STREETADD, BRGYADD, CITYADD, PROVINCE, COUNTRY,  PHONE, EMAILADD, ZIPCODE, CUSERNAME, CPASSWORD,  TERMS, DATEJOIN) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,1,?)");
    $sql->bind_param("sssssssssisss", $_POST["first"],$_POST["last"],$_POST["add1"],$_POST["add2"],$_POST["city"],$_POST["state"],$_POST["country"],$_POST["phone"],$_POST["email"],$_POST["pin"],$_POST["username"],$password,$date);
    // error_log($_POST["city"],3,'logfile.log');
    // $result=$sql->get_result();
    if( $sql->execute()){
      $mydb->setQuery('SELECT CUSTOMERID FROM tblcustomer WHERE EMAILADD = "'.$_POST["email"].'"');
      $custid = $mydb->loadSingleResult();
      $sql = $db->conn->prepare(" INSERT INTO tblshippingaddress(CUSTOMERID ,FNAME, LNAME, STREETADD, BRGYADD, CITYADD, PROVINCE, COUNTRY,  PHONENO, EMAIL, ZIPCODE) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
      $sql->bind_param("isssssssssi", $custid->CUSTOMERID, $_POST["first"],$_POST["last"],$_POST["add1"],$_POST["add2"],$_POST["city"],$_POST["state"],$_POST["country"],$_POST["phone"],$_POST["email"],$_POST["pin"]);
      $sql->execute();
      $mydb->setQuery('SELECT SHIPPINGADDRESSID FROM tblshippingaddress WHERE CUSTOMERID = '.$custid->CUSTOMERID);
      $custdefadd = $mydb->loadSingleResult();
      $mydb->setQuery('UPDATE tblcustomer SET DEFAULTADDRESSID = '.$custdefadd->SHIPPINGADDRESSID.' WHERE CUSTOMERID = '.$custid->CUSTOMERID);
      $mydb->executeQuery();
      $_SESSION["USER"]=$custid->CUSTOMERID;
      redirect(web_root."index.php");
    }
    
}

?>







<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Sign up @ FinerFits</title>
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
    <link href="img/favicon.ico" rel="icon">

<link href="css/style.css"  rel="stylesheet">

<style>
.login-page {
  width: 90vw;
  max-width: 800px;
  padding: 8% 0 0;
  margin: auto;
}
.login-page .form .login{
  margin-top: -31px;
margin-bottom: 26px;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 800px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}

.form .terms {
  width: 10%;
  margin-bottom: 5px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background-color: #328f8a;
  background-image: linear-gradient(45deg,blue,white);
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
}
.form button:disabled {
  background-image: linear-gradient(45deg,grey,white);
  
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: white;
  text-decoration: none;
}

.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}

body {
  background-color: white;
  background-image: linear-gradient(45deg,white,white);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.form .input-group {
    display: flex;
    gap: 10px;
  }

  .form .input-group input {
    flex: 1;
  }

  .login-form span{
    color:red;
    font-size: 12px;
    position: absolute;
    top: -12px;
  }


</style>
</head>

  <body>
    <div class="login-page">
      <div class="form" >
        <div class="login">
          <div class="login-header">
            <h3>Create a Account</h3>
          </div>
        </div>
        <form class="login-form" method="POST">
            <div class="row">
              <div class="col-12 col-md-6">
                <span id="warningFnameText" ></span>
                <input type="text" name="first" id="fname" placeholder="First name" required /> 
              </div>
              <div class="col-12 col-md-6">
                <span id="warningLnameText" ></span>
                <input type="text" name="last" id="lname" placeholder="Last name" required/>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <span id="warningEmailText" ></span>
                <input type="email" name="email" id="email" placeholder="Email" required/>
              </div>
              <div class="col-12 col-md-6">
                <span id="warningPhoneText" ></span>
                <input type="text" name="phone" id="phone" placeholder="Phone no" required/>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <span id="warningAdd1Text" ></span>
                <input type="text" name="add1" id="add1" placeholder="Address Line 1" required/>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <span id="warningAdd2Text" ></span>
                <input type="text" name="add2" id="add2" placeholder="Address Line 2" required/>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <span id="warningPinText" ></span>
                <input type="text" name="pin" id="pin" placeholder="Pincode" required/>
              </div>
              <div class="col-12 col-md-6">
                <input type="text" name="city" id="city" placeholder="City" required readonly/>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <input type="text" name="state" id="state" placeholder="State" required readonly/>
              </div>
              <div class="col-12 col-md-6">
                <input type="text" name="country" id="country" placeholder="Country" required readonly/>
              </div>
            </div>
            
            <div class="row">
              <div class="col-12">
                <span id="warningUsernameText" ></span>
                <input type="text" name="username" id="username" placeholder="Username" required/>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <span id="warningPasswordText" ></span>
                <input type="password" name="pass" id="password" placeholder="Password" required/>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-center mb-3">
              <input class="terms" type="checkbox" id="terms" name="term" />
              <label>Terms and conditions</label>
            </div>

            <button type="submit" id="submit" name="submit" disabled>Sign Up</button>
                
           
          </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

    <script>
    // function validateForm() {
    //   var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    //   var phonePattern = /^\d{10}$/;
    //   var pinPattern = /^\d{6}$/;

    //   var emailInput = document.getElementById('email');
    //   var phoneInput = document.getElementById('phone');
    //   var pinInput = document.getElementById('pin');

    //   if (!emailPattern.test(emailInput.value)) {
    //     alert('Please enter a valid email address.');
    //     return false;
    //   }

    //   if (!phonePattern.test(phoneInput.value)) {
    //     alert('Please enter a valid 10-digit phone number.');
    //     return false;
    //   }

    //   if (!pinPattern.test(pinInput.value)) {
    //     alert('Please enter a valid 6-digit pin code.');
    //     return false;
    //   }

    //   return true;
    // }
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
    let disableflag = {
        email:true,
        username:true,
        phone:true,
        password:true,
        fname:true,
        lname:true,
        add1:true,
        add2:true,
        city:true,
        state:true,
        country:true,
        pin:true,
        terms:true,
    }
    document.addEventListener("DOMContentLoaded", function() {
      function handleInputValidation(inputId, warningTextId, submitButtonId, existingValues) {
        const inputElement = document.getElementById(inputId);
        const warningText = document.getElementById(warningTextId);
        const submitButton = document.getElementById(submitButtonId);

        inputElement.addEventListener('input', handleinputchange);
        inputElement.addEventListener('keydown', handleinputchange);
        function handleinputchange() {
            let inputValue = this.value.trim();
            const isNotEmpty = inputValue !== '';

            if (!isNotEmpty) {
                warningText.textContent = 'This field cannot be empty.';
                disableflag[inputId] = true;
                submitButton.disabled = true;
            } else if (existingValues.includes(inputValue)) {
                warningText.textContent = `This ${inputId} is already in use.`;
                disableflag[inputId] = true;
                submitButton.disabled = true;
            } else {
                warningText.textContent = '';
                disableflag[inputId] = false;
                checkSubmitButton();
            }
        }
      }
      handleInputValidation('email', 'warningEmailText', 'submit', existingEmails);
      handleInputValidation('phone', 'warningPhoneText', 'submit', existingPhones);
      handleInputValidation('username', 'warningUsernameText', 'submit', existingUsernames);
      ['fname', 'lname', 'add1', 'add2', 'pin', 'password'].forEach(function(inputId) {
        const inputElement = document.getElementById(inputId);
        const warningText = document.getElementById(`warning${inputId.charAt(0).toUpperCase() + inputId.slice(1)}Text`);

        inputElement.addEventListener('input', handleinputchange);
        inputElement.addEventListener('keydown', handleinputchange);
        function handleinputchange() {
            let inputValue = this.value.trim();
            const isNotEmpty = inputValue !== '';

            if (!isNotEmpty) {
                warningText.textContent = 'This field cannot be empty.';
                disableflag[inputId] = true;
                if(inputId=="pin"){
                  disableflag['city']=true;
                  disableflag['state']=true;
                  disableflag['country']=true;
                }
            } else {
                warningText.textContent = ' ';
                disableflag[inputId] = false;
                if(inputId=="pin"){
                  disableflag['city']=false;
                  disableflag['state']=false;
                  disableflag['country']=false;
                }
                checkSubmitButton();
            }
        }
      });
      const termsCheckbox = document.getElementById('terms');
      termsCheckbox.addEventListener('change', function() {
          disableflag.terms = !this.checked;
          checkSubmitButton();
      });

      // Function to check and enable/disable the submit button
      function checkSubmitButton() {
          const submitButton = document.getElementById('submit');
          // console.log(disableflag);
          submitButton.disabled = Object.values(disableflag).some(flag => flag);
      }
    });
    function updateCityState(pincode) {
        $.ajax({
            url: 'https://api.postalpincode.in/pincode/' + pincode,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data[0].Status === 'Success') {
                    var postOffice = data[0].PostOffice[0];
                    $('#city').val(postOffice.District);
                    $('#state').val(postOffice.State);
                    $('#country').val(postOffice.Country);
                    // console.log( $('#city').val(), $('#state').val(), $('#country').val())

                } else {
                    console.error('Invalid Pincode');
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
    $(document).ready(function() {
            $('#pin').on('blur', function () {
                var pincode = $(this).val();
                updateCityState(pincode);
            });
      });
  </script>
</body>
</html>
