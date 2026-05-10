<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include('db.php');

date_default_timezone_set('Africa/Addis_Ababa');
$today = date('Y-m-d');
$current_time = date('h:i A');

// 1. ጠቅላላ ሰራተኞች
$total_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM employees");
$total_employees = mysqli_fetch_assoc($total_res)['total'];

// 2. እረፍት ላይ ያሉ
$break_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM employees WHERE status='Break'");
$on_break = mysqli_fetch_assoc($break_res)['total'];

// 3. በስራ ላይ ያሉ
$active_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM employees WHERE status='Active'");
$active_employees = mysqli_fetch_assoc($active_res)['total'];

// 4. ዛሬ የመጡ (Present)
$present_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM attendance WHERE attendance_date='$today' AND status='Present'");
$today_present = mysqli_fetch_assoc($present_res)['total'];

// 5. ዛሬ የቀሩ (Absent)
$absent_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM attendance WHERE attendance_date='$today' AND status='Absent'");
$today_absent = mysqli_fetch_assoc($absent_res)['total'];
?>

<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS Admin - Dashboard</title>
    <!-- Bootstrap & FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Sidebar Styling */
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; }
        .sidebar { height: 100vh; background: #2c3e50; color: white; position: fixed; width: 250px; overflow-y: auto; z-index: 1000; }
        .main-content { margin-left: 250px; padding: 30px; transition: 0.3s; }
        
        .nav-link { color: #ecf0f1 !important; padding: 12px 20px; display: block; text-decoration: none; border-bottom: 1px solid #34495e; transition: 0.3s; font-size: 0.95rem; }
        .nav-link:hover, .nav-link.active { background: #3498db !important; color: white !important; }
        
        /* Card Styling */
        .stat-card { border: none; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s; background: white; }
        .stat-card:hover { transform: translateY(-5px); }
        .action-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); height: 100%; }
        
        /* Badge & Custom Colors */
        .bg-custom-blue { background-color: #3498db; }
        .border-success-custom { border-left: 5px solid #28a745 !important; }
        .border-warning-custom { border-left: 5px solid #ffc107 !important; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
        }

        /* Print Style */
        @media print {
            .sidebar, .no-print, .btn { display: none !important; }
            .main-content { margin-left: 0 !important; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center py-4"><i class="fas fa-users-cog"></i> EMS Admin</h3>
        <nav>
            <a href="dashboard.php" class="nav-link active"><i class="fas fa-tachometer-alt me-2"></i>ዳሽቦርድ/Dashboard</a>
            <a href="employees-list.php" class="nav-link"><i class="fas fa-list me-2"></i> ሰራተኞች ዝርዝር/List</a>
            <a href="add-employee.php" class="nav-link"><i class="fas fa-user-plus me-2"></i> ሰራተኛ መዝግብ/Register</a>
            <hr class="bg-secondary mx-3">
            <a href="attendance.php" class="nav-link"><i class="fas fa-calendar-check me-2"></i> ጥበቃ መዝግብ/Attend</a>
            <a href="attendance_list.php" class="nav-link"><i class="fas fa-history me-2"></i> የጥበቃ ታሪክ/History</a>
            <a href="attendance_report.php" class="nav-link"><i class="fas fa-file-invoice me-2"></i> የጥበቃ ሪፖርት/Report</a>
            <hr class="bg-secondary mx-3">
            <a href="reports.php" class="nav-link"><i class="fas fa-file-alt me-2"></i> ሪፖርት/Report</a>
            <a href="setting.php" class="nav-link"><i class="fas fa-cog me-2"></i> ማስተካከያ/Setting</a>
            <a href="logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i> ውጣ/Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">የአስተዳደር ዳሽቦርድ</h2>
                <div class="text-end">
                    <span class="badge bg-primary p-2 mb-1">እንኳን መጡ፣ <?php echo htmlspecialchars($_SESSION['admin']); ?>!</span><br>
                    <small class="text-muted"><i class="fas fa-clock"></i> ሰዓት፡ <?php echo $current_time; ?></small>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card stat-card p-4 h-100">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white p-3 rounded-circle me-3"><i class="fas fa-users fa-2x"></i></div>
                            <div>
                                <h6 class="text-muted">ጠቅላላ ሰራተኞች</h6>
                                <h3 class="fw-bold mb-0"><?php echo $total_employees; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card stat-card p-4 h-100 border-success-custom">
                        <div class="ms-3">
                            <h6 class="text-muted">በስራ ላይ (Active)</h6>
                            <h3 class="fw-bold mb-0 text-success"><?php echo $active_employees; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card stat-card p-4 h-100 border-warning-custom">
                        <div class="ms-3">
                            <h6 class="text-muted">እረፍት ላይ (Break)</h6>
                            <h3 class="fw-bold mb-0 text-warning"><?php echo $on_break; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Stats -->
            <h5 class="fw-bold mb-3 text-secondary"><i class="fas fa-clipboard-check"></i> የዛሬ ጥበቃ (<?php echo $today; ?>)</h5>
            <div class="row mb-5">
                <div class="col-md-6 mb-3">
                    <div class="card stat-card bg-success text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user-check fa-lg"></i> ዛሬ የመጡ (Present)</span>
                            <h2 class="mb-0"><?php echo $today_present; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card stat-card bg-danger text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user-times fa-lg"></i> ዛሬ የቀሩ (Absent)</span>
                            <h2 class="mb-0"><?php echo $today_absent; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Section -->
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="action-card">
                        <h4 class="fw-bold mb-3">ፈጣን አስተዳደር</h4>
                        <div class="row g-3 mt-2">
                            <div class="col-sm-6">
                                <a href="attendance.php" class="btn btn-info w-100 p-3 text-white">
                                    <i class="fas fa-calendar-plus d-block mb-2"></i> ጥበቃ መዝግብ
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="employees-list.php" class="btn btn-primary w-100 p-3">
                                    <i class="fas fa-users d-block mb-2"></i> ዝርዝር እይ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="action-card text-center no-print">
                        <h5 class="fw-bold mb-4">ሪፖርት/Report</h5>
                        <a href="add-employee.php" class="btn btn-outline-success w-100 mb-3 p-2">
                            <i class="fas fa-plus-circle me-1"></i> አዲስ ሰራተኛ
                        </a>
                        <button class="btn btn-outline-dark w-100 p-2" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> ገጹን አትም
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>