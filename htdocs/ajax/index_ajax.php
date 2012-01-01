<?php
@header("Content-Type:text/plain; charset=utf-8");
//弹出一键填单相关ajax数据处理
include("../common.inc.php");
InitGP(array("action","url","refuname","referer","aid","cityid")); //初始化变量全局返回
AjaxHead();
$jsonarray=$dataarray=array();
if($action=='maqueeproduct'){
	include_once(INC_PATH."/order.class.php");
	$o=OrderClass::init();
//	$wherestr[]="uname='".$_USERS['uname']."'";
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$dataarray=$o->getdata(10,$wheresql,"oid desc","*"); //获取数据
	$jsonarray=array();
	foreach ($dataarray as $key=>$val){
		$jsonarray[$key]['c']=$val['typeid'];
		$jsonarray[$key]['d']=ddate('m-d', $val['addtime']);
		$jsonarray[$key]['id']=$val['oid'];
		$jsonarray[$key]['m']=$val['goodsprice'];
		$jsonarray[$key]['n']=$val['goodsname'];
		$jsonarray[$key]['p']=$val['showimg'];
		$jsonarray[$key]['s']=$val['goodssite'];
		$jsonarray[$key]['u']=$val['goodsurl'];
		$jsonarray[$key]['un']=substrs($val['uname'],2,1)."***";
	}
	echo json_encode($jsonarray);
	
	//echo '[{"id":755285,"un":"木***y","n":"2010日韩新款秋季甜美向日葵娃娃鞋女鞋/单鞋/平底鞋/订大码","u":"http://item.taobao.com/item.htm?id=5970369688&taomi=8aR2LQR6GJQQsvvZN5m1a7Q8hHfQgg%2BrQHW2MVsqGxBX%2BBsSaNVdF2aNxTE3UMqSeG%2BfpJaI0obJL6V2Q%2BFP2s5KwHnvk%2Fh629ylx1BFsfIDL5BWmtieSYGhBWSvxqwM32LznBT4Lm","p":"http://img.panli.com/goods/small/2010/08/31/755285.jpg","m":39.90,"d":"8分钟前","c":99,"s":"淘宝"},{"id":755284,"un":"木***y","n":"JJS 推荐 2010春天 韩版瑞丽女装  长袖开身显瘦休闲外套1500","u":"http://item.taobao.com/item.htm?id=5195199724&taomi=8aR2LQR6GJQYVWg2cyUMEwq6qDueIMvH8WFfVSp83Sb2cf6c2Cn6Wg%2BwtyQibpmBIAtGoqHqqOsFNz0PlN28lM7I4l2YJlwXU9w6oeroKZxkjMkHG0TTyyJ4GeSMvzVRDdVOaIxLWyNmeisf%2","p":"http://img.panli.com/goods/small/2010/08/31/755284.jpg","m":12.00,"d":"8分钟前","c":99,"s":"淘宝"},{"id":755283,"un":"木***y","n":"包邮！正品匡威川久保玲PLAY明星鬼脸米色高帮爱心男女情侣帆布鞋","u":"http://item.taobao.com/item.htm?id=7035442987&ali_refid=a3_419342_1006:1102983467:6:%B7%AB%B2%BC%D0%AC:00c32dac57e5923cfd643311bc0ff810&ali_trackid=1_00c32dac57e5923cfd643311bc0ff810","p":"http://img.panli.com/goods/small/2010/08/31/755283.jpg","m":88.00,"d":"8分钟前","c":99,"s":"淘宝"},{"id":755282,"un":"木***y","n":"（台湾馆）**PG美人网**Y580【6/18缤纷洞洞侧肩包】4色","u":"http://item.taobao.com/item.htm?id=5861366980&taomi=8aR2LQR6GJQRJG%2FMR%2BNE0u2uOmIMBhGhN9v%2F61VbirwB%2BUGMra5cv9kBuk4iH%2BzbBuFFonT6YF%2BFBWZCRw0E3DHFVMAYOLTL%2Bcd6OoUhRGzKzwRXhqkwDwFh9BrRTQiAFTvDdu","p":"http://img.panli.com/goods/small/2010/08/31/755282.jpg","m":52.00,"d":"8分钟前","c":99,"s":"淘宝"},{"id":755281,"un":"v***g","n":"质感一流~韩版纯手工编织毛球短檐网眼毛线帽/女款冬季帽子","u":"http://item.taobao.com/item.htm?id=3740516109","p":"http://img.panli.com/goods/small/2010/08/31/755281.jpg","m":38.00,"d":"9分钟前","c":99,"s":"淘宝"},{"id":755276,"un":"l***n","n":"伊人小径 超值韩版！优雅女人味 花朵珍珠腰链 水钻pd1866","u":"http://auction1.taobao.com/auction/item_detail-0db2-26a3927e7bf299c0799ffbbee52664bd.jhtml","p":"http://img.panli.com/goods/small/2010/08/31/755276.jpg","m":28.00,"d":"14分钟前","c":99,"s":"淘宝"},{"id":755275,"un":"l***n","n":"呛口小辣椒同款 ZARA限量款百搭铆钉圆钉松紧腰带腰封","u":"http://item.taobao.com/item.htm?id=5601838968","p":"http://img.panli.com/goods/small/2010/08/31/755275.jpg","m":12.80,"d":"14分钟前","c":99,"s":"淘宝"},{"id":755274,"un":"l***n","n":"韩国时尚 复古柳钉金属亮片 百搭朋克松紧宽腰封/女式束腰带/裙带","u":"http://item.taobao.com/item.htm?id=4143404593","p":"http://img.panli.com/goods/small/2010/08/31/755274.jpg","m":5.80,"d":"14分钟前","c":99,"s":"淘宝"},{"id":755273,"un":"l***n","n":"[美一步皇冠店]舒适满载铆钉超可爱平底侧花朵娃鞋鞋(推荐款)","u":"http://item.taobao.com/auction/item_detail-0db1-dc36f00dd0c1c299f7d12749e4288efc.htm","p":"http://img.panli.com/goods/small/2010/08/31/755273.jpg","m":49.00,"d":"14分钟前","c":99,"s":"淘宝"},{"id":755272,"un":"v***g","n":"10新款能穿的韩版T恤哦~特小号-特大号，瑞丽KOKO杂志款0A1017","u":"http://item.taobao.com/item.htm?id=1639260120","p":"http://img.panli.com/goods/small/2010/08/31/755272.jpg","m":96.00,"d":"15分钟前","c":99,"s":"淘宝"},{"id":755271,"un":"v***g","n":"10新款大码胖装肥装简约运动型螺纹弹力腰头休闲裤D0359 黑色","u":"http://item.taobao.com/item.htm?id=4486123938","p":"http://img.panli.com/goods/small/2010/08/31/755271.jpg","m":89.00,"d":"15分钟前","c":99,"s":"淘宝"},{"id":755270,"un":"v***g","n":"09新款秋季大尺码胖装肥装超百搭折皱中领内搭衣A8516 三色入","u":"http://item.taobao.com/item.htm?id=1638510536","p":"http://img.panli.com/goods/small/2010/08/31/755270.jpg","m":39.00,"d":"15分钟前","c":99,"s":"淘宝"},{"id":755269,"un":"v***g","n":"09新款秋季大码胖MM的高领彩色百搭打底衫长袖T恤A8517 4色入","u":"http://item.taobao.com/item.htm?id=1757501054","p":"http://img.panli.com/goods/small/2010/08/31/755269.jpg","m":39.00,"d":"15分钟前","c":99,"s":"淘宝"},{"id":755268,"un":"悠***y","n":"会拉丝的老祖母冷制纯橄榄皂 添加蛋黄 干皮必选","u":"http://item.taobao.com/item.htm?id=2227452249","p":"http://img.panli.com/goods/small/2010/08/31/755268.jpg","m":9.90,"d":"15分钟前","c":99,"s":"淘宝"},{"id":755267,"un":"v***g","n":"09新款大码胖装肥装 大筒围大腿围真牛皮内增高骑士靴YM10081","u":"http://item.taobao.com/item.htm?id=1644662476","p":"http://img.panli.com/goods/small/2010/08/31/755267.jpg","m":228.00,"d":"15分钟前","c":99,"s":"淘宝"}]';
	exit;
	
}else if($action=='recommendproduct'){
	
	$goodsobj=new TableClass('goods','gid');
	$dataarray=$goodsobj->getdata(10,"flag='c'",'buynum asc,gid desc','gid,gtypeid,goodsurl,goodsname,goodsprice,goodsseller,goodsimg,sellerurl,shopname,rindex,views,buynum,listorder,flag,addtime');
	$j=$i=0;
	foreach ($dataarray as $key=>$val){
		$jsonarray[$j][$i]['id']=$val['gid'];
		$jsonarray[$j][$i]['m']=$val['goodsprice'];
		$jsonarray[$j][$i]['n']=$val['goodsname'];
		$jsonarray[$j][$i]['p']=$val['goodsimg'];
		$jsonarray[$j][$i]['s']=$val['buynum'];
		$i++;
		if ($i>=5) {
			$i=0;$j++;
		}
	}
	echo json_encode($jsonarray);
	exit;
	
	//echo '[[{"n":"耸肩小夹克","m":"494.00","p":"http://img.panli.com/CMS/product/8727/cover/mimg/8727.jpg","id":8727,"s":1},{"n":"月饼模具四花片","m":"14.00","p":"http://img.panli.com/CMS/product/8787/cover/mimg/8787.jpg","id":8787,"s":2},{"n":"爱丽丝复古发箍","m":"29.00","p":"http://img.panli.com/CMS/product/8731/cover/mimg/8731.jpg","id":8731,"s":1},{"n":"简约贵气修身款衬衫","m":"58.00","p":"http://img.panli.com/CMS/product/8723/cover/mimg/8723.jpg","id":8723,"s":2},{"n":"时尚兔毛高跟短靴","m":"198.00","p":"http://img.panli.com/CMS/product/8756/cover/mimg/8756.jpg","id":8756,"s":3}],[{"n":"神奇小眼变大眼魔贴","m":"3.88","p":"http://img.panli.com/CMS/product/8753/cover/mimg/8753.jpg","id":8753,"s":3},{"n":"白色粗线针织毛衣","m":"49.00","p":"http://img.panli.com/CMS/product/8780/cover/mimg/8780.jpg","id":8780,"s":7},{"n":"周黑鸭真空简包鸡尖","m":"18.00","p":"http://img.panli.com/CMS/product/8770/cover/mimg/8770.jpg","id":8770,"s":4},{"n":"强力吸盘三角浴室架","m":"6.30","p":"http://img.panli.com/CMS/product/8775/cover/mimg/8775.jpg","id":8775,"s":2},{"n":"soft rock知秋衬衫","m":"139.00","p":"http://img.panli.com/CMS/product/8734/cover/mimg/8734.jpg","id":8734,"s":3}],[{"n":"呛口小辣椒秀天使马戏团包包卡通包","m":"33.00","p":"http://img.panli.com/CMS/product/8763/cover/mimg/8763.jpg","id":8763,"s":5},{"n":"店主超级推荐 斜彩条斗篷型针织衫","m":"75.00","p":"http://img.panli.com/CMS/product/8725/cover/mimg/8725.jpg","id":8725,"s":7},{"n":"古香古色 景泰蓝黑玛瑙五福手链","m":"22.00","p":"http://img.panli.com/CMS/product/8766/cover/mimg/8766.jpg","id":8766,"s":4},{"n":"★新作★VentiAnni超ING流苏牛仔靴","m":"230.00","p":"http://img.panli.com/CMS/product/8755/cover/mimg/8755.jpg","id":8755,"s":2},{"n":"创意折叠迷你笔式电烫睫毛夹","m":"11.80","p":"http://img.panli.com/CMS/product/8784/cover/mimg/8784.jpg","id":8784,"s":7}]]';
	exit;
}
?>