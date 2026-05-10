<?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>የጥበቃ ዝርዝር/Attendance List</title>
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; padding-top: 30px; }
        .list-container { 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
        }
        .header-section { 
            border-bottom: 2px solid #f8f9fa; 
            margin-bottom: 25px; 
            padding-bottom: 15px; 
        }
        .table { vertical-align: middle; }
        .table thead { background-color: #2c3e50; color: white; border: none; }
        .table-striped tbody tr:nth-of-type(odd) { background-color: rgba(0,0,0,.02); }
        .badge { padding: 8px 12px; border-radius: 6px; font-weight: 500; }
        
        /* ማተሚያ ገጽ ላይ የማይፈለጉ ነገሮች */
        @media print {
            .no-print, .btn, .btn-link { display: none !important; }
            body { background-color: white; padding: 0; }
            .list-container { box-shadow: none; border: none; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="container list-container">
        <!-- የራስጌ ክፍል -->
        <div class="header-section d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold text-dark"><i class="fas fa-clipboard-list text-primary me-2"></i>የጥበቃ ታሪክ/Attendance Records</h3>
                <p class="text-muted mb-0 small">የሰራተኞችን የእለት ተእለት የጥበቃ መዝገብ እዚህ ያገኛሉ</p>
            </div>
            <div class="no-print">
                <a href="attendance.php" class="btn btn-primary shadow-sm me-2">
                    <i class="fas fa-plus-circle"></i> አዲስ መዝግብ
                </a>
                <button class="btn btn-outline-dark shadow-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> አትም (Print)
                </button>
            </div>
        </div>

        <!-- ሰንጠረዥ -->
        <div class="table-responsive">
            <table class="table table-hover table-striped border">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar-alt me-1"></i> ቀን (Date)</th>
                        <th><i class="fas fa-user me-1"></i> የሰራተኛ ስም</th>
                        <th><i class="fas fa-info-circle me-1"></i> ሁኔታ (Status)</th>
                        <th><i class="fas fa-clock me-1"></i> የገቡበት ሰዓት</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SQL Query - 'id' መጠቀሙን አረጋግጫለሁ
                    $query = "SELECT attendance.*, employees.full_name 
                              FROM attendance 
                              JOIN employees ON attendance.employee_id = employees.id 
                              ORDER BY attendance.attendance_date DESC, attendance.id DESC";
                    
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status = $row['status'];
                            // የቀለም ምርጫ
                            $badge_class = ($status == 'Present') ? 'bg-success' : 'bg-danger';
                            $status_text = ($status == 'Present') ? 'መጥቷል/Present' : 'ቀርቷል/Absent';
                            
                            echo "<tr>
                                <td class='fw-bold'>{$row['attendance_date']}</td>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td><span class='badge $badge_class'>$status_text</span></td>
                                <td class='text-muted'>" . ($row['check_in_time'] ?: '---') . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>ምንም አይነት የጥበቃ መረጃ አልተገኘም</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- የታችኛው ክፍል -->
        <div class="mt-4 no-print border-top pt-3">
            <a href="dashboared.php" class="btn btn-link text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> ወደ ዳሽቦርድ ተመለስ
            </a>
        </div>
    </div>

</body>
</html>