<?php

/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\file		lib/relations.lib.php
 * 	\ingroup	relations
 * 	\brief		This file is an example module library
 * 				Put some comments here
 */
function relationsAdminPrepareHead() {
    global $langs, $conf;

    $langs->load("relations@relations");

    $h = 0;
    $head = array();

    $head[$h][0] = dol_buildpath("/relations/admin/relations_setup.php", 1);
    $head[$h][1] = $langs->trans("Parameters");
    $head[$h][2] = 'settings';
    $h++;
    $head[$h][0] = dol_buildpath("/relations/admin/relations_about.php", 1);
    $head[$h][1] = $langs->trans("About");
    $head[$h][2] = 'about';
    $h++;

    // Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    //$this->tabs = array(
    //	'entity:+tabname:Title:@relations:/relations/mypage.php?id=__ID__'
    //); // to add new tab
    //$this->tabs = array(
    //	'entity:-tabname:Title:@relations:/relations/mypage.php?id=__ID__'
    //); // to remove a tab
    complete_head_from_modules($conf, $langs, $object, $head, $h, 'relations');

    return $head;
}

function getRelations($id = '') {
    global $db;

    $sql = "SELECT rowid, name";
    $sql .= " FROM " . MAIN_DB_PREFIX . "type_relations";
    if (!empty($id)) {
        $sql .= " WHERE rowid=$id";
    }
    $resql = $db->query($sql);

    $list_relations = [];

    while ($obj = $db->fetch_object($resql)) {
        if (!empty($id)) {
            return $obj->name;
        }
        $list_relations[$obj->rowid] = $obj->name;
    }
    return $list_relations;
}

function insertRelation($socid_source, $fk_type_relation, $socid_target) {
    global $db;

    $sql = 'INSERT INTO ' . MAIN_DB_PREFIX . 'les_relations';
    $sql .= " VALUES($socid_source, $fk_type_relation, $socid_target)";

    $db->query($sql);
}

function fetchRelations($socid) {
    global $db;

    $sql = "SELECT t.name, fk_socid_target";
    $sql .= " FROM " . MAIN_DB_PREFIX . "les_relations r";
    $sql .= " INNER JOIN " . MAIN_DB_PREFIX . "type_relations t ON r.fk_type_relation = t.rowid";
    $sql .= " WHERE fk_socid_source=$socid";
    $resql = $db->query($sql);

    $list_relations = [];

    while ($obj = $db->fetch_object($resql)) {
        $list_relations[] = [$obj->name, $obj->fk_socid_target];
    }
    return $list_relations;
}
