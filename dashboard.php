<?php
session_start(); // Start the session

// Oracle database connection parameters
$hostname = 'localhost';
$username = 'system';
$password = 'varshini03';
$service_name = 'orcl'; // or SID if applicable

// Construct the Oracle database connection string
$db_connection_string = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=$hostname)(PORT=1522)))(CONNECT_DATA=(SERVICE_NAME=$service_name)))";

// Attempt to establish a connection to the Oracle database
$conn = oci_connect($username, $password, $db_connection_string);

// Check if the connection was successful
if (!$conn) {
    $error_message = oci_error(); // Get the Oracle error message
    die("Connection failed: " . $error_message['message']);
}else {
    echo "Connected to Oracle database successfully";
    // You can perform database operations here
    // For example, execute SQL queries, fetch data, etc.
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit; // Terminate the script
}

// Handle logout
if (isset($_POST['logout'])) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to the login page after logout
    header("Location: login.php");
    exit; // Terminate the script
}

// Close the database connection when done
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
			background-image: url('wall.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: light yellow;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
            color: white;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }
        .dashboard-links {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .dashboard-links li {
            margin-bottom: 20px;
        }
        .dashboard-links a {
            display: block;
            padding: 15px 30px;
            background-color: lightcoral;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dashboard-links a:hover {
            background-color: darkslateblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="dashboard-title">Hostel Management Dashboard</h1>
		
        <ul class="dashboard-links">
		     <li><a href="hostel.php">Hostel Information</a></li>
            <li><a href="student.php">Student Information</a></li>
            <li><a href="room.php">Room Details</a></li>
            <li><a href="fee.php">Mess Payment Records</a></li>
            <li><a href="warden.php">Warden Information</a></li>
        </ul>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
