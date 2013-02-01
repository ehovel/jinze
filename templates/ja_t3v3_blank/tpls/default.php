<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <jdoc:include type="head" />
    <?php  $this->loadBlock ('head');?>
  </head>

  <body>
	<div class="wrap">
    <?php  $this->loadBlock ('header'); ?>
    
    <?php  $this->loadBlock ('spotlight-1'); ?>

    <?php  $this->loadBlock ('content'); ?>
    
    <?php  $this->loadBlock ('spotlight-2'); ?>
    
    <?php  $this->loadBlock ('navhelper'); ?>
    
    <?php  $this->loadBlock ('footer'); ?>
    </div>
    
  </body>

</html>