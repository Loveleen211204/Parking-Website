<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parking Rules | Activa Parking System</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #f6f2ef;
    }
    .sub-header {
        text-align: center;
        padding: 10px;
        background: #9b2c3b;
        color: #fff;
        font-size: 14px;
    }

    .container {
        padding: 20px;
        max-width: 1200px;
        margin: auto;
    }
    /* Horizontal Cards */
    .card-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card h3 {
        margin-top: 0;
        color: #7b1f2a;
        border-bottom: 2px solid #7b1f2a;
        padding-bottom: 5px;
    }

    .icon {
        font-size: 26px;
        margin-right: 8px;
    }

    .card ul {
        padding-left: 20px;
    }

    .card ul li {
        margin-bottom: 8px;
    }

    /* Accordion */
    .accordion {
        margin-top: 30px;
    }

    .accordion-item {
        background: #fff;
        border-radius: 10px;
        margin-bottom: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .accordion-header {
        background: #7b1f2a;
        color: #fff;
        padding: 15px;
        cursor: pointer;
        font-weight: bold;
    }

    .accordion-body {
        display: none;
        padding: 15px;
        background: #fafafa;
    }
    .note {
        background: #fff;
        border-left: 8px solid #7b1f2a;
        border-radius: 10px;
        padding: 14px 16px;
        margin-top: 20px;
        font-size: 14px;
    }

    .footer {
        text-align: center;
        padding: 15px;
        background: #7b1f2a;
        color: #fff;
        margin-top: 30px;
    }
    .topbar {
        background: #7b1f2a;
        color: white;
        padding: 13px 0;
    }

    .topbar-inner {
        position: relative;
        display: flex;
        align-items: center;
        padding-left: 10px;
    }

    .title {
       position: absolute;
       left: 50%;
       transform: translateX(-50%);
       font-size: 22px;
       font-weight: bold;
    }
</style>
</head>
<body>
<div class="topbar">
  <div class="topbar-inner">
    <a href="main.php" class="btn btn-light btn-sm">
        <i class="fa-solid fa-house"></i> Home
    </a>
    <div class="title">🚦 Parking Management</div>
  </div>
</div>
<div class="sub-header">🅿️ Parking Rules & Guidelines - Kanya Maha Vidyalaya Campus</div>
<div class="container">
    <div class="card-row">
        <div class="card">
            <h3><span class="icon">🏍️</span>Types of Vehicles Allowed</h3>
            <ul>
                <li>Two-Wheelers: Activa,Bikes</li>
                <li>Four-Wheelers: Cars </li>
                <li>No heavy vehicles allowed</li>
            </ul>
        </div>

        <div class="card">
            <h3><span class="icon">🅿️</span>Parking Areas</h3>
            <ul>
                <li>Type A: Two-Wheeler Parking Zone</li>
                <li>Type B: Four-Wheeler Parking Zone</li>
                <li>Park only in marked slots</li>
                <li>No parking on pathways</li>
                <li>Do not block emergency exits</li>
            </ul>
        </div>

        <div class="card">
            <h3><span class="icon">⏱️</span>Entry & Exit Rules</h3>
            <ul>
                <li>Login/Scan ID before entry</li>
                <li>IN time mandatory</li>
                <li>OUT time mandatory</li>
                <li>Entry during college hours only</li>
                <li>Follow security instructions</li>
            </ul>
        </div>
    </div>

    <div class="card-row" style="margin-top:20px;">
        <div class="card">
            <h3><span class="icon">🛡️</span>Safety Guidelines</h3>
            <ul>
                <li>Drive slowly inside campus</li>
                <li>Wear helmet</li>
                <li>Lock your vehicle</li>
                <li>No loud horns</li>
                <li>Do not leave valuables</li>
            </ul>
        </div>

        <div class="card">
            <h3><span class="icon">🪪</span>Required Documents</h3>
            <ul>
                <li>Valid Driving License</li>
                <li>College ID Card</li>
            </ul>
        </div>

        <div class="card">
            <h3><span class="icon">🎓</span>Student Responsibilities</h3>
            <ul>
                <li>Register vehicle on portal</li>
                <li>One vehicle per student</li>
                <li>Maintain discipline</li>
                <li>Report suspicious activity</li>
            </ul>
        </div>
    </div>

    <!-- Accordion Section -->
    <div class="accordion">
        <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">🚫 Prohibited Activities</div>
            <div class="accordion-body">
                <ul>
                    <li>No rash driving</li>
                    <li>Follow one-way directions</li>
                    <li>No stopping near main gates</li>
                </ul>
            </div>
        </div>

        <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">🧑‍💻 System Usage Rules</div>
            <div class="accordion-body">
                <ul>
                    <li>Do not share login credentials</li>
                    <li>Enter correct IN/OUT time</li>
                    <li>System misuse may block account</li>
                    <li>Admin monitors activities</li>
                </ul>
            </div>
        </div>

        <div class="accordion-item">
            <div class="accordion-header" onclick="toggleAccordion(this)">🚨 Emergency & Help Desk</div>
            <div class="accordion-body">
                <ul>
                    <li>Contact parking supervisor</li>
                    <li>Emergency numbers </li>
                    <li>First-aid available</li>
                    <li>Report accidents immediately</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="note">
        ℹ️ These rules help maintain discipline and safety inside the campus.
    </div>
</div>
<div class="footer">
     © KMV Parking Management 
</div>
<script>
function toggleAccordion(element) {
    let body = element.nextElementSibling;
    body.style.display = body.style.display === "block" ? "none" : "block";
}
</script>
</body>
</html>