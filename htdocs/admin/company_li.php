<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title></title>
<link href="_css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="_script/jquery.js"></script>
<script src="_script/jquery.colorbox.js"></script>
<link type="text/css" media="screen" rel="stylesheet" href="_script/jquery.colorbox.css" />
<script type="text/javascript">
$(function(){$(".user_x").colorbox({iframe:true,innerWidth:506, innerHeight:580});});
function checkclick(msg){if(confirm(msg)){event.returnValue=true;}else{event.returnValue=false;}}
$( function() {	
	// 全选反选	
	$("#checkboxall").click(function(){   
	    var checked_status = this.checked;   
		$("input[name='id[]']").each(function(){this.checked = checked_status;});
		});		
	// 选中的值	
	$("#sendAll").click(function(){
	
		var selectedStr = "";
		var $sendMail = $("input[name='id[]']");		
		$sendMail.each( function() {
			if ($(this).attr("checked")) {
				selectedStr += $(this).val() + "|";
			}
		});
		
		//alert(selectedStr);
		if (selectedStr == "") {
			$("#act")[0].value="";
			alert("至少选择一条数据");
			return false;
		}
		
	//判断类型
	var acts = $("#act")[0].value;
	if(acts=="del"){
	if(confirm("您确认要删除？")){		
    $.post("company_li.php", {act:acts, ids: selectedStr}, 
		   function(data){
				  if(data==1){location.reload();}else{alert("删除出错");}
				  //alert(data);return false;				  
				  }); 
    }
	}
//alert(selectedStr+$("#act")[0].value);		
	});
});
</script>
<SCRIPT type=text/javascript>
function tools(){
var box_h="1";	
var top=$(document).scrollTop();
$("#topv")[0].value=top;
if(($.browser.msie==true)&&($.browser.version==6.0)){
if(top>box_h)$("#box_tools").css({position:"absolute",top:top-box_h});
}else{
if(top>box_h)$("#box_tools").css({position:"fixed",top:"-"&top+"px"});
}
if(top<=box_h)$("#box_tools").css({position:"static",top:0});
}

$(function(){
window.onscroll=tools;
window.onresize=tools;
});
</SCRIPT>
<!--[if lt IE 7]><script type="text/javascript" src="_script/unitpngfix.js"></script><![endif]-->
</head>
<body>
<div id="box_tools" class="floor_t">
  <div  class="toolbgline">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="28"><a href="javascript:location.reload();"><img src="images/admin.gif" alt="刷新" width="28" height="20" /></a></td>
        <td width="172"><input type="hidden" id="act" name="act" value="" />
          <a href="company_add.php" target="_blank" class="user_x btn_a">新增企业</a><a href="####"  onclick="document.getElementById('act').value='del'" id="sendAll" class="btn_a" style="margin-left:5px">删除已选</a></td>
        <td width="200"><table border="0" align="right" cellpadding="0" cellspacing="0">
            <form method="get" name="form" id="form" >
              <tr>
                <td width="110" align="center"><input name="keywords" type="text" class="input" value="<?php echo $_GET['keywords']?>" size="20" /></td>
                <td width="2"></td>
                <td width="52"><input name="Submit3" type="submit" class="btn" value="搜索" /></td>
              </tr>
            </form>
          </table></td>
        <td align="right">共<?php echo $total;?>条 每页显示<?php echo $num;?>条 </td>
        <td width="20"><input class="input"  style="width:20px;margin-right:2px" name="topv" type="text" id="topv" value="" /></td>
        <td width="1"></td>
      </tr>
    </table>
  </div>
</div>
<div class="floor_c">
  <div class="xn"></div>
  <div class="boxf">
    <div class="boxn">
      <table id="table">
        <tr class="th" >
          <td width="20"><input type="checkbox" id=checkboxall name="chkall" value='ON' /></td>
          <td width="40">修改</td>
          <td>城市|公司名</td>
          <td>电话|传真</td>
          <td>地址</td>
          <td>邮编</td>
          <td>网址</td>
          <td>部门</td>
          <td>分店</td>
          <td>备注</td>
          <td>添加日期</td>
        </tr>

        <tr align="center" class="ths" onmouseover="this.style.backgroundColor='#E7E7E7'" onmouseout="this.style.backgroundColor=''" <?php echo $bgcolor?>>
          <td width="20"><input type="checkbox" name="id[]" value="<?php echo $thread["id"]?>" /></td>
          <td width="40"><a href="company_edit.php?id=<?php echo $thread["id"]?>"  target="_blank" class="user_x"><img src="images/23x16.gif" /></a></td>
          <td><?php echo $thread["region"]?> | <?php echo $thread["name"]?></td>
          <td><?php echo $thread["phone"]?>|<?php echo $thread["fax"]?></td>
          <td><?php echo $thread["address"]?></td>
          <td><?php echo $thread["zip"]?></td>
          <td><?php echo $thread["homepage"]?></td>
          <td><?php echo $thread["dep"]?></td>
          <td><?php echo $thread["shop"]?></td>
          <td><?php echo $thread["conn"]?></td>
          <td><?php echo $thread["startdate"]?></td>
        </tr>

        <tr>
          <td colspan="11"  bgcolor="#E7F0FF"><?php $time_end = 0;printf ("[页面执行时间: %.2f 毫秒]\n\n",($time_end - $time_start)*1000);?></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="xn"></div>
  <div class="x1"></div>
</div>
<iframe src="about:blank" name="ActFrm" id="ActFrm" style="display:none"></iframe>
</body>
</html>
