<?php

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

class DbHelper
{
    public function getThemeConfig()
    {
        $db = Factory::getContainer()->get(\Joomla\Database\DatabaseInterface::class);
        $templateName = 'yootheme_digital';

        $query = $db->getQuery(true)
            ->select($db->quoteName(['params']))
            ->from($db->quoteName('#__template_styles'))
            ->where($db->quoteName('template') . ' = ' . $db->quote($templateName));

        $db->setQuery($query);
        $templateParams = $db->loadResult();

        return json_decode($templateParams);
    }
}

