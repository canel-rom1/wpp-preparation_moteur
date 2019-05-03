<div id="pm_user_menu">
    <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="get" id="chgvhc">
        <select id="list_marque"  onchange="marquechange();"></select>
        <select id="list_modele"  onchange="modelechange();"></select>
        <select id="list_version" onchange="versionchange();"></select>
        <select id="list_motorisation" onchange="motorisationchange();"></select>
        <select id="list_moteur" onchange="moteurchange();"></select>
    </form>
</div>
