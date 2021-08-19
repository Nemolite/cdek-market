<?php
/**
 * Модуль работы с базами данных
 */

/**
 * Модуль сбора id для импорта
 */ 

add_action('wp_ajax_cdek_array_id', 'cdek_action_cdek_array_id'); 
function cdek_action_cdek_array_id(){
  
    if(isset($_POST)&&!empty($_POST)){
        $ids = $_POST;
        unset($_POST);
    }   

    $import_ids = array();
    foreach($ids as $key => $value){
        if($key=="amiron"){
            $import_ids = $value;
        }
    }
    
    $interaction = new WC_Cdek_Market_Interaction();

    //Получение токена
    $request =  cdek_get_token();
    $token = $request['access_token'];

    if( isset($import_ids)&&!empty($import_ids) ){
        foreach($import_ids as $product_id ){
          $list = $interaction->cdek_get_one_product( $product_id );
          $result = cdek_import_product( $list, $token );
        }  

    }  

    show($result);

    wp_die();
}
?>