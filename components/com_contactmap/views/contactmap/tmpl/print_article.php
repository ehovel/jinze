<?php 
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 
$document   =& JFactory::getDocument();

$document->addCustomTag( '<link rel="stylesheet" href="components/com_contactmap/views/contactmap/contactmap_print.css" media="print" type="text/css" />'); 
$document->addCustomTag( '<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>'); 
JHTML::_( 'behavior .modal' );
$config =& JComponentHelper::getParams('com_contactmap'); 
$printer=JURI::base().'components/com_contactmap/images/printer.jpg';
?>
<div  id="contactmap_print">
<?php
foreach ($this->rows as $row) {	?>
    	<h1><?php echo $row->name; ?></h1><br />
        <h4><?php echo $row->con_position; ?></h4>
		<table>
    		<tr>
                <td>
                    <?php
						if ($row->image!=null) { $image=JURI::base().'/images/contactmap/'.$row->image;?> <img src=<?php echo $image; ?> > <?php }; ?>
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="contactmap_print_taille2">
            <?php if ($row->address!=null) {?><label><?php echo JText::_('GMAPFP_ADRESSE');?> </label><span><?php echo $row->address;?></span><br /> <?php };?> 
            <?php if ($row->postcode!=null) {?><label><?php echo JText::_('GMAPFP_CODEPOSTAL');?> </label><span><?php echo $row->postcode;?></span><br /> <?php };?> 
            <?php if ($row->suburb!=null) {?><label><?php echo JText::_('GMAPFP_VILLE'); ?> </label><span><?php  echo $row->suburb;?></span><br /> <?php };?> 
            <?php if ($row->state!=null) {?><label><?php echo JText::_('GMAPFP_DEPARTEMENT');?> </label><span><?php echo $row->state;?></span><br /> <?php };?> 
            <?php if ($row->country!=null) {?><label><?php echo JText::_('GMAPFP_PAY');?> </label><span><?php echo $row->country;?></span><br /> <?php };?> 
                </td>
                <td>
            <?php if ($row->telephone!=null) {?><label><?php echo JText::_('GMAPFP_TEL');?> </label><span><?php echo $row->telephone;?></span><br /> <?php };?> 
            <?php if ($row->mobile!=null) {?><label><?php echo JText::_('GMAPFP_TEL');?> </label><span><?php echo $row->mobile;?></span><br /> <?php };?> 
            <?php if ($row->fax!=null) {?><label><?php echo JText::_('GMAPFP_FAX');?> </label><span><?php echo $row->fax;?></span><br /> <?php };?> 
            <?php if ($row->email_to!=null) {?><label><?php echo JText::_('GMAPFP_EMAIL');?> </label><span><?php echo $row->email_to;?></span><br /> <?php };?> 
            <?php if ($row->webpage!=null) {?><label><?php echo JText::_('GMAPFP_SITE_WEB');?> </label><span><?php echo $row->webpage;?></span> <br /> <?php };?> <br />
                </td>
			</tr>
		</table>
        <br />
        <span><?php echo $row->misc; echo $row->message; ?></span><br /><br />
        <?php if ($row->horaires_prix!=null) {?><label><?php echo JText::_('GMAPFP_HORAIRES_PRIX');?> </label><br /><span><?php echo $row->horaires_prix;?></span><br /> <?php };
}; ?>
<div style="overflow: auto;">
	<?php echo $this->map; ?>
</div>
<?php if ($this->params->get('contactmap_licence')) : ?>
<table>
    <tr>
        <td valign="top" align="center">
            <?php echo '<br />'.JText::_('GMAPFP_COPYRIGHT'); ?>
        </td>
    </tr>
</table>
<?php endif; ?>
</div>
