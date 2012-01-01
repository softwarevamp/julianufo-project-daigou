<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>[<?php echo $cfg_site_name;?>] - 全球最大的华人代购网站</title>
<meta name="keywords" content="代购,中国代购,华人代购,淘宝代购,留学生代购,国内代购,团购,拼单购" />
<meta name="description" content="" />
</head>

<body>
<?php include template('header'); ?>
<div class="w960 banner">
<div class="w200 left notice">
<div class="title"><a href="<?php echo url("news.php"); ?>">网站最新公告</a></div>
<ul class="left">
<?php if(is_array($newsarray)) foreach($newsarray AS $r) { ?>
<li><a href="<?php echo url("news.php?action=view&nid=$r[nid]"); ?>" target="_blank" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></a></li>
<?php } ?>
</ul>
</div>
<div class="w750 right slide">

<div id="SlidePlayer">
<ul id="Slides" class="Slides" style="height: 825px; position: absolute; top: -275px;">			
<?php if(is_array($topcarray)) foreach($topcarray AS $r) { ?>
<li><a title="<?php echo $r['title'];?>" href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>" target="_blank"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>"></a></li>
<?php } ?>			
</ul>
<ul class="SlideTriggers"><li class="">1</li><li class="Current">2</li><li class="">3</li></ul>			
</div>

</div>
<div class="clear"></div>
</div>
<div class="w960">
<div class="box_1 left">
<div class="title"><span class="more"><a href="<?php echo url("see.php"); ?>">更多...</a></span><h2>大家在买什么？</h2></div>
<div class="content">
<div id="Slider">
<div class="seeLoading">
<img src="<?php echo TPL;?>images/loading.gif" alt="数据加载中..." />
<p>数据加载中...</p>
</div>			
<ul>
</ul>
</div>
</div>
</div>
<div class="box_2 left">
<div class="title"><span class="more"><a href="<?php echo url("special.php"); ?>">更多...</a></span><h2>精品活动</h2></div>
<div class="content">
<?php if(is_array($specialarray1)) foreach($specialarray1 AS $r) { ?>
<div class="acttop top5 left">
<a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>"><img src="<?php echo $r['pic'];?>" alt="<?php echo $r['title'];?>" /></a>
</div>
<?php } ?>
<ul class="actlist left">
<?php if(is_array($specialarray2)) foreach($specialarray2 AS $r) { ?>			
<li><span class="actname"><a href="<?php echo url("special.php?action=view&sid=$r[sid]"); ?>"><?php echo $r['title'];?></a></span><span class="addtime"><?php echo date("Y-m-d",$r['addtime']);?></span></li>			
<?php } ?>
</ul>
</div>
</div>
<div class="box_3 left">
<div class="title"><span class="more"><a href="<?php echo url("help.php"); ?>">更多...</a></span><h2>常见问题</h2></div>
<div class="content">
<ul class="newslist">
<?php if(is_array($articlearray)) foreach($articlearray AS $r) { ?>
<li><a href="<?php echo url("help.php?action=view&id=$r[aid]"); ?>" target="_blank" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></a></li>
<?php } ?>
</ul>
</div>
</div>
<div class="clear"></div>
</div>
<div class="w960 top5">
<div class="recommendpro left">
<div class="proList"><a href="<?php echo url("recommend.php?action=list&tid=1"); ?>">服装</a> | <a href="<?php echo url("recommend.php?action=list&tid=2"); ?>">鞋包</a> | <a
                                    href="<?php echo url("recommend.php?action=list&tid=3"); ?>">美容</a> | <a href="<?php echo url("recommend.php?action=list&tid=4"); ?>">居家</a> | <a
                                        href="<?php echo url("recommend.php?action=list&tid=5"); ?>">配饰</a> | <a href="<?php echo url("recommend.php?action=list&tid=6"); ?>">食品</a></div>
