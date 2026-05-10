<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $job_title = trim($_POST['job_title']);
    $salary = $_POST['salary'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];

    // ቫሊዴሽን
    if (empty($full_name) || empty($job_title) || $salary < 1000) {
        $_SESSION['error'] = "እባክዎ ሁሉንም መረጃዎች በትክክል ይሙሉ!";
        header("Location: add-employee.php");
        exit();
    }

    $full_name = mysqli_real_escape_string($conn, $full_name);
    $job_title = mysqli_real_escape_string($conn, $job_title);

    // --- የፋይል መጫኛ ክፍል (Photo & CV) ---
    $upload_dir = "uploads/";
    
    // ፎቶውን የማስተናገድ ክፍል
    $photo_name = $_FILES['emp_photo']['name'];
    $final_photo = "default.png"; // ፎቶ ካልተመረጠ የሚቀመጥ
    if (!empty($photo_name)) {
        $final_photo = time() . "_photo_" . basename($photo_name);
        move_uploaded_file($_FILES['emp_photo']['tmp_name'], $upload_dir . $final_photo);
    }

    // CV (PDF) የማስተናገድ ክፍል
    $cv_name = $_FILES['emp_cv']['name'];
    $final_cv = ""; // CV ከሌለ ባዶ ይሆናል
    if (!empty($cv_name)) {
        $final_cv = time() . "_cv_" . basename($cv_name);
        move_uploaded_file($_FILES['emp_cv']['tmp_name'], $upload_dir . $final_cv);
    }
    // ---------------------------------------

    // SQL Query (አዲሶቹን ፊልዶች ጨምሬዋለሁ)
    $sql = "INSERT INTO employees (full_name, job_title, gender, age, phone, salary, status, photo, cv) 
            VALUES ('$full_name', '$job_title', '$gender', '$age', '$phone', '$salary', 'Active', '$final_photo', '$final_cv')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "ሰራተኛው በትክክል ተመዝግቧል!";
        header("Location: employees-list.php");
    } else {
        $_SESSION['error'] = "የዳታቤዝ ስህተት፡ " . mysqli_error($conn);
        header("Location: add-employee.php");
    }
}
?>