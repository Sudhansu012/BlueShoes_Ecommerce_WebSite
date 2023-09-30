<html lang="en">
<head>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="alert/dist/sweetalert.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "nav3.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">  
</head>
<body>
    <header>
        <a href="main_page_1.php" class="logo">BlueShoe</a>
        <div class="group">
            <ul class="navigation">
                <li><a href="test11.php?catgio=1">Men</a></li>
                <li><a href="test11.php?catgio=2">Women</a></li>
                <li><a href="test11.php?catgio=3">Kids</a></li>
                <li><a href="login_page_1.php" style = "font-size: 20px;"><i class="bi bi-person-circle"></i></a></li>
                <li><a href="test5.php" style = "font-size: 20px;"><i class="bi bi-cart-fill"></i></a></li>
            </ul>
            <div class="search">
                <span class="icon">
                    <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                    <ion-icon name="close-outline" class="closeBtn"></ion-icon>
                </span>
            </div>
            <ion-icon name="menu-outline" class="menuToggle"></ion-icon>

        </div>
        <div class="searchBox">
            <input type="text" id = "well_search" placeholder="Search here...">
        </div>    
    </header>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        current_state = 0;
        let searchBtn = document.querySelector('.searchBtn');
        let closeBtn = document.querySelector('.closeBtn');
        let searchBox = document.querySelector('.searchBox');
        let navigation = document.querySelector('.navigation');
        let menuToggle = document.querySelector('.menuToggle');
        let header = document.querySelector('header');
        searchBtn.onclick = function(){
            if (current_state == 0){
                searchBox.classList.add('active');
                closeBtn.classList.add('active');
                searchBtn.classList.add('active');
                menuToggle.classList.add('hide');
                header.classList.remove('open');
                current_state = 1;
            }
            else{
                var temp = document.getElementById('well_search').value;
                var env = {sql:""};
                if (temp == ""){
                    Swal.fire(
                    'Search should not be empty','',
                    'error'
                    );
                }
                else{
                    sqli = "select * from products1 where name like '%"+temp+"%' or (brand like '%"+temp+"%') or (catg like '%"+temp+"%') or (type like '%"+temp+"%') or (manufacture like '%"+temp+"%')";
                    //alert(sqli);
                    env['sql'] = sqli;
                //alert(env['size']);

                    window.location = "test11.php?env="+JSON.stringify(env);
                    current_state = 0;

                }
            }
        }

        closeBtn.onclick = function(){
            searchBox.classList.remove('active');
            closeBtn.classList.remove('active');
            searchBtn.classList.remove('active');
            menuToggle.classList.remove('hide');
            current_state = 0;
        }
        menuToggle.onclick = function(){
        header.classList.toggle('open');
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');}
    </script> 
</body>
</html>