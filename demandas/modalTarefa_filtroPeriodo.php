<!--------- FILTRO PERIODO --------->
<div class="modal" id="periodoModal" tabindex="-1" role="dialog"
    aria-labelledby="periodoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filtro Periodo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-check">
              <input class="form-check-input" type="radio" value="<?php echo null ?>" id="Radio" name="FiltroPeriodo"
                <?php echo $Checked; ?> hidden>
              <input class="form-check-input" type="radio" value="1" id="PrevisaoRadio" name="FiltroPeriodo" <?php echo $previsaoChecked; ?>>
              <label class="form-check-label" for="PrevisaoRadio">
                Previsão
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" value="0" id="RealizadoRadio" name="FiltroPeriodo" <?php echo $realizadoChecked; ?>>
              <label class="form-check-label" for="RealizadoRadio">
                Realizado
              </label>
            </div>
            <div class="row" id="conteudoReal">
              <div class="col">
                <label class="labelForm">Começo</label>
                <?php if ($PeriodoInicio != null) { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoInicio"
                  value="<?php echo $PeriodoInicio ?>" name="PeriodoInicio" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoInicio" name="PeriodoInicio"
                  autocomplete="off">
                <?php } ?>
              </div>
              <div class="col">
                <label class="labelForm">Fim</label>
                <?php if ($PeriodoFim != null) { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoFim"
                  value="<?php echo $PeriodoFim ?>" name="PeriodoFim" autocomplete="off">
                <?php } else { ?>
                <input type="date" class="data select form-control" id="FiltroPeriodoFim" name="PeriodoFim"
                  autocomplete="off">
                <?php } ?>
              </div>
            </div>
            </div>
            <div class="modal-footer border-0">
              <div class="col-sm text-start">
                <button type="button" class="btn btn-primary" onClick="limparPeriodo()">Limpar</button>
              </div>
              <div class="col-sm text-end">
                <button type="button" class="btn btn-success" id="filtrarButton" data-dismiss="modal">Filtrar</button>
              </div>
            </div>
          </form>
        
      </div>
    </div>
  </div>
