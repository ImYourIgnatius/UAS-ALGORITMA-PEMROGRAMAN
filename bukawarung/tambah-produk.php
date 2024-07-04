<?php
    session_start();
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }
    include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Warung</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

</head>
<body>
    <!-- Header -->
     <header>
        <div class="container">
        <h1 href="dasboard.php">BukaWarung</h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
            </div>
     </header>

     <!-- Content -->
      <div class="section">
        <div class="container">
            <h3>Tambah Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" id="" required>
                        <option value="">--Pilih--</option>
                        <?php
                            $kategory = mysqli_query($con, "SELECT * FROM tb_category ORDER BY category_id DESC");
                            while($r = mysqli_fetch_array($kategory)){
                        ?>
                        <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Nama produk" required>
                    <input type="text" name="harga" class="input-control" placeholder="Harga" required>
                    <input type="file" name="gambar" class="input-control" required>
                    <textarea name="deskripsi" class="input-control" placeholder="Deskripsi"></textarea><br>
                    <select name="status" class="input-control">
                        <option value="">--Pilih--</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>

                <?php
                if(isset($_POST['submit'])){
                    
                //    print_r($_FILES['gambar']);
                // menampung inputan dari form
                $kategori   = $_POST['kategori'];
                $nama       = $_POST['nama'];
                $harga      = $_POST['harga'];
                $deskripsi  = $_POST['deskripsi'];
                $status     = $_POST['status'];
                // menampung data file yang di upload
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];

                $type1 = explode('.', $filename);
                $type2 = $type1[1];

                $newname = 'produk'.time().'.'.$type2;

                // menampung data format file yang di izinkan di upload
                $type_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
                
                //validasi format file
                if(!in_array($type2, $type_diizinkan)){
                    // format file tidak di izinkan
                    echo '<script>alert("Format File Tidak di Izinkan")</script>';
                }
                else{
                    //  jika format file benar maka akan diteruskan ke database
                    //  proses upload file sekaligus insert database
                    move_uploaded_file($tmp_name, './produk/'.$newname);

                    $insert = mysqli_query($con, "INSERT INTO tb_product VALUES (
                                null,
                                '".$kategori."',
                                '".$nama."',
                                '".$harga."',
                                '".$deskripsi."',
                                '".$newname."',
                                '".$status."',
                                    null
                                ) ");
                if($insert){
                    echo '<script>alert("Tambah data berhasil")</script>';
                    echo '<script>window.location="data-produk.php"</script>';
                }
                else{
                    echo 'gagal'.mysqli_error($con);
                }

                }
        }
            ?>


            </div>
        </div>
      </div>


    <!-- Footer -->
     <footer>
     <div class="container">
        <small>Copyright &copy; 2024 - BukaWarung</small>
     </div>
     </footer>
     <script>
        ClassicEditor
            .create( document.querySelector( 'textarea[name="deskripsi"]' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>
