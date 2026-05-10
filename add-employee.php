<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee - EMS</title>
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; padding: 40px 15px; }
        .form-container { 
            background: white; 
            padding: 35px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            max-width: 650px; 
            margin: auto; 
        }
        .form-header { border-bottom: 2px solid #f0f0f0; margin-bottom: 25px; padding-bottom: 15px; }
        .label { font-size: 15px; font-weight: 600; color: #444; margin-top: 15px; margin-bottom: 5px; display: block; }
        .form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid #ddd; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2); border-color: #3498db; }
        .error-msg { color: #e74c3c; font-size: 13px; display: none; margin-top: 5px; }
        .btn-register { background: #27ae60; border: none; padding: 12px; border-radius: 8px; font-weight: bold; transition: 0.3s; margin-top: 20px; }
        .btn-register:hover { background: #219150; transform: translateY(-2px); }
        .upload-section { background: #f9f9f9; padding: 15px; border-radius: 10px; margin-top: 20px; border: 1px dashed #ccc; }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header text-center">
            <h3 class="text-primary fw-bold"><i class="fas fa-user-plus me-2"></i>አዲስ ሰራተኛ መዝግብ</h3>
            <p class="text-muted small">ሁሉንም መረጃዎች በትክክል መሙላትዎን ያረጋግጡ</p>
        </div>
        
        <form action="insert_employee.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            
            <!-- ስም -->
            <label for="full_name" class="label">ሙሉ ስም (Full Name)</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="ለምሳሌ፡ ካሳሁን አየለ" required>
            </div>
            <p id="nameError" class="error-msg"><i class="fas fa-exclamation-circle"></i> እባክዎ ትክክለኛ ስም ያስገቡ (ፊደላት ብቻ)</p>

            <!-- የስራ መደብ -->
            <label for="job" class="label">የስራ መደብ (Job Title)</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-briefcase"></i></span>
                <input type="text" name="job_title" id="job" class="form-control" placeholder="ለምሳሌ፡ Manager" required>
            </div>

            <!-- ጾታ እና እድሜ በአንድ ረድፍ -->
            <div class="row">
                <div class="col-md-6">
                    <label for="sex" class="label">ጾታ (Gender)</label>
                    <select name="gender" id="sex" class="form-select">
                        <option value="Male">ወንድ/Male</option>
                        <option value="Female">ሴት/Female</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="age" class="label">እድሜ (Age)</label>
                    <input type="number" id="age" name="age" class="form-control" required min="18" placeholder="18+">
                </div>
            </div>

            <!-- ስልክ እና ደመወዝ -->
            <div class="row">
                <div class="col-md-6">
                    <label for="phone" class="label">ስልክ ቁጥር (Phone)</label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="0911..." required>
                </div>
                <div class="col-md-6">
                    <label for="salary" class="label">ደመወዝ (Salary)</label>
                    <input type="number" id="salary" name="salary" class="form-control" required min="1000" placeholder="Min. 1000">
                </div>
            </div>
            <p id="salaryError" class="error-msg"><i class="fas fa-exclamation-circle"></i> ደመወዝ ከ 1000 በላይ መሆን አለበት</p>

            <!-- የፋይል መጫኛ -->
            <div class="upload-section">
                <label class="label text-success mt-0"><i class="fas fa-image me-1"></i> የሰራተኛው ፎቶ (Image)</label>
                <input type="file" name="emp_photo" class="form-control mb-3" accept="image/*">

                <label class="label text-success mt-0"><i class="fas fa-file-pdf me-1"></i> የሰራተኛው CV (PDF Only)</label>
                <input type="file" name="emp_cv" class="form-control" accept=".pdf">
            </div>

            <button type="submit" class="btn btn-success btn-register w-100 text-white">
                <i class="fas fa-save me-2"></i>መዝግብ/Register
            </button>
            
            <div class="text-center mt-3">
                <a href="dashboared.php" class="text-decoration-none text-muted small">
                    <i class="fas fa-arrow-left me-1"></i> ተመለስ/Back to Dashboard
                </a>
            </div>
        </form>
    </div>

    <script>
    function validateForm() {
        let name = document.getElementById("full_name").value;
        let salary = document.getElementById("salary").value;
        // አማርኛ እና እንግሊዝኛ ስም እንዲቀበል የተስተካከለ Regex
        let namePattern = /^[a-zA-Z\s\u1200-\u137F]+$/; 
        let isValid = true;

        if (!name.match(namePattern)) {
            document.getElementById("nameError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("nameError").style.display = "none";
        }

        if (salary < 1000) {
            document.getElementById("salaryError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("salaryError").style.display = "none";
        }

        return isValid;
    }
    </script>
</body>
</html>