<?php

require 'config.php';

dol_include_once('/societe/class/societe.class.php');
dol_include_once('/core/lib/company.lib.php');
dol_include_once('/relations/class/relations.class.php');

$socid = GETPOST('socid');

$object = new Societe($db);
$object->fetch($socid);

switch ($action) {
    case 'save':
    default:
        _card($object);
        break;
}

function _card(&$object) {
    global $db, $conf, $langs;
    
    llxHeader();
    $head = societe_prepare_head($object);
    dol_fiche_head($head, 'relations', $langs->trans('ThirdParty'), 0, 'company.png');
    
    echo '<h2>' . $langs->trans('Relations') . '</h2>';
    
    dol_fiche_end();
    llxFooter();
}
