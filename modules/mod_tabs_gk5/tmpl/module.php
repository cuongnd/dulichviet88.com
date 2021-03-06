<?php

/**
* Tabs GK5 - module template
* @package Joomla!
* @Copyright (C) 2009-2012 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: GK5 1.0 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

?>

<div class="gkTabsItem<?php echo $active_class; ?>">
	<?php 
		foreach(array_keys($this->mod_getter) as $m) { 
			if(!isset($this->config['module_wrap']) || (isset($this->config['module_wrap']) && $this->config['module_wrap'] == 0)) {
				echo JModuleHelper::renderModule($this->mod_getter[$m]); 
			} else {
				echo JModuleHelper::renderModule($this->mod_getter[$m], array('style' => 'gk_style'));
			}
		}
	?>
</div>