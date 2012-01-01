<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>------</title>
<link href="_css/style.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]><script type="text/javascript" src="_script/unitpngfix.js"></script><![endif]-->
<script type="text/jscript" src="_script/jquery.js"></script>
<!-- Arquivos utilizados pelo jQuery jgrowl plugin -->
<script type="text/javascript" src="_script/jquery.jgrowl.js"></script>
<link rel="stylesheet" type="text/css" href="_script/jquery.jgrowl.css" media="screen" />
<!--[if lt IE 7]><LINK href="_script/jquery.jgrowl.ie6.css" type=text/css rel=stylesheet><![endif]-->
<!-- / fim dos arquivos utilizados pelo jQuery jgrowl plugin -->
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
</head>
<body>
<div id="box_tools" class="floor_t">
  <div class="toolbgline">
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="28"><a href="javascript:location.reload();"><img src="images/admin.gif" alt="刷新" width="28" height="20" /></a></td>
        
        <td>&nbsp;</td>
        
        <td width="20"><input class="input w200"  style="width:20px;margin-right:2px" name="topv" type="text" id="topv" value="" /></td>
        <td width="1"></td>
      </tr>
    </table>
  </div>
</div>
<div class="floor_c">  
  <div class="xn"></div>
  <div class="boxf">
    <div class="boxn">
<script>    
function checkform()
{
/*	var title = document.getElementById("title");
	if(title.value=="")
	{
		alert("作品标题不能为空，请输入！");
		title.focus();
		return false;
	}*/

	
	document.form.reback.disabled=true;
	document.form.save.disabled=true;
	//document.form.save.value='提交中';
	return true;
}
function nform()
{
	document.form.reback.disabled=false;
	document.form.save.disabled=false;
	return true;
}


</script>    
    
    
      <form name="form" target="ActFrm" enctype="multipart/form-data" method="post" onSubmit="return checkform()">
        <table id="table">
          <tr class="th" >
            <td  colspan="6">&nbsp;&nbsp;修改公司基本信息：(网站页脚处信息)</td>
          </tr>
          <tr>
            <td  class="lh">公司名称：</td>
            <td height="22" colspan="5" bgcolor="#FFFFFF"><input name="company" type="text" class="input w200" id="company" value="<?php echo $t_wi["company"]?>" >
              <input type="hidden" name="act" value="ok"></td>
          </tr>
          <tr>
            <td  class="lh">公司地址：</td>
            <td height="22" colspan="5" bgcolor="#FFFFFF"><input name="address" type="text" class="input w200" id="address"  value="<?php echo $t_wi["address"]?>"></td>
          </tr>
          <tr>
            <td  class="lh">公司邮编：</td>
            <td width="162" height="22" bgcolor="#FFFFFF"><input name="postcode" type="text" class="input w200" id="postcode"  value="<?php echo $t_wi["postcode"]?>" ></td>
            <td  class="lh">公司电话：</td>
            <td width="162" bgcolor="#FFFFFF"><input name="telephone" type="text" class="input w200" id="telephone" value="<?php echo $t_wi["telephone"]?>" ></td>
            <td  class="lh">公司传真：</td>
            <td bgcolor="#FFFFFF"><input name="facsimile" type="text" class="input w200" id="facsimile" value="<?php echo $t_wi["facsimile"]?>" ></td>
          </tr>
          <tr>
            <td  class="lh">电子邮件：</td>
            <td width="162" height="22" bgcolor="#FFFFFF"><input name="email" type="text" class="input w200" id="email"  value="<?php echo $t_wi["email"]?>"></td>
            <td  class="lh">联系QQ：</td>
            <td width="162" height="22" bgcolor="#FFFFFF"><input name="qq" type="text" class="input w200" value="<?php echo $t_wi["qq"]?>"  /></td>
            <td  class="lh">联系msn：</td>
            <td height="22" bgcolor="#FFFFFF"><input name="msn" type="text" class="input w200" id="msn"   value="<?php echo $t_wi["msn"]?>"></td>
          </tr>
          <tr>
            <td  class="lh">版权信息：</td>
            <td width="162" height="22" bgcolor="#FFFFFF"><input name="copyright" type="text" class="input w200" id="copyright"  value="<?php echo $t_wi["copyright"]?>"  ></td>
            <td  class="lh">法律顾问：</td>
            <td width="162" height="22" bgcolor="#FFFFFF"><input name="adviser" type="text" class="input w200" id="adviser"  value="<?php echo $t_wi["adviser"]?>"></td>
            <td  class="lh">站点域名：</td>
            <td height="22" bgcolor="#FFFFFF"><input name="http" type="text" class="input w200" id="http"   value="<?php echo $t_wi["http"]?>"></td>
          </tr>
        </table>
        <table id="table" style="margin-top:10px">
          <tr class="th" >
            <td colspan="2">&nbsp;&nbsp;SEO信息：(网站搜索引擎用信息)</td>
          </tr>
          <tr>
            <td  class="lh">Title：</td>
            <td height="22" bgcolor="#FFFFFF"><input name="title" type="text" class="input w200" id="title"  value="<?php echo $t_wi["title"]?>">
              注：网页标题信息</td>
          </tr>
          <tr>
            <td  class="lh">关 键 字：</td>
            <td height="22" bgcolor="#FFFFFF"><input name="seo" type="text" class="input w200" id="seo"  value="<?php echo $t_wi["seo"]?>">
              如：气车,维修,拍卖</td>
          </tr>
          <tr>
            <td  class="lh">网站介绍：</td>
            <td height="22" bgcolor="#FFFFFF"><input name="intro" type="text" class="input w200" id="intro"  value="<?php echo $t_wi["intro"]?>">
              如：本网站是气车维修类网站</td>
          </tr>
        </table>
        
        <table id="table" style="margin-top:10px">
          <tr class="th" >
            <td colspan="2">&nbsp;&nbsp;嵌入代码：(嵌入到每个页面的末尾)</td>
          </tr>
          <tr>
            <td  class="lh">嵌入代码：</td>
            <td height="22" bgcolor="#FFFFFF"><textarea name="code" cols="100" rows="5" class="textarea"  id="code">fffffff</textarea></td>
          </tr>
        </table>

        <div align="center" style="margin-top:10px"><input name="save" type="submit" class="btn" value="确认更新">&nbsp;&nbsp;<input name="reback" type="reset" class="btn" value="重新填写"></div>
      </form>
    </div>
  </div>
  <div class="xn"></div>
  <div class="x1"></div>
</div>
<iframe src="about:blank" name="ActFrm" id="ActFrm" style="display:none"></iframe>


</body>
</html>