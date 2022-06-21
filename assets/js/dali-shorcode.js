(function($) {
    $(document).ready(function() {
        let selected = null;
        $(document).on('click', '.dali-template-selector', function(event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();   
              var _this = $(this),
                 template_id = _this.data('id');       
                 
                 $('input[name=dali_home_id]').val(template_id);
                 if(selected){
                    if( selected === $(this)){
                      return;
                    }else {
                      selected.removeClass('active');
                      selected.text('SELECT');
                      selected = $(this);
                      selected.addClass('active');
                      selected.text('active');
                    }
                  }else {
                    selected = $(this);
                    selected.addClass('active');
                    selected.text('active');
                }                    
        });  
    });
 }(jQuery));