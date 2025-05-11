<!-- 
PHP döngüler, koşul yapıları, diziler ve fonksiyonlar kullanarak bir örnek yapınız. Tüm konu başlıklarının örnekte bulunması gerekmektedir.
HTML, CSS, JavaScript kullanmak zorunlu değildir.
-->

<?php
// Kitap bilgilerini tutan çok boyutlu dizi
$books = [
    [
        'id' => 1,
        'title' => 'Suç ve Ceza',
        'author' => 'Fyodor Dostoyevski',
        'year' => 1866,
        'available' => true
    ],
    [
        'id' => 2,
        'title' => 'Sefiller',
        'author' => 'Victor Hugo',
        'year' => 1862,
        'available' => false
    ],
    [
        'id' => 3,
        'title' => 'Tutunamayanlar',
        'author' => 'Oğuz Atay',
        'year' => 1971,
        'available' => true
    ],
    [
        'id' => 4,
        'title' => 'Yüzüklerin Efendisi',
        'author' => 'J.R.R. Tolkien',
        'year' => 1954,
        'available' => true
    ]
];

function listBooks($bookArray)
{
    echo "<h2>Kütüphanemizdeki Kitaplar:</h2>";

    echo "<h3>For Döngüsü ile Listeleme:</h3>";
    echo "<ul>";
    for ($i = 0; $i < count($bookArray); $i++) {
        echo "<li>" . $bookArray[$i]['title'] . " - " . $bookArray[$i]['author'] . "</li>";
    }
    echo "</ul>";

    echo "<h3>Foreach Döngüsü ile Listeleme:</h3>";
    echo "<ul>";
    foreach ($bookArray as $book) {
        if ($book['available']) {
            echo "<li>" . $book['title'] . " - Durum: <span style='color:green'>Mevcut</span></li>";
        } else {
            echo "<li>" . $book['title'] . " - Durum: <span style='color:red'>Ödünç Verilmiş</span></li>";
        }
    }
    echo "</ul>";
}

function getBooksAfterYear($bookArray, $year)
{
    $filteredBooks = [];

    $i = 0;
    while ($i < count($bookArray)) {
        if ($bookArray[$i]['year'] > $year) {
            $filteredBooks[] = $bookArray[$i];
        }
        $i++;
    }

    return $filteredBooks;
}

function changeBookStatus($bookArray, $bookId, $newStatus)
{
    foreach ($bookArray as &$book) {
        if ($book['id'] === $bookId) {
            $book['available'] = $newStatus;
            break;
        }
    }

    return $bookArray;
}

function borrowOrReturnBook($bookArray, $bookId)
{
    $i = 0;
    do {
        if ($bookArray[$i]['id'] === $bookId) {
            $newStatus = $bookArray[$i]['available'] ? false : true;
            $action = $bookArray[$i]['available'] ? "ödünç alındı" : "iade edildi";

            $bookArray[$i]['available'] = $newStatus;
            echo "<p>" . $bookArray[$i]['title'] . " kitabı " . $action . ".</p>";
            break;
        }
        $i++;
    } while ($i < count($bookArray));

    return $bookArray;
}

function categorizeBookByYear($year)
{
    $period = "";

    switch (true) {
        case ($year < 1800):
            $period = "Klasik Dönem";
            break;
        case ($year >= 1800 && $year < 1900):
            $period = "19. Yüzyıl Edebiyatı";
            break;
        case ($year >= 1900 && $year < 2000):
            $period = "20. Yüzyıl Edebiyatı";
            break;
        default:
            $period = "Modern Edebiyat";
    }

    return $period;
}

// Tüm kitapları listeleyerek başlayalım
listBooks($books);

// 1950'den sonra yazılmış kitapları filtreleyelim
$modernBooks = getBooksAfterYear($books, 1950);
echo "<h2>1950'den Sonra Yazılmış Kitaplar:</h2>";
echo "<ul>";
foreach ($modernBooks as $book) {
    echo "<li>" . $book['title'] . " (" . $book['year'] . ") - " . categorizeBookByYear($book['year']) . "</li>";
}
echo "</ul>";

// Kitap ödünç alma/iade etme işlemleri
echo "<h2>Kitap İşlemleri:</h2>";
$books = borrowOrReturnBook($books, 1); // Suç ve Ceza'yı ödünç al
$books = borrowOrReturnBook($books, 2); // Sefiller'i iade et

// Son durumu gösterelim
echo "<h2>Güncel Kitap Durumları:</h2>";
listBooks($books);
