<?php
/**
* @package		Social
* @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined( '_JEXEC' ) or die( 'Unauthorized Access' );

FD::import( 'site:/views/views' );

class EasySocialViewFollowers extends EasySocialSiteView
{
	/**
	 * Responsible to return html codes to the ajax calls.
	 *
	 * @since	1.0
	 * @access	public
	 */
	public function filter( $filter , $users = array() , $currentUserId = '' )
	{
		$ajax 	= FD::ajax();

		// Throw error
		if( $this->hasErrors() )
		{
			return $ajax->reject( $this->getMessage() );
		}

		$currentUser 	= FD::user( $currentUserId );

		$theme 			= FD::themes();

		$theme->set( 'currentUser'	, $currentUser );
		$theme->set( 'users' 	, $users );
		$theme->set( 'active'	, $filter );

		$output 	= $theme->output( 'site/followers/default.items' );

		return $ajax->resolve( $output );
	}

	/**
	 * Displays confirmation to unfollow a user.
	 *
	 * @since	1.0
	 * @access	public
	 */
	public function confirmUnfollow()
	{
		$ajax 	= FD::ajax();

		$theme	= FD::themes();

		$id 	= JRequest::getInt( 'id' );

		$user 	= FD::user( $id );

		$theme->set( 'user'	, $user );
		$contents = $theme->output( 'site/followers/dialog.unfollow' );

		return $ajax->resolve( $contents );
	}

	/**
	 * Post processing after an item is unfollowed
	 *
	 * @since	1.0
	 * @access	public
	 * @param	string
	 * @return
	 */
	public function unfollow()
	{
		$ajax 	= FD::ajax();


		$ajax->resolve();
	}
}
