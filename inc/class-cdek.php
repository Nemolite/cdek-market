<?php

if ( ! class_exists( 'WC_Cdek_Market_Interaction' ) ) {
 
	class WC_Cdek_Market_Interaction {

        public function cdek_get_data() {                    
            global $post;

            $query = new WP_Query( [
              'post_type'              => array( 'product' ),
              'post_status'            => array( 'publish' ),
              'nopaging'               => true,
            ] );
       
    
            $list = array();
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    //the_title();
                    $list[] = get_the_ID();
                }
            } else {
                // Постов не найдено
            }
            
            wp_reset_postdata();
        
            return $list;
        } //cdek_get_data

        public function cdek_get_one_product($product_id){
           // $product_id = 11656;
            $list = array();
            $_product = wc_get_product( $product_id );


            $list['offer_id'] = $_product->get_id();
           

            $list['status'] = "A"; // A-aktiv
            $list['price'] = $_product->get_price();
           
            $list['amount'] =$_product->get_stock_quantity();
            $list['name'] = $_product->get_name();
            $list['shortname'] = $_product->get_name();
            $list['short_description'] = $_product->get_short_description();
            $list['full_description']= $_product->get_description();;            
            $list['weight'] =$_product->get_weight();
            $list['weight_unit'] = "kg";
            $list['dimension_unit'] = "mm";            
            $list['length'] =$_product->get_length();
            $list['width'] = $_product->get_width();
            $list['height'] =$_product->get_height();

            $cat_num = intval(get_option( 'cdek_category_pole'));

            $list['categories'] = [
                $cat_num
                ]; // 50 - спорттовары СДЭК Маркет
         //   $img_id = get_post_meta($product_id ,'_thumbnail_id',true);
           // $img_id = $product->get_image_id();

           $attachment_ids = $_product->get_gallery_image_ids();

           $list_images = array();

           $idx = 0;
           foreach( $attachment_ids as $attachment_id ) 
               {    

                $list_images[]  = wp_get_attachment_url( $attachment_id ); 
                $idx++;
                if($idx>=5){
                    break;
                }
               } 


           // $list['pictures'] = [wp_get_attachment_url( $img_id )];
           $list['pictures'] = $list_images;
            $list['taxes'] = "none"; // нет налогов


            $delever = [
                "use_product_dimensions"=> true,
                "box_length"=> 0,
                "box_width"=> 0,
                "box_height"=> 0,
                "min_items_in_box"=> 0,
                "max_items_in_box"=> 0
            ];

            $list['delivery_options'] = (object)$delever; 
            
         $products['products'] = array((object)$list);
         return $products;

        }
    } // class   
} // if
?>