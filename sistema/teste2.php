<?php

?>
<style>
#picture__input {
  display: none;
}

.picture {
  width: 120px;
  height: 120px;
  background: #ddd;
  display: flex;
  align-items: center;
  text-align: center;
  justify-content: center;
  color: #aaa;
  border: 1px dashed currentcolor;
  border-radius: 100px;
  cursor: pointer;
  font-family: sans-serif;
  transition: color 300ms ease-in-out, background 300ms ease-in-out;
  outline: none;
  overflow: hidden;
}

.picture:hover {
  color: #777;
  background: #ccc;
}

.picture:active {
  border-color: turquoise;
  color: turquoise;
  background: #eee;
}

.picture:focus {
  color: #777;
  background: #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.picture__img {
  max-width: 100%;
}
</style>

<body>
<label class="picture" for="picture__input" tabIndex="0">
  <span class="picture__image"></span>
</label>

<input type="file" name="picture__input" id="picture__input">
</div>



<script>
const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");
const pictureImageTxt = "Carregar imagem";
pictureImage.innerHTML = pictureImageTxt;

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function (e) {
      const readerTarget = e.target;

      const img = document.createElement("img");
      img.src = readerTarget.result;
      img.classList.add("picture__img");

      pictureImage.innerHTML = "";
      pictureImage.appendChild(img);
    });

    reader.readAsDataURL(file);
  } else {
    pictureImage.innerHTML = pictureImageTxt;
  }
});

</script>
</body>
</html>