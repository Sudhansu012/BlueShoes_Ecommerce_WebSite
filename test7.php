<?php
    session_start();

    //confirmation message
    $message = $_GET['message_me'];
    if (isset($message)){
        $_SESSION['messageFinal'] = $message;
        header('Location: test7.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "test13.css?v=<?php echo time(); ?>">
       
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
    <?php include('nav3.php'); ?>
    <div class = "mainDD" style = "margin-top: 100px; margin-bottom: 370px;">
        <div class = "hayo">
            <div class = "title"><?php echo $_SESSION['messageFinal']?></div>
            <div class = "button">
                <a href = "test11.php"><button class = "browse" onmouseenter = "showCartBut(1, 'Browse more Products ?', 'browse2')" onmouseleave = "showCartBut(2, 'Browse more Products ?', 'browse2')">
                    <i class="bi bi-arrow-left"></i>&nbsp;
                    <i class="bi bi-bag-fill"></i>&nbsp;&nbsp;&nbsp;
                    <span id = "browse2">Browse products ?</span></button></a>
                <a href = "test5.php"><button class = "cart" onmouseenter = "showCartBut(1, 'Add to cart', 'browse3')" onmouseleave = "showCartBut(2, 'Add to cart', 'browse3')">
                <span id = "browse3">Go to cart</span>&nbsp;&nbsp;&nbsp;<i class="bi bi-cart3"></i>
                <i class="bi bi-arrow-right"></i></button></a>
            </div>
        </div>
    </div>
    <?php include('foot3.php')?>
    <script>

        //give button animation of typing
        function showCartBut(dd, bb, cc){
            if (dd == 1){
                var a = document.getElementById(cc);;
                gone = 0;
                var temp2 = "";
                var i = 0;
                var poir = setInterval(function(){ 
                        var bro = bb;
                        if (i == bb.length-1 || gone == 1){
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
                var a = document.getElementById(cc);
                a.style.display = "none";
                gone = 1;
            }
        }
    </script>
    
</body>
</html>