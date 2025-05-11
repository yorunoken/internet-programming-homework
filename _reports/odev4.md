# ÖDEV 4 RAPORU

## Ders: İnternet Programlama

**Öğrenci Adı Soyadı:** Muhammed Fatih Fetvacı  
**Öğrenci Numarası:** 202407012067  
**Teslim Tarihi:** 05.05.2025  
**Proje Adı:** PHP Dizileri

## Proje Tanıtımı

Bu ödevde, PHP'de dizilerin kullanımına yönelik 5 farklı örnek oluşturulmuştur. Her örnek satır satır açıklanarak, dizilerin farklı kullanım şekilleri gösterilmiştir.

## Kodlar ve Açıklamaları

### Örnek 1: İndeks Dizisi

```php
$colors = ["kirmizi", "yesil", "mavi"];
printf("2. indekste olan renk: %s", $colors[2]);
```

-   İndeks dizisi oluşturuldu (sıralı, anahtarları 0'dan başlayan sayılar olan dizi)
-   `printf()` fonksiyonu ile dizinin 2. indeksindeki eleman (mavi) ekrana yazdırıldı

### Örnek 2: İlişkisel Dizi

```php
$student = [
    "name" => "Fatih",
    "age" => 19,
    "department" => "Bilgisayar Programciligi"
];
printf("Ogrenci bilgileri: ad: %s, yas: %d, department: %s", $student["name"], $student["age"], $student["department"]);
```

-   İlişkisel (associative) dizi tanımlandı, her eleman için özel anahtarlar kullanıldı
-   Dizi elemanlarına string anahtarlar ile erişim sağlandı
-   Öğrenci bilgileri formatlanarak yazdırıldı

### Örnek 3: Çok Boyutlu Dizi

```php
$users = [
    ["name" => "Ali", "email" => "ali@hotmail.com"],
    ["name" => "Ayse", "email" => "ayse@hotmail.com"]
];
printf("Ilk kullanici email: %s", $users[0]["email"]);
```

-   İç içe dizi yapısı oluşturularak çok boyutlu dizi tanımlandı
-   İlk kullanıcının email bilgisine `$users[0]["email"]` şeklinde erişildi

### Örnek 4: Array Fonksiyonu

```php
$numbers = array(1, 2, 3, 4, 5);
printf("Ucuncu sayi: %d", $numbers[2]);
```

-   Dizi, alternatif sözdizimi olan `array()` fonksiyonu ile oluşturuldu
-   Sayısal indeksli dizinin 3. elemanına erişilerek yazdırıldı

### Örnek 5: Karışık Dizi

```php
$mixed = [
    "id" => 101,
    0 => "active",
    "role" => "admin"
];
printf("status: %s", $mixed[0]);
```

-   Hem sayısal hem string anahtarları bir arada içeren karışık bir dizi tanımlandı
-   Sayısal indeks kullanarak dizinin "active" elemanına erişildi
