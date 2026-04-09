<html>
<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
 <meta charset="UTF-8">
 <title> Home Page </title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f6f2ef;
        }
        /* Header */
        header {
            background-color: #7b1e2b;
            padding: 15px 0;
        }
        header h1 {
            font-size: 22px;
            margin: 0;
        }
        /* Hero Section */
        .hero {
            padding: 40px;
            text-align: center;
            background-image: url("https://static.vecteezy.com/system/resources/previews/002/100/079/large_2x/blurred-car-parking-lot-with-many-cars-abstract-background-free-photo.jpg");
            background-size: cover;       /* image covers full area */
            background-position: center;  /* center image */
            background-repeat: no-repeat;
            height: 300px; /*increase image height*/
            max-width: 100%;
        }
        .hero h2 {
            font-size: 30px;
            color: #7b1e2b;
        }
        .hero p {
            font-size: 16px;
            color: #333;
            max-width: 800px;
            margin: auto;
        }
        /* Section */
        .section {
            padding: 40px 60px;
        }

        .section h2 {
            color: #7b1e2b;
            margin-bottom: 20px;
        }
        /* Features */
        .features {
            display: flex;
            gap: 20px;
        }
        .feature-box {
           background-color: #ffffff;
           padding: 20px;
           border-radius: 8px;
           flex: 1;
           display: grid;
           grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
           gap: 20px;
           margin-top: 20px;
           border-left: 6px solid #7b1e2b;
           transition: 0.3s;
           box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .feature-box:hover {
           transform: translateY(-8px);
           box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        /* Parking Areas */
        .parking {
            display: flex;
            gap: 20px;
        }
        .parking-box {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
            border-left: 6px solid #7b1e2b;
            transition: 0.3s;
        }
        .parking-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        /* Cards Design */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        } 
        .card-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
            border-left: 5px solid #7b1e2b;
        }
        .card-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .card-box h3 {
            color: #7b1e2b;
            margin-bottom: 10px;
        }
        /* Footer */
        footer {
            background-color: #7b1e2b;
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 30px;
        }
 
    </style>
</head>
<body>
<header class="d-flex align-items-center px-4">
    <a href="main.php" class="btn btn-light btn-sm me-3">
        <i class="fa-solid fa-house me-1"></i> Home
    </a>
    <h1 class="m-0 text-white">Vehicle Parking Management</h1>
</header>

<!-- Introduction -->
<section class="hero">
    <h2>Welcome to College Vehicle Parking Management </h2>
    <p>
        This system is designed to manage student vehicle parking inside the college campus.
        It helps in registering student vehicles, monitoring entry and exit time,and ensuring secure and organized parking for both two-wheelers and four-wheelers.
    </p>
</section>

<!-- Features -->
<section class="section">
    <h2>Feature Overview</h2>
    <div class="features">
        <div class="feature-box">
            <h3>Student Registration</h3>
            <p>Register student vehicle details securely with verification.</p>
        </div>
        <div class="feature-box">
            <h3>Complaint & Support System </h3>
            <p>Student can report parking issues or vehicle problems online.</p>
        </div>
        <div class="feature-box">
            <h3>Entry & Exit Tracking</h3>
            <p>Automatic recording of entry and exit time of vehicles.</p>
        </div>
    </div>
</section>

<!-- Parking Areas -->
<section class="section">
    <h2>Parking Areas</h2>
    <div class="parking">
        <div class="parking-box">
            <h3>Type A – Two Wheeler Parking</h3>
            <p>
                This area is reserved for two-wheelers such as Activa, bikes, and scooters.
                Only registered student vehicles are allowed.
            </p>
        </div>
        <div class="parking-box">
            <h3>Type B – Four Wheeler Parking</h3>
            <p>
                This area is reserved for four-wheelers such as cars.
                Parking slots are limited and monitored by the admin.
            </p>
        </div>
    </div>
</section>

<!-- Objectives -->
<section class="section">
    <h2>Objective of the Project</h2>
    <ul>
        <li>To provide a systematic and organized parking system inside the college campus.</li>
        <li>To maintain records of student vehicles. </li>
        <li>To track vehicle entry and exit time for security purposes.</li>
        <li>To reduce manual paperwork and human errors.</li>
        <li>To ensure safe and secure parking for students and staff.</li>
    </ul>
</section>

<!-- Benefits -->
<section class="section">
    <h2>Benefits of the Project</h2>
    <ul>
        <li>Helps students to easily register their vehicles online.</li>
        <li>Improves security by maintaining vehicle entry and exit records.</li>
        <li>Helps college administration in better parking management.</li>
        <li>Saves time and reduces manual work for security staff.</li>
    </ul>
</section>

<!-- Benefits Section -->
<section class="section">
    <h2>Benefits of the System</h2>
    <div class="card-container">
        <div class="card-box">
            <h3>Benefits to College</h3>
            <ul>
                <li>Reduces manual paperwork.</li>
                <li>Better monitoring of campus vehicles.</li>
                <li>Saves time and manpower.</li>
                <li>Improves campus security.</li>
                <li>Digital record management.</li>
            </ul>
        </div>
        <div class="card-box">
            <h3>Benefits to Students</h3>
            <ul>
                <li>Easy online vehicle registration.</li>
                <li>Fast entry and exit process.</li>
                <li>Secure parking system.</li>
                <li>No manual forms required.</li>
                <li>Organized parking areas.</li>
            </ul>
        </div>
    </div>
</section>
<footer>
    © KMV Parking Management 
</footer>
</body>
</html>