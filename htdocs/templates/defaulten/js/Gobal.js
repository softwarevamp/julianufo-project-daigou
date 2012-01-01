function getViewportHeight() {
    if (window.innerHeight != window.undefined) {
        return window.innerHeight;
    }
    if (document.compatMode == "CSS1Compat") {
        return document.documentElement.clientHeight;
    }
    if (document.body) {
        return document.body.clientHeight;
    }
    return window.undefined;
}
$(function() {
    $("#CrawlUrl").focus(function() {
        $("#CrawlPromt").removeClass("red").addClass("green").text("Purchasing goods can enter the address！");
        if ($("#CrawlUrl").val() == "http://") {
            $("#CrawlUrl").val("");
        }
    }).blur(function() {
        $("#CrawlPromt").removeClass("green");
        if ($.trim($("#CrawlUrl").val()).length <= 0) {
            $("#CrawlUrl").val("http://");
        }
    });
    var e = function() {
        var d = $.trim($("#CrawlUrl").val());
        if (d.length <= 0 || d == "http://") {
            $("#CrawlPromt").removeClass("green").addClass("red").text("Enter a product address！");
            return false;
        }
        var i = new RegExp("http(s)?://([\\w-]+\\.)+[\\w-]+(/[\\w- ./?%&=]*)?");
        if (d.indexOf("http://") < 0 && d.indexOf("https://") < 0) {
            d = "http://" + d;
        }
        if (!i.test(d)) {
            $("#CrawlPromt").removeClass("green").addClass("red").text("Address is not correct, then fill out！");
            return false;
        }
        $("#CrawlUrl").val("");
		FastAddShow(d);
        return false;
    };
    $("#CrawlUrl").keydown(function(d) {
        if (d.keyCode == 13) {
            e();
            return false;
        }
    });
    $("#PanliCrawlBtn").click(e);
    $.getJSON("/App_Scripts/JSData/UserLoginInfo.ashx?u=" + window.location.href + "&r=" + new Date(),
    function(i) {
        $("#Gobal_LoginInfo").html(i.s);
        $("#Gobal_Shoppingcart").html("购物车<span>(" + i.p + ")</span>");
    });
    var b = window.location.href;
    b = b.toLowerCase();
    if (b.indexOf("see") > 0) {
        $("#see").addClass("xt");
    } else {
        if (b.indexOf("demo") > 0) {
            $("#demo").addClass("xt");
        } else {
            if (b.indexOf("shop") > 0) {
                $("#shop").addClass("xt").children("b").remove();
            } else {
                if (b.indexOf("recommend") > 0) {
					$("#recommend").addClass("xt").next("b").remove();
				}
				else {
					if (b.indexOf("guestbook") > 0) {
						$("#guestbook").addClass("xt").next("b").remove();
					}
					else {
						$("#Default").addClass("xt");
					}
				}  
            }
        }
    }
    if (b.indexOf("/special/") > 0) {
        $("#special").addClass("orange");
    } else {
        if (b.indexOf("/discount/") > 0) {
            $("#discount").addClass("orange");
        } else {
            if (b.indexOf("/free_postage/") > 0) {
                $("#free_postage").addClass("orange");
            }
        }
    }
    $("#Panli_Tools,#Panli_ToolsList").hover(function() {
        $("#Panli_ToolsList").show();
    },
    function() {
        $("#Panli_ToolsList").hide();
    });
   // var a = new Date(parseInt($("#Beijing_Time").val()));
    //a.setMinutes(a.getMinutes() + a.getTimezoneOffset());
  //  setInterval(function() {
  //      a.setSeconds(a.getSeconds() + 1);
  //      $("#BeijingDate").html("Time：" + a.getFullYear() + "-" + (a.getMonth() < 9 ? "0": "") + (a.getMonth() + 1) + "-" + (a.getDate() < 9 ? "0": "") + a.getDate());
  //      $("#BeijingTime").html("<span>" + a.getHours() + "</span><b></b><span>" + (a.getMinutes() < 10 ? "0": "") + a.getMinutes() + "</span><b></b><span>" + (a.getSeconds() < 10 ? "0": "") + a.getSeconds() + "</span>");
  //  },
  //  1000);
  
	var a = new Date(parseInt($("#Beijing_Time").val())*1000);
   // a.setMinutes(a.getMinutes() + a.getTimezoneOffset());
    a.setMinutes(a.getMinutes());
    setInterval(function() {
        a.setSeconds(a.getSeconds() + 1);
        $("#BeijingDate").html("北京时间：" + a.getFullYear() + "-" + (a.getMonth() < 9 ? "0": "") + (a.getMonth() + 1) + "-" + (a.getDate() < 9 ? "0": "") + a.getDate());
        $("#BeijingTime").html("<span>" + a.getHours() + "</span><b></b><span>" + (a.getMinutes() < 10 ? "0": "") + a.getMinutes() + "</span><b></b><span>" + (a.getSeconds() < 10 ? "0": "") + a.getSeconds() + "</span>");
    },
    1000);

	if (typeof document.body.style.maxHeight == "undefined") {
		//if ($.browser.msie && $.browser.version == "6.0") {
		$(".addpanel_dialog").css("position", "absolute").css("margin-top", "0px");
		var divY = (getViewportHeight() - $(".addpanel_dialog").outerHeight()) / 2;
		$(".addpanel_dialog").css("top", (divY + document.documentElement.scrollTop).toString());
		$(window).scroll(function() { $(".addpanel_dialog").css("top", divY + document.documentElement.scrollTop + ""); });
	}	

	
});

