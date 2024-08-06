<?php
session_start();
ini_set("display_errors", "Off");
include("connect.php");
include "header.php";

$id = $_SESSION['username'];
$show_kelas = "SELECT * FROM pemilik WHERE user = '$id'";
$hasil_kelas = mysqli_query($conn, $show_kelas);

if ($view_kelas = mysqli_fetch_assoc($hasil_kelas)) {
    $idpemilik = $view_kelas['id_pemilik'];
?>

<div class="container contentAllCK">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 listing-wrapper">
            <div></div>
            <h1 class="listingTitle">LIST KAMAR PEMILIK KOS</h1>
            <div class="col-md-12 removePadding showDesktop">
                <div style="margin-bottom:20px;">
                    <div class="table-responsive">
                        <?php
                        $a = "SELECT * FROM kamar WHERE id_pemilik = '$idpemilik'";
                        $b = mysqli_query($conn, $a);

                        if (mysqli_num_rows($b) > 0) {
                        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Gambar</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($conn, "SELECT * FROM kamar WHERE id_pemilik = '$idpemilik' GROUP BY id_pemilik DESC");
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($sql)) {
                                            $harga = number_format($row['harga'], 2, ",", ".");
                                        ?>
                                            <tr class='td' bgcolor='#FFF'>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo '<img src="images/kamar/' . htmlspecialchars($row['gambar1']) . '" width="80">'; ?></td>
                                                <td>Rp.<?php echo $harga; ?></td>
                                                <td>
                                                    <a href="javascript:KonfirmasiHapus('deletekamarpemilik.php?idk=<?php echo $row['id_kamar']; ?>')">Hapus</a> |
                                                    <a href="detailkamar.php?idk=<?php echo $row['id_kamar']; ?>">Detail</a>
                                                </td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        } else {
                            echo '
                            <div class="table-responsive">
                            <br>
                              <p align="center">
                                <img src="images/sr1-icon-noResult.png"><br><br>
                                <strong>Maaf!! Kamar masih kosong, silahkan isi kamar anda.</strong>
                              </p>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<?php
} else {
?>
<div class="container contentAllCK">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 listing-wrapper">
            <div class="table-responsive">
                <div class="alert alert-danger">
                    <strong>Maaf, Anda harus mengisi biodata pemilik kos terlebih dahulu</strong>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
