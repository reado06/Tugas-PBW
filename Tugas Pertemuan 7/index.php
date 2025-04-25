<?php
require 'connect.php';
$pages = ['mahasiswa','matakuliah','krs'];
$page  = isset($_GET['page']) && in_array($_GET['page'],$pages) ? $_GET['page'] : 'mahasiswa';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">CRUD Sistem Akademik</h1>
    <ul class="nav nav-tabs mb-3">
        <?php foreach($pages as $p): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo $p==$page?'active':'' ?>" href="?page=<?php echo $p ?>"><?php echo ucfirst($p) ?></a>
            </li>
        <?php endforeach ?>
    </ul>
    <div>
        <?php include $page . '.php'; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>