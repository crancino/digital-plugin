<?php
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

class DbHelper
{

    public function __construct()
    {
        
    }

    
    public function getThemeConfig()
    {
        // Ottieni l'istanza del database di Joomla
        $db = JFactory::getDBO();

        // Sostituisci 'nome_template' con il nome del tuo template Yootheme Pro
        $templateName = 'yootheme_digital';

        // Costruisci la query per recuperare i parametri del template dalla tabella del database
        $query = $db->getQuery(true)
            ->select($db->quoteName(array('params')))
            ->from($db->quoteName('#__template_styles'))
            ->where($db->quoteName('template') . ' = ' . $db->quote($templateName));

        // Esegui la query
        $db->setQuery($query);

        // Ottieni i risultati
        $templateParams = $db->loadResult();

        // Decodifica i parametri JSON se necessario
        $templateParams = json_decode($templateParams);

        return $templateParams;
    }
    
    
    
}

?>