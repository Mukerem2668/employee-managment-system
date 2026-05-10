<?php
// የዳታቤዝ ግንኙነቱን እናስገባለን
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ከፎርሙ የተላኩ መረጃዎችን በሙሉ መቀበል
    // mysqli_real_escape_string ለደህንነት ሲባል (SQL Injection ለመከላከል) ይጠቅማል
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $job = mysqli_real_escape_string($conn, $_POST['job_title']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    // መረጃውን ለማስተካከያ የሚሆን የ SQL ትዕዛዝ
    $sql = "UPDATE employees SET 
            full_name = '$name', 
            job_title = '$job', 
            salary = '$salary' 
            WHERE id = '$id'";

    // ትዕዛዙን መፈጸም
    if (mysqli_query($conn, $sql)) {
        // በትክክል ከተስተካከለ ወደ ዝርዝር ገጽ ይመልሰን
        header("Location: employees-list.php?status=updated");
        exit();
    } else {
        // ስህተት ካለ መልእክት ያሳየናል
        echo "መረጃውን ማስተካከል አልተቻለም: " . mysqli_error($conn);
    }
} else {
    // በቀጥታ ይህን ፋይል ለመክፈት ከሞከሩ ወደ ዝርዝር ገጽ ይመለሳሉ
    header("Location: employees-list.php");
    exit();
}
?>