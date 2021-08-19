<?php
/**
* Plugin Name: cdek-market (cdek)
* Plugin URI: https://github.com/Nemolite/cdek-market
* Description: Взаимодействие с торговой площадкой СДЭК.Маркет 
* Version: 1.0.0
* Author: Nemolite
* Author URI: http://vandraren.ru/
* License: GPL2
*/

defined('ABSPATH') || exit;

/**
 * Подключение скриптов и стилей
 */

function script_and_style_cdek(){
  wp_enqueue_style( 'cdek-style',  plugins_url('assets/css/style.css', __FILE__));
  wp_enqueue_script( 'cdek-script', plugins_url('assets/js/cdek.js', __FILE__),array(),'1.0.0','in_footer');
}
add_action( 'wp_enqueue_scripts', 'script_and_style_cdek' );

/**
 * Подключение скриптов и стилей для админки
 */

function script_and_style_cdek_admin(){
	wp_enqueue_style( 'cdek-adminatyle',  plugins_url('assets/css/style-admin.css', __FILE__));
	wp_enqueue_script( 'cdek-adminscript', plugins_url('assets/js/cdek-admin.js', __FILE__),array(),'1.0.0','in_footer');

	wp_localize_script( 'cdek-adminscript', 'myajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  }
  add_action( 'admin_enqueue_scripts', 'script_and_style_cdek_admin' );

 /**
  * Helper
  */ 

 function dshow($array) {
   echo "<pre>";
   print_r($array);
   echo "</pre>";

 }

 /**
 * Модуль создания меню
 */
require "inc/menu.php";  

/**
 * class WC_Cdek_Market_Interaction
 */
require "inc/class-cdek.php";

/**
 * Модуль взаимодействия
 */
require "inc/interaction.php";

/**
 * Модуль работы с базами данных
 */
require "inc/database.php";

/**
 * Для того чтобы класс был виден в системе
 *
 * @param array $methods
 * @return array $methods
 */
/*
function cdek_add_shipping_class( $methods ) {
	$methods[ 'cdek_market' ] = 'WC_Cdek_Market_Interaction'; 
	return $methods;
}
add_filter( 'woocommerce_shipping_methods', 'cdek_add_shipping_class' );
*/
?>