<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Baiplus</title>
    <link rel="stylesheet" href="Asset/css/style-beer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <!--Nav BAR-->
    <header>
        <div class="nav container">
            <!--LOGO-->
            <a href="index.html" class="logo"><i class='bx bx-home'></i>BaiPlus</a>
            <!--Menu Icon-->
            <input type="checkbox" name="" id="menu">
            <label for="menu"><i class='bx bx-menu' id="menu-icon"></i></label>
            <!--Navlist-->
            <ul class="navbar">
                <li><a href="#home">Home</a></li>
                <li class="dropdown-link">
                    <a href="">Accounts<i class='bx bxs-chevron-down'></i></a>
                    <ul class="dropdown">
                        <li><a href="account.html">Profile Accounts</a></li>
                        <li><a href="accountdetail.php">Another Accounts</a></li>   
                    </ul>
                </li>
                <li><a href="card_holder.php">Sales</a></li>
                <li><a href="#properties">Properties</a></li>
            </ul>
            <!--LOGIN BUTTON-->
            <a href="createcard.php" class="btn">Log In</a>
        </div>
    </header>
    <!--Properties-->
    <section class="properties container">
        <div class="heading">
            <h1>Account</h1>
        </div>
        <div class="properties-container container">
            <?php
            // Check if the customer ID is stored in the session
            session_start();
            if (isset($_SESSION['customer_ID'])) {
                $customer_ID = $_SESSION['customer_ID'];

                // Connect to the database
                $con = mysqli_connect("localhost", "root", "", "baiplus_database");
                if (!$con) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Retrieve account data for the logged-in customer
                $sql = "SELECT * FROM account WHERE customer_ID = '$customer_ID'";
                $result = mysqli_query($con, $sql);

                // Display account data
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $account_name = $row['account_name'];
                        $account_balance = $row['account_balance'];
                        $bank_id= $row['bank_id'];

                        echo "<div class='box'>";
                        echo "<img src='Asset/images/image-restaurant.jpg' alt=''>";
                        echo "<h3>$" . number_format($account_balance, 2) . "</h3>";
                        echo "<div class='content'>";
                        echo "<div class='text'>";
                        echo "<h3>$account_name</h3>";
                        echo "<p><i class='bx bxs-bank'></i> $bank_id</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No accounts found.</p>";
                }

                // Close the database connection
                mysqli_close($con);
            } else {
                echo "<p>Customer ID not found.</p>";
            }
            ?>
        </div>
    </section>
</body>
</html>
