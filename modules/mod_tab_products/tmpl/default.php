<?phpdefined('_JEXEC') or die;JHtml::_('jquery.framework');JHtml::_('jquery.ui');JHtml::_('jquery.zozo_tab');JHtml::_('jQuery.lazyload');JHtml::_('jQuery.appear');$doc->addLessStyleSheet(JUri::root() . 'media/system/js/slick-master/slick/slick-theme.less');$doc->addLessStyleSheet(JUri::root() . 'modules/mod_tab_products/assets/less/mod_tab_products.less');$doc->addScript(JUri::root() . 'modules/mod_tab_products/assets/js/jquery.vtvslider.js');JHtml::_('jQuery.utility');$doc->addScript(JUri::root() . 'modules/mod_tab_products/assets/js/mod_tab_products.js');require_once JPATH_ROOT . DS . 'administrator/components/com_hikashop/helpers/helper.php';$moduleclass_sfx = $params->get('moduleclass_sfx','');$params=$module->params;$lazyload=(boolean)$params->get('lazyload',false);$style=$params->get('product_style','');$deconstruction=$lazyload;$effects = array('tada', 'pulse', 'flipInX', 'flipInY', 'fadeIn', 'fadeInUp', 'fadeInRight', 'fadeInUpBig',    'fadeInRightBig', 'slideInRight', 'bounceIn', 'bounceInUp', 'bounceInRight', 'rotateIn',    'rotateInUpLeft', 'rotateInUpRight', 'lightSpeedIn');?>    <div class="mod_tab_products <?php echo $moduleclass_sfx ?>" id="mod_tab_products_<?php echo $module->id ?>">        <?php        if(!$lazyload){              echo Modtab_productsHelper::render_module($module);         }else{            echo Modtab_productsHelper::render_module($module,$deconstruction);        }        ?>    </div><?php$js_content = '';$doc = JFactory::getDocument();ob_start();?>    <script type="text/javascript">        jQuery(document).ready(function ($) {            $("#mod_tab_products_<?php echo $module->id ?>").mod_tab_products({                module_id:<?php echo $module->id   ?>,                style: "<?php echo $style ?>",                lazyload: "<?php echo json_encode($lazyload) ?>",                deconstruction: "<?php echo json_encode($lazyload) ?>",                params:<?php echo json_encode($params->toObject()) ?>            });        });    </script><?php$js_content = ob_get_clean();$js_content = JUtility::remove_string_javascript($js_content);$doc->addScriptDeclaration($js_content);?>