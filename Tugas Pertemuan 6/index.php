<?php
session_start();

$bandara_asal = [
    "Soekarno Hatta" => 65000,
    "Husein Sastranegara" => 50000,
    "Abdul Rachman Saleh" => 40000,
    "Juanda" => 30000
];

$bandara_tujuan = [
    "Ngurah Rai" => 85000,
    "Hasanuddin" => 70000,
    "Inanwatan" => 90000,
    "Sultan Iskandar Muda" => 60000
];

ksort($bandara_asal);
ksort($bandara_tujuan);

if (!isset($_SESSION['penerbangan'])) {
    $_SESSION['penerbangan'] = [];
}

if (isset($_POST['submit'])) {
    $nama_maskapai = $_POST['nama_maskapai'];
    $asal = $_POST['bandara_asal'];
    $tujuan = $_POST['bandara_tujuan'];
    $harga = $_POST['harga'];

    $pajak_asal = $bandara_asal[$asal];
    $pajak_tujuan = $bandara_tujuan[$tujuan];

    $total_pajak = $pajak_asal + $pajak_tujuan;
    $total_harga = $harga + $total_pajak;

    $penerbangan = [
        'nomor' => count($_SESSION['penerbangan']) + 1,
        'tanggal' => date('Y-m-d H:i:s'),
        'nama_maskapai' => $nama_maskapai,
        'asal' => $asal,
        'tujuan' => $tujuan,
        'harga' => $harga,
        'pajak_asal' => $pajak_asal,
        'pajak_tujuan' => $pajak_tujuan,
        'total_pajak' => $total_pajak,
        'total_harga' => $total_harga
    ];

    $_SESSION['penerbangan'][] = $penerbangan;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Rute Penerbangan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Pendaftaran Rute Penerbangan</h1>
    
    <div class="container">
        <div class="form-section">
            <h2>Form Pendaftaran</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama_maskapai">Nama Maskapai:</label>
                    <input type="text" id="nama_maskapai" name="nama_maskapai" required>
                </div>
                
                <div class="form-group">
                    <label for="bandara_asal">Bandara Asal:</label>
                    <select id="bandara_asal" name="bandara_asal" required>
                        <option value="">-- Pilih Bandara Asal --</option>
                        <?php foreach ($bandara_asal as $bandara => $pajak): ?>
                            <option value="<?= $bandara ?>"><?= $bandara ?> (Pajak: Rp <?= number_format($pajak, 0, ',', '.') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="bandara_tujuan">Bandara Tujuan:</label>
                    <select id="bandara_tujuan" name="bandara_tujuan" required>
                        <option value="">-- Pilih Bandara Tujuan --</option>
                        <?php foreach ($bandara_tujuan as $bandara => $pajak): ?>
                            <option value="<?= $bandara ?>"><?= $bandara ?> (Pajak: Rp <?= number_format($pajak, 0, ',', '.') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga Tiket (Rp):</label>
                    <input type="number" id="harga" name="harga" min="0" required>
                </div>
                
                <button type="submit" name="submit">Daftarkan Penerbangan</button>
            </form>
        </div>
        
        <div class="results-section">
            <h2>Data Penerbangan</h2>
            
            <?php if (isset($_POST['submit'])): ?>
                <div class="alert alert-success">
                    Pendaftaran penerbangan berhasil ditambahkan!
                </div>
            <?php endif; ?>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Maskapai</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Harga Tiket</th>
                        <th>Pajak</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_SESSION['penerbangan']) && count($_SESSION['penerbangan']) > 0): ?>
                        <?php foreach ($_SESSION['penerbangan'] as $data): ?>
                            <tr>
                                <td><?= $data['nomor'] ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?></td>
                                <td><?= $data['nama_maskapai'] ?></td>
                                <td><?= $data['asal'] ?></td>
                                <td><?= $data['tujuan'] ?></td>
                                <td>Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($data['total_pajak'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">Belum ada data penerbangan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
