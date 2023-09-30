<?php
    error_reporting(E_ERROR | E_PARSE);
    session_start();

    //product elements
    $mainName = "";  //product name
    $color = "";
    $size = "";
    $arch = "";

    //mysql connection
    $con = mysqli_connect('localhost', 'Gaurav1', 'test123', 'blueshoes1');
    if (!$con){
        echo 'Connection Error: '.mysqli_connect_error();
    }

    //add to cart button
    if (isset($_POST['gotocart'])){
        
        $_SESSION['i'] = 0;
        if ($_SESSION['user_id'] == ""){
            //echo '<script>alert("Please sign in first");</script>';
            header('Location: login_page_1.php');
        }
        $temp = "";
        $temp1 = str_split($_SESSION['mainName']) ;
        foreach ($temp1 as $quity){
            if (ctype_alnum($quity)){
                $temp .= $quity;
            }else{
                $temp .= '\\'.$quity;
            }
        }
        $_SESSION['mainName'] = $temp;
        $sql2 = "insert into cart1(userid, productid, name, color, size, arch, quantity) values("
                        .$_SESSION['user_id'].","
                        .$_SESSION['id'].",'"
                        .$_SESSION['mainName']."','"
                        .$_SESSION['color']."','"
                        .$_SESSION['size']."','"
                        .$_SESSION['arch']."', 1)";
        echo '<script>alert("'.$sql2.'");</script>';
            
        $sql3 = "select * from cart1 where "
                            ."userid = ".$_SESSION['user_id']." and "
                            ."productid = ".$_SESSION['id']." and "
                            ."color = '".$_SESSION['color']."' and "
                            ."size = '".$_SESSION['size']."' and "
                            ."arch = '".$_SESSION['arch']."'";
        $num1 = 0;
        $res3 = mysqli_query($con, $sql3);
        if (mysqli_num_rows($res3)){
            header('Location: test7.php?message_me=Item already in cart!!<br><i class="bi bi-basket2-fill"></i>');
        }
        else{
            $res2 = mysqli_query($con, $sql2);
            if ($res2){
                header('Location: test7.php?message_me=Added to Cart successfully!!<i class="bi bi-cart-check-fill"></i>');
            }
            else{
                //echo '<script>alert("Error adding to cart");</script>';
                header('Location: test10.php');
            }
        }
    }

    // $_SESSION['i'] = 0;
    //session for the first time?
    if(!isset( $_SESSION['i'])) {
        $_SESSION['i'] = 0;
        //echo "hello";
    }
    if(!isset( $_SESSION['user_id'])) {
        $_SESSION['user_id'] = "8";
        //echo "hello";
    }
    if(!isset( $_SESSION['id'])) {
        $_SESSION['id'] = "1";
        //echo "hello";
    }
    $colarr = array();
    $sizearr = array();
    $archarr = array();

    // $env = $_GET['env'];
    //setting cookies - when web page entered for the first time
    if ($_SESSION['i'] == 0){
        if (isset($_GET['productIDsend'])){
            $_SESSION['id'] = $_GET['productIDsend'];
        }
        //environment array
        $env = array('color'=>'', 'size'=>'', 'arch'=>'');

        //color part
        $sql2 = "select * from color1 where id = '".$_SESSION['id']."'";
        $res2 = mysqli_query($con, $sql2);
        $r1 = mysqli_fetch_row($res2);
        $env['color'] = $r1[1];

        //size part
        $sql2 = "select * from size1 where id = '".$_SESSION['id']."'";
        $res2 = mysqli_query($con, $sql2);
        $r1 = mysqli_fetch_row($res2);
        $env['size'] = $r1[1];

        //arch part
        $sql2 = "select * from arch1 where id = '".$_SESSION['id']."'";
        $res2 = mysqli_query($con, $sql2);
        $r1 = mysqli_fetch_row($res2);
        $env['arch'] = $r1[1];

        //updating sessions
        $_SESSION['color'] = $env['color'];
        $_SESSION['arch'] = $env['arch'];
        $_SESSION['size'] = $env['size'];

        //echo '<script>alert("Reset the thing");</script>';
        $_SESSION['i'] = 1;
        //header('Location: test4.php');
    } else{ 
        $env = json_decode($_GET['env'], true);
        $isTouch = isset($env);
        if ($isTouch){
            //updating sessions
            //echo '<script>alert("oi u mad");</script>';
            $_SESSION['color'] = $env['color'];
            $_SESSION['arch'] = $env['arch'];
            $_SESSION['size'] = $env['size'];
        }
    }

    //varriables
    $id = $_SESSION['id'];
    $main_pic = "";
    $color = $_SESSION['color'];
    $arch = $_SESSION['arch'];
    $size = $_SESSION['size'];

    // echo $arch;
    // echo $size;
    // echo $color;

    //showing the side pics of the product
    function showSidePic($colori){
        $id = $GLOBALS['id'];
        $con = $GLOBALS['con'];
        $sql = "select * from imagep where id = '".$id."' and imageL = '".$colori."'";
        $res = mysqli_query($con, $sql);
        
        $num = 0;
        //echo '<script> alert("Hello");</script>';
        while($r = mysqli_fetch_row($res)){
            echo '<div class = "p1';
            if ($num == 0){
                $GLOBALS['main_pic'] = 'images/'.$id.'-'.$colori.'-'.$num.'.webp';
                echo ' active-pic';
            }
            echo '" onmouseover = " displayPic(\''.$r[2].'\')">
            <img id = "'.$r[2].'" src = "images/'.$id.'-'.$colori.'-'.$num.'.webp"> </div>';
            // echo '<script> alert("'.$r[2].'");</script>';
            $num++;
        }
    }

    //show the description part
    function showDesc(){
        $id = $GLOBALS['id'];
        $con = $GLOBALS['con'];
        $sql = "select * from products1 where id = '".$id."'";
        $res = mysqli_query($con, $sql);

        //$tempenv = $GLOBALS['env'];

        $r = mysqli_fetch_row($res);

        echo '<div class = "descriptionPart">
                <div class = "md">
                  <div class = "m-brand">'.$r[2].'</div>
                  <div class = "m-name">'.$r[1].'</div>
                  <div class = "m-price">
                    <span class = "m-oldp">₹ ';
        $_SESSION['mainName'] = $r[1];
        if ($r[11] != "0"){
            $newp = ((100 - $r[11])*$r[5]/100);
            echo $newp.'</span>
            <span class = "m-newp">₹ '.$r[5].'</span>
            <span class = "m-discount">'.$r[11].'% off</span>';
        }else{
            echo $r[5].'</span>';
        }

        $sql2 = 'select avg(rate), count(rate) from rate1 where id = '.$r[0];
        $r2 = mysqli_fetch_row(mysqli_query($con, $sql2));
                 
            echo '</div>
                    <div class = "m-rating">
                        <p class = "m-rate"><i class="bi bi-star-fill"></i> '.round($r2[0], 1).'</p>
                        <p class = "m-rev">'.$r2[1].' people reviewed</p>
                    </div>
                    
                    <div class = "m-color">
                        <p class = "ct">Color: </p>';

        
        $sql2 = "select color from color1 where id = '".$id."'";
        $res2 = mysqli_query($con, $sql2);

        $num = 1;
        while($r1 = mysqli_fetch_row($res2)){
            echo '<p class = "c1';
            if ($GLOBALS['color'] == $r1[0]){
                echo ' active-color';
            }
            echo '" onclick = "skillStuff(\'color\')">'.$r1[0].'</p>';

        }
              echo '</div>';
        
              echo '<div class = "m-size">
                        <p class = "st">Size: </p>';

        $sql2 = "select * from size1 where id = '".$id."'";
        $res2 = mysqli_query($con, $sql2);

        $num = 1;
        while($r1 = mysqli_fetch_row($res2)){
           // active-size" onclick = "skillStuff('size')">
            echo '<p class = "s1';
            if ($GLOBALS['size'] == $r1[1]){
                echo ' active-size';
            }
            echo '" onclick = "skillStuff(\'size\')">'.$r1[1].'</p>';
        }
                   
              echo '</div>';

              echo '<div class = "m-arch">
                        <p class = "at">Arch Type: </p>';

        $sql2 = "select * from arch1 where id = '".$id."'";
        $res2 = mysqli_query($con, $sql2);

        $num = 1;
        while($r1 = mysqli_fetch_row($res2)){
            echo '<p class = "a1';
            if ($GLOBALS['arch'] == $r1[1]){
                echo ' active-arch';
            }
            
            echo '" onclick = "skillStuff(\'arch\')">'.$r1[1].'</p>';
        }

              echo '</div>';

              echo '<div class = "aboutProduct">
                        <div class="tab">
                            <div class="sub-tab active-link" onclick = "openTab(\'details\')">Details</div>
                            <div class="sub-tab" onclick = "openTab(\'care\')">Care Guide</div>
                            <div class="sub-tab" onclick = "openTab(\'ret\')">Return Policy</div>
                        </div>
                        <div class = "tab-content active-tab" id = "details">'.$r[9].'
                        </div>
                        <div class = "tab-content" id = "care">'.$r[10].'
                        </div>
                        <div class = "tab-content" id = "ret">
                            <div class = "returnpl">Return Policy: '.$r[12].' days</div>
                            <div class = "returnpl">Manufacturing store: '.$r[14].'</div>
                            <div class = "returnpl">Shipping costs: ₹'.$r[15].'</div>
                        </div>
                    </div>
                </div>
            </div>';
        

    }

    //showing the rating part
    function showRate(){
        $id = $GLOBALS['id'];
        $con = $GLOBALS['con'];
        $sql = "select * from rate1 where id = '".$id."'";
        $res = mysqli_query($con, $sql);
        echo '<div class = "header">
                <p class = "h-heaad"> Rating and Reviews </p>
                <p class = "h-rate"><p class = "p-rev"><i class = "fas fa-star"></i></p></p>
                <button class = "h-btn" onclick = "funfun()">Rate Product</button>
            </div>';
        if (!mysqli_num_rows($res)){
            echo '<h3 class = "noreview">No Reviews!! Be the first one by rating the product!<h3>';
            echo '<hr id = "nice">';
            return;
        }
        while($r = mysqli_fetch_row($res)){

            echo '<div class = "person">
            <div class = "p-person"><i class="bi bi-person-circle"></i>'.$r[2].'</div>
            <div class = "p-rate">
                <div class = "star"><i class = "fas fa-star"></i> '.$r[1].'</div>
                <div class = "content">'.$r[3].'</div>
            </div>
            <div class = "p-date">
                Reviewed on <span class = "date">'.$r[4].'</span>
            </div>
                <div class = "p-review">'.$r[5].'</div>
            </div>
            <hr id = "nice">';
        }

    }


