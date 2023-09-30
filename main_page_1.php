<?php

  //database connection
 $con = mysqli_connect('localhost','root','','blueshoes1');
 if (!$con){
     echo 'Connection Error: '.mysqli_connect_error();
 }
 ?>


<?php
    error_reporting(E_ERROR | E_PARSE);
    //session start
    session_start();
    $_SESSION['i'] = 0;
    $_SESSION['id'] = 0;
    $_SESSION['sql'] = "select * from products1";
    if(!isset( $_SESSION['sql'] ) ) {
        $_SESSION['sql'] = 'select * from products1';
    }
    if(!isset( $_SESSION['id'] ) ) {
      $_SESSION['id'] = '1';
  }
  if(!isset( $_SESSION['user_id'] ) ) {
    $_SESSION['user_id'] = '1';
  }
?>
<?php
 //include("connect.php");
// Get the 8 most recently added products
$stmt = 'SELECT * FROM products1 ORDER BY date_added DESC LIMIT 7';
$fetch_latest_arrivals = mysqli_query($con,$stmt);
$recently_added_products=array();
while ($row = mysqli_fetch_assoc($fetch_latest_arrivals)){
  $recently_added_products[] = $row;
} 

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>BlueShoes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="style_1.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/0318227299.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <section id="title">
    <div class="container-fluid_A ">

      <!-- Nav Bar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarToggleExternalContent">
            <ul class="navbar-nav me-auto ">
              <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">Men</a>
                <div class="dropdown-menu">
                  <div class="row">
                    <div class="shoes col-lg-4">
                      <h3>Shoes</h3>
                      <ul class="dropdown-content">
                        <li class="dropdown-items"><a id="dropdown-tags" href="description_page.html">Everyday Sneakers</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="description_page.html">Running Shoes</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="description_page.html">Slip-Ons</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Hiking Shoes</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">High Tops</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Slippers</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Sandals</a></li>
                      </ul>
                    </div>
                    <div class="accessories col-lg-4">
                      <h3>Accessories</h3>
                      <ul class="dropdown-content">
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Activewear</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Tees & Tops</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Bottoms</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Socks</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Apparels</a></li>
                      </ul>
                    </div>
                    <div class="features col-lg-4">
                      <h3>Featured</h3>
                      <div class="mens-img">
                        <img id="image1" src="mens11.jpg" alt="mens-image">
                      </div>
                      <div class="mens-img">
                        <img src="mens11.jpg" alt="mens-image">
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">Women</a>
                <div class="dropdown-menu">
                  <div class="row">
                    <div class="shoes col-lg-4">
                      <h3>Shoes</h3>
                      <ul class="dropdown-content">
                        <li class="dropdown-items"><a id="dropdown-tags" href="description_page.html">Everyday Sneakers</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="description_page.html">Running Shoes</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Slip-Ons</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Hiking Shoes</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">High Tops</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Slippers</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Sandals</a></li>
                      </ul>
                    </div>
                    <div class="accessories col-lg-4">
                      <h3>Accessories</h3>
                      <ul class="dropdown-content">
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Activewear</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Tees & Tops</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Bottoms</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Socks</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Apparels</a></li>
                      </ul>

                    </div>
                    <div class="features col-lg-4">
                      <h3>Featured</h3>
                      <div class="mens-img">
                        <img id="image1" src="mens11.jpg" alt="mens-image">
                      </div>
                      <div class="mens-img">
                        <img src="mens11.jpg" alt="mens-image">
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">Kids</a>
                <div class="dropdown-menu">
                  <div class="row">
                    <div class="shoes col-lg-4">
                      <h3>Little Kids</h3>
                      <ul class="dropdown-content">
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Everyday Sneakers</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Slip-Ons</a></li>

                      </ul>
                    </div>
                    <div class="accessories col-lg-4">
                      <h3>Big Kids</h3>
                      <ul class="dropdown-content">
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Everyday Sneakers</a></li>
                        <li class="dropdown-items"><a id="dropdown-tags" href="#">Slip-Ons</a></li>
                      </ul>

                    </div>
                    <div class="features col-lg-4">
                      <h3>Featured</h3>
                      <div class="mens-img">
                        <img id="image1" src="mens11.jpg" alt="mens-image">
                      </div>
                      <div class="mens-img">
                        <img src="mens11.jpg" alt="mens-image">
                      </div>
                    </div>
                  </div>

                </div>
              </li>
            </ul>
            <a class="navbar-brand navbar-brand-centered" href="main_page.">BlueShoes</a>

            <!-- search module -->
            <div class="search">
              <form class="d-flex" role="search" action="search.php" method="GET">
                <input class="form-control me-2 search-bar" type="search" placeholder="Search" aria-label="Search" name="query">
                <!-- change something. like submit button -->
                <button class="icon" style="border-radius: 0 5px 5px 0; height:2em;"><i class="fa fa-search"></i></button>
              </form>
            </div>


            <ul class="navbar-nav  ">
              <li class="nav-item">
                <a class="nav-link" href="login_page_1.php"><i class="fa-solid fa-user"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <!-- Description -->

    <div class="container-fluid description-container">
      <div class="row">
        <div class="col-lg-6  description-container1">
          <img src="images/desc-main.webp" alt="" style="width:100%; border-radius:5px; height:100%;">

        </div>
        <div class="col-lg-6 description-container2">
          <div class="row" id="desc-row" style=" padding-top:0; padding-bottom:0;margin-left: 0px;padding-left: 0px;">
            <div class="col col-lg-12 col-md-12 col-sm-12">
              <img class="desc-img-2" src="images/desc1.webp" alt="" style="width:100%; border-radius:5px;">

            </div>
          </div>
          <div class="row" id="desc-row" style="padding-top:0; padding-bottom:0;margin-left: 0px;padding-left: 0px;" >
            <div class="col col-lg-12 col-md-12 col-sm-12">
              <img src="images/desc2.webp" alt="" style="width:100%; border-radius:5px;">

            </div>

          </div>


        </div>


      </div>


    </div>


  </section>

