<?php
session_start();
require('KimElektro.php');

// =====================
// Pastikan session['data'] selalu array
// =====================
if(!isset($_SESSION['data']) || !is_array($_SESSION['data'])){
    $_SESSION['data'] = [];
} else {
    // Konversi objek KimElektro menjadi array untuk session
    foreach($_SESSION['data'] as $i => $e){
        if($e instanceof KimElektro){
            $_SESSION['data'][$i] = [
                "id" => $e->getID(),
                "nama" => $e->getNama(),
                "JenisAlat" => $e->getJenisAlat(),
                "harga" => $e->getHarga(),
                "gambar" => $e->getGambar()
            ];
        }
    }
}

// =====================
// Load data dari session
// =====================
$data = [];
foreach($_SESSION['data'] as $e){
    $data[] = new KimElektro($e['id'],$e['nama'],$e['JenisAlat'],$e['harga'],$e['gambar']);
}

// =====================
// Handle form actions
// =====================
$message="";
$action = $_POST['action'] ?? "";
$id = $_POST['id'] ?? "";
$nama = $_POST['nama'] ?? "";
$JenisAlat = $_POST['JenisAlat'] ?? "";
$harga = $_POST['harga'] ?? "";
$gambar = $_FILES['gambar'] ?? null;
$editID = $_POST['editID'] ?? "";
$delID = $_POST['delID'] ?? "";

// Tambah Data
if($action=="add"){
    $exists=false;
    foreach($data as $e){
        if($e->getID()==$id){ $exists=true; break; }
    }
    if($exists){
        $message="KimElektro says: ID sudah digunakan!";
    } else {
        $targetFile="";
        if($gambar && $gambar['error']==0){
            $targetDir="assets/";
            if(!is_dir($targetDir)) mkdir($targetDir);
            $targetFile=$targetDir . basename($gambar['name']);
            move_uploaded_file($gambar['tmp_name'],$targetFile);
        }
        $data[] = new KimElektro($id,$nama,$JenisAlat,(int)$harga,$targetFile);
        $message="KimElektro says: Data berhasil ditambahkan!";
    }
}

// Edit Data
elseif($action=="edit"){
    foreach($data as $e){
        if($e->getID()==$editID){
            if($id != $editID){
                $exists=false;
                foreach($data as $other){
                    if($other->getID()==$id){ $exists=true; break; }
                }
                if($exists){
                    $message="KimElektro says: ID sudah digunakan oleh data lain!";
                    break;
                } else {
                    $e->setID($id);
                    $message="KimElektro says: ID berhasil diubah!";
                }
            } else {
                $message="KimElektro says: ID tetap sama, data lain diperbarui.";
            }
            $e->setNama($nama);
            $e->setJenisAlat($JenisAlat);
            $e->setHarga((int)$harga);
            if($gambar && $gambar['error']==0){
                $targetDir="assets/";
                if(!is_dir($targetDir)) mkdir($targetDir);
                $targetFile=$targetDir . basename($gambar['name']);
                move_uploaded_file($gambar['tmp_name'],$targetFile);
                $e->setGambar($targetFile);
            }
            break;
        }
    }
}

// Hapus Data
elseif($action=="delete" && $delID){
    $found=false;
    foreach($data as $i => $e){
        if($e->getID()==$delID){
            array_splice($data,$i,1);
            $found=true; break;
        }
    }
    $message = $found ? "KimElektro says: Data berhasil dihapus!" : "KimElektro says: Data tidak ditemukan!";
}

// =====================
// Save session
// =====================
$_SESSION['data'] = [];
foreach($data as $e){
    $_SESSION['data'][] = [
        "id" => $e->getID(),
        "nama" => $e->getNama(),
        "JenisAlat" => $e->getJenisAlat(),
        "harga" => $e->getHarga(),
        "gambar" => $e->getGambar()
    ];
}

// =====================
// Search
// =====================
$searchID = $_GET['searchID'] ?? "";
$searchResult = [];

if($searchID){
    foreach($data as $e){
        if($e->getID() == $searchID){
            $searchResult[] = $e;
            break;
        }
    }
    if(empty($searchResult)){
        echo "<script>alert('KimElektro says: Barang dengan ID $searchID tidak ditemukan!');</script>";
    }
}

