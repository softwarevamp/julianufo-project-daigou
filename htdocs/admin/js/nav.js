// 导航栏配置文件
var outlookbar=new outlook();
var t;
var ADMIN_URL=document.location.toString();
var index1 = ADMIN_URL.lastIndexOf('/');
ADMIN_URL=ADMIN_URL.substring(0,index1);
//获取后台路径

//服务网址
var SERVERURL="http://www.tuan518.com/";

//——start————团购管理部分开始
t=outlookbar.addtitle('管理团购','团购管理',1)
outlookbar.additem('团购列表',t,'groups_list.php')
outlookbar.additem('团购添加',t,'groups_add.php')
outlookbar.additem('团购回收站',t,'groups_list.php?action=recycle')
t=outlookbar.addtitle('供应商','团购管理',1)
outlookbar.additem('供应商家列表',t,'suppliers_list.php')
outlookbar.additem('添加供应商',t,'suppliers_add.php')
t=outlookbar.addtitle('团购券','团购管理',1)
outlookbar.additem('团购券列表',t,'groupbond_list.php')
outlookbar.additem('添加团购券',t,'groupbond_add.php')
outlookbar.additem('批量添加团购券',t,'groupbond_adds.php')

t=outlookbar.addtitle('团购供应','团购管理',1)
outlookbar.additem('<font color=red>团购供应信息</a>',t,SERVERURL+'api_list.php?url='+ADMIN_URL)
outlookbar.additem('<font color=red>提供团购信息</a>',t,SERVERURL+'api_add.php?url='+ADMIN_URL)

//———end———团购管理部分结束

//——start————文章管理部分开始
t=outlookbar.addtitle('管理文章','文章管理',1)
outlookbar.additem('文章列表',t,'article_list.php')
outlookbar.additem('添加文章',t,'article_add.php')
t=outlookbar.addtitle('文章分类','文章管理',1)
outlookbar.additem('分类列表',t,'atype_manage.php')
outlookbar.additem('添加分类',t,'atype_manage.php?action=add')
//———end———文章管理部分结束

//——start————网站留言管理部分开始
t=outlookbar.addtitle('管理留言','留言管理',1)
outlookbar.additem('普通留言',t,'guestbook_list.php')
outlookbar.additem('提供团购信息',t,'feedback_list.php?tid=1')
outlookbar.additem('意见反馈',t,'feedback_list.php?tid=2')
//———end———网站留言管理部分结束

//——start————订单管理部分开始
t=outlookbar.addtitle('管理订单','订单管理',1)
outlookbar.additem('订单列表',t,'order_list.php')
outlookbar.additem('会员充值',t,'accountcharge_list.php')
t=outlookbar.addtitle('支付款单','订单管理',1)
outlookbar.additem('收款单',t,'moneychanges_list.php?tid=1')
outlookbar.additem('退款单',t,'moneychanges_list.php?tid=2')

t=outlookbar.addtitle('送货车','订单管理',1)
outlookbar.additem('发货单',t,'invoice_list.php?tid=0,1')
outlookbar.additem('退货单',t,'invoice_list.php?tid=2')
//———end———订单管理部分结束

//——start————会员管理部分开始
t=outlookbar.addtitle('管理会员','会员管理',1)
outlookbar.additem('会员列表',t,'user_list.php')
outlookbar.additem('会员添加',t,'user_add.php')
t=outlookbar.addtitle('邀请返利','会员管理',1)
outlookbar.additem('邀请返利管理',t,'accountreferrals_list.php')
outlookbar.additem('未处理邀请返利',t,'accountreferrals_list.php?tid=0')
outlookbar.additem('通过邀请返利',t,'accountreferrals_list.php?tid=1')
outlookbar.additem('失效邀请返利',t,'accountreferrals_list.php?tid=2')

//———end———会员管理部分结束

//——start————邮件管理部分开始
t=outlookbar.addtitle('管理推广','推广管理',1)
outlookbar.additem('手机列表',t,'mobile_list.php')
outlookbar.additem('邮箱列表',t,'email_list.php')
outlookbar.additem('发送账户',t,'smtp_list.php')
outlookbar.additem('群发邮件',t,'email_send.php')
//———end———邮件管理部分结束

//——start————交易方式管理部分开始
t=outlookbar.addtitle('交易设置','交易方式',1)
outlookbar.additem('支付方式',t,'pay_account.php')
outlookbar.additem('配送方式',t,'pay_delivery.php')
//———end———交易方式管理部分结束

//——start————系统设置管理部分开始
t=outlookbar.addtitle('设置系统','系统设置',1)
outlookbar.additem('参数设置',t,'sys_info.php')
outlookbar.additem('管理员管理',t,'sys_admin.php')
outlookbar.additem('数据库备份',t,'dbbak.php')
t=outlookbar.addtitle('地区设置','系统设置',1)
outlookbar.additem('地区列表',t,'city_manage.php')
outlookbar.additem('添加地区',t,'city_manage.php?action=add')
t=outlookbar.addtitle('缓存日志','系统设置',1)
outlookbar.additem('清空缓存',t,'clearcache.php')
//outlookbar.additem('日志管理',t,'log_list.php')
//———end———交易方式管理部分结束


