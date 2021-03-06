<?php
/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://webx.solutions
# Terms of Use: An extension that is derived from the Ark Editor will only be allowed under the following conditions: http://arkextensions.com/terms-of-use
# ------------------------------------------------------------------------*/ 

defined( '_JEXEC' ) or die;
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('radio');

class JFormFieldJSRadio extends JFormFieldRadio
{
	protected $type = 'JSRadio';

	protected function getInput()
	{
		global $JElementJSRadioJSWritten;
		if (!$JElementJSRadioJSWritten) 
		{
			$file = dirname(__FILE__) . DS . "jsradio.js";
			$url  = str_replace(JPATH_ROOT, JURI::root(true), $file);
			$url  = str_replace(DS, "/", $url);
			$doc  = JFactory::getDocument();
			$doc->addScript( $url );

			$JElementJSRadioJSWritten = TRUE;
		}

		$this->class = $this->class ? 'ark_radio btn-group' . chr( 32 ) .(string)$this->class : 'ark_radio btn-group';

		return parent::getInput();
	}
}