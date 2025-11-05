<?php
$baris = (int)($_POST['baris'] ?? 0);
$kolom = (int)($_POST['kolom'] ?? 0);
$data_input = $_POST['data'] ?? [];

// Menentukan langkah tampilan berdasarkan input yang diterima
if (!empty($data_input)) {
    $step = 3;
} elseif ($baris > 0 && $kolom > 0) {
    $step = 2;
} else {
    $step = 1;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data</title>
    </head>
<body>

<div class="container">

<?php
if ($step === 1) {
?>
    <h2>Input Jumlah Baris dan Kolom</h2>
    <form method="POST" action="">
        <div class="input-awal-group">
            <label for="baris">Inputkan Jumlah Baris:</label>
            <input type="number" id="baris" name="baris" required min="1" value="<?php echo $baris > 0 ? $baris : ''; ?>">
            <small>Contoh: 1</small>
        </div>
        <br>
        <div class="input-awal-group">
            <label for="kolom">Inputkan Jumlah Kolom:</label>
            <input type="number" id="kolom" name="kolom" required min="1" value="<?php echo $kolom > 0 ? $kolom : ''; ?>">
            <small>Contoh: 3</small>
        </div>
        <br>
        <input type="submit" value="LANJUTKAN">
    </form>

<?php

} elseif ($step === 2) {
?>

    <h2>Input Data</h2>
    <form method="POST" action="">
        <div class="data-input-group">
        <?php
        for ($i = 1; $i <= $baris; $i++) {
            for ($j = 1; $j <= $kolom; $j++) {
                echo '<div class="data-item" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">'; // Style inline minimal untuk tata letak
                echo '<span class="label-input">' . $i . '.' . $j . ': </span>';
                echo '<input type="text" name="data[' . $i . '][' . $j . ']" required size="5">';
                echo '</div>';
            }
            if ($baris > 1) {
                echo '<br>';
            }
        }
        ?>
        </div>
        <input type="hidden" name="baris" value="<?php echo $baris; ?>">
        <input type="hidden" name="kolom" value="<?php echo $kolom; ?>">
        <input type="submit" value="SUBMIT DATA">
    </form>

<?php

} elseif ($step === 3) {
?>
    <h2>Hasil Input Data</h2>

    <div style="border: 1px solid black; padding: 10px; width: fit-content;"> 
    <?php
    if (!empty($data_input)) {
        $count = 0;
        
        foreach ($data_input as $baris_key => $kolom_array) {
            foreach ($kolom_array as $kolom_key => $nilai) {
                echo '<b>' . htmlspecialchars($baris_key) . '.' . htmlspecialchars($kolom_key) . ' : </b>' . htmlspecialchars($nilai) . '<br>';
                $count++;
            }
        }
        
       
    } else {
        echo '<p>Tidak ada data yang disubmit.</p>';
    }
    ?>
    </div>
    
    <br>
    <a href="?">Kembali</a>

<?php
}
?>

</div>

</body>
</html>