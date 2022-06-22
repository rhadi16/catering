<?php include("../../../admin/config/connect.php"); ?>

<option value="">Select one...</option>
<?php 
  $qry1 = "SELECT * FROM list_barang";

  $dt1 = mysqli_query($mysqli, $qry1);

  while($data1 = mysqli_fetch_array($dt1)){
?>
  <option value="<?php echo $data1['id_barang'].'||'.$data1['stok'].'||'.$data1['harga']; ?>"><?php echo $data1['nama_barang']; ?></option>
<?php } ?>