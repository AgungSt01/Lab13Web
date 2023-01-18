<?php
include("koneksi.php");

// query untuk menampilkan data
$q = "";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = "WHERE nama LIKE '{$q}%'"; 
}
$title = 'Data Barang';
$sql = 'SELECT * FROM data_barang';
$sql_count = " SELECT COUNT(*) FROM data_barang";
if (isset($sql_where)) {
    $sql .= $sql_where;
    $sql_count .= $sql_where;
}
$result_count = mysqli_query($conn, $sql_count);
$count = 0;
if ($result_count) {
    $r_data = mysqli_fetch_row($result_count);
    $count = $r_data[0];
   
$per_page = 1;
$num_page = ceil($count / $per_page);
$limit = $per_page;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $offset = ($page - 1) * $per_page;
    $previous = $page - 1;
    $next = $page + 1;
}
} else {
    $offset = 0;
    $page = 1;
}
$sql .= " LIMIT {$offset}, {$limit}";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Data Barang</title>
</head>
<body>
    <div class="container">
        <h1>Data Barang</h1>
        <div class="main">
        <a href="tambah.php" class="tombol2">Tambah Barang</a> <br><br><br>
            <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Katagori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php if($result): ?>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><img src="Gambar/<?= $row['Gambar'];?>"alt="<?= $row['Nama'];?>"></td>
                <td><?= $row['Nama'];?></td>
                <td><?= $row['Kategori'];?></td>
                <td><?= $row['Harga_Beli'];?></td>
                <td><?= $row['Harga_Jual'];?></td>
                <td><?= $row['Stok'];?></td>
                <td>
                    <a class="tombol3" href="ubah.php?id=<?= $row['Id_Barang'];?>">Ubah</a>
                    <a class="tombol3" href="hapus.php?id=<?= $row['Id_Barang'];?>">Hapus</a> 
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>
            <?php endif; ?>
            </table>
            <nav aria-label="Page navigation example">
            <ul class = "pagination">
                <li class="page-item">
					<a class="page-link" <?php if($page > 1){ echo "href='?page=$previous'"; } ?>>Previous</a>
				</li>
                <?php for ($i=1; $i <= $num_page; $i++) {
                    $link = "?page={$i}";
                    if (!empty($q)) $link .= "&q={$q}";
                    $class = ($page == $i ? 'active' : '');
                    echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
                } ?>
                
                <li class="page-item">
					<a  class="page-link" <?php if($offset < $page){ echo "href='?page=$next'"; } ?>>next</a>
				</li>
            </ul>
            </nav>
        </div>
    </div>
</body>
</html>