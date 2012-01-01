function searchFocus() {
    if ($("#searchKeyword").attr("class") == "text") {
        $("#searchKeyword").attr("class", "text_").val("");
    }
}

function searchBlur() {
    if ($.trim($("#searchKeyword").val()) == "") {
        $("#searchKeyword").attr("class", "text").val("请输入商品名..");
    }
}

function searchPiece() {
    var para = "?";
    if ($("#categoryID").attr("categoryid") != "-1")
        para += "c=" + $("#categoryID").attr("categoryid");
    if ($("#searchKeyword").attr("class") == "text_" && $.trim($("#searchKeyword").val()) != "") {
        if (para.length - para.lastIndexOf("?") > 1) para += "&";
        para += "k=" + encodeURI($.trim($("#searchKeyword").val()));
    }
    var ps = $.trim($(".tiao li a[class='yellow']").text());
    if (ps != 9) {
        if (para.length - para.lastIndexOf("?") > 1) para += "&";
        para += "ps=" + ps;
    }
    if (para.length < 3)
        window.location = new RegExp("http:\\w*\\??").exec(window.location.href);
    else
        window.location = "/pinindex.php" + para;
}

function subSearch() {
    var para = new RegExp("\\?.*$").exec(window.location.href).toString();
    if (para != null) {
        if (new RegExp("mi=\\w*").test(para))
            para = para.replace(/mi=[\w\.]*/, "mi=" + $("#minPrice").val());
        else
            para += "&mi=" + $("#minPrice").val();
        if (new RegExp("ma=\\w*").test(para))
            para = para.replace(/ma=[\w\.]*/, "ma=" + $("#maxPrice").val());
        else
            para += "&ma=" + $("#maxPrice").val();

        if ($.trim($("#minPrice").val()).length <= 0)
            para = para.replace(/[&\?]mi=\w*/, "");
        if ($.trim($("#maxPrice").val()).length <= 0)
            para = para.replace(/[&\?]ma=\w*/, "");

        para = para.replace(/[&\?]pn=\w*/, "");
        window.location = "/pinindex.php" + para;
    }
}

function mutiDiv(id) {
    $(".qh li").removeAttr("class");
    $(".qh li:eq(" + id + ")").attr("class", "on");
    $(".jifen").hide();
    $(".jifen:eq(" + id + ")").show();
}



function showHotProInfo(dom) {
    $(".jifen dt").hide();
    $(".jifen dd").show();
    $(dom).hide();
    $(dom).prev("dt").show();
}

$(document).ready(function() {
    $("#searchKeyword").keydown(function(e) { if (e.keyCode == 13) { searchPiece(); return false; } });
    $("#suggestCheck").keydown(function(e) { if (e.keyCode == 13) $("#suggestBtn2").click(); });
    $("#minPrice,#maxPrice").keydown(function(e) { if (e.keyCode == 13) subSearch(); });
    var reg = new RegExp("k=(\\w*)&?");

    var keywordReturn = reg.exec(window.location.href);

    if (keywordReturn) {
        keywordReturn = $("#searchKeyword").val();
        $(".summary h1 a").each(function() {
            var str = $(this).text();
            str = str.replace(new RegExp("(" + keywordReturn + ")", "ig"), "<font color='#FF0000'>$1</font>");
            $(this).html(str);
        });
    }

    $(".jifen dd:eq(0)").hide();
    $(".jifen dt:eq(0)").show();


    $(document).mouseup(function() {
        $("#categoryList").hide();
    });
    
    $(".remen a").each(function() { if ($("#categoryID").val() == $.trim($(this).text())) $(this).css("background-color", "#FF9900").css("text-decoration", "none").css("color", "#FFF"); });
})


