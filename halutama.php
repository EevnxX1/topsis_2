<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "header.php";
include "menu.php";
?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="m-b-0 m-t-0" style="color: #6E7BF5;">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-block">
                        <?php if ($_SESSION['status'] == 'admin'): ?>
                            <!-- <h1 class="mt-5"><p align="center">Halaman Utama Administrator</p></h1>
                            <p class="lead" align="center">
                                SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN UNIVERSITAS TERBAIK<br>MENGGUNAKAN METODE TOPSIS
                            </p>
                            <p class="lead" align="center"><img src="assets/images/logo1.png" align="center" width="150"></p> -->
                            
                            <div style="background-image: url('assets/bg.png'); width: 100%; height: 70vh; position: relative;">
                                <!-- Asset -->
                                 <div style="position: absolute; top: 0; left: 150px;">
                                    <img src="assets/Group 6.png" style="width: 50vh;" alt="aksessoris">
                                 </div>
                                 <div style="position: absolute; bottom: 0; rotate: 180deg; right: 0;">
                                    <img src="assets/Group 6.png" style="width: 65vh;" alt="aksessoris">
                                 </div>
                                <!-- Asset -->
                                <div style="display: flex; justify-content: space-between; align-items: end; height: 100%; padding: 0 40px; position: relative; z-index: 10;">
                                    <div style="height: 50%; display: flex; flex-direction: column;">
                                        <h1 style="font-weight: bold;">Selamat Datang Di Website</h1>
                                        <h2>Pencarian Universitas Terbaik</h2>
                                    </div>
                                    <div>
                                        <img src="assets/Frame 1.png" style="width: 40vw;" alt="people">
                                    </div>
                                </div>
                            </div>
                            <div style="background-color: #6E7BF5; width: 100%; display: flex; justify-content: center; padding-top: 50px;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="margin-bottom: 40px;">
                                            <h1 style="font-size: 30px; color: white; font-weight: bold; text-align: center;">Raih Masa Depan dengan <br>
                                            pilihan Universitas Terbaikmu!</h1>
                                        </div>
                                        <div>
                                            <img src="assets/Frame 2.png" style="width: 40vw;" alt="people">
                                        </div>
                                    </div>
                                </div>
                        <!-- <?php elseif ($_SESSION['status'] == 'pemilik'): ?>
                            <h1 class="mt-5"><p align="center">Anda Login Sebagai Pemilik Kos</p></h1>
                            <p align="center">
                                SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN INDEKOS TERBAIK DI SEKITAR KAMPUS<br>MENGGUNAKAN METODE TOPSIS
                            </p>
                            <p class="lead" align="center"><img src="assets/images/logo1.png" align="center" width="150"></p>
                            <table class="table table-sm" align="left">
                                <tr><td>Nama</td><td>: <?php echo $_SESSION['nama']; ?></td></tr>
                                <tr><td>Alamat</td><td>: <?php echo $_SESSION['alamat']; ?></td></tr>
                                <tr><td>No. telepon</td><td>: <?php echo $_SESSION['telepon']; ?></td></tr>
                                <tr><td>Email</td><td>: <?php echo $_SESSION['email']; ?></td></tr>
                                <tr><td>Login Sebagai</td><td>: <?php echo $_SESSION['status'] == 'user' ? 'Pencari Kos' : 'Pemilik Kos'; ?></td></tr>
                            </table>
                        <?php elseif ($_SESSION['status'] == 'user'): ?>
                            <h1 class="mt-5"><p align="center">Anda Login Sebagai Pencari Universitas</p></h1>
                            <p align="center">
                                SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN UNIVERSITAS TERBAIK<br>MENGGUNAKAN METODE TOPSIS
                            </p>
                            <p class="lead" align="center"><img src="assets/images/logo1.png" align="center" width="80"></p>
                            <table class="table table-sm" align="left">
                                <tr><td>Nama</td><td>: <?php echo $_SESSION['nama']; ?></td></tr>
                                <tr><td>Alamat</td><td>: <?php echo $_SESSION['alamat']; ?></td></tr>
                                <tr><td>No. telepon</td><td>: <?php echo $_SESSION['telepon']; ?></td></tr>
                                <tr><td>Email</td><td>: <?php echo $_SESSION['email']; ?></td></tr>
                                <tr><td>Login Sebagai</td><td>: <?php echo $_SESSION['status'] == 'user' ? 'Pencari Kos' : 'Pemilik Kos'; ?></td></tr>
                            </table> -->
                        <?php else: ?>
                            <div style="background-image: url('assets/bg.png'); width: 100%; height: 70vh; position: relative;">
                                <!-- Asset -->
                                 <div style="position: absolute; top: 0; left: 150px;">
                                    <img src="assets/Group 6.png" style="width: 50vh;" alt="aksessoris">
                                 </div>
                                 <div style="position: absolute; bottom: 0; rotate: 180deg; right: 0;">
                                    <img src="assets/Group 6.png" style="width: 65vh;" alt="aksessoris">
                                 </div>
                                <!-- Asset -->
                                <div style="display: flex; justify-content: space-between; align-items: end; height: 100%; padding: 0 40px; position: relative; z-index: 10;">
                                    <div style="height: 50%; display: flex; flex-direction: column;">
                                        <h1 style="font-weight: bold;">Selamat Datang Di Website</h1>
                                        <h2>Pencarian Universitas Terbaik</h2>
                                    </div>
                                    <div>
                                        <img src="assets/Frame 1.png" style="width: 40vw;" alt="people">
                                    </div>
                                </div>
                            </div>
                            <div style="background-color: #6E7BF5; width: 100%; display: flex; justify-content: center; padding-top: 50px;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="margin-bottom: 40px;">
                                            <h1 style="font-size: 30px; color: white; font-weight: bold; text-align: center;">Raih Masa Depan dengan <br>
                                            pilihan Universitas Terbaikmu!</h1>
                                        </div>
                                        <div>
                                            <img src="assets/Frame 2.png" style="width: 40vw;" alt="people">
                                        </div>
                                    </div>
                                </div>
                        <!-- <?php endif; ?> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
