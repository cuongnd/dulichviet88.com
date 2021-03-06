<?php
/**
 * @package    HikaMarket for Joomla!
 * @version    1.7.0
 * @author     Obsidev S.A.R.L.
 * @copyright  (C) 2011-2016 OBSIDEV. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
class zoneMarketController extends hikamarketController {
	protected $rights = array(
		'display' => array('selection', 'useselection', 'gettree'),
		'add' => array(),
		'edit' => array(),
		'modify' => array(),
		'delete' => array()
	);

	protected $type = 'zone';
	protected $config = null;

	public function __construct($config = array(), $skip = false) {
		parent::__construct($config, $skip);
		$this->config = hikamarket::config();
	}

	public function selection() {
		if(!hikamarket::loginVendor())
			return false;
		if(!$this->config->get('frontend_edition',0))
			return false;
		JRequest::setVar('layout', 'selection');
		return parent::display();
	}

	public function useselection() {
		if(!hikamarket::loginVendor())
			return false;
		if(!$this->config->get('frontend_edition',0))
			return false;
		JRequest::setVar('layout', 'useselection');
		return parent::display();
	}

	public function getTree() {
		while(ob_get_level())
			@ob_end_clean();

		if(!hikamarket::loginVendor() || !$this->config->get('frontend_edition',0)) {
			echo '[]';
			exit;
		}

		$zone_key = JRequest::getVar('zone_key', null);
		$displayFormat = JRequest::getVar('displayFormat', '');
		$search = JRequest::getVar('search', null);

		$nameboxType = hikamarket::get('type.namebox');
		$options = array(
			'zone_key' => $zone_key,
			'displayFormat' => $displayFormat
		);
		$ret = $nameboxType->getValues($search, 'zone', $options);
		if(!empty($ret)) {
			echo json_encode($ret);
			exit;
		}
		echo '[]';
		exit;
	}
}
