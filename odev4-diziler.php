<!-- 
PHP dizi ile ilgili 5 adet örnek yapıp ve kodları satır satır açıklayınız.
HTML, CSS, JavaScript kullanmak zorunlu değildir.
-->

<?php

// 1: Index dizisi
$colors = ["kirmizi", "yesil", "mavi"];
printf("2. indekste olan renk: %s", $colors[2]);

// 2.
$student = [
    "name" => "Fatih",
    "age" => 19,
    "department" => "Bilgisayar Programciligi"
];
printf("Ogrenci bilgileri: ad: %s, yas: %d, department: %s", $student["name"], $student["age"], $student["department"]);

// 3. Uc Boyutlu
$users = [
    ["name" => "Ali", "email" => "ali@hotmail.com"],
    ["name" => "Ayse", "email" => "ayse@hotmail.com"]
];
printf("Ilk kullanici email: %s", $users[0]["email"]);

// 4. Array fonksiyon
$numbers = array(1, 2, 3, 4, 5);
printf("Ucuncu sayi: %d", $numbers[2]);

// 5. Karisik array
$mixed = [
    "id" => 101,
    0 => "active",
    "role" => "admin"
];
printf("status: %s", $mixed[0]);
