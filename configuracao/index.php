<?php
include_once(__DIR__ . '/../head.php');
?>

<style>
  .temp {
    color: black
  }
  .nav-link.active:any-link{
    font-weight: 700;
    background-color: transparent;
    border-bottom: 1px solid #002C53;
    width: 120px;
    /* border-right: 2px solid #002C53; */
    border-radius: 15px 15px 0px 0px;
  }

  
</style>
<div class="container">
  <div class="row mt-3" ><!-- style="border: 1px solid #DFDFDF;" -->
    <div class="col-md-2 ">
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
            href="?tab=configuracao&stab=contratoStatus" role="tab" style="color:#12192C">Contrato Status</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "tipoocorrencia") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=tipoocorrencia" role="tab" style="color:#12192C">Tipo Ocorrência</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link <?php if ($stab == "tipostatus") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=tipostatus" role="tab" style="color:#12192C">Tipo Status</a>
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