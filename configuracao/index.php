<?php
include_once(__DIR__ . '/../head.php');
?>

<style>
  .temp {
    color: black
  }
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 mb-3">
      <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
        <?php
        $stab = 'contratoStatus';
        if (isset($_GET['stab'])) {
          $stab = $_GET['stab'];
        }
        //echo "<HR>stab=" . $stab;
        ?>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "contratoStatus") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=contratoStatus" role="tab" style="color:black">Contrato Status</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "tipoocorrencia") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=tipoocorrencia" role="tab" style="color:black">Tipo Ocorrencia</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "tipostatus") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=tipostatus" role="tab" style="color:black">Tipo Status</a>
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

          if ($ssrc !== "") {
            //echo $ssrc;
            include($ssrc);
          }

      ?>

    </div>
  </div>



</div>
<!-- /.container -->