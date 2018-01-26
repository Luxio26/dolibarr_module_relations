CREATE TABLE llx_les_relations (
    -- BEGIN MODULEBUILDER FIELDS
    fk_socid_source INTEGER NOT NULL,
    fk_type_relation INTEGER NOT NULL,
    fk_socid_target INTEGER NOT NULL,
    -- END MODULEBUILDER FIELDS
    PRIMARY KEY (fk_socid_source, fk_type_relation, fk_socid_target)
) ENGINE=innodb