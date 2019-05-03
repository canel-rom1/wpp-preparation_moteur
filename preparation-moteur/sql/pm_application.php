<?php
    require_once(explode("wp-content",__FILE__)[0]."wp-load.php");
    global $wpdb;

    $t_marques       = $wpdb->prefix."pm_marques";
    $t_modeles       = $wpdb->prefix."pm_modeles";
    $t_versions      = $wpdb->prefix."pm_versions";
    $t_motorisations = $wpdb->prefix."pm_motorisations";
    $t_moteurs       = $wpdb->prefix."pm_moteurs";

    $sql = "SELECT $t_marques.name        AS marque,
                   $t_modeles.name        AS modele,
                   $t_versions.name       AS version,
                   $t_motorisations.name  AS motorisation,
                   $t_moteurs.name        AS moteur,
                   $t_moteurs.ch_ori      AS ch_ori,
                   $t_moteurs.ch_reprog   AS ch_reprog,
                   $t_moteurs.nm_ori      AS nm_ori,
                   $t_moteurs.nm_reprog   AS nm_reprog,
                   $t_moteurs.prix        AS prix,
                   $t_moteurs.text        AS text
            FROM $t_moteurs
            INNER JOIN $t_marques
                  ON   $t_moteurs.id_marque = $t_marques.id
            INNER JOIN $t_modeles
                  ON   $t_moteurs.id_modele = $t_modeles.id
            INNER JOIN $t_versions
                  ON   $t_moteurs.id_version = $t_versions.id
            INNER JOIN $t_motorisations
                  ON   $t_moteurs.id_motorisation = $t_motorisations.id
            ORDER BY marque, modele, version, motorisation, moteur;";
    $results = $wpdb->get_results($sql);

    echo json_encode($results);
?>
