<?php
/**
* @version 1.4.0
* @package RSform!Pro 1.4.0
* @copyright (C) 2007-2013 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
$tmpl = JRequest::getVar('tmpl');
?>
<?php if ($tmpl != 'component') { ?>
<button type="button" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=forms.emails&tmpl=component&formId='.$this->formId); ?>', 'Emails', '800x750');" class="rs_button"><?php echo JText::_('RSFP_FORM_EMAILS_NEW'); ?></button>
<br /><br />

<div id="emailscontent">
<?php } ?>
<table class="adminlist table table-striped" id="articleList">
	<thead>
		<tr>
			<th><?php echo JText::_('RSFP_FORM_EMAILS_SUBJECT'); ?></th>
			<th width="55%" align="center"><?php echo JText::_('RSFP_FORM_EMAILS_TO'); ?></th>
			<th width="1%" nowrap="nowrap" class="title"><?php echo JText::_('RSFP_FORM_EMAILS_ACTIONS'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $k = 0; ?>
		<?php if (!empty($this->emails)) { ?>
		<?php foreach ($this->emails as $row) { ?>
		<tr class="row<?php echo $k; ?>">
			<td>
				<a href="#" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=forms.emails&tmpl=component&formId='.$row->formId.'&cid='.$row->id); ?>', 'Emails', '800x750'); return false;"><?php echo $this->escape($row->subject); ?></a>
			</td>
			<td><?php echo $this->escape($row->to); ?></td>
			<td align="center" width="20%" nowrap="nowrap">
				<button type="button" class="rs_button rs_left" onclick="openRSModal('<?php echo JRoute::_('index.php?option=com_rsform&task=forms.emails&tmpl=component&formId='.$row->formId.'&cid='.$row->id); ?>', 'Emails', '800x750')"><?php echo JText::_('EDIT'); ?></button>
				<button type="button" class="rs_button rs_left" onclick="removeEmail(<?php echo $row->id; ?>,<?php echo $row->formId; ?>);"><?php echo JText::_('DELETE'); ?></button>
			</td>
		</tr>
		<?php $k=1-$k; ?>
		<?php } ?>
		<?php } ?>
	</tbody>
</table>
<?php if ($tmpl != 'component') { ?>
</div>
<?php } ?>