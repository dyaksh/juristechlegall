<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

  
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Add debugging output
    echo '<script>alert("Invalid email address: ' . $email . '"); window.location = "index.html";</script>';
    exit();
}


    // Compose the email message
    $subject = "Enquiry for Legal Services";
    $messageBody = "Name: $name\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Phone Number: $phone\n";
    $messageBody .= "Message:\n$message";

    // Replace with your own email address
    $to = "yakshdarji2@gmail.com";

    // Send the email
    $headers = "From: Juristechlegal <noreply@example.com>";

    if (mail($to, $subject, $messageBody, $headers)) {
        echo '<script>alert("Thank you for your submission!"); window.location = "index.html";</script>';
    } else {
        echo '<script>alert("Sorry, there was an error processing your request. Please try again later."); window.location = "index.html";</script>';
    }
} else {
    echo '<script>alert("Invalid request."); window.location = "index.html";</script>';
}
?>
