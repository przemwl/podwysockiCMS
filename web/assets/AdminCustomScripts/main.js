jQuery(document).ready(function(){
   
   $('.field-substitution .disappearing-field .btn').click(function(){
       $(this).parent().css("display", "none");
       $(this).parent().parent().find('.editing-field').css("display","block");
       $(this).parent().parent().find('.editing-field input').focus();
   });
   
});
