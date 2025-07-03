<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

<?php 
function curl(){ 
    $curl = curl_init(); 
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost:8080/api",
        CURLOPT_RETURNTRANSFER => true, 
        CURLOPT_CUSTOMREQUEST => "GET", 
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: random123678abcghi", // Ganti sesuai kunci API kamu
        ),
    ));
    $output = curl_exec($curl); 	
    curl_close($curl);      
    return json_decode($output);
} 
?>

<div class="p-3 pb-md-4 mx-auto text-center">
  <h1 class="display-4 fw-normal text-body-emphasis">Dashboard - TOKO</h1>
  <p class="fs-5 text-body-secondary"><?= date("l, d-m-Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
</div> 

<hr>

<div class="table-responsive card m-5 p-5">
  <table class="table text-center table-bordered">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Alamat</th>
        <th>Total Harga</th>
        <th>Ongkir</th>
        <th>Jumlah Item</th> <!-- ✅ Tambahan sesuai soal -->
        <th>Status</th>
        <th>Tanggal Transaksi</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $data = curl();
      if (!empty($data) && $data->status->code == 200) {
        $i = 1;
        foreach ($data->results as $item) {
      ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($item->username) ?></td>
          <td><?= htmlspecialchars($item->alamat) ?></td>
          <td><?= number_format($item->total_harga) ?></td>
          <td><?= number_format($item->ongkir) ?></td>
          <td><?= $item->jumlah_item ?? 0 ?></td> <!-- ✅ tampilkan jumlah item -->
          <td><?= $item->status == 0 ? 'Belum Diproses' : 'Selesai' ?></td>
          <td><?= date('d-m-Y H:i', strtotime($item->created_at)) ?></td>
        </tr>
      <?php 
        }
      } else {
        echo '<tr><td colspan="8">Tidak ada data transaksi.</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div> 

<script>
  function waktu() {
    const waktu = new Date();
    document.getElementById("jam").innerHTML = waktu.getHours().toString().padStart(2, '0');
    document.getElementById("menit").innerHTML = waktu.getMinutes().toString().padStart(2, '0');
    document.getElementById("detik").innerHTML = waktu.getSeconds().toString().padStart(2, '0');
    setTimeout(waktu, 1000);
  }
  waktu();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
