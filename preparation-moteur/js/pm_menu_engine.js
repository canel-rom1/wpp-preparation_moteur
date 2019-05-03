var vhcs_ar = "";
var marque_select = "";
var modele_select = "";
var version_select = "";
var motorisation_select = "";
var moteur_select = "";
var marque_selected = "";
var modele_selected = "";
var version_selected = "";
var motorisation_selected = "";
var moteur_selected = "";
var change_value = 1;

xhr = new XMLHttpRequest(); 
xhr.onreadystatechange = function() 
{
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
    {
        console.log("RECIEVED DATA"); // C'est bon \o/
        console.log(xhr.responseText);
        vhcs_ar = JSON.parse(xhr.responseText);
        console.log(vhcs_ar);
        chargepage();
    }
};
//xhr.open("GET", "dbFetchTable.php", true);
xhr.open("GET", pm_wp_path.plugin+"sql/pm_application.php", true);
xhr.send(null);

function chargepage()
{
    console.log("CHARGE LA PAGE");
    marque_select = document.getElementById("list_marque");
    modele_select = document.getElementById("list_modele");
    version_select = document.getElementById("list_version");
    motorisation_select = document.getElementById("list_motorisation");
    moteur_select = document.getElementById("list_moteur");

    marquechange();
}

function marquechange()
{
    console.log("MARQUE CHANGE");

    fillSelectMarque(vhcs_ar);

    modelechange();
}

function modelechange()
{
    console.log("MODELE CHANGE");

    fillSelectModele(vhcs_ar);

    versionchange();
}

function versionchange()
{
    console.log("VERSION CHANGE");

    fillSelectVersion(vhcs_ar);

    motorisationchange();
}

function motorisationchange()
{
    console.log("MOTORISATION CHANGE");

    fillSelectMotorisation(vhcs_ar);

    moteurchange();
}

function moteurchange()
{
    console.log("MOTEUR CHANGE");

    fillSelectMoteur(vhcs_ar);

    pagevhc();
}

function pagevhc()
{
    change_value = 0;
    document.getElementById("pm_user_titre_marque").innerHTML = marque_selected;
    document.getElementById("pm_user_titre_modele").innerHTML = modele_selected;
    document.getElementById("pm_user_titre_version").innerHTML = version_selected;

    fillVhcZone(vhcs_ar);
}

function fillVhcZone(vhcs)
{
    for(i in vhcs)
    {
        if(vhcs[i].marque    == marque_selected    &&
          vhcs[i].modele    == modele_selected    &&
          vhcs[i].version   == version_selected   &&
          vhcs[i].motorisation == motorisation_selected &&
          vhcs[i].moteur    == moteur_selected)
        {
            document.getElementById("pm_user_text").innerHTML = vhcs[i].text;
            //document.getElementById("pm_user_prix").innerHTML = vhcs[i].prix.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1\'') + "CHF";
            fillTableZone(vhcs[i].ch_ori, vhcs[i].ch_reprog, 
                          vhcs[i].nm_ori, vhcs[i].nm_reprog);
        }
    }
}

function fillTableZone(ch_ori, ch_reprog, nm_ori, nm_reprog)
{
    var vhcsTable = document.getElementById("pm_user_table");

    if(vhcsTable.rows.length == 0)
    {
        var vhcsTitreRow = vhcsTable.insertRow(0);
        vhcsTitreRow.insertCell(0).innerHTML = "";
        vhcsTitreRow.insertCell(1).innerHTML = "Origine";
        vhcsTitreRow.insertCell(2).innerHTML = "Reprogrammé";
        vhcsTitreRow.insertCell(3).innerHTML = "Gain";

        var vhcsChRow = vhcsTable.insertRow(1);
        vhcsChRow.insertCell(0).innerHTML = "Puissance";
        vhcsChRow.insertCell(1).innerHTML = ch_ori + "ch";
        vhcsChRow.insertCell(2).innerHTML = ch_reprog + "ch";
        vhcsChRow.insertCell(3).innerHTML = `+${ch_reprog - ch_ori}ch`;

        var vhcsNmRow = vhcsTable.insertRow(2);
        vhcsNmRow.insertCell(0).innerHTML = "Couple";
        vhcsNmRow.insertCell(1).innerHTML = nm_ori + "nm";
        vhcsNmRow.insertCell(2).innerHTML = nm_reprog + "nm";
        vhcsNmRow.insertCell(3).innerHTML = `+${nm_reprog - nm_ori}nm`;
    }
    else
    {
        vhcsTable.rows[1].cells[1].innerHTML = ch_ori + "ch";
        vhcsTable.rows[1].cells[2].innerHTML = ch_reprog + "ch";
        vhcsTable.rows[1].cells[3].innerHTML = `+${ch_reprog - ch_ori}ch`;
        vhcsTable.rows[2].cells[1].innerHTML = nm_ori + "nm";
        vhcsTable.rows[2].cells[2].innerHTML = nm_reprog + "nm";
        vhcsTable.rows[2].cells[3].innerHTML = `+${nm_reprog - nm_ori}nm`;
    }
}

function fillSelectMarque(vhcs)
{
    var marque_tmp = "";
    //console.log(vhcs[0].ma);

    if(marque_select.selectedIndex == -1)
    {
        marque_selected = vhcs[0].marque;
    }
    else
    {
        marque_selected = marque_select.options[marque_select.selectedIndex].value;
        change_value = 1;// Peu etre supprimer
    }

    removeAllOptions(marque_select);

    for(i in vhcs)
    {
        if(marque_tmp != vhcs[i].marque)
        {
            marque_tmp = vhcs[i].marque;
            if(marque_tmp == marque_selected)
            {
                addOption(marque_select, marque_tmp, marque_tmp, true);
                //marque_selected = marque_tmp;
            }
            else
            {
                addOption(marque_select, marque_tmp, marque_tmp, false);
            }
        }
    }
}

