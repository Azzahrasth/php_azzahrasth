<?php
// koneksi database
$servername = "localhost";
$username = "root"; 
$password = "";    
$dbname = "testdb";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$search_hobi = "";
$search_query = "";

// Cek apakah ada parameter pencarian
if (isset($_GET['search_hobi']) && !empty($_GET['search_hobi'])) {
    $search_hobi = $conn->real_escape_string($_GET['search_hobi']);
    $search_query = " HAVING hobi LIKE '%$search_hobi%'";
}

// Query untuk mengambil data hobi, menghitung jumlah person, dan mengurutkan
$sql = "SELECT 
            hobi, 
            COUNT(DISTINCT person_id) AS jumlah_person
        FROM 
            hobi
        GROUP BY 
            hobi" . $search_query . "
        ORDER BY 
            jumlah_person DESC, hobi ASC"; 

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari Hobi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 50%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .search-form { margin-bottom: 20px; }
        .search-form input[type="text"] { padding: 5px; }
        .search-form input[type="submit"] { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="search-form">
        <form method="GET" action="soal2.php">
            <label for="search_hobi">Cari Hobi:</label>
            <input type="text" id="search_hobi" name="search_hobi" value="<?php echo htmlspecialchars($search_hobi); ?>" placeholder="Masukkan nama hobi">
            <input type="submit" value="Cari">
            <?php if (!empty($search_hobi)): ?>
                <a href="soal2.php">Tampilkan Semua</a>
            <?php endif; ?>
        </form>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>hobi</th><th>jumlah person</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["hobi"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["jumlah_person"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Tidak ada data hobi yang ditemukan" . (!empty($search_hobi) ? " untuk pencarian: <b>" . htmlspecialchars($search_hobi) . "</b>" : "") . ".</p>";
    }

    $conn->close();
    ?>

</body>
</html>