<!-- Trending -->

  <h2 class="trending-header">Trending</h2>
  <section class="product">

    <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
    <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
    <div class="product-container-banner">
      <div class="product-card">
        <div class="product-image-banner">

          <img src="images/banner1.jpg" class="product-thumb" alt="">
          <a href = "test11.php"><button class="card-btn">Explore</button><a href = "test11.php">
        </div>
        <div class="product-info">
          <h2 class="product-brand">Crocs</h2>
          <p class="product-short-description">Grab your favourite Sandals NOW!</p>

        </div>
      </div>
      <div class="product-card">
        <div class="product-image-banner">

          <img src="images/banner2.webp" class="product-thumb" alt="">
          <a href = "test11.php"><button class="card-btn">Explore</button></a>

        </div>
        <div class="product-info">
          <h2 class="product-brand">New Launch - Activ Collection</h2>
          <p class="product-short-description">Shop for Activ Shoes at best price</p>

        </div>
      </div>
      <div class="product-card">
        <div class="product-image-banner">

          <img src="images/banner3.webp" class="product-thumb" alt="">
          <a href = "test11.php"><button class="card-btn">Explore</button></a>
        </div>
        <div class="product-info">
          <h2 class="product-brand">Puma X Mercedes</h2>
          <p class="product-short-description">Buy exclusive puma x mercedes collection</p>

        </div>
      </div>
    </div>
  </section>

  <!-- New Arrivals -->
  <h2 class="trending-header">New Arrivals</h2>
  <section class="product">


    <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
    <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
    <div class="product-container">
    <?php foreach ($recently_added_products as $product): 
        $temp = explode("-", $product['color']);
        $temp = $temp[0];?>

      <div class="product-card">
        <div class="product-image">
          <span class="discount-tag"><?=$product['discount']?>% off</span>
          <img src="images/<?=$product['id']?>-<?=$temp?>-0.webp" class="product-thumb" alt="<?=$product['name']?>">
          <a href = "test10.php?productIDsend=<?=$product['id']?>"><button class="card-btn">Shop Now</button></a>
        </div>
        <div class="product-info">
          <h4 class="product-brand"><?=$product['name']?></h4>
          <span class="price">₹<?=$product['price']?></span>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </section>


  <!-- Footer -->
  <div class="footer" style="background-color:black; color:white;">
    <div class="row">
      <div class="about col-lg-3 col-md-6 col-sm-12">
        <h3 class="footer-heading">About</h3>
        <ul class="dropdown-content">
          <li class="dropdown-items "><a id="footer-tags" href="#">Contact Us</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">About Us</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Corporate Information</a></li>
        </ul>
      </div>
      <div class="help col-lg-3 col-md-6 col-sm-12">
        <h3 class="footer-heading">Help</h3>
        <ul class="dropdown-content">
          <li class="dropdown-items"><a id="footer-tags" href="#">Payments</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Shipping</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">FAQ</a></li>
        </ul>
      </div>
      <div class="policy col-lg-3 col-md-6 col-sm-12">
        <h3 class="footer-heading">Policy</h3>
        <ul class="dropdown-content">
          <li class="dropdown-items"><a id="footer-tags" href="#">Return Policy</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Terms of use</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Security</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Privacy</a></li>
        </ul>
      </div>
      <div class="shop col-lg-3 col-md-6 col-sm-12">
        <h3 class="footer-heading">Shop</h3>
        <ul class="dropdown-content">
          <li class="dropdown-items"><a id="footer-tags" href="description_page.html">Men's Footwear</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="description_page.html">Women's Footwear</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="description_page.html">Kids</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="description_page.html">Accessories</a></li>
        </ul>

      </div>

    </div>

  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer">
  </script>

  <script src="script.js" charset="utf-8"></script>

</body>

</html>
