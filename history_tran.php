<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Asset/css/swiper-bundle.min.css">

    <!-- css -->
    <link rel="stylesheet" href="Asset/css/style.css">
    <!-- incon -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- ไอคอนบนแท็บ -->
    <link rel="shortcut icon" href="Asset/img/Baiplus_final-removebg-preview.png">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Baiplus History</title>


    
</head>
<!--==================== MAIN JS ====================-->
    <script src="Asset/js/main.js"></script>
    <script src="Asset/js/darkmode.js"></script>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="nav-bar home__containter header">
            <!-- Logo -->
            <a href="account__main.html" class="logo">
                <img src="Asset/img/Baiplus_final-removebg-preview.png" class="nav__icon" alt="BaiPlus" />
                BaiPlus
            </a>
            <!-- Menu Icon -->
            <input type="checkbox" name="" id="menu">
            <label for="menu">
                <i class='bx bx-menu' id="menu-icon"></i>
            </label>
            <!-- Navlist -->
            <ul class="navbar">
                <li><a href="account__main.html">Home</a></li>
                <li class="home__dropdown-link">
                    <div href="">ACCOUNTS&nbsp;&nbsp;<i class='bx bxs-chevron-down'></i></div>
                    <ul class="home__dropdown">
                        <li><a href="account__main.html">Profile Accounts</a></li>
                        <li><a href="account__other.html">Another Accounts</a></li>   
                    </ul>
                </li>
                <li class="home__dropdown-link">
                    <div href="">TRANSACTION&nbsp;&nbsp;<i class='bx bxs-chevron-down'></i></div>
                    <ul class="home__dropdown">
                        <li><a href="tranfer_selectBank.html">Transfer</a></li>
                        <li><a href="paybill.html">Pay Bill</a></li>
                        <li><a href="withdraw.html">Withdraw</a></li> 
                        <li><a href="loan.html">Loan</a></li>    
                    </ul>
                </li>
                <li><a href="history_tran.php">HISTORY</a></li>
                <li><a href="card-font.html">CREDIT CARD</a></li>
                <li class="nav__btns">           
                    <i class="uil uil-moon change-theme" id="theme-button"></i>
                </li>
                <li class="home__dropdown-link">
                    <div class="nav__acc-bg">
                        <div class="nav__img"><img src="Asset/img/avatar.svg"></div>
                    </div>
                    <ul class="home__dropdown">
                        <li><a href="account__edit.html">Setting</a></li>
                        <li><a href="index.html">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
<!-- Main -->
<main class="main">
    <section class="his__section section" id="select">
        <h2 class="section__title">History</h2>
        <span class="section__subtitle">Lorem ipsum dolor sit amet.</span>
        <div class="his__bg">
            <div class="grid his__container">
                <div class="his__box" value="">
                    <div class="info his__box-data">Transferor</div>
                    <div class="info his__box-data">Recipient</div>
                    <div class="info his__box-data">Type</div>
                    <div class="info his__box-data">Amount</div>
                    <div class="info his__box-data">Date & Time</div>
                </div>

                <?php
                session_start();

                // Check if the user is logged in
                if (!isset($_SESSION['customer_ID'])) {
                    // Redirect to login page or handle unauthorized access
                    header("Location: login.php");
                    exit;
                }

                // Retrieve the logged-in user's ID
                $loggedInUserID = $_SESSION['customer_ID'];

                // Connect to the database
                $connection = mysqli_connect("localhost", "root", "", "baiplus_database");
                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Retrieve transaction history based on the logged-in user's ID
                $sql = "SELECT t.*, 
                            CONCAT(c1.customer_fname, ' ', c1.customer_lname) AS transferor_name, 
                            CONCAT(c2.customer_fname, ' ', c2.customer_lname) AS receiver_name
                        FROM transaction AS t
                        INNER JOIN account AS a1 ON t.account_transferor = a1.account_id
                        INNER JOIN customer AS c1 ON a1.customer_id = c1.customer_id
                        LEFT JOIN account AS a2 ON t.account_receiver = a2.account_id
                        LEFT JOIN customer AS c2 ON a2.customer_id = c2.customer_id
                        WHERE a1.customer_id = '$loggedInUserID' OR a2.customer_id = '$loggedInUserID'
                        ORDER BY t.transaction_date DESC";

                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($transaction = mysqli_fetch_assoc($result)) {
                        $transferor = $transaction['transferor_name'];
                        $receiver = $transaction['receiver_name'];
                        $type = $transaction['trans_type'];
                        $amount = $transaction['transaction_amount'];
                        $dateTime = $transaction['transaction_date'];
                        ?>

                        <div class="his__box">
                            <div class="info his__box-data"><?php echo $transferor; ?></div>
                            <div class="info his__box-data"><?php echo $receiver ? $receiver : 'no receiver'; ?></div>
                            <div class="info his__box-data"><?php echo $type; ?></div>
                            <div class="info his__box-data"><?php echo $amount; ?></div>
                            <div class="info his__box-data"><?php echo $dateTime; ?></div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p>No transaction history found.</p>";
                }

                // Close the database connection
                mysqli_close($connection);
                ?>

            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="footer"></footer>

<!-- Swiper JS -->
<script src=""></script>
</body>
</html>