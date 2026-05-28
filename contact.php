<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Enivesh</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 40px 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 24px; color: #333; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; color: #555; }
        input, textarea { width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px; }
        textarea { height: 130px; resize: vertical; }
        button { background: #2c7be5; color: #fff; border: none; padding: 12px 30px; border-radius: 5px; font-size: 16px; cursor: pointer; width: 100%; }
        button:hover { background: #1a5fbd; }
        .msg { padding: 12px 16px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
<div class="container">
    <h2>Contact Us</h2>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'success') {
            echo '<div class="msg success">&#10003; Thank you! Your message has been sent. We\'ll get back to you shortly.</div>';
        } elseif ($_GET['status'] === 'error') {
            $err = isset($_GET['msg']) ? htmlspecialchars(urldecode($_GET['msg'])) : 'Something went wrong.';
            echo '<div class="msg error">&#10007; Error: ' . $err . '</div>';
        }
    }
    ?>

    <form action="send_mail.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" required placeholder="Your full name">
        </div>
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required placeholder="your@email.com">
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+91 XXXXX XXXXX">
        </div>
        <div class="form-group">
            <label for="subject">Subject *</label>
            <input type="text" id="subject" name="subject" required placeholder="How can we help?">
        </div>
        <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required placeholder="Write your message here..."></textarea>
        </div>
        <button type="submit">Send Message</button>
    </form>
</div>
</body>
</html>
