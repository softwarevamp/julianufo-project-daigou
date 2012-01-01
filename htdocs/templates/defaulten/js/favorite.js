$(document).ready(function() {
    $("#favoriteList tr:even").addClass("hui");
})
var fId = "";
var closeBtn = 0;
//取消收藏
function deleteFavorite(id) {
    if (confirm("您确定要删除收藏吗？")) {
        $.ajax({
            type: "POST",
            url: "m.php?name=favorite&action=del",
            dataType: "json",
            contentType: "application/json;utf-8",
            data: "{'favoriteId':" + id + "}",
            timeout: 10000,
            error: function() { alert("网络错误，请稍后再试！"); },
            success: function(res) { if (res == "OK") {  $("#tr_favor_" + id).remove(); if ($(".biao table tr").length <2) { window.location = ToPrevPage(); } } else { alert("删除失败了！"); } }
        });
    }
}
//取消选中收藏
function deleteSelectFavorite() {
    var id = "";
    $("input[name=cbSel]").each(function() { if ($(this).attr("checked")) { id += $(this).val() + "," } });
    if (id.length < 1) {
        alert("请选择您要删除的商品！");
        return;
    }
    if (confirm("您确定要删除这些商品吗？")) {
        $.ajax({
            type: "POST",
            url: "m.php?name=favorite&step=del",
            dataType: "json",
            contentType: "application/json;utf-8",
            data: "{'favoriteId':'" + id + "'}",
            timeout: 10000,
            error: function() { alert("网络错误，请稍后再试！");},
            success: function(res) { if (res == "OK") {  var ids = id.split(","); for (i = 0; i < ids.length - 1; i++) $("#tr_favor_" + ids[i]).remove();if ($(".biao table tr").length <2) { window.location = ToPrevPage(); } } else { alert("删除失败了！"); } }
        });
    }
}
//全选
function CheckAll(isChecked) {
    $("input[name=cbSel]").each(function() { $(this).attr("checked", isChecked) });
}

function FCheck() {
    $("input[name=cbSel]").each(function() { this.checked = !this.checked; });
}
function TxtFocus() {
    if ($.browser.msie) {
        var e = event.srcElement;
        var r = e.createTextRange();
        r.moveStart('character', e.value.length);
        r.collapse(true);
        r.select();
    }
}

function getTotalHeight() {

    if ($.browser.msie) {
        return document.compatMode == "CSS1Compat" ? document.documentElement.clientHeight :
                          document.body.clientHeight;
    } else {
        return self.innerHeight;
    }
}

function ReplaceBlank(tagname) {
    return tagname.replace();
}


//阻止添加商品层添加事件
function UnmouseUp(e) {
    if (e && e.stopPropagation != undefined) { e.stopPropagation(); }
    else { window.event.cancelBubble = true; }
}

//显示删除按钮，阻止删除       
function ShowClose() {
    clearTimeout(closeBtn);
}

//显示删除标签按钮
function ShowDelTag(tag, id) {
    $(tag).after("<a href=\"javascript:;\" onmouseout=\"$(this).remove()\" onclick=\"RemoveFavoriteTag('" + ReplaceD($(tag).attr("title")) + "'," + id + ")\" class=\"close\" onmouseover=\"ShowClose()\" title=\"删除标签\"></a>");
}

//隐藏删除标签按钮
function HideDelTag(tag) {
    closeBtn = setTimeout(function() {
        $(tag).next().remove();
    }, 500);
}
//去除重复的项
Array.prototype.unique = function() {
    var a = {}; for (var i = 0; i < this.length; i++) {
        if (typeof a[this[i]] == "undefined")
            a[this[i]] = 1;
    }
    this.length = 0;
    for (var i in a)
        this[this.length] = i;
    return this;
}

//阴影层效果
$(function() {
    if (typeof document.body.style.maxHeight == "undefined") {
        //if ($.browser.msie && $.browser.version == "6.0") {
        $("#dialog").css("position", "absolute").css("margin-top", "0px");
        var divY = (getViewportHeight() - $("#dialog").outerHeight()) / 2;
        $("#dialog").css("top", (divY + document.documentElement.scrollTop).toString());
        $(window).biaoroll(function() { $("#dialog").css("top", divY + document.documentElement.scrollTop + ""); });
    }
    $(document).bind("mouseup", function() { $("#f_tianjiaTag").remove(); });
});