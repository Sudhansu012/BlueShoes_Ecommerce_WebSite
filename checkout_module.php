<?php
    session_start();
    $_SESSION['checkoutError'] = "";
    $_SESSION['validCard'] = 0;

    //indian states
    $indian_states = array (
        'AP' => 'andhra pradesh',
'AR' => 'arunachal pradesh',
'AS' => 'assam',
'BR' => 'bihar',
'CT' => 'chhattisgarh',
'GA' => 'goa',
'GJ' => 'gujarat',
'HR' => 'haryana',
'HP' => 'himachal pradesh',
'JK' => 'jammu and kashmir',
'JH' => 'jharkhand',
'KA' => 'karnataka',
'KL' => 'kerala',
'MP' => 'madhya pradesh',
'MH' => 'maharashtra',
'MN' => 'manipur',
'ML' => 'meghalaya',
'MZ' => 'mizoram',
'NL' => 'nagaland',
'OR' => 'odisha',
'PB' => 'punjab',
'RJ' => 'rajasthan',
'SK' => 'sikkim',
'TN' => 'tamil nadu',
'TR' => 'tripura',
'UK' => 'uttarakhand',
'UP' => 'uttar pradesh',
'WB' => 'west bengal',
       );

       $months1 = array('0'=>'january',
       '1'=>'february',
       '2'=>'march',
       '3'=>'april',
       '4'=>'may',
       '5'=>'june',
       '6'=>'july ',
       '7'=>'august',
       '8'=>'september',
       '9'=>'october',
       '10'=>'november',
       '11'=>'december');

    //validating checkout input after pressing "proceed to checkout"
    if (isset($_POST['checkoutYolo'])){

        $err = 0;

        //name
        if (empty($_POST['fname'])) {
            $err = 1;
        } else {
            $name = test_input($_POST["fname"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $_SESSION['checkoutError'] = "Only letters and white space allowed in name!!";
                $err = 2;
            }
        }
        
        //email
        if (empty($_POST["femail"])) {
            $err = 1;
        } else {
            $email = test_input($_POST["femail"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['checkoutError'] = "Invalid email format!!";
                $err = 2;
            }
        }

        //address
        if (empty($_POST['faddress'])) {
            $err = 1;
        }

        //city
        if (empty($_POST['fcity'])) {
            $err = 1;
        } else {
            $city = test_input($_POST["fcity"]);
            // check if city only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$city)) {
                $_SESSION['checkoutError'] = "Only letters and white space allowed in city!!";
                $err = 2;
            }
        }

        //state
        if (empty($_POST['fstate'])) {
            $err = 1;
        } else {
            $state = test_input($_POST["fstate"]);
            // check if name only contains letters and whitespace
            if (!in_array(strtolower($state), $indian_states)) {
                $_SESSION['checkoutError'] = "Should be valid Indian state!!";
                $err = 2;
            }
        }

        //zip
        if (empty($_POST['fzip'])) {
            $err = 1;
        } else {
            $zip = test_input($_POST["fzip"]);
            // check if name only contains letters and whitespace
            if (strlen($zip) != 6 or !is_numeric($zip)) {
                $_SESSION['checkoutError'] = "Zip code should be of 6 digits and only numbers";
                $err = 2;
            }
        }

        //name
        if (empty($_POST['fnamec'])) {
            $err = 1;
        } else {
            $name = test_input($_POST["fnamec"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $_SESSION['checkoutError'] = "Only letters and white space allowed in Card name!!";
                $err = 2;
            }
        }

        //zip
        if (empty($_POST['fcardno'])) {
            $err = 1;
        } else {
            $cardNo = test_input($_POST["fcardno"]);
            // check if name only contains letters and whitespace
            if (strlen("$cardNo") != 16) {
                $_SESSION['checkoutError'] = "Card number should have 16 digits!!";
                $err = 2;
            }
        }

        //month
        if (empty($_POST['fmonth'])) {
            $err = 1;
        } else {
            $month = test_input($_POST["fmonth"]);
            // check if name only contains letters and whitespace
            if (!in_array(strtolower($month), $months1)) {
                $_SESSION['checkoutError'] = "Enter valid month!!";
                $err = 2;
            }
        }

        //cvv
        if (empty($_POST['fcvv'])) {
            $err = 1;
        } else {
            $cvv = test_input($_POST["fcvv"]);
            // check if name only contains letters and whitespace
            if (!is_numeric($cvv)) {
                $_SESSION['checkoutError'] = "CVV should only be numbers!!";
                $err = 2;
            }
        }

        if ($err == 1){
            $_SESSION['checkoutError'] = "Details should not be empty";
        } else if ($err == 0){
            $_SESSION['checkoutError'] = "";
            $con = mysqli_connect('localhost', 'Gaurav1', 'test123', 'blueshoes1');
            if (!$con){
                echo 'Connection Error: '.mysqli_connect_error();
            }
            $sql2 = "select purchaseNo from login where id = ".$_SESSION['user_id'];
            $res2 = mysqli_query($con, $sql2);
            $r2 = mysqli_fetch_row($res2);

            $sql1 = "select * from cart1 where userid = ".$_SESSION['user_id'];
            $res1 = mysqli_query($con, $sql1);
            while($r1 = mysqli_fetch_row($res1)){
                $sql3 = "insert into purchase1(userid, productid, name, color, size, arch, quantity, purchaseNo, discount)
                            values(".$r1[0].", ".$r1[1].", '"
                                .$r1[2]."', '"
                                .$r1[3]."', '"
                                .$r1[4]."', '"
                                .$r1[5]."', "
                                .$r1[6].", ".$r2[0].", ".$_SESSION['couponDiscount'].")";
                $res3 = mysqli_query($con, $sql3);
            }

            //updating login table - user now has purchaseNo + 1 purchases
  
            $sql4 = "update login set purchaseNo = purchaseNo + 1 where id = ".$_SESSION['user_id'];
            $res4 = mysqli_query($con, $sql4);

            //deleting or emptying cart
            $sql5 = "delete from cart1 where userid = ".$_SESSION['user_id'];
            $res5 = mysqli_query($con, $sql5);

            header('Location: test7.php?message_me=Payment Confirmed!!<br>Thankyou for ordering <i class="bi bi-emoji-laughing-fill"></i>');
        }


    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "styleCheckout.css?v=<?php echo time(); ?>">
       
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="stylesheet" href="alert/dist/sweetalert.css">
    <!-- custom css file link  -->
    <!-- <link rel="stylesheet" href="styleCheckout.css"> -->

</head>
<body>
<?php include("nav3.php"); ?>
<div class="container" style = "margin-top: 100px;">
    <form method = "post" class = "checkoutbill">

        <div class="row">

            <div class="col">

                <h3 class="title">billing address</h3>

                <div class="inputBox">
                    <span>full name :</span>
                    <input type="text" placeholder="john deo" name = "fname">
                </div>
                <div class="inputBox">
                    <span>email :</span>
                    <input type="email" placeholder="example@example.com" name = "femail">
                </div>
                <div class="inputBox">
                    <span>address :</span>
                    <input type="text" placeholder="room - street - locality" name = "faddress">
                </div>
                <div class="inputBox">
                    <span>city :</span>
                    <input type="text" placeholder="mumbai" name = "fcity">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>state :</span>
                        <input type="text" placeholder="india" name = "fstate">
                    </div>
                    <div class="inputBox">
                        <span>zip code :</span>
                        <input type="text" placeholder="123 456" name = "fzip">
                    </div>
                </div>

            </div>

            <div class="col">

                <h3 class="title">payment</h3>

                <div class="inputBox">
                    <span>cards accepted :</span>
                    <img src="images/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>name on card :</span>
                    <input type="text" placeholder="mr. john deo" name = "fnamec">
                </div>
                <div class="inputBox">
                    <span>credit card number :</span>
                    <input type="number" placeholder="1111-2222-3333-4444" name = "fcardno">
                </div>
                <div class="inputBox">
                    <span>exp month :</span>
                    <input type="text" placeholder="january" name = "fmonth">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>exp year :</span>
                        <input type="number" placeholder="2022">
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" placeholder="1234" name = "fcvv">
                    </div>
                </div>

            </div>
    
        </div>

        <input name = "checkoutYolo" type="submit" value="proceed to checkout" class="submit-btn">

    </form>
    <div class = "check">
        <h3 class = "check-header">Price Details</h3>
        
        <div class = "subtotal">
            <p class = "lab1">Subtotal</p>
            <p class = "prc">₹ <?php echo $_SESSION['totalPrice']; ?></p>
            <p class = "lab1">Shipping Charges</p>
            <p class = "prc">₹ <?php echo $_SESSION['shipping']; ?></p>
            <p id = "lab2">
                Coupon Discount(<span id = "cpnname"></span>)
            </p>
            <p id = "prc2"></p> 
            <div class = "hide">Delete?</div>
        </div>
        <!-- <hr> -->
        <div class = "weout">
            <p class = "lab1">Total amount</p>
            <p class = "prc">₹ <?php echo $_SESSION['tt']; ?></p>
        </div>
        <button class = "gotocart" onclick = "window.open('test5.php', '_self')">BACK TO CART ?</button>
        <!-- <form method = "post">
            <div class = "clearfix">
            <span class = "coup">Coupon Code?</span>
            <input type = "text" name = "couptext" class = "couptext">
            
            </div>
            <div class = "coupname" align= "right">
                <input type = "submit" name = "coupbtn" value = "CHECK" class = "coupbtn" onclick = "funshow()">
                
            </div>
        </form> -->

            
        </div>

</div>   
<?php include("foot3.php"); ?> 
<script>
        var coupname = "<?php echo $_SESSION['coupon']?>";
        var discount = "<?php echo $_SESSION['couponDiscount']?>";

        if (coupname != ""){
            document.getElementById('cpnname').innerHTML = coupname;
            document.getElementById('prc2').style.display = "block";
            document.getElementById('prc2').innerHTML = '-'+discount+'% Off';
            document.getElementById('lab2').style.display = "block";
            //window.open("test5.php", "_self");
        }
        var error = '<?php echo $_SESSION['checkoutError']; ?>';
        if (error != ""){
            Swal.fire(
            error,
            '',
            'error'
            );
        }
        // var valid = '<?php //echo $_SESSION['validCard']; ?>';
        // if (valid){
        //     Swal.fire(
        //     "Valid Card",
        //     '',
        //     'success'
        //     )
        // }
    </script>
    
</body>
</html>