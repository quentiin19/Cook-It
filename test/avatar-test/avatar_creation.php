<?php



$skin = createimagefrompng("img/skin".$_GET['skin'].".png");
$eye = createimagefrompng("img/eye".$_GET['eye'].".png");
$mouth = createimagefrompng("img/mouth".$_GET['mouth'].".png");



$avatar = imagecopy($skin, $eye, 0, 0, 0, 0, 300, 300);
$avatar = imagecopy($avatar, $mouth, 0, 0, 0, 0, 300, 300);

imagepng($avatar, "img/avatar.png");