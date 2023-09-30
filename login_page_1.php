<?php
//REGISTER..................................
error_reporting(E_ERROR | E_PARSE);
session_start();
  $_SESSION['coupon'] = "";
  $_SESSION['couponDiscount'] = 0;
$_SESSION['user_id'] = "";
$_SESSION['sql'] = "select * from products1";
$_SESSION['id'] = "";
$_SESSION['coupon'] = "";
 include("connect.php");
if(isset($_POST['register'])){
    
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirmpassword=$_POST['confirmpassword'];
    $sql="SELECT * FROM login WHERE email='{$email}'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
      echo "<div class='alert alert-danger'>Email already exist</div>";

    }
    else{
        if($password===$confirmpassword){
          $pass=md5($password);
        $sql1="INSERT INTO login(first_name,last_name,email,password) VALUES ('$firstname','$lastname','$email','$pass')";
        if(mysqli_query($conn,$sql1)){
          echo "<div class='alert alert-danger'>Hello $firstname you have registered succesfully</div>";
        }
        else{
          echo "Error";
        }
      }
      else{
        echo "<div class='alert alert-danger'>password are not matching</div>";


      }
    }
     
}
?>


<?php
//LOGIN........................................
 include("connect.php");
if(isset($_POST['sinup'])){
  $email=$_POST['email'];
    $password=$_POST['password'];
    $incpass=md5($password);
    $sql="SELECT * FROM login WHERE email='{$email}'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
       $row=mysqli_fetch_assoc($result);
       $pass=$row['password'];
       if($pass===$incpass){
          session_start();
          $_SESSION['user_id']=$row['id'];

          header("Location: main_page_1.php");
      }
      else{
        echo "<div class='alert alert-danger'>invalid password</div>";
      }
    }
    else{
      echo "<div class='alert alert-danger'>Invalid email</div>";
    }
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



</head>

<body>
  <section id="title">
    <div class="container-fluid_A">

      <div class="container-fluid_A">

        
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
                          <li class="dropdown-items"><a id="dropdown-tags" href="#">Everyday Sneakers</a></li>
                          <li class="dropdown-items"><a id="dropdown-tags" href="#">Running Shoes</a></li>
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
                  <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" href="#">Women</a>
                  <div class="dropdown-menu">
                    <div class="row">
                      <div class="shoes col-lg-4">
                        <h3>Shoes</h3>
                        <ul class="dropdown-content">
                          <li class="dropdown-items"><a id="dropdown-tags" href="#">Everyday Sneakers</a></li>
                          <li class="dropdown-items"><a id="dropdown-tags" href="#">Running Shoes</a></li>
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
              <a class="navbar-brand navbar-brand-centered" href="main_page_1.php">BlueShoes</a>
              <div class="search">
                <form class="d-flex" role="search">
                  <input class="form-control me-2 search-bar" type="search" placeholder="Search" aria-label="Search">
                  <a class="nav-link search-bar-icon" href="#"><i class="fa fa-search"></i></a>

                </form>
              </div>


              <ul class="navbar-nav  ">
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa-solid fa-user"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>

    </div>
  </section>

  <div class="row login-row" style = "margin-top: 100px;">
    <div class="login col col-lg-6 col-md-12 col-sm-12">
      <h2>LOGIN</h2><br>
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
      <p>EMAIL</p>
      <input type="email" name="email" id="email" autocomplete="off" required><br><br>
      <p>PASSWORD</p>
      <input type="password" name="password" autocomplete="off" required><br><br>
      <div class="d-grid gap-2">
          <button type="submit" name="sinup" class="btn btn-dark btn-lg" style="width:70%;">LOGIN</button>
      </div>
      <br>
      <center><a href="#"> FORGOT PASSWORD</a></center>
      </form>
    </div>

    <div class="newlogin col col-lg-6 col-md-12 col-sm-12">
      <h2>CREATE NEW ACCOUNT</h2><br>
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <p>FIRST NAME</p>
        <input type="text" name="firstname" required> <br><br>
        <p>LAST NAME</p>
        <input type="text" name="lastname" required> <br><br>
        <p>EMAIL</p>
        <input type="email" name="email" id="email" required><br><br>
        <p>PASSWORD</p>
        <input type="password" name="password"   required><br><br>
        <p>CONFIRM PASSWORD</p>
        <input type="password" name="confirmpassword"   required><br><br>
        <div class="d-grid gap-2">
          <!-- <input type="submit" name="register" value="register"> -->
            <button type="submit" name="register" class="btn btn-dark btn-lg" value="register" style="width:70%;">REGISTER</button>
        </div>

      </form>
    </div>
  </div>
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
          <li class="dropdown-items"><a id="footer-tags" href="#">Men's Footwear</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Women's Footwear</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Kids</a></li>
          <li class="dropdown-items"><a id="footer-tags" href="#">Accessories</a></li>
        </ul>

      </div>

    </div>

  </div>

</body>

</html>
