<div class="parent-btn-paginasi">
  <ul class="pagination">
    <?php
      // Jika page = 1, maka LinkPrev disable
      if($page == 1){ 
    ?>        
      <!-- link Previous Page disable --> 
      <li class="disabled waves-effect"><a href="#"><i class="material-icons">chevron_left</i></a></li>
    <?php
      }
      else{ 
        $LinkPrev = ($page > 1)? $page - 1 : 1;  

        if($kolomCari=="" && $kolomKataKunci==""){
    ?>
          <li class="waves-effect"><a href="<?php echo $view; ?>?page=<?php echo $LinkPrev; ?>"><i class="material-icons">chevron_left</i></a></li>
    <?php     
        }else{
    ?> 
        <li class="waves-effect"><a href="<?php echo $view; ?>?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $LinkPrev;?>"><i class="material-icons">chevron_left</i></a></li>
    <?php
         } 
      }
    ?>

    <!-- pagination -->
    <?php
      //kondisi jika parameter pencarian kosong
      if($kolomCari=="" && $kolomKataKunci==""){
        $SqlQuery = mysqli_query($mysqli, "$qry $orderby");
      }else{
        //kondisi jika parameter kolom pencarian diisi
        $SqlQuery = mysqli_query($mysqli, "$qry
                                           WHERE $kolomCari LIKE '%$kolomKataKunci%' $orderby");
      }     
    
      //Hitung semua jumlah data yang berada pada tabel Sisawa
      $JumlahData = mysqli_num_rows($SqlQuery);
      
      // Hitung jumlah halaman yang tersedia
      $jumlahPage = ceil($JumlahData / $limit); 
      
      // Jumlah link number 
      $jumlahNumber = 1; 

      // Untuk awal link number
      $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; 
      
      // Untuk akhir link number
      $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; 
      
      for($i = $startNumber; $i <= $endNumber; $i++){
        $linkActive = ($page == $i)? ' class="active waves-effect"' : '';

        if($kolomCari=="" && $kolomKataKunci==""){
    ?>
        <li<?php echo $linkActive; ?>><a href="<?php echo $view; ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

    <?php
      }else{
        ?>
        <li<?php echo $linkActive; ?>><a href="<?php echo $view; ?>?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php
      }
    }
    ?>

    <!-- next page -->
    <?php       
     if($page == $jumlahPage){ 
    ?>
      <li class="disabled waves-effect"><a href="#"><i class="material-icons">chevron_right</i></a></li>
    <?php
    }
    else{
      $linkNext = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
     if($kolomCari=="" && $kolomKataKunci==""){
        ?>
          <li class="waves-effect"><a href="<?php echo $view; ?>?page=<?php echo $linkNext; ?>"><i class="material-icons">chevron_right</i></a></li>
     <?php     
        }else{
      ?> 
         <li class="waves-effect"><a href="<?php echo $view; ?>?Kolom=<?php echo $kolomCari;?>&KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $linkNext; ?>"><i class="material-icons">chevron_right</i></a></li>
    <?php
      }
    }
    ?>
  </ul>
</div>