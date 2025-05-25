<?php

// Veritabanı bağlantı bilgileri
$serverLocation = "localhost";
$username = "yoru";
$password = "0410";
$databaseName = "mysql_ornek_odev";

// MySQL veritabanına bağlantı oluşturma
$conn = new mysqli($serverLocation, $username, $password, $databaseName);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Connection failed " . $conn->connect_error);
}

// 1. Örnek - Tablo Oluşturma
// Eğer yoksa 'kullanicilar' adında bir tablo oluşturur
$sql = "CREATE TABLE IF NOT EXISTS kullanicilar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
)";

if ($conn->query($sql)) {
    echo "Tablo başarıyla oluşturuldu\n";
} else {
    echo "Tablo oluşturulurken hata: " . $conn->error;
}

// 2. Örnek - Veri Ekleme
// Tabloya yeni bir kullanıcı kaydı ekler
$sql = "INSERT INTO kullanicilar (isim, email) VALUES ('Ahmet', 'ahmet@example.com')";

if ($conn->query($sql)) {
    echo "Yeni kayıt eklendi\n";
} else {
    echo "Kayıt eklenirken hata: " . $conn->error;
}

// 3. Örnek - Veri Sorgulama
// Tüm kullanıcıları isme göre sıralayarak veritabanından çeker ve listeler
$sql = "SELECT * FROM kullanicilar ORDER BY isim";
$sonuc = $conn->query($sql);

if ($sonuc->num_rows > 0) {
    while ($satir = $sonuc->fetch_assoc()) {
        echo "ID: {$satir['id']} - İsim: {$satir['isim']} - E-posta: {$satir['email']}\n";
    }
} else {
    echo "Hiç kullanıcı bulunamadı.";
}

// 4. Örnek - Veri Güncelleme
// Belirli bir e-posta adresine sahip kullanıcının ismini günceller
$sql = "UPDATE kullanicilar SET isim='Ahmet Güncellendi' WHERE email='ahmet@example.com'";

if ($conn->query($sql)) {
    echo "Kayıt güncellendi\n";
} else {
    echo "Kayıt güncellenirken hata: " . $conn->error;
}

// 5. Örnek - Veri Silme
// Belirli bir e-posta adresine sahip kullanıcıyı siler
$sql = "DELETE FROM kullanicilar WHERE email='ahmet@example.com'";

if ($conn->query($sql)) {
    echo "Kayıt silindi\n";
} else {
    echo "Kayıt silinirken hata: " . $conn->error;
}