?>
<html>
    <head>
        <title>Something</title>
        <?php //echo "My name, my life"; ?>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous"> -->
        <!-- <link rel = "stylesheet" href = "stylekolete.css?v=<?php echo time(); ?>">
         -->
        <link rel = "stylesheet" href = "test4.css?v=<?php echo time(); ?>">
        <script src="https://kit.fontawesome.com/0318227299.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    
  <!-- <link rel="stylesheet" href="style.css"> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script> -->
  
    </head>
  <body>
    <?php include("nav3.php"); ?>
    <div class = "main">
      <div class = "show">
        <!-- Function to display side pics -->
        <div class = "pic">
          <!-- <div class = "p1 active-pic" onmouseover = "displayPic('hello1')">
            <img id = "hello1" src = "https://rukminim1.flixcart.com/image/832/832/l4yi7bk0/shoe/8/i/h/-original-imagfqgbezysjcfz.jpeg?q=70">
              
            </div>
          <div class = "p1" onmouseover = "displayPic('hello2')">
            <img id = "hello2" src = "https://rukminim1.flixcart.com/image/832/832/xif0q/shoe/g/s/u/-original-imaggcb3d6f4cxvu.jpeg?q=70">
              
            </div>
          <div class = "p1" onmouseover = "displayPic('hello3')">
            <img id = "hello3" src = "https://rukminim1.flixcart.com/image/832/832/l4yi7bk0/shoe/s/c/x/-original-imagfqgbktfgxdmx.jpeg?q=70">
              
            </div> -->
            <?php showSidePic($color) ?>
        
          
        </div>
        <div class = "main-pic">
            
          <div class = "mp1"><img id = "maing" src = "<?php echo $main_pic ?> "></div>
          <form class = "add-cart" method = "post">
            <input type = "submit" name = "gotocart" class = "cartbtn" onclick = "goToCart()" value = "ADD TO CART">
          </form>
        </div>
        
        <!-- <div class = "desc">
          <div class = "md">
            <div class = "m-brand">Brand</div>
            <div class = "m-name">Name of shoe</div>
            <div class = "m-price">
              <span class = "m-oldp linego">Hey</span>
              <span class = "m-newp">New Price</span>
              <span class = "m-discount">Discount</span>               
            </div>
            <div class = "m-rating">
                <p class = "m-rate"><i class="bi bi-star-fill"></i> 4.3</p>
                <p class = "m-rev">4 review</p>
            </div>
            <div class = "m-color">
              <p class = "ct">Color: </p>
              <p class = "c1 active-color" onclick = "skillStuff('color')">red</p>
              <p class = "c1" onclick = "skillStuff('color')">black</p>
            </div>
            <div class = "m-size">
              <p class = "st">Size: </p>
              <p class = "s1 active-size" onclick = "skillStuff('size')">1</p>
              <p class = "s1" onclick = "skillStuff('size')">2</p>
            </div>
            <div class = "m-arch">
              <p class = "at">Arch-Type: </p>
              <p class = "a1 active-arch" onclick = "skillStuff('arch')">Low</p>
              <p class = "a1" onclick = "skillStuff('arch')">Medium</p>
            </div>
            <div class = "about-col-2">
                    <div class="tab">
                        <div class="sub-tab active-link" onclick = "openTab('skills')">Skills</div>
                        <div class="sub-tab" onclick = "openTab('cert')">Certifications</div>
                        <div class="sub-tab" onclick = "openTab('aca')">Academic</div>
                        <div class="sub-tab" onclick = "openTab('exp')">Experience</div>
                    </div>
                    <div class = "tab-content active-tab" id = "skills">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum esse labore beatae nihil dolorem dolor in id, ab, perspiciatis culpa exercitationem unde quod quaerat cumque? Nostrum earum quibusdam ad cum accusantium. Fugit maxime suscipit perferendis ab sequi inventore aut dicta natus eos voluptas? Vero recusandae earum fuga tempore cum iusto aliquam magnam itaque, repellendus voluptatum, aspernatur, modi a neque. Iusto nobis repellat ullam adipisci repudiandae, maiores debitis assumenda dolorem quis, at, necessitatibus maxime cupiditate facere nesciunt tempora illum animi voluptatibus.
                    </div>
                    <div class = "tab-content" id = "cert">
                        ipsum Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum esse labore beatae nihil dolorem dolor in id, ab, perspiciatis culpa exercitationem unde quod quaerat cumque? Nostrum earum quibusdam ad cum accusantium. Fugit maxime suscipit perferendis ab sequi inventore aut dicta natus eos voluptas? Vero recusandae earum fuga tempore cum iusto aliquam magnam itaque, repellendus voluptatum, aspernatur, modi a neque. Iusto nobis repellat ullam adipisci repudiandae, maiores debitis assumenda dolorem quis, at, necessitatibus maxime cupiditate facere nesciunt tempora illum animi voluptatibus.
                    </div>
            </div>
          </div>
        </div> -->
        <?php showDesc() ?>
      
    </div>
    <!-- Rating part -->
      <div class = "rate">
        <!-- <div class = "header">
          <p class = "h-heaad"> Rating and Reviews </p>
          <p class = "h-rate"><p class = "p-rev"><i class = "fas fa-star"></i></p></p>
          <button class = "h-btn">Rate Product</button>
        </div> -->
        <!-- <div class = "person">
          <div class = "p-person">Icon Person</div>
          <div class = "p-rate">
            <div class = "star">4.2</div>
            <div class = "content">Content</div>
          </div>
          <div class = "p-date">
            Reviewed on <span class = "date">Date<span>
          </div>
            <div class = "p-review">
              User Review
            </div>
        </div>
        <hr id = "nice"> -->
        <?php showRate() ?>
        <!-- <div class = "person">
          <div class = "p-person">Icon Person</div>
          <div class = "p-rate">
            <div class = "star">4.2</div>
            <div class = "content">Content</div>
          </div>
          <div class = "p-date">
            Reviewed on <span class = "date">Date</span>
          </div>
            <div class = "p-review">
              User Review
            </div>
        </div>-->
        
      </div>
      <?php include("foot3.php"); ?>
      
      
  </div>
 
  <script>
        var subTab = document.getElementsByClassName("sub-tab");
        var tabContent = document.getElementsByClassName("tab-content");
        
        
        //alert("hello 123");

        function openTab(tabName){
            //To open different tabs in the "about" section
            // alert("Hello");
            for (tab1 of subTab){
                tab1.classList.remove("active-link");
            }
            for (tabc of tabContent){
                tabc.classList.remove("active-tab");
            }
            event.currentTarget.classList.add("active-link");
            document.getElementById(tabName).classList.add("active-tab");
        }

        var pic1 = document.getElementsByClassName("p1");
        function displayPic(tabname){
            for (tab1 of pic1){
                tab1.classList.remove("active-pic");
            }
            // divElement = document.getElementById("hello2");
      
            // elemHeight = divElement.offsetHeight;
            // alert(elemHeight);
            event.currentTarget.classList.add("active-pic");
            var temp = document.getElementById(tabname).src;
            document.getElementById("maing").src = temp;
        }

        var size1 = document.getElementsByClassName("s1");
        var arch1 = document.getElementsByClassName("a1");
        var color1 = document.getElementsByClassName("c1");
        

        var archf = "<?php echo $arch; ?>";
        //alert(archf);

        var sizef = "<?php echo $size; ?>";
        //alert(sizef);

        var colorf = "<?php echo $color; ?>";
        //alert(colorf);

        var env = {
            color: colorf,
            size: sizef,
            arch: archf
        };
        //alert(env['size']);
       
        function skillStuff(catg){
            var temp;
            if (catg == "size") {
                temp = "active-size";
                temp1 = size1;
            }
            else if (catg == "arch") {
                temp = "active-arch";
                temp1 = arch1;
            }else{
                temp = "active-color";
                temp1 = color1;
            }
            for (tab1 of temp1){
                tab1.classList.remove(temp);
            }
            event.currentTarget.classList.add(temp);
            
            if (catg == "size"){
                sizef = event.currentTarget.innerHTML;
                env['size'] = sizef;
                //alert(env['size']);

                window.location = "test10.php?env="+JSON.stringify(env);

                // document.cookie = "size ="+sizef;
                //alert(sizef);
            } 
            else if (catg == "arch"){
                archf = event.currentTarget.innerHTML;
                env['arch'] = archf;
                //alert(env['arch']);

                window.location = "test10.php?env="+JSON.stringify(env);
                // document.cookie = "arch ="+archf;
                //alert(archf);
            } 
            else{
                env['color'] = event.currentTarget.innerHTML;
                colorf = event.currentTarget.innerHTML;
                //alert(env['color']);
                //document.cookie = "color ="+colorf;

                window.location = "test10.php?env="+JSON.stringify(env);

                // window.open("test6.php", "_self");
                //alert(colorf);
            }
        }
        function funfun(){
            window.open("test12.php", "_self");
        }
  </script>
  </body>
</html>