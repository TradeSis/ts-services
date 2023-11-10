<!-- Lucas 10112023 id965 Melhorias em Tarefas -->
<!-- Lucas 25102023 id643 revisao geral -->


<!--------- INSERIR/AGENDAR --------->
<div class="modal" id="inserirModal" tabindex="-1" role="dialog" aria-labelledby="inserirModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Inserir Tarefa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <?php if (isset($demanda)) { ?>
        <!-- COM Demanda Associada-->
        <div class="modal-body">
          <form method="post">
            <div class="row">
              <div class="col-md-6">
                <label class='form-label ts-label'>Tarefa</label>
                <input type="text" class="form-control ts-input" name="tituloTarefa" id="tituloTarefa" autocomplete="off">
                <input type="hidden" class="form-control ts-input" name="tituloDemanda" value="<?php echo $demanda['tituloDemanda'] ?>">
              </div>
              <div class="col-md-6">
                <label class='form-label ts-label'>ID/Demanda Relacionada</label>
                <input type="hidden" class="form-control ts-input" name="idDemanda" value="<?php echo $demanda['idDemanda'] ?>">
                <input type="text" class="form-control ts-input" value="<?php echo $demanda['idDemanda'] ?> - <?php echo $demanda['tituloDemanda'] ?>" readonly>
                <input type="hidden" name="tipoStatusDemanda" value="<?php echo $idTipoStatus ?>" />
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-4">
                <label class='form-label ts-label'>Cliente</label>
                <input type="hidden" class="form-control ts-input" name="idCliente" value="<?php echo $demanda['idCliente'] ?>">
                <input type="text" class="form-control ts-input" value="<?php echo $cliente['nomeCliente'] ?>" readonly>
              </div>
              <div class="col-md-4">
                <label class='form-label ts-label'>Reponsável</label>
                <select class="form-select ts-input" name="idAtendente">
                  <?php
                  foreach ($atendentes as $atendente) {

                  ?>
                    <option <?php
                            if ($atendente['idUsuario'] == $demanda['idAtendente']) {
                              echo "selected";
                            }
                            ?> value="<?php echo $atendente['idUsuario'] ?>"><?php echo $atendente['nomeUsuario'] ?>
                    </option>

                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class='form-label ts-label'>Ocorrência</label>
                <select class="form-select ts-input" name="idTipoOcorrencia" id="idTipoOcorrencia">
                  <?php
                  foreach ($ocorrencias as $ocorrencia) {
                  ?>
                    <option <?php
                            if ($ocorrencia['idTipoOcorrencia'] == $demanda['idTipoOcorrencia']) {
                              echo "selected";
                            } ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>"><?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <!-- Lucas 10112023 ID 965 Removido horasCobrado -->
            </div>
            <div class="row mt-3">
              <div class="col-md-4">
                <label class="form-label ts-label">Data Previsão</label>
                <input type="date" class="form-control ts-input" name="Previsto" autocomplete="off">
              </div>
              <div class="col-md-4">
                <label class="form-label ts-label">Inicio</label>
                <input type="time" class="form-control ts-input" name="horaInicioPrevisto" autocomplete="off">
              </div>
              <div class="col-md-4">
                <label class="form-label ts-label">Fim</label>
                <input type="time" class="form-control ts-input" name="horaFinalPrevisto" autocomplete="off">
              </div>
            </div>
        </div>
        <div class="modal-footer text-end">
          <button type="submit" formaction="../database/tarefas.php?operacao=inserirStart" class="btn btn-warning">Start</button>
          <button type="submit" formaction="../database/tarefas.php?operacao=inserir" class="btn btn-success">Inserir</button>
        </div>
        </form>
      <?php } else { ?>
      <!-- SEM Demanda Associada-->
        <div class="modal-body">
          <form method="post" id="inserirForm">

            <div class="row">
              <div class="col-md-12">
                <label class='form-label ts-label'>Tarefa</label>
                <input type="text" class="form-control ts-input" name="tituloTarefa" id="newtitulo" autocomplete="off" required>
                <input type="hidden" class="form-control ts-input" name="idDemanda" value="null" id="newidDemanda">
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-md-4">
                <label class='form-label ts-label'>Cliente</label>
                <div class="form-label ts-label">
                  <select class="form-select ts-input" name="idCliente" id="newidCliente">
                    <option value="null"></option>
                    <?php
                    foreach ($clientes as $cliente) {
                    ?>
                      <option value="<?php echo $cliente['idCliente'] ?>">
                        <?php echo $cliente['nomeCliente'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <label class='form-label ts-label'>Responsável</label>
                <div class="form-label ts-label">
                  <select class="form-select ts-input" name="idAtendente" id="newidAtendente">
                    <!-- gabriel 13102023 id596 removido a possibilidade de adicionar tarefa sem responsável -->
                    <option value="null">Selecione</option>
                    <?php
                    foreach ($atendentes as $atendente) {
                    ?>
                      <!-- Lucas 25102023 id643 select vai trazer o usuario logado como primeira opção -->
                      <option <?php
                              if ($atendente['idUsuario'] == $usuario['idUsuario']) {
                                echo "selected";
                              }
                              ?> value="<?php echo $atendente['idUsuario'] ?>">
                        <?php echo $atendente['nomeUsuario'] ?>
                      </option>

                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <label class='form-label ts-label'>Ocorrência</label>
                <div class="form-label ts-label">
                  <select class="form-select ts-input" name="idTipoOcorrencia" id="newidTipoOcorrencia">
                    <option value="null">Selecione</option>
                    <?php
                    foreach ($ocorrencias as $ocorrencia) {
                    ?>
                      <option value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                        <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4">
                <label class="form-label ts-label">Data Previsão</label>
                <input type="date" class="form-control ts-input" name="Previsto" autocomplete="off" required>
              </div>
              <div class="col-md-4">
                <label class="form-label ts-label">Inicio</label>
                <input type="time" class="form-control ts-input" name="horaInicioPrevisto" autocomplete="off">
              </div>
              <div class="col-md-4">
                <label class="form-label ts-label">Fim</label>
                <input type="time" class="form-control ts-input" name="horaFinalPrevisto" autocomplete="off">
              </div>
            </div>
        </div><!--modal body-->
        <div class="modal-footer text-end">
          <button type="submit" class="btn btn-warning" id="inserirStartBtn">Start</button>
          <button type="submit" class="btn btn-success" id="inserirBtn">Inserir</button>
        </div>
        </form>

      <?php } ?>

    </div>
  </div>
</div>