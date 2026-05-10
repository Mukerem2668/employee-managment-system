<?php
include('db.php');
date_default_timezone_set('Africa/Addis_Ababa');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $today = date('Y-m-d');
    $current_time = date('H:i:s');
    $statuses = $_POST['status'];

    foreach ($statuses as $emp_id => $status) {
        // 1. መጀመሪያ ይህ ሰራተኛ ዛሬ ተመዝግቧል ወይ ብሎ ቼክ ያደርጋል
        $check_query = "SELECT * FROM attendance WHERE employee_id = '$emp_id' AND attendance_date = '$today'";
        $check_res = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_res) > 0) {
            // 2. ካለ (Already exists) - ሁኔታውንና ሰዓቱን ያድሳል (Update)
            $update_sql = "UPDATE attendance 
                           SET status = '$status', check_in_time = '$current_time' 
                           WHERE employee_id = '$emp_id' AND attendance_date = '$today'";
            mysqli_query($conn, $update_sql);
        } else {
            // 3. ከሌለ (New record) - አዲስ ያስገባል (Insert)
            $insert_sql = "INSERT INTO attendance (employee_id, attendance_date, status, check_in_time) 
                           VALUES ('$emp_id', '$today', '$status', '$current_time')";
            mysqli_query($conn, $insert_sql);
        }
    }
    
    header("Location: attendance_list.php?success=1");
    exit();
}
?>