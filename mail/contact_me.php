<?php
// Validate email address
$email_address = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// Check for empty fields
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message']) || !$email_address) {
    echo "No arguments provided or invalid email!";
    return false;
}

$name = htmlspecialchars($_POST['name']);
$phone = htmlspecialchars($_POST['phone']);
$message = htmlspecialchars($_POST['message']);

if ($email_address === FALSE) {
    echo 'Invalid email';
    exit(1);
}

if (empty($_POST['_gotcha'])) { // If hidden field was filled out (by spambots) don't send!
    // Create the email and send the message
    $to = 'elysian0121@gmail.com'; // Your email address
    $email_subject = "Website Contact Form:  $name";
    $email_body = "You have received a new message from your website contact form.\n\n" .
                  "Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
    $headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from
    $headers .= "Reply-To: $email_address";

    if(mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully!";
        return true;
    } else {
        echo "Mail sending failed!";
        return false;
    }
}

echo "Gotcha, spambot!";
return false;
?>
