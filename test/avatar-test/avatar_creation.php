<?php



$skin = imagecreatefrompng("img/skin".$_GET['skin'].".png");
$eye = imagecreatefrompng("img/eye".$_GET['eye'].".png");
$mouth = imagecreatefrompng("img/mouth".$_GET['mouth'].".png");



$avatar = imagecopy($skin, $eye, 0, 0, 0, 0, 300, 300);
$avatar = imagecopy($avatar, $mouth, 0, 0, 0, 0, 300, 300);

imagepng($avatar, "img/avatar.png");