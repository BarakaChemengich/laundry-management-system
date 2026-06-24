<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WashEase - Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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
    background:#f5f7fb;
}

/* SMALLER CARD */
.login-container{
    width:100%;
    max-width:300px;
    padding:16px;
    background:white;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* LOGO */
.logo{
    text-align:center;
    margin-bottom:8px;
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

.logo h1{
    margin-top:6px;
    font-size:18px;
}

.logo span{
    color:#2563eb;
}

/* TITLE */
.title{
    text-align:center;
    margin-bottom:10px;
}

.title h2{
    font-size:18px;
    margin-bottom:4px;
}

.title p{
    font-size:11px;
    color:#64748b;
}

/* INPUT */
.input-group{
    margin-bottom:10px;
}

.input-group label{
    font-size:11px;
    color:#475569;
    margin-bottom:4px;
    display:block;
}

.input-group input{
    width:100%;
    padding:8px;
    border:1px solid #dbe2ea;
    border-radius:8px;
    font-size:12px;
}

/* OPTIONS */
.options{
    display:flex;
    justify-content:space-between;
    font-size:11px;
    margin-bottom:10px;
}

/* BUTTON */
.login-btn{
    width:100%;
    padding:9px;
    background:#0f172a;
    color:white;
    border:none;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
}

/* DIVIDER */
.divider{
    text-align:center;
    margin:12px 0;
    font-size:11px;
    color:#94a3b8;
}

/* SOCIAL */
.social-btn{
    width:100%;
    padding:8px;
    border:1px solid #dbe2ea;
    background:white;
    border-radius:8px;
    margin-bottom:8px;
    font-size:12px;
}

/* SIGNUP */
.register{
    text-align:center;
    margin-top:10px;
    font-size:11px;
}

.register a{
    color:#2563eb;
    font-weight:600;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="login-container">

    <div class="logo">
        <div class="logo-icon">🧺</div>
        <h1>Wash<span>Ease</span></h1>
    </div>

    <div class="title">
        <h2>Sign In to Your Account</h2>
        <p>Enter your credentials to access your account</p>
    </div>

    <form>

        <div class="input-group">
            <label>Email</label>
            <input type="email" placeholder="email@example.com">
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" placeholder="••••••••">
        </div>

        <div class="options">
            <label><input type="checkbox"> Remember</label>
            <a href="#">Forgot Password?</a>
        </div>

        <button class="login-btn">SIGN IN</button>

        <div class="divider">OR</div>

        <button type="button" class="social-btn"> Google</button>
        <button type="button" class="social-btn">Facebook</button>

        <div class="register">
            Don't have an account? <a href="#">Sign Up</a>
        </div>

    </form>

</div>

</body>
</html>