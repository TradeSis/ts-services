 <!--------- MODAL STOP Tab EXECUCAO --------->
 <div class="modal" id="stopexecucaomodal" tabindex="-1" role="dialog"
    aria-labelledby="stopexecucaomodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stop Tarefa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- gabriel 13102023 id 596 adicionado id -->
          <form method="post" id="stopForm">
            <div class="container-fluid p-0">
              <div class="col">
                <span class="tituloEditor">Comentários</span>
              </div>
              <div class="quill-stop" style="height:20vh !important"></div>
              <textarea style="display: none" id="quill-stop" name="comentario"></textarea>
            </div>
            <div class="col-md form-group">
              <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>"
                readonly>
              <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>"
                readonly>
              <input type="hidden" class="form-control" name="idTarefa" id="idTarefa-stopexecucao" />
              <input type="hidden" class="form-control" name="idDemanda" id="idDemanda-stopexecucao" />
              <input type="hidden" class="form-control" name="tipoStatusDemanda" id="status-stopexecucao" />
              <input type="time" class="form-control" name="horaInicioCobrado" id="horaInicioReal-stopexecucao" step="2"
                readonly style="display: none;" />

            </div>
        </div>
        <div class="modal-footer">
          <div class="col align-self-start pl-0">
            <!-- gabriel 13102023 id 596 fix ao dar stop vai para demanda -->
            <button type="submit" id="realizadoFormbutton" class="btn btn-warning float-left">Entregar</button>
          </div>
          <!-- gabriel 13102023 id 596 fix ao dar stop vai para demanda -->
          <button type="submit" id="stopFormbutton" class="btn btn-danger">Stop</button>
          </form>
        </div>
      </div>
    </div>
  </div>