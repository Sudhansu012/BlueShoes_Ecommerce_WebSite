<?php
    session_start();

    //for rate error message
    $_SESSION['RateMessage'] = "";
    $_SESSION['errorCheck'] = 0;
    if ($_SESSION['rateError'] == 1){
        $_SESSION['RateMessage'] = $_GET['Rate_message'];
        $_SESSION['errorCheck'] = 1;
    }
    $_SESSION['rateError'] = 0;
    
    //if user wants to update rate
    if (!isset($_SESSION['oldrater'])){
        $_SESSION['oldrater'] = 0;
    }

    //if user has not logged in
    if ($_SESSION['user_id'] == ""){
        header('Location: login_page_1.php');
    }

    //database connection
    $con = mysqli_connect('localhost', 'Gaurav1', 'test123', 'blueshoes1');
    if (!$con){
        echo 'Connection Error: '.mysqli_connect_error();
    }

    //heading of the rate form - new rate account or updating rate
    function HeadingPls(){
        $con = $GLOBALS['con'];
        $_SESSION['oldrater'] = 0;
        echo '<div class = "title">
            RATE-PRODUCT ';
        //if user already given rating
        $sql1 = "select * from rate1 where user_id = ".$_SESSION['user_id']." and id = ".$_SESSION['id'];
        if (mysqli_num_rows(mysqli_query($con, $sql1))){
            echo '(Updating user rate)';
            $_SESSION['oldrater'] = 1;
        }
        echo '</div>';
    }

    //if submit rating button is pressed
    if (isset($_POST['submitRate'])){
        $rate = $_POST['rate'];
        $rate = floatval($rate);

        //if rating is not between 0 or five or is empty
        if (!is_numeric($rate) or $rate < 0 or $rate > 5 or empty($rate)){
            $_SESSION['rateError'] = 1;
            header('Location: test12.php?Rate_message=Rate should be of proper value');
            
            //echo "<script>alert('Rate should be of proper value');</script>";
        }else{
            $det1 = $_POST['title'];
            //if title is empty or not less than 20 words
            if (strlen($det1) > 20 or empty($det1)){

                $_SESSION['rateError'] = 1;
                header('Location: test12.php?Rate_message=Title should be less than 20 words and not empty!!');
                //echo "<script>alert('Title should be less than 20 words and not empty!!');</script>";
            }else{
                $det2 = $_POST['detail'];
                //if details is empty
                if (empty($det2)){
                    $_SESSION['rateError'] = 1;
                    header('Location: test12.php?Rate_message=Details should not be empty!!');
                
                    //echo "<script>alert('Details should not be empty!!');</script>";
                } else{

                    if ($_SESSION['oldrater'] == 1){
                        $sql1 = "delete from rate1 where user_id=".$_SESSION['user_id'];
                        $res = mysqli_query($con, $sql1);

                    }
                    $sql1 = "select first_name, last_name from login where id=".$_SESSION['user_id'];
                    $rname = mysqli_fetch_row(mysqli_query($con, $sql1));
                    $sql = "insert into rate1(id, rate, user, sidetext, review, user_id) values(
                        ".$_SESSION['id'].", ".round($rate, 1).", '"
                        .$rname[0]." ".$rname[1]."', '".$det1."', '"
                        .$det2."', ".$_SESSION['user_id'].")";

                    echo $sql;    
                    $res = mysqli_query($con, $sql);
                    header("Location: test7.php?message_me=User review recorded <i class='bi bi-bookmark-check-fill'></i>");
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="alert/dist/sweetalert.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "test12.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('nav3.php');?>
  <div class = "wrapper" style = "margin-top: 100px;">
    <!-- <div class = "title">
      RATE-PRODUCT
    </div> -->
    <?php HeadingPls(); ?>
    <form method = "post" class = "addProduct">
<!--     <div class = "inputfield"> -->
      <label for = "">Rate (out of 5)</label>
      <input type = "text" name = "rate" class = "input">
<!--     </div> -->
<!--     <div class = "inputfield"> -->
      <label for = "">Rating title (in 20 words)</label>
      <textarea class="input11" name = "title"></textarea>
<!--     </div> -->
<!--     <div class="inputfield"> -->
        
<!--     <div class="inputfield"> -->
        <label>Rating Details</label>
        <textarea class="textarea" name = "detail"></textarea>
        <input type = "submit" name = "submitRate" class = "submitRate">
  </form>
  </div>
  <?php include('foot3.php');?>
  <script>

    //check if any error in entering rate - if yes - alert
    var hello = <?php echo $_SESSION['errorCheck'];?>;
    if (hello){
        Swal.fire(
            '<?php echo $_SESSION['RateMessage']?>','',
            'error'
            );

    }
    </script>
  
</body>
</html>