<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>- 程序管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="_css/css.css" rel="stylesheet" type="text/css" />
<SCRIPT src="_script/jquery.js" type=text/javascript></SCRIPT>
<!--[if lt IE 7]><script type="text/javascript" src="_script/unitpngfix.js"></script><![endif]-->
<script language="javascript"> 
function firm() { 
if(confirm("您是否要真的退出本系统?")){//如果是true 
location.href="?act=logout"; 
}else{} 
} 
</script>
</head>
<body>
<div id="header">
  <div style="background:url(images/logo.jpg) no-repeat;">
    <div id="innerHeader">
      <div id="innerHeaders">
	头部部分头部部分头部部分头部部分
		
      </div>
      <div id="topguide">
        <ul id="topguide-entry">
          <li id="Common" onmouseover="showguide(this.id);"><a style="cursor:pointer" href="javascript:" onclick="return initguide('Common');"><span>常用管理</span></a></li>	
          <li id="Options" onmouseover="showguide(this.id);"><a style="cursor:pointer" href="javascript:" onclick="return initguide('Options');"><span>基本设置</span></a></li>
          <li id="UserMan" onmouseover="showguide(this.id);"><a style="cursor:pointer" href="javascript:" onclick="return initguide('UserMan');"><span>用户管理</span></a></li>

        </ul>
      </div>
    </div>
    <div class="c"></div>
    <div id="guide"></div>
  </div>
</div>
<div id="selector">
  <div id="left" class="inner"></div>
</div>
<div id="gird">
  <div class="inner">
    <iframe name="main" frameborder="0" scrolling=yes style="height:99.9%;visibility:inherit;width:99.95%;z-index:1"></iframe>
  </div>
</div>
<!--下拉目录 开始-->
<div id="footer">
  <div id="innerFooter"></div>
</div>
<iframe name="notice" frameborder="0" style="height:0;width:0;"></iframe>
<iframe name="line" frameborder="0" src="lines.php" style="height:0;width:0;"></iframe>
<div id="menu" style="display:none"></div>
<div id="showmenu" style="display:none"></div>
<script language="JavaScript" type="text/javascript">
var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
var is_gecko= (navigator.product == "Gecko");
var guides={
//--常用管理--------------------------------------------------------------------------------------------------------------
   'Common' : {
		'Common_' : {	
		    'Common_1' : ['站点设置','setinfo.php?name=<?php echo rawurlencode('站点设置');?>',''],	
			//'Common_2' : ['生成缓存','../php2html.php?name=<?php echo rawurlencode('生成缓存');?>&ptype=5',''],
			'Common_0' : ['其他','tablelist.php','']}},			
//--基本设置--------------------------------------------------------------------------------------------------------------			
   'Options' : {
		'Options1_' : {	
		    'Options_1' : ['站点设置','setinfo.php?name=<?php echo rawurlencode('站点设置');?>',''],	
			'Options_2' : ['信息分类','type.php?name=<?php echo rawurlencode('信息分类');?>&ptype=1',''],
			'Options_3' : ['日志分类','fclass.php?name=<?php echo rawurlencode('日志分类');?>&ptype=2','_blank'],
			'Options_4' : ['相册分类','fclass.php?name=<?php echo rawurlencode('相册分类');?>&ptype=3','_parent'],
			'Options_5' : ['音乐分类','fclass.php?name=<?php echo rawurlencode('音乐分类');?>&ptype=4',''],
			'Options_6' : ['视频分类','fclass.php?name=<?php echo rawurlencode('视频分类');?>&ptype=5',''],
			'Options_7' : ['买卖分类','fclass.php?name=<?php echo rawurlencode('买卖分类');?>&ptype=6',''],
			'Options_8' : ['喜好分类','fclass.php?name=<?php echo rawurlencode('喜好分类');?>&ptype=7',''],
			'Options_9' : ['纠结分类','fclass.php?name=<?php echo rawurlencode('纠结分类');?>&ptype=8',''],
			'Options_10' : ['活动分类','fclass.php?name=<?php echo rawurlencode('活动分类');?>&ptype=9',''],
			'Options_13' : ['游戏活动分类','fclass.php?name=<?php echo rawurlencode('游戏活动分类');?>&ptype=12',''],
			'Options_11' : ['招聘分类','fclass.php?name=<?php echo rawurlencode('招聘分类');?>&ptype=10',''],
			'Options_12' : ['圈子分类','fclass.php?name=<?php echo rawurlencode('圈子分类');?>&ptype=11',''],
			'Options_13' : ['问题类型','fclass.php?name=<?php echo rawurlencode('问题类型');?>&ptype=15',''],
			'Options_0' : ['其他','template.php?name=<?php echo rawurlencode('其他');?>','']}},
//--用户管理--------------------------------------------------------------------------------------------------------------
   'UserMan' : {
		'UserMan_' : {	 
		    'UserMan_1' : ['用户管理','userman_li.php?name=<?php echo rawurlencode('用户管理');?>',''],			
			//'UserMan_2' : ['用户日志','siteset/manadmin_user.php?name=<?php echo rawurlencode('用户登陆日志');?>',''],
			'UserMan_3' : ['管理日志','userman_a_li.php?name=<?php echo rawurlencode('管理员日志');?>',''],
			//'UserMan_4' : ['在线用户','userman_u_live.php?name=<?php echo rawurlencode('在线用户');?>',''],
			'UserMan_0' : ['其他','template.php?name=<?php echo rawurlencode('其他');?>','']}}
}
var titles={
	'Common_' : '常用管理',	
	'Options1_' : '基本设置',
	'UserMan_' : '用户管理',
	
	'plgl_' : '评论管理'
	}
	
