<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $npm    = $_POST['npm'];
    $nama   = $_POST['nama'];
    $jurusan= $_POST['jurusan'];
    $alamat = $_POST['alamat'];
    if($_POST['action']=='create'){
        $sql = "INSERT INTO mahasiswa(npm,nama,jurusan,alamat) VALUES('$npm','$nama','$jurusan','$alamat')";
    } else {
        $sql = "UPDATE mahasiswa SET nama='$nama',jurusan='$jurusan',alamat='$alamat' WHERE npm='$npm'";
    }
    $conn->query($sql);
    header('Location:?page=mahasiswa'); exit;
}

if(isset($_GET['delete'])){
    $conn->query("DELETE FROM mahasiswa WHERE npm='".$_GET['delete']."'");
    header('Location:?page=mahasiswa'); exit;
}

$edit = null;
if(isset($_GET['edit'])){
    $res = $conn->query("SELECT * FROM mahasiswa WHERE npm='".$_GET['edit']."'");
    $edit = $res->fetch_assoc();
}
?>
<div class="mb-4">
  <h2>Form Mahasiswa</h2>
  <form method="post">
    <input type="hidden" name="action" value="<?php echo $edit?'update':'create' ?>">
    <div class="mb-3">
      <label>NPM</label>
      <input required name="npm" class="form-control" value="<?php echo $edit['npm'] ?? ''?>" <?php echo $edit?'readonly':''?>>
    </div>
    <div class="mb-3">
      <label>Nama</label>
      <input required name="nama" class="form-control" value="<?php echo $edit['nama'] ?? ''?>">
    </div>
    <div class="mb-3">
      <label>Jurusan</label>
      <select required name="jurusan" class="form-select">
        <option value="Teknik Informatika" <?php echo (isset($edit['jurusan'])&&$edit['jurusan']=='Teknik Informatika')?'selected':''?>>Teknik Informatika</option>
        <option value="Sistem Informasi" <?php echo (isset($edit['jurusan'])&&$edit['jurusan']=='Sistem Informasi')?'selected':''?>>Sistem Informasi</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Alamat</label>
      <textarea name="alamat" class="form-control"><?php echo $edit['alamat'] ?? ''?></textarea>
    </div>
    <button class="btn btn-primary"><?php echo $edit?'Update':'Simpan'?></button>
    <?php if($edit): ?><a href="?page=mahasiswa" class="btn btn-secondary">Batal</a><?php endif?>
  </form>
</div>
<div>
  <h2>Daftar Mahasiswa</h2>
  <table class="table table-striped">
    <thead><tr><th>NPM</th><th>Nama</th><th>Jurusan</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php
    $res = $conn->query("SELECT * FROM mahasiswa");
    while($row=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['npm']?></td>
        <td><?php echo $row['nama']?></td>
        <td><?php echo $row['jurusan']?></td>
        <td>
          <a class="btn btn-sm btn-warning" href="?page=mahasiswa&edit=<?php echo $row['npm']?>">Edit</a>
          <a class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')" href="?page=mahasiswa&delete=<?php echo $row['npm']?>">Hapus</a>
        </td>
      </tr>
    <?php endwhile?>
    </tbody>
  </table>
</div>