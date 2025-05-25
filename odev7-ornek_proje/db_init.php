<?php
// Veritabanı bağlantı bilgileri
$serverName = "localhost";
$username = "yoru";
$password = "0410";
$dbName = "urun_takip";

// Veritabanı bağlantısı
$conn = new mysqli($serverName, $username, $password);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// Veritabanı yoksa oluştur
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
$conn->query($sql);

// Veritabanını seç
$conn->select_db($dbName);

// Tablo yoksa oluştur
$sql = "CREATE TABLE IF NOT EXISTS urunler (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    urun_adi VARCHAR(50) NOT NULL,
    fiyat DECIMAL(10,2) NOT NULL,
    stok_miktari INT(6) NOT NULL,
    kategori VARCHAR(50),
    ekleme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($sql);
