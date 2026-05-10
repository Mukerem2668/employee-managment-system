<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS - Welcome</title>
    <style>
        /* --- 1. Basic Setup --- */
       
        body {
            /* ምስሉ image.jpg መሆኑን አረጋግጥ */
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('images.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
        }

        /* --- 2. Main Container --- */
        .welcome-box {
            text-align: center;
            padding: 40px;
            width: 70%;
            /* ለሳጥኑ የኋላ ጥቁር ጥላ በመስጠት ጽሁፉን ማጉላት */
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* --- 3. Typography (የጽሁፍ ስታይል) --- */
        h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 800;
        }

        .amharic{
            display: block;
            font-size: 28px;
            color: #3498db; /* ደማቅ ሰማያዊ */
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            font-size: 23px;
            line-height: 1.6;
            margin-bottom: 35px;
            color: #ecf0f1;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* --- 4. Button Style (ያለ ቡትስትራፕ የተሰራ) --- */
        .login-button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 18px 45px;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 50px;
            transition: all 0.4s ease;
            border: 2px solid #3498db;
            text-transform: uppercase;
        }
.amharic-pa {
          display: block;
            font-size: 23px;
            color: #3498db; /* ደማቅ ሰማያዊ */
            margin-bottom: 20px;
            font-weight: bold;
}
        .login-button:hover {
            background-color: transparent;
            color: #ffffff;
            border-color: #ffffff;
            transform: scale(1.05);
        }

        /* --- 5. Responsive (ለስልክ ማስተካከያ) --- */
        @media (max-width: 768px) {
            h1 { font-size: 2rem; }
            .amharic-title { font-size: 1.5rem; }
            p { font-size: 1rem; }
            .login-button { padding: 12px 30px; font-size: 1rem; }
        }
    </style>
</head>
<body>

    <div class="welcome-box">
      <h1 class="fw-bold">Welcome to Employee Management System</h1>
        <span class="amharic">እንኳን ወደ ሰራተኞች አስተዳደር ሲስተም በደህና መጡ!</span>
          <p>
            An integrated solution to manage employee records, salaries, and performance efficiently.
        </p>
        <p  class="amharic-pa">
            የሰራተኞችዎን መረጃ በዘመናዊ መንገድ ለመያዝ፣ ለመቆጣጠር እና ሪፖርቶችን ለማውጣት 
            የሚያስችል አስተማማኝ ሶፍትዌር።
</p>
        <div class="login-button">
            <a href="login.php" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> ወደ ሲስተሙ ግባ / Login Here
            </a>
    </div>

</body>
</html>