<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ከፎርም የመጣ ዳታ
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // አድሚኑን መፈለግ
    $query = "SELECT * FROM admins WHERE username = '$user' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $db_pass = $row['password'];

        // ቼክ ማድረግ (በሀሽ ወይም በቀጥታ)
        if (password_verify($pass, $db_pass) || $pass === $db_pass) {
            $_SESSION['admin'] = $row['username'];
            
            // የፋይል ስምህን እዚህ ጋር አረጋግጥ (dashboard.php መሆኑን)
            header("Location: dashboared.php"); 
            exit();
        } else {
            header("Location: login.php?error=የተሳሳተ የይለፍ ቃል!");
            exit();
        }
    } else {
        header("Location: login.php?error=ተጠቃሚው አልተገኘም!");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>2