<div class="tt"><a href="<?php echo url("recommend.php"); ?>">小编推荐</a></div>
<div class="content">
<?php if(is_array($cptjarray)) foreach($cptjarray AS $r) { ?>
<div class="goodsitem">
<div class="goodspic"><a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>"><img alt="<?php echo $r['goodsname'];?>" src="<?php echo $r['goodsimg'];?>"></a></div>
<p class="buynum">已购买<?php echo $r['buynum'];?>件</p>
<p class="goodsname top5"><a href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>" target="_blank" title="<?php echo $r['goodsname'];?>"><?php echo $r['goodsname'];?></a></p>
<p class="goodsprice">￥<?php echo $r['goodsprice'];?></p>
</div>
<?php } ?>
</div>
</div>
<div class="box_3 left">
<div class="title"><span class="more"><a href="<?php echo url("talkover.php"); ?>" target="_blank">更多...</a></span><h2>用户讨论区</h2></div>
<div class="content">
<ul class="bbs_info">
<?php if(is_array($dataarray)) foreach($dataarray AS $r) { ?>	
<li>
<div class="gst_img"><img src="<?php echo $r['face'];?>" onerror="this.src='<?php echo TPL;?>images/untitled.jpg'" alt="" /></div>
<a href="<?php echo url("talkover.php"); ?>" target="_blank"><?php echo substrs($r['msg'],24,0,1);?></a>
<div class="gst_uname"><?php echo $r['uname'];?></div>
</li>
<?php } ?>	
</ul>
</div>
</div>
<div class="box_3 left top5">
<div class="title"><span class="more"><a href="<?php echo url("about.php?action=contactus"); ?>">更多...</a></span><h2>联系我们</h2></div>
<div class="content">
<span class="contact_tel">电话：<?php echo $cfg_index_tel;?></span>
<span class="contact_email">邮箱：<?php echo $cfg_index_msnlink;?></span>
<span class="contact_msn">MSN：<?php echo $cfg_index_msnlink;?></span>
<span class="contact_qq">QQ：<?php echo $cfg_index_qqlink;?></span>
</div>
</div>
<div class="clear"></div>
</div>
<div class="w960 top10 link">
<div class="title left"><img src="<?php echo TPL;?>images/flink_title.gif" alt="" /></div>
<div class="content left">
<ul>
<li><a href="#"><img src="<?php echo TPL;?>images/flink_1.gif" alt="" /></a></li>
<li><a href="#"><img src="<?php echo TPL;?>images/flink_2.gif" alt="" /></a></li>
<li><a href="#"><img src="<?php echo TPL;?>images/flink_3.gif" alt="" /></a></li>
<li><a href="#"><img src="<?php echo TPL;?>images/flink_4.gif" alt="" /></a></li>
<li><a href="#"><img src="<?php echo TPL;?>images/flink_5.gif" alt="" /></a></li>
<li><a href="#"><img src="<?php echo TPL;?>images/flink_6.gif" alt="" /></a></li>
</ul>
</div>
</div>
<?php include template('footer'); ?>
<script type="text/javascript" src="<?php echo TPL;?>js/indexSlide.js"></script>
<script type="text/javascript">
    $(function() {
        var e = function(n, b) {
            if (n.length > b) {
                return n.substring(0, b - 2) + "...";
            }
            return n;
        };		

        $.getJSON("/ajax/index_ajax.php?action=maqueeproduct&r=" + Math.random(),
        function(n) {
            var b = $("<ul></ul>");
            $("#Slider").empty().append(b);
            $.each(n,
            function(o, p) {
                b.append('<li><div class="detailed"><div class="pic"><a href="<?php echo url("see.php?type="); ?>' + p.c + "#" + p.id + '"><img width=80 height=80 alt="' + p.n + '" src="' + p.p + '" /></a></div><div class="info"><h2><a href="<?php echo url("see.php?type="); ?>' + p.c + "#" + p.id + '">' + e(p.n, 40) + "</a></h2><dl><dd><b>￥" + p.m + "</b><span>" + p.d + '</span></dd><dd class="i_bj">代购信息：' + p.un + "购买于" + p.s + '</dd></dl></div></div><div class="concise"><p><a href="<?php echo url("see.php?type="); ?>' + p.c + "#" + p.id + '">' + e(p.n, 25) + "</a></p><span>" + p.d + "</span></div></li>");
            }); (function(v, x) {
                var w = true;
                var u = b;
                var o = 0;
                var p;
                var t = 1;
                var y = u.find(".concise:eq(0)").outerHeight();
                u.scrollTop(0);
                u.children().each(function() {
                    o += $(this).outerHeight();
                });
                u.append(u.html());
                var q = u.find("li:eq(1)");
                $(q).find(".detailed").show();
                $(q).find(".concise").hide();
                var z = function() {
                    var s = u.scrollTop();
                    if (s >= o) {
                        q = u.find("li:eq(0)");
                        u.find(".detailed").hide();
                        $(q).find(".detailed").show();
                        $(q).find(".concise").hide();
                    }
                    u.scrollTop((s >= o ? 0 : s) + t);
                    if (u.scrollTop() % y == 0) {
                        r();
                    }
                };
                function r() {
                    t = 0;
                    if (w) {
                        setTimeout(function() {
                            $(q).find(".concise").show();
                            q = $(q).next("li:first");
                            if (!q) {
                                q = u.find("li:first");
                            }
                            u.find(".detailed").hide();
                            $(q).find(".detailed").show();
                            $(q).find(".concise").hide();
                            w = true;
                            t = 1;
                        },
                        x);
                    }
                    w = false;
                }
                u.find("li").mouseover(function() {
                    u.find(".detailed").hide();
                    $(this).find(".detailed").show();
                    $(this).find(".concise").hide();
                    clearInterval(p);
                });
                u.find("li").mouseout(function() {
                    u.find(".detailed").hide();
                    $(this).find(".concise").show();
                    $(q).find(".detailed").show();
                    $(q).find(".concise").hide();
                    p = setInterval(z, v);
                });
                p = setInterval(z, v);
            })(30, 3000);
        });
    });
</script>
</body>
</html>
