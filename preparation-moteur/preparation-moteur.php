<?php
/*
 * Plugin Name: Préparation moteur
 * Plugin URI: https://www.canel.ch
 * Description: Plugin Wordpress. Permet d'afficher les propositions de préparation moteur. Fait pour GenoProg.
 * Version: 0.1b
 * Author: Rom1 <rom1@canel.ch>
 * Author URI: https://www.canel.ch
 * License: GPL3
 */

/* Définir les variable global */
global $pm_db_version;
$pm_db_version = "0.1";


/*************/
/* DATABASES */
/*************/
/* Créer les tables lors de l'activation du plugin */
register_activation_hook(__FILE__, "pm_init_database");
function pm_init_database()
{
	require_once("sql/pm_initdb.php");//Mettre avec un chemin absolu
    pm_create_db();
}
/* Supprimer les tables lors de la désactivation du plugin */
//register_deactivation_hook(__FILE__, "pm_remove_database");//Finir de tester et supprimer
function pm_remove_database()
{
	require_once("sql/pm_initdb.php");
}


/********************/
/* SCRIPTS CSS & JS */
/********************/
/* ADMIN ZONE */
add_action("admin_enqueue_scripts", "pm_admin_init_scripts");
function pm_admin_init_scripts()
{
	/* JAVASCRIPT */
	wp_register_script("pm-js-ajax", plugin_dir_url(__FILE__)."js/pm_ajax.js");
	wp_enqueue_script("pm-js-ajax");//Essayer de le mettre au plus près de la fonction php
	wp_register_script("pm-js-admin-marques", plugin_dir_url(__FILE__)."js/pm_admin_marques.js");
	wp_enqueue_script("pm-js-admin-marques");//Essayer de le mettre au plus près de la fonction php

	/* Exporter des variables dans JS */
	$pm_wp_path = array(
		'plugin' => plugin_dir_url(__FILE__)
	);
	wp_localize_script('pm-js-ajax', 'pm_wp_path', $pm_wp_path);


	/* STYLESHEETS */
	wp_enqueue_style("pm-main-css", plugin_dir_url(__FILE__)."css/pm_admin.css");
}
/* USER ZONE */
add_action("wp_enqueue_scripts", "pm_user_init_scripts");
function pm_user_init_scripts()
{
	/* JAVASCRIPT */
	wp_register_script("pm-js-ajax", plugin_dir_url(__FILE__)."js/pm_ajax.js");
	wp_enqueue_script("pm-js-ajax");//Essayer de le mettre au plus près de la fonction php
	wp_register_script("pm-js-menu-engine", plugin_dir_url(__FILE__)."js/pm_menu_engine.js");
	wp_enqueue_script("pm-js-menu-engine");//Essayer de le mettre au plus près de la fonction php

	/* Exporter des variables dans JS */
	$pm_wp_path = array(
		'plugin' => plugin_dir_url(__FILE__)
	);
	wp_localize_script('pm-js-ajax', 'pm_wp_path', $pm_wp_path);
	wp_localize_script('pm-js-menu-engine', 'pm_wp_path', $pm_wp_path);


	/* STYLESHEETS */
	wp_enqueue_style("pm-main-css", plugin_dir_url(__FILE__)."css/pm_user.css");
}


/******************/
/* USER INTERFACE */
/******************/
add_shortcode("preparation-moteur", "pm_user_interface");
function pm_user_interface()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_all.php");
}

add_shortcode("pm_user_menu_div", "pm_user_menu_div");
function pm_user_menu_div()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_menu_div.php");
}

add_shortcode("pm_user_main_div", "pm_user_main_div");
function pm_user_main_div()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_main_div.php");
}

add_shortcode("pm_user_titre_div", "pm_user_titre_div");
function pm_user_titre_div()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_titre_div.php");
}

add_shortcode("pm_user_table_div", "pm_user_table_div");
function pm_user_table_div()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_table_div.php");
}

add_shortcode("pm_user_prix_div", "pm_user_prix_div");
function pm_user_prix_div()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_prix_div.php");
}

add_shortcode("pm_user_text_div", "pm_user_text_div");
function pm_user_text_div()
{
	return file_get_contents(plugin_dir_url(__FILE__)."includes/pm_user_text_div.php");
}


/*******************/
/* ADMIN INTERFACE */
/*******************/
add_action("admin_menu", "pm_create_admin");
function pm_create_admin()
{
	add_menu_page(
		"Première page",	//Titre
		"Préparations moteurs",	//Libellé du menu
		"manage_options",	//Niveau de droit des utilisateurs
		"prep-mot",
		"pm_admin_toplevel"
	);
	add_submenu_page(
		"prep-mot",
		"Préparation moteur: Marques",
		"Marques",
		"manage_options",
		"pm-admin-marques",
		"pm_admin_marques"
	);
	add_submenu_page(
		"prep-mot",
		"Préparation moteur: Paramètres",
		"Paramètres",
		"manage_options",
		"pm-admin-sets",
		"pm_admin_settings"
	);
}

function pm_admin_toplevel()
{
	echo file_get_contents(plugin_dir_url(__FILE__)."includes/pm_admin_top.php");
}

function pm_admin_marques()
{
	echo file_get_contents(plugin_dir_url(__FILE__)."includes/pm_admin_marques.php");
}

function pm_admin_settings()
{
	echo file_get_contents(plugin_dir_url(__FILE__)."includes/pm_admin_settings.php");
}

?>
