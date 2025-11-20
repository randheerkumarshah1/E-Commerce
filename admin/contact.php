<?php
include("../includes/header.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // For demo: Save in a file (You can replace this with database/email logic)
    $file = fopen("messages.txt", "a");
    fwrite($file, "Name: $name | Email: $email | Subject: $subject | Message: $message\n");
    fclose($file);

    $success = "Your message has been sent successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - MyShop</title>
  <style>
    body {font-family: Arial, sans-serif; margin:0; padding:0; background:#f9f9f9;}
    .container {max-width:1100px; margin:30px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
    h1 {text-align:center; color:#007bff; margin-bottom:20px;}
    .row {display:flex; flex-wrap:wrap; gap:20px;}
    .form-container, .info-container {flex:1; min-width:300px;}
    form input, form textarea {width:100%; padding:12px; margin-bottom:10px; border:1px solid #ddd; border-radius:6px;}
    form button {background:#007bff; color:#fff; border:none; padding:12px 20px; border-radius:6px; cursor:pointer;}
    form button:hover {background:#0056b3;}
    .info-container {background:#f1f1f1; padding:20px; border-radius:10px;}
    .info-item {margin-bottom:15px;}
    .map {margin-top:20px;}
    .success {color:green; font-weight:bold; margin-bottom:15px;}
    @media(max-width:768px){.row{flex-direction:column;}}
  </style>
</head>
<body>
  <div class="container">
    <h1>Contact Us</h1>
    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

    <div class="row">
      <!-- Contact Form -->
      <div class="form-container">
        <form method="POST" action="">
          <input type="text" name="name" placeholder="Your Name" required>
          <input type="email" name="email" placeholder="Your Email" required>
          <input type="text" name="subject" placeholder="Subject" required>
          <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="info-container">
        <div class="info-item"><strong>Email:</strong> randheerkumarshah9213@gmail.com</div>
        <div class="info-item"><strong>Phone:</strong> +91 9354025247</div>
        <div class="info-item"><strong>Address:</strong> 123 Market Road, New Delhi, India</div>
        <div class="map">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.000000000!2d77.216721!3d28.644800!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd34abcd1234%3A0x56789abcd1234ef!2sConnaught%20Place%2C%20New%20Delhi!5e0!3m2!1sen!2sin!4v0000000000" 
            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php
include("../includes/footer.php");
?>
