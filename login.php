<?php
session_start();

// ቀድሞ ሎጊን ካደረገ በቀጥታ ወደ ዳሽቦርድ ይሂድ
if(isset($_SESSION['admin'])) {
    header("Location: dashboared.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #2c3e50, #3498db); 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            width: 100%; 
            max-width: 400px; 
        }
     .arrow-left {
display: inline-flex;
    align-items: center;
    position: relative;
    width: 30px;
    height: 2px;
    background-color: #ffffff; /* የዘንጉ ቀለም */
    margin-right: 15px;
        .btn-primary {
            background: #3498db;
            border: none;
            padding: 12px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
        <h3 class="fw-bold mb-4">Admin Login</h3>

        <!-- ስህተት ሲኖር የሚታይ መልዕክት -->
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div><?php echo htmlspecialchars($_GET['error']); ?></div>
            </div>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <div class="mb-3 text-start">
             <label class="form-label text-muted" for="mk">Username</label>

                <div class="input-group">

                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>

                    <input type="text" name="username" id="mk" class="form-control" placeholder="መለያ ስም ያስገቡ" required>
                </div>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label text-muted" for="mkl">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="mkl" class="form-control" placeholder="የይለፍ ቃል ያስገቡ" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                ግባ / Login <i class="fas fa-sign-in-alt ms-2"></i>
            </button><br>
            <br>
            <a href="index.php" class="btn btn-primary w-100 rounded-pill shadow-sm">ተመለስ/back</a>
        </form>

        <div class="mt-4">
            <small class="text-muted">Employee Management System &copy; 2026</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>