<?php
/**
 * Модуль взаимодействия
 */

/**
 * Получения токена
 */ 
function cdek_get_token(){
    $apiurl  = 'https://api.cdek.market/api/v1/auth/login';
    $api_key = get_option( 'cdek_settings_fields');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'api_key'=>$api_key,    
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = json_decode(curl_exec($ch),1);
    if( count($data)<=0 )
    {
        echo "Отправление не создано";
    }
    else
    {
        return $data;      

    } 

}

/**
 * Обновление токена
 *
 * @return void
 */
function cdek_refresh_token(){

    $apiurl  = 'https://api.cdek.market/api/v1/auth/refresh';
    $api_key = get_option( 'cdek_settings_fields');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
      //  'api_key'=>$api_key,    
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = json_decode(curl_exec($ch),1);
    if( count($data)<=0 )
    {
        echo "Отправление не создано";
    }
    else
    {
        dshow($data);
        

    }  
}

function cdek_get_products(){
    $apiurl  = 'https://api.cdek.market/api/v1/products';
    // $api_key = '21031_404b87q580X04pSrQvpNb1b4MQ530389';
    $ch = curl_init();
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
       // 'api_key'=>$api_key, 
          'page'   => 2,
          'pageSize' => 4
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = json_decode(curl_exec($ch),1);
    if( count($data)<=0 )
    {
        echo "Отправление не создано";
    }
    else
    {
        dshow($data);

    } 

}

function cdek_one_get_product_test_22(  $token, $post ) {    
    $ch = curl_init();
    $apiurl  = 'https://api.cdek.market/api/v1/products';
    curl_setopt($ch, CURLOPT_URL, $apiurl);
 
    $post = json_encode($post);
    $authorization = "Authorization: Bearer ".$token; 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

    $result = curl_exec($ch); 
    curl_close($ch); 
    return json_decode($result); 

    die();


 }

 /**
 * Импорт товаров
 */ 
function cdek_import_product( $list, $token ){
    $ch = curl_init();

    $apiurl  = 'https://api.cdek.market/api/v1/products/import';    
    $set_list = json_encode( $list );
    $authorization = 'Authorization: Bearer '.$token;   
  
    //dshow($set_list);   
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Content-Type: application/json', 
        $authorization, 
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $set_list );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = json_decode(curl_exec($ch),1);


    if( count($result)<=0 )
    {
        
        echo "<br>";
        echo "zero";
    }
    else
    {
        return $result;      

    } 

}

function cdek_get_product_from_cdek(){
    $curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => "your api goes here",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => array(
"Authorization: Bearer eyJ0eciOiJSUzI1NiJ9.eyJMiIsInNjb3BlcyI6W119.K3lW1STQhMdxfAxn00E4WWFA3uN3iIA"
  ),
 ));

$response = curl_exec($curl);
$data = json_decode($response, true);

echo $data;
}

/**
 * Функция настройки отправки товаров на СДЭК Маркет
 */
function cdek_get_category(){
    
 ?>      
    
      <h3>Выбор товаров для импорта на СДЭК.Маркет</h3>
      <form action="" method="POST" name="form_cdek_import" id="form_cdek_import">
      <table class="cdek_table">
        <thead>  
            <tr>
                <td class="cdek_table_td">ID</td>
                <td class="cdek_table_td">Наименование</td>
                <td class="cdek_table_td">
                    Выбрать
                </td>
                <!--
                <td class="cdek_table_td">Статус</td>            
                -->
            </tr>
        </thead>
        <tbody>
            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'product',
                'paged' => $paged,
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();	
            ?>

            <tr class="cdek_table_tr">
                <td class="cdek_table_td">
                    <?php echo the_ID()?>
                </td>
                <td class="cdek_table_td">
                    <?php echo the_title()?>
                </td>
                <td class="cdek_table_td cdek_checkbox">
                        <input type="checkbox" 
                            name="cdek_ids[]" 
                            value="<?php echo the_ID()?>"
                            id="<?php echo the_ID()?>"
                            data-product_id="<?php echo the_ID()?>"
                        >
                </td>
                <!--
                <td class="cdek_table_td">

                </td>
                -->
            
            </tr>          
            <?php           
                }
            }             
            wp_reset_postdata();           
            ?>
        </tbody>
    </table>  
    <p></p>  
    <input 
        type="button" 
        class="button" 
        id="cdek_import"
        value="Импортировать">
    </form>
<?php
}
?>