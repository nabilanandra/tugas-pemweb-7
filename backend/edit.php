<?php 
session_start();
if ($_SESSION['role'] != 'admin') {
    echo "
    <script>
    alert('Halaman ini hanya bisa di akses oleh admin');
    window.location = '../profile.php';
    </script>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../plugin/css/bootstrap.min.css">
    <title>Edit Data</title>
</head>
<body>
<div style="border: none !important" class="card m-1">
<div class="card-body">
<form method="post" enctype="multipart/form-data">
    <h2>Edit Data</h2>
  <div class="mb-3">
    <label for="Name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="Name" aria-describedby="emailHelp" required value="<?php echo $row['name']; ?>">
  </div>
  <div class="mb-3">
    <label for="Price" class="form-label">Price</label>
    <input type="number" name="price" class="form-control" id="Price" aria-describedby="emailHelp" required value="<?php echo $row['price']; ?>">
  </div>
  <div class="mb-3">
    <label for="Image" class="form-label">Image</label>
    <input type="file" name="image" class="form-control" id="Image" aria-describedby="emailHelp" required>
  </div>
  <a class="btn btn-danger" href="../show.php">Cancel</a>
  <input type="submit" name="update" class="btn btn-primary" value="Edit">
</form>
</div>
</div>
</body>
</html>

<?php
require_once("../config/db.php");

$base_url = "http://localhost/pemweb-otorisasi-main/upload";
$id = $_GET['id'];
$data = mysqli_query($db_connect, "SELECT * FROM products WHERE id = $id");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tempImage = $_FILES['image']['tmp_name'];
    $imageInfo = getimagesize($tempImage);
    if ($imageInfo === false) {
        echo "
        <script>
        alert('File yang diunggah bukan file gambar');
        window.location = '../show.php';
        </script>
        ";
        exit;
    }
    $randomFilename = time() . '-' . md5(rand()) . '-' . $image;
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/tugas-pertemuan-7/upload/' . $randomFilename;
    $upload = move_uploaded_file($tempImage, $uploadPath);
    echo $upload;
    if ($upload) {
        $updateQuery = "UPDATE products SET 
        name = '$name', 
        price = '$price', 
        image = '/upload/$randomFilename'
        WHERE id = $id";

        if (mysqli_query($db_connect, $updateQuery)) {
            echo "
            <script>
            alert('Data berhasil diubah');
            window.location = '../show.php';
            </script>
            ";
        } else {
            echo "
            <script>
            alert$upload('Data gagal diubah. Error: " . mysqli_error($db_connect) . "');
            window.location = '../show.php';
            </script>
            ";
        }
    } else {
        // echo 
        
        // <script>
        // alert('Gagal mengunggah file');
        // window.location = '../show.php';
        // </script>
        ;
    }
}
?>