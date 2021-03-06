<?php
/**
* @package		EasySocial
* @copyright	Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @author		Jason Rey <jasonrey@stackideas.com>
* EasySocial is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined( '_JEXEC' ) or die( 'Unauthorized Access' );

class EasySocialControllerFoundry extends EasySocialController
{
	/**
	 * Processes .view and .language from the javascript calls.
	 *
	 * @since	1.0
	 * @access	public
	 * @param	string
	 * @return
	 */
	public function getResource()
	{
		$resources 	= JRequest::getVar('resource');

		if ($resources) {

			// Load language files
			$lang = FD::language();

			$lang->loadSite();
			$lang->loadAdmin();

			foreach ($resources as &$resource) {
				$resource	= (object) $resource;
				$result 	= false;

				if ($resource->type == 'view') {
					$result = $this->getView($resource->name);
				}

				if ($resource->type == 'language') {
					$result = $this->getLanguage($resource->name);
				}

				if ($result !== false) {
					$resource->content = $result;
				}
			}
		}

		header('Content-type: text/x-json; UTF-8');

		echo json_encode($resources);
		exit;
	}

	/**
	 * Responsible to output ejs theme files given the namespace.
	 *
	 * @since	1.0
	 * @access	public
	 * @param	string	The current namespace.
	 */
	public function getView( $path = '', $type = '', $prefix = '', $config = array())
	{
		$theme = FD::themes();
		$theme->extension = 'ejs';
		$output = $theme->output( $path );
		return $output;
	}

	/**
	 * Performs language translations.
	 *
	 * @since	1.0
	 * @param 	string	The language string to translate.
	 * @return	string	The translated language string.
	 */
	public function getLanguage( $languageString )
	{
		return JText::_( strtoupper( $languageString ) );
	}

	/**
	 * Determines if the controller should be visible on lockdown mode
	 *
	 * @since	1.0
	 * @access	public
	 * @return	bool
	 */
	public function isLockDown()
	{
		return false;
	}

}
