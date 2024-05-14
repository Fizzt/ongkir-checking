<?php

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "key: aafdebd89a242abaae74db8f516cd7d6"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // echo $response;
    $data = json_decode($response);
    // echo "<pre>"; print_r($data); echo "</pre>";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Web Ongkos Kirim</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="jumbotron text-center bg-primary text-white">
    <h1>Cek Ongkos Kirim by TKJ</h1>
    <p>Ingin tahu berapa ongkos kirim kamu? Ayo segera cek di sini!</p> 
  </div>
    
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="">
          <h3>Kota Asal</h3>
          <div class="form-group">
            <label>Pilih provinsi:</label>
            <select name="provinsi_asal" id="pronsi_asal" class="form-control" onchange="cariKotaAsal(this.value)">
              <option>-- pilih provinsi --</option>
              <?php 
                foreach ($data->rajaongkir->results as $provinsi) {
                  echo '<option value="'.$provinsi->province_id.'">'.$provinsi->province.'</option>';
                }
              ?>
            </select>
            <br>
            <label>Pilih kota asal:</label>
            <select name="kota_asal" id="kota_asal" class="form-control">
              <option>-- pilih kota--</option>
            </select>
          </div>
        </div>
        <div class="">
          <h3>Kota Tujuan</h3>
          <div class="form-group">
            <label>Pilih provinsi:</label>
            <select name="provinsi_tujuan" class="form-control" onchange="cariKotaTujuan(this.value)">
              <option>-- pilih provinsi --</option>
              <?php 
                foreach ($data->rajaongkir->results as $provinsi) {
                  echo '<option value="'.$provinsi->province_id.'">'.$provinsi->province.'</option>';
                }
              ?>
            </select>
            <br>
            <label>Pilih kota tujuan:</label>
            <select name="kota_tujuan" id="kota_tujuan" class="form-control">
              <option>-- pilih kota --</option>
            </select>
          </div>
        </div>
        <div class="">
          <h3>Berat Paket & Kurir</h3>        
          <p>
            Berat Paket:<br>
            <input id="berat_paket" type="text" name="berat_paket">
          </p>
          <p>
            Pilih Kurir:<br>
            <select id="kurir" name="kurir">
              <option value="jne">JNE</option>
              <option value="tiki">TIKI</option>
              <option value="pos">Pos Indonesia</option>
            </select>
          </p>
        </div>
      </div>
      <br>
        <div class="col-sm-6">
          <div class="row">
            <div class="col-6">
              <h3>Cek Ongkos Kirim</h3><br>
              <div id="hasil_cek_ongkir"></div>
            </div>
            <div class="col-4">
              <p>
                <input type="submit" name="cari" value="Cek Ongkir" class="btn btn-primary" onclick="cekOngkir()">
              </p>
            </div>
          </div>
        </div>
    </div>
  </div>

  <script>

    function cariKotaAsal(id_provinsi){
      const xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("kota_asal").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "http://localhost/apirajaongkir/cariKota.php?id_provinsi="+id_provinsi, true);
      xmlhttp.send();
    }

    function cariKotaTujuan(id_provinsi){
      const xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("kota_tujuan").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "http://localhost/apirajaongkir/cariKota.php?id_provinsi="+id_provinsi, true);
      xmlhttp.send();
    }

    function cekOngkir(){
      var id_kota_asal = document.getElementById("kota_asal").value;
      var id_kota_tujuan = document.getElementById("kota_tujuan").value;
      var berat_paket = document.getElementById("berat_paket").value;
      var kurir = document.getElementById("kurir").value;

      const xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("hasil_cek_ongkir").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "http://localhost/apirajaongkir/rajaongkoskirim.php?id_kota_asal="+id_kota_asal+"&id_kota_tujuan="+id_kota_tujuan+"&berat_paket="+berat_paket+"&kurir="+kurir, true);
      xmlhttp.send();
    }
  </script>
</body>
</html>