function fillSelectModele(vhcs){
    var modele_tmp = "";

    if(modele_select.selectedIndex == -1)
    {
        modele_selected = vhcs[0].modele;
    }
    else if(change_value == 1)
    {
        for(i in vhcs)
        {
            if(vhcs[i].marque == marque_selected)
            {
                modele_selected = vhcs[i].modele;
                break;
            }
        }
    }
    else
    {
        modele_selected = modele_select.options[modele_select.selectedIndex].value;
        change_value = 1;
    }

    removeAllOptions(modele_select);

    for (i in vhcs)
    {
        if (modele_tmp != vhcs[i].modele && marque_selected == vhcs[i].marque)
        {
            modele_tmp = vhcs[i].modele;
            if(modele_tmp == modele_selected)
            {
                addOption(modele_select, modele_tmp, modele_tmp, true);
                //modele_selected = modele_tmp;
            }
            else
            {
                addOption(modele_select, modele_tmp, modele_tmp, false);
            }
        }
    }
}

function fillSelectVersion(vhcs)
{
    var version_tmp = "";

    if(version_select.selectedIndex == -1)
    {
        version_selected = vhcs[0].version;
    }else if(change_value == 1)
    {
        for(i in vhcs)
        {
            if(vhcs[i].marque == marque_selected && vhcs[i].modele == modele_selected)
            {
                version_selected = vhcs[i].version;
                break;
            }
        }
    }
    else
    {
        version_selected = version_select.options[version_select.selectedIndex].value;
        change_value = 1;
    }

    removeAllOptions(version_select);

    for (i in vhcs)
    {
        if (version_tmp != vhcs[i].version && marque_selected == vhcs[i].marque && modele_selected == vhcs[i].modele)
        {
            version_tmp = vhcs[i].version;
            if(version_tmp == version_selected)
            {
                addOption(version_select, version_tmp, version_tmp, true);
                //version_selected = version_tmp;
            }
            else
            {
                addOption(version_select, version_tmp, version_tmp, false);
            }
        }
    }
}

function fillSelectMotorisation(vhcs)
{
    var motorisation_tmp = "";

    if(motorisation_select.selectedIndex == -1){

        motorisation_selected = vhcs[0].motorisation;
    }
    else if(change_value == 1)
    {
        for(i in vhcs)
        {
            if(vhcs[i].marque == marque_selected && vhcs[i].modele == modele_selected && vhcs[i].version == version_selected)
            {
                motorisation_selected = vhcs[i].motorisation;
                break;
            }
        }
    }
    else
    {
        motorisation_selected = motorisation_select.options[motorisation_select.selectedIndex].value;
        change_value = 1;
    }

    removeAllOptions(motorisation_select);

    for(i in vhcs)
    {
        if(motorisation_tmp != vhcs[i].motorisation && marque_selected == vhcs[i].marque && 
           modele_selected == vhcs[i].modele && version_selected == vhcs[i].version)
        {
            motorisation_tmp = vhcs[i].motorisation;
            if(motorisation_tmp == motorisation_selected)
            {
                addOption(motorisation_select, motorisation_tmp, motorisation_tmp, true);
                //motorisation_selected = motorisation_tmp;
            }
            else
            {
                addOption(motorisation_select, motorisation_tmp, motorisation_tmp, false);
            }
        }
    }
}

function fillSelectMoteur(vhcs)
{
    var moteur_tmp = "";

    if(moteur_select.selectedIndex == -1)
    {
        moteur_selected = vhcs[0].moteur;
    }
    else if(change_value == 1)
    {
        for(i in vhcs)
        {
            if(vhcs[i].marque == marque_selected && vhcs[i].modele == modele_selected && 
               vhcs[i].version == version_selected && vhcs[i].motorisation == motorisation_selected)
            {
                moteur_selected = vhcs[i].moteur;
                break;
            }
        }
    }
    else
    {
        moteur_selected = moteur_select.options[moteur_select.selectedIndex].value;
        change_value = 1;
    }

    removeAllOptions(moteur_select);

    for(i in vhcs)
    {
        if (moteur_tmp != vhcs[i].moteur && marque_selected == vhcs[i].marque && modele_selected == vhcs[i].modele &&
            version_selected == vhcs[i].version && motorisation_selected == vhcs[i].motorisation)
        {
            moteur_tmp = vhcs[i].moteur;
            if(moteur_tmp == moteur_selected)
            {
                addOption(moteur_select, moteur_tmp, moteur_tmp, true);
                //moteur_selected = moteur_tmp;
            }
            else
            {
                addOption(moteur_select, moteur_tmp, moteur_tmp, false);
            }
        }
    }
}

function removeAllOptions(selectbox){                           
    var i;
    for(i=selectbox.options.length-1;i>=0;i--)
    {
        selectbox.options.remove(i);
        selectbox.remove(i);
    }
}


function addOption(selectbox, value, text, selected){
    var opt = document.createElement("OPTION"); // comprendre le create option

    opt.value = value;
    opt.text = text;
    opt.selected = selected;

    selectbox.options.add(opt)
}

function printSelectBox(selectbox){
    console.log("CNT | INDEX | VALUE | TEXT | SELECTED");
    for(i=0 ; i < selectbox.length ; i++)
    {
        console.log(i, selectbox.options[i].index, selectbox.options[i].value, selectbox.options[i].text, selectbox.options[i].selected);
    }
}


