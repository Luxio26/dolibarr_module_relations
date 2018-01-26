ALTER TABLE llx_les_relations ADD CONSTRAINT fk_relation_source FOREIGN KEY (fk_socid_source) REFERENCES llx_societe(rowid);
ALTER TABLE llx_les_relations ADD CONSTRAINT fk_relation_type FOREIGN KEY (fk_type_relation) REFERENCES llx_type_relations(rowid);
ALTER TABLE llx_les_relations ADD CONSTRAINT fk_relation_target FOREIGN KEY (fk_socid_target) REFERENCES llx_societe(rowid);
