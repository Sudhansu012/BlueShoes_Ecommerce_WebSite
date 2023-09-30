<?php

    error_reporting(E_ERROR | E_PARSE);
    session_start();

    $_SESSION['DelItem'] = 0; //delete item confirm for JS part of code
    $_SESSION['DelItem1'] = "";  //deleted item name
    if ($_SESSION['delete'] == 2){ //if delete confirm

        $_SESSION['DelItem'] = 1;
        $_SESSION['DelItem1'] = $_GET['ItemDel'];
        // echo "<script>alert('".$_GET['ItemDel']."');</script>";
        //header('Location: test5.php');
    }

    $_SESSION['delete'] = 1;
    $_SESSION['couponinuse'] = 0;  //coupon currently in use
    $_SESSION['coupAddYolo'] = 0;  //coupon adding
    $_SESSION['removecoup'] = 0;  //removing coupon

    if ($_SESSION['user_id'] == ""){
        header('Location: login_page_1.php');
    }
    if(!isset( $_SESSION['totalPrice'])) {
        $_SESSION['totalPrice'] = 0;
        //echo "hello";
    }
    if(!isset( $_SESSION['discount'])) {
        $_SESSION['discount'] = 0;
        //echo "hello";
    }
    if(!isset( $_SESSION['coupon'])) {
        $_SESSION['coupon'] = "";
        //echo "hello";
    }
    if(!isset( $_SESSION['couponDiscount'])) {
        $_SESSION['couponDiscount'] = "";
        //echo "hello";
    }
    if(!isset( $_SESSION['discPrice'])) {
        $_SESSION['discPrice'] = "";
        //echo "hello";
    }
    if(!isset( $_SESSION['delete'])) {
        $_SESSION['delete'] = 0;
        //echo "hello";
    }
    if(!isset( $_SESSION['shipping'])) {
        $_SESSION['shipping'] = 0;
        //echo "hello";
    }

    //Databse connection
    $con = mysqli_connect('localhost', 'Gaurav1', 'test123', 'blueshoes1');
    if (!$con){
        echo 'Connection Error: '.mysqli_connect_error();
    }

    //if user wants to delete coupon
    if ($_SESSION['delete'] == 1){
        //echo '<script>alert("Deleted u prick");</script>';
        $delete1 = json_decode($_GET['itemnum'], true);
        $isTouch = isset($delete1);
        if ($isTouch){
            $rpg = mysqli_fetch_row(mysqli_query($con, "select name from cart1 where cartid = '".$delete1['item']."'")); 
            $sql2 = "delete from cart1 where cartid = '".$delete1['item']."'";
            $res2 = mysqli_query($con, $sql2);
            unset($_GET['itemnum']);
            $_SESSION['delete'] = 2;
            header('Location: test5.php?ItemDel='.$rpg[0]);
            //echo '<script>alert("Deleted u prick1");</script>';
        }
        //echo '<script>alert("Deleted u prick");</script>';
        //$_SESSION['delete'] = 0;
    }

    //deleting coupon - setting session of coupon to NULL
    if (isset($_GET['rem'])){
        $_SESSION['coupon'] = "";
        $_SESSION['couponDiscount'] = 0;
        header('Location: test5.php');
    }
    $opq = json_decode($_GET['opq'], true);
    $isTouch = isset($opq);
    if ($isTouch){
        $sql2 = "update cart1 set quantity = '".$opq['quan']."' where cartid = '".$opq['item']."'";
        $res2 = mysqli_query($con, $sql2);
        //unset($opq);
        header('Location: test5.php');

        //echo '<script>alert("Added u prick");</script>';
    }


    //add coupon
    if (isset($_POST['coupbtn'])){
        //echo '<script>alert("HELLO!!");</script>';

        if ($_SESSION['coupon'] == ""){
            //echo '<script>alert("'.$_SESSION['coupon'].'");</script>';
            $sql2 = "select * from coupon where coupon = '".$_POST['couptext']."'";
            $res2 = mysqli_query($con, $sql2);
            if (mysqli_num_rows($res2)){
                $r1 = mysqli_fetch_row($res2);
                if ($r1[2] == 1){
                    echo '<script>alert("Coupon already used!!");</script>';
                }
                else{
                    $_SESSION['coupon'] = $r1[0];
                    $_SESSION['couponDiscount'] = $r1[1];
                    $_SESSION['coupAddYolo'] = 1;
                }
            }
            else{
                $_SESSION['removecoup'] = 1;
                //echo '<script>alert("No such coupon exists!!");</script>';
            }
            //echo '<script>alert("'.$_SESSION['coupon'].'");</script>';
        }
        else{
            // echo '<script>alert("Coupon already in use!!");</script>';
            $_SESSION['couponinuse'] = 1;
        }

    }

    //place order
    if (isset($_POST['placeorder'])){
        header('Location: checkout_module.php');
    }
    function showProd(){
        $con = $GLOBALS['con'];
        $_SESSION['discount'] = 0;
        $_SESSION['totalPrice'] = 0;
        $_SESSION['shipping'] = 0;
        $sql2 = "select * from cart1 where userid = ".$_SESSION['user_id']."";
        //echo '<script>alert("'.$sql2.'");</script>';
        $res2 = mysqli_query($con, $sql2);
        $countYay = 0;
        while($r1 = mysqli_fetch_row($res2)){
            $countYay = 1;
            echo '<div class = "c-product">
                    <div class = "show">
                    <div class = "image">
                        <img src = "images/'.$r1[1].'-'.$r1[3].'-0.webp">
                    </div>
                    <div class = "add">
                        <button class = "neg" onclick = "negquan(\''.$r1[7].'\', '.$r1[6].')">-</button>
                        <input type = "text" name = "quantity" id = "quan" value = "'.$r1[6].'" disabled>
                        <button class = "neg" onclick = "addquan(\''.$r1[7].'\', '.$r1[6].')">+</button>
                    </div>
                    </div>
                    <div class = "stuff">';

            $sql3 = "select * from products1 where id = '".$r1[1]."'";
            
            $res3 = mysqli_query($con, $sql3);
            $r3 = mysqli_fetch_row($res3);
                  echo '<p class = "s-brand">'.$r3[2].'</p>
                        <p class = "s-name">'.$r3[1].'</p>
                        <p class = "s-color">Color: <span class = "meribold">'.$r1[3].'</span></p>
                        <p class = "s-size">Size: <span class = "meribold">'.$r1[4].'</span></p>
                        <p class = "s-arch">Arch: <span class = "meribold">'.$r1[5].'</span></p>
                        <p class = "s-delete"><a onclick = "delitem(\''.$r1[7].'\')" class="bi bi-trash3-fill"></a></p>
                    </div>
                    <div class = "price">';
                   
                        if ($r3[11] != "0"){
                            $temp = ((100-$r3[11])*$r3[5])/100;
                            $tempd = round($temp - $r3[5], 2);
                            echo '<div class = "new">₹ '.$temp.'</div>';
                            echo '<div class = "old"><span class = "pr">₹ '.round($r3[5], 2).'</span><span class = "pt">  '.$r3[11].'% off</span></div>';
                        }
                        else{
                            $temp = $r3[5];
                            $tempd = 0;
                            echo '<div class = "new">₹ '.$r3[5].'</div>';
                        }
              echo '</div>
                  </div>';
            $_SESSION['totalPrice'] += ($temp*$r1[6]);
            $_SESSION['discount'] += $tempd;
            $_SESSION['shipping'] += $r3[15];
        }

        //if cart empty
        if ($countYay == 0){
            echo '<div class = "epol" align = center>';
            echo '<div class = "emptyCart">Cart is empty <i class="bi bi-emoji-smile-upside-down-fill"></i></div>';
            echo '<a href = "test11.php"><button class = "emptyCartbtn" onmouseenter = "showCartBut(1)" onmouseleave = "showCartBut(2)">
                    <i class="bi bi-arrow-left"></i>&nbsp
                    <i class="bi bi-bag-fill"></i>&nbsp
                    <span id = "browse">Browse products ?</span> </button></a>';
            echo '</div>';
        } else{
            echo '<form method = "post" class = "checkout" align = "right">
            <input class = "pbtn" type = "submit" name = "placeorder" value = "PLACE ORDER">
            </form>';
        }
        $_SESSION['tt'] = (((100-$_SESSION['couponDiscount'])*$_SESSION['totalPrice'])/100) + $_SESSION['shipping'];
    }

