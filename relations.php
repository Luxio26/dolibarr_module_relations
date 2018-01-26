<?php

require 'config.php';

dol_include_once('/societe/class/societe.class.php');
dol_include_once('/core/lib/company.lib.php');
dol_include_once('/relations/class/relations.class.php');
dol_include_once('/relations/lib/relations.lib.php');

$socid = GETPOST('socid');
$action = GETPOST('action');

$object = new Societe($db);
$object->fetch($socid);

_card($object, $action, $socid);

function _card(&$object, $action, $socid) {
    global $db, $conf, $langs, $user;

    $form = new Form($db);

    llxHeader();
    $head = societe_prepare_head($object);
    dol_fiche_head($head, 'relations', $langs->trans('ThirdParty'), 0, 'company.png');

    $linkback = '<a href="' . DOL_URL_ROOT . '/societe/list.php?restore_lastsearch_values=1">' . $langs->trans("BackToList") . '</a>';

    dol_banner_tab($object, 'socid', $linkback, ($user->societe_id ? 0 : 1), 'rowid', 'nom');

    print '<div class="fichecenter">';
    print '<div class="underbanner clearboth"></div>';
    print '<form action="' . $_SERVER['PHP_SELF'] . '?socid=' . $socid . '" method="POST">';
    print '<input type="hidden" name="action" value="save" />';
    print '<table class="border tableforfield" width="100%">';

    if ($action == 'modify') {
        print '<tr>';
        print '<td width="20%">Tiers</td>';
        print '<td>';
        echo $form->select_thirdparty_list("", "socid_list", "s.rowid <> $socid", "", 0, 0, [], "", 0);
        print '</td>';
        print '</tr>';

        $liste_relations = getRelations();

        print '<tr>';
        print '<td width="20%">Type relation</td>';
        print '<td>';
        echo $form->selectarray("fk_type_relations", $liste_relations);
        print '</td>';
        print '</tr>';

        print '</table>';
//        print '</form>';
        print '</div>';
        print '</div>';

        print '<script type="text/javascript">'
                . '$(document).ready(function() {'
                . '     $("#fk_type_relations").select2({ width: "element" });'
                . '});'
                . '</script>';

        print '<div class="tabsAction">';
        print '<input class="butAction" type="submit" name="submit" value="' . $langs->trans('Save') . '"/>';
        print '</div>';
    }
    if ($action == 'save' || $action == '') {
        $tiers = GETPOST('socid_list');
        $type_relation = GETPOST('fk_type_relations');

        if ($action == 'save') {
            insertRelation($socid, $type_relation, $tiers);
        }
        
        $societe = new Societe($db);

        $les_relations = fetchRelations($socid);

        print '<tr>';
        print '<th>Tiers</th>';
        print '<th>Type relation</th>';
        print '</tr>';
        foreach ($les_relations as $rel) {
            $societe->fetch($rel[1]);
            
            print '<tr style="text-align: center">';
            print '<td>';
            print $societe->nom;
            print '</td>';
            print '<td>';
            print($rel[0]);
            print '</td>';
            print '</tr>';
        }

        print '</table>';
//        print '</form>';
        print '</div>';
        print '</div>';

        print '<div class="tabsAction">';
        print '<div class="inline-block divButAction"><a class="butAction" href="' . $_SERVER['PHP_SELF'] . '?socid=' . $socid . '&action=modify">' . $langs->trans('Add') . '</a></div>';
        print '</div>';
    }


//    print '<div class="tabsAction">';
//    print '<div class="inline-block divButAction"><a class="butAction" href="">'.$langs->trans('Modify').'</a></div>';
//    print '</div>';

    dol_fiche_end();
    llxFooter();
}
