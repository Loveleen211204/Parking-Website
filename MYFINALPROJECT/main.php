<html>
<head>
<meta charset="UTF-8">
<title> Parking Management </title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background:#f6f2ef;
}

/* ===== Navbar ===== */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #7b1e2b;
    padding: 15px 30px;
    color: white;
    flex-wrap: wrap;
}

header nav a {
    margin-left: 15px;
    text-decoration: none;
    color: white;
    transition: transform 0.2s ease;
    background: 0.2s ease;
    color: 0.2s ease;
    border-radius: 6px;
}

header nav a:hover {
    transform: translateY(-3px);
}

.second-header {
    background-color:  #9b2c3b;
    color: white;
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    padding: 12px 0;
}

.notice-bar {
    overflow: hidden;
    white-space: nowrap;
    background:#7b1e2b;
    padding: 10px 0;
}

.notice-bar p {
    display: inline-block;
    color: white;
    font-size: 20px;
    font-weight: 400;
    white-space: nowrap;
    animation: scroll-left 18s linear infinite;
}

/* Animation */
@keyframes scroll-left {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

.logo-area {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.logo-img {
    width: 90px;
    height: 80px;
    margin-right: 7px;
}

.logo-text {
    font-size: 14px;
    color: white;
}

/* ===== Buttons ===== */
.btn {
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 4px;
    margin-left: 10px;
    font-weight: bold;
    display: inline-block;
    transition: transform 0.3s ease;
    box-shadow :0.3s ease;
}

.login {
    background-color: #ffffff;
    color:#7b1e2b;
}

.register {
    background-color: #ffffff;
    color: #7b1e2b;
}
.login1 {
    background-color: #7b1e2b;
    color: #ffffff;
}

.register1 {
    background-color: #7b1e2b;
    color: #ffffff;
}

.primary {
    background: #fd7e14;
    color: white;
}
.secondary {
    background: #0d6efd;
    color: white;
}

.small {
    background: #7b1e2b;
    color: white;
}
/* ===== Hero ===== */
.hero {
    background-image: url("https://irp.cdn-website.com/2c13bff2/dms3rep/multi/parking-state-college.webp");
    background-size: cover;
    background-position: center;
    height: 450px;
    width: 100%;
}

/* ===== Cards ===== */
.cards {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 40px;
    flex-wrap: wrap;
}

.card {
    background: white;
    padding: 20px;
    border-left: 4px solid  #9b2c3b;
    width: 250px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease; box-shadow: 0.3s ease;
    cursor: pointer;
}

.card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
    border-left-color: #7b1e2b;
}

/* ===== Features ===== */
.features {
    background: #f6f2ef;
    padding: 40px;
    text-align: center;
}

.feature-box {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.feature {
    background: #eef2ff;
    padding: 20px; 
    border-left: 4px solid  #9b2c3b;
    border-radius: 10px;
    width: 220px;
    transition: transform 0.3s ease;
    box-shadow :0.3s ease;
    cursor: pointer;
}

.feature:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
    border-left-color: #7b1e2b;
}

/* ===== Auth Section ===== */
.auth {
    text-align: center;
    padding: 40px;
    background: #f6f2ef;
}

.auth .btn:hover {
    transform: translateY(-5px) scale(1.08);
    box-shadow: 0 10px 22px rgba(0,0,0,0.25);
}

/* ===== Footer ===== */
footer {
    background-color: #7b1e2b;
    color: white;
    text-align: center;
    padding: 12px;
    margin-top: 30px;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        text-align: center;
    }
    header nav {
        margin-top: 10px;
    }
}
</style>
</head>
<body>
<header>
 <div class="logo-area">
    <img src="data:image/png;base64,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" class="logo-img">
    <div class="logo-text">
        The Hertitage Institution (Established 1886) <br>
        Kanya Maha Vidyalaya (Autonomous)<br>
        For Admission related queries : 7009969253,9814406986<br>
        Email Id : kmvoffice1886@gmail.com,kmvjalandhar@yahoo.com
    </div> 
 </div>
 <nav>
    <a href="home.php">About</a>
    <a href="parking.php">Parking Rules</a>
    <a href="contact.php">Contact</a>
    <a href="login.php" class="btn login">Login</a>
   <a href="role.php" class="btn register">Register</a>
 </nav>
</header>
  <div class="second-header"> KMV Parking Management</div>
   <section class="hero"></section>
   <div class="notice-bar">
     <p>Welcome to KMV Parking Management System | Follow parking rules | Park only in allotted area | Helmet mandatory for two-wheelers | kmvoffice1886@gmail.com</p>
   </div>

   <section class="cards">

    <div class="card">
      <h3>🚫 Parking Rules</h3>
      <p>Follow college parking rules for smooth parking management.</p>
      <a href="parking.php" class="btn login1">View Rules</a>
    </div>

    <div class="card">
      <h3>ℹ️ About System</h3>
      <p>This system manages vehicle entry, exit, and parking slots.</p>
      <a href="home.php" class="btn login1">Read More</a>
    </div>

    <div class="card">
      <h3>📞 Contact Us</h3>
      <p>For any parking related issue, contact admin.</p>
      <a href="contact.php" class="btn login1">Contact Now</a>
    </div>
    
   </section>

  <section class="features">
   <h2>Why Use Our Parking System?</h2>
   <div class="feature-box">
    <div class="feature">📝 Easy To Check Entry & Exit</div>
    <div class="feature">🔐 Safe & Secure Parking</div>
    <div class="feature">📝 Easy Online Registration</div>
   </div>
  </section>

  <section class="auth">
   <h2>Register / Login</h2>
   <p>Students & Staff can manage parking online</p>
   <a href="login.php" class="btn login1">Login</a>
   <a href="role.php" class="btn register1">Register</a>
  </section>
<footer>
  <p> © KMV Parking Management </p>
</footer>
</body>
</html>