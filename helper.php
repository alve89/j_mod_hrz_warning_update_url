<?php
/**
 * Helper class for mod_hrz_warning_update_url module
 *
 * @package    mod_hrz_warning_update_url
 * @license        GNU/GPL, see LICENSE.php
 */
class ModHrzWarningUpdateUrlHelper {

  public static function getTemplateSettings() {
    // Obtain a database connection
    $db = JFactory::getDbo();
    // Retrieve the shout
    $query = $db->getQuery(true)
                ->select($db->quoteName('params'))
                ->from($db->quoteName('#__template_styles'))
                ->where('template = ' . $db->Quote('isis'));
    // Prepare the query
    $db->setQuery($query);
    // Load the row.
    $result = $db->loadResult();
    // Return the Hello
    return $result;

  }
  public static function updateTemplateSettings($templateSettings) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    // Fields to update.
    $fields = $db->quoteName('params') . ' = ' . $db->quote(json_encode($templateSettings));
    // Conditions for which records should be updated.
    $conditions = array(
        $db->quoteName('template') . ' = ' . $db->quote('isis')
    );
    $query->update($db->quoteName('#__template_styles'))->set($fields)->where($conditions);
    $db->setQuery($query);
    $result = $db->execute();
  }

  public static function varDump($var) {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
  }

}
