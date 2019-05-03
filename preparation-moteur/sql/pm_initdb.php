<?php
function pm_create_db()
{
    pm_add_table_marques();
    pm_add_table_modeles();
    pm_add_table_versions();
    pm_add_table_motorisations();
    pm_add_table_moteurs();
}

function pm_add_table_marques()
{
    global $wpdb;

    $t_marques       = $wpdb->prefix."pm_marques";
    $charset_collate = $wpdb->get_charset_collate();

    $sql= "CREATE TABLE $t_marques(
        id          INTEGER(4)      NOT NULL AUTO_INCREMENT,
        name        VARCHAR(99)     NOT NULL,
        PRIMARY KEY(id)
    )$charset_collate;";

    $wpdb->query($sql);
}

function pm_add_table_modeles()
{
    global $wpdb;

    $t_marques       = $wpdb->prefix."pm_marques";
    $t_modeles       = $wpdb->prefix."pm_modeles";
    $charset_collate = $wpdb->get_charset_collate();

    $sql= "CREATE TABLE $t_modeles(
        id          INTEGER(4)      NOT NULL AUTO_INCREMENT,
        id_marque   INTEGER(4)      NOT NULL,
        name        VARCHAR(99)     NOT NULL,
        PRIMARY KEY(id),
        KEY id_marque(id_marque),
        CONSTRAINT modeles_ibkf_1 FOREIGN KEY (id_marque) REFERENCES $t_marques(id)
    )$charset_collate;";

    $wpdb->query($sql);
}

function pm_add_table_versions()
{
    global $wpdb;

    $t_modeles       = $wpdb->prefix."pm_modeles";
    $t_versions      = $wpdb->prefix."pm_versions";
    $charset_collate = $wpdb->get_charset_collate();

    $sql= "CREATE TABLE $t_versions(
        id          INTEGER(4)      NOT NULL AUTO_INCREMENT,
        id_modele   INTEGER(4)      NOT NULL,
        name        VARCHAR(99)     NOT NULL,
        PRIMARY KEY(id),
        KEY id_modele(id_modele),
        CONSTRAINT versions_ibkf_1 FOREIGN KEY (id_modele) REFERENCES $t_modeles(id)
    )$charset_collate;";

    $wpdb->query($sql);
}

function pm_add_table_motorisations()
{
    global $wpdb;

    $t_motorisations = $wpdb->prefix."pm_motorisations";
    $charset_collate = $wpdb->get_charset_collate();

    $sql= "CREATE TABLE $t_motorisations(
        id          INTEGER(4)      NOT NULL AUTO_INCREMENT,
        name        VARCHAR(99)     NOT NULL,
        PRIMARY KEY(id)
    )$charset_collate;";

    $wpdb->query($sql);
}

function pm_add_table_moteurs()
{
    global $wpdb;

    $t_marques       = $wpdb->prefix."pm_marques";
    $t_modeles       = $wpdb->prefix."pm_modeles";
    $t_versions      = $wpdb->prefix."pm_versions";
    $t_motorisations = $wpdb->prefix."pm_motorisations";
    $t_moteurs       = $wpdb->prefix."pm_moteurs";
    $charset_collate = $wpdb->get_charset_collate();

    $sql= "CREATE TABLE $t_moteurs(
        id              INTEGER(4)      NOT NULL AUTO_INCREMENT,
        id_marque       INTEGER(4)      NOT NULL,
        id_modele       INTEGER(4)      NOT NULL,
        id_version      INTEGER(4)      NOT NULL,
        id_motorisation INTEGER(4)      NOT NULL,
        name            VARCHAR(99)     NOT NULL,
        ch_ori          INTEGER(4)      NOT NULL,
        ch_reprog       INTEGER(4)      NOT NULL,
        nm_ori          INTEGER(4)      NOT NULL,
        nm_reprog       INTEGER(4)      NOT NULL,
        prix            INTEGER(6)      NOT NULL,
        text            TEXT            NOT NULL,
        PRIMARY KEY(id),
        KEY id_marque(id_marque),
        KEY id_modele(id_modele),
        KEY id_version(id_version),
        KEY id_motorisation(id_motorisation),
        CONSTRAINT moteurs_ibfk_1     FOREIGN KEY (id_marque)       REFERENCES $t_marques(id),
        CONSTRAINT moteurs_ibfk_2     FOREIGN KEY (id_modele)       REFERENCES $t_modeles(id),
        CONSTRAINT moteurs_ibfk_3     FOREIGN KEY (id_version)      REFERENCES $t_versions(id),
        CONSTRAINT moteurs_ibfk_4     FOREIGN KEY (id_motorisation) REFERENCES $t_motorisations(id)
    )$charset_collate;";

    $wpdb->query($sql);
}
?>
