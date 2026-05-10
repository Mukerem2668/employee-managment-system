<?php
include('db.php');
// አዲስ የሰላምታ ፓስዎርድ መፍጠር (ለምሳሌ፡ admin123)
$hashed_password = password_hash("admin123", PASSWORD_DEFAULT);
$sql = "UPDATE admins SET password='$hashed_password' WHERE username='admin'";

if(mysqli_query($conn, $sql)){
    echo "ፓስዎርዱ በስኬት ተቀይሯል። አሁን በ 'admin123' መግባት ትችላለህ።";
} else {
    echo "ስህተት፡ " . mysqli_error($conn);
}
?>