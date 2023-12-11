 <!-- Lucas 10112023 id965 Melhorias em Tarefas -->


 <!--------- MODAL STOP Tab EXECUCAO --------->
 <div class="modal" id="stopmodal" tabindex="-1" aria-labelledby="stopmodalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Stop Tarefa</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>

       <div class="modal-body">
         <form method="post" id="stopForm">
           <div class="container-fluid p-0">
             <div class="col">
               <span class="tituloEditor">Comentários</span>
             </div>
             <div class="quill-stop" style="height:20vh !important"></div>
             <textarea style="display: none" id="quill-stop" name="comentario"></textarea>
           </div>
           <div class="col-md">
           
             <input type="hidden" class="form-control" name="idCliente" value="<?php echo $demanda['idCliente'] ?>" readonly>
             <input type="hidden" class="form-control" name="idUsuario" value="<?php echo $usuario['idUsuario'] ?>" readonly>
          
             <input type="hidden" class="form-control" name="idTarefa" id="stopmodal_idTarefa" />
             <input type="hidden" class="form-control" name="idDemanda" id="stopmodal_idDemanda" />
           </div>
       </div>
       <div class="modal-footer">
         <?php if (isset($demanda)) { ?>
           <div class="col align-self-start pl-0">
             <button type="submit" formaction="../database/demanda.php?operacao=atualizar&acao=realizado" class="btn btn-warning float-left">Entregar</button>
           </div>
           <button type="submit" formaction="../database/tarefas.php?operacao=realizado&acao=stop&redirecionarDemanda" class="btn btn-danger">Stop</button>
         <?php } else { ?>
           <div class="col align-self-start pl-0">
             <!-- gabriel 13102023 id 596 fix ao dar stop vai para demanda -->
             <button type="submit" id="realizadoFormbutton" class="btn btn-warning float-left">Entregar</button>
           </div>
           <!-- gabriel 13102023 id 596 fix ao dar stop vai para demanda -->
           <button type="submit" id="stopFormbutton" class="btn btn-danger">Stop</button>
         <?php } ?>


         </form>
       </div>

     </div>
   </div>
 </div>

 <!-- LOCAL PARA COLOCAR OS JS -->

 <!-- QUILL editor -->
 <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

 <script>
   var quillstop = new Quill('.quill-stop', {
     theme: 'snow',
     modules: {
       toolbar: [
         ['bold', 'italic', 'underline', 'strike'],
         ['blockquote'],
         [{
           'list': 'ordered'
         }, {
           'list': 'bullet'
         }],
         [{
           'indent': '-1'
         }, {
           'indent': '+1'
         }],
         [{
           'direction': 'rtl'
         }],
         [{
           'size': ['small', false, 'large', 'huge']
         }],
         [{
           'header': [1, 2, 3, 4, 5, 6, false]
         }],
         ['link', 'image', 'video', 'formula'],
         [{
           'color': []
         }, {
           'background': []
         }],
         [{
           'font': []
         }],
         [{
           'align': []
         }],
       ]
     }
   });

   /* lucas 22092023 ID 358 Modificado nome da classe do editor */
   quillstop.on('text-change', function(delta, oldDelta, source) {
     $('#quill-stop').val(quillstop.container.firstChild.innerHTML);
   });
 </script>

 <!-- LOCAL PARA COLOCAR OS JS -FIM -->