<div class="container">
  <form method="get">
    <div class="row">
      <div class="input-field col s12 m6">
        <select name="Kolom" id="select-column-paginasi">
          <?php 
            for ($i=0; $i < count($column['value']); $i++) {
          ?>
            <option value="<?php echo $column['value'][$i]; ?>" <?php if(isset($_GET['Kolom']) AND $_GET['Kolom']==$column['value'][$i]){echo'selected';} ?>><?php echo $column['label'][$i]; ?></option>
          <?php } ?>
        </select>
        <label>Cari Barang Berdasarkan</label>
      </div>

      <div class="input-field col s12 m6">
        <input id="input-column-paginasi" type="text" class="validate" name="KataKunci" value="<?php if(isset($_GET['KataKunci'])){echo $_GET['KataKunci'];} ?>">
        <label for="input-column-paginasi">Nama Yang Dicari</label>
      </div>

      <div class="col s12 m6">
        <button type="submit" class="waves-effect waves-light btn blue darken-2"><i class="material-icons left">search</i>Cari</button>
        <?php 
          if(isset($_GET['Kolom']) || isset($_GET['KataKunci'])){
        ?>
          <a href="<?php echo $view; ?>" class="waves-effect waves-light btn red darken-2"><i class="material-icons left">close</i>Batal</a>
        <?php } ?>
      </div>
    </div>  
  </form>
</div>