<?php
include('db.php');

// 1. የቀን ገደብ መቀበያ (ባዶ ከሆነ የዛሬን ቀን ይወስዳል)
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');

// 2. Query - እዚህ ጋር በ 'attendance.employee_id' እና በ 'employees.id' መካከል ግንኙነት ተፈጥሯል
$query = "SELECT attendance.*, employees.full_name, employees.id as emp_id 
          FROM attendance 
          INNER JOIN employees ON attendance.employee_id = employees.id 
          WHERE attendance.attendance_date BETWEEN '$from_date' AND '$to_date'
          ORDER BY attendance.attendance_date DESC";

$result = mysqli_query($conn, $query);

// ስህተት ካለ እንዲያሳየን
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>የጥበቃ ሪፖርት</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } }
        body { background-color: #f8f9fa; }
        .report-header { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container mt-5">
        
        <!-- Filter Section -->
        <div class="report-header no-print">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">ከቀን (From):</label>
                    <input type="date" name="from_date" class="form-control" value="<?php echo $from_date; ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">እስከ ቀን (To):</label>
                    <input type="date" name="to_date" class="form-control" value="<?php echo $to_date; ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2">ሪፖርት አሳይ</button>
                    <button type="button" class="btn btn-success w-100" onclick="window.print()">አትም (Print)</button>
                </div>
            </form>
        </div>

        <!-- Report Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">የሰራተኞች ጥበቃ ሪፖርት</h3>
                    <p class="text-muted">ከቀን <?php echo $from_date; ?> እስከ <?php echo $to_date; ?></p>
                </div>

                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ቀን</th>
                            <th>መለያ (ID)</th>
                            <th>ሙሉ ስም</th>
                            <th>ሁኔታ (Status)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $status_badge = ($row['status'] == 'Present') ? 'bg-success' : 'bg-danger';
                                echo "<tr>
                                        <td>{$row['attendance_date']}</td>
                                        <td>{$row['emp_id']}</td>
                                        <td>{$row['full_name']}</td>
                                        <td><span class='badge $status_badge'>{$row['status']}</span></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>በተመረጠው ቀን ምንም መረጃ አልተገኘም።</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-3 text-end no-print">
            <a href="dashboared.php" class="btn btn-secondary">ወደ ዳሽቦርድ ተመለስ</a>
        </div>
    </div>
</body>
</html>