//注意：下边参数必须是成套出现
//var cate   = 'glmk'; //默认显示主导航
//var action = 'glmk_1'; //默认显示方位
//var type   = 'glmk_1_1';//下级别导航明确 
var cate   = 'Common';
var action = '';
var type   = '';
function showtitle(){
	var obj = document.getElementById('guide');
	var guide = guides[cate];
	var html = '<span class="fr s1" style="margin:0 16px"><div id="Clock" align="center" style="font-size: 12px; color:#000000;width:300px;height:10px;float: left;"></div> | 用户: <?php echo $uid?> | <a class="s0" href="javascript:location.reload();" >刷新</a> <a class="s0" href="javascript:history.back();" >上一步</a> <a class="s0" href="javascript:history.forward();">下一步</a> <a class="s0" href="####" onclick="firm()">退出</a></span>';
	if(action && type){
		html += '<h1><span class="fr1">' + titles[action] + ' &raquo; ' + guide[action][type][0] + '</span></h1>';
	} else {
		html += '<h1><span class="fr1">数据统计</span></h1>';
	}
	obj.innerHTML = html;
}
//initguide(cate,type,'allocation.php');//默认显示页
initguide('Common','Common_1');//默认显示项目


function uptopguide(id){
	var obj = document.getElementById('topguide-entry');
	var objs=obj.getElementsByTagName('li');
	for(var i=0;i<objs.length;i++){
		objs[i].className = objs[i].id==id ? 'li1' : '';
	}
}
function showguide(id){

	var obj = document.getElementById('showmenu');

	var guide = guides[id];
	var html  = '<dl>';

	for(i in guide){
		var subs = guide[i];
		html += '<dd class=rl>';
		for(j in subs){
			var sub = subs[j];
				if(sub[2] == ''){
				html += '<a href="javascript:" onclick="return initguide(\''+id+'\',\''+j+'\')"><span class=ah>'+sub[0]+'</span></a>';
				} else {
					if(sub[2] == 'm'){
						html += '<a href="javascript:" onclick="return initguide2(\''+id+'\',\''+j+'\')"><span class=ah>'+sub[0]+'</span></a>';
					} else {
						html += '<a href='+sub[1]+' target='+sub[2]+'>'+sub[0]+'</a>';
					}				
				}
			
		}
		html += '</dd>';
	}
	obj.innerHTML = html + '</dl>';
	
	var obj1  = document.getElementById(id);
	var left  = findPosX(obj1) + ietruebody().scrollLeft;
	var top   = findPosY(obj1) + ietruebody().scrollTop + 24;

	obj.style.display = "";
	obj.style.top	= top + 'px';
	obj.style.left	= left + 'px';
	
	addEvent(document,"mouseout",doc_mouseout);
}
function closeguide(){
	var obj = document.getElementById('showmenu');
	obj.style.display = "none";
	uptopguide(cate);
	removeEvent(document,"mouseout",doc_mouseout);
}
function upleft(t){
	var obj  = document.getElementById('left');
	var objs = obj.getElementsByTagName('a');
	for(var i=0;i<objs.length;i++){
		objs[i].className = objs[i].id==t ? 'a1' : '';
	}
}
function showleft(id,t,url){
	cate = id;
	var obj = document.getElementById('left');
	var html = '<dl>';
	var guide = guides[id];	
	url = typeof url != 'undefined' ? url : '';
	type = typeof t != 'undefined' ? t : '';
	for(i in guide){
		var subs = guide[i];
		html += '<dt>' + titles[i] + '</dt><dd>';
		for(j in subs){
			var sub = subs[j];
			
			if(sub[2] == ''){
				html += '<a id="'+j+'" href="javascript:" onclick="return initguide(\''+id +'\',\''+j+'\')">'+sub[0]+'</a>';
				} else {
					if(sub[2] == 'm'){
						html += '<a id="'+j+'" href="javascript:" onclick="return initguide2(\''+id +'\',\''+j+'\')">'+sub[0]+'</a>';
					
					} else {
						html += '<a id="'+j+'" href='+sub[1]+' target='+sub[2]+'>'+sub[0]+'</a>';
					}				
				}
			if(url == ''){
				if(type == ''){
					url = sub[1];
					type = j;
				} else if(j == type){
					url = sub[1];
				}
				action = i;
			}
		}
		html += '</dd>';
	}
	obj.innerHTML = html + '</dl>';
	uptopguide(cate);
	upleft(type);
	parent.main.location = url;
	return false;
}
function showleft2(id,t,url){
	cate = id;
	var obj = document.getElementById('left');
	//var html = '<dl>';
	var guide = guides[id];	
	url = typeof url != 'undefined' ? url : '';
	type = typeof t != 'undefined' ? t : '';
	for(i in guide){
		var subs = guide[i];
		//html += '<dt>' + titles[i] + '</dt><dd>';
		for(j in subs){
			var sub = subs[j];
			//html += '<a id="'+j+'" href="javascript:" onclick="return initguide(\''+id +'\',\''+j+'\')">'+sub[0]+'</a>';
			if(url == ''){
				if(type == ''){
					url = sub[1];
					type = j;
				} else if(j == type){
					url = sub[1];
				}
				action = i;
			}
		}
		//html += '</dd>';
	}
		//html += '<dt>'+type+'</dt><dd>';
		
		//html += '<iframe name="player" src="'+type+'_tree.htm" frameborder="0"  style="height:96%;width:132;z-index:1"></iframe>';
		//html += '</dd></dl>';
	obj.innerHTML = '<iframe name="tree" src="'+type+'_tree.htm" frameborder="0"  style="height:99.9%;width:134;z-index:1"></iframe>';
	uptopguide(cate);
	upleft(type);
	parent.main.location = url;
	return false;
}
function initguide(id,t,url){
	showleft(id,t,url);
	showtitle();
	return false;
}
function initguide2(id,t,url){
	showleft2(id,t,url);
	showtitle();
	return false;
}
function showmenu(){
	var obj = document.getElementById('menu');
	//top.main.showselect('hidden');
	if(!IsElement('menubg')){
		var html = '<div id="menu2" class="inner">';
		for(i in guides){
			if(i=='common') continue;
			var guide = guides[i];
			html += "<dl>";
			for(j in guide){
				html += "<dt><h3>" + titles[j] + "</h3></dt><dd>";
				var subs = guide[j];
				for(k in subs){
					var sub = subs[k];
					if(sub[2] == ''){
					html += '<a href="javascript:" onclick="return toguide(\''+i+'\',\''+k+'\')">'+sub[0]+'</a>';
					} else {
					if(sub[2] == 'm'){
					html += '<a href="javascript:" onclick="return toguide2(\''+i+'\',\''+k+'\')">'+sub[0]+'</a>';
					} else {
					html += '<a href='+sub[1]+' target='+sub[2]+'>'+sub[0]+'</a>';
					}
					}
				}
				html += "</dd>";
			}
			html += '</dl>';
		}
		html += '<div><a class="fr" style="color:#ff8800; position:absolute;right:1%;top:1%; cursor:pointer;" onclick="closemenu();">关闭</a></div></div>';
		obj.innerHTML = html;
		var obj2 = document.createElement("div");
		obj2.id = "menubg";
		obj.parentNode.insertBefore(obj2,obj);
	} else {
		var obj2 = document.getElementById('menubg');
		obj2.style.display = "";
	}
	obj.style.display = "";
	addEvent(document,"mousedown",doc_mousedown);
}
function closemenu(){
	var obj = document.getElementById('menu');
	obj.style.display = "none";
	var obj2 = document.getElementById('menubg');
	obj2.style.display = "none";
	removeEvent(document,"mousedown",doc_mousedown);
	//top.main.showselect('');
}
function toguide(id,t){
	closemenu();
	initguide(id,t);
	return false;
}
function toguide2(id,t){
	closemenu();
	initguide2(id,t);
	return false;
}
function doc_mousedown(e){
	var e = is_ie ? event: e;
	obj	= document.getElementById("menu");
	_x	= is_ie ? e.x : e.pageX;
	_y	= is_ie ? e.y + ietruebody().scrollTop : e.pageY;
	_x1 = obj.offsetLeft;
	_x2 = obj.offsetLeft + obj.offsetWidth;
	_y1 = obj.offsetTop - 20;
	_y2 = obj.offsetTop + obj.offsetHeight;

	if(_x<_x1 || _x>_x2 || _y<_y1 || _y>_y2){
	   closemenu();
	}
}
function doc_mouseout(e){
	var e = is_ie ? event: e;
	obj	= document.getElementById("showmenu");
	_x	= is_ie ? e.x : e.pageX;
	_y	= is_ie ? e.y + ietruebody().scrollTop : e.pageY;
	_x1 = obj.offsetLeft + 2;
	_x2 = obj.offsetLeft + obj.offsetWidth;
	_y1 = obj.offsetTop - 20;
	_y2 = obj.offsetTop + obj.offsetHeight;

	if(_x<_x1 || _x>_x2 || _y<_y1 || _y>_y2){
		closeguide();
	}
}
function IsElement(id){
	return document.getElementById(id)!=null ? true : false;
}
function addEvent(el,evname,func){
	if(is_ie){
		el.attachEvent("on" + evname,func);
	} else{
		el.addEventListener(evname,func,true);
	}
};
function removeEvent(el,evname,func){
	if(is_ie){
		el.detachEvent("on" + evname,func);
	} else{
		el.removeEventListener(evname,func,true);
	}
};
function findPosX(obj){
	var curleft = 0;
	if (obj.offsetParent){
		while (obj.offsetParent){
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft - ietruebody().scrollLeft;
}
function findPosY(obj){
	var curtop = 0;
	if (obj.offsetParent){
		while (obj.offsetParent){
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	} else if (obj.y){
		curtop += obj.y;
	}
	return curtop - ietruebody().scrollTop;;
}
function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}

</script>
</body>
</html>
<!---->