<?php
include "koneksi.php";

$id_movies = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM movies WHERE id_movies = $id_movies");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e63946;
            --primary-dark: #c1121f;
            --secondary: #f8f9fa;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        /* === ANIMATIONS === */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                transform: translateY(50px);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        /* === POPUP OVERLAY === */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(8px);
            animation: fadeIn 0.5s ease-out;
        }

        /* === FORM CONTAINER === */
        .popup-form {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s 0.1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            position: relative;
        }

        /* === FORM HEADER === */
        .form-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 25px;
            color: white;
            text-align: center;
            position: relative;
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .form-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        /* === FORM BODY === */
        .form-body {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* === FORM GROUPS === */
        .form-group {
            margin-bottom: 25px;
            position: relative;
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }

        /* Stagger animations */
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }
        .form-group:nth-child(4) { animation-delay: 0.5s; }
        .form-group:nth-child(5) { animation-delay: 0.6s; }
        .form-group:nth-child(6) { animation-delay: 0.7s; }
        .form-group:nth-child(7) { animation-delay: 0.8s; }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
            font-size: 14px;
        }

        /* === INPUT STYLES === */
        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: white;
            font-size: 14px;
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* === RADIO BUTTONS === */
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-option {
            display: flex;
            align-items: center;
        }

        input[type="radio"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #ddd;
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
            cursor: pointer;
            transition: var(--transition);
        }

        input[type="radio"]:checked {
            border-color: var(--primary);
            background-color: var(--primary);
        }

        input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* === CURRENT IMAGE === */
        .current-image {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: var(--gray);
            font-style: italic;
        }

        /* === FILE INPUT === */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-button {
            border: 1px dashed #ddd;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }

        .file-input-button:hover {
            border-color: var(--primary);
            background-color: rgba(230, 57, 70, 0.05);
        }

        .file-input-button i {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
        }

        .file-input-button span {
            color: var(--gray);
            font-size: 14px;
        }

        input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* === SUBMIT BUTTON === */
        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(230, 57, 70, 0.4);
            animation: pulse 1.5s infinite;
        }

        /* === CLOSE BUTTON === */
        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.2);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            z-index: 10;
        }

        .close-btn:hover {
            background-color: rgba(255,255,255,0.3);
            transform: rotate(90deg);
        }

        /* === RESPONSIVE ADJUSTMENTS === */
        @media (max-width: 768px) {
            .popup-form {
                width: 95%;
            }
            
            .form-body {
                padding: 20px;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="popup-overlay">
        <div class="popup-form">
            <button class="close-btn" onclick="window.history.back()">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="form-header">
                <h2 class="form-title">Edit Movie Details</h2>
                <p class="form-subtitle">Update the movie information below</p>
            </div>
            
            <div class="form-body">
                <form action="prs_edit_movies.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id_movies ?>">

                    <div class="form-group">
                        <label for="title">Movie Title</label>
                        <input type="text" name="title" id="title" value="<?= htmlspecialchars($data['title']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Genre</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" name="genre" id="horor" value="horor" <?= ($data['genre'] == 'horor') ? 'checked' : '' ?> required>
                                <label for="horor">Horror</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="genre" id="komedi" value="komedi" <?= ($data['genre'] == 'komedi') ? 'checked' : '' ?>>
                                <label for="komedi">Comedy</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="genre" id="romance" value="romance" <?= ($data['genre'] == 'romance') ? 'checked' : '' ?>>
                                <label for="romance">Romance</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" required><?= htmlspecialchars($data['description']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date" name="release_date" id="release_date" value="<?= $data['release_date'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration (HH:MM)</label>
                        <input type="time" name="duration" id="duration" value="<?= $data['duration'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Movie Poster</label>
                        <div class="file-input-wrapper">
                            <div class="file-input-button">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Click to upload new poster</span>
                                <input type="file" name="poster_image" id="poster_image" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                        <span class="current-image">Current: <?= htmlspecialchars($data['poster_image']) ?></span>
                    </div>

                    <div class="form-group">
                        <label for="max_tayang">Last Showing Date</label>
                        <input type="date" name="max_tayang" id="max_tayang" value="<?= $data['max_tayang'] ?>" required>
                    </div>

                    <button type="submit" name="submit" class="submit-btn">
                        <i class="fas fa-save"></i> Update Movie
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add animation delays to form groups
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${0.2 + (index * 0.1)}s`;
            });
        });
    </script>
</body>
</html>