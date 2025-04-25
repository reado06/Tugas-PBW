<?php
if($_SERVER['REQUEST_METHOD']=='POST' && $_GET['page']=='matakuliah'){
    $kodemk = $_POST['kodemk'];
    $nama   = $_POST['nama'];
    $sks    = $_POST['jumlah_sks'];
    if($_POST['action']=='create'){
        $sql = "INSERT INTO matakuliah(kodemk, nama, jumlah_sks) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $kodemk, $nama, $sks);
    } else {
        $sql = "UPDATE matakuliah SET nama=?, jumlah_sks=? WHERE kodemk=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $nama, $sks, $kodemk);
    }
    $stmt->execute();
    $stmt->close();
    header('Location:?page=matakuliah'); exit;
}
if(isset($_GET['delete']) && $page=='matakuliah'){
    $delete_kodemk = $_GET['delete'];
    $sql = "DELETE FROM matakuliah WHERE kodemk=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $delete_kodemk);
    $stmt->execute();
    $stmt->close();
    header('Location:?page=matakuliah'); exit;
}
$edit=null;
if(isset($_GET['edit']) && $page=='matakuliah'){
    $edit_kodemk = $_GET['edit'];
    $sql = "SELECT * FROM matakuliah WHERE kodemk=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $edit_kodemk);
    $stmt->execute();
    $r = $stmt->get_result();
    $edit = $r->fetch_assoc();
    $stmt->close();
}
?>
<div class="mb-4">
  <h2>Form Matakuliah</h2>
  <form method="post">
    <input type="hidden" name="action" value="<?php echo $edit?'update':'create' ?>">
    <div class="mb-3">
      <label>Kode MK</label>
      <input required name="kodemk" class="form-control" value="<?php echo $edit['kodemk'] ?? ''?>" <?php echo $edit?'readonly':''?>>
    </div>
    <div class="mb-3">
      <label>Nama Mata Kuliah</label>
      <input required name="nama" class="form-control" value="<?php echo $edit['nama'] ?? ''?>">
    </div>
    <div class="mb-3">
      <label>Jumlah SKS</label>
      <input required type="number" name="jumlah_sks" class="form-control" value="<?php echo $edit['jumlah_sks'] ?? ''?>">
    </div>
    <button class="btn btn-primary"><?php echo $edit?'Update':'Simpan'?></button>
    <?php if($edit): ?><a href="?page=matakuliah" class="btn btn-secondary">Batal</a><?php endif?>
  </form>
</div>
<div>
  <h2>Daftar Matakuliah</h2>
  <table class="table table-striped">
    <thead><tr><th>KodeMK</th><th>Nama</th><th>SKS</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php
    $res=$conn->query("SELECT * FROM matakuliah");
    while($r=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $r['kodemk']?></td>
        <td><?php echo $r['nama']?></td>
        <td><?php echo $r['jumlah_sks']?></td>
        <td>
          <a class="btn btn-sm btn-warning" href="?page=matakuliah&edit=<?php echo $r['kodemk']?>">Edit</a>
          <a class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')" href="?page=matakuliah&delete=<?php echo $r['kodemk']?>">Hapus</a>
        </td>
      </tr>
    <?php endwhile?>
    </tbody>
  </table>
</div>