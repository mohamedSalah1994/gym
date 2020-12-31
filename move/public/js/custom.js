$(document).ready(function(){
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    
    $('#loginForm_submit').submit(function(e){
        $(".main_sppiner").removeClass('hideloader');
        $('#login_errors').html('').hide();
        $('#login_success').html('').hide();
        e.preventDefault();
        var form = $(this);
        var action = form.attr( 'action' );
        var identity = $("input[name='identity']",this).val();
        var password = $("input[name='password']",this).val();
        var remember = $("input[name='remember']",this).is(':checked');
        var submit = $("input[name='submit']",this);
        $.ajax({
         type:'POST',
         url:action,
         data:{password : password , identity : identity , remember : remember},
         success:function(data){
             $(".main_sppiner").addClass('hideloader');
             if(data.status == "failed"){
                 $htmlError = '';
                 data.errors.forEach((error)=>{
                           $htmlError += '<div>'+error+'</div>';          
                                     });
                 $('#login_errors').html($htmlError).show();
             } else if(data.status == "done"){
                 form.trigger("reset");
                 submit.prop('disabled', true);
                 $('#login_success').html(data.message).show();
                 setTimeout(function(){
                     window.location.href = '/';
                 },2000);
             }
            console.log(data);
         }
      });
    });
    $('#signup_form_submit').submit(function(e){
        $(".main_sppiner").removeClass('hideloader');
        $('#signup_form_errors').html('').hide();
        $('#signup_form_success').html('').hide();
        e.preventDefault();
        var form = $(this);
        var action = form.attr( 'action' );
        var name = $("input[name='name']",this).val();
//        var email = $("input[name='email']",this).val();
        var identity = $("input[name='identity']",this).val();
        var mobile = $("input[name='mobile']",this).val();
        var password = $("input[name='password']",this).val();
        var birth = $("input[name='birth']",this).val();
        var submit = $("input[name='submit']",this);
        $.ajax({
         type:'POST',
         url:action,
         data:{name : name , identity : identity , birth : birth , mobile : mobile , password : password},
         success:function(data){
             $(".main_sppiner").addClass('hideloader');
             if(data.status == "failed"){
                 $htmlError = '';
                 data.errors.forEach((error)=>{
                           $htmlError += '<div>'+error+'</div>';          
                                     });
                 $('#signup_form_errors').html($htmlError).show();
             }
             else if(data.status == "done"){
                 form.trigger("reset");
                 submit.prop('disabled', true);
                 $('#signup_form_success').html(data.message).show();
                 setTimeout(function(){
                     window.location.href = '/';
                 },2000);
             }
            console.log(data);
         }
      });
    });
    $(".bookplannow").click(function(e){
         e.preventDefault();
         $(".main_sppiner").removeClass('hideloader');
         var dataPlan = $(this).attr('data-plan');
         var action = $(this).attr('action');
           $.ajax({
             type:'POST',
             url:action,
             data:{ plan : dataPlan},
             success:function(data){
                 $(".main_sppiner").addClass('hideloader');
                 if(data.status == "failed"){
                     $htmlError = '';
                        data.errors.forEach((error)=>{
                           $htmlError += '<p class="errormessagestyle">'+error+'</p>';          
                                     });
                     $('#error_response_mess').html($htmlError);
                     $('#json_reponses').modal('show');
                 }else if(data.status == "done"){
                      window.location.href = data.message
                 }
                 console.log(data);
             }
      });
    });
    $(".cancelBook").click(function(e){
         e.preventDefault();
         $(".main_sppiner").removeClass('hideloader');
         var dataBook = $(this).attr('data');
         var action = $(this).attr('action');
         var thisme = $(this);
           $.ajax({
             type:'POST',
             url:action,
             data:{ booking : dataBook},
             success:function(data){
                 $(".main_sppiner").addClass('hideloader');
                 if(data.status == "done"){
                      thisme.after(data.text).remove();
                 }
                 console.log(data);
             }
      });
    });
    

});