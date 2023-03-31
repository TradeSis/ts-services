<?php

?>
<style>
   .personal-image {
  text-align: center;
}
.personal-image input[type="file"] {
  display: none;
} 

.personal-figure {
  position: relative;
  width: 120px;
  height: 120px;
}


.personal-avatar {
  cursor: pointer;
  width: inherit;
  height: inherit;
  box-sizing: border-box;
  border-radius: 100%;
  border: 2px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.2);
  transition: all ease-in-out .3s;
}
.personal-avatar:hover {
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.5);
}

.personal-figcaption {
  cursor: pointer;
  position: absolute;
  top: 0px;
  width: inherit;
  height: inherit;
  border-radius: 100%;
  opacity: 0;
  background-color: rgba(0, 0, 0, 0);
  transition: all ease-in-out .3s;
}
.personal-figcaption:hover {
  opacity: 1;
  background-color: rgba(0, 0, 0, .5);
}
.personal-figcaption > img {
  margin-top: 32.5px;
  width: 50px;
  height: 50px;
}
</style>

<body>
<div class="personal-image">
  <label class="label">
    <input type="file" />
    <figure class="personal-figure">
      <img src="../img/imgAplicativo/pefil.png" class="personal-avatar" alt="avatar">
      <figcaption class="personal-figcaption">
        <img src="../img/imgAplicativo/pefil.png">
      </figcaption>
    </figure>
  </label>
</div>
</body>
</html>