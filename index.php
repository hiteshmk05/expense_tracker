<?php


    include('dbConfig.php');

    if (!isset($_SESSION['USER_ID'])) {
	    header("location:signin.php");
	    die();
    }


    $user = $_SESSION['USER_NAME'];
    $query = mysqli_query($conn,"select * from users where username = '$user'");
    $rowr =mysqli_fetch_array($query);
    $id = $rowr['id'];

    if (isset($_REQUEST['submit'])) 
    {
 	    $category =   $_REQUEST['category'];
 	    $total_expense = $_REQUEST['total_expense'];
 	    $issued_date = $_REQUEST['issued_date'];
 	    $status = $_REQUEST['status'];
        mysqli_query($conn,"insert into user_data(category,total_expense,issued_date,status,user_id)value('$category','$total_expense','$issued_date','$status','$id')");
    }


    $selectedOption = 'all';
    $selectedDate = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["myButton"])) {
        $selectedOption = 'all';
        $selectedDate = '';   
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["inputStatus"])) {
            $selectedOption = $_POST["inputStatus"];
        }
        if (isset($_POST["inputDate"])) {
            $selectedDate = $_POST["inputDate"];
        }
    }   

    $query = "SELECT * FROM user_data WHERE user_id = '$id' ORDER BY issued_date DESC";

    if (!empty($selectedDate)) {
        $query = "SELECT * FROM user_data WHERE user_id = '$id' AND issued_date = '$selectedDate' ORDER BY issued_date DESC";
    }

    if ($selectedOption == 'paid') {
        $query = "SELECT * FROM user_data WHERE user_id = '$id' AND status = 'paid' ORDER BY issued_date DESC";
        if (!empty($selectedDate)) {
            $query = "SELECT * FROM user_data WHERE user_id = '$id' AND issued_date = '$selectedDate' AND status='paid' ORDER BY issued_date DESC";
        }
    } elseif ($selectedOption == 'unpaid') {
        $query = "SELECT * FROM user_data WHERE user_id = '$id' AND status = 'unpaid' ORDER BY issued_date DESC";
        if (!empty($selectedDate)) {
            $query = "SELECT * FROM user_data WHERE user_id = '$id' AND issued_date = '$selectedDate' AND status='unpaid' ORDER BY issued_date DESC";
        }
    }

    $query1 = mysqli_query($conn, $query);

    $result = mysqli_num_rows($query1);


    $firstDayOfMonth = date('Y-m-01');
    $lastDayOfMonth = date('Y-m-t');

    $query2 = mysqli_query($conn, "SELECT 
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'food' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as total_food_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'food' AND status = 'paid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as paid_food_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'food' AND status = 'unpaid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as unpaid_food_expense");
    $result2 = mysqli_fetch_assoc($query2);
    $totalFoodExpense = $result2['total_food_expense'];
    $paidFoodExpense = $result2['paid_food_expense'];
    $unpaidFoodExpense = $result2['unpaid_food_expense'];
    $percentageFoodPaid = $totalFoodExpense != 0 ? ($paidFoodExpense / $totalFoodExpense) * 100 : 0;
    $percentageFoodUnpaid = $totalFoodExpense != 0 ? ($unpaidFoodExpense / $totalFoodExpense) * 100 : 0;


    $query3 = mysqli_query($conn, "SELECT 
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'grocery' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as total_grocery_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'grocery' AND status = 'paid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as paid_grocery_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'grocery' AND status = 'unpaid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as unpaid_grocery_expense");
    $result3 = mysqli_fetch_assoc($query3);
    $totalGroceryExpense = $result3['total_grocery_expense'];
    $paidGroceryExpense = $result3['paid_grocery_expense'];
    $unpaidGroceryExpense = $result3['unpaid_grocery_expense'];
    $percentageGroceryPaid = $totalGroceryExpense != 0 ? ($paidGroceryExpense / $totalGroceryExpense) * 100 : 0;
    $percentageGroceryUnpaid = $totalGroceryExpense != 0 ? ($unpaidGroceryExpense / $totalGroceryExpense) * 100 : 0;


    $query4 = mysqli_query($conn, "SELECT 
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'travels' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as total_travels_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'travels' AND status = 'paid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as paid_travels_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'travels' AND status = 'unpaid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as unpaid_travels_expense");
    $result4 = mysqli_fetch_assoc($query4);
    $totalTravelsExpense = $result4['total_travels_expense'];
    $paidTravelsExpense = $result4['paid_travels_expense'];
    $unpaidTravelsExpense = $result4['unpaid_travels_expense'];
    $percentageTravelsPaid = $totalTravelsExpense != 0 ? ($paidTravelsExpense / $totalTravelsExpense) * 100 : 0;
    $percentageTravelsUnpaid = $totalTravelsExpense != 0 ? ($unpaidTravelsExpense / $totalTravelsExpense) * 100 : 0;


    $query5 = mysqli_query($conn, "SELECT 
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'bills' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as total_bill_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'bills' AND status = 'paid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as paid_bill_expense,
        COALESCE((SELECT SUM(total_expense) FROM user_data WHERE user_id = '$id' AND category = 'bills' AND status = 'unpaid' AND issued_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'), 0) as unpaid_bill_expense");
    $result5 = mysqli_fetch_assoc($query5);
    $totalBillsExpense = $result5['total_bill_expense'];
    $paidBillsExpense = $result5['paid_bill_expense'];
    $unpaidBillsExpense = $result5['unpaid_bill_expense'];
    $percentageBillsPaid = $totalBillsExpense != 0 ? ($paidBillsExpense / $totalBillsExpense) * 100 : 0;
    $percentageBillsUnpaid = $totalBillsExpense != 0 ? ($unpaidBillsExpense / $totalBillsExpense) * 100 : 0;


?>





<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Expense Tracker Dashboard</title>
    <link rel="stylesheet" href="expenseDetailsForm.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>


    <div class="container">
        <div id="expenseForm" style="display: none;">
            <h2>Expense Details</h2>
            <form id="expenseEntryForm" action="#" method="POST">
        
                <label for="category">Category :</label>
                <select name="category" id="category" required>
                    <option value="Food">Food</option>
                    <option value="Travels">Travels</option>
                    <option value="Grocery">Grocery</option>
                    <option value="Bills">Bills</option>
                    <option value="Others">Others</option>
                </select><br><br>
        
                <label for="totalExpense">Total Expense:</label>
                <input type="number" id="total_expense" name="total_expense" required><br><br>
        
                <label for="issuedDate">Issued Date:</label>
                <input type="date" id="issued_date" name="issued_date" required><br><br>
        
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select><br><br>
        
                <input type="submit" name="submit" value="submit" id="submit">
                <input type="button" name="cancel" value="cancel" id="cancel">
            </form>
        </div>
    </div>


    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><span>Logo</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/1.jpeg)"></div>
                <h4>
                    <?php echo $_SESSION['USER_NAME'] ?>
                </h4>
                <small>User <?php  echo $id?></small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="#" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="las la-user-alt"></span>
                            <small>Profile</small>
                        </a>
                    </li>
                    <li>
                        <a href="contact.php">
                            <span class="las la-tasks"></span>
                            <small>Contact Us</small>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">

        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>

                <div class="header-menu">

                    <div class="notify-icon">
                        <span class="las la-envelope"></span>
                        <span class="notify">4</span>
                    </div>

                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>

                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>

                        <span class="las la-power-off"></span>
                        <span><a href="logout.php">Logout</a></span>
                    </div>
                </div>
            </div>
        </header>


        <main>

            <div class="page-header">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>

            <div class="page-content">

                <div class="analytics">

                    <div class="card">
                        <div class="card-head">
                            <h3>Rs <?php echo $totalGroceryExpense; ?></h3>
                            <span class="las la-shopping-cart"></span>
                        </div>
                        <div class="card-progress">
                            <small>Grocery Purchases</small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: <?php echo $percentageGroceryPaid; ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h3>Rs <?php echo $totalTravelsExpense; ?></h3>
                            <span class="las la-taxi"></span>
                        </div>
                        <div class="card-progress">
                            <small>Travel</small>
                            <div class="card-indicator">
                                <div class="indicator two" style="width: <?php echo $percentageTravelsPaid; ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h3>Rs <?php echo $totalFoodExpense; ?></h3>
                            <span class="las la-beer"></span>
                        </div>
                        <div class="card-progress">
                            <small>Food Purchases</small>
                            <div class="card-indicator">
                                <div class="indicator three" style="width: <?php echo $percentageFoodPaid; ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h3>Rs <?php echo $totalBillsExpense; ?></h3>
                            <span class="las la-envelope"></span>
                        </div>
                        <div class="card-progress">
                            <small>Monthly Bills</small>
                            <div class="card-indicator">
                                <div class="indicator four" style="width: <?php echo $percentageBillsPaid; ?>%"></div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="records table-responsive">

                    <div class="record-header">
                        <div class="add">
                            <button id="showExpenseForm">Add record</button>
                        </div>

                        <div class="browse">
                            <form method="post" action="">
                                <input type="date" name="inputDate" id="inputDate" onchange="this.form.submit()" class="record-search" value="<?php echo $selectedDate; ?>">
                                <select name="inputStatus" id="inputStatus" onchange="this.form.submit()">
                                    <option value="all" <?php echo ($selectedOption === 'all') ? 'selected' : ''; ?>>All</option>
                                    <option value="paid" <?php echo ($selectedOption === 'paid') ? 'selected' : ''; ?>>Paid</option>
                                    <option value="unpaid" <?php echo ($selectedOption === 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                                </select>
                            </form>
                            <form method="post">
                                <button type="submit" name="myButton">Clear Filters</button>
                            </form>
                        </div>
                    </div>

                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><span class="las la-sort"></span> CATEGORY</th>
                                    <th><span class="las la-sort"></span> TOTAL EXPENSE</th>
                                    <th><span class="las la-sort"></span> ISSUED DATE</th>
                                    <th><span class="las la-sort"></span> STATUS</th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="expenseTableBody">
                            <?php 
                                for($i=1; $i<=$result;$i++){
                                    $row =  mysqli_fetch_array($query1)
 	                            ?>
                                <tr>
                                    <td>#<?php  echo $row['data_id']?></td>
                                    <td>
                                        <div class="client">
                                            <div class="client-img bg-img" style="background-image: url(img/1.jpeg)">
                                            </div>
                                            <div class="client-info">
                                                <h3><?php  echo $row['category']?></h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        Rs <?php  echo $row['total_expense']?>
                                    </td>
                                    <td>
                                        <?php  echo $row['issued_date']?>
                                    </td>
                                    <td>
                                        <?php  echo $row['status']?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <button class="editExpense">Edit</button>
                                            <button class="deleteExpense">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
            

        </main>

    </div>


</body>

<script>

    const showExpenseForm = document.getElementById("showExpenseForm");
    const expenseForm = document.getElementById("expenseForm");
    const expenseEntryForm = document.getElementById("expenseEntryForm");
    
    showExpenseForm.addEventListener("click", () => {
        showExpenseForm.style.display = "none"; // Hide the button
        expenseForm.style.display = "block";
    });

    const hideExpenseForm = () => {
        showExpenseForm.style.display = "block"; // Show the button
        expenseForm.style.display = "none";
        expenseEntryForm.reset();
    };

    document.getElementById("cancel").addEventListener("click", hideExpenseForm);

</script>



</html>