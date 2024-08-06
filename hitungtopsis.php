<?php
include "header.php";
include "menu.php";
include("connect.php"); // Ensure this contains MySQLi connection code

// Error reporting configuration
ini_set("display_errors", 1);
error_reporting(E_ALL);

?>

<div class="page-wrapper">
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-block">
        <h1 class="mt-5">Cari Kriteria Menggunakan Nilai BOBOT (W)</h1>

<div class="panel panel-default">
  <div class="panel-body">
    <div>
      <div class="row">
        <div class="col-md-12">
          <?php
          function tampiltabel($arr) {
              echo '<table class="table table-bordered table-highlight">';
              foreach ($arr as $row) {
                  echo '<tr>';
                  foreach ($row as $cell) {
                      echo '<td>' . htmlspecialchars($cell) . '</td>';
                  }
                  echo '</tr>';
              }
              echo '</table>';
          }

          function tampilbaris($arr) {
              echo '<table class="table table-bordered table-highlight">';
              echo '<tr>';
              foreach ($arr as $item) {
                  echo '<td>' . htmlspecialchars($item) . '</td>';
              }
              echo '</tr>';
              echo '</table>';
          }

          function tampilkolom($arr) {
              echo '<table class="table table-bordered table-highlight">';
              foreach ($arr as $item) {
                  echo '<tr>';
                  echo '<td>' . htmlspecialchars($item) . '</td>';
                  echo '</tr>';
              }
              echo '</table>';
          }

          // Check for connection error
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          if (!isset($_POST['submit'])) {
          ?>

          <script src="js/jquery.js"></script>
          <script src="js/validator.min.js"></script>

          <script>
          $(document).ready(function() {
              $('form').parsley();
          });
          </script>

<form name="form1" data-toggle="validator" role="form" method="POST" action="">
<br>
<div class="row">
  <div class="col-sm-12">
      <table class="table table-sm">
          <thead>
              <tr>
                  <th id="ignore" bgcolor="#DBEAF5" width="400" colspan="2">
                      <div align="center">
                          <strong><font size="2" face="Arial, Helvetica, sans-serif">BOBOT KEPENTINGAN KRITERIA</font></strong>
                      </div>
                  </th>
              </tr>
          </thead>
          <tbody>
              <?php
              $result = $conn->query("SELECT * FROM kriteria ORDER BY CASE nama_kriteria
              WHEN 'Akreditasi Univ' THEN 1
              WHEN 'Biaya' THEN 2
              WHEN 'Akreditasi Jurusan' THEN 3
              WHEN 'Jarak' THEN 4
              WHEN 'Fasilitas' THEN 5
              ELSE 6
              END
              ");
              while ($row = $result->fetch_assoc()) {
              ?>
              <tr>
                  <td width="200">
                      <?php echo htmlspecialchars($row['nama_kriteria']); ?> (<?php echo htmlspecialchars($row['atribut']); ?>)
                  </td>
                  <td width="200">
                      <div class="form-group">
                          <?php
                          $query = $conn->query("SELECT * FROM kriteria INNER JOIN t_kriteria ON kriteria.id_kriteria = t_kriteria.id_kriteria AND t_kriteria.id_kriteria='{$row['id_kriteria']}'");
                          while ($data = $query->fetch_assoc()) {
                          ?>
                          <div class="form-check">
                                  <input class="form-check-input" id="flexRadioDefault<?= htmlspecialchars($data['id_tkriteria']); ?>" value="<?= htmlspecialchars($data['nkriteria']); ?>" type="radio" name="kepentingan<?= $row['id_kriteria']; ?>" value="<?= htmlspecialchars($data['nkriteria']); ?>"> 
                                  <label class="form-check-label" for="flexRadioDefault<?= htmlspecialchars($data['id_tkriteria']); ?>">
                                  <?php echo htmlspecialchars($data['keterangan']); ?> [<?php echo htmlspecialchars($data['nkriteria']); ?>]
                                  </label>
                          </div>
                          <?php
                          }
                          ?>
                          <div class="help-block with-errors"></div>
                      </div>
                  </td>
              </tr>
              <?php
              }
              ?>

              <tr>
                  <td colspan="2">
                      <input class="btn btn-success" type="submit" name="submit" value="Proses">
                  </td>
              </tr>
          </tbody>
      </table>
  </div>
</div>
</form>

          <?php
          } else {
              // Process the form data
              $alternatif = array();
              $hp = array();
              $nama = array();
              $alamat = array();
              $queryalternatif = $conn->query("SELECT * FROM pemilik ORDER BY id_pemilik");
              while ($dataalternatif = $queryalternatif->fetch_assoc()) {
                  $alternatif[] = $dataalternatif['nama_kos'];
                  $hp[] = $dataalternatif['telepon'];
                  $nama[] = $dataalternatif['nama'];
                  $alamat[] = $dataalternatif['alamat'];

                  
              }
              // var_dump($_POST);
              $kriteria = array();
              $costbenefit = array();
              $kepentingan = array();

              $querykriteria = $conn->query("SELECT * FROM kriteria ORDER BY id_kriteria");
              while ($datakriteria = $querykriteria->fetch_assoc()) {
                  $kriteria[] = $datakriteria['nama_kriteria'];
                  $costbenefit[] = $datakriteria['atribut'];
                  $kepentingan[] = $_POST['kepentingan' . $datakriteria['id_kriteria']];
                  // echo $_POST['kepentingan' . $datakriteria['id_kriteria']];
              }
              // die;

              $alternatifkriteria = [];
              $queryalternatif = $conn->query("SELECT * FROM pemilik ORDER BY id_pemilik");
              $index = 0;
              while ($dataalternatif = $queryalternatif->fetch_assoc()) {
                  $querykriteria = $conn->query("SELECT * FROM kriteria ORDER BY id_kriteria");
                  array_push($alternatifkriteria, []);
                  while ($datakriteria = $querykriteria->fetch_assoc()) {
                      $queryalternatifkriteria = $conn->query("SELECT * FROM analisa WHERE id_pemilik = '{$dataalternatif['id_pemilik']}' AND id_kriteria = '{$datakriteria['id_kriteria']}'");
                      $dataalternatifkriteria = $queryalternatifkriteria->fetch_assoc();
                      array_push($alternatifkriteria[$index],$dataalternatifkriteria['nilainya'] ?? 0);
                  }
                  // echo $dataalternatifkriteria['nilainya'];
                  $index++;
              };

              $pembagi = array();
              foreach ($kriteria as $i => $criterion) {
                  $pembagi[$i] = 0;
                  foreach ($alternatif as $j => $alt) {
                      $pembagi[$i] += pow($alternatifkriteria[$j][$i], 2);
                  }
                  $pembagi[$i] = sqrt($pembagi[$i]);
              }

              $normalisasi = array();
              foreach ($alternatif as $i => $alt) {
                  foreach ($kriteria as $j => $criterion) {
                      $normalisasi[$i][$j] = $alternatifkriteria[$i][$j] / $pembagi[$j];
                  }
              }

              $terbobot = array();
              foreach ($alternatif as $i => $alt) {
                  foreach ($kriteria as $j => $criterion) {
                      $terbobot[$i][$j] = $normalisasi[$i][$j] * $kepentingan[$j];
                  }
              }

              $aplus = array();
              foreach ($kriteria as $i => $criterion) {
                  if ($costbenefit[$i] == 'cost') {
                      $aplus[$i] = min(array_column($terbobot, $i));
                  } else {
                      $aplus[$i] = max(array_column($terbobot, $i));
                  }
              }

              $amin = array();
              foreach ($kriteria as $i => $criterion) {
                  if ($costbenefit[$i] == 'cost') {
                      $amin[$i] = max(array_column($terbobot, $i));
                  } else {
                      $amin[$i] = min(array_column($terbobot, $i));
                  }
              }

              $dplus = array();
              foreach ($alternatif as $i => $alt) {
                  $dplus[$i] = 0;
                  foreach ($kriteria as $j => $criterion) {
                      $dplus[$i] += pow($aplus[$j] - $terbobot[$i][$j], 2);
                  }
                  $dplus[$i] = sqrt($dplus[$i]);
              }

              $dmin = array();
              foreach ($alternatif as $i => $alt) {
                  $dmin[$i] = 0;
                  foreach ($kriteria as $j => $criterion) {
                      $dmin[$i] += pow($terbobot[$i][$j] - $amin[$j], 2);
                  }
                  $dmin[$i] = sqrt($dmin[$i]);
              }

              $hasil = array();
              foreach ($alternatif as $i => $alt) {
                  $hasil[$i] = $dmin[$i] / ($dplus[$i] + $dmin[$i]);
              }

              $hasilrangking = $hasil;
              $alternatifrangking = $alternatif;
              $hp1 = $hp;
              $nama1 = $nama;
              $alamat1 = $alamat;
              array_multisort($hasilrangking, SORT_DESC, $alternatifrangking, $hp1, $nama1, $alamat1);

              ?>

              <br />
              <!-- <h4 class="heading">Alternatif :</h4>
              <?php tampilbaris($alternatif); ?>
              <br />
              <h4 class="heading">Kriteria :</h4>
              <?php tampilbaris($kriteria); ?>
              <br />
              <h4 class="heading">Costbenefit :</h4>
              <?php tampilbaris($costbenefit); ?>
              <br />
              <h4 class="heading">Kepentingan :</h4>
              <?php tampilbaris($kepentingan); ?>
              <br /> -->
              <!-- <h4 class="heading">Alternatif Kriteria :</h4>
              <?php tampiltabel($alternatifkriteria); ?>
              <br />
              <h4 class="heading">Pembagi :</h4>
              <?php tampilbaris($pembagi); ?>
              <br />
              <h4 class="heading">Normalisasi :</h4>
              <?php tampiltabel($normalisasi); ?>
              <br />
              <h4 class="heading">Terbobot :</h4>
              <?php tampiltabel($terbobot); ?>
              <br />
              <h4 class="heading">A+ :</h4>
              <?php tampilbaris($aplus); ?>
              <br />
              <h4 class="heading">A- :</h4>
              <?php tampilbaris($amin); ?>
              <br />
              <h4 class="heading">D+ :</h4>
              <?php tampilkolom($dplus); ?>
              <br />
              <h4 class="heading">D- :</h4>
              <?php tampilkolom($dmin); ?>
              <br />
              <h4 class="heading">Hasil :</h4>
              <?php tampilkolom($hasil); ?>
              <br />
              <h4 class="heading">Hasil Ranking :</h4>
              <?php tampilkolom($hasilrangking); ?> -->
              <br />
              <h4 class="heading">Alternatif Ranking :</h4>
              <?php tampilkolom($alternatifrangking); ?>
              <br />
              <h4 class="heading">Alternatif Terbaik :</h4>
              <h4 class="heading">
                  <span class="label label-success"><?php echo htmlspecialchars($alternatifrangking[0]); ?></span>
              </h4>
              <h4 class="heading">Contact Person :</h4>
              <h4 class="heading">
                  <span class="label label-primary"><?php echo ($nama1[0]). "&nbsp &nbsp &nbsp". $hp1[0]; ?></span>
              </h4>
              <h4 class="heading">Address Univ :</h4>
              <h4 class="heading">
                  <span class="label label-primary"><?php echo $alamat1[0]; ?></span>
              </h4>
              <br />
              <?php
          }
          
          $conn->close();
          ?>
        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div>
  </div>
</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>


