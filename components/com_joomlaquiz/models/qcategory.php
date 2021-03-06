<?php
/**
* Joomlaquiz Component for Joomla 3
* @package Joomlaquiz
* @author JoomPlace Team
* @copyright Copyright (C) JoomPlace, www.joomplace.com
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
/**
 * Category Model.
 *
 */
class JoomlaquizModelQcategory extends JModelList
{	
	public function getCategories(){
		
		jimport('joomla.application.categories');
		$categories = new JCategories(array('extension'=>'com_joomlaquiz','access'=>true));
		$input = JFactory::getApplication()->input;
		$cur_cat = $categories->get($input->get( 'cat_id'));
		$subs = $cur_cat->getChildren(true);
		$rel_level = $cur_cat->level;
		
		$ids = array($cur_cat->id);
		foreach($subs as $s){
			$ids[] = $s->id;
		}
		$return_data = array();
		foreach($ids as $cat_id){
			$database = JFactory::getDBO();
			$mainframe = JFactory::getApplication();
			$my = JFactory::getUser();
			
			$cat = array();
			if (!$cat_id) {
				$cat[0] = new stdClass;
				$cat[0]->error = 1;
				$cat[0]->message = '';
				continue;
			}

			$cat = $categories->get($cat_id);
			$cat->level =  $cat->level - $rel_level;
					
			$where = array();
			$rel_quizzes = array();
			$lpath_ids = array();
			$quiz_ids = array();
			if($my->id) {
				
				$VM_quiz_products = array();
				if (file_exists(JPATH_BASE . '/components/com_virtuemart/helpers/config.php'))
					$no_virtuemart = false;
				else
					$no_virtuemart = true;
					
				if(!$no_virtuemart){
					$query = "SELECT DISTINCT qp.*, vm_o.virtuemart_order_id "
						. "\n FROM #__virtuemart_orders AS vm_o"
						. "\n INNER JOIN #__virtuemart_order_items AS vm_oi ON vm_oi.virtuemart_order_id = vm_o.virtuemart_order_id"
						. "\n INNER JOIN #__quiz_products AS qp ON qp.pid = vm_oi.virtuemart_product_id"
						. "\n WHERE vm_o.virtuemart_user_id = " . $my->id . " AND vm_o.order_status IN ('C')"
						;
					$database->SetQuery( $query );
					$VM_quiz_products = $database->loadObjectList();
				}
								
				$query = "SELECT DISTINCT qp.*, (p.id+1000000000) AS `order_id`"
						. "\n FROM #__quiz_payments AS p"
						. "\n INNER JOIN #__quiz_products AS qp ON qp.pid = p.pid"
						. "\n WHERE p.user_id = '". $my->id ."' AND p.status IN ('Confirmed')"
						;
				$database->SetQuery( $query );
				$quiz_products = $database->loadObjectList();		
				if (!is_array($quiz_products)) $quiz_products = array();
				
				$quiz_products = array_merge($quiz_products, $VM_quiz_products);
				
				if (is_array($quiz_products) && count($quiz_products)) 
				foreach($quiz_products as $q) {
					$rel_quizzes[$q->type][] = $q;
					if($q->type == 'l') {
						$lpath_ids[] = $q->rel_id;
					} else {
						$quiz_ids[] = $q->rel_id;
					}
				}
				$lpath_ids = array_unique($lpath_ids);
				$quiz_ids = array_unique($quiz_ids);

				$query = "SELECT * "
				. "\n FROM #__quiz_products_stat "
				. "\n WHERE uid = '{$my->id}' "
				;
				$database->SetQuery( $query );
				$products_stat = $database->loadObjectList('qp_id');
			}

			$query = "SELECT *"
			. "\n FROM `#__quiz_t_quiz`"
			. "\n WHERE c_category_id = '$cat_id' AND published = 1 ORDER BY c_title "
			;
			$database->SetQuery( $query );
			$all_quizzez = $database->loadObjectList('c_id');
			
			$query = "SELECT `c_title`"
			. "\n FROM `#__quiz_t_quiz`"
			. "\n WHERE c_category_id = '$cat_id' AND published = 1 ORDER BY `c_title` "
			;
			$database->SetQuery( $query );
			$c_titles = $database->loadColumn();
			uasort($c_titles, "strnatcmp");
			$c_titles = array_values($c_titles);
			
			$sort_quizzez = array();
			if(count($all_quizzez)){
				foreach($c_titles as $title){
					foreach($all_quizzez as $i=>$row){
						if($row->c_title == $title){
							$sort_quizzez[] = $row;
						}
					}
				}
			}
			$all_quizzez = $sort_quizzez;
			
			$rows = $purch_quizzes = array();
			if (is_array($all_quizzez)) {
				foreach($all_quizzez as $i=>$row) {
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_title, 'quiz_t_quiz', 'c_title', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_description, 'quiz_t_quiz', 'c_description', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_short_description, 'quiz_t_quiz', 'c_short_description', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_right_message, 'quiz_t_quiz', 'c_right_message', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_wrong_message, 'quiz_t_quiz', 'c_wrong_message', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_pass_message, 'quiz_t_quiz', 'c_pass_message', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_unpass_message, 'quiz_t_quiz', 'c_unpass_message', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_metadescr, 'quiz_t_quiz', 'c_metadescr', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_keywords, 'quiz_t_quiz', 'c_keywords', $all_quizzez[$i]->c_id);
					JoomlaquizHelper::JQ_GetJoomFish($all_quizzez[$i]->c_metatitle, 'quiz_t_quiz', 'c_metatitle', $all_quizzez[$i]->c_id);

					if($all_quizzez[$i]->paid_check == 0 ) {
						$all_quizzez[$i]->payment = JText::_('COM_QUIZ_PAYMENT_FREE');
						$rows[] = $all_quizzez[$i];
					} else {
						$purch_quizzes[] = $all_quizzez[$i]->c_id;
					}
				}
			}
			
			$bought_quizzes = array();
			if(array_key_exists('q', $rel_quizzes) && count($rel_quizzes['q']) ) {
				foreach($rel_quizzes['q'] as $data) {
					if(!in_array($data->rel_id, $purch_quizzes) || empty($all_quizzez[$data->rel_id])) {
						continue;
					}
					if($data->xdays > 0) {
						$data->suffix = sprintf(JText::_('COM_QUIZ_XDAYS'), $data->xdays);
					} else if(($data->period_start && $data->period_start != '0000-00-00') || ($data->period_end && $data->period_end != '0000-00-00')) {
						if(!empty($products_stat) && array_key_exists($data->id, $products_stat)) {
							$data->period_start = $products_stat[$data->id]->period_start;
							$data->period_end = $products_stat[$data->id]->period_end;
						}
						$period = array();				
						if($data->period_start && $data->period_start != '0000-00-00') {
							$period[] = sprintf(JText::_('COM_QUIZ_LPATH_PERIOD_FROM'), date(JText::_('COM_QUIZ_LPATH_PERIOD_FORMAT') ,strtotime($data->period_start)));
						}
						if($data->period_end && $data->period_end != '0000-00-00') {
							$period[] = sprintf(JText::_('COM_QUIZ_LPATH_PERIOD_TO'), date(JText::_('COM_QUIZ_LPATH_PERIOD_FORMAT') ,strtotime($data->period_end)));
						}
						$data->suffix = sprintf(JText::_('COM_QUIZ_PERIOD'), implode(' ', $period));
					}
					
					if($data->attempts > 0 && $data->xdays > 0) {
						$data->suffix = sprintf(JText::_('COM_QUIZ_XDAYS_ATTEMPTS'), $data->attempts, $data->xdays);
					} else {
						$data->suffix .= ($data->suffix ? ' ' : '') . sprintf(JText::_('COM_QUIZ_ATTEMPTS'), $data->attempts);
					}
					$data->row = $all_quizzez[$data->rel_id];
					$data->pid = $data->order_id;
					$bought_quizzes[] = $data;
				}
			}

			$lpaths = array();
			if(array_key_exists('l', $rel_quizzes) && count($rel_quizzes['l'])) {
				$query = 'SELECT * FROM #__quiz_lpath WHERE published = 1';
				$database->setQuery( $query );
				$lpath = $database->loadObjectList('id');
				if (!empty($lpath)) {
					foreach($lpath as $i=>$row) {
						JoomlaquizHelper::JQ_GetJoomFish($lpath[$i]->title, 'quiz_lpath', 'title', $lpath[$i]->id);
						JoomlaquizHelper::JQ_GetJoomFish($lpath[$i]->short_descr, 'quiz_lpath', 'short_descr', $lpath[$i]->id);
						JoomlaquizHelper::JQ_GetJoomFish($lpath[$i]->descr, 'quiz_lpath', 'descr', $lpath[$i]->id);
					}
					if(is_array($rel_quizzes['l']) && count($rel_quizzes['l']))
					foreach($rel_quizzes['l'] as $data) {
						if(empty($lpath[$data->rel_id])) {
							continue;
						}
						$data->title = $lpath[$data->rel_id]->title;
						$data->short_descr = $lpath[$data->rel_id]->short_descr;
						if($data->xdays > 0) {
							$data->suffix = sprintf(JText::_('COM_LPATH_XDAYS'), $data->xdays);
						} else if(($data->period_start && $data->period_start != '0000-00-00') || ($data->period_end && $data->period_end != '0000-00-00')) {
							if(!empty($products_stat) && array_key_exists($data->id, $products_stat)) {
								$data->period_start = $products_stat[$data->id]->period_start;
								$data->period_end = $products_stat[$data->id]->period_end;
							}
							$period = array();
							if($data->period_start && $data->period_start != '0000-00-00') {
								$period[] = sprintf(JText::_('COM_QUIZ_LPATH_PERIOD_FROM'), date(JText::_('COM_QUIZ_LPATH_PERIOD_FORMAT'), strtotime($data->period_start)));
							}
							if($data->period_end && $data->period_end != '0000-00-00') {
								$period[] = sprintf(JText::_('COM_QUIZ_LPATH_PERIOD_TO'), date(JText::_('COM_QUIZ_LPATH_PERIOD_FORMAT'), strtotime($data->period_end)));
							}
							$data->suffix = sprintf(JText::_('COM_LPATH_PERIOD'), implode(' ', $period));
						}
						if($data->attempts > 0) {
							$data->suffix .= ($data->suffix ? ' ' : '') . sprintf(JText::_('COM_LPATH_ATTEMPTS'), $data->attempts);
						}
						$data->pid = $data->order_id;
						$lpaths[] = $data;
					}
				}
			}

			$data = new stdClass;
			$data->cat = $cat;
		
			$user = JFactory::getUser();
			foreach($rows as $i => $quizz){	
				if($quizz->paid_check || !$quizz->c_guest){
					// need to run checks
					if(!$user->id){
						// need to check permissions
						if(!$user->authorise('core.view', 'com_joomlaquiz.quiz.'.$quizz->c_id)){
							unset($rows[$i]);
						}
					}
					// need to check packages
					// feature to release(after refactoring)
				}
			}
			
			$data->rows = $rows;
			$data->lpaths = $lpaths;
			$data->bought_quizzes = $bought_quizzes;
			
			$return_data[$cat_id] = $data;
		}
		
		return $return_data;
	}
}
