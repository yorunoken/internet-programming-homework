<?php
include "./db_init.php";

// Ürün ekleme işlemi
if (isset($_POST['ekle'])) {
    $urunAdi = $conn->real_escape_string($_POST['urun_adi']);
    $fiyat = $conn->real_escape_string($_POST['fiyat']);
    $stokMiktari = $conn->real_escape_string($_POST['stok_miktari']);
    $kategori = $conn->real_escape_string($_POST['kategori']);

    $sql = "INSERT INTO urunler (urun_adi, fiyat, stok_miktari, kategori) VALUES ('$urunAdi', '$fiyat', '$stokMiktari', '$kategori')";

    if ($conn->query($sql)) {
        echo "<div style='color: green;'>Ürün başarıyla eklendi!</div>";
    } else {
        echo "<div style='color: red;'>Hata: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Ürün silme işlemi
if (isset($_GET['sil'])) {
    $id = $conn->real_escape_string($_GET['sil']);

    $sql = "DELETE FROM urunler WHERE id = $id";

    if ($conn->query($sql)) {
        echo "<div style='color: green;'>Ürün başarıyla silindi!</div>";
    } else {
        echo "<div style='color: red;'>Silme hatası: " . $conn->error . "</div>";
    }
}

// Stok güncelleme işlemi
if (isset($_POST['guncelle'])) {
    $id = $conn->real_escape_string($_POST['urun_id']);
    $yeniStok = $conn->real_escape_string($_POST['yeni_stok']);

    $sql = "UPDATE urunler SET stok_miktari = $yeniStok WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<div style='color: green;'>Stok miktarı başarıyla güncellendi!</div>";
    } else {
        echo "<div style='color: red;'>Güncelleme hatası: " . $conn->error . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Ürün Takip Sistemi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1,
        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select {
            margin-bottom: 15px;
            padding: 8px;
            width: 300px;
        }

        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .update-form {
            display: inline;
        }

        .update-input {
            width: 60px;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <h1>Ürün Takip Sistemi</h1>

    <h2>Yeni Ürün Ekle</h2>
    <form method="post" action="">
        <label for="urun_adi">Ürün Adı:</label>
        <input type="text" name="urun_adi" required>

        <label for="fiyat">Fiyat (TL):</label>
        <input type="number" name="fiyat" step="0.01" required>

        <label for="stok_miktari">Stok Miktarı:</label>
        <input type="number" name="stok_miktari" required>

        <label for="kategori">Kategori:</label>
        <select name="kategori">
            <option value="Elektronik">Elektronik</option>
            <option value="Giyim">Giyim</option>
            <option value="Gıda">Gıda</option>
            <option value="Kitap">Kitap</option>
            <option value="Diğer">Diğer</option>
        </select>

        <button type="submit" name="ekle">Ürün Ekle</button>
    </form>

    <h2>Ürün Listesi</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Ürün Adı</th>
            <th>Fiyat (TL)</th>
            <th>Stok Miktarı</th>
            <th>Kategori</th>
            <th>Eklenme Tarihi</th>
            <th>İşlemler</th>
        </tr>

        <?php
        // Ürünleri listele
        $sql = "SELECT * FROM urunler ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["urun_adi"] . "</td>";
                echo "<td>" . number_format($row["fiyat"], 2, ',', '.') . " ₺</td>";
                echo "<td>" . $row["stok_miktari"] . "</td>";
                echo "<td>" . $row["kategori"] . "</td>";
                echo "<td>" . date('d.m.Y H:i', strtotime($row["ekleme_tarihi"])) . "</td>";
                echo "<td class='action-buttons'>";
                echo "<form class='update-form' method='post' action=''>";
                echo "<input type='hidden' name='urun_id' value='" . $row["id"] . "'>";
                echo "<input class='update-input' type='number' name='yeni_stok' value='" . $row["stok_miktari"] . "' min='0'>";
                echo "<button type='submit' name='guncelle'>Güncelle</button>";
                echo "</form>";
                echo " <a href='?sil=" . $row["id"] . "'><button class='delete-btn'>Sil</button></a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align: center;'>Henüz ürün bulunmuyor</td></tr>";
        }
        ?>
    </table>

    <h2>İstatistikler</h2>
    <?php
    // Toplam ürün sayısı
    $sql = "SELECT COUNT(*) as toplam FROM urunler";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "<p>Toplam Ürün Sayısı: <strong>" . $row["toplam"] . "</strong></p>";

    // Toplam stok değeri
    $sql = "SELECT SUM(stok_miktari * fiyat) as toplam_deger FROM urunler";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "<p>Toplam Stok Değeri: <strong>" . number_format($row["toplam_deger"], 2, ',', '.') . " ₺</strong></p>";

    // Kategoriye göre ürün sayısı
    $sql = "SELECT kategori, COUNT(*) as adet FROM urunler GROUP BY kategori";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<p>Kategorilere Göre Ürün Dağılımı:</p>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>" . $row["kategori"] . ":</strong> " . $row["adet"] . " ürün</li>";
        }
        echo "</ul>";
    }
    ?>
</body>

</html>