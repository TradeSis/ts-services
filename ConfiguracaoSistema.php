<style>
  .temp{
    color:black
  }
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 mb-3">
      <ul class="nav nav-pills flex-column" id="myTab" role="tablist">

        <li class="nav-item">
          <a class="nav-link active temp" id="contratoStatus-tab" data-toggle="tab" href="#contratoStatus" role="tab" aria-controls="contratoStatus" aria-selected="true">contratoStatus</a>
        </li>
        <li class="nav-item">
          <a class="nav-link temp" id="tipoocorrencia-tab" data-toggle="tab" href="#tipoocorrencia" role="tab" aria-controls="tipoocorrencia" aria-selected="true">tipoocorrencia</a>
        </li>

        <li class="nav-item">
          <a class="nav-link temp" id="tipostatus-tab" data-toggle="tab" href="#tipostatus" role="tab" aria-controls="tipostatus" aria-selected="false">tipostatus</a>
        </li>
        
      </ul>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-10">
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="contratoStatus" role="tabpanel" aria-labelledby="contratoStatus-tab">
          <?php include 'configuracao/contratoStatus.php' ?>
        </div>
        <div class="tab-pane fade" id="tipoocorrencia" role="tabpanel" aria-labelledby="tipoocorrencia-tab">
        <?php include 'configuracao/tipoocorrencia.php' ?>
        </div>
        <div class="tab-pane fade" id="tipostatus" role="tabpanel" aria-labelledby="tipostatus-tab">
        <?php include 'configuracao/tipostatus.php' ?>
        </div>
       
      </div>
    </div>
    <!-- /.col-md-8 -->
  </div>



</div>
<!-- /.container -->