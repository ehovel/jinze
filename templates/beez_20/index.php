<?php
/**
 * @package                Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright        Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

// check modules
$showRightColumn	= ($this->countModules('position-3') or $this->countModules('position-6') or $this->countModules('position-8'));
$showbottom			= ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showleft			= ($this->countModules('position-4') or $this->countModules('position-7') or $this->countModules('position-5'));

if ($showRightColumn==0 and $showleft==0) {
	$showno = 0;
}

JHtml::_('behavior.framework', true);

// get params
$color				= $this->params->get('templatecolor');
$logo				= $this->params->get('logo');
$navposition		= $this->params->get('navposition');
$app				= JFactory::getApplication();
$menu = $app->getMenu();
$isHome = false;
if($menu->getActive()==$menu->getDefault()){
	$isHome = true;
}
$doc				= JFactory::getDocument();
$templateparams		= $app->getTemplate(true)->params;

$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/jinze.css', $type = 'text/css', $media = 'screen,projection');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="shortcut icon" href="favicon.png" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/plugin.js" type="text/javascript"></script>
<script src="js/all.js" type="text/javascript"></script>
<jdoc:include type="head" />

<!--[if lte IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>

<body>
	<div id="wrap">
		<div id="header">
			<div class="layout header_inner"> 
				<div class="header_top clearfix">
					<div class="unit"><a href="#" title="" class="red">网站首页</a>|<a href="#" title="">网站地图</a>|<a href="#" title="">English</a></div>
					<div class="top_nav"><a href="#" title="">液压机</a>|<a href="#" title="" class="red">卷板机</a>|<a href="#" title="">剪板机</a>|<a href="#" title="">折弯机</a></div>
				</div>
				
				<!--logo-->
				<h1 id="logo">
					<a href="<?php echo $this->baseurl ?>" title="<?php echo htmlspecialchars($templateparams->get('sitetitle'));?>">
						<?php if ($logo): ?>
	                	<img src="<?php echo $this->baseurl ?>/<?php echo htmlspecialchars($logo); ?>"  alt="<?php echo htmlspecialchars($templateparams->get('sitetitle'));?>" />
	                <?php endif;?></a>
	            </h1>
	            <!-- menus begin -->
				<jdoc:include type="modules" name="menus" />
			</div>
		</div>
		<div id="content"<?php echo !$isHome ? ' class="inner_content_box"' : '';?>>
			<?php if ($isHome){?>
			<div class="layout content_inner"> 
				<!--promo-->
				<div id="promo">
					<jdoc:include type="modules" name="banners" />
				</div>
				
				<div class="clearfix">
					<div class="contact_phone">服务热线<em>13901477088</em><span>有任何问题欢迎拨打服务热线，联系人：储经理</span></div>
				
					<div class="search_wrap">
						<span class="dt">常见搜索：<em>折弯机</em>、剪板机、卷板机</span>
						<!--search-->
						<div class="search">
							<jdoc:include type="modules" name="产品搜索" />
							<!-- 
							<form action="" method="post">
								<input type="text" class="input_text act_clear" value="如：剪板机" onFocus="if (this.value == '如：剪板机') this.value = '';" onBlur="if (this.value == '') this.value = '如：剪板机';"  />
								<button type="submit" class="btn">search</button>
							</form> -->
						</div>
					</div>
		
				</div>
				
				<!--indexSection-->
				<div class="indexSection">
					<div class="indexSection_inner clearfix">
						<jdoc:include type="modules" name="首页产品分类" />
						<!--indexAbout-->
						<jdoc:include type="modules" name="首页公司简介" />
						
						<!--index_pro-->
						<div class="mod index_pro">
							<div class="hd clearfix">
								<h2>产品展示</h2>
								<span>product show</span>
								<a href="/products" title="">查看更多 &gt;&gt;</a>
							</div>
							<div class="bd">
								<jdoc:include type="modules" name="首页产品展示" />
							</div>
						</div>
						
						
						<div class="mod indexNews">
							<div class="hd">
								<h2 class="title">新闻资讯</h2>
								<span>news information</span>
								<a href="/news" title="">查看更多 &gt;&gt;</a>
							</div>
							<div class="bd">
								<div class="info">
									<jdoc:include type="modules" name="首页新闻展示" />
								</div>
							</div>
						
						</div>
				</div>
			</div>
			</div>
		<?php } else {?>
			<jdoc:include type="message" />
			<div class="inner_content_wrap">
				<div class="layout inner_content">
					<div class="inner_layout clearfix">
					
						<div class="aside">
							<jdoc:include type="modules" name="left" />
						</div>
					
						<!--main-->
						<div class="main">
							<div class="clearfix">
								<jdoc:include type="modules" name="顶部服务热线" />
							
								<div class="search_wrap">
									<!--search-->
									<div class="search">
										<jdoc:include type="modules" name="产品搜索" />
									</div>
								</div>
					
							</div>
							<!--headline-->
							<jdoc:include type="component" />
							
							<!--service_center-->
							<div class="service_center">
								
							</div>					
					
					</div>
					</div>
				</div>		
			</div>
		
		<?php }?>
		</div>
		<!--footer-->
		<div id="footer">
			<div class="layout footer_inner">
				<p><span class="copyright">Copyright &copy; <?php echo date('Y')?> 版权所有：江苏金泽重型机械有限公司  苏ICP备11014662号-1 </span><span><em>厂址：</em>江苏南通海安开发区立发大道8号</span>
					<span><em>网址：</em>www.jinzezj.com</span></p><p>
					<span><em>手机：</em>13901477088 / 13506276898</span>
					<span><em>电话：</em>0513-88661199</span>
					<span><em>传真：</em>0513-88661199</span>
					<span><em>邮箱：</em><a href="#" title="">info@jsjzzj.com</a></span>
				</p>
				<p>友情链接：<a href="#" title="">剪板机</a>、<a href="#" title="">折弯机</a>、<a href="#" title="">卷板机</a>、<a href="#" title="">液压机</a>、<a href="#" title="">开卷校平线</a>、<a href="#" title="">型材弯曲机</a>、<a href="#" title="">钢坯剪断机</a></p>
				
			</div>
		</div>
	</div>
</body>
</html>
