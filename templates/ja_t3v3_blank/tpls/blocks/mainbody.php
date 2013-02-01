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

<section id="ja-mainbody" class="container ja-mainbody">
  <div class="row">
    
    <!-- MAIN CONTENT -->
    <div id="ja-content" class="ja-content <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>
      <jdoc:include type="message" />
      <jdoc:include type="component" />
    </div>
    
    <!-- //MAIN CONTENT -->

    <?php if ($this->countModules($sidebar1)) : ?>
    <!-- SIDEBAR 1 -->
    <div class="ja-sidebar ja-sidebar-1 <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>
      <jdoc:include type="modules" name="<?php $this->_p($sidebar1) ?>" style="JAxhtml" />
    </div>
    <!-- //SIDEBAR 1 -->
    <?php endif ?>
    
    <?php if ($this->countModules($sidebar2)) : ?>
    <!-- SIDEBAR 2 -->
    <div class="ja-sidebar ja-sidebar-2 <?php echo $this->getClass($layout, $col) ?>" <?php echo $this->getData ($layout, $col++) ?>>
      <jdoc:include type="modules" name="<?php $this->_p($sidebar2) ?>" style="JAxhtml" />
    </div>
    <!-- //SIDEBAR 2 -->
    <?php endif ?>

  </div>
</section> 