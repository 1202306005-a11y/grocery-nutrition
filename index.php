<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Nutrition - Analisis Gizi</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Poppins:wght@400;700&display=swap');

        * { box-sizing: border-box; }
        
        body { 
            margin: 0; padding: 0; 
            background-color: #a2c9e8; /* Warna biru langit background */
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            height: 100vh;
        }

        /* HEADER COKELAT DENGAN POLA */
        .header {
            background-color: #5b3d36;
            background-image: url('https://www.transparenttextures.com/patterns/food.png');
            padding: 25px 10px;
            text-align: center;
            border-bottom: 6px solid #452b25;
            position: relative;
            z-index: 100;
        }
        .header h1 {
            color: #fff; font-family: 'Montserrat', sans-serif;
            font-size: 45px; margin: 0; text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* LAYER STIKER (Tetap di belakang konten) */
        .sticker-bg {
            position: fixed;
            top: 120px; left: 0; width: 100%; height: calc(100% - 120px);
            z-index: 1;
            pointer-events: none;
        }
        .stiker {
            position: absolute;
            width: 140px;
            filter: drop-shadow(5px 5px 0px white); /* Outline putih khas stiker */
        }

        /* AREA KONTEN UTAMA */
        .content-area {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }

        /* --- DESAIN HALAMAN DASHBOARD (gmbr1.jpg) --- */
        #dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .scanner-container {
            background: white;
            padding: 10px;
            border-radius: 40px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            width: 450px; max-width: 90vw;
            border: 20px solid white;
            overflow: hidden;
            margin-bottom: 20px;
        }
        #reader { width: 100% !important; border: none !important; }

        .input-bar {
            background: white;
            padding: 8px 8px 8px 30px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            width: 500px; max-width: 85vw;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .input-bar input {
            border: none; flex-grow: 1; font-size: 20px; outline: none;
        }
        .btn-cek {
            background-color: #c474df; /* Warna ungu tombol */
            color: black; border: none; padding: 12px 35px;
            border-radius: 15px; font-weight: 800; font-size: 20px; cursor: pointer;
        }

        /* --- DESAIN HALAMAN HASIL (gmbr2.jpg) --- */
        #result-page {
            display: none;
            background-color: #f3f1eb; /* Warna krem cerah */
            width: 95%; max-width: 900px;
            border-radius: 0px; /* Sesuai gambar yang flat ke sisi */
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            overflow: hidden;
            margin-top: 20px;
        }

        .res-top { display: flex; align-items: center; padding: 40px; gap: 30px; }
        .res-img-placeholder {
            background: #b35252; color: white; width: 110px; height: 110px;
            border-radius: 15px; display: flex; align-items: center; justify-content: center;
            text-align: center; font-size: 12px; font-weight: bold; padding: 10px;
        }
        .res-product-name { font-size: 42px; font-weight: 800; text-transform: uppercase; }

        .res-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px; padding: 0 40px 40px;
        }
        .nutri-item {
            background: #b35252; /* Warna merah bata/marun */
            color: white; height: 120px; border-radius: 30px;
            display: flex; flex-direction: column; justify-content: center;
            align-items: center; text-align: center; font-weight: bold;
        }
        .nutri-item span { font-weight: normal; font-size: 14px; margin-top: 5px; opacity: 0.9; }

        .res-footer {
            background: #b35252; color: white; padding: 35px;
        }
        .footer-label {
            font-weight: 800; font-size: 22px; margin-bottom: 15px;
            display: flex; align-items: center; gap: 15px;
        }
        .footer-text { font-size: 17px; line-height: 1.6; opacity: 0.95; }
    </style>
</head>
<body>

<div class="header">
    <h1>GROCERY NUTRITION</h1>
</div>

<div class="sticker-bg">
    <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" class="stiker" style="top: 5%; left: 5%; transform: rotate(-15deg);">
    <img src="https://cdn-icons-png.flaticon.com/512/2405/2405479.png" class="stiker" style="top: 2%; right: 10%; transform: rotate(10deg);">
    <img src="https://cdn-icons-png.flaticon.com/512/3050/3050158.png" class="stiker" style="bottom: 15%; left: 2%; width: 150px;">
    <img src="https://cdn-icons-png.flaticon.com/512/2722/2722527.png" class="stiker" style="bottom: 10%; right: 5%; width: 130px; transform: rotate(-10deg);">
    <img src="https://cdn-icons-png.flaticon.com/512/3143/3143640.png" class="stiker" style="top: 40%; right: 15%; width: 100px; opacity: 0.8;">
</div>

<div class="content-area">
    <div id="dashboard">
        <div class="scanner-container">
            <div id="reader"></div>
        </div>
        <div class="input-bar">
            <input type="text" id="manualCode" placeholder="ketik kode manual">
            <button class="btn-cek" onclick="prosesBarcode(document.getElementById('manualCode').value)">CEK</button>
        </div>
    </div>

    <div id="result-page">
        <div class="res-top">
            <div class="res-img-placeholder" id="pImg">GAMBAR PRODUK</div>
            <div class="res-product-name" id="pNama">NAMA PRODUK</div>
        </div>

        <div class="res-grid">
            <div class="nutri-item">KALORI<br><span id="v1">-</span></div>
            <div class="nutri-item">GARAM<br><span id="v2">-</span></div>
            <div class="nutri-item">GULA<br><span id="v3">-</span></div>
            <div class="nutri-item">PROTEIN<br><span id="v4">-</span></div>
            <div class="nutri-item">KARBOHIDRAT<br><span id="v5">-</span></div>
            <div class="nutri-item">LEMAK<br><span id="v6">-</span></div>
        </div>

        <div class="res-footer">
            <div class="footer-label">📋 PERINGATAN KESEHATAN</div>
            <div class="footer-text" id="vAnalisis">
                ini berisi tentang manfaat dari kandungan kandungan diatas, dan ada juga peringatan jika kandungan itu melebihi batas harian sesuai kemeskes/who
            </div>
            <button onclick="location.reload()" style="margin-top:20px; padding:10px 20px; cursor:pointer; border-radius:10px; border:none; font-weight:bold;">KEMBALI SCAN</button>
        </div>
    </div>
</div>

<script>
    // Logika Scanner
    const html5QrCode = new Html5Qrcode("reader");
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    html5QrCode.start({ facingMode: "environment" }, config, (decodedText) => {
        html5QrCode.stop();
        prosesBarcode(decodedText);
    });

    function prosesBarcode(barcode) {
        if(!barcode) return;

        // Simulasi Fetch Data (Anda bisa hubungkan ke API OpenFoodFacts)
        // Menghilangkan Dasbor, Menampilkan Hasil
        document.getElementById('dashboard').style.display = 'none';
        document.getElementById('result-page').style.display = 'block';

        // Mengisi Data (Contoh Statis)
        document.getElementById('pNama').innerText = "SAMYANG CHEESE";
        document.getElementById('v1').innerText = "550 kkal";
        document.getElementById('v2').innerText = "1290 mg";
        document.getElementById('v3').innerText = "5 g";
        document.getElementById('v4').innerText = "9 g";
        document.getElementById('v5').innerText = "84 g";
        document.getElementById('v6').innerText = "16 g";
        
        document.getElementById('vAnalisis').innerHTML = "⚠️ <b>PERINGATAN:</b> Kandungan Garam (Natrium) pada produk ini sangat tinggi (1290mg). Batas maksimal harian WHO adalah 2000mg. Konsumsi berlebih berisiko menyebabkan Hipertensi.";
    }
</script>

</body>
</html>