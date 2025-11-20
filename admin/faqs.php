<?php
include("../includes/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQs - MyShop</title>
  <style>
    body {font-family: Arial, sans-serif; margin:0; padding:0; background:#f9f9f9;}
    .container {max-width:1000px; margin:30px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
    h1 {text-align:center; color:#007bff; margin-bottom:20px;}
    .faq-item {margin-bottom:20px;}
    .faq-question {font-weight:bold; cursor:pointer; background:#f1f1f1; padding:12px; border-radius:6px;}
    .faq-answer {display:none; padding:10px; color:#555; border-left:3px solid #007bff; margin-top:5px; background:#fafafa; border-radius:6px;}
    @media(max-width:768px){
      .container {margin:10px; padding:15px;}
    }
  </style>
  <script>
    function toggleFAQ(index) {
      let answer = document.getElementById("answer" + index);
      if (answer.style.display === "block") {
        answer.style.display = "none";
      } else {
        answer.style.display = "block";
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <h1>Frequently Asked Questions (FAQs)</h1>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(1)">1. How do I place an order?</div>
      <div class="faq-answer" id="answer1">
        To place an order, simply browse our products, add items to your cart, and proceed to checkout.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(2)">2. What payment methods are accepted?</div>
      <div class="faq-answer" id="answer2">
        We accept Credit/Debit cards, UPI, Net Banking, and Cash on Delivery (COD).
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(3)">3. How can I track my order?</div>
      <div class="faq-answer" id="answer3">
        After your order is shipped, you will receive an email/SMS with a tracking link.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(4)">4. What is your return policy?</div>
      <div class="faq-answer" id="answer4">
        Products can be returned within 7 days of delivery if defective, damaged, or incorrect. Check our <a href="return-policy.php">Return Policy</a>.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(5)">5. How long does delivery take?</div>
      <div class="faq-answer" id="answer5">
        Delivery usually takes 3–7 business days, depending on your location.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question" onclick="toggleFAQ(6)">6. Do you offer international shipping?</div>
      <div class="faq-answer" id="answer6">
        Currently, we only ship within India. International shipping will be available soon.
      </div>
    </div>

  </div>
</body>
</html>
<?php
include("../includes/footer.php");
?>
