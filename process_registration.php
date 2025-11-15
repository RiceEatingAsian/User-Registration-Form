<?php
// ----------------------------------------------------
// Database Configuration
// !! IMPORTANT: Update these values if they changed !!
// ----------------------------------------------------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_experiment_db"; // Database name from Experiment 1

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Collect and Sanitize Input Data
    $input_username = trim($_POST['username']);
    $input_email = trim($_POST['email']);
    $input_password = $_POST['password']; // Password input is taken as is

    // Basic validation (You would add more complex validation here)
    if (empty($input_username) || empty($input_email) || empty($input_password)) {
        die("<h3>❌ Error: All fields are required.</h3>");
    }

    // 2. Security Enhancement: Hash the Password
    // IMPORTANT: Never store passwords in plain text!
    $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);
    
    // 3. Database Connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("❌ Database connection failed: " . $conn->connect_error);
    }

    // 4. PREPARED STATEMENT for Secure Insertion (CRUCIAL Requirement)
    // We are inserting into the 'users' table created in Experiment 1.
    // Note: The 'users' table only has 'name' and 'email' columns.
    // We map 'input_username' to 'name' and 'input_email' to 'email'.
    // In a real application, you would also insert the $hashed_password.
    $sql = "INSERT INTO users (name, email) VALUES (?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("❌ Error preparing statement: " . $conn->error);
    }
    
    // Bind parameters to the query
    // 's' means the corresponding variable is a string (username and email are strings)
    $stmt->bind_param("ss", $input_username, $input_email);
    
    // 5. Execute the Statement
    if ($stmt->execute()) {
        $feedback_message = "<h3>✅ Registration successful!</h3><p>User **$input_username** with email **$input_email** has been added to the database.</p>";
    } else {
        // Check for specific error, like duplicate entry (from the UNIQUE constraint on 'email')
        if ($conn->errno == 1062) {
             $feedback_message = "<h3>❌ Registration failed:</h3><p>The email **$input_email** is already registered.</p>";
        } else {
            $feedback_message = "<h3>❌ Registration failed:</h3><p>Error: " . $stmt->error . "</p>";
        }
    }

    // 6. Close statement and connection
    $stmt->close();
    $conn->close();

} else {
    // If the user tries to access this page directly (not via POST submission)
    $feedback_message = "<h3>🚫 Invalid access.</h3><p>Please submit the form via <a href='register.html'>register.html</a>.</p>";
}

// ----------------------------------------------------
// Display Feedback to the User
// ----------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Feedback</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .feedback { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 400px; text-align: center; }
        h3 { color: #5cb85c; }
        .feedback h3.error { color: #d9534f; }
    </style>
</head>
<body>
    <div class="feedback">
        <?php 
            echo $feedback_message; 
            // Change color for error messages
            if (strpos($feedback_message, '❌') !== false) {
                echo "<script>document.querySelector('.feedback h3').classList.add('error');</script>";
            }
        ?>
        <p><a href="register.html">Go back to registration</a></p>
    </div>
</body>
</html>