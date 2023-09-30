<?php
    error_reporting(E_ERROR | E_PARSE);

    //session start
    session_start();
    $env = json_decode($_GET['env'], true);
    //echo '<script> alert("'.$env['sql'].'");</script>';

    $isTouch = isset($env);
    if ($isTouch){
        //updating sessions
        //echo '<script>alert("oi u mad");</script>';
        $_SESSION['sql'] = $env['sql'];

    }

    //information from previous page - reptile
    $reptile = $_GET['catgio'];
    if (isset($reptile)){
        if ($reptile == 1){
            $_SESSION['sql'] = 'select * from products1 where catg = "MEN"';
        }
        else if ($reptile == 2){
            $_SESSION['sql'] = 'select * from products1 where catg = "WOMEN"';
        }
        else if ($reptile == 3){
            $_SESSION['sql'] = 'select * from products1 where catg = "KIDS"';
        }
        header('Location: test11.php');
    }

    //sessions for different attributes of footwear
    $_SESSION['i'] = 0;
    $_SESSION['color'] = "";
    $_SESSION['size'] = "";
    $_SESSION['arch'] = "";
    if(!isset( $_SESSION['sql'] ) ) {
        $_SESSION['sql'] = 'select * from products1';
    }

    //showing product one by one
    function showProd($sql){
        $num = 0;
        $con = mysqli_connect('localhost', 'Gaurav1', 'test123', 'blueshoes1');
        if (!$con){
            echo 'Connection Error: '.mysqli_connect_error();
        }
        // $sql = "select * from products1";
        $res = mysqli_query($con, $sql);
 
        while($r = mysqli_fetch_row($res)){
            $sql2 = 'select imageL from imagep where id = '.$r[0].' and mainpic = 1';

            $r2 = mysqli_fetch_row(mysqli_query($con, $sql2));
            // echo '<a style = "text-decoration: none;" href = "test6.php?productIDsend='.$r[0].'>';
            echo '<div class = "product" id = "'.$r[0].'">';
            echo '<a class = "linkify" style = "color: black; text-decoration: none;" href = "test10.php?productIDsend='.$r[0].'" target="_self">';
            echo '<img src = "images/'.$r[0].'-'.$r2[0].'-0.webp" alt = "dummyPic1">
                    
                    <div class="p">
                    <span class = "p-brand">'.$r[2].'</span>
                    <span class = "p-price">₹ '.$r[5].'</span>
                    <br>';
            if (strlen($r[1]) > 18){
                $r[1] = substr($r[1], 0, 18);
                $r[1] .= "...";
            }
                echo '<h4 class = "p-name">'.$r[1].'</h4>';
            $sql2 = 'select avg(rate) from rate1 where id = '.$r[0];
            $r2 = mysqli_fetch_row(mysqli_query($con, $sql2));
                echo '<p class = "p-rev"><i class = "fas fa-star"></i> '.round($r2[0], 1).'</p>';
                echo '</div></a></div>';
            $num = 1;
            
        }
        if ($num == 0){  //no product available
            echo '<p>No product available</p>';
        }
        mysqli_close($con);

    }

    //filter part - deciding the sql command for filtering products
    $num = 0;
    function pet($res){
        $temp = "";
        $num = $GLOBALS['num'];
        if ($num == 0){
            $temp .=  ' where (';
            $num++;
        }else{
            if ($res == 1){
                $temp .= ' and (';
            }else{
                $temp .= ' or';
            }
        }
        $GLOBALS['num'] = $num;
        return $temp;
        
    }

    //if filter update button pressed
    if (isset($_GET['update'])){
        $con = mysqli_connect('localhost', 'Gaurav1', 'test123', 'blueshoes1');
        if (!$con){
            echo 'Connection Error: '.mysqli_connect_error();
        }
        $sql = "select * from products1";

        //Category
        $categ = $_GET['Categ'];
        if (!empty($categ)){
            $num = count($categ);
                $sql .= ' where (';
            for($i=0; $i < $num; $i++){
                if ($i != 0){
                    $sql .= ' or ';
                }
                $sql .= 'catg = "'.$categ[$i].'"';
            }
            $sql .= ')';
        }

        $min = $_GET['min'];
        $max = $_GET['max'];

        $temp = $num;
        if (!empty($min)){
            $sql .= pet(1);
            $sql .= 'price > '.$min.')';
        }
        if (!empty($max)){
            $sql .= pet(1);
            $sql .= 'price < '.$max.')';
        }

        $color = $_GET['color'];
        if (!empty($color)){
            $sql .= pet(1);
            $num = count($color);
            // $_SESSION['color'] = [];
            for($i=0; $i < $num; $i++){
                if ($i != 0){
                    $sql .= ' or ';
                }
                // $_SESSION['color'].push($color[$i]);
                $sql .= 'color like "%'.$color[$i].'%"';
            }
            $sql .= ')';
        }

        $brand = $_GET['brand'];
        if (!empty($brand)){
            $sql .= pet(1);
            $num = count($brand);
            for($i=0; $i < $num; $i++){
                if ($i != 0){
                    $sql .= ' or ';
                }
                $sql .= 'brand = "'.$brand[$i].'"';
            }
            $sql .= ')';
        }

        $arch = $_GET['arch'];
        if (!empty($arch)){
            $sql .= pet(1);
            $num = count($arch);
            for($i=0; $i < $num; $i++){
                if ($i != 0){
                    $sql .= ' or ';
                }
                $sql .= 'arch like "%'.$arch[$i].'%"';
            }
            $sql .= ')';
        }

        $discount = $_GET['discount'];
        if (!empty($discount)){
            $sql .= pet(1);
            $num = count($discount);
            for($i=0; $i < $num; $i++){
                if ($i != 0){
                    $sql .= ' or ';
                }
                $sql .= 'discount = "'.$discount[$i].'"';
            }
            $sql .= ')';
        }
        $_SESSION['sql'] = $sql;
        if ($min >= $max && !empty($min) && !empty($max)){
            $_SESSION['sql'] = "select * from products1";
            //$_SESSION['color'] = ['black', 'white', 'red', 'pink', 'Blue'];
            echo '<script>alert("Please type Min-Max amount in proper manner")</script>';
        }
        //showProd($sql);
        //echo $sql;
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous"> -->
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script> -->
    <script src="https://kit.fontawesome.com/0318227299.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title>Document</title>
    <link rel = "stylesheet" href = "test2.css?v=<?php echo time(); ?>">
    <script
        src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous">
    </script>
    <!-- <script>function filterPile(){
        alert("Hello");
    }</script> -->
</head>
<body>
    <?php include("nav3.php"); ?>
    <div class="flex-container" style = "margin-top: 100px;">
        <div class = "c1">
        <form method = "get">
            <div class = "categories_e" style = "border-bottom: 1px solid black; border-top: 1px solid black; padding: 10px;">
                <div class = "dflexman">
                    <div id = "plpl">Categories</div> 
                    <div id = "mymanpl"><span class="fa fa-chevron-up rotate" onclick="showChecks('check_e')" style = "border: none;"></span></div>
                </div>
                <div id = "check_e" style = "margin-left: 20px; margin-top: 10px; display: block;" class = "check"> <div class = "d-flex flex-column">
                    <!-- <form method = "post"> -->
                        <div><input type = "checkbox" id = "men" name = "Categ[]" value = "men"> <label for = "men">Men</label></div>
                        <div><input type = "checkbox" id = "women" name = "Categ[]" value = "women"> <label for = "women">Women</label></div>
                        <div><input type = "checkbox" id = "kids" name = "Categ[]" value = "kids"> <label for = "kids">Kids</label></div>
                    <!-- </form> -->
                </div></div>
            </div>
            <div class = "price_e" style = "border-bottom: 1px solid black; border-top: 1px solid black; padding: 10px;">
                <div class = "dflexman">
                    <div id = "plpl">Price</div> 
                    <div id = "mymanpl"><span class="fa fa-chevron-up rotate" onclick="showChecks('check e1')" style = "border: none;"></span></div>
                </div>
                <div id = "check e1" style = "margin-left: 20px; margin-top: 10px; display: block;" class = "check"> 
                    
                    <div class = "d-flex flex-column">
                        <div style="margin-bottom: 5px;"><input type = "text" id = "cat1" placeholder = "Min" name = "min"></div>
                        <div style = "flex: 20%; text-align: center;"> To </div>
                        <div style="margin-top: 5px;"><input type = "text" id = "cat2" placeholder = "Max" name = "max"></div>
                    </div>
                </div>
            </div>
            <div class = "color_e" style = "border-bottom: 1px solid black; border-top: 1px solid black; padding: 10px;">
                <div class = "dflexman">
                    <div id = "plpl">Color</div> 
                    <div id = "mymanpl"><span class="fa fa-chevron-up rotate" onclick="showChecks('check e2')" style = "border: none;"></sp></div>
                </div>
                <div id = "check e2" style = "margin-left: 20px; margin-top: 10px; display: block;" class = "check"> <div class = "d-flex flex-column">
                    <!-- <form action = "test2.php" method = "post"> -->
                        <div><input type = "checkbox" id = "cat1" value = "Black" name = "color[]"><label for = "cat1">Black</label></div>
                        <div><input type = "checkbox" id = "cat2" value = "Blue" name = "color[]"><label for = "cat2">Blue</label></div>
                        <div><input type = "checkbox" id = "cat3" value = "White" name = "color[]"><label for = "cat3">White</label></div>
                        <div><input type = "checkbox" id = "cat4" value = "Red" name = "color[]"><label for = "cat4">Red</label></div>
                        <div><input type = "checkbox" id = "cat5" value = "Pink" name = "color[]"><label for = "cat5">Pink</label></div>
                        <div><input type = "checkbox" id = "cat6" value = "Green" name = "color[]"><label for = "cat6">Green</label></div>
                        <div><input type = "checkbox" id = "cat7" value = "Brown" name = "color[]"><label for = "cat7">Brown</label></div>
                        <div><input type = "checkbox" id = "cat8" value = "Grey" name = "color[]"><label for = "cat8">Grey</label></div>
                    <!-- </form> -->
                </div></div>
            </div>
            <div class = "brand_e" style = "border-bottom: 1px solid black; border-top: 1px solid black; padding: 10px;">
                <div class = "dflexman">
                    <div id = "plpl">Brand</div> 
                    <div id = "mymanpl"><span class="fa fa-chevron-up rotate" onclick="showChecks('check e3')" style = "border: none;"></span></div>
                </div>
                <div id = "check e3" style = "margin-left: 20px; margin-top: 10px; display: block;" class = "check"> <div class = "d-flex flex-column">
                    <!-- <form action = "test2.php" method = "post"> -->
                        <div><input type = "checkbox" id = "cat1" value = "Nike" name = "brand[]"> <label for = "cat1">Nike</label></div>
                        <div><input type = "checkbox" id = "cat2" value = "Puma" name = "brand[]"> <label for = "cat2">Puma</label></div>
                        <div><input type = "checkbox" id = "cat3" value = "Adidas" name = "brand[]"> <label for = "cat3">Adidas</label></div>
                        <div><input type = "checkbox" id = "cat3" value = "Reebok" name = "brand[]"> <label for = "cat3">Reebok</label></div>
                    <!-- </form> -->
                </div></div>
            </div>
            <div class = "arch_e" style = "border-bottom: 1px solid black; border-top: 1px solid black; padding: 10px;">
                <div class = "dflexman">
                    <div id = "plpl">Arch-Type</div> 
                    <div id = "mymanpl"><span class="fa fa-chevron-up rotate" onclick="showChecks('check_e4')" style = "border: none;"></span></div>
                </div>
                <div id = "check_e4" style = "margin-left: 20px; margin-top: 10px; display: block;" class = "check"> <div class = "d-flex flex-column">
                    <!-- <form action = "test2.php" method = "post"> -->
                        <div><input type = "checkbox" id = "cat1" value = "low" name = "arch[]"> <label for = "cat1">Low</label></div>
                        <div><input type = "checkbox" id = "cat2" value = "medium" name = "arch[]"> <label for = "cat2">Medium</label></div>
                        <div><input type = "checkbox" id = "cat3" value = "high" name = "arch[]"> <label for = "cat3">High</label></div>
                    <!-- </form> -->
                </div></div>
            </div>
            <div class = "discount_e" style = "border-bottom: 1px solid black; border-top: 1px solid black; padding: 10px;">
                <div class = "dflexman">
                    <div id = "plpl" >Discount</div> 
                    <div id = "mymanpl"><span class="fa fa-chevron-up rotate" onclick="showChecks('check e5')" style = "border: none;"></span></div>
                </div>
                <div id = "check e5" style = "margin-left: 20px; margin-top: 10px; display: block;" class = "check"> <div class = "d-flex flex-column">
                    <!-- <form action = "test2.php" method = "post"> -->
                        <div><input type = "checkbox" id = "cat1" value = "10" name = "discount[]"> <label for = "cat1">10% Discount</label></div>
                        <div><input type = "checkbox" id = "cat2" value = "20" name = "discount[]"> <label for = "cat2">20% Discount</label></div>
                        <div><input type = "checkbox" id = "cat3" value = "30" name = "discount[]"> <label for = "cat3">30% Discount</label></div>
                    <!-- </form> -->
                </div></div>
            </div>
            <a href = "test2.php"><input type = "submit" value = "Update" name = "update" class = "updatebtn"></a>
        </form>
        </div>
        <div class = "c2">
            <?php showProd($_SESSION['sql']) ?> 
                <!-- <div class = "product" id = "container">
                    <img class = "img-fluid mb-3" src = "images/1-black-0.webp" alt = "dummyPic1">
                    <div class="p">
                        <span class = "p-brand">Brand</span>
                        <span class = "p-price">Price</span>
                        <br>
                        <h4 class = "p-name">Name</h4>
                        <p class = "p-rev"><i class = "fas fa-star"></i> 4.2</p>
                    </div>
                    
                </div>
                <div class = "product">
                    <img class = "img-fluid mb-3" src = "images/1-red-1.webp" alt = "dummyPic1">
                    <div class="p">
                        <span class = "p-brand">Brand</span>
                        <span class = "p-price">PrHellice</span>
                        <br>
                        <h4 class = "p-name">Name</h4>
                        <p class = "p-rev"><i class = "fas fa-star"></i> 4.2</p>
                    </div>
                    
                </div>
                <div class = "product">
                    <img src = "images/1-black-0.webp" alt = "dummyPic1">
                    
                    <div class="p">
                        <span class = "p-brand">Brand</span>
                        <span class = "p-price">Price</span>
                        <br>
                        <h4 class = "p-name">Name</h4>
                        <p class = "p-rev"><i class = "fas fa-star"></i> 4.2</p>
                    </div>
                </div> -->
                    <!-- <div style = "margin: 0px";><button class = "add-to-cart">View Description</button></div> -->
                
        </div>
        <!-- </div> -->
    </div>
    <?php include("foot3.php"); ?>
    <script>
        function showChecks(id){
            var element = document.getElementById(id);
            if (element) {
                var display = element.style.display;

                if (display == "none") {
                    element.style.display = "block";
                } else {
                    element.style.display = "none";
                }
            }
            
        }
        $(".rotate").click(function () {
            $(this).toggleClass("down");
        })
        // var clientWidth = document.getElementById('container').clientWidth;
        // alert(clientWidth);
        <?php $nop = 123;?>
        // function goToProdPage(tagid){
        //     alert(tagid);
        //     <?php //$_SESSION['i'] = 0;?>
        //     window.open("test11.php?productIDsend = " + tagid);
        // }
        
        
    </script>

</body>
</html>