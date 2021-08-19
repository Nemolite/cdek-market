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


  echo '<div class="wrap">
	<h1>' . get_admin_page_title() . '</h1>
  <h3>Настройка плагина</h3>
	<form method="post" action="options.php">';
 
		settings_fields( 'cdek_settings' ); // true_slider_settings название настроек
		do_settings_sections( 'cdek' ); // true_slider ярлык страницы, не более
		submit_button(); // функция для вывода кнопки сохранения
 
	echo '</form></div>';

    $interaction = new WC_Cdek_Market_Interaction();
    echo '<div class="wrap woocommerce">'; 
    
        cdek_get_category();
        // dshow( $interaction->cdek_get_data() ); 

        //Получение токена
      //  $request =  cdek_get_token();
      //  $token = $request['access_token'];
      //  echo $token;

        // Обновление токена
        // cdek_refresh_token();

        // Получение продуктов
        // cdek_get_products();
      //  dshow( $interaction->cdek_get_one_product() ); 
      //  $list = $interaction->cdek_get_one_product();
      //  $result = cdek_import_product( $list, $token );

      //  dshow( $result );



    echo '</dir>';
  }

add_action( 'admin_init',  'cdek_fields' );  

function cdek_fields(){

  // регистрируем опцию
	register_setting(
		'cdek_settings', // true_slider_settings название настроек из предыдущего шага
		'cdek_settings_fields', // number_of_slider_slides ярлык опции
		'' // функция очистки
	);

  register_setting(
		'cdek_settings', // true_slider_settings название настроек из предыдущего шага
		'cdek_category_pole', // number_of_slider_slides ярлык опции
		'' // функция очистки
	);

  add_settings_section(
		'cdek_settings_section_id', // slider_settings_section_id ID секции, пригодится ниже
		'', // заголовок (не обязательно)
		'', // функция для вывода HTML секции (необязательно)
		'cdek' // ярлык страницы
	);

  add_settings_section(
		'cdek_category_section_id', // slider_settings_section_id ID секции, пригодится ниже
		'', // заголовок (не обязательно)
		'', // функция для вывода HTML секции (необязательно)
		'cdek' // ярлык страницы
	);

  add_settings_field(
		'cdek_settings_fields',
		'Токен',
		'cdek_token_field', // название функции для вывода
		'cdek', // ярлык страницы
		'cdek_settings_section_id', // // ID секции, куда добавляем опцию
		array( 
			'label_for' => 'cdek_settings_fields',
			'class' => '', // для элемента <tr>
			'cdek_token' => 'cdek_settings_fields', // любые доп параметры в колбэк функцию
		)
	);

  add_settings_field(
		'cdek_category_pole',
		'Категория (по CDEK.Market)',
		'cdek_category_field', // название функции для вывода
		'cdek', // ярлык страницы
		'cdek_category_section_id', // // ID секции, куда добавляем опцию
		array( 
			'label_for' => 'cdek_category_pole',
			'class' => '', // для элемента <tr>
			'cdek_category' => 'cdek_category_pole', // любые доп параметры в колбэк функцию
		)
	);
}

function cdek_token_field( $args ){
	// получаем значение из базы данных
  $value_token = get_option( $args[ 'cdek_token' ] );

  printf(
		'<input class="cdek_token_input" type="text" id="%s" name="%s" value="%s" />',
		esc_attr( $args[ 'cdek_token' ] ),
		esc_attr( $args[ 'cdek_token' ] ),
		$value_token
	);
}

function cdek_category_field( $args_cat ){
	// получаем значение из базы данных
	$value_category = get_option( $args_cat[ 'cdek_category' ] );

  printf(
		'<input class="cdek_category_input" type="text" id="%s" name="%s" value="%s" />',
		esc_attr( $args_cat[ 'cdek_category' ] ),
		esc_attr( $args_cat[ 'cdek_category' ] ),
		$value_category
	);
}
 
?>