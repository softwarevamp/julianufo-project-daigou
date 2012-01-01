var prodata = {};
function step1() { gsItemInit(); $("#fillshopingStep2").hide(); $("#fillshopingStep3").hide(); $("#fillshopingStep1").show(); document.getElementById("myPanli_itemUrl").focus(); }
function step2() { $("#fillshopingStep1").hide(); $("#fillshopingStep3").hide(); $("#fillshopingStep2").show(); }
function step3() { buileS3(); $("#fillshopingStep1").hide(); $("#fillshopingStep2").hide(); $("#fillshopingStep3").show(); }
function buileS3() {
    $("#sp_proTNum").text("0"); $("#sp_proSum").text("0");
    $.ajax({
        type: "POST",
        url: "/ajax/fast_ajax.php?action=state",
        dataType: "text",
        contentType: "application/json;utf-8",
        data: "{}",
        timeout: 20000,
        error: function(a, b, c) { },
        success: function(data) {
            var v = data.split("#"); $("#sp_proTNum").text(v[1].toString()); $("#sp_proSum").text(v[2].toString());
        }
    });
    $("#sp_proPic").attr("src", prodata.Picture); 
	$("#sp_proName").text($("#gsItemName").val()); 
	$("#sp_proPrice").text("￥" + $("#gsItemPrice").val()); 
	$("#sp_proFright").text($("#gsItemFreight").val());
	$("#sp_proNum").text($("#gsItemNum").val());
}

function gsItemInit() {
    $("#myPanli_itemUrl").removeAttr("disabled").val(""); $("#toGetProBtn").removeAttr("disabled").attr("class", "tijiao");
    $('#itemUrlTip').attr("class", "dhk").html("<p>请将您想代购商品的<span>详细页网址</span>粘贴到输入框中提交！</p>");
    $("#gsItemRemark").attr("class", "still").removeAttr("disabled").val("");
    $("#gsItemNum").val("1");
    $("#gsItemName").removeAttr("disabled").val("").attr("class", "text_k");
    $("#gsItemPrice").removeAttr("disabled").val("").attr("class", "text");
    $("#favoriteInfo").hide();
    $("#FillvipPriceS").remove();
    document.getElementById("gsItemRemarkCheck").checked = false;
}

function checkAll() {
    if ($("#gsItemUrl").val().length > 0 && $("#gsItemName").attr("class") != "text_k red" && $("#gsItemFreight").val().length > 0 && $("#gsItemPrice").attr("class") != "text red") {
        if (($("#gsItemRemark").val().length > 0 && $("#gsItemRemark").attr("class") != "red") || document.getElementById("gsItemRemarkCheck").checked)
            return true;
        else
        { $("#gsItemRemark").attr("class", "red").val("请填写备注"); return false; }
    }
    else
        return false;
}

function remarkChangeCheck() {
    if (document.getElementById("gsItemRemarkCheck").checked) $("#gsItemRemark").attr("disabled", "disabled").attr("class", "hui").val("我对此商品无任何特殊备注。");
    else $("#gsItemRemark").removeAttr("disabled").attr("class", "still").val("");
}

function noPrice(price) {
    if (price >= 0) { $("#gsItemPrice").attr("class", "text").val(price).unbind("blur").blur(function() { var p = $(this).val(); try { if (p.length <= 0 || parseFloat(p) < price) $(this).val(price.toString()); } catch (e) { $(this).val(price.toString()); } }); }
    else { $("#gsItemPrice").attr("class", "text red").val("请填写商品价格"); }
}

function checkInput(dom, str) { if ($.trim($(dom).val()).length <= 0) $(dom).attr("class", "text red").val(str); }

function checkItemName(dom) {
    if ($.trim($(dom).val()).length <= 0) $(dom).attr("class", "text_k red").val("请填写商品名称");

}

var GetSuccess = function(data) {
    prodata = data.d;
    if (prodata.Error == "BlockedShop") { gsItemInit(); $("#myPanli_itemUrl").val(prodata.Href); $('#itemUrlTip').attr("class", "wrong").html("<p style=\"width:405px;\">该商品的卖家为嫌疑商家，请不要代购此商品！<a href=\"/Help/Detail.aspx?hid=98\" target=\"_blank\">什么是嫌疑商家？</a></p>"); return; }
	if (prodata.Href != "" && prodata.Href != null) $("#gsItemUrl").val(prodata.Href);
	
	else if(prodata.Href == null) $("#gsItemUrl").val($("#myPanli_itemUrl").val());
    else $("#gsItemUrl").val($("#myPanli_itemUrl").val());

    if (prodata.Name != "" && prodata.Name != null) {
		$("#gsItemName").attr("class", "text_k hui").attr("disabled", "disabled").val(prodata.Name);
	}
	else if(prodata.Name == null){ $("#gsItemName").attr("class", "text_k red").val("请填写商品名称");
		document.getElementById("gsItemName").disabled=false;
	}
    else {$("#gsItemName").attr("class", "text_k red").attr("disabled", "false").val("请填写商品名称");
		document.getElementById("gsItemName").disabled=false;
	}
    $("#gsItemImg").attr("src", prodata.Picture).attr("alt", prodata.Name);
	if (prodata.Price > 0) $("#gsItemPrice").attr("disabled", "disabled").attr("class", "text hui").val(prodata.Price); else noPrice(-1); 
	
    if (prodata.Freight >= 0) $("#gsItemFreight").attr("disabled", "disabled").attr("class", "text hui").val(prodata.Freight); 
	if(prodata.Freight == null) $("#gsItemFreight").removeAttr("disabled").attr("class", "text wen red").val("10");
	else $("#gsItemFreight").removeAttr("disabled").attr("class", "text wen red").val("10");
    step2();
}

