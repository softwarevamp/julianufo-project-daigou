
(function($) {
    $.Estimates = function(options) {
        var opts = { tbTotleProductCost: null, tbTotleWeight: null, ddlArea: null, ddlSendType: null, tbEstimatesDetail: null, trEstimatesResault: null };
        opts = $.extend(opts, options);
        //$this['Estimates'] = $(this);
        var bgprice = 0;
        this.getDetail = function() {
            if (opts.tbTotleProductCost.val() == "")
            { alert("请输入商品价格"); return; }
            if (opts.tbTotleWeight.val() == "")
            { alert("请输入商品重量"); return; }
            if (opts.ddlArea.val() == "运送区域") { alert("请选择运送区域"); return; }
            else if (opts.ddlArea.val() == "国内转送") {
                bgprice = 0;
            }
            opts.tbEstimatesDetail.html('<tr><td>正在计算...</td><tr>');
            $.ajax({
                type: "POST",
                url: "/ajax/estimates_ajax.php?action=getdetails",
                dataType: "json",
                contentType: "application/json;utf-8",
                data: "{'TotleWeight':" + opts.tbTotleWeight.val()+ ",'TotleProductCost':'" + opts.tbTotleProductCost.val() + "','Area':'" + opts.ddlArea.val() + "'}",
                timeout: 10000,
                Error: onfail,
                success: onsuccess
            });
        }
        var onsuccess = function(resault) {
            //opts.trEstimatesResault.show('slow');
            var detail = resault;
            var res = "<tr><td height=\"30\" bgcolor=\"#FFFFFF\"><b>运送方式</b></td><td bgcolor=\"#FFFFFF\"><b>商品价格(元)</b></td><td bgcolor=\"#FFFFFF\"><b>服务费(元)</b></td><td bgcolor=\"#FFFFFF\"><b>报关费(元)</b></td><td bgcolor=\"#FFFFFF\"><b>运费(元)</b></td><td bgcolor=\"#FFFFFF\"><b>总计(元)</b></td></tr>";
            for (var i = 0; i < detail.length; i++) {
                res += "<tr><td height=\"30\" bgcolor=\"#FFFFFF\">" + detail[i].deliveryname + "</td><td bgcolor=\"#FFFFFF\">" + opts.tbTotleProductCost.val() + "</td><td bgcolor=\"#FFFFFF\">" + detail[i].serverfee + "</td><td bgcolor=\"#FFFFFF\">" + detail[i].customs_fee + "</td><td bgcolor=\"#FFFFFF\">" + detail[i].sendfee + "</td><td bgcolor=\"#FFFFFF\">" + detail[i].totlefee + "</td></tr>";
            }
            opts.tbEstimatesDetail.html(res);
        }
        var onfail = function() {
            opts.trEstimatesResault.show('slow');
            opts.tbEstimatesDetail.html('<td>网络超时!</td>');
        }
        return this;
    }
})(jQuery);
