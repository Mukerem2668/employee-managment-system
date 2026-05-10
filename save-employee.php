<?php
session_start();
include('db.php');

// ሎጊን ካላደረገ መግባት አይችልም
if(!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ከፎርሙ የመጡ መረጃዎችን መቀበል
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender    = mysqli_real_escape_string($conn, $_POST['gender']);
    $salary    = mysqli_real_escape_string($conn, $_POST['salary']);
    $status    = mysqli_real_escape_string($conn, $_POST['status']);

    // --- የፎቶ አያያዝ ክፍል ---
    $photo_name = $_FILES['emp_photo']['name'];
    $tmp_name   = $_FILES['emp_photo']['tmp_name'];
    $error      = $_FILES['emp_photo']['error'];
    
    $upload_dir = "uploads/";

    // የ uploads ፎልደር ከሌለ እንዲፈጠር ማድረግ
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if ($photo_name) {
        // የፋይሉን አይነት መለየት (jpg, png, etc.)
        $file_ext = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));
        $allowed_ext = array("jpg", "jpeg", "png", "gif");

        if (in_array($file_ext, $allowed_ext)) {
            // ለፎቶው ልዩ ስም መስጠት
            $new_photo_name = time() . "_" . $photo_name;
            $upload_path = $upload_dir . $new_photo_name;

            // ፋይሉን ወደ ፎልደሩ ማንቀሳቀስ
            if (move_uploaded_file($tmp_name, $upload_path)) {
                $final_photo = $new_photo_name;
            } else {
                echo "ፎቶውን መጫን አልተቻለም/Error uploading photo.";
                exit();
            }
        } else {
            echo "ያልተፈቀደ የፋይል አይነት/Invalid file type.";
            exit();
        }
    } else {
        // ፎቶ ካልተመረጠ ነባሪ (default) ፎቶ መጠቀም
        $final_photo = "default.png"; 
    }

    // --- ዳታቤዝ ውስጥ ማስገባት ---
    $sql = "INSERT INTO employees (full_name, email, phone, gender, salary, status, photo) 
            VALUES ('$full_name', '$email', '$phone', '$gender', '$salary', '$status', '$final_photo')";

    if (mysqli_query($conn, $sql)) {
        // ከተመዘገበ በኋላ ወደ ዝርዝር ገጽ ይመለስ
        header("Location: employees-list.php?msg=success");
    } else {
        echo "ስህተት ተከስቷል: " . mysqli_error($conn);
    }
}
?>