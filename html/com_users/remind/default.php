<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
JFactory::getApplication()->enqueueMessage('Forbidden', 'error');
return false;

die();
defined('_JEXEC') or die;
require_once  JPATH_SITE . '/components/com_people/helpers/people.php';

?>

<?php echo $this->loadTemplate('core'); ?>

<?php echo $this->loadTemplate('params'); ?>

<?php echo $this->loadTemplate('custom'); ?>

</div>
