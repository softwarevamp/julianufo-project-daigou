<?php
include 'securimage.php';
$img = new securimage();
$_GET['s']='';
$_GET['t']='';
$w=GetNum($_GET['w']);
$h=GetNum($_GET['h']);
$width=131;
$height=28;
if(!empty($w))$width=$w;
if(!empty($h))$height=$h;

$img->image_width = $width;
$img->image_height = $height;
$img->font_size = 16;
$img->text_x_start = 1;
$img->text_minimum_distance = 12;
$img->text_maximum_distance = 13;
$img->arc_linethrough = false;
$img->charset = '0123456789';
$img->perturbation = 0.4; // 1.0 = high distortion, higher numbers = more distortion
$img->image_bg_color = new Securimage_Color("#ff6600");
$img->text_color = new Securimage_Color("#EAEAEA");
$img->text_transparency_percentage = 100; // 100 = completely transparent
$img->num_lines = 1;
$img->line_color = new Securimage_Color("#cccccc");
$img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
//$img->image_type = SI_IMAGE_PNG;
$img->code_length = 4;

$img->show();
