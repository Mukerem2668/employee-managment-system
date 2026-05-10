<?php
session_start();
if(!isset($_SESSION['admin'])) { header("Location: index.php"); exit(); }
include('db.php');

$msg = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_user = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $pass = $_POST['password'];
    $admin_now = $_SESSION['admin'];

    // Username validation
$userPattern = "/^[a-zA-Z]+$/";

if(!preg_match($userPattern, $new_user)){
    $errors[] = "የአድሚን ስም ፊደላት መሆን አለበት!";
}
elseif(strlen($new_user) < 4) {
    $errors[] = "የአድሚን ስም ቢያንስ 4 ፊደላት መሆን አለበት!";
}

// Password validation
$pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";

if (!preg_match($pattern, $pass)) {
    $errors[] = "ፓስዎርዱ ደካማ ነው!";
}

// If no errors → update
if (empty($errors)) {

    $new_pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE admins SET username=?, password=? WHERE username=?");
    $stmt->bind_param("sss", $new_user, $new_pass_hashed, $admin_now);

    if($stmt->execute()) {
        $_SESSION['admin'] = $new_user;
        $msg = "<div class='alert alert-success'>Updated successfully!</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Database error!</div>";
    }
}
}
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <title>EMS - Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error-list { font-size: 0.85rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5" style="max-width: 500px;">
        <div class="card p-4 shadow-lg border-0 rounded-4">
            <h3 class="fw-bold text-primary"><i class="fas fa-user-cog"></i> ሲስተም ሴቲንግ/System setting</h3>
            <p class="text-muted small" style=font-size: 20px;>የአድሚን እና የይለፍ ቃል መቀየርያ/Change of username and password</p>
            <hr>

            <!-- የስኬት መልእክት -->
            <?php echo $msg; ?>

            <!-- የስህተት መልእክቶች ዝርዝር -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-warning error-list">
                    <ul class="mb-0">
                        <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" id="settingsForm" onsubmit="return validateSettings()">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="username">የአድሚን ስም/Admin-Name</label>
                    <input type="text" id="username" name="username" class="form-control" 
                           value="<?php echo htmlspecialchars($_SESSION['admin']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold" for="password">አዲስ ፓስዎርድ/New password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="አዲስ ፓስዎርድ ያስገቡ" required>
                    </div>
                    <div id="passHint" class="form-text small mt-2"></div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    <i class="fas fa-save"></i> ለውጦችን መዝግብ/Save Update
                </button>
                
                <a href="dashboared.php" class="btn btn-link w-100 mt-2 text-decoration-none text-secondary">
                    <i class="fas fa-arrow-left"></i> ወደ ዳሽቦርድ ተመለስ/Back
                </a>
            </form>
        </div>
    </div>

    <script>
    function validateSettings() {
        const username = document.getElementById('username').value;
        const pass = document.getElementById('password').value;
        const passPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (username.length < 4) {
            alert("የአድሚን ስም በጣም አጭር ነው!");
            return false;
        }

        if (!passPattern.test(pass)) {
            alert("ፓስዎርዱ መስፈርቱን አያሟላም!\n1. ቢያንስ 8 ርዝመት\n2. ትልቅ እና ትንሽ ፊደል\n3. ቁጥር መያዝ አለበት።");
            return false;
        }
        return true;
    }

    // ፓስዎርድ ሲመታ ወዲያውኑ ጥንካሬውን ለማሳየት (Real-time feedback)
    document.getElementById('password').addEventListener('input', function() {
        const hint = document.getElementById('passHint');
        const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        if (pattern.test(this.value)) {
            hint.innerHTML = "<span class='text-success'><i class='fas fa-check'></i> ጠንካራ ፓስዎርድ ነው!</span>";
        } else {
            hint.innerHTML = "<span class='text-danger'>ደካማ ፓስዎርድ!</span>";
        }
    });
    </script>
</body>
</html>