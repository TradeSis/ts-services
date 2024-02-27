<?php

?>
  <link href="http://localhost/vendor/quilljs/quill.snow.css" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


<div>
  <div id="ql-toolbar">
    <?php include_once "ql-toolbar.php"  ?>
  </div>
  <div id="ql-editor">
  </div>
</div>

<script src="http://localhost/vendor/quilljs/quill.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Initialize Quill editor -->
<script>

  var quill = new Quill('#ql-editor', {
    modules: {
      toolbar: '#ql-toolbar'
    },
    placeholder: 'Digite o texto...',
    theme: 'snow'
  });

</script>

<script src="quill-uploadFile.js"></script>

</script>