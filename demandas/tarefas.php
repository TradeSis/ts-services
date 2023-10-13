<!-- Gabriel 06102023 ID 596 mudanças em agenda e tarefas -->
<!-- Gabriel 06102023 ID 596 removido php para indexTarefa -->

<body class="bg-transparent">

  <nav id="menuFiltros" class="menuFiltros" style="width: 163px;margin-top:-58px;margin-left:40px">
    <div class="titulo"><span>Filtrar por:</span></div>
    <ul>
      <!-- Gabriel 06102023 ID 596 ajustado posiçao -->
      <li class="ls-label col-sm-12 mr-1" style="list-style-type: none;"> <!-- ABERTO/FECHADO -->
        <form class="d-flex" action="" method="post" style="text-align: right;">
          <select class="form-control" name="statusTarefa" id="FiltroStatusTarefa"
            style="font-size: 14px; width: 150px; height: 35px">
            <option value="<?php echo null ?>">
              <?php echo "Todos" ?>
            </option>
            <option <?php if ($statusTarefa == "1") {
              echo "selected";
            } ?> value="1">Aberto</option>
            <option <?php if ($statusTarefa == "0") {
              echo "selected";
            } ?> value="0">Realizado</option>
          </select>
        </form>
      </li>
    </ul>

    <div class="col-sm" style="text-align:right; color: #fff">
      <a onClick="limpar()" role=" button" class="btn btn-sm" style="background-color:#84bfc3; ">Limpar</a>
    </div>
  </nav>


  <div class="container-fluid text-center mt-2">

    <div class="row">
      <div class="btnAbre" style="height:33px">
        <span style="font-size: 25px;font-family: 'Material Symbols Outlined'!important;"
          class="material-symbols-outlined">
          filter_alt
        </span>

      </div>

      <div class="col-sm-3 ml-2">
        <h2 class="tituloTabela">Tarefas</h2>
        <!-- Gabriel 11102023 ID 596 removido, h6 agora preenche via script -->
        <h6 style="font-size: 10px;font-style:italic;text-align:left;"></h6>
      </div>

      <!-- Gabriel 06102023 ID 596 removido buscar duplicado -->
      <div class="col-sm-4">
        <div class="input-group">
          <input type="text" class="form-control" id="buscaTarefa" placeholder="Buscar por id ou titulo">
          <span class="input-group-btn">
            <button class="btn btn-primary mt-2" id="buscar" type="button">
              <span style="font-size: 20px;font-family: 'Material Symbols Outlined'!important;"
                class="material-symbols-outlined">search</span>
            </button>
          </span>
        </div>
      </div>

      <div class="col-sm-1">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#periodoModal"><i
            class="bi bi-calendar3"></i></button>
      </div>

      <div class="col-sm" style="text-align:right">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#inserirModal"><i
            class="bi bi-plus-square"></i>&nbsp Novo</button>
      </div>
    </div>


    <div class="card mt-2 text-center">
      <div class="table table-sm table-hover table-striped table-wrapper-scroll-y my-custom-scrollbar diviFrame">
        <table class="table">
          <thead class="cabecalhoTabela">
            <tr>
              <th>ID</th>
              <th>Tarefa</th>
              <th>Responsável</th>
              <th>Cliente</th>
              <th>Ocorrência</th>
              <th>Previsão</th>
              <th>Real</th>
              <th>Cobrado</th>
              <th style="width: 17%;">Ação</th>
            </tr>
            <tr>
              <th></th>
              <th></th>
              <th>
                <form action="" method="post">
                  <select class="form-control text-center" name="idAtendente" id="FiltroUsuario"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <?php
                    foreach ($atendentes as $atendente) {
                      ?>
                      <option <?php
                      if ($atendente['idUsuario'] == $idAtendente) {
                        echo "selected";
                      }
                      ?> value="<?php echo $atendente['idUsuario'] ?>">
                        <?php echo $atendente['nomeUsuario'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="idCliente" id="FiltroClientes"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <?php
                    foreach ($clientes as $cliente) {
                      ?>
                      <option <?php
                      if ($cliente['idCliente'] == $idCliente) {
                        echo "selected";
                      }
                      ?> value="<?php echo $cliente['idCliente'] ?>">
                        <?php echo $cliente['nomeCliente'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="idTipoOcorrencia" id="FiltroOcorrencia"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <?php
                    foreach ($ocorrencias as $ocorrencia) {
                      ?>
                      <option <?php
                      if ($ocorrencia['idTipoOcorrencia'] == $idTipoOcorrencia) {
                        echo "selected";
                      }
                      ?> value="<?php echo $ocorrencia['idTipoOcorrencia'] ?>">
                        <?php echo $ocorrencia['nomeTipoOcorrencia'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="PrevistoOrdem" id="FiltroPrevistoOrdem"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <option <?php if ($PrevistoOrdem == "1") {
                      echo "selected";
                    } ?> value="1">DESC</option>
                    <option <?php if ($PrevistoOrdem == "0") {
                      echo "selected";
                    } ?> value="0">ASC</option>
                  </select>
                </form>
              </th>
              <th style="width: 10%;">
                <form action="" method="post">
                  <select class="form-control text-center" name="RealOrdem" id="FiltroRealOrdem"
                    style="font-size: 14px;color:#fff; font-style:italic; margin-top:-10px; margin-bottom:-6px;background-color:#13216A">
                    <option value="<?php echo null ?>">
                      <?php echo "Selecione" ?>
                    </option>
                    <option <?php if ($RealOrdem == "1") {
                      echo "selected";
                    } ?> value="1">DESC</option>
                    <option <?php if ($RealOrdem == "0") {
                      echo "selected";
                    } ?> value="0">ASC</option>
                  </select>
                </form>
              </th>
              <th></th>
              <th style="width: 10%;"></th>
            </tr>
          </thead>

          <tbody id='dados' class="fonteCorpo">

          </tbody>
        </table>
      </div>
    </div>
  </div>


  <!-- Gabriel 06102023 ID 596 removido modal para indexTarefa -->

  <script>
    //Gabriel 06102023 ID 596 adicionado document.ready para buscar filtro periodo, ajustado buscaTarefa
    $(document).ready(function () {
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });
    function limpar() {
      buscar(null, null, null, null, null, null, null, null, null, null, function () {
      //gabriel 13102023 id 596 fix atualizar pagina correta
      refreshTab('execucao');
      });
    }
    function limparPeriodo() {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), null, null, null, null, null, function () {
      //gabriel 13102023 id 596 fix atualizar pagina correta
      refreshTab('execucao');
      });
    }
    //Gabriel 06102023 ID 596 movido function do ajax para ser utilizado fora dele
    function formatDate(dateString) {
      if (dateString !== null && !isNaN(new Date(dateString))) {
        var date = new Date(dateString);
        var day = date.getUTCDate().toString().padStart(2, '0');
        var month = (date.getUTCMonth() + 1).toString().padStart(2, '0');
        var year = date.getUTCFullYear().toString().padStart(4, '0');
        return day + "/" + month + "/" + year;
      }
      return "00/00/0000";
    }
    function formatTime(timeString) {
      if (timeString !== null) {
        var timeParts = timeString.split(':');
        var hours = timeParts[0].padStart(2, '0');
        var minutes = timeParts[1].padStart(2, '0');
        return hours + ":" + minutes;
      }
      return "00:00";
    }

    var vdata = new Date();

    var day = String(vdata.getDate()).padStart(2, '0');
    var month = String(vdata.getMonth() + 1).padStart(2, '0');
    var year = vdata.getFullYear();
    var today = `${day}/${month}/${year}`;

    var hh = String(vdata.getHours()).padStart(2, '0');
    var mm = String(vdata.getMinutes()).padStart(2, '0');
    var time = hh + ':' + mm;

    function buscar(idCliente, idAtendente, tituloTarefa, idTipoOcorrencia, statusTarefa, Periodo, PeriodoInicio, PeriodoFim, PrevistoOrdem, RealOrdem, buscaTarefa, callback) {
      //Gabriel 11102023 ID 596 utiliza valores do buscar para gravar no h6 da tabela filtros status e periodo
      var h6Element = $(".col-sm-3 h6");
      var text = "";
      if (statusTarefa === "1") {
        if (text) text += ", "; 
        text += "Status = Aberto";
      } else if (statusTarefa === "0") {
        if (text) text += ", "; 
        text += "Status = Realizado";
      }
      if (Periodo === "1") {
        if (text) text += ", "; 
        text += "Periodo = Previsão";
      } else if (Periodo === "0") {
        if (text) text += ", "; 
        text += "Periodo = Realizado";
      }
      if (PeriodoInicio !== "") {
        if (text) text += " em ";
        text += formatDate(PeriodoInicio);
      }  
      if (PeriodoFim !== "") {
        if (text) text += " até ";
        text += formatDate(PeriodoFim);
      }

      h6Element.html(text);
      $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=filtrar',
        beforeSend: function () {
          $("#dados").html("Carregando...");
        },
        data: {
          idCliente: idCliente,
          idAtendente: idAtendente,
          tituloTarefa: tituloTarefa,
          idTipoOcorrencia: idTipoOcorrencia,
          statusTarefa: statusTarefa,
          Periodo: Periodo,
          PeriodoInicio: PeriodoInicio,
          PeriodoFim: PeriodoFim,
          PrevistoOrdem: PrevistoOrdem,
          RealOrdem: RealOrdem,
          buscaTarefa: buscaTarefa
        },
        success: function (msg) {

          var json = JSON.parse(msg);
          var linha = "";
          for (var $i = 0; $i < json.length; $i++) {
            var object = json[$i];


            var vPrevisto = formatDate(object.Previsto);
            var vhoraInicioPrevisto = formatTime(object.horaInicioPrevisto);
            var vhoraFinalPrevisto = formatTime(object.horaFinalPrevisto);
            var vhorasPrevisto = formatTime(object.horasPrevisto);

            var vdataReal = formatDate(object.dataReal);
            var vhoraInicioReal = formatTime(object.horaInicioReal);
            var vhoraFinalReal = formatTime(object.horaFinalReal);
            var vhorasReal = formatTime(object.horasReal);
            var vhoraCobrado = formatTime(object.horaCobrado);
            linha += "<tr>";
            linha += "<td>" + object.idTarefa + "</td>";
            linha += "<td data-target='#alterarmodal' data-idtarefa='" + object.idTarefa + "'>";

            if (object.tituloTarefa == "") {
              linha += object.tituloDemanda;
            } else {
              linha += object.tituloTarefa;
            }

            linha += "</td>";
            linha += "<td>" + object.nomeUsuario + "</td>";
            linha += "<td>" + object.nomeCliente + "</td>";
            linha += "<td>" + object.nomeTipoOcorrencia + "</td>";
            if (vPrevisto < today && vdataReal == "00/00/0000" && vPrevisto != "00/00/0000") {
              linha += "<td style='background:firebrick'>" + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "</td>";
            } else {
              linha += "<td>" + vPrevisto + " " + vhoraInicioPrevisto + " " + vhoraFinalPrevisto + " (" + vhorasPrevisto + ")" + "</td>";
            }
            if (vhoraInicioReal != "00:00" && vhoraFinalReal == "00:00" && vdataReal == today) {
              var timeParts = time.split(':');
              var vhoraInicioRealParts = vhoraInicioReal.split(':');

              var timeMinutes = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
              var vhoraInicioRealMinutes = parseInt(vhoraInicioRealParts[0]) * 60 + parseInt(vhoraInicioRealParts[1]);

              var differenceMinutes = timeMinutes - vhoraInicioRealMinutes;

              var hours = Math.floor(differenceMinutes / 60);
              var minutes = differenceMinutes % 60;

              var vhorasReal = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
            }
            linha += "<td>" + vdataReal + " " + vhoraInicioReal + " " + vhoraFinalReal + " (" + vhorasReal + ")" + "</td>";
            linha += "<td>" + vhoraCobrado + "</td>";
            linha += "<td class='text-center' id='botao'>";
            if (vhoraInicioReal != "00:00" && vhoraFinalReal == "00:00" && vdataReal == today) {
              //lucas 25092023 ID 358 Adicionado condição para botão com demanda associada e sem demanda asssociada
              if(object.idDemanda == null){
                linha += "<button type='button' class='stopButton btn btn-danger btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-data-execucao='" + object.horaInicioReal + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-stop-circle'></i></button>"
              }else{
                linha += "<button type='button' class='btn btn-danger btn-sm mr-1' data-toggle='modal' data-target='#stopexecucaomodal' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-data-execucao='" + object.horaInicioReal + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-stop-circle'></i></button>"
              }
            }
            if (vhoraInicioReal == "00:00") {
              linha += "<button type='button' class='startButton btn btn-success btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-play-circle'></i></button>"
              linha += "<button type='button' class='realizadoButton btn btn-info btn-sm mr-1' data-id='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-check-circle'></i></button>"
            }
            if (vhoraInicioReal != "00:00" && vhoraFinalReal != "00:00") {
              //gabriel 13102023 id 596 identificação botão clonar novo
              linha += "<button type='button' class='clonarButton btn btn-success btn-sm mr-1' data-idtarefa='" + object.idTarefa + "' data-status='" + object.idTipoStatus + "' data-demanda='" + object.idDemanda + "'><i class='bi bi-back'></i></button>";
            }
            linha += "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#alterarmodal' data-idtarefa='" + object.idTarefa + "'><i class='bi bi-pencil-square'></i></button>"

            linha += "</td>";
            linha += "</tr>";
          }

          $("#dados").html(linha);

          if (typeof callback === 'function') {
            callback();
          }
        }
      });
    }

    $("#FiltroClientes").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroUsuario").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#buscar").click(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroOcorrencia").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroDemanda").click(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroStatusTarefa").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroPrevistoOrdem").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    $("#FiltroRealOrdem").change(function () {
      //Gabriel 06102023 ID 596 ajustado #buscaTarefa
      buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
    });

    //Gabriel 11102023 ID 596 adicionado document ready pois o modal está em indextarefa.php
    $(document).ready(function() {
      $("#filtrarButton").click(function () {
        if (!$('#PrevisaoRadio').is(':checked') && !$('#RealizadoRadio').is(':checked')) {
          alert("Por favor selecione uma opção.");
          return false;
        } else {
          //Gabriel 06102023 ID 596 ajustado #buscaTarefa
          buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
          $('#periodoModal').modal('hide');
        }
      });
    });

    document.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        //Gabriel 06102023 ID 596 ajustado #buscaTarefa
        buscar($("#FiltroClientes").val(), $("#FiltroUsuario").val(), $("#buscaTarefa").val(), $("#FiltroOcorrencia").val(), $("#FiltroStatusTarefa").val(), $("input[name='FiltroPeriodo']:checked").val(), $("#FiltroPeriodoInicio").val(), $("#FiltroPeriodoFim").val(), $("#FiltroPrevistoOrdem").val(), $("#FiltroRealOrdem").val(), $("#buscaTarefa").val());
      }
    });


    //lucas 25092023 ID 358 Adicionado script para popup de stop
    $(document).on('click', 'button[data-target="#stopexecucaomodal"]', function () {
      var idTarefa = $(this).attr("data-id");
      var idDemanda = $(this).attr("data-demanda");
      var status = $(this).attr("data-status");
      var horaInicioReal = $(this).attr("data-data-execucao");
      
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
        data: {
          idTarefa: idTarefa
        },
        success: function (data) {
          $('#idTarefa-stopexecucao').val(data.idTarefa);
          $('#idDemanda-stopexecucao').val(idDemanda);
          $('#status-stopexecucao').val(status);
          $('#horaInicioReal-stopexecucao').val(horaInicioReal);
                        
          $('#stopexecucaomodal').modal('show');
        }
      });
    });

    $('.btnAbre').click(function () {
      //Gabriel 06102023 ID 596 ajustado para ID ao invés de classe
      $('#menuFiltros').toggleClass('mostra');
      $('.diviFrame').toggleClass('mostra');
    });



    var inserirModal = document.getElementById("inserirModal");

    var inserirBtn = document.querySelector("button[data-target='#inserirModal']");

    inserirBtn.onclick = function () {
      inserirModal.style.display = "block";
    };

    window.onclick = function (event) {
      if (event.target == inserirModal) {
        inserirModal.style.display = "none";
      }
    };

    $(document).ready(function() {
      $(document).on('click', 'button.clonarButton', function () {
          var idTarefa = $(this).data("idtarefa"); // Use data() to access the custom data attribute
          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: '<?php echo URLROOT ?>/services/database/tarefas.php?operacao=buscar',
              data: {
                  idTarefa: idTarefa
              },
              success: function (data) {
                  $('#newtitulo').val(data.tituloTarefa);
                  $('#newidCliente').val(data.idCliente);
                  $('#newidDemanda').val(data.idDemanda);
                  $('#newidAtendente').val(data.idAtendente);
                  $('#newidTipoOcorrencia').val(data.idTipoOcorrencia);
                  $('#newtipoStatusDemanda').val(data.idTipoStatus);
                  $('#newdescricao').val(data.descricao);

                  $('#inserirModal').modal('show');
              }
          });
      });
  });

  </script>

</body>

</html>