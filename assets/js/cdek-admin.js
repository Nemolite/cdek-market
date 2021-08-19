( function( $ ) {

    $('#cdek_cat').on('change', function() { 
                        
        let catid = $('#cdek_cat').val();       
       
        let catData =  {  
             action: 'cdek_get_products',   
             catid: catid,                            
           };  
           
             $.ajax({
                  url:myajax.ajaxurl, 
                  data:catData,                       
                  type:'POST',  
                  success:function(request){                                
   
                  }          
             });
    });

    
    $('#cdek_import').on('click', function(e) {
      e.preventDefault();
      
      // var amiron = { 'cdek_ids[]' : []};
      var amiron = [];;
      $(`.cdek_checkbox`).each(function (index, element) { 
      
        if($( element ).children("input").is(':checked')){
          let checkboxer = $( element ).children("input").attr("data-product_id");       
          amiron.push( checkboxer );
        }
      
       
      });
      
      let cdekData =  {  
        action: 'cdek_array_id',   
        amiron: amiron,               
      };  

      $.ajax({
        url:myajax.ajaxurl, 
        data: cdekData,                     
        type:'POST',  
        success:function(request){                                
          console.log(request);
        }          
   });

     
    });

} )( jQuery );