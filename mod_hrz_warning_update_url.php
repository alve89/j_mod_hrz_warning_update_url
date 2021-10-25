<?php
/**
 * @version 	0.0.1
 * @package 	mod_hrz_warning_update_url
 * @copyright 	(c) 2017 Stefan Herzog
 * @license		GNU/GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');

$application = JFactory::getApplication();

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

//ModHrzWarningUpdateUrlHelper::varDump();

if(explode('.', $_SERVER['HTTP_HOST'])[0] == $params->get('subdomain')) {
  if($params->get('showNotice')
  && $params->get('useRandom')
  && rand(1,abs(intval($params->get('frequency')))) == 1) {
    JFactory::getApplication()->enqueueMessage("You're on the specified URL!", 'notice');
  }

  $templateSettings = json_decode(ModHrzWarningUpdateUrlHelper::getTemplateSettings()); // from DB

  if(!file_exists(dirname(__FILE__) . '/oldcolors.txt')) {
    if( file_put_contents(dirname(__FILE__) . '/oldcolors.txt', json_encode(array('templateColor'=>$templateSettings->templateColor,
                                                                              'headerColor'  => $templateSettings->headerColor)) !== false) ) {
      JFactory::getApplication()->enqueueMessage('File "oldcolors.txt" was created, colors stored');
    }
    else {
      JFactory::getApplication()->enqueueMessage('File "oldcolors.txt" was NOT created!', 'error');
    }
  }

  if($params->get('resetColors')) {
    $templateSettings = json_decode(file_get_contents(dirname(__FILE__) . '/oldcolors.txt'));
    if(unlink(dirname(__FILE__) . '/oldcolors.txt') ) {
      JFactory::getApplication()->enqueueMessage('File "oldcolors.txt" was deleted');
    }
    else {
      JFactory::getApplication()->enqueueMessage('Error while deleting file "oldcolors.txt"', 'error');
    }
  }
  else {
    $templateSettings->templateColor = $params->get('backgroundcolor_nav');
    $templateSettings->headerColor = $params->get('backgroundcolor_title');

  }

  ModHrzWarningUpdateUrlHelper::updateTemplateSettings($templateSettings);
}

require JModuleHelper::getLayoutPath('mod_hrz_warning_update_url');