$displayData = $searchID ? $searchResult : $data;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Toko KimElektro</title>
<style>
/* ===================== */
/* Warna tema */
:root {--c1:#E3FDFD;--c2:#CBF1F5;--c3:#b4f3f8;--c4:#71C9CE;}
body{font-family:Arial,sans-serif;margin:0;background-color:var(--c1);}
.navbar{background-color:var(--c4);color:white;text-align:center;padding:15px;font-size:1.5em;font-weight:bold;}
table{border-collapse:collapse;width:100%;margin-top:20px;background-color: var(--c2);}
th,td{text-align:center;padding:10px;}
th{background-color:var(--c3);color:var(--c4);}
tr:nth-child(even){background-color:var(--c1);}
img{max-width:80px;max-height:80px;object-fit:cover;}
form{background-color: var(--c2);padding:15px;margin-top:20px;border-radius:5px;}
input[type=text],input[type=number],input[type=file]{width:100%;padding:6px;margin:5px 0 10px 0;border-radius:4px;border:1px solid var(--c4);}
input[type=submit]{padding:8px 16px;background-color:var(--c4);color:white;border:none;border-radius:4px;c sor:pointer;}
input[type=submit]:hover{background-color:var(--c3);color:var(--c4);}
.bodie{padding:20px; margin: 10px;}
.bodie form {background: var(--c2);padding:20px;border-radius:10px;}
.bodie table {background: var(--c2);padding:30px;border-radius:20px;}
</style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">Toko KimElektro</div>

<!-- Alert pesan -->
<?php if($message): ?>
<script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>

<!-- Form Tambah Data -->
<div class="bodie">
<form id="formTambah" method="post" enctype="multipart/form-data">
    <h3 style="text-align: center">Tambah Data</h3>
    <input type="hidden" name="action" value="add">
    <label>ID:</label><input type="text" name="id" required>
    <label>Nama:</label><input type="text" name="nama" required>
    <label>JenisAlat:</label><input type="text" name="JenisAlat" required>
    <label>Harga:</label><input type="number" name="harga" required>
    <label>Gambar:</label><input type="file" name="gambar" accept="image/*">
    <input type="submit" value="Tambah">
</form>
</div>

<!-- Form Pencarian -->
<div class="bodie">
<form method="get" style="margin-bottom:20px;">
    <h3 style="text-align:center;">Cari Barang Berdasarkan ID</h3>
    <input type="text" name="searchID" placeholder="Masukkan ID" required>
    <input type="submit" value="Cari">
    <a href="index.php" style="padding:8px 16px;background-color:var(--c3);color:var(--c4);border-radius:4px;text-decoration:none;">Tampilkan semua barang</a>
</form>
</div>

<?php
$editID = $_POST['editID'] ?? null;
$editData = null;
if($editID){
    foreach($data as $e){
        if($e->getID() == $editID){
            $editData = $e;
            break;
        }
    }
}
?>

<!-- Tabel Data -->
<div class="bodie">
    <h3 style="text-align:center;">Daftar Barang</h3>
<table>
<tr>
    <th>ID</th><th>Nama</th><th>JenisAlat</th><th>Harga</th><th>Gambar</th><th>Aksi</th>
</tr>
<?php foreach($displayData as $e): ?>
<tr>
    <td><?= htmlspecialchars($e->getID()); ?></td>
    <td><?= htmlspecialchars($e->getNama()); ?></td>
    <td><?= htmlspecialchars($e->getJenisAlat()); ?></td>
    <td><?= number_format($e->getHarga()); ?></td>
    <td>
        <?php if($e->getGambar()): ?>
            <img src="<?= $e->getGambar(); ?>" alt="gambar">
        <?php endif; ?>
    </td>
    <td>
        <!-- Tombol Edit -->
        <form method="post" style="display:inline;">
            <input type="hidden" name="editID" value="<?= $e->getID(); ?>">
            <input type="submit" value="Edit">
        </form>
        <!-- Tombol Hapus -->
        <form method="post" style="display:inline;">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="delID" value="<?= $e->getID(); ?>">
            <input type="submit" value="Hapus" onclick="return confirm('Yakin hapus?')">
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>

<!-- Form Edit Data -->
<?php if($editData): ?>
<div class="bodie">
<form method="post" enctype="multipart/form-data" style="margin-top:20px;" name="formEdit">
    <h3>Edit Data ID <?= htmlspecialchars($editData->getID()); ?></h3>
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="editID" value="<?= $editData->getID(); ?>">

    <label>ID:</label>
    <input type="text" name="id" value="<?= htmlspecialchars($editData->getID()); ?>" required>
    <label>Nama:</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($editData->getNama()); ?>" required>
    <label>JenisAlat:</label>
    <input type="text" name="JenisAlat" value="<?= htmlspecialchars($editData->getJenisAlat()); ?>" required>
    <label>Harga:</label>
    <input type="number" name="harga" value="<?= $editData->getHarga(); ?>" required>
    <label>Gambar:</label>
    <?php if($editData->getGambar()): ?>
        <img src="<?= $editData->getGambar(); ?>" alt="gambar" style="display:block;margin-bottom:5px;">
    <?php endif; ?>
    <input type="file" name="gambar" accept="image/*">
    <input type="submit" value="Update">
</form>
</div>
<?php endif; ?>

<script>
// Reset form tambah setelah submit
window.onload = function() {
    var formTambah = document.getElementById('formTambah');
    if(formTambah) formTambah.reset();

    // Scroll ke form edit jika sedang mengedit
    var formEdit = document.querySelector('form[method="post"][name="formEdit"]');
    if(formEdit){
        formEdit.scrollIntoView({behavior: "smooth", block: "start"});
    }
}
</script>

</body>
</html>
