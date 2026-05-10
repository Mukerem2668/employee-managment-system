<?php
session_start();
if(!isset($_SESSION['admin'])) { header("Location: index.php"); }
include('db.php');

// ዳታዎችን ሰብስቦ ማምጣት
$total_emp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM employees"))['c'];
$total_salary = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(salary) as s FROM employees"))['s'];
$male_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as m FROM employees WHERE gender='Male'"))['m'];
$female_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as f FROM employees WHERE gender='Female'"))['f'];

// ደመወዝ በጾታ (ለግራፍ)
$male_sal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(salary) as s FROM employees WHERE gender='Male'"))['s'] ?? 0;
$female_sal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(salary) as s FROM employees WHERE gender='Female'"))['s'] ?? 0;
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>EMS - Visual Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); height: 100%; }
        @media print { .btn, .no-print { display: none !important; } }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h2><i class="fas fa-chart-pie text-primary"></i> የሪፖርት ዳሽቦርድ/Visual Report</h2>
            <div>
                <button onclick="window.print()" class="btn btn-dark"><i class="fas fa-print"></i> አትም/Print</button>
                <a href="dashboared.php" class="btn btn-secondary">ወደ ዳሽቦርድ/Back</a>
            </div>
        </div>

        <!-- ካርዶች -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 bg-primary text-white p-3 shadow-sm">
                    <small>ጠቅላላ ሰራተኞች/Total-employeers</small>
                    <h3 class="fw-bold"><?php echo $total_emp; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-success text-white p-3 shadow-sm">
                    <small>ጠቅላላ ወጪ/Total-cost</small>
                    <h4 class="fw-bold"><?php echo number_format($total_salary); ?> ETB</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-info text-white p-3 shadow-sm">
                    <small>ወንድ/Male</small>
                    <h3 class="fw-bold"><?php echo $male_count; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-warning text-dark p-3 shadow-sm">
                    <small>ሴት/Female</small>
                    <h3 class="fw-bold"><?php echo $female_count; ?></h3>
                </div>
            </div>
        </div>

        <!-- ግራፎች (Charts) -->
        <div class="row g-4">
            <!-- Pie Chart - Gender -->
            <div class="col-md-6">
                <div class="chart-container text-center">
                    <h5 class="mb-4 fw-bold">የጾታ ስርጭት/Gender Distribution</h5>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
            <!-- Bar Chart - Salary -->
            <div class="col-md-6">
                <div class="chart-container text-center">
                    <h5 class="mb-4 fw-bold">የደመወዝ ክፍያ በጾታ/Salary by Gender</h5>
                    <canvas id="salaryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. የጾታ ግራፍ (Pie Chart)
        const ctx1 = document.getElementById('genderChart').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['ወንድ (Male)', 'ሴት (Female)'],
                datasets: [{
                    data: [<?php echo $male_count; ?>, <?php echo $female_count; ?>],
                    backgroundColor: ['#3498db', '#f1c40f'],
                    borderWidth: 1
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        // 2. የደመወዝ ግራፍ (Bar Chart)
        const ctx2 = document.getElementById('salaryChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['ወንድ', 'ሴት'],
                datasets: [{
                    label: 'ጠቅላላ ደመወዝ (ETB)',
                    data: [<?php echo $male_sal; ?>, <?php echo $female_sal; ?>],
                    backgroundColor: ['#2ecc71', '#e67e22'],
                    borderRadius: 10
                }]
            },
            options: { 
                responsive: true, 
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>