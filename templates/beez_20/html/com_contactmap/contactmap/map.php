<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.9
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

$height_msg = '500px';
$width_msg = '400px';
$menu_info = $this->params->toArray();
$title = explode('&', $menu_info['page_heading']);
$first_contacter = array_shift($this->rows);
?>
<div class="headline clearfix">
	<div class="hd">
		<h3 class="title"><?php echo $title[0];?></h3>
		<?php echo isset($title[1]) ? '<span>'.$title[1].'</span>' : '';?>
	</div>
	
	<jdoc:include type="modules" name="顶部服务热线" />
	<div class="crumb"><span>您的位置：</span><a href="/" title="">首页</a>|<em><?php echo $title[0];?></em></div>
</div>
<div class="contactus_table">
	<table class="data_table">
		<tbody>
		<tr class="th">
			<td colspan="2" style="width:50%;">江苏金泽重型机械有限公司</td>
			<td colspan="2" rowspan="7">
				<?php echo $this->map; ?>
			</td>
		</tr>
		<tr>
			<td>联系人 </td>
			<td><?php echo $first_contacter->name?></td>
		</tr>
		<tr class="th">
			<td>手机</td>
			<td><?php echo $first_contacter->mobile?></td>
		</tr>
		<tr>
			<td>电话</td>
			<td><?php echo $first_contacter->telephone?></td>
		</tr>
		<tr class="th">
			<td>传真</td>
			<td><?php echo $first_contacter->fax?></td>
		</tr>
		<tr>
			<td class="th">地址</td>
			<td><?php echo $first_contacter->address?></td>
		</tr>
		<tr class="th">
			<td class="th">邮箱</td>
			<td><?php echo $first_contacter->email_to?></td>
		</tr>
	</tbody></table>
	<p><br/><br/></p>
	
	<table class="data_table">
		<tbody><tr>
			<td class="th" colspan="8">江苏金泽重型机械有限公司销售办事处</td>
		</tr>
		<tr>
			<td>销售员 姓名 </td>
			<td colspan="5">办事处及地址</td>
			<td>传真 </td>
			<td>联系电话</td>
		</tr>
		<?php foreach ($this->rows as $row) {?>
		<tr>
			<td>储经理</td>
			<td colspan="5"><?php echo $row->address?></td>
			<td><?php echo $row->fax?></td>
			<td><?php echo $row->telephone?></td>
		</tr>
		<?php }?>
	</tbody></table>
	
</div>
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php  echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif;?>
