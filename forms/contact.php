<?php
// Set your email address
$to = "sowndharvisuals@gmail.com";
$subjectPrefix = "Contact Form: ";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and retrieve form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "error: All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error: Invalid email format.";
        exit;
    }

    // Email content
    $emailSubject = $subjectPrefix . $subject;
    $emailBody = "You have received a new message from the contact form:\n\n"
               . "Name: $name\n"
               . "Email: $email\n"
               . "Subject: $subject\n\n"
               . "Message:\n$message\n";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $emailSubject, $emailBody, $headers)) {
        echo "success: Your message has been sent. Thank you!";
    } else {
        echo "error: There was a problem sending your email.";
    }
} else {
    echo "error: Invalid request method.";
}
?>
