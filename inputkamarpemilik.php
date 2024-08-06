<?php
include "header.php";
include "menu.php";
include "connect.php";

// Secure session handling
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page or show an error message
    header("Location: login.php");
    exit();
}

$id = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $pemilik=$_POST['pemilik'];
    $deskripsi=$_POST['deskripsi'];
    // $fasilitas=$_POST['fasilitas'];
    $harga=$_POST['harga'];
    $tipe=$_POST['tipe'];
    $type=$_POST['type'];

      $lokasi_file1 = $_FILES['fupload1']['tmp_name'];
      $nama_file1   = $_FILES['fupload1']['name'];

      $lokasi_file2 = $_FILES['fupload2']['tmp_name'];
      $nama_file2   = $_FILES['fupload2']['name'];

      $lokasi_file3 = $_FILES['fupload3']['tmp_name'];
      $nama_file3   = $_FILES['fupload3']['name'];

      $lokasi_file4 = $_FILES['fupload4']['tmp_name'];
      $nama_file4   = $_FILES['fupload4']['name'];

    // if(isset($deskripsi,$fasilitas,$harga)){
    //   if((!$deskripsi)||(!$fasilitas)||(!$harga)){
    //   print "<script>alert ('Harap semua data diisi...!!');</script>";
    //   print"<script> self.history.back('Gagal Menyimpan');</script>"; 
    //   exit();
    //   } 

    move_uploaded_file($lokasi_file1,"images/kamar/$nama_file1");

    move_uploaded_file($lokasi_file2,"images/kamar/$nama_file2");

    move_uploaded_file($lokasi_file3,"images/kamar/$nama_file3");

    move_uploaded_file($lokasi_file4,"images/kamar/$nama_file4");

    $add_kelas="INSERT INTO kamar(id_pemilik, tipe, deskripsi, harga, tipeharga, gambar1, gambar2, gambar3, gambar4, status) VALUES 
    ('$pemilik','$tipe','$deskripsi', '$harga','$type','$nama_file1','$nama_file2','$nama_file3','$nama_file4','y')";
    // mysql_query($add_kelas,$conn);
    $conn->query($add_kelas);
    $hasil_input = $add_kelas;
    var_dump($hasil_input);

}
// Ensure database connection and prepare statements are used correctly
$show_kelas = "SELECT * FROM pemilik WHERE user = '". $id . "' ";
// $stmt = $conn->prepare($show_kelas);
// if ($stmt === false) {
//     die("Error preparing statement: " . $conn->error);
// }

// $stmt->bind_param("s", $id);
// $stmt->execute();

if ($conn->connect_error) {
    # code...
    die("Error preparing statement: " . $conn->connect_error);

}

$result = $conn->query($show_kelas);
$resultpemilik = $result->fetch_assoc();
// var_dump($resultpemilik);
// $hasil_kelas = $stmt->get_result();
// $view_kelas = $hasil_kelas->fetch_assoc();
// if ($view_kelas) {
//     $idpemilik = $view_kelas['id'];
// } else {
//     echo "<div class='alert alert-danger'>Pemilik tidak ditemukan atau terjadi kesalahan.</div>";
//     $idpemilik = ''; // Make sure $idpemilik is set to an empty string if not found
// }
// $stmt->close();

