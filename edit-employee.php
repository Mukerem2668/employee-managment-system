<?php
include('db.php');
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM employees WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>ሰራተኛ አስተካክል/Update Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .current-files { font-size: 0.85rem; color: #666; margin-bottom: 10px; }
    </style>
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 shadow-sm rounded" style="max-width: 600px;">
        <h3 class="text-center mb-4">የሰራተኛ መረጃ አስተካክል</h3>
        
        <!-- enctype መጨመር በጣም አስፈላጊ ነው -->
        <form action="update_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <!-- የቆዩ ፋይሎችን ስም በ hidden እንይዛለን (አዲስ ካልተመረጠ እንዳይጠፉ) -->
            <input type="hidden" name="old_photo" value="<?php echo $row['photo']; ?>">
            <input type="hidden" name="old_cv" value="<?php echo $row['cv']; ?>">

            <div class="row">
                <div >
                    <label class="form-label">ሙሉ ስም/Fullname</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo $row['full_name']; ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">የስራ መደብ/Job Title</label>
                    <input type="text" name="job_title" class="form-control" value="<?php echo $row['job_title']; ?>" required>
                </div>
<br />
                <div>
                    <label class="form-label">ደመወዝ/Salary</label>
                    <input type="number" name="salary" class="form-control" value="<?php echo $row['salary']; ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">እድሜ/Age</label>
                    <input type="number" name="age" class="form-control" value="<?php echo $row['age']; ?>" required>
                </div>
<br />
                <div class="col-md-6 mb-3">
                    <label class="form-label">ስልክ ቁጥር/Phone</label>
                    <input type="tel" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required>
                </div>
            </div>

            <hr>

            <!-- ፎቶ ማስተካከያ -->
            <div class="mb-3">
                <label class="form-label text-primary">ፎቶ ቀይር/Change Photo</label>
                <input type="file" name="emp_photo" class="form-control" accept="image/*">
                <div class="current-files">አሁን ያለ ፎቶ፡ <?php echo $row['photo']; ?></div>
            </div>

            <!-- CV ማስተካከያ -->
            <div class="mb-3">
                <label class="form-label text-primary">CV ቀይር/Change CV (PDF)</label>
                <input type="file" name="emp_cv" class="form-control" accept=".pdf">
                <div class="current-files">አሁን ያለ CV፡ <?php echo $row['cv']; ?></div>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-3">ለውጦቹን መዝግብ/Update Info</button>
            <a href="employees-list.php" class="btn btn-link w-100 mt-2 text-decoration-none">ተመለስ/Back</a>
        </form>
    </div>
</body>
</html>