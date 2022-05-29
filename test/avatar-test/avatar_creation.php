<?php



$avatar = imagecreatefrompng("img/skin".$_GET['skin'].".png");
$eye = imagecreatefrompng("img/eye".$_GET['eye'].".png");
$mouth = imagecreatefrompng("img/mouth".$_GET['mouth'].".png");



imagecopy($avatar, $eye, 0, 0, 0, 0, 300, 300);
imagecopy($avatar, $mouth, 0, 0, 0, 0, 300, 300);

imagepng($avatar, "avatars/avatar.png");