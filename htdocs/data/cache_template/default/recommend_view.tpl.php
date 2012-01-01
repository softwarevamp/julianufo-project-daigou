<?php defined('ZZQSS') or exit('Access Denied'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="JUSTYLE,2010,春夏,伦敦之旅,圆领,图案,印花,绣花工艺,休闲T恤,L,黑色, <?php echo $cfg_site_name;?>" name="keywords">
<link href="<?php echo TPL;?>css/NewTopFoot.css" rel="Stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/AddItemPanel.css">
<script type="text/javascript" src="<?php echo TPL;?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jQuery.Extend.js"></script>
<script src="<?php echo TPL;?>js/jQuery.Drag.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.cookies.2.1.0.min.js"></script>
<script src="<?php echo TPL;?>js/Gobal.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo TPL;?>css/Product.css">
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.json-1.3.min.js"></script>
   
    <script type="text/javascript">
        var flag = false;
        var pid = <?php echo $gid;?>;
var pimg="<?php echo $value['goodsimg'];?>";
        $(document).ready(function() {
            var pname = $.trim($(".you h1").text()).replace("\n","");
            var data = {};
            var newOptions = { domain: '', hoursToLive: 168 };
            try {
                data = $.evalJSON(jaaulde.utils.cookies.get("scan"));
            } catch (eee) {
                data = null;
            }
            if (data != null) {
                data = $.grep(data, function(item, index) { return item["id"] != pid; });
 
                if (data.length >= 10) flag = true;
                $.each(data, function(index, item) {
                    $("#scan").append("<li><a href='recommend.php?action=view&gid=" + item["id"] + "'><img src='" + item["pimg"] + "' alt='" + item["n"] + "'  /></a></li>");
                });
                if (flag) { data = $.grep(data, function(item, index) { return index < 9; }); }
                data = $.merge([{ "id": pid, "pimg": pimg, "n": pname}], data);
                jaaulde.utils.cookies.set("scan", $.toJSON(data), newOptions);
            }
            else {
                jaaulde.utils.cookies.set("scan", '[{"id":' + pid + ',"pimg":"' + pimg +'","n":"' + pname + '"}]', newOptions);
            }
            $(".ph dl").each(function() { $(this).mouseover(function() { $(".ph dl dt").hide(); $(".ph dl dd").show(); $(this).find("dd").hide(); $(this).find("dt").show(); }); });
            $(".ph dl:eq(0)").mouseover();
 
            $("#submitBtn").click(function() {
                $.ajax({
                    type: "POST",
                    url: "/ajax/recommend_ajax.php?action=addbuynum",
                    dataType: "json",
                    contentType: "application/json;utf-8",
                    data: "{'pid':'" + pid + "'}",
                    timeout: 10
                });
            });
        });
    </script>


<title>
<?php echo $value['goodsname'];?> - <?php echo $cfg_site_name;?>
</title></head><body>


<form id="" action="###" method="post" name="">

<?php include template('header'); ?>

    <div class="weizhi">
        <p>
            <b>当前位置：</b><a href="<?php echo url("recommend.php"); ?>">编辑推荐</a><?php echo $position;?><span>&gt;</span><i><?php echo $value['goodsname'];?></i></p>
    </div>
    <div class="list">
        <div class="zuo">
            <div class="ranking">
                <h2>
                    <img alt="推荐" src="<?php echo TPL;?>images/ranking.gif"></h2>

                <div class="ph">
                    
                    <?php if(is_array($leftarray)) foreach($leftarray AS $key => $r) { ?>
                    <dl>
                        <dt <?php if($key==0) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>
                            <div class="img">
                                <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                                <img alt="<?php echo $r['goodsname'];?>" src="<?php echo $r['goodsimg'];?>">
                                </a>
                            </div>
                            <div class="xiangxi">
                                <h1>
                                    <b>
                                        <? echo $key+1; ?>.</b> <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                                            <?php echo substrs($r['goodsname'],45);?></a>
                                </h1>
                                <label>
                                    <?php echo $r['goodsprice'];?></label>
                                <p>
                                    来源网站：<span><?php echo $r['shopname'];?></span></p>
                            </div>
                        </dt>
                        <dd <?php if($key==0) { ?>style="display: none;"<?php } else { ?>style="display: block;"<?php } ?>>
                            <span><? echo $key+1; ?></span>
                            <p>
                                <a target="_blank" href="<?php echo url("recommend.php?action=view&gid=$r[gid]"); ?>">
                                    <?php echo substrs($r['goodsname'],45);?></a>
                            </p>
                        </dd>
                    </dl>
<?php } ?>

                </div>					


            </div>
            <div class="lately">
                <h2>
                    <img alt="您最近浏览过的宝贝" src="<?php echo TPL;?>images/lately.gif"></h2>
                <ul id="scan">
                </ul>
            </div>
        </div>
        <div class="you">
            <h1>
               <?php echo $value['goodsname'];?></h1>
            <div class="product">
                <div class="img">
                    <a href="?pid=8294">
                        <img alt="<?php echo $value['goodsname'];?>" src="<?php echo $value['goodsimg'];?>"></a>
                </div>
                <div class="parameter">
                    <div class="pl">
                      <p>推荐指数：<img alt="<?php echo $value['rindex'];?>" src="<?php echo TPL;?>images/star<?php echo $value['rindex'];?>.gif"></p>
                        <dl>
                            <dt>￥<?php echo $value['goodsprice'];?></dt>
                            
                        </dl>
                    </div>
                    <ul>
                        <li>代购件数：<?php echo $value['buynum'];?>件</li>
                        <li>浏览次数：<?php echo $value['views'];?>次</li>
                        <li>来源商家：<a target="_blank" href="<?php echo $value['sellerurl'];?>"><?php echo $value['goodsseller'];?></a><span><?php echo $value['shopname'];?></span></li>
                    </ul>
                    <div class="shopping">
                        <p>
                           网站所有商品信息来源其他购物网站，由于时效性问题，商品信息可能有出入，以来源网站信息为准！</p>
                        <a style="cursor: pointer;" onClick="FastAddShow('<?php echo $value['goodsurl'];?>')" id="submitBtn"></a>
                    </div>
                </div>
            </div>
            <div class="reason">
                <h2>
                    推荐理由</h2>
                <p>
<?php echo $value['why'];?>
</p>
            </div>
            <div class="lm">
                <h3>
                    商品描述</h3>
            </div>
            <div class="miaoshu">
<?php echo $value['about'];?>
            </div>
        </div>
    </div>

<?php include template('footer'); ?>

    </form>

</body>
</html>