<?php
include("../common.inc.php");
include("function_common.php");
InitGP(array("page","action","inbox","value","payid","ids","did","delids")); //初始化变量全局返回

	$PM=new TableClass("pm","mid");
	if(!empty($_ADMINUSERS))$wherestr[]="touname='{$_ADMINUSERS['adminname']}'";//自己的短信列表
	if(!empty($wherestr)) $wheresql = implode(' AND ', $wherestr);	//条件汇总
	$pmarray=$PM->getdata(3,$wheresql); //获取短信息

	$GUESTBOOK=new TableClass("guestbook","gid");
	$guestbookarray=$GUESTBOOK->getdata(3); //获取留言数据
	
	
	$SENDORDER=new TableClass("sendorder","sid");
	$sendorderarray=$SENDORDER->getdata(4); //获取发货单数据
	
	$ADMIN=new TableClass("admin","adminid");
	$adminarray=$ADMIN->getdata(5); //获取管理员列表
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="MSHTML 6.00.3790.0" name=GENERATOR>
<link href="skin/skin_0/style/main.css" rel="stylesheet" type="text/css" />
<!--划动门内容CSS-->
<link href="skin/skin_0/style/HX101515261033.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.STYLE1 {font-size: 14px}
img {border:0px}
-->
</style>
</HEAD>
<BODY>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" valign="top"><table width="100%" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1">
              <tr>
                <td height="2" bgcolor="#FFFFFF"></td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1"><img src="skin/skin_0/images/b1.jpg" width="2" height="184" /></td>
                      <td valign="top" background="skin/skin_0/images/b2.jpg"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td height="28" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top"><span class="cdsearchlabel">待办事宜</span></td>
                                  <td width="50"></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td width="110" height="120" valign="top"><table width="110" height="120" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td><table width="100" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                      <tr>
                                        <td bgcolor="#FFFFFF"><table width="100" border="0" cellspacing="1" cellpadding="0">
                                            <tr>
                                              <td><img src="skin/skin_0/images/ZA102233712052.jpg" width="105" height="105" /></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                  </table></td>
                                </tr>
                            </table></td>
                            <td valign="top">
							<table width="99%" border="0" cellpadding="0" cellspacing="6" class="txt12">
                              <tr>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="order_list.php?state=1">未处理订单</a> <span class="txt12h">[
								<?php echo DB::result_first("select count(*) from ".DB::table('order')." where state = '1'");?>
								]</span></td>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="sendorder_list.php?state=1">待处理运单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('sendorder')." where state = '1'");?>]</span></td>

                              </tr>
                              <tr>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="order_list.php?state=2">已确认订单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('order')." where state = '2'");?>]</span></td>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="sendorder_list.php?state=2">以邮寄运单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('sendorder')." where state = '2'");?>]</span></td>

                              </tr>
                              <tr>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="order_list.php?state=3">已订购订单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('order')." where state = '3'");?>]</span></td>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="sendorder_list.php?state=3">已成功运单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('sendorder')." where state = '3'");?>]</span></td>

                              </tr>
                              <tr>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="order_list.php?state=4">到仓库订单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('order')." where state = '4'");?>]</span></td>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="pm_in.php">我的短信数</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('pm')." where touname='{$_ADMINUSERS['adminname']}'");?>]</span></td>

                              </tr>
                              <tr>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="order_list.php?state=5">已提交货运订单</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('order')." where state = '5'");?>]</span></td>
                                <td><img src="skin/skin_0/images/dingbat01.gif" width="10" height="11" /></td>
                                <td><a href="guestbook_list.php">待处理留言数</a> <span class="txt12h">[<?php echo DB::result_first("select count(*) from ".DB::table('guestbook')." where state = '0'");?>]</span></td>
                              </tr>
							  
                            </table></td>
                          </tr>
                          <tr>
                            <td height="1" colspan="2" background="skin/skin_0/images/d.gif"></td>
                          </tr>
                          <tr>
                            <td height="26" colspan="2" align="center"><p>&nbsp;</p>
                                <p>&nbsp;</p></td>
                          </tr>
                      </table></td>
                      <td width="1"><img src="skin/skin_0/images/b3.jpg" width="2" height="184" /></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="4" bgcolor="#FFFFFF"></td>
              </tr>

              <tr>
                <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="1"><img src="skin/skin_0/images/b1.jpg" width="2" height="184" /></td>
                            <td valign="top" background="skin/skin_0/images/b2.jpg"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                                <tr>
                                  <td height="28"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td><span class="cdsearchlabel">&nbsp;站内短信</span></td>
                                        <td width="50"><a href="pm_in.php"><img src="skin/skin_0/images/more2.gif" width="42" height="13" border=0/></a></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td height="140" valign="top"><div class="tab-page" id="div">
								  <?php foreach($pmarray as $r){?>
								  <DIV class=cntTextPane 
                              xmlns:dates="urn:rdcpro-com:dates" 
                              xmlns:bob="urn:bob">
                                      <DIV class=cntTextPaneHead><A 
                              href="pm_in.php">
                                        <?php echo $r['subject'];?> </A></DIV>
                                      <DIV 
                              class=cntTextPaneBlurb><?php echo $r['message'];?></DIV>
                                      <DIV class=cntClientline></DIV>
                                    </DIV>
									<?php };?>
									

                                  </div></td>
                                </tr>
                              </table></td>
                            <td width="1"><img src="skin/skin_0/images/b3.jpg" width="2" height="184" /></td>
                          </tr>
                        </table></td>
                      <td width="4"></td>
                      <td width="340"><table width="340" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="1"><img src="skin/skin_0/images/b1.jpg" width="2" height="184" /></td>
                            <td valign="top" background="skin/skin_0/images/b2.jpg"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                              <tr>
                                <td height="28"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><span class="cdsearchlabel">&nbsp;最新留言</span></td>
                                      <td width="50"><a href="guestbook_list.php"><img src="skin/skin_0/images/more2.gif" width="42" height="13" border=0/></a></td>
                                    </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td height="140" valign="top"><div class="tab-page" id="div2">
								
								  <?php foreach($guestbookarray as $r){?>
								  <DIV class=cntTextPane 
                              xmlns:dates="urn:rdcpro-com:dates" 
                              xmlns:bob="urn:bob">
                                      <DIV class=cntTextPaneHead><A 
                              href="guestbook_list.php">
                                        <?php echo $r['uname'];?> </A></DIV>
                                      <DIV 
                              class=cntTextPaneBlurb><?php echo $r['msg'];?></DIV>
                                      <DIV class=cntClientline></DIV>
                                    </DIV>
									<?php };?>
                                </div></td>
                              </tr>
                            </table></td>
                            <td width="1"><img src="skin/skin_0/images/b3.jpg" width="2" height="184" /></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
			   <tr>
                <td height="4" bgcolor="#FFFFFF"></td>
              </tr>

                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1"><img src="skin/skin_0/images/b1.jpg" width="2" height="184" /></td>
                      <td valign="top" background="skin/skin_0/images/b2.jpg"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td height="28" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top"><span class="cdsearchlabel">最新运单</span></td>
                                  <td width="50"><img src="skin/skin_0/images/more2.gif" width="42" height="13" /></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td width="110" height="120" valign="top"><table width="110" height="120" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td><table width="100" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                                      <tr>
                                        <td bgcolor="#FFFFFF"><table width="100" border="0" cellspacing="1" cellpadding="0">
                                            <tr>
                                              <td><img src="skin/skin_0/images/ZA102233712052.jpg" width="105" height="105" /></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                  </table></td>
                                </tr>
                            </table></td>
                            <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="7">
                                <tr>
                                  <td colspan="2" class="txt16">最新运单列表,请赶快处理！</td>
                                </tr>
                           
                                <tr>
                                  <td width="80%">
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="txt12">
								  
								<?php foreach($sendorderarray as $r){?>
								  
                                      <tr>
                                        <td width="4%" height="18"><img src="skin/skin_0/images/90.jpg" width="10" height="10" /></td>
                                        <td width="72%"><?php echo "订单ID：".$r['sid']." 网站用户：".$r['uname']." 运费：".$r['freight']." 服务费：".$r['serverfee']." 收货人：".$r['consignee'];?>    </td>
                                        <td width="24%" class="txt12h">[<?php echo ddate('Y-m-d H:i:s',$r['addtime']);?>]</td>
                                      </tr>
								<?php };?>
								
                                  </table></td>
                                </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td height="1" colspan="2" background="skin/skin_0/images/d.gif"></td>
                          </tr>
                          <tr>
                            <td height="26" colspan="2" align="center"><p>&nbsp;</p>
                                <p>版权所有：郑州全搜索</p></td>
                          </tr>
                      </table></td>
                      <td width="1"><img src="skin/skin_0/images/b3.jpg" width="2" height="184" /></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="240" valign="top">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px">
              <tr>
                <td height="4"></td>
              </tr>
              <tr>
                <td>
				<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                    <tr>
                      <td height="22" align="center" background="skin/skin_0/images/q1.jpg"><table width="96%" border="0" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td width="91%"><span class="cdsearchlabel">管理员列表</span> </td>
                            <td width="9%"></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td width="20%" height="110" valign="top"><img src="skin/skin_0/images/default.aspx-assetid=ZA101775731033.gif" alt="" width="35" height="52" border="0" title="" /></td>
                            <td width="80%" align="left">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" class="txt12">
							<?php foreach($adminarray as $r){?>
							
                                <tr>
                                  <td width="7%" height="18" align="center"><img src="skin/skin_0/images/90.jpg" width="10" height="10" /></td>
                                  <td width="93%"> <?php echo $r['adminname'];?> 
								  ，最后登录：
								  <span class="txt12h">
								  <?php echo ddate('Y-m-d',$r['lastlogin']);?>
								  </span></td>
                                </tr>
							<?php };?>	
								

                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="2"></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                    <tr>
                      <td height="28" align="center" background="skin/skin_0/images/qw1.jpg"><table width="96%" border="0" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td width="91%"><span class="cdsearchlabel">&nbsp;快速导航</span></td>
                            <td width="9%">&nbsp;</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td align="center" bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td align="center" valign="top"><a href="order_list.php"><img src="skin/skin_0/images/default.aspx-assetid=ZA101512961033.gif" width="36" height="52" /></a></td>
                            <td align="center"><a href="order_list.php?state=3"><img src="skin/skin_0/images/default.aspx-assetid=ZA101762941033.gif" width="35" height="52" /></a></td>
                            <td align="center"><a href="order_list.php?state=4"><img src="skin/skin_0/images/default.aspx-assetid=ZA101320441033.gif" width="35" height="52" /></a></td>
                            <td align="center"><a href="order_list.php?state=5"><img src="skin/skin_0/images/default.aspx-assetid=ZA101775901033.gif" width="35" height="52" /></a></td>
                          </tr>
                          <tr>
                            <td height="20" align="center" class="cdsearchlabel">订单管理</td>
                            <td align="center"><span class="cdsearchlabel">在途订单</span></td>
                            <td align="center"><span class="cdsearchlabel">到库订单</span></td>
                            <td align="center"><span class="cdsearchlabel">提交订单</span></td>
                          </tr>
                        </table>
                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="2"></td>
                          </tr>
                          <tr>
                            <td height="1" background="skin/skin_0/images/d.gif"></td>
                          </tr>
                          <tr>
                            <td height="2"></td>
                          </tr>
                        </table>
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">

						  
                          <tr>
                            <td align="center" valign="top"><a href="sendorder_list.php"><img src="skin/skin_0/images/ZA101776012052.gif" width="37" height="52" /></a></td>
                            <td align="center"><a href="sendorder_list.php?state=1"><img src="skin/skin_0/images/default.aspx-AssetID=ZA101642761033.gif" width="24" height="24" /></a></td>
                            <td align="center"><a href="sendorder_list.php?state=2"><img src="skin/skin_0/images/default.aspx-assetid=ZA101512921033.gif" width="36" height="52" /></a></td>
                            <td align="center"><a href="sendorder_list.php?state=3"><img src="skin/skin_0/images/ZA101326232052.gif" width="35" height="52" /></td>
                          </tr>						  
						  
						  
						  
                          <tr>
                            <td height="20" align="center" class="cdsearchlabel">运单管理</td>
                            <td align="center"><span class="cdsearchlabel">待处理</span></td>
                            <td align="center"><span class="cdsearchlabel">已处理</span></td>
                            <td align="center"><span class="cdsearchlabel">已成功</span></td>
                          </tr>
                        </table>
                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="2"></td>
                          </tr>
                          <tr>
                            <td height="1" background="skin/skin_0/images/d.gif"></td>
                          </tr>
                          <tr>
                            <td height="2"></td>
                          </tr>
                        </table>
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                          <tr>
                            <td align="center" valign="top"><a href="sys_info.php"><img src="skin/skin_0/images/default.aspx-assetid=ZA101776221033.gif" width="35" height="52" /></a></td>
                            <td align="center"><a href="special_list.php"><img src="skin/skin_0/images/ZA101776202052.gif" width="35" height="52" /></a></td>
                            <td align="center"><a href="news_list.php"><img src="skin/skin_0/images/ZA101326252052.gif" width="35" height="52" /></a></td>
                            <td align="center"><a href="goods_list.php"><img src="skin/skin_0/images/pp.gif" width="35" height="52" /></a></td>
                          </tr>
                          <tr>
                            <td height="20" align="center" class="cdsearchlabel">系统设置</td>
                            <td align="center"><span class="cdsearchlabel">专题列表</span></td>
                            <td align="center"><span class="cdsearchlabel">公告列表</span></td>
                            <td align="center"><span class="cdsearchlabel">推荐代购</span></td>
                          </tr>
                        </table>
                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="2"></td>
                          </tr>
                          <tr>
                            <td height="1" background="skin/skin_0/images/d.gif"></td>
                          </tr>
                          <tr>
                            <td height="2"></td>
                          </tr>
                        </table>
						
                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="txt12">
                            <tr>
                            <td align="center" valign="top"><a href="pm_in.php"><img src="skin/skin_0/images/default.aspx-assetid=ZA101776191033.gif" width="35" height="52" /></td>
                            <td align="center"><a href="user_list.php"><img src="skin/skin_0/images/default.aspx-AssetID=ZA101642751033.gif" width="24" height="24" /></td>
                            <td align="center"><a href="guestbook_list.php"><img src="skin/skin_0/images/default.aspx-assetid=ZA101776211033.gif" width="35" height="52" /></td>
                            <td align="center"><a href="pm_send.php"><img src="skin/skin_0/images/default.aspx-assetid=ZA101775841033.gif" width="35" height="52" /></td>
                          </tr>
                          <tr>
                            <td height="20" align="center" class="cdsearchlabel">我的短信</td>
                            <td align="center"><span class="cdsearchlabel">用户管理</span></td>
                            <td align="center"><span class="cdsearchlabel">留言列表</span></td>
                            <td align="center"><span class="cdsearchlabel">发送短信</span></td>
                          </tr>
                        </table>
						
						</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="4"></td>
                    </tr>
                    <tr>
                      <td><img src="skin/skin_0/images/uu.gif" width="242" height="50"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="4"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</BODY>
</HTML>
