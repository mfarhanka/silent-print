<?php
// Include database configuration
require_once 'config.php';

// Set content type to JSON
header('Content-Type: application/json');

// Initialize response array
$response = array();

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize and validate input
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $company = isset($_POST['company']) ? trim($_POST['company']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validation
    $errors = array();
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    } elseif (strlen($message) < 10) {
        $errors[] = 'Message must be at least 10 characters';
    }
    
    // If there are validation errors
    if (!empty($errors)) {
        $response['success'] = false;
        $response['message'] = implode(', ', $errors);
        echo json_encode($response);
        exit;
    }
    
    // Escape strings to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $company = $conn->real_escape_string($company);
    $message = $conn->real_escape_string($message);
    
    // Insert into database
    $sql = "INSERT INTO inquiries (name, email, phone, company, message) 
            VALUES ('$name', '$email', '$phone', '$company', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Thank you for contacting us! We will get back to you soon.';
        
        // Optional: Send email notification
        // You can uncomment and configure this section if you want email notifications
        /*
        $to = "info@silentprints.com";
        $subject = "New Contact Form Submission - Silent Prints";
        $email_message = "New inquiry from $name\n\n";
        $email_message .= "Name: $name\n";
        $email_message .= "Email: $email\n";
        $email_message .= "Phone: $phone\n";
        $email_message .= "Company: $company\n";
        $email_message .= "Message:\n$message\n";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        mail($to, $subject, $email_message, $headers);
        */
        
    } else {
        $response['success'] = false;
        $response['message'] = 'An error occurred. Please try again later.';
        
        // Log error (in production, use proper error logging)
        error_log("Database error: " . $conn->error);
    }
    
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
}

// Close connection
$conn->close();

// Return JSON response
echo json_encode($response);
?>
