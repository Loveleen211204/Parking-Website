<?php
include "db.php";

if(isset($_POST['send'])){

    $name = $_POST['name'] ?? '';
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    $issue = $_POST['issue'] ?? '';
    $message = $_POST['message'] ?? '';

    if($name == '' || $role == '' || $email == '' || $issue == '' || $message == ''){
        header("Location: contact.php?error=1");
        exit();
    } else {
        $sql = "INSERT INTO contact_requests (name, role, email, issue, message)
                VALUES ('$name','$role','$email','$issue','$message')";

        if(mysqli_query($conn, $sql)){
            header("Location: contact.php?sent=1");   // 🔥 redirect after success
            exit();
        } else {
            die("DB Error: " . mysqli_error($conn));
        }
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Contact & Help | Activa Parking System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  
    <style>
        body {
            background: #f6f2ef;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .top-bar {
            background: #7b1f2a;
            color: #fff;
            font-size: 14px;
            padding: 8px 0;
        }

        .hero {
            
             text-align: center;
             padding: 10px;
             background: #9b2c3b;
            color: #fff;
        }

        .hero h1 {
            color: #f8f7f7;
            font-weight: 800;
        }

        .info-card {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-top: 4px solid  #9b2c3b;
            transition: 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-8px);
        }

        .icon-circle {
            width: 55px;
            height: 50px;
            background:  #9b2c3b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .section-title {
            text-align: center;
            color: var  #9b2c3b;
            font-weight: 700;
            margin: 50px 0 25px;
        }

        .faq .accordion-button {
            font-weight: 600;
        }

        footer {
            background: #7b1f2a;
            color:#fff;
            padding: 18px 0;
            margin-top: 50px;
        }
        .top-bar {
            background: #7b1f2a;
            color: #fff;
            font-size: 14px;
            padding: 10px 0;
        }
    </style>
</head>
<body> 
 <?php 
    if(isset($_GET['sent'])){ ?>
      <div class="alert alert-success text-center">
        ✅ Request sent successfully!
     </div>
 <?php } ?>

 <?php if(isset($_GET['error'])){ ?>
    <div class="alert alert-danger text-center">
        ❌ Please fill all fields!
    </div>
 <?php } ?>

  <!-- Top Bar -->
  <div class="top-bar d-flex align-items-center justify-content-between px-3">
     <a href="main.php" class="btn btn-light btn-sm">
       <i class="fa-solid fa-house me-1"></i> Home
     </a>
    <!-- Center Text -->
    <div class="mx-auto text-center">
       📞 Parking Help Desk: +91 9XXXXXXXXX |
       ✉️ support@collegeparking.com |
       🕒 9:00 AM - 5:00 PM
    </div>
  </div>
  <!-- Hero -->
    <div class="hero text-center">
      <div class="container">
        <h1>Contact & Help Desk</h1>
        <p>Activa Parking System – Student Support & Assistance</p>
      </div>
    </div>

  <div class="container py-5">
    <!-- Contact Info -->
    <h3 class="section-title">📍 Contact Information</h3>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-geo-alt-fill"></i></div>
                <h6>College Address</h6>
                <p>Kanya Maha Vidyalaya, Jalandhar, Punjab</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-telephone-fill"></i></div>
                <h6>Help Desk</h6>
                <p>+91 9XXXXXXXXX</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-envelope-fill"></i></div>
                <h6>Email Support</h6>
                <p>support@collegeparking.com</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-person-badge-fill"></i></div>
                <h6>Parking Supervisor</h6>
                <p>Mr. Rajesh Kumar</p>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <h3 class="section-title">❓ Help & FAQs</h3>
     <div class="accordion faq" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                    I forgot to mark OUT time. What should I do?
                </button>
            </h2>
            <div id="q1" class="accordion-collapse collapse " data-bs-parent="#faqAccordion" aria-expanded="true">
                <div class="accordion-body">
                    Contact the parking supervisor or submit a help request through the contact form.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q2">
                    My vehicle is not showing on the dashboard.
                </button>
            </h2>
            <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Please ensure your vehicle is registered and your account is approved by admin.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q3">
                    Login is not working.
                </button>
            </h2>
            <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Check your email & password or use "Forgot Password" option. Contact admin if problem continues.
                </div>
            </div>
        </div>
     </div>

    <!-- Contact Form -->      
    <h3 class="section-title">📝 Raise a Help Request</h3>
     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="info-card">
                <form method="POST" action="contact.php" >
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Student Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control"  name="role" placeholder="Student/Teacher" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"placeholder="Enter email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Issue Type</label>
                            <select  name="issue" class="form-select" required>
                                <option>Login Issue</option>
                                <option>Updation Issues</option>
                                <option>Vehicle Not Showing</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="4" name="message"  placeholder="Describe your problem..." required></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-danger px-4" name="send">Submit Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
     </div>

    <!-- Emergency -->
    <h3 class="section-title">🚨 Emergency Support</h3>
     <div class="row g-4">
        <div class="col-md-4">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-shield-lock-fill"></i></div>
                <h6>Security Office</h6>
                <p>Near Parking Gate</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-hospital-fill"></i></div>
                <h6>First Aid Room</h6>
                <p>Near Parking Type-A</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card text-center">
                <div class="icon-circle"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <h6>Emergency Number</h6>
                <p>112</p>
            </div>
        </div>
     </div>
  </div>
<footer class="text-center">
     © KMV Parking Management 
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>