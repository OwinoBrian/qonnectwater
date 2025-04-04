<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'vendor/autoload.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['First Name'] ?? '';
    $email = $_POST['Email'] ?? '';
    $phone = $_POST['Phone Number'] ?? '';
    $coverLetter = $_POST['Cover Letter'] ?? '';

    // File handling
    $attachment = $_FILES['Attachments']['tmp_name'] ?? null;
    $attachmentName = $_FILES['Attachments']['name'] ?? null;

    // Email settings
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'mail.gulfjobskenya.online';  // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'recruitment@gulfjobskenya.online'; // Replace with your email
        $mail->Password = 'Gulf@2025'; // Use a real app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 465;

        // Email headers
        $mail->setFrom('recruitment@gulfjobskenya.online', 'Job Application');
        $mail->addAddress('admin@gulfjobskenya.online'); // Admin's receiving email

        // Attach file if exists
        if ($attachment) {
            $mail->addAttachment($attachment, $attachmentName);
        }

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Job Application from $firstName";
        $mail->Body = "
            <h3>New Job Application</h3>
            <p><strong>Name:</strong> $firstName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Cover Letter:</strong><br> $coverLetter</p>
        ";

        // Send email
        $mail->send();
        echo "Application submitted successfully.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
