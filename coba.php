<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Popup Gambar</title>
  <style>
    .popup {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.7);
    }
    .popup-content {
      position: relative;
      margin: 10% auto;
      padding: 20px;
      width: 60%;
      background: white;
      border-radius: 10px;
      text-align: center;
    }
    .popup-content img {
      max-width: 100%;
      height: auto;
    }
    .close {
      position: absolute;
      top: 10px; right: 20px;
      font-size: 20px;
      cursor: pointer;
      color: #333;
    }
  </style>
</head>
<body>

<!-- Link untuk melihat gambar -->
<a href="#" onclick="showPopup('bukti_pembayaran/<?= $payments['mtd_image'] ?>')">View</a>

<!-- Popup -->
<div id="imagePopup" class="popup" onclick="hidePopup()">
  <div class="popup-content" onclick="event.stopPropagation()">
    <span class="close" onclick="hidePopup()">&times;</span>
    <img id="popupImg" src="" alt="Gambar">
  </div>
</div>

<script>
  function showPopup(src) {
    document.getElementById('popupImg').src = src;
    document.getElementById('imagePopup').style.display = 'block';
  }

  function hidePopup() {
    document.getElementById('imagePopup').style.display = 'none';
  }
</script>

</body>
</html>
