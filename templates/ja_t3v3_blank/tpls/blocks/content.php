<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Mainbody 3 columns, content in center: sidebar1 - content - sidebar2
 */
defined('_JEXEC') or die;
?>

<div id="content">
	<div class="layout content_inner">
		<jdoc:include type="modules" name="<?php $this->_p('banners') ?>" style="JAxhtml" />
		<div class="clearfix">
			<div class="contact_phone">服务热线<em>13901477088</em><span>有任何问题欢迎拨打服务热线，联系人：储经理</span></div>
		
			<div class="search_wrap">
				<span class="dt">常见搜索：<em>折弯机</em>、剪板机、卷板机</span>
				<!--search-->
				<div class="search">
					<form method="post" action="">
						<input type="text" onblur="if (this.value == '') this.value = '如：剪板机';" onfocus="if (this.value == '如：剪板机') this.value = '';" value="如：剪板机" class="input_text act_clear">
						<button class="btn" type="submit">search</button>
					</form>
				</div>
			</div>

		</div>
		
		<!--indexSection-->
		<div class="indexSection">
			<div class="indexSection_inner clearfix">

				<div class="mod indexCategory">
					<div class="hd">
						<h2 class="title">产品分类</h2>
						<span>product categories</span>
					</div>
					<div class="bd">
						<div class="info">
							<ul>
								<li><a title="" href="">剪板机</a></li>
								<li><a title="" href="">折弯机</a></li>
								<li><a title="" href="">卷板机</a></li>
								<li><a title="" href="">液压机</a></li>
								<li><a title="" href="">校平机</a></li>
								<li><a title="" href="">开卷校平剪切生产线</a></li>
							</ul>
						</div>
					</div>
				</div>

				<!--indexAbout-->
				<div class="mod indexAbout">
					<div class="hd">
						<h2 class="title">公司简介</h2>
						<span>company profile</span>
					</div>
					<div class="bd">
						<div class="pic"><img alt="" src="images/change/index_about.jpg"></div>
						<div class="info">
							<p class="info">江苏金泽重型机械有限公司创立于1990年，于2010年改制后成立，位于长三角海安经济开发区。</p>
							<p class="clearfix"><a title="" href="#" class="more">详情点击 &gt;&gt;</a></p></div>
					</div>
				</div>
				
				<!--index_pro-->
				<div class="mod index_pro">
					<div class="hd clearfix">
						<h2>产品展示</h2>
						<span>product show</span>
						<a title="" href="">查看更多 &gt;&gt;</a>
					</div>
					<div class="bd">
						<ul class="catelist clearfix">
							<li>
								<div class="pic"><a title="" href="#"><img src="images/change/img_pro_05.jpg" title="" alt=""></a></div>
								<div class="info">
									<a title="" href="#">液压板料折弯机</a>
								</div>
							</li>
							<li>
								<div class="pic"><a title="" href="#"><img src="images/change/img_pro_05.jpg" title="" alt=""></a></div>
								<div class="info">
									<a title="" href="#">液压板料折弯机</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
				
				
				<div class="mod indexNews">
					<div class="hd">
						<h2 class="title">新闻资讯</h2>
						<span>news information</span>
						<a title="" href="#">查看更多 &gt;&gt;</a>
					</div>
					<div class="bd">
						<div class="info">
							<div class="item"><a class="newsTitle" title="" href="">世界机床工业以生产促进数控机床单机为主流</a><span class="date">2012-12-29</span></div>
							<div class="item"><a class="newsTitle" title="" href="">世界机床工业以生产促进数控机床单机为主流</a><span class="date">2012-12-29</span></div>
							<div class="item"><a title="" href="#">傲立机床网指出，目前世界机床技术水平</a><span class="date">2012-12-29</span></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	</div>
</div>