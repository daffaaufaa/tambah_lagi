<?php
include "koneksi.php";
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AZFATICKET.XXI</title>
    <!-- ===== FONT AWESOME ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== GLOBAL STYLES & VARIABLES ===== */
        :root {
            --primary: #e63946; /* Modern red */
            --secondary: #f1faee; /* Soft white */
            --accent: #a8dadc; /* Soft teal for accents */
            --dark: #1d3557; /* Dark blue for text */
            --light: #ffffff; /* Pure white */
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--secondary);
            color: var(--dark);
            overflow-x: hidden;
        }

       /* === NAVBAR === */
    header {
      background-color: #c62828;
      color: white;
      padding: 25px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-radius: 0 0 50px 50px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      animation: navFadeIn 1s ease-in-out;
    }

    @keyframes navFadeIn {
      0% {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .logo {
      display: flex;
      align-items: center;
      font-weight: bold;
      font-size: 28px;
    }

    .logo img {
      margin-right: 10px;
      height: 50px;
      width: auto;
    }

    nav a {
      margin: 0 18px;
      text-decoration: none;
      color: white;
      font-weight: bold;
      font-size: 18px;
      position: relative;
      transition: all 0.4s ease;
    }

    nav a::after {
      content: '';
      display: block;
      width: 0;
      height: 2px;
      background: white;
      transition: width 0.3s;
      position: absolute;
      bottom: -5px;
      left: 0;
    }

    nav a:hover::after {
      width: 100%;
    }

    nav a:hover {
      transform: scale(1.1);
    }

    .profile img {
      width: 50px;
      height: 50px;
      background-size: contain;
      border-radius: 50%;
      cursor: pointer;

    }
    .profile a{
      text-decoration: none;
    }

    .dropdown {
      position: absolute;
      top: 65px;
      right: 0;
      background: rgba(255,255,255,0.9);
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      backdrop-filter: blur(8px);
      padding: 10px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: 0.3s ease;
      z-index: 100;
    }

    .dropdown.active {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown button {
      display: block;
      background: linear-gradient(to right, #ff8a80, #ff5252);
      color: white;
      font-size: 18px;
      font-weight: 500;
      padding: 12px 20px;
      margin: 10px 0;
      width: 200px;
      border: none;
      border-radius: 12px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .dropdown button:hover {
      background: linear-gradient(to right, #ff1744, #e53935);
      transform: scale(1.05);
    }

        /* ===== MAIN LOGIN SECTION ===== */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 90px);
            padding: 40px 20px;
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .login-box {
            display: flex;
            flex-direction: column;
            background: var(--light);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow);
            max-width: 500px;
            width: 100%;
            position: relative;
            transition: transform 0.5s ease;
        }
        
        .login-box:hover {
            transform: translateY(-10px);
        }
        
        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 65%, rgba(230, 57, 70, 0.1) 100%);
            z-index: 0;
        }
        
        /* ===== LOGO SECTION ===== */
        .logo-section {
            padding: 30px;
            background: linear-gradient(135deg, var(--primary) 0%, #c1121f 100%);
            color: var(--light);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .logo-section::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(30deg);
            animation: shine 8s infinite linear;
        }
        
        @keyframes shine {
            0% { transform: rotate(30deg) translateX(-100%); }
            100% { transform: rotate(30deg) translateX(100%); }
        }
        
        .logo-section img {
            height: 80px;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .logo-section h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .logo-section p {
            font-size: 1rem;
            letter-spacing: 1px;
            opacity: 0.9;
        }
        
        /* ===== LOGIN FORM SECTION ===== */
        .login-form {
            padding: 40px 30px;
            background: var(--light);
            position: relative;
            z-index: 1;
        }
        
        .login-form h3 {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--primary);
            position: relative;
            display: inline-block;
            text-align: center;
            width: 100%;
        }
        
        .login-form h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--primary);
        }
        
        .login-form form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .input-group {
            position: relative;
        }
        
        .login-form input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: none;
            border-bottom: 2px solid #ddd;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: transparent;
        }
        
        .login-form input:focus {
            border-bottom-color: var(--primary);
            outline: none;
        }
        
        .login-form input::placeholder {
            color: #aaa;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            transition: all 0.3s ease;
        }
        
        .login-form input:focus + i {
            color: var(--primary);
        }
        
        .login-form button {
            background: linear-gradient(135deg, var(--primary) 0%, #c1121f 100%);
            color: var(--light);
            border: none;
            padding: 15px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.4);
        }
        
        .login-form button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(230, 57, 70, 0.6);
        }
        
        .forgot {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .forgot::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--primary);
            transition: width 0.3s ease;
        }
        
        .forgot:hover::after {
            width: 100%;
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .login-box {
                max-width: 100%;
            }
            
            .logo-section, .login-form {
                padding: 30px 20px;
            }
            
            nav {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER SECTION -->
    <header>
        <div class="logo">
            <img src="logo_web.png" alt="AZFATICKET Logo">
            AZFATICKET.XXI
        </div>
        <nav>
            <a href="home.php">MOVIE</a>
            <a href="cinema.php">CINEMA</a>
            <a href="contact_azfa.php">CONTACT</a>
        </nav>
        <div class="profile" onclick="toggleDropdown()">
        <img src="userputih.jpg" alt="">
        <div class="dropdown" id="dropdownMenu">
            <?php if(isset($_SESSION['username'])){ ?>
                <a href="profil_azfa.php"><button>Profil <?= $_SESSION['username'] ?></button></a>
                <a href="logout.php"><button>Logout</button></a>
            <?php }else{ ?>
                <a href="login.php"><button>Sign In</button></a>
                <a href="register.php"><button>Sign Up</button></a> 
            <?php } ?>
        </div>
        
    </header>
    <script>
    function toggleDropdown() {
      document.getElementById("dropdownMenu").classList.toggle("active");
    }

    window.onclick = function(e) {
      if (!e.target.closest('.profile')) {
        document.getElementById("dropdownMenu").classList.remove("active");
      }
    }
  </script>

    <!-- LOGIN SECTION -->
    <div class="login-container">
        <div class="login-box">
            <!-- LOGO SECTION -->
            <div class="logo-section">
                <img src="logo_web.png" alt="AZFATICKET Logo">
                <h2>AZFATICKET.XXI</h2>
                <p>CITY MALL</p>
            </div>

            <!-- LOGIN FORM SECTION -->
            <div class="login-form">
                <h3>FORGET PASSWORD</h3>
                <form action="proses_forget.php" method="post">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="new_password" placeholder="Password 1" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" placeholder="password 2" required>
                    </div>
                    <button type="submit">CONFIRM</button>
                    </form>
            </div>
        </div>
    </div>
</body>
</html>