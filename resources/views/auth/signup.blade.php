<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WashEase - Create Account</title>
     
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#eef3f9;
            padding:20px;
        }

        .container{
            width:100%;
            max-width:390px;
            background:#fff;
            border-radius:24px;
            padding:24px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);
        }
        .logo{
    text-align:center;
    margin-bottom:15px;
}
.logo-icon{
    width:42px;
    height:42px;
    background:#2563eb;
    color:white;
    margin:auto;
    border-radius:14px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:18px;
}
.logo img{
    width:70px;
    height:70px;
    object-fit:contain;
}
        .logo{
            text-align:center;
            margin-bottom:20px;
        }

        .logo h1{
            font-size:24px;
            font-weight:600;
            color:#111827;
            
        }

        .logo span{
            color:#2563eb;
        }

        .title{
            text-align:center;
            margin-bottom:20px;
        }

        .title h2{
            font-size:18px;
            color:#111827;
            margin-bottom:5px;
        }

        .title p{
            color:#6b7280;
            font-size:10px;
        }

        .form-group{
            margin-bottom:12px;
        }

        label{
            display:block;
            margin-bottom:6px;
            font-size:12px;
            font-weight:600;
            color:#374151;
        }

        input,
        select{
            width:100%;
            padding:13px;
            border:1px solid #dbe4f0;
            border-radius:12px;
            outline:none;
            font-size:13px;
            background:white;
        }

        input:focus,
        select:focus{
            border-color:#2563eb;
        }

        .security-box{
    background:linear-gradient(
        180deg,
        #f8fbff 0%,
        #f3f8ff 100%
    );
    border:1px solid #dbeafe;
    border-radius:18px;
    padding:18px;
    margin-top:10px;
}

        .security-box h4{
            color:#111827;
            margin-bottom:12px;
            font-size:14px;
        }

        .note{
            font-size:11px;
            color:#64748b;
            margin-top:8px;
        }

        .checkbox{
            display:flex;
            gap:10px;
            align-items:flex-start;
            margin-bottom:18px;
        }

        .checkbox input{
            width:auto;
            margin-top:4px;
        }

        .checkbox label{
            margin:0;
            font-size:12px;
            font-weight:400;
        }

        .btn{
            width:100%;
            border:none;
            background:#121a34;
            color:white;
            padding:14px;
            border-radius:12px;
            font-weight:600;
            cursor:pointer;
        }

        .divider{
            text-align:center;
            margin:20px 0;
            position:relative;
            color:#94a3b8;
            font-size:12px;
        }

        .divider:before,
        .divider:after{
            content:'';
            position:absolute;
            top:50%;
            width:42%;
            height:1px;
            background:#e5e7eb;
        }

        .divider:before{
            left:0;
        }

        .divider:after{
            right:0;
        }

        .social-btn{
    width:100%;
    padding:12px;
    border:1px solid #e5e7eb;
    border-radius:12px;
    background:white;
    font-weight:500;
    margin-bottom:10px;
    cursor:pointer;
}

.social-btn i{
    margin-right:10px;
}

        .signin-link{
            text-align:center;
            margin-top:15px;
            font-size:13px;
        }

        .signin-link a{
            color:#2563eb;
            text-decoration:none;
            font-weight:600;
        }
        .input-group{
    display:flex;
    align-items:center;
    border:1px solid #dbe4f0;
    border-radius:12px;
    padding:0 14px;
    margin-bottom:15px;
    background:#fff;
}

.input-group i{
    color:#94a3b8;
    font-size:14px;
}

.input-group input{
    border:none;
    outline:none;
    flex:1;
    padding:14px 12px;
    background:transparent;
}
.toggle-password,
.toggle-confirm-password{
    cursor:pointer;
    color:#94a3b8;
    transition:0.3s;
}

.toggle-password:hover,
.toggle-confirm-password:hover{
    color:#2563eb;
}
    </style>
</head>
<body>

<div class="container">

    <div class="logo">
        <div class="logo-icon">🧺</div>
        <h1>Wash <span>Ease</span></h1>
    </div>

    <div class="title">
        <h2>Create Your Account</h2>
        <p>Fill in your details to get started</p>
    </div>

    <form method="POST" action="#">
        @csrf

        <label>Full Name</label>
       <div 
       class="input-group">
    <i class="fa-solid fa-user"></i>
    <input type="text" name="name" placeholder="Enter your full name" required>
</div>
        
      <label>Email Address</label>
        <div class="input-group">
    <i class="fa-solid fa-envelope"></i>
    <input type="email" name="email" placeholder="Enter your email address" required>
</div>
     <label>Phone Number</label>
        <div class="input-group">
    <i class="fa-solid fa-phone"></i>
    <input type="text" name="phone" placeholder="Enter your phone number" required>
</div>
         <label>Password</label>

<div class="input-group">
    <i class="fa-solid fa-lock"></i>

    <input
        type="password"
        id="password"
        name="password"
        placeholder="Create a password"
        required
    >

    <i class="fa-solid fa-eye toggle-password"
       onclick="togglePassword()"></i>
</div>


<label>Confirm Password</label>

<div class="input-group">
    <i class="fa-solid fa-lock"></i>

    <input
        type="password"
        id="confirm_password"
        name="password_confirmation"
        placeholder="Confirm your password"
        required
    >

    <i class="fa-solid fa-eye toggle-confirm-password"
       onclick="toggleConfirmPassword()"></i>
</div>
        <div class="security-box">

            <h4>🔐 Account Security Question</h4>

            <div class="form-group">
                <label>Choose Question</label>

                <select name="security_question" required>
                    <option value="">Select Security Question</option>
                    <option>What was your high school name?</option>
                    <option>What was the name of your first pet?</option>
                    <option>What is your mother's maiden name?</option>
                    <option>What city were you born in?</option>
                    <option>What was your childhood nickname?</option>
                </select>
            </div>

            <div class="form-group">
                <label>Security Answer</label>

                <input
                    type="text"
                    name="security_answer"
                    placeholder="Enter your answer"
                    required
                >
            </div>

            <div class="note">
                This question will be used to recover your account.
            </div>

        </div>

        <div class="checkbox">
            <input type="checkbox" required>
            <label>
                I agree to the Terms of Service and Privacy Policy.
            </label>
        </div>

        <button type="submit" class="btn">
            CREATE ACCOUNT
        </button>

        <div class="divider">OR</div>

       <button type="button" class="social-btn">
    <i class="fa-brands fa-google"></i>
    Continue with Google
</button>

        <button type="button" class="social-btn">
    <i class="fa-brands fa-facebook-f"></i>
    Continue with Facebook
</button>

        <div class="signin-link">
            Already have an account?
            <a href="/">Sign In</a>
        </div>

    </form>

</div>
<script>
function togglePassword() {

    const password = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if (password.type === "password") {

        password.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    } else {

        password.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

function toggleConfirmPassword() {

    const password = document.getElementById("confirm_password");
    const icon = document.querySelector(".toggle-confirm-password");

    if (password.type === "password") {

        password.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    } else {

        password.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>
</body>
</html>