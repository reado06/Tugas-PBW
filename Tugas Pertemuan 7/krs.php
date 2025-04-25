<?php
if($_SERVER['REQUEST_METHOD']=='POST' && $page=='krs'){
    $npm   = $_POST['mahasiswa_npm'];
    $mk    = $_POST['matakuliah_kodemk'];
    if($_POST['action']=='create'){
        $sql="INSERT INTO krs(mahasiswa_npm, matakuliah_kodemk) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $npm, $mk);
    } else {
        $id = $_POST['id'];
        $sql="UPDATE krs SET mahasiswa_npm=?, matakuliah_kodemk=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $npm, $mk, $id);
    }
    $stmt->execute();
    $stmt->close();
    header('Location:?page=krs'); exit;
}
if(isset($_GET['delete']) && $page=='krs'){
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM krs WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header('Location:?page=krs'); exit;
}
$edit=null;
if(isset($_GET['edit']) && $page=='krs'){
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM krs WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $r = $stmt->get_result();
    $edit = $r->fetch_assoc();
    $stmt->close();
}
?>
<div class="mb-4">
  <h2>Form KRS</h2>
  <form method="post">
    <input type="hidden" name="action" value="<?php echo $edit?'update':'create' ?>">
    <?php if($edit): ?><input type="hidden" name="id" value="<?php echo $edit['id']?>"><?php endif?>
    <div class="mb-3">
      <label>Mahasiswa</label>
      <select required name="mahasiswa_npm" class="form-select">
        <?php $m=$conn->query("SELECT npm,nama FROM mahasiswa ORDER BY nama ASC"); while($r=$m->fetch_assoc()): ?>
          <option value="<?php echo $r['npm']?>" <?php echo ($edit&&$edit['mahasiswa_npm']==$r['npm'])?'selected':''?>><?php echo $r['nama']?></option>
        <?php endwhile?>
      </select>
    </div>
    <div class="mb-3">
      <label>Matakuliah</label>
      <select required name="matakuliah_kodemk" class="form-select">
        <?php $m=$conn->query("SELECT kodemk,nama FROM matakuliah ORDER BY nama ASC"); while($r=$m->fetch_assoc()): ?>
          <option value="<?php echo $r['kodemk']?>" <?php echo ($edit&&$edit['matakuliah_kodemk']==$r['kodemk'])?'selected':''?>><?php echo $r['nama']?></option>
        <?php endwhile?>
      </select>
    </div>
    <button class="btn btn-primary"><?php echo $edit?'Update':'Simpan'?></button>
    <?php if($edit): ?><a href="?page=krs" class="btn btn-secondary">Batal</a><?php endif?>
  </form>
</div>
<div>
  <h2>Daftar KRS</h2>
  <table class="table table-striped">
    <thead><tr><th>No</th><th>Nama Lengkap</th><th>Mata Kuliah</th><th>Keterangan</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php
    $q = "SELECT k.id, m.nama AS nama_mahasiswa, mk.nama AS nama_matakuliah, mk.jumlah_sks
          FROM krs k
          JOIN mahasiswa m ON k.mahasiswa_npm = m.npm
          JOIN matakuliah mk ON k.matakuliah_kodemk = mk.kodemk
          ORDER BY m.nama ASC, mk.nama ASC";
    $r = $conn->query($q);
    $i = 1;
    while($row = $r->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++?></td>
        <td><?php echo $row['nama_mahasiswa']?></td>
        <td><?php echo $row['nama_matakuliah']?></td>
        <td>
          <span class="text-primary fw-bold"><?php echo $row['nama_mahasiswa']?></span> 
          Mengambil Mata Kuliah 
          <span class="text-success fw-bold"><?php echo $row['nama_matakuliah']?></span> 
          (<span class="text-danger"><?php echo $row['jumlah_sks']?> SKS</span>)
        </td>
        <td>
          <a class="btn btn-sm btn-warning" href="?page=krs&edit=<?php echo $row['id']?>">Edit</a>
          <a class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')" href="?page=krs&delete=<?php echo $row['id']?>">Hapus</a>
        </td>
      </tr>
    <?php endwhile?>
    </tbody>
  </table>
</div>