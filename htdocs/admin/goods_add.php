<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","state","value","gid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("goods","gid");
AjaxHead();//禁止页面缓存

if(empty($action)){
	InitGP(array("gid","gtypeid","goodsurl","goodsname","goodsprice","goodsseller","goodsimg","sellerurl","shopname","views","buynum","rank","why","listorder","about","flag")); //初始化变量全局返回
	if(!empty($_POST) and !empty($goodsname) and !empty($goodsprice)){

		$gid=GetNum($gid);
		if(empty($gtypeid))showmsg("必须选择分类!",PHP_SELF);//出错！
		if(empty($goodsurl))showmsg("商品地址不能为空!",PHP_SELF);//出错！
		if(empty($goodsname))showmsg("商品名称不能为空!",PHP_SELF);//出错！
		if(empty($goodsprice))showmsg("商品价格不能为空!",PHP_SELF);//出错！
		//远程图本地化
		if(!empty($goodsimg)){
			$tempimg=GetRemoteImage($goodsimg);
			$thumbname="../".$tempimg['savepath']."_thumb_".$tempimg['filename'];
			makeThumb("../".$tempimg['filepath'],$thumbname);
			$goodsimg=$tempimg['filepath'];
		}
		
		$arrayadd=array(
			"gtypeid"=> GetNum($gtypeid),
			"goodsurl"=> Char_cv($goodsurl),
			"goodsname"=> Char_cv($goodsname),
			"goodsseller"=> Char_cv($goodsseller),
			"goodsimg"=> Char_cv($goodsimg),
			"sellerurl"=> Char_cv($sellerurl),
			"shopname"=> Char_cv($shopname),
			"why"=> Char_cv($why),
			"goodsprice"=> GetNum($goodsprice),
			"rindex"=> GetNum($rank),
			"views"=> GetNum($views),
			"buynum"=> GetNum($buynum),
			"listorder"=> GetNum($listorder),
			"about"=>HtmlReplace($about,-1),
			"flag"=>Char_cv($flag),
			"Audit"=>1,
			"addtime"=>time()
		);
		$info=$Table->add($arrayadd);
		if(GetNum($info)){
				showmsg("发布成功!",PHP_SELF);//出错！
		}else{
			showmsg("发布失败!","-1");//出错！
		}
	}else{
		if(!empty($_POST['goodsurl'])){
			include(INC_PATH."/shopsite.class.php");
			$shop=ShopClass::init();
			$shopinfo=$shop->get($_POST['goodsurl']);
			$evalue=$shopinfo;
			$evalue['goodsurl']=$shopinfo['url'];
		}
		//print_r($evalue);
		include("tpl/goods_add.htm");
	}
}elseif($action=="edit" && !empty($gid)){
	InitGP(array("gid","gtypeid","goodsurl","goodsname","goodsprice","goodsseller","goodsimg","sellerurl","shopname","views","buynum","rank","why","listorder","about","flag")); 
	if(!empty($_POST) and !empty($goodsname) and !empty($gid)){

		$gid=GetNum($gid);
		if(empty($gtypeid))showmsg("必须选择分类!",PHP_SELF);//出错！
		if(empty($goodsurl))showmsg("商品地址不能为空!",PHP_SELF);//出错！
		if(empty($goodsname))showmsg("商品名称不能为空!",PHP_SELF);//出错！
		if(empty($goodsprice))showmsg("商品价格不能为空!",PHP_SELF);//出错！
		$arrayadd=array(
			"gtypeid"=> GetNum($gtypeid),
			"goodsurl"=> Char_cv($goodsurl),
			"goodsname"=> Char_cv($goodsname),
			"goodsseller"=> Char_cv($goodsseller),
			"goodsimg"=> Char_cv($goodsimg),
			"sellerurl"=> Char_cv($sellerurl),
			"shopname"=> Char_cv($shopname),
			"why"=> Char_cv($why),
			"flag"=> Char_cv($flag),
			"goodsprice"=> GetNum($goodsprice),
			"rindex"=> GetNum($rank),
			"views"=> GetNum($views),
			"buynum"=> GetNum($buynum),
			"listorder"=> GetNum($listorder),
			"about"=>HtmlReplace($about,-1),
			"addtime"=>time()
		);
		$info=$Table->edit($gid,$arrayadd);

		if($info=="OK"){
				showmsg("更新成功!","goods_list.php");//出错！
		}else{
			showmsg("更新失败!","goods_list.php");//出错！
		}
	}else{
		$evalue=$Table->getone($gid);
		include("tpl/goods_add.htm");
	}

}else{
	showmsg("未知请求","-1");//出错！
}

//获取选择文章分类下拉框
function getatypeselect($var="",$value="",$other=""){
	$Table=new TableClass("gtype","typeid");
	$arraydata=$Table->getdata('','','typeid asc');
	foreach ($arraydata as $val){
		$arrayoption[$val['typeid']]=$val['typename'];
	}
	return getselectstr($var, $arrayoption, $value, $other);
}

//创建缩微图函数
function makeThumb ($imgPath,$filename,$width=100,$height=100) {

     $types = array(1 => 'gif',2 => 'jpg',3 => 'png'); //允许的图片类型 
     if (!file_exists ($imgPath)) { //如果图片不存在，则返回 
         echo "图片地址错误！"; 
         return false; 
     } 
     $imgInfo = getimagesize($imgPath); //得到图片的大小信息 
     $realWidth= $imgInfo[0]; //取得图片的真实宽度 
     $realHeight= $imgInfo[1]; //取得图片的真实高度 
     if ($realWidth < $width && $realHeight < $height) { //如果图片的真实宽高都小于要生成的缩略图的宽高，则按实际大小生成 
         $newWidth = $realWidth; 
         $newHeight = $realHeight; 
     } else { 
         $bili = min ($width/$realWidth,$height/$realHeight); //取得原图与生成图之间的比例 
         $newWidth = (int) $realWidth*$bili; //按比例算出新图的宽 
         $newHeight = (int) $realHeight*$bili; //按比例算出新图的高 
     } 
     if (isset ($types[$imgInfo[2]])) { //如果原图是允许的类型 
         $imgType   = $types[$imgInfo[2]]; //取出全图的类型   ，详细请查阅 getimagesize 函数的返回值 
         if ($imgType == 'jpg') { //如果图片类型是jpg ，刚把它转化成jpeg 
             $imgType = 'jpeg'; 
         } 
     } else {
         echo "error!"; 
         return false; //如果原图类型不对，则返回 
     } 
     $createFun   = 'ImageCreateFrom'.$imgType; //根据不同的图片类型，创建不同的函数名 
     $oldimg     = $createFun($imgPath); //用新创建的函数来拷贝原图 
     $newimg = imagecreatetruecolor($newWidth, $newHeight); //以新的宽高来创建新图 
     ImageCopyResized($newimg, $oldimg, 0, 0, 0, 0, $newWidth, $newHeight, $realWidth,$realHeight); //把原图拷贝到新图里并调整大小 
     $imageFun = 'image'.$imgType; //根据图片类型构造创建新图的函数名 
     !@$imageFun($newimg,$filename,90) && die('保存失败!检查目录是否存在并且可写?'); //保存新图 
     ImageDestroy($newimg); //销毁新图句柄 
     ImageDestroy($oldimg); //销毁原图句柄 
     return $filename; //返回保存的文件名 

} 


?>