var GetFail = function() {
    prodata = {
        Href: "",
        Name: "",
        ShopName: "",
        ShopHref: "",
        Picture: "",
        Thumbnail: "",
        Category: "",
        SubCategory: "",
        Shop: { Name: "", Href: "" },
        Price: 0,
        VIPPrice1: -1,
        VIPPrice2: -1,
        VIPPrice3: -1,
        IsAuction: false
    };
    $("#gsItemName").attr("class", "text_k red").val("请填写商品名称");
    $("#gsItemPrice").attr("class", "text red").val("请填写商品价格");
    $("#gsItemFreight").removeAttr("disabled").attr("class", "text wen red").val("10");
    $("#gsItemUrl").val(/^http(s)?:\/\//g.test($("#myPanli_itemUrl").val()) ? $("#myPanli_itemUrl").val() : "http://" + $("#myPanli_itemUrl").val());
    step2();
}

function step1Lock() {
    $("#myPanli_itemUrl").attr("disabled", "disabled");
    $("#toGetProBtn").attr("disabled", "disabled");
}
function toGetPro() {
    var url = $("#myPanli_itemUrl").val();
    if (url.length <= 0) { $('#itemUrlTip').attr("class", "wrong").html("<p>请输入您想代购商品的详细页网址！</p>"); return; }
    if (url.indexOf("http://") <= -1 && url.indexOf("https://") <= -1) url = "http://" + url;
    if (new RegExp("http(s)?://([\\w-]+\\.)+[\\w-]+(/[\\w- ./?%&=]*)?").test(url)) {
        step1Lock();
        $('#itemUrlTip').attr("class", "loading").html('<img src="/add/newimages/loading.gif" alt="加载中" /><p>正在抓取商品信息...</p>');
        $.ajax({
            type: "POST",
            url: "/ajax/fast_ajax.php?action=get",
            dataType: "json",
            data: "url=" + url,
            timeout: 25000,
            error: GetFail,
            success: GetSuccess
        });
    }
    else { $('#itemUrlTip').attr("class", "wrong").html("<p>输入的网址不正确，请核实后再填写！</p>"); return; }
}

function toShoppingCart() {
    if (!checkAll()) return;
    prodata.Price = prodata.Price < 0 ? $('#gsItemPrice').val() : prodata.Price;
	prodata.chicun=$("#fillchicun").val();//获取尺寸信息
	prodata.yanse=$("#fillyanse").val();//获取颜色信息
	typevalue=$("#BuySelffill").attr("checked");
	prodata.type=1;
	prodata.expressno="";
	if(typevalue==true){
		 if ($.trim($("#expressnofill").val()).length <= 0) {
			$("#expressnofill").focus();
			return;
		 }else{
			prodata.type=2;//获取是否是代发
			prodata.expressno=$.trim($("#expressnofill").val());//获取颜色信
		 }
	}
    $.ajax({
        type: "POST",
        url: "/ajax/fast_ajax.php?action=add",
        dataType: "json",
      //    contentType: "application/json;utf-8",
		data:"adddata={\"name\":'" + HtmlEncode($("#gsItemName").val()) + "',\"href\":'" + $("#gsItemUrl").val() + "',\"picture\":'" + prodata.Picture + "',\"thumbnail\":'" + prodata.Thumbnail + "',\"chicun\":'" + prodata.chicun + "',\"yanse\":'" + prodata.yanse + "',\"shopName\":'" + prodata.Shop.Name + "',\"shopHref\":'" + prodata.Shop.Href + "',\"price\":" + prodata.Price + ",\"vipPrice1\":" + prodata.VIPPrice1 + ",\"vipPrice2\":" + prodata.VIPPrice2 + ",\"vipPrice3\":" + prodata.VIPPrice3 + ",\"buyNum\":" + $("#gsItemNum").val() + ",\"freight\":" + $("#gsItemFreight").val() + ",\"isAuction\":" + prodata.IsAuction + ",\"remark\":'" + $("#gsItemRemark").val()  + "',\"type\":" + prodata.type  + ",\"expressno\":'" + prodata.expressno + "'}",
        timeout: 10000,
        error: function() { alert("网络错误，请稍后再试"); },
        success: function(d) { if (d) step3(); else alert("您提交的商品信息有误。"); }
    });
}

$(document).ready(function() {
    $("#myPanli_itemUrl").keydown(function(e) { if (e.keyCode == 13) { toGetPro(); return false; } });
    document.getElementById("myPanli_itemUrl").focus();
	$("#BuySelffill").click(function() {
		$("#type1fill").toggle();
		$("#type2fill").toggle();
	});
});
//ok