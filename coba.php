<!-- untuk menampilkan form di html -->
<form action="coba.php" method="post">
  <input type="text" name="sql" placeholder="Masukan sql di sini">
  <button type="submit">Jalankan</button>
</form>

<?php
// menangani jika request post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $connect = mysqli_connect("localhost", "ibbor", "@Gaktaugwlupa0", "keuangan") or die('Unable to Connect');
  $query = $_POST["sql"]; // menerima string dari method post

  // mencegah dari orang iseng untuk delete, insert, atau update data nya
  if (stristr($query, 'delete') !== false || stristr($query, 'insert') !== false || stristr($query, 'update') !== false) {
    echo "jangan iseng";
  } else {
    $result = mysqli_query($connect,$query); // eksekusi kueri

    // pengecekan apakah query nya benar atau salah
    if (!mysqli_query($connect, $query)) echo mysqli_errno($connect) . ": " . mysqli_error($connect) . "\n"; // jika salah, menampilkan error
    else {
      // jika benar, menampilkan data yang didapat
      while ($row = mysqli_fetch_assoc($result)) { ?>
        <h6><?php echo $row["no"].". ".$row["name"]; ?></h6>
      <?php }
    }
  }
  // menutup koneksi database
  mysqli_close($connect);
}
?>
