<?php
  move_uploaded_file($_FILES["upload"]["tmp_name"], "../site/images/posts/" . $_FILES["upload"]["name"]);
?>
