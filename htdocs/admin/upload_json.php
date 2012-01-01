<?php
include("../common.inc.php");
include("function_common.php");
//文件保存目录URL
$save_url = '../';
//定义允许上传的文件扩展名
$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
//最大文件大小
$max_size = 3000000;

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}

	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("临时文件可能不是上传文件。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr) === false) {
		alert("上传文件扩展名是不允许的扩展名。");
	}
	/*
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	*/
	require_once (INC_PATH.'/upload.class.php');
	$f = new Upload('../attachment/editor',array('gif','jpg','jpge','png'),50000);
	$f->setThumb(0);//设置不生成缩微图
	$f->run('imgFile',1);
	$info=$f->getInfo();
	$imgdata=$info[0]['fullsavename'];//获取第一个上传图片反馈
	
	
	$file_url = $save_url . $imgdata;
	@chmod($file_url, 0644);
	header('Content-type: text/html; charset=UTF-8');
	echo json_encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$msg=iconv(CHARSET, 'UTF-8',$msg);  
	echo json_encode(array('error' => 1, 'message' => $msg));
	exit;
}
?>