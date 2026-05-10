<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>የሰራተኞች ዝርዝር እና ፍለጋ/search..</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .search-box { max-width: 400px; margin-bottom: 20px; }
        .status-badge { font-size: 0.85rem; padding: 5px 10px; border-radius: 20px; }
        .container {
            width: 90%;
        }
    </style>
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 shadow-sm rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-users text-primary"></i> የሰራተኞች ዝርዝር/list employeers</h2>
        <a href="add-employee.php" class="btn btn-success"><i class="fas fa-plus"></i> አዲስ መዝግብ/New-Register</a>
    </div>

    <!-- የፍለጋ ሳጥን -->
    <form action="" method="GET" class="search-box d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="በስም ወይም በስራ መደብ/name or job-title..." 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">ፈልግ/search</button>
        <?php if(isset($_GET['search'])): ?>
            <a href="employees-list.php" class="btn btn-outline-secondary">ሁሉንም/All</a>
        <?php endif; ?>
    </form>

    <table class="table table-hover border">
        <thead class="table-dark">
            <tr>
                <th>መለያ/ID</th>
                <th>photo</th>
                <th>ሙሉ ስም/Fullname</th>
                <th>የስራ መደብ/Job-Title</th>
                  <th>ጾታ/sex</th>
                       <th>እድሜ/age</th>
                       <th>ስልክ/phone</th>
                <th>ሁኔታ/Status</th>
                <th>ደመወዝ/salary</th>
                <th>cv</th>
                    <th>reg_date</th>
                <th class="text-center">ድርጊት/Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('db.php');

            $search = "";
            if (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $query = "SELECT * FROM employees WHERE full_name LIKE '%$search%' OR job_title LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM employees ORDER BY id ASC";
            }

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // ሁኔታውን ለመለየት
                    $status = $row['status'] ?? 'Active';
                    $badge_class = ($status == 'Active') ? 'bg-success' : 'bg-warning text-dark';
                    $status_text = ($status == 'Active') ? 'በስራ ላይ/active' : 'እረፍት ላይ/break';

                    echo "<tr>
                        <td>#{$row['id']}</td>
                       <td><img src='uploads/{$row['photo']}' style='width:40px; height:40px; border-radius:50%; object-fit:cover;'></td>
                        <td><strong>{$row['full_name']}</strong></td>
                        <td>{$row['job_title']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['phone']}</td>
                        <td><span class='badge $badge_class status-badge'>$status_text</span></td>
                        <td>" . number_format($row['salary']) . " ETB</td>
                        <td><a href='uploads/{$row['cv']}' target='_blank' class='btn btn-sm btn-link'>View CV</a></td>
                           <td>" . date('M d, Y', strtotime($row['reg_date'])) . "</td>

                        <td class='text-center text-nowrap'>
                            <!-- የእረፍት መቀየሪያ ቁልፍ -->
                            "; if($status == 'Active') {
                                echo "<a href='update_status.php?id={$row['id']}&status=Break' class='btn btn-sm btn-outline-info me-1' title='እረፍት/break'>
                                        <i class='fas fa-coffee'></i>
                                      </a>";
                            } else {
                                echo "<a href='update_status.php?id={$row['id']}&status=Active' class='btn btn-sm btn-outline-success me-1' title='ወደ ስራ/active'>
                                        <i class='fas fa-walking'></i>
                                      </a>";
                            }
                    echo "
                            <a href='edit-employee.php?id={$row['id']}' class='btn btn-sm btn-warning me-1'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"እርግጠኛ ነህ/are you sure?\")'>
                                <i class='fas fa-trash'></i>
                            </a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center text-muted'>መረጃ አልተገኘም/not found!</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="mt-3">
        <a href="dashboared.php" class="text-decoration-none"><i class="fas fa-arrow-left"></i> ወደ ዳሽቦርድ ተመለስ/Back</a>
    </div>
</div>

</body>
</html>