function getViewportHeight() { if (window.innerHeight != window.undefined) { return window.innerHeight } if (document.compatMode == "CSS1Compat") { return document.documentElement.clientHeight } if (document.body) { return document.body.clientHeight } return window.undefined }
function InitP2() {
    $("#proAlert").attr("class", "").text("恭喜您！商品信息抓取成功，您可以修改购买数量和填写商品备注！");
    $("#productUrl").val("");
    $("#productName").val("").attr("class", "addpanel_k").removeAttr("disabled").unbind("focus").unbind("blur");
    $("#productPrice").val("").attr("class", "").removeAttr("disabled").unbind("focus").unbind("blur");
    $("#productSendPrice").val("").attr("class", "").unbind("focus");
    $("#productNum").val("1");
    $("#productImg").hide();
    $("#isAuction").hide();
    $("#productImg img").attr("src", "");
    $("#productRemark").attr("class", "addpanel_still").text("请选填颜色、尺寸等要求！");
    $("#successBtn").attr("disabled", "disabled").attr("class", "addpanel_next_no");
    $("#vipPriceS").remove();
}

function p3Init() {
    $("#p3_img").attr("src", "/add/newimages/noimg80.gif");
}
//执行抓取操作
function FastAdd_Submit(){
	$("#addpanel_submit").click(); 
}
function FastAddShow(url) {
	$(".addpanel_overlay").height($(document).height()).show();
    $(".addpanel_dialog").show();
    if ($("#p1 div").length == 0)
        $("#p1").load("/add/AddItemPanel/AddItemPanel1.htm", function() { $("#p0").remove(); $("#p1").show(); 
			if(url==null){
				$("#itemUrl").focus();
			}else{
				$("#itemUrl").val(url).focus();
				setTimeout("FastAdd_Submit()",500);
				return false;
			}
		});
    else {
		if(url==null){
			$("#itemUrl").focus();
		}else{
			$("#itemUrl").val(url).focus();
			setTimeout("FastAdd_Submit()",500);
			return false;
		}
	}
	
    if ($("#p2 div").length == 0)
       $("#p2").load("/add/AddItemPanel/AddItemPanel2.htm", function() { $("#p2").hide(); });
    if ($("#p3 div").length == 0)
       $("#p3").load("/add/AddItemPanel/AddItemPanel3.htm", function() { $("#p3").hide(); });
}

function AddItemClose() {
    $(".addpanel_dialog").hide();
    $(".addpanel_overlay").hide();
    if ($("#p2 div").length >= 1) {
        $("#p2").hide();
        InitP2();
    }
    if ($("#p3 div").length >= 1) {
        $("#p3").hide();
        p3Init();
    }
    $(".addpanel_address_").attr("class", "addpanel_address");
    $("#itemUrl").removeAttr("disabled").val("");

    $("#promptInfo").attr("class", "addpanel_dhk").find("img").remove();
    $("#promptInfo p").text("请将您想代购商品的详细页网址粘贴到输入框中提交!");
    $("#addpanel_submit").removeAttr("disabled").attr("class", "addpanel_tijiao");

    $("#p1").show();
}

$("#closeBtn").click(AddItemClose);
var browser = navigator.appName;
var b_version = navigator.appVersion;
var version = parseFloat(b_version);
navigator.compitable