?>
<div class="page-wrapper">
<div class="container">
    <h1 class="mt-5">Input Kamar Pemilik Kos</h1>
    <div class="row">
        <div class="col-lg-8">
            <?php
            if (!empty($resultpemilik)) {
                $kamarquery = "SELECT * FROM kamar WHERE id_pemilik = '" . $resultpemilik['id_pemilik'] ."'";
                // $stmt2 = $conn->prepare($a);
                // if ($stmt2 === false) {
                //     die("Error preparing statement: " . $conn->error);
                // }
                // $stmt2->bind_param("s", $idpemilik);
                // $stmt2->execute();
                // $b = $stmt2->get_result();

                if ($conn->connect_error) {
                    # code...
                    die("Error preparing statement: " . $conn->connect_error);
                
                }

                $kamar = $conn->query($kamarquery);
                $resultkamar = $kamar->fetch_assoc();

                if ($kamar->num_rows > 0) {
                    echo '
                    <div class="table-responsive">
                        <br>
                        <p align="center">
                            <img src="images/sr1-icon-noResult.png"><br><br>
                            <strong>Maaf!! Kamar Sudah Terisi</strong>
                        </p>
                    </div>';
                } else {
                    ?>
                    <div class="table-responsive">
                        <form action="inputkamarpemilik.php?submit=simpan" class="form-horizontal" data-toggle="validator" role="form" method="post" enctype="multipart/form-data">
                            <table class="table" align="left">
                                <tr>
                                    <td>ID Pemilik Kos</td>
                                    <td><input readonly type="text" class="form-control" name="pemilik" value="<?php echo ($resultpemilik['id_pemilik']); ?>"></td>
                                </tr>
                                <?php
                                $q = $conn->query("SELECT * FROM kriteria ORDER BY id_kriteria");
                                while ($r = $q->fetch_assoc()) {
                                    ?>
                                    <!-- <tr>
                                        <td width="200"><?php echo htmlspecialchars($r['nama_kriteria']); ?> (<?php echo htmlspecialchars($r['atribut']); ?>)</td>
                                        <td width="200">
                                            <div class="form-group">
                                                <?php
                                                $querykriteria = $conn->prepare("SELECT * FROM kriteria, t_kriteria WHERE kriteria.id_kriteria = t_kriteria.id_kriteria AND t_kriteria.id_kriteria = ?");
                                                if ($querykriteria === false) {
                                                    die("Error preparing statement: " . $conn->error);
                                                }

                                                $querykriteria->bind_param("i", $r['id_kriteria']);
                                                $querykriteria->execute();
                                                $resultKriteria = $querykriteria->get_result();
                                                while ($datakriteria = $resultKriteria->fetch_assoc()) {
                                                    ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" required type="radio" name="kepentingan<?php echo $datakriteria['id_kriteria']; ?>" value="<?php echo $datakriteria['nkriteria']; ?>" id="radioBag<?php echo $datakriteria['id_tkriteria']; ?>" >
                                                        <label class="form-check-label" for="radioBag<?php echo $datakriteria['id_tkriteria']; ?>">
                                                            <?php echo htmlspecialchars($datakriteria['keterangan']); ?> 
                                                        </label>
                                                    </div>
                                                    <?php
                                                }

                                                $querykriteria->close();
                                                ?>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </td>
                                    </tr> -->
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td>Deskripsi Kamar</td>
                                    <td><textarea class="form-control" name="deskripsi" rows="5" cols="50"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Strata</td>
                                    <td><select class="form-control" name="tipe">
                                        <option value="0" selected>- Pilih Tipe -</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="D3">D3</option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td>Tipe universitas</td>
                                    <td>
                                        <select class="form-control" name="type">
                                            <option value="0" selected>- Pilih -</option>
                                            <option value="PTN">PTN</option>
                                            <option value="Swasta">Swasta</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Harga Biaya Masuk</td>
                                    <td><input type="text" class="form-control" name="harga" required></td>
                                </tr>
                                <tr>
                                    <td>Gambar1</td>
                                    <td><input type="file" name="fupload1" accept="image/*"></td>
                                </tr>
                                <tr>
                                    <td>Gambar2</td>
                                    <td><input type="file" name="fupload2" accept="image/*"></td>
                                </tr>
                                <tr>
                                    <td>Gambar3</td>
                                    <td><input type="file" name="fupload3" accept="image/*"></td>
                                </tr>
                                <tr>
                                    <td>Gambar4</td>
                                    <td><input type="file" name="fupload4" accept="image/*"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input id="btn-fblogin" class="btn btn-primary" name="submit" type="submit" value="Input Data" /></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <?php
                }
                // $stmt2->close();
            } else {
                echo "<div class='alert alert-danger'>Tidak ada data pemilik yang ditemukan.</div>";
            }
            ?>
        </div>
    </div>
</div>
</div>
<?php include "footer.php"; ?>

<!-- JS Libraries -->
<script src="js/jquery.js"></script>
<script src="js/validator.min.js"></script>
<script>
$(document).ready(function(){
    $('form').parsley();
});
</script>
<?php



?>