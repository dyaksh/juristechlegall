<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST["full_name"];
    $address = $_POST["address"];
    $college = $_POST["college"];
    $position = $_POST["looking_for"];
    $year_cleared = $_POST["year"];
    $course_duration = $_POST["duration"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $immediate_joining = $_POST["immediate_joining"];
    $in_office_internship = $_POST["ready"];
    $phone_number = $_POST["phone"]; 
    $email = $_POST["email"];
    // File Upload - Resume
    $resume_tmp_name = $_FILES["resume"]["tmp_name"];
    $resume_name = $_FILES["resume"]["name"];

    // File Upload - Profile Image
    $profile_image_tmp_name = $_FILES["picture"]["tmp_name"];
    $profile_image_name = $_FILES["picture"]["name"];

    // Compose the email message
    $subject = "Career Application Submission";
    $message = " Name: $full_name\n";
    $message .= "Email Address: $email\n";
    $message .= "Phone Number: $phone_number\n";
    $message .= "Address: $address\n";
    $message .= "College/University: $college\n";
    $message .= "Course Duration: $course_duration\n";
    $message .= "Position Applied For: $position\n";
    $message .= "Year of Graduation: $year_cleared\n";
    $message .= "Preferred Start Date: $start_date\n";
    $message .= "Preferred End Date: $end_date\n";
    $message .= "Immediate Joining: $immediate_joining\n";
    $message .= "Ready for In-Office Internship: $in_office_internship\n";
    
    $to = "yakshdarji2@gmail.com";

    // Create a boundary for the email
    $boundary = md5(time());

    // Headers for the email
    $headers = "From: $full_name <$email>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message Body
    $email_message = "--$boundary\r\n";
    $email_message .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
    $email_message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $email_message .= $message . "\r\n\r\n";

    // Resume Attachment
    if (is_uploaded_file($resume_tmp_name)) {
        $file = fopen($resume_tmp_name, "rb");
        $data = fread($file, filesize($resume_tmp_name));
        fclose($file);
        $attachment_data = chunk_split(base64_encode($data));
        $email_message .= "--$boundary\r\n";
        $email_message .= "Content-Type: application/octet-stream; name=\"$resume_name\"\r\n";
        $email_message .= "Content-Disposition: attachment; filename=\"$resume_name\"\r\n";
        $email_message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $email_message .= $attachment_data . "\r\n\r\n";
    }

    // Profile Image Attachment
    if (is_uploaded_file($profile_image_tmp_name)) {
        $file = fopen($profile_image_tmp_name, "rb");
        $data = fread($file, filesize($profile_image_tmp_name));
        fclose($file);
        $attachment_data = chunk_split(base64_encode($data));
        $email_message .= "--$boundary\r\n";
        $email_message .= "Content-Type: application/octet-stream; name=\"$profile_image_name\"\r\n";
        $email_message .= "Content-Disposition: attachment; filename=\"$profile_image_name\"\r\n";
        $email_message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $email_message .= $attachment_data . "\r\n\r\n";
    }

    // Send the email
    if (mail($to, $subject, $email_message, $headers)) {
        echo json_encode(array("message" => "Thank you for your application!"));
      
    } else {
        echo json_encode(array("message" => "Sorry, there was an error processing your application. Please try again later."));
    }
} else {
    echo json_encode(array("message" => "Invalid request."));
}
?>
