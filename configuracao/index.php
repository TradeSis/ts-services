<?php
include_once(__DIR__ . '/../head.php');
?>

<style>

  .nav-link.active:any-link{
    background-color: transparent;
    border: 2px solid #DFDFDF;
    border-radius: 5px 5px 0px 0px;
    color: #1B4D60;
  }

  .nav-link:any-link{
    background-color: #567381;
    border: 1px solid #DFDFDF;
    border-radius: 5px 5px 0px 0px;
    color: #fff;
  }
  
</style>
<div class="container-fluid">
  <div class="row mt-3" ><!-- style="border: 1px solid #DFDFDF;" -->
    <div class="col-md-2 ">
      <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
        <?php
        $stab = 'contratotipos';
        if (isset($_GET['stab'])) {
          $stab = $_GET['stab'];
        }
        //echo "<HR>stab=" . $stab;
        ?>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "contratotipos") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=contratotipos" role="tab" >Contrato Tipos</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "contratoStatus") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=contratoStatus" role="tab" >Contrato Status</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "tipoocorrencia") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=tipoocorrencia" role="tab" >Tipo Ocorrência</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "tipostatus") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=tipostatus" role="tab" >Tipo Status</a>
        </li>

      </ul>
    </div>
    <div class="col-md-10">
      <?php
          $ssrc = "";

          if ($stab == "contratoStatus") {
            $ssrc = "contratoStatus.php";
          }
          if ($stab == "tipoocorrencia") {
            $ssrc = "tipoocorrencia.php";
          }
          if ($stab == "tipostatus") {
            $ssrc = "tipostatus.php";
          }
          if ($stab == "contratotipos") {
            $ssrc = "contratotipos.php";
          }

          if ($ssrc !== "") {
            //echo $ssrc;
            include($ssrc);
          }

      ?>

    </div>
  </div>



</div>
<!-- /.container -->