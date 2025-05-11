# ÖDEV 3 RAPORU

## Ders: İnternet Programlama

**Öğrenci Adı Soyadı:** Muhammed Fatih Fetvacı  
**Öğrenci Numarası:** 202407012067  
**Teslim Tarihi:** 12.05.2025  
**Proje Adı:** Image Uploader

## Proje Tanıtımı

Bu projede, PHP kullanarak kullanıcıların resim yükleyebildiği bir website yapılmıştır. Projeyi yapmak için kullandığım teknolojileri aşağıda bulabilirsiniz:

-   PHP v8.\*
-   MariaDB
-   Composer

## Kodlar ve Açıklamaları

### login.php

```php
<?php
session_start();
include "./database/db_connect.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        $message = "Username and password must be provided.";
    } else {
        $usernameProvided = trim($_POST["username"]);
        $passwordProvided = $_POST["password"];

        $stmt = $conn->prepare("SELECT password, login_token, id FROM users WHERE username = ?");
        if (!$stmt) {
            $message = "Database error. Please try again later.";
        } else {
            $stmt->bind_param("s", $usernameProvided);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {
                $message = "Incorrect username or password.";
            } else {
                $stmt->bind_result($correctPasswordHashed, $loginToken, $userId);
                $stmt->fetch();
                $stmt->close();

                if (!password_verify($passwordProvided, $correctPasswordHashed)) {
                    $message = "Incorrect username or password.";
                } else {
                    tials are correct.
                    if (!$loginToken) {
                        $loginToken = bin2hex(random_bytes(32));

                        $stmt = $conn->prepare("UPDATE users SET login_token = ? WHERE id = ?");
                        if (!$stmt) {
                            $message = "Database error. Please try again later.";
                        } else {
                            $stmt->bind_param("si", $loginToken, $userId);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }

                    $_SESSION["login_token"] = $loginToken;
                    $_SESSION['username'] = $usernameProvided;
                    header("Location:                 exit();
                }
            }
        }
    }
}
?>
```

**Açıklama:**

1. Oturum başlatılıyor ve veritabanına bağlantı kuruluyor.
2. Request'in POST ile gönderilip gönderilmediği kontrol ediliyor, gönderilmiş ise çalışıyor.
3. Kullanıcı adı veya şifre girilmemişse hata mesajı hazırlanıyor.
4. Veritabanından kullanıcı bilgileri (şifre, token, id) çekiliyor.
5. Girilen şifre, veritabanındaki hash'lenmiş şifre ile karşılaştırılıyor.
6. Token yoksa yeni bir token üretiliyor.
7. Token ve kullanıcı adı oturum cookies'ine atanıyor, kullanıcı anasayfaya yönlendiriliyor.

### upload.php

```php
<?php
session_start();
include "./database/db_connect.php";
include "./database/utils.php";

// Check if user is logged in
$isLoggedIn = loginTokenIsValid(isset($_SESSION["login_token"]) ? $_SESSION["login_token"] : "");
$userId = $isLoggedIn ? getUserFromLoginToken($_SESSION["login_token"])["id"] : null;

// Setting up variables
$message = "";
$messageType = "";
$maxFileSize = 5 * 1024 * 1024;
$allowedExtensions = ["jpg", "jpeg", "png", "gif"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    $file = $_FILES["image"];

    if ($file["error"] !== UPLOAD_ERR_OK) {
        $message = "Upload failed with error code: " . $file["error"];
        $messageType = "error";
    } else {
        if ($file["size"] > $maxFileSize) {
            $message = "File size too large. Maximum size is: " . $maxFileSize . "MB";
            $messageType = "error";
        } else {
            $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                $message = "Only the following file types are allowed: " . implode(", ", $allowedExtensions);
                $messageType = "error";
            } else {
                // Everything is valid, insert into database

                $fileTitle = isset($_POST["title"]) && !empty($_POST["title"])
                    ? $_POST["title"]
                    : pathinfo($file["name"], PATHINFO_FILENAME);

                $result = uploadImage($file["name"], $fileTitle, $userId, $file["tmp_name"]);
                $message = $result["message"];
                $messageType = $result["messagetype"];
            }
        }
    }
}
?>
```

**Açıklama:**

1. Oturum başlatılıyor, veritabanı bağlantısı ve yardımcı fonksiyonlar (utils.php) ekleniyor.
2. loginTokenIsValid fonksiyonu ile kullanıcı oturum açmış mı diye kontrol ediliyor.
3. Maksimum dosya boyutu (5MB) ve izin verilen dosya türleri tanımlanıyor.
4. Form POST ile gönderildiyse ve bir dosya yüklendiyse işlem başlıyor.
5. Dosya yüklenirken hata oluşmuşsa, kullanıcıya hata mesajı veriliyor.
6. Dosya boyutu 5MB'tan büyükse, hata mesajı veriliyor.
7. Dosya uzantısı geçerli değilse, kullanıcı uyarılıyor.
8. Her şey doğruysa:
    - Başlık girilmişse kullanılıyor, girilmemişse dosya adı başlık olarak atanıyor.
    - uploadImage fonksiyonu çağrılarak resim kaydediliyor ve sonucu kullanıcıya mesaj olarak gösteriliyor.
