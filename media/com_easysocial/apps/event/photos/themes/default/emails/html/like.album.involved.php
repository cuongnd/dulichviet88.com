<?php
/**
* @package        EasySocial
* @copyright    Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license        GNU/GPL, see LICENSE.php
* EasySocial is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<tr>
    <td style="text-align: center;padding: 40px 10px 0;">
        <div style="margin-bottom:15px;">
            <div style="font-family:Arial;font-size:32px;font-weight:normal;color:#333;display:block; margin: 4px 0">
                <?php echo JText::sprintf('APP_EVENT_PHOTOS_EMAILS_LIKE_ALBUM_INVOLVED_HEADING', $actor); ?>
            </div>
        </div>
    </td>
</tr>

<tr>
    <td style="text-align: center;font-size:12px;color:#888">

        <div style="margin:30px auto;text-align:center;display:block">
            <img src="<?php echo rtrim(JURI::root(), '/'); ?>/components/com_easysocial/themes/wireframe/images/emails/divider.png" alt="<?php echo JText::_('divider'); ?>" />
        </div>

        <table width="540" cellspacing="0" cellpadding="0" border="0" align="center">
            <tr>
                <td>
                    <p style="text-align:left;">
                        <?php echo JText::_('COM_EASYSOCIAL_EMAILS_HELLO'); ?> <?php echo $recipientName; ?>,
                    </p>

                    <p style="text-align:left;">
                        <?php echo JText::sprintf('APP_EVENT_PHOTOS_EMAILS_LIKE_ALBUM_INVOLVED_CONTENT', $actor); ?>
                    </p>
                </td>
            </tr>
        </table>

        <table width="540" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 20px auto 0;background-color:#f8f9fb;padding:15px 20px;">
            <tbody>
                <tr>
                    <td valign="top" align="left" width="30%">
                        <a href="<?php echo $albumPermalink; ?>"><img src="<?php echo $albumCover; ?>" alt="<?php echo $this->html('string.escape', $albumTitle); ?>" style="" width="128" /></a>
                    </td>
                    <td valign="top" style="color:#888;background-color:#f8f9fb;text-align:left;">
                        <p style="margin:0 0 5px;font-weight:bold;font-size:13px;">
                            <a href="<?php echo $albumPermalink; ?>" style="color:#888;text-decoration:none;"><?php echo $albumTitle; ?></a>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <a style="
                display:inline-block;
                text-decoration:none;
                font-weight:bold;
                margin-top: 20px;
                padding:10px 15px;
                line-height:20px;
                color:#fff;font-size: 12px;
                background-color: #83B3DD;
                background-image: linear-gradient(to bottom, #91C2EA, #6D9CCA);
                background-repeat: repeat-x;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                border-style: solid;
                border-width: 1px;
                box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
                border-radius:2px; -moz-border-radius:2px; -webkit-border-radius:2px;
                " href="<?php echo $albumPermalink; ?>"><?php echo JText::_('COM_EASYSOCIAL_EMAILS_VIEW_ALBUM'); ?></a>

    </td>
</tr>