?>
</html>
    <head>
    <title>Something</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="stylesheet" href="alert/dist/sweetalert.css">

        <link rel = "stylesheet" href = "test5.css?v=<?php echo time(); ?>">
        <script src="https://kit.fontawesome.com/0318227299.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    </head>
    <body>
        <?php include('nav3.php');?>
    <div class = "main" style = "margin-top: 100px;">
        <div class = "cart">
        <h1 class = "c-header">My Cart</h1>
        <hr style = "margin-bottom: 20px;">
        <!-- <div class = "c-product">
            <div class = "show">
            <div class = "image">
                <img src = "https://rukminim1.flixcart.com/image/580/696/xif0q/shoe/l/b/b/-original-imagg6r9x7ej8x6t.jpeg?q=50">
            </div>
            <div class = "add">
                <button class = "neg">-</button>
                <input type = "text" name = "quantity" id = "quan" value = "1">
                <button class = "neg">+</button>
            </div>
            </div>
            <div class = "stuff">
            <p class = "s-brand">Brand</p>
            <p class = "s-name">Name of shoe that belongs to the brand</p>
            <p class = "s-color">Color: </p>
            <p class = "s-size">Size: 6</p>
            <p class = "s-arch">Arch: Low</p>
            <p class = "s-delete">Delete</p>
            </div>
            <div class = "price">
            <div class = "new">$1234</div>
            <div class = "old"><span class = "pr">$1345</span><span class = "pt">10%off</span></div>
            </div>
        </div>
        <hr>
        <div class = "c-product">
            <div class = "show">
            <div class = "image">
                <img src = "https://rukminim1.flixcart.com/image/580/696/xif0q/shoe/l/b/b/-original-imagg6r9x7ej8x6t.jpeg?q=50">
            </div>
            <div class = "add">
                <button class = "neg">-</button>
                <input type = "text" name = "quantity" id = "quan" value = "1">
                <button class = "neg">+</button>
            </div>
            </div>
            <div class = "stuff">
            <p class = "s-brand">Brand</p>
            <p class = "s-name">Name of shoe that belongs to the brand</p>
            <p class = "s-color">Color: </p>
            <p class = "s-size">Size: 6</p>
            <p class = "s-arch">Arch: Low</p>
            <p class = "s-delete">Delete</p>
            </div>
            <div class = "price">
            <div class = "new">$1234</div>
            <div class = "old"><span class = "pr">$1345</span><span class = "pt">10%off</span></div>
            </div>
        </div> -->
        <?php showProd() ?>

        </div>
        <div class = "check">
            <h3 class = "check-header">Price Details</h3>
            
            <div class = "subtotal">
                <p class = "lab1">Subtotal</p>
                <p class = "prc">₹ <?php echo $_SESSION['totalPrice']; ?></p>
                <p class = "lab1">Shipping Charges</p>
                <p class = "prc">₹ <?php echo $_SESSION['shipping']; ?></p>
                <p id = "lab2">
                    <i class="bi bi-file-x-fill" onclick = "removecoup()"></i>
                    Coupon Discount(<span id = "cpnname"></span>)
                </p>
                <p id = "prc2"></p> 
                <div class = "hide">Delete?</div>
            </div>
            <hr>
            <div class = "weout">
                <p class = "lab1">Total amount</p>
                <p class = "prc">₹ <?php echo $_SESSION['tt']; ?></p>
            </div>
            <hr>
            <form method = "post">
                <div class = "clearfix">
                <span class = "coup">Coupon Code?</span>
                <input type = "text" name = "couptext" class = "couptext">
                
                </div>
                <div class = "coupname" align= "right">
                    <input type = "submit" name = "coupbtn" value = "CHECK" class = "coupbtn" onclick = "funshow()">
                    
                </div>
            </form>
            <hr style = "margin-top: 20px;">
            
        </div>
    </div>
    <?php include('foot3.php');?>
    </body>
    <script>
        var coupname = "<?php echo $_SESSION['coupon'];?>";
        var discount = "<?php echo $_SESSION['couponDiscount'];?>";

        //updating coupon with its discount
        if (coupname != ""){
            document.getElementById('cpnname').innerHTML = coupname;
            document.getElementById('prc2').style.display = "block";
            document.getElementById('prc2').innerHTML = '-'+discount+'% Off';
            document.getElementById('lab2').style.display = "block";
            //window.open("test5.php", "_self");
        }

        //remove coupon
        function removecoup(){
            document.getElementById('prc2').style.display = "none";
            document.getElementById('lab2').style.display = "none";
            //alert("yo whats up");
            window.open("test5.php?rem=1", "_self");
        }

        //delete item - send json encoded string to this php file
        var itemNum = {item: 0};
        //alert("What!!");
        function delitem(itemid){
            itemNum['item'] = itemid;
            //alert(itemNum['item']);
            window.location = "test5.php?itemnum="+JSON.stringify(itemNum);
        }

        //adding and subtracting quantity
        var opq = {
            item: 0,
            quan: 0
        };
        //adding
        function addquan(timid, quan){
            opq['item'] = timid;
            opq['quan'] = quan+1;
            //alert("Yo whats up my g");
            //alert(opq['quan']);
            document.getElementById('quan').innerHTML = opq['quan'];
            window.location = "test5.php?opq="+JSON.stringify(opq);
        }

        //subtracting
        function negquan(timid, quan){
            opq['item'] = timid;
            opq['quan'] = quan-1;
            if (opq['quan'] < 1){
                Swal.fire(
            'Quantity cannot be less than 1!!','',
            'error'
            );
            }
            else{
                //alert("Yo whats up my g");
                //alert(opq['quan']);
                document.getElementById('quan').innerHTML = opq['quan'];
                window.location = "test5.php?opq="+JSON.stringify(opq);
            }
        }

        //if coupon in use
        var coupInuse = <?php echo $_SESSION['couponinuse'];?>;
        if (coupInuse){
                    Swal.fire(
            'Coupon already in use','',
            'error'
            );
        }

        //if adding a coupon
        var coupAdd = <?php echo $_SESSION['coupAddYolo']; ?>;
        if (coupAdd){

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Coupon added!!',
                showConfirmButton: false,
                timer: 1500
                });

        }

        //if removing a coupon
        var coupRem = <?php echo $_SESSION['removecoup']; ?>;
        if (coupRem){

            Swal.fire(
            'No such coupon exists!!','',
            'error'
            );

        }

        //removing an item from cart
        var ItemRemove = <?php echo $_SESSION['DelItem']; ?>;
        if (ItemRemove){
            Swal.fire(
            'Item Deleted!!','Item - "'+'<?php echo $_SESSION['DelItem1'];?>'+'" deleted.',
            'success'
            );

        }
        var gone = 0;
        
        //animation for Browse more product button when cart is empty
        function showCartBut(dd){
            if (dd == 1){
                var a = document.getElementById('browse');;
                gone = 0;
                var temp2 = "";
                var i = 0;
                var poir = setInterval(function(){ 
                        var bro = "Browse Products ?";
                        if (i == 16 || gone == 1){
                            clearTimeout(poir);
                        }
                        if (gone == 0){
                            temp2 += bro[i];
                            console.log(i);
                            i++;
                            a.innerHTML = temp2;
                            a.style.display = "inline"; }
                        else gone = 0;
                        }, 25);
                    
                // console.log(temp2);
                // clearTimeout();
            } else{
                var a = document.getElementById('browse');
                a.style.display = "none";
                gone = 1;
            }
        }
    </script>
</html>