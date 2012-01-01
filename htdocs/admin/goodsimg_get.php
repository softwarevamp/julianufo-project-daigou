<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","startid","endid","starttime","endtime","type","oid","ids","did","delids")); //初始化变量全局返回
$Table=new TableClass("order","oid");
AjaxHead();//禁止页面缓存
set_time_limit(0);



if(!empty($type)||!empty($oid)){

	if(!empty($oid)){
		if(is_numeric($oid)){
			$wherestr[]="oid"." = ".$oid;
		}elseif(is_array($oid)){
			$ids=getdotstring($oid,'int');
			$wherestr[]="oid"." in ({$ids})";
		}elseif(is_string($oid) && (strexists($oid,',') || strexists($oid,'|'))){
			if(strexists($oid,',')){
				$ids=getdotstring($oid,'int');
			}else{
				$ids=getdotstring(explode('|',$ids),'int');
			}
			$wherestr[]="oid"." in ({$ids})";
		} else{
			exit("ID格式错误");	
		}

	}elseif(!empty($type)){
		if($type=="all"){
		}elseif($type=="idlist"){
			if(GetNum($startid) and GetNum($endid)){
				$wherestr[]="oid >={$startid}";
				$wherestr[]="oid <={$endid}";
				
			}else{showmsg("ID范围必须填写！",PHP_SELF);}
		}elseif($type=="timelist"){
			if(!empty($starttime)&&!empty($endtime)){
				$starttimeunix=strtotime($starttime);
				$endtimeunix=strtotime($endtime);
				$wherestr[]="addtime >{$starttimeunix}";
				$wherestr[]="addtime <{$endtimeunix}";
			}else{showmsg("时间范围必须填写！",PHP_SELF);}
		}
	}
	//if(!empty($state))$wherestr[]="state='{$state}'";
	$wherestr[]="orderimg is NULL or orderimg =''";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	
	//获取当前页码
	$total=$Table->getcount($wheresql); 							  //总信息数
	$pagesize=10;												  //一页显示信息数
	$page = isset($page) ? max(1, intval($page)) : 1;             //处理页码变量
	$offset=($page-1)*$pagesize;   								  //偏移量
	$dataarray=$Table->getdata("$offset,$pagesize",$wheresql,'','oid,goodsimg,orderimg'); //获取团购数据
	$msg="总共需要抓取图片:{$total}个<br/>";
	if(!empty($dataarray)){
		//抓取图片操作
		foreach($dataarray as $val){
			//远程图本地化
			if(!empty($val['goodsimg'])){
				$tempimg=GetRemoteImage($val['goodsimg']);
				$thumbname="../".$tempimg['savepath']."_thumb_".$tempimg['filename'];
				makeThumb("../".$tempimg['filepath'],$thumbname);
				editstate($Table->table,"orderimg","oid=".$val['oid'],$tempimg['filepath']);//更改图片地址操作
				$msg.="更新订单ID:{$val['oid']} 图片地址成功<br/>";
			}
		}
		$url=geturl();
		$goto = url::replace($url, "page=".($page+1),0,1);	
		showmsg($msg,$goto);
	}else{
		showmsg("抓取完成!","goodsimg_get.php");
	}
}else{

	//包含后台模板文件
	include("tpl/goodsimg_get.htm");
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