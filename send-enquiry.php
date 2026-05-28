<?php
// Always return JSON
header('Content-Type: application/json');

// Load PHPMailer
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Block direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit();
}

// Grab form data
$first_name = trim(strip_tags($_POST['first_name'] ?? ''));
$last_name  = trim(strip_tags($_POST['last_name']  ?? ''));
$name       = trim("$first_name $last_name");
$email      = trim(strip_tags($_POST['email']      ?? ''));
$phone      = trim(strip_tags($_POST['phone']      ?? ''));
$service    = trim(strip_tags($_POST['service']    ?? ''));
$budget     = trim(strip_tags($_POST['budget']     ?? ''));
$message    = trim(strip_tags($_POST['message']    ?? ''));

// Validate
if (!$first_name || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Please enter your name and phone number.']);
    exit();
}

// Helper
function createMailer(): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'plesk-web3.webhostbox.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@enivesh.in';
    $mail->Password   = 'Rajgir@@2026';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';
    $mail->Timeout    = 30;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ]
    ];
    return $mail;
}

// =========================================================
// MAIL 1 — Notify admin
// =========================================================
try {
    $mail = createMailer();
    $mail->setFrom('info@enivesh.in', 'eNivesh Website');
    $mail->addAddress('info@enivesh.in', 'eNivesh');
    if ($email) $mail->addReplyTo($email, $name);
    $mail->isHTML(true);
    $mail->Subject = "New Enquiry from $name - eNivesh";
    $mail->Body = "
    <html><body style='font-family:Arial,sans-serif;color:#333;'>
    <div style='max-width:600px;margin:auto;'>
    <h2 style='color:#1DA1F2;border-bottom:2px solid #1DA1F2;padding-bottom:10px;'>New Enquiry — eNivesh Contact Form</h2>
    <table cellpadding='10' cellspacing='0' style='border-collapse:collapse;width:100%;margin-top:16px;'>
        <tr style='background:#E8F5FD;'>
            <td style='width:170px;font-weight:bold;border:1px solid #D0E6F5;'>Full Name</td>
            <td style='border:1px solid #D0E6F5;'>" . htmlspecialchars($name) . "</td>
        </tr>
        <tr>
            <td style='font-weight:bold;border:1px solid #D0E6F5;'>Phone</td>
            <td style='border:1px solid #D0E6F5;'>" . htmlspecialchars($phone) . "</td>
        </tr>
        <tr style='background:#E8F5FD;'>
            <td style='font-weight:bold;border:1px solid #D0E6F5;'>Email</td>
            <td style='border:1px solid #D0E6F5;'>" . (htmlspecialchars($email) ?: 'Not provided') . "</td>
        </tr>
        <tr>
            <td style='font-weight:bold;border:1px solid #D0E6F5;'>Interested In</td>
            <td style='border:1px solid #D0E6F5;'>" . (htmlspecialchars($service) ?: 'Not selected') . "</td>
        </tr>
        <tr style='background:#E8F5FD;'>
            <td style='font-weight:bold;border:1px solid #D0E6F5;'>Investment Budget</td>
            <td style='border:1px solid #D0E6F5;'>" . (htmlspecialchars($budget) ?: 'Not selected') . "</td>
        </tr>
        <tr>
            <td style='font-weight:bold;border:1px solid #D0E6F5;vertical-align:top;'>Message</td>
            <td style='border:1px solid #D0E6F5;'>" . (nl2br(htmlspecialchars($message)) ?: 'No message provided') . "</td>
        </tr>
    </table>
    <p style='margin-top:20px;font-size:12px;color:#999;'>Sent from enivesh.in contact form</p>
    </div>
    </body></html>";
    $mail->AltBody = "New Enquiry\nName: $name\nPhone: $phone\nEmail: $email\nService: $service\nBudget: $budget\nMessage: $message";
    $mail->send();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Mail error: ' . $mail->ErrorInfo]);
    exit();
}

// =========================================================
// MAIL 2 — Acknowledgement to visitor
// =========================================================
if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    try {
        $mail2 = createMailer();
        $mail2->setFrom('info@enivesh.in', 'eNivesh Financial Services');
        $mail2->addAddress($email, $name);
        $mail2->isHTML(true);
        $mail2->Subject = "We received your enquiry — eNivesh";
        $mail2->Body = "
        <html><body style='font-family:Arial,sans-serif;color:#333;background:#F5FAFE;padding:20px;'>
        <div style='max-width:560px;margin:auto;background:#fff;border-radius:12px;padding:36px;box-shadow:0 6px 24px rgba(13,126,196,0.14);'>
            <h2 style='color:#1DA1F2;margin-bottom:8px;'>Thank You, " . htmlspecialchars($first_name) . "!</h2>
            <p style='font-size:16px;line-height:1.6;color:#0D2233;'>We have received your enquiry and our advisor will get back to you within <strong>1 business day</strong>.</p>
            <hr style='margin:24px 0;border:none;border-top:1px solid #EEF5FB;'>
            <h4 style='margin-bottom:12px;color:#074E7A;font-size:14px;text-transform:uppercase;letter-spacing:0.05em;'>Your Enquiry Summary</h4>
            <table cellpadding='8' cellspacing='0' style='width:100%;border-collapse:collapse;font-size:14px;'>
                <tr style='background:#E8F5FD;'>
                    <td style='font-weight:bold;border:1px solid #D0E6F5;width:140px;'>Interested In</td>
                    <td style='border:1px solid #D0E6F5;'>" . (htmlspecialchars($service) ?: 'Not selected') . "</td>
                </tr>
                <tr>
                    <td style='font-weight:bold;border:1px solid #D0E6F5;'>Budget</td>
                    <td style='border:1px solid #D0E6F5;'>" . (htmlspecialchars($budget) ?: 'Not selected') . "</td>
                </tr>
                <tr style='background:#E8F5FD;'>
                    <td style='font-weight:bold;border:1px solid #D0E6F5;vertical-align:top;'>Message</td>
                    <td style='border:1px solid #D0E6F5;'>" . (nl2br(htmlspecialchars($message)) ?: 'No message provided') . "</td>
                </tr>
            </table>
            <div style='margin-top:28px;padding:16px;background:#E8F5FD;border-radius:8px;'>
                <p style='font-size:14px;color:#074E7A;margin:0;'>Need immediate help? Call us at<br>
                <strong style='font-size:16px;'><a href='tel:+919031831828' style='color:#1DA1F2;'>+91-9031831828</a></strong></p>
            </div>
            <p style='margin-top:24px;font-size:13px;color:#5A8FA8;'>If you did not submit this form, please ignore this email.</p>
            <p style='margin-top:8px;font-size:14px;'>Best regards,<br><strong>Team eNivesh Financial Services</strong><br>
            <a href='https://enivesh.in' style='color:#1DA1F2;'>enivesh.in</a></p>
        </div>
        </body></html>";
        $mail2->AltBody = "Hi $first_name,\n\nThank you for your enquiry. Our advisor will contact you within 1 business day.\n\nNeed help now? Call +91-9031831828\n\nTeam eNivesh\nhttps://enivesh.in";
        $mail2->send();
    } catch (Exception $e) {
        error_log('eNivesh ack mail failed: ' . $e->getMessage());
    }
}

// Success!
echo json_encode(['success' => true]);
exit();
