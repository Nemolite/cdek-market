<?php
/**
 * Создание пункта Меню
 */
if ( is_admin() ) {
    add_action( 'admin_menu', 'add_cdek_menu_entry', 100 );
  }
  
  function add_cdek_menu_entry() {
    
    $page_title = __( 'CDEK.Market' );
    $menu_title = __( 'CDEK.Market' );
    $capability = 'manage_woocommerce';
    $menu_slug = 'cdek_menu';
    $function = 'register_cdek_menu_admin';
    $icon_url = 'dashicons-controls-repeat';
    $position = 38;

    add_menu_page ( 
        $page_title, 
        $menu_title, 
        $capability, 
        $menu_slug, 
        $function, 
        $icon_url, 
        $position 
    );
  }
  
  function register_cdek_menu_admin() {

    $interaction = new WC_Cdek_Market_Interaction();
    echo '<div class="wrap woocommerce">';                  
        $interaction->cdek_get_data(); 
    echo '</dir>';
  }

?>