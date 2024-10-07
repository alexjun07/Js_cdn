<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer via Composer

// Get the posted data
$chatData = isset($_POST['chatData']) ? $_POST['chatData'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : ''; // Added email field
$phone = isset($_POST['phone']) ? $_POST['phone'] : ''; // Added phone field
$contact = isset($_POST['contact']) ? $_POST['contact'] : '';

// Decode the JSON chat data
$chatHistory = json_decode($chatData, true);

// Function to strip HTML tags from bot messages
function cleanMessage($message) {
    // Strip HTML tags from the message and decode any special HTML entities (like emojis)
    return htmlspecialchars_decode(strip_tags($message), ENT_QUOTES);
}

// Format the email body
$emailBody = "<h3>New Chat Conversation</h3>";
$emailBody .= "<strong>Name:</strong> " . htmlspecialchars($name) . "<br>";
$emailBody .= "<strong>Email:</strong> " . htmlspecialchars($email) . "<br>"; // Added email in the email body
$emailBody .= "<strong>Phone:</strong> " . htmlspecialchars($phone) . "<br>"; // Added phone in the email body
$emailBody .= "<strong>Contact:</strong> " . htmlspecialchars($contact) . "<br><br>";
$emailBody .= "<strong>Chat History:</strong><br><ul>";

if (is_array($chatHistory)) {
    foreach ($chatHistory as $message) {
        $sender = htmlspecialchars($message['sender']);
        $text = htmlspecialchars($message['message']);

        // Clean the message text (remove HTML tags and decode any entities)
        $cleanText = cleanMessage($text);

        // Differentiate between bot and user messages
        if ($sender === 'bot') {
            $emailBody .= "<li><strong>Bot:</strong> $cleanText</li>";
        } else {
            $emailBody .= "<li><strong>User:</strong> $cleanText</li>";
        }
    }
}

$emailBody .= "</ul>";

// Setup PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ashishdwivedi.dmp@gmail.com'; // Replace with your Gmail address
    $mail->Password   = 'qzbg xexi eygh jrge';           // Replace with your App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('ashishdwivedi.dmp@gmail.com', 'KBS Travel Bot');
    $mail->addAddress('ankusajwan7840@gmail.com');     // Your recipient email

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Chat Conversation from Bot';
    $mail->Body    = $emailBody;

    $mail->send();
    echo 'Mail sent successfully!';
} catch (Exception $e) {
    echo "Mail could not be sent. Error: {$mail->ErrorInfo}";
}
?>
