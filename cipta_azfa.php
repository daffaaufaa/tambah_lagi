<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - AZFA BIOSKOP</title>
  <style>
    /* RESET */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    /* BACKGROUND PUTIH + GRADIENT LEMBUT */
    body {
      background: linear-gradient(to bottom right, #ffffff, #fff5f5);
      min-height: 100vh;
      padding: 60px 20px;
      color: #800000;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      text-align: center;
      font-size: 3rem;
      margin-bottom: 50px;
      color: #b30000;
      position: relative;
    }

    h1::after {
      content: "";
      display: block;
      width: 100px;
      height: 4px;
      background: #ff4d4d;
      margin: 10px auto 0;
      border-radius: 4px;
    }

    .about-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 50px;
      max-width: 1300px;
      margin: auto;
    }

    .profile-box {
      background: #fffafa;
      border: 2px solid #ffe0e0;
      border-radius: 25px;
      width: 420px;
      padding: 40px 30px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(255, 102, 102, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s;
      animation: floatUp 1s ease forwards;
    }

    .profile-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 30px rgba(255, 102, 102, 0.3);
    }

    @keyframes floatUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .profile-image {
      width: 130px;
      height: 130px;
      margin: 0 auto 20px;
      background-color: #ffe6e6;
      background-image: url('https://via.placeholder.com/130');
      background-size: cover;
      background-position: center;
      border-radius: 50%;
      border: 5px solid #ffcccc;
      animation: pulse 2.5s infinite ease-in-out;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .profile-name {
      font-size: 1.7rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .profile-role {
      font-size: 1.2rem;
      color: #cc0000;
      margin-bottom: 25px;
    }

    .about-button {
      padding: 12px 24px;
      background-color: #ff4d4d;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s;
    }

    .about-button:hover {
      background-color: #e60000;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      .about-container {
        flex-direction: column;
        align-items: center;
      }

      .profile-box {
        width: 90%;
      }
    }
  </style>
</head>
<body>

  <h1>Meet The Creators</h1>

  <div class="about-container">
    <!-- FRONT END -->
    <div class="profile-box">
      <div class="profile-image"></div>
      <div class="profile-name">Daffa Aufaa Pratama Irawan</div>
      <div class="profile-role">Front-End Developer</div>
      <button class="about-button">Tentang Saya</button>
    </div>

    <!-- BACK END -->
    <div class="profile-box">
      <div class="profile-image"></div>
      <div class="profile-name">Aizar faruq Nafiul Umam</div>
      <div class="profile-role">Back-End Developer</div>
      <button class="about-button">Tentang Saya</button>
    </div>
  </div>

</body>
</html>
