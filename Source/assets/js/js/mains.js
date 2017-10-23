
 
 function initialize(id) {
	 //alert(id);
	 var cntry = document.getElementById('countryin').value;
	
	 var optionsAuto = {
		 //types: ['address'],
		 componentRestrictions: {
			 country: cntry
			 }
		};
		
		var input = document.getElementById(id);
		var autocomplete = new google.maps.places.Autocomplete(input, optionsAuto);
		// console.log(autocomplete);
		//var autocomplete1 = new google.maps.places.Autocomplete(input, options);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var placeA = autocomplete.getPlace();
			var latLong = autocomplete.getPlace().geometry.location;
			var js=JSON.stringify(latLong);
			var par=JSON.parse(js);
			document.getElementById('driver_lat').value=par.lat;
			document.getElementById('driver_lng').value=par.lng;
			// document.getElementById('pickup_lat').value=par.lat;
			// document.getElementById('pickup_lng').value=par.lng;
			});
	}
  function initialize_hour(id) {
	  //alert(id);
	  var cntry = document.getElementById('countryin').value;
	  var optionsAuto = {
		  //types: ['address'],
		  componentRestrictions: {
			  country: cntry
			  }
			  };
			  var input = document.getElementById(id);
			  var autocomplete = new google.maps.places.Autocomplete(input, optionsAuto);
			  // console.log(autocomplete);
			  //var autocomplete1 = new google.maps.places.Autocomplete(input, options);
			  google.maps.event.addListener(autocomplete, 'place_changed', function () {
				  var placeA = autocomplete.getPlace();
				  var latLong = autocomplete.getPlace().geometry.location;
				  var js=JSON.stringify(latLong);
				  var par=JSON.parse(js);
				  document.getElementById('driver_lat_hour').value=par.lat;
				  document.getElementById('driver_lng_hour').value=par.lng;
				  // document.getElementById('pickup_lat').value=par.lat;
				  // document.getElementById('pickup_lng').value=par.lng;
				  });
	}
	function initializes(id) {
		//alert(id);
		var cntry = document.getElementById('countryin').value;
		var optionsAuto = {
			//types: ['address'],
			componentRestrictions: {
				country: cntry
				}
				};
				var input = document.getElementById(id);
				var autocomplete = new google.maps.places.Autocomplete(input, optionsAuto);
				// console.log(autocomplete);
				//var autocomplete1 = new google.maps.places.Autocomplete(input, options);
				google.maps.event.addListener(autocomplete, 'place_changed', function () {
					var placeA = autocomplete.getPlace();
					var latLong = autocomplete.getPlace().geometry.location;
					var js=JSON.stringify(latLong);
					var par=JSON.parse(js);
					//document.getElementById('driver_lat').value=par.lat;
					// document.getElementById('driver_lng').value=par.lng;
					document.getElementById('drop_lat').value=par.lat;
					document.getElementById('drop_lng').value=par.lng;
					});
	}
	// google.maps.event.addDomListener(window, 'load', initialize);
	
	$(document).ready(function(){
		 $('.loader').hide();
		$.ajax({
			type: "POST",
			url:base_url+'callmycab/check_logged_user',
			cache: false,
			success: function(data){
				if(data=='driver')
				{
					$('.book-scn-tab').hide();
				}
			}
		}); 
	});
	$(document).ready(function(){
		$('#success_psw').hide();
		$('#confirm_psw').hide();
		$('#current_psw').hide();
		$('#error_psw').hide();
		$('#success_contact').hide();
		$('#error_div').hide();
		$('#success_div').hide();
		
		$(".signup_logg").click(function(){
			if ($('#log_sign').parsley().validate() ) {
				var value =$("#log_sign").serialize() ;
				$.ajax({
					url:base_url+'callmycab/userlogin',
					type:'post',
					data:value,
					success:function(result){
						var username = result;
						if(result==1){
							$("#error_msg").html('<p class="error">Please enter a correct username or password</p>');
							setTimeout(function(){$("#error_msg").hide(); $(".cl-mdl").click();}, 3000);
						}else{
							//$('.logout2').html(logout);
							if(result=="driver"){
								window.location = base_url+"callmycab/account";
								}else{
									$("#error_msg").html('<p class="error">Login success</p>');
									$('<li id="logged" class="active check_test"><a href="'+base_url+'callmycab/account"><span><img src="'+base_url+'assets/img/home/m-1.png"/> </span><br>'+username+'</a></li><li><a href="'+base_url+'callmycab/logout"><span><img src="'+base_url+'assets/img/home/m-5.png"/> </span><br>Logout </a></li>').appendTo('#logged_ul');
									$('#notLogged').hide();
									setTimeout(function(){$("#error_msg").hide(); $(".cl-mdl").click();}, 1000);
								} 
						} } 
				}); 
			} 
		});



$("#save_details").click(function(){

	if ($('#account_dtls').parsley().validate() ) {	

	 var value =$("#account_dtls").serialize() ;

	$.ajax({

	url:base_url+'callmycab/contact',

	type:'post',

	data:value,

	success:function(result){

		if(result=='1'){

			$('#error_div').hide();

			$('#success_div').show();

			setTimeout(function(){ $('#success_div').hide();}, 3000);

		 }else{

			 $('#error_div').show();

			setTimeout(function(){ $('#error_div').hide();}, 3000);

		 }

	}

	});



} });




$("#callback_button").click(function(){

	if ($('#callback_form').parsley().validate() ) {	

	 var value =$("#callback_form").serialize() ;

	$.ajax({

	url:base_url+'callmycab/call_back_func',

	type:'post',

	data:value,

	success:function(result){

		if(result=='1'){

			 
			 $(".test11").html('<p class="error">Success!!!</p>');

			setTimeout(function(){ $('.cl-mdl').click();}, 3000);

		 }else{

			 $(".test11").html('<p class="error">Error!!!</p>');
		setTimeout(function(){ $('.cl-mdl').click();}, 3000);

		 }

	}

	});



} });


	$("#userreg").click(function(){
		if ($('#user_reg').parsley().validate() ) {
			var username = $('#signup-username').val();
			$('#otp-user').val(username);
			  
			  $('.loader').show();
			var value =$("#user_reg").serialize() ;
			$.ajax({
				url:base_url+'callmycab/sign_up',
				type:'post',
				data:value,
				success:function(res){
					res=res.trim();
					//alert(res);
					 $('.loader').hide();
					var username=res;
					if(res==3){
						$(".test12").html('<p class="error">Username Already Exist!!!</p>');
					}
					else if(res==4){
						$(".test12").html('<p class="error">Email Already Exist!!!</p>');
						setTimeout(function(){$(".test11").hide(); }, 3000);
					}else if(res==5){
						$(".test12").html('<p class="error">Mobile Number Already Exist!!!</p>');
						setTimeout(function(){$(".test11").hide(); }, 3000);
					}else if(res==2){
							$(".test12").html('<p class="error">Erorr !!!</p>');
							setTimeout(function(){$(".test11").hide(); }, 3000);
					}else if(res=="mail_smtp_incorrect"){
							
								$(".test12").html('<p class="error">Smtp error, please provide valid smtp details !!!</p>');
								setTimeout(function(){$(".test12").hide(); }, 5000);
					}else{
					
						if(res=='verify'){
							
							$(".test12").html('<p class="success">Please check your mail for verification OTP !!!</p>');
							setTimeout(function(){
								$(".test12").hide();
								$(".cl-mdl").click();
								$('#myModal').modal('show');
								}, 3000);
						}else{
							if(res=='driver'){
								$(".test12").html('<p class="success">User Registered Successfully</p>');
								setTimeout(function(){
									window.location = base_url+'callmycab/account';
									}, 3000);
							}else if(res=='user'){
								$(".test12").html('<p class="success">User Registered Successfully</p>');
								$('<li id="logged" class="active check_test"><a href="'+base_url+'callmycab/account"><span><img src="'+base_url+'assets/img/home/m-1.png"/> </span><br>'+username+'</a></li><li><a href="'+base_url+'callmycab/logout"><span><img src="'+base_url+'assets/img/home/m-5.png"/> </span><br>Logout </a></li>').appendTo('#logged_ul');
								$('#notLogged').hide();
							}else if(res==username){
								$(".test12").html('<p class="success">User Registered Successfully</p>');
								$('<li id="logged" class="active check_test"><a href="'+base_url+'callmycab/account"><span><img src="'+base_url+'assets/img/home/m-1.png"/> </span><br>'+username+'</a></li><li><a href="'+base_url+'callmycab/logout"><span><img src="'+base_url+'assets/img/home/m-5.png"/> </span><br>Logout </a></li>').appendTo('#logged_ul');
								$('#notLogged').hide();
							}else{
								$(".test12").html('<p class="success">Error in Submission</p>');
								setTimeout(function(){$(".test11").hide(); }, 3000);
							}
						}}}
				});
			}
		});



$("#verify_otp").click(function(){

	if ($('#otp_verification').parsley().validate() ) {	

var value =$("#otp_verification").serialize() ;

$.ajax({

url:base_url+'callmycab/otp_verify',

type:'post',

data:value,

success:function(result){
var username=result;
	 if(result == 1 || result == 3)

	 {

$("#error_msgs").html('<p class="error">An error occured!!!</p>');

setTimeout(function(){$("#error_msgs").hide(); $(".cl-mdl").click();}, 3000);
 $(".cl-mdl").click();
	 }
	else if(result=='driver'){

$(".test11").html('<p class="success">User Registered Successfully</p>');
 
setTimeout(function(){ 
	window.location = base_url+'callmycab/account';
}, 3000);
} 
else{
	  $(".cl-mdl").click();
	  $('<li id="logged" class="active check_test"><a href="'+base_url+'callmycab/account"><span><img src="'+base_url+'assets/img/home/m-1.png"/> </span><br>'+username+'</a></li><li><a href="'+base_url+'callmycab/logout"><span><img src="'+base_url+'assets/img/home/m-5.png"/> </span><br>Logout </a></li>').appendTo('#logged_ul');
 $('#notLogged').hide();

}
	

} }); } });



$( ".point_to_point" ).click(function() {

 var access = true;
 var fetch = $(this).data("validate");
 
 $('.'+fetch).each(function() {
 	var bb=$(this).attr('id');
	var v = $(this).val();
    if(v == null) v='';
 	if((v.replace(/\s+/g, '')) == '') {
  		access = false;
		 $("#"+bb).addClass("error-border");
 		}
 	else {
 		  $("#"+bb).removeClass("error-border");
 		}
 	});

 if(access) {

  	if(fetch=='first'){
  		var a=  $( ".pickup_areas" ).val();
			   var b=  $( ".drop_areas" ).val();
			  
			 if(a==b){
				 swal("Please select different pickup and drop areas")
				   $( ".pickup_areas" ).val("");
				      $( ".drop_areas" ).val("");
			 }else{

			var ress='second';
 			var next='menus1';
			var last='homes';
			var shift=$('#pickup_time').val();
			var pick_lat=$('#driver_lat').val();
			var pick_lng=$('#driver_lng').val();
			var drop_lat=$('#drop_lat').val();
			var drop_lng=$('#drop_lng').val();

			 $.ajax({	
			 type: "POST",
   			url:base_url+'callmycab/fetch_car',
			data: {type:'Point to Point Transfer',shift:shift,pick_lat:pick_lat,pick_lng:pick_lng,drop_lat:drop_lat,drop_lng:drop_lng},
			 cache: false,
		 	 success: function(datas){
				 	 obj = JSON.parse(datas);

				    $('.append_val').html('');
				    $.each(obj, function( index, value ) {					   
 					$('<div class="form-group"><div class="radio"><label><input type="radio" name="taxi_type" value="'+value['cartype']+'"  class="second"><span><img src="'+value['car_image']+'"/></span><span>'+value['cartype']+'</span><span class="fre-det-mn">'+value['total_rate']+'</span></label></div></div><input type="hidden" value='+value['timetype']+' name="timetype" id="timetype"><input type="hidden" value='+value['total_dist']+' name="distance" id="total_dis"><input type="hidden" value='+value['total_rate']+' name="amount" id="total_rate">').appendTo(".append_val");
 					$('#dist').html('Distance: '+value['total_dist']+'KM');
				 	});
				  } });
			}
		 }else if(fetch=='second')
 			{
			 if($(':radio[name=taxi_type]:checked').length>0){
		var ress='third';
			var next='menus2';
			var last='menus1';
			
			  
	} else {
		swal("SELECT CAR TYPE");
		 
			}
			}

		    $('#'+ress).addClass("active");
			$('#'+next).addClass("active");
			$('#'+next).addClass("in");
 		    $("#"+fetch).removeClass("active");
			$("#"+last).removeClass("active");
			$("#"+last).removeClass("in");
 			
 			if(fetch=='third')
			 {
				 $.ajax({
 				 type: "POST",
 				 url:base_url+'callmycab/check_logged_in',
 				 cache: false,
 				 success: function(data){
 				 	
 				if(data==0)
					{  
  					$('#myModallogin').modal('show');
				 } else{
					var value=$('#myForm').serialize();

	 	  	$.ajax({

			 type: "POST",
    		 url:base_url+'callmycab/book_point',
			 data: {value},
			 cache: false,
		 	 success: function(data){
				if(data!=0)
				{
					window.location.href = base_url+'Payment/index/'+data;
				}
			 

			  }

		});
				}
			 

			  }

		});
		

			 }

			  

		//return;

	}

	else {

	// $("#"+bb).removeClass("error-border");

		//$("html, body").animate({ scrollTop: $('.has-error').offset().top - 50 }, "slow");

	}

	 

	});





$( ".hourly" ).click(function() {

 var access = true;

 

  var fetch = $(this).data("validate");

 //alert(fetch);

	$('.'+fetch).each(function() {

		
var bb=$(this).attr('id');
		var v = $(this).val();

//alert(v);

		if(v == null) v='';

		if((v.replace(/\s+/g, '')) == '') {

			//alert('e');

			access = false;

			// $(this).parents(".form-group").addClass("has-error");

			 $("#"+bb).addClass("error-border");

		}

		else {

			 $("#"+bb).removeClass("error-border");

			//alert('no');

		}

	});

	if(access) {

		//alert('return');

		if(fetch=='firsts')

		{

			 

			var ress='seconds';

			var next='menusss1';

			var last='homesss';

			var shift=$('#pickup_time_hour').val();

			var pick_lat=$('#driver_lat').val();

			var pick_lng=$('#driver_lng').val();

			var hour_package=$('#hour_package').val();

			

			 

			$.ajax({	

			 type: "POST",

			url:base_url+'callmycab/fetch_car_search',

			data: {type:'Hourly Rental',shift:shift,pick_lat:pick_lat,pick_lng:pick_lng,hour_package:hour_package},

			 cache: false,

		 	 success: function(datas){
						 
				 	 obj = JSON.parse(datas);
					 if(obj==""){
						swal("No Car Found");
					 $('#homesss').addClass("active");
					 $('#homesss').addClass("in");
					  $("#menusss1").removeClass("active");
					  $("#menusss1").removeClass("in");
					  return;
					}else{

				  $('.append_val_hour').html('');

				  $.each(obj, function( index, value ) {					   

  					  $('<div class="form-group"><div class="radio"><label><input type="radio" name="hour_taxi_type" value="'+value['cartype']+'"  class="seconds"><span><img src="'+value['car_image']+'"/></span><span>'+value['cartype']+'</span><span class="pr-car-nw">'+value['standardrate']+'</span></label></div></div><input type="hidden" value='+value['timetype']+' name="timetype" id="timetype">').appendTo(".append_val_hour");

					 $('#distance_hr').html('Distance: '+value['total_dist']+'KM');

				 });

			  }
			 }

		});

			

		}else if(fetch=='seconds')

			{
 if($(':radio[name=hour_taxi_type]:checked').length>0){
		var ress='thirds';

			var next='menusss2';

			var last='menusss1';

			
			  
	} else {
		alert("SELECT CAR TYPE");
		 
			}
			
		}

		    $('#'+ress).addClass("active");

			$('#'+next).addClass("active");

			$('#'+next).addClass("in");

			

            $("#"+fetch).removeClass("active");

			 $("#"+last).removeClass("active");

			  $("#"+last).removeClass("in");

			  

			 if(fetch=='thirds')

			 {
$.ajax({

			 type: "POST",

			url:base_url+'callmycab/check_logged_in',

			 
			 cache: false,

		 	 success: function(data){

		 	 	 
		 	 	 

				if(data==0)
				{  
 
					  $('#myModallogin').modal('show');
					 
					 
				} else{
						
				  var value=$('#hourlyform').serialize();

	 	  //alert(value);

		 

		 $.ajax({

			 type: "POST",

			url:base_url+'callmycab/book_hourly',

			data: {value},

			 cache: false,

		 	 success: function(data){

				if(data!=0)
				{
					window.location.href = base_url+'Payment/index/'+data;
				}
  }

		});
				}
			 

			  }

		});
		

			 }

			  

		//return;

	}


	else {

		 //$("#"+bb).removeClass("error-border");

		//$("html, body").animate({ scrollTop: $('.has-error').offset().top - 50 }, "slow");

	}

	 

	});





//validation



/*

  var navListItems = $('ul.setup-panels li a'),

      allWells = $('.setup-content'),

      allNextBtn = $('.nextBtn');



  allWells.hide();



  navListItems.click(function (e) {

    e.preventDefault();

    var $target = $($(this).attr('href')),

        $item = $(this);



    if (!$item.hasClass('disabled')) { 

      navListItems.removeClass('btn-default').addClass('btn-primary');

      $item.addClass('btn-default');

      allWells.hide();

      $target.show();

      $target.find('input:eq(0)').focus();

    }

  });



  allNextBtn.click(function(){

    var curStep = $(this).closest(".setup-content"),

      curStepBtn = curStep.attr("id"),

      nextStepWizard = $('ul.setup-panels li a[href="#' + curStepBtn + '"]').parent().next().children("a"),

      curInputs = curStep.find("input[type='text'],input[type='url'],input[type='password'],input[type='email'],textarea[textarea]"),

      isValid = true;



    $(".form-group").removeClass("has-error");

    for(var i=0; i<curInputs.length; i++){

      if (!curInputs[i].validity.valid){

        isValid = false;

        $(curInputs[i]).closest(".form-group").addClass("has-error");

      }

    }

//alert(isValid);

/*mycode

    if(curStepBtn=="step-1" && isValid==true){

      var mysqlDetails=$('#Values').serialize();

        $('.loader').show();

          $.ajax({

            url:'dbconnect.php',

            type:'post',

            data:mysqlDetails,

            success:function(result){

              $('.loader').hide();

              if(result=="Success"){ 

			  

			 

                isValid = true;

                if(isValid)

                  nextStepWizard.removeAttr('disabled').trigger('click');

              }else{

                isValid = false;

                $('.message').html('<br><div class="label label-danger">Could not connect to MYSQL!</div>');

              } 



            }

          });

    }else{

      if (isValid)

        nextStepWizard.removeAttr('disabled').trigger('click');

    }



    if(curStepBtn=="step-4" && isValid==true){

      var db_host=$('#db_host').val();

      var db_name=$('#db_name').val();

      var db_username=$('#db_username').val();

      var db_password=$('#db_password').val();



      var smtp_host=$('#smtp_host').val();

      var smtp_username=$('#smtp_username').val();

      var smtp_password=$('#smtp_password').val();

      

      var admin_email=$('#admin_email').val();

      var sms_gateway_username=$('#sms_gateway_username').val();

      var sms_gateway_password=$('#sms_gateway_password').val();

      var security_key=$('#security_key').val();



      var allVal='<div class="col-md-6 " style="padding:0px;"> <div class="all_dtl"><div class="all_dtl1">Database Host</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_host+'</div></div><div class="all_dtl"><div class="all_dtl1">Database Name</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_name+'</div></div><div class="all_dtl"><div class="all_dtl1">Database Username</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_username+'</div></div><div class="all_dtl"><div class="all_dtl1">Database Password</div><div class="all_dtl2">:</div><div class="all_dtl3">'+db_password+'</div></div><div class="all_dtl"><div class="all_dtl1">SMTP Host</div><div class="all_dtl2">:</div><div class="all_dtl3">'+smtp_host+'</div></div><div class="all_dtl"><div class="all_dtl1">SMTP USername</div><div class="all_dtl2">:</div><div class="all_dtl3">'+smtp_username+'</div></div></div><div class="col-md-6"><div class="all_dtl"><div class="all_dtl1">SMTP Password</div><div class="all_dtl2">:</div><div class="all_dtl3">'+smtp_password+'</div></div><div class="all_dtl"><div class="all_dtl1">Admin Email</div><div class="all_dtl2">:</div><div class="all_dtl3">'+admin_email+'</div></div><div class="all_dtl"><div class="all_dtl1">SMS Gateway Username</div><div class="all_dtl2">:</div><div class="all_dtl3">'+sms_gateway_username+'</div></div><div class="all_dtl"><div class="all_dtl1">SMS Gateway Password</div><div class="all_dtl2">:</div><div class="all_dtl3">'+sms_gateway_password+'</div></div></div>';

       $('.allData').html(allVal);



    }

   

 

  });



  $('ul.setup-panels li a.btn-primary').trigger('click');



    $('#formDataa').click(function(){

		

      var allDetails=$('#Values').serialize();

	  console.log(allDetails);

         $('.loader').show();

          $.ajax({

            url:'',

            type:'post',

            data:allDetails,

            success:function(result){

              $('.loader').hide();

              if(result=="Success"){

                //window.location.href ='../index.php';

              }else{

                

                $('.message').html('<br><div class="label label-danger">Error Occured</div>');

              } 



            }

          });

    });



*/

// $( ".taxi_find" ).click(function() {

	// alert("hi");

	  // var ids = $(this).attr( "title" );

	  

	  // alert(ids);

// $( "ids" ).each(function() {

	// var v = $(this).val();

	// if((v.replace(/\s+/g, '')) == '') {

		// console.log("error");

		// // $(this).parents(".form-group").addClass("has-error");

	// }

	// else {

		// console.log("redirect");

		// // $(this).parents(".form-group").removeClass("has-error");

	// }

// });

	 

	 

// $( ".select2" ).each(function() {

	// var v = $(this).val();

	// if((v.replace(/\s+/g, '')) == '') {

		// console.log("error1");

		// // $(this).parents(".form-group").addClass("has-error");

	// }

	// else {

		// console.log("redirect");

		// // $(this).parents(".form-group").removeClass("has-error");

	// }

// });

 

	 

// $( ".select3" ).each(function() {

	// var v = $(this).val();

	// if((v.replace(/\s+/g, '')) == '') {

		// console.log("error2");

		// // $(this).parents(".form-group").addClass("has-error");

	// }

	// else {

		// console.log("redirect");

		// // $(this).parents(".form-group").removeClass("has-error");

	// }

// });

	  

//});

// $(".taxi_find").click(function() {

    // var valid = true;

    // var i = 0;

    // var $inputs = $(this).closest("div").find("input");



    // $inputs.each(function() {

        // if (!validator.element(this) && valid) {

            // valid = false;

        // }

    // });



    // if (valid) {

        // $("#tabs").tabs("select", this.hash);

    // }

// });

 // var cntry = document.getElementById('countryin').value;

// var options = {



  // componentRestrictions: {country: cntry}

 // };

  // var autocompleteA = new google.maps.places.Autocomplete(

                           // $("#autocomplete")[0],

                            // {types: ['(cities)']});

							  $( "#datepicker1" ).attr("placeholder", "mm-dd-yyyy").datepicker({

		   

			minDate: 0//this option for allowing user to select from year range

		});

		$("#datepicker1").change(function(){

			var date = $(this).val();

			$.ajax({

				url:base_url+'callmycab/timepicker',

				 data:{'date' : date},

				   type:'post',

				   success:function(result){

					 

						$("#pickup_time").html(result);

					   }	

			});

		});

		

		

									  $( "#datepicker3" ).attr("placeholder", "mm-dd-yyyy").datepicker({

		   

			minDate: 0//this option for allowing user to select from year range

		});

		$("#datepicker3").change(function(){

			var date = $(this).val();

			$.ajax({

				url:base_url+'callmycab/timepicker',

				 data:{'date' : date},

				   type:'post',

				   success:function(result){

					 

						$(".basicExample").html(result);

					   }	

			});

		});

		

});





$('input[name="air_trans"]').on('click',function(){

    var select = $(this).val();
    //alert(select);

    if(select=="going"){

        $('#airport_label').html('Pickup Area');

        $('#airport_field').attr('name','air_drop_area');

        $('#autocomplete_pick').attr('name','air_pickup_area');

    } else {

        $('#airport_label').html('Drop Area');

        $('#airport_field').attr('name','air_pickup_area');

        $('#autocomplete_pick').attr('name','air_drop_area');

    }

})





$("#datepicker2" ).attr("placeholder", "mm-dd-yyyy").datepicker({		   

	minDate: 0

});

$("#datepicker_dep" ).attr("placeholder", "mm-dd-yyyy").datepicker({		   

	minDate: 0

});

$("#datepicker_ret" ).attr("placeholder", "mm-dd-yyyy").datepicker({		   

	minDate: 0

});





		

$("#datepicker2").change(function(){



	var date = $(this).val();

	$.ajax({

		url:base_url+'callmycab/timepicker',

		 data:{'date' : date},

		   type:'post',

		   	success:function(result){	

				$("#air_pickup_time").html(result);

			}	

	});

});







$('.airport_transfer').on('click',function(){

	var air_loc_status = true;

	var air_location = true;

	var specifier = $(this).data('validate');

	//alert(specifier);

	$('.'+specifier).each(function(){

		var attr_name = $(this).attr('name');

		if($(this).attr('type')=='radio'){

		//alert($(':radio[name="air_trans"]:checked').length);	

			if($(':radio[name="air_trans"]:checked').length==0){			

				$(this).focus();

				air_loc_status = false;				

				return false;			

			}

		} else if($(this).prop('type')=='select-one') {

			if($(this).val()==''){

				$(this).focus();

				air_loc_status = false;

				return false;

			}

		} else {

			var value = $('input[name="'+attr_name+'"]').val();

			if(value==''){

				$(this).focus();

				air_loc_status = false;

				return false;

			}

		}



	})



	//alert(air_loc_status);

	if(air_loc_status==false){
			swal({
	title: "Please fill all required fields.",		
   
  timer: 3000,
  showConfirmButton: false
});
		 
	}
	



	if(air_loc_status==true){



		$('#air_car').addClass('active');

		$('#menuss1').addClass('active');

		$('#menuss1').addClass('in');



		$('#air_location').removeClass("active");

		$('#homess').removeClass("active");

		$('#homess').removeClass("in");



		var pick_lat = $('#driver_lat').val();	

		var pick_lng = $('#driver_lng').val();

		var drop_lat = $('#drop_lat').val();

		var drop_lng = $('#drop_lng').val();



		//obj = JSON.parse(data);



		//var distance_val = Math.ceil(distance(drop_lat,drop_lng,pick_lat,pick_lng,'K'));

		//alert(distance_val);



		//fetch_car_result(distance_val);



		$.ajax({

			type: "POST",

			url:base_url+'callmycab/fetch_distance',

			data: {drop_lng:drop_lng,drop_lat:drop_lat,pick_lat:pick_lat,pick_lng:pick_lng},

			cache: false,

			success: function(data){

				obj = JSON.parse(data);

				fetch_car_result(obj.distance);

			}

		});



	}

})





$('#airport_field').on('change',function(){

	var value = $(this).val();

	$.ajax({

			type: "POST",

			url:base_url+'callmycab/fetch_position',

			data: {code:value},

			cache: false,

			success: function(data){

				obj = JSON.parse(data);

				$('#drop_lat').val(obj['lat']);

				$('#drop_lng').val(obj['lon']);				

			}

		});

})



function fetch_car_result(distance){

		var time = $('#air_pickup_time').val();

		var optradio = $('input[name="air_trans"]').val();

		$.ajax({

			type: "POST",

			url:base_url+'callmycab/fetch_air_car',

			data: {type:'Airport Transfer',shift:time,distance:distance,select_type:optradio},

			cache: false,

			success: function(data){

				obj = JSON.parse(data);

				$('.sl-car').html('');

				$.each(obj, function( index, value ) {					   

  					$('<div class="form-group"><div class="radio"><label><input type="radio" name="air_car_type" data-type="'+value['cartype']+'" data-distance="'+value['distance']+'" data-amount="'+value['rate']+'" class="air_car"><span><img src="'+value['car_image']+'"/></span><span>'+value['cartype']+'</span><span class="pr-car-nw">'+value['currency']+value['rate']+'</span><span class="fre-det-mn">'+value['fare_details']+'</span></label></div></div>').appendTo(".sl-car");

					$('#air_dist').html('Distance: '+value['distance']);

				});

			

			}

		});

}



$('.airport_car').on('click',function(){



	//alert($('input[name="air_car_type":checked]').length);

	if($(':radio[name=air_car_type]:checked').length>0){

		air_car_status = true;

	} else {

		alert("Please Select Car Type");

		air_car_status = false;

	}

	



	

	


	if(air_car_status==true){

		$('#air_confirm').addClass('active');

		$('#menuss2').addClass('active');

		$('#menuss2').addClass('in');



		$('#air_car').removeClass("active");

		$('#menuss1').removeClass("active");

		$('#menuss1').removeClass("in");

	}

})



$('.air_confirm').on('click',function(){

	if($('#air_address').val().trim()==''){
		 
		$('#air_address').addClass("error-border");

		return false;

		

	} else {
		
			 $.ajax({

			 type: "POST",

			url:base_url+'callmycab/check_logged_in',

			 
			 cache: false,

		 	 success: function(data){

		 	 	 
		 	 	 

				if(data==0)
				{  
 
					  $('#myModallogin').modal('show');
					 
					 
				} else{

		var value = $('#airport_form').serialize();
		var car_type = $(':radio[name=air_car_type]:checked').data('type');
		var distance = $(':radio[name=air_car_type]:checked').data('distance');
		var amount = $(':radio[name=air_car_type]:checked').data('amount');
		var air_trans = $(':radio[name=air_trans]:checked').val();

		if(air_trans="coming"){
			var current_lat = $('#drop_lat').val();
			var current_lng =$('#drop_lng').val();
		} else {
			var current_lat = $('#driver_lat').val();
			var current_lng =$('#driver_lng').val();
		}

		var post_data = value+'&car_type='+car_type+'&distance='+distance+'&amount='+amount+'&current_lat='+current_lat+'&current_lng='+current_lng;

        // alert(post_data);
		$.ajax({

			type: "POST",

			url:base_url+'callmycab/airport_book',

			data: post_data,

			cache: false,

			success: function(data){
   // alert(data);
				window.location.href = base_url+'Payment/index/'+data;

			

			}

		});
		
		}
			 

			  }

		});
		

			 }

 
})

$(':radio[name=payment_option]').on('click',function(){
	var value = $(':radio[name=payment_option]:checked').val();
	if(value=="credit_card"){
		$('#credit_card_form').css('display','block');
	} else {
		$('#credit_card_form').css('display','none');
	}
})

$('#payment_submit').on('click',function(){
	//alert('sdfsdfds');
	if($(':radio[name=payment_option]:checked').length>0){
		var payment = $(':radio[name=payment_option]:checked').val();
		var amount = $('#amount').val();
		var booking_id = $('#booking_id').val();
		if(payment=="credit_card"){
			var card_no = $('#card_no').val();
			var exp_date = $('#exp_date').val();
			var card_cvv = $('#card_cvv').val();
			var credit_option = $('#credit_option').val();
			if(credit_option=="Authorize"){
				var url = 'Payment/autherize_payment';
			} else {
				var url = 'Payment/braintree_payment';
			}

			$.ajax({

			type: "POST",

			url:base_url+url,

			data: {amount:amount,booking_id:booking_id,card_no:card_no,exp_date:exp_date,card_cvv:card_cvv},

			cache: false,

			success: function(data){

				obj = JSON.parse(data);

				if(obj['status']=='success'){
					window.location.href = base_url+'Payment/payment_success/'+obj['booking_id'];
					$('#error_msg_class').html('');
				} else {
					 $('#error_msg_class').html('');
				 	$('<div class="col-lg-6" id="error_msg" style="color: red">'+obj['message']+'</div>').appendTo("#error_msg_class");
					 
				}

				

			

			}

		});

		} else if(payment=="cash"){
			$.ajax({

				type: "POST",

				url:base_url+'Payment/cash_payment',

				data: {amount:amount,booking_id:booking_id},

				cache: false,

				success: function(data){

					obj = JSON.parse(data);

					window.location.href = base_url+'Payment/payment_success/'+obj['booking_id'];

				

				}

			});

		} else {
			window.location.href = base_url+'Payment/paypal_payment/'+amount+'/'+booking_id;
		}
	} else {
		alert("Please Select Payment Option");
		return false;
	}
})

$('#outstation_field').on('change',function(){
	var package = $(this).val();
	$.ajax({
		type: "POST",
		url:base_url+'callmycab/get_location',
		data: {package:package},
		cache: false,
		success: function(data){
			var obj = JSON.parse(data);
			$('#out_drop_area').empty();
			$('#out_drop_area').append('<option value="">Select Pick Area</option>');
			$.each(obj,function(index,value){
				$('<option value="'+value+'">'+value+'</option>').appendTo('#out_drop_area');
			})
		}
	});
})

$('#out_loc').on('click',function(){
	var specifier = $(this).data('validate');
	var out_loc_status = true;

	//alert(specifier);

	$('.'+specifier).each(function(){

		var attr_name = $(this).attr('name');	
		



		if($(this).prop('type')=='select-one') {

			if($(this).val()==''){

				$(this).focus();

				out_loc_status = false;

				return false;

			}

		} else {

			var value = $('input[name="'+attr_name+'"]').val();

			if(value==''){

				$(this).focus();

				out_loc_status = false;

				return false;

			}

		}



	})


	if(out_loc_status==false){
			swal({
			 
     title: "Please fill all required fields.",
  timer: 3000,
  showConfirmButton: false
});

}



	if(out_loc_status==true){



		$('#out_car').addClass('active');
		$('#menussss1').addClass('active');
		$('#menussss1').addClass('in');

		$('#out_location').removeClass("active");
		$('#homessss').removeClass("active");
		$('#homessss').removeClass("in");

		var package = $('#outstation_field').val();
		var dep_date = $('#datepicker_dep').val();
		var ret_date = $('#datepicker_ret').val();

		$.ajax({
			type: "POST",
			url:base_url+'callmycab/fetch_out_car',
			data: {package:package,dep_date:dep_date,ret_date:ret_date},
			cache: false,
			success: function(data){
				obj = JSON.parse(data);
				$('#out_car_list').html('');
				$.each(obj, function( index, value ) {		   
					$('<div class="form-group"><div class="radio"><label><input type="radio" name="out_car_type" data-type="'+value['cartype']+'" data-distance="'+value['distance']+'" data-amount="'+value['rate']+'" class="out_car"><span><img src="'+value['car_image']+'"/></span><span>'+value['cartype']+'</span><span class="pr-car-nw">'+value['currency']+value['rate']+'</span><span class="fre-det-mn">'+value['fare_details']+'</span></label></div></div>').appendTo("#out_car_list");
					$('#out_dist').html('Total: '+value['distance']);
				});	
			}

		});





		



		//obj = JSON.parse(data);



		//var distance_val = Math.ceil(distance(drop_lat,drop_lng,pick_lat,pick_lng,'K'));

		//alert(distance_val);



		



		



	}


})

$('.outstation_car').on('click',function(){

	//alert('outstation_car');
	
	if($(':radio[name=out_car_type]:checked').length>0){

		out_car_status = true;

	} else {

		alert("Please Select Car Type");

		out_car_status = false;

	}

	



	



	//alert(out_car_status);



	if(out_car_status==true){

		$('#out_confirm').addClass('active');

		$('#menussss2').addClass('active');

		$('#menussss2').addClass('in');


		$('#out_car').removeClass("active");

		$('#menussss1').removeClass("active");

		$('#menussss1').removeClass("in");


		var date = $('#datepicker_dep').val();

			$.ajax({

				url:base_url+'callmycab/timepicker',

				 data:{'date' : date},

				   type:'post',

				   success:function(result){

					 

						$("#out_pickup").html(result);

					   }	

			});

		



	}
})


$('.out_confirm').on('click',function(){

//alert($('#out_pickup').val());


	if($('#out_address').val().trim()==''){
		 
		$('#out_address').addClass("error-border");
		return false;	

	} else if($('#out_pickup').val()==''){
		$('#out_pickup').focus();
		return false;
	}else {
		
			 $.ajax({

			 type: "POST",

			url:base_url+'callmycab/check_logged_in',

			 
			 cache: false,

		 	 success: function(data){

		 	 	 
		 	 	 

				if(data==0)
				{  
 
					  $('#myModallogin').modal('show');
					 
					 
				} else{

		var value = $('#out_statation').serialize();
		var car_type = $(':radio[name=out_car_type]:checked').data('type');
		var distance = $(':radio[name=out_car_type]:checked').data('distance');
		var amount = $(':radio[name=out_car_type]:checked').data('amount');
		var pickup_area = $("#outstation_field option:selected").text();

		


		var post_data = value+'&car_type='+car_type+'&distance='+distance+'&amount='+amount+'&pickup_area='+pickup_area;

		//alert(JSON.stringify(post_data));
		$.ajax({

			type: "POST",

			url:base_url+'callmycab/outstation_book',

			data: post_data,

			cache: false,

			success: function(data){

				//alert(data);

				window.location.href = base_url+'Payment/index/'+data;

			

			}

		});




				}
			 

			  }

		});
		

			 }

 

})

$('.contact_form_button').on('click',function(){
 
		if ($('#contact_form').parsley().validate() ) {	
		 
	  var value=$('#contact_form').serialize();
	  
		$.ajax({
			type: "POST",
			url:base_url+'callmycab/contact_us_details',
			data: {value},
			cache: false,
			success: function(data){
				obj = JSON.parse(data);
			 
				 
				if(obj.status=='success'){
					 
				$('#success_contact').show();
			setTimeout(function(){ $('#success_contact').hide();}, 3000);
				}else{
					$('#error_psw').show();
			    setTimeout(function(){ $('#error_psw').hide();}, 3000);
				}
				  
			}
		});
		}
})


$('#save_chng_psw').on('click',function(){
 
		if ($('#change_psw_acc').parsley().validate() ) {	
		 
	  var value=$('#change_psw_acc').serialize();
	  
		$.ajax({
			type: "POST",
			url:base_url+'callmycab/change_password',
			data: {value},
			cache: false,
			success: function(data){
				if(data=='Success'){
				$('#success_psw').show();
			setTimeout(function(){ $('#success_psw').hide();}, 3000);
				}else if(data=='cpsw')
				{
				$('#confirm_psw').show();
			    setTimeout(function(){ $('#confirm_psw').hide();}, 3000);
				}else if(data=='current')
				{
					$('#current_psw').show();
			    setTimeout(function(){ $('#current_psw').hide();}, 3000);
				}else{
					$('#error_psw').show();
			    setTimeout(function(){ $('#error_psw').hide();}, 3000);
				}
				  
			}
		});
		}
})
 $( "#datepicker_sort" ).attr("placeholder", "mm-dd-yyyy").datepicker({
		   
		  
		   buttonImage: '../assets/img/login/calender.png',
		         buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        showOn: 'both',
         buttonText: 'Sort By Date',
		
		onClose: function(selectedDate) {
			 
                var dates = $('#datepicker_sort').val();
			// var ref_this = $("ul.nav-tabs li").find(".active");
			var active =  $("ul.chk li.active");
			var active_tab_id=$(active).attr('id');
		 
			  $.ajax({
			type: "POST",
			url:base_url+'callmycab/sort_date',
			data: {dates:dates,tab_id:active_tab_id},
			cache: false,
			success: function(data){
				obj = JSON.parse(data);
				if(active_tab_id=='active1'){
					var append_content='append_content_active';
				}else{
					var append_content='append_content_past';
				}
			$('.'+append_content).html('');
			$.each(obj , function(index,value){
				 
				$('<div class="tab-login-first"><h5>From<span>'+value['pickup_area']+'</span></h5><h5>To<span>'+value['drop_area']+'</span></h5><div class="date-tf"><h6> '+value['pickup_date']+' <span>'+value['pickup_time']+' </span></h6></div><div class="date-tf"><h6><?php echo $lang_booking_id; ?>Booking ID: <span>'+value['uneaque_id']+' </span></h6></div><div class="date-tf"><h6><?php echo $lang_car_type; ?>Car Type: <span>'+value['taxi_type']+' </span></h6></div><div class="date-tf"><h6><?php echo $lang_total_fare; ?>Total Fare:<span>'+value['amount']+' </span> </h6></div><div class="clearfix"></div><h6 class="stat"><?php echo $lang_status; ?>Status:<span>'+value['status']+' </span></h6></div>').appendTo('.'+append_content);
				 
			})
				 
				  
			}
		});
              
			   
			    
			   }
		});
$('.hide-main-second').on('click',function(){
	$('.m-s-1').show();
	$('.m-s-2').hide();

})
 
function distance(lat1, lon1, lat2, lon2, unit) {

	var radlat1 = Math.PI * lat1/180

	var radlat2 = Math.PI * lat2/180

	var theta = lon1-lon2

	var radtheta = Math.PI * theta/180

	var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);

	dist = Math.acos(dist)

	dist = dist * 180/Math.PI

	dist = dist * 60 * 1.1515

	if (unit=="K") { dist = dist * 1.609344 }

	if (unit=="N") { dist = dist * 0.8684 }

	return dist

}


$(document).ready(function(){
	
	var time_type = 'day';
	var search_amount = '';
	var value = {time_type:time_type,search_amount:search_amount};
	get_fare_info(value);

	

});

$('#search_amount').on('change',function(){
	var search_amount = $(this).val();
	var time_type = 'day';
	var value = {time_type:time_type,search_amount:search_amount};
	get_fare_info(value)
})


function get_fare_info(value){

$('#point_cab').html('');
$('#airport_cab').html('');
$('#hourly_cab').html('');
$('#station_cab').html('');



	$.ajax({
		type: "POST",
		url:base_url+'callmycab/fare_details',
		data: value,
		cache: false,
		success: function(data){
			// alert(data);
			obj = JSON.parse(data);
			

			$.each(obj.point , function(index,value){
				$('<div class="row mn-rew"><div class="col-lg-6"><div class="sedan-hd"><img src="'+value['car_image']+'"/><h5>'+value['cartype']+'</h5></div></div><div class="col-lg-6"><div class="sedan-list-det"><h5> '+value['fare_details']+'</h5></div></div></div>').appendTo('#point_cab');
			})

			$.each(obj.airport , function(index,value){
				$('<div class="row mn-rew"><div class="col-lg-4"><div class="sedan-hd"><img src="'+value['car_image']+'"/><h5>'+value['cartype']+'</h5></div></div><div class="col-lg-4"><div class="sedan-list-det"><h5> '+value['fare_details']+'</h5></div></div><div class="col-lg-4"><div class="sedan-list-det"><h5> '+value['fare_from_details']+'</h5> </div></div></div>').appendTo('#airport_cab');
			})

			$.each(obj.hourly , function(index,value){
				$('<div class="row mn-rew"><div class="col-lg-6"><div class="sedan-hd"><img src="'+value['car_image']+'"/><h5>'+value['cartype']+'</h5></div></div><div class="col-lg-6"><div class="sedan-list-det"><h5> '+value['fare_details']+'</h5></div></div></div>').appendTo('#hourly_cab');
			})

			$.each(obj.station , function(index,value){
				$('<div class="row mn-rew"><div class="col-lg-6"><div class="sedan-hd"><img src="'+value['car_image']+'"/><h5>'+value['cartype']+'</h5></div></div><div class="col-lg-6"><div class="sedan-list-det"><h5> '+value['fare_details']+'</h5></div></div></div>').appendTo('#station_cab');
			})
			  
		}
    });
}

$('#day_click').on('click',function(){
	$('#day_main').addClass('add-highlight');
	$('#night_main').removeClass('add-highlight');
	$('#time_type').val('day');
	var time_type = $('#time_type').val();
	var search_amount = $('#search_amount').val();
	var value = {time_type:time_type,search_amount:search_amount};
	get_fare_info(value);
})

$('#night_click').on('click',function(){
	$('#night_main').addClass('add-highlight');
	$('#day_main').removeClass('add-highlight');
	$('#time_type').val('night');
	var time_type = $('#time_type').val();
	var search_amount = $('#search_amount').val();
	var value = {time_type:time_type,search_amount:search_amount};
	get_fare_info(value);
})

$('#add_money').on('click',function(){
	
	if ($('#wallet_get_form').parsley().validate() ) {	
	//$('.close').click();
	$.ajax({
		type: "POST",
		url:base_url+'callmycab/check_logged_in',
		cache: false,
		success: function(data){
			if(data==0) {
				$('#myModalwallet').modal('hide');
			 $('#myModallogin').modal('show');
			} else{
				var wallet_amount = $('#wallet_amount').val();
				window.location.href = base_url+'Wallet/add_to_wallet/'+wallet_amount;
			}
		}
	})
	}
})

//out_promo_check

//air_promo_check

$('#air_promo_check').on('click',function(){
	var air_promo = $('#air_promo').val();
	if(air_promo!=''){
		check_promo(air_promo,'air_promo_status','air_promo');
	} else {
		return false;
	}
})

$('#point_promo_check').on('click',function(){
	var air_promo = $('#point_promo').val();
	if(air_promo!=''){
		check_promo(air_promo,'promo_status_point','point_promo');
	} else {
		return false;
	}
})

$('#hour_promo_check').on('click',function(){
	var air_promo = $('#hour_promo').val();
	if(air_promo!=''){
		check_promo(air_promo,'promo_status_hour','hour_promo');
	} else {
		return false;
	}
})

$('#out_promo_check').on('click',function(){
	var air_promo = $('#out_promo').val();
	//alert(air_promo);
	if(air_promo!=''){
		check_promo(air_promo,'out_promo_status','out_promo');
	} else {
		return false;
	}
})


function check_promo(promo_code,fields,promo_field){
	//alert(fields);
	$.ajax({
		type: "POST",
		url:base_url+'callmycab/promo_verify',
		data: {code:promo_code},
		cache: false,
		success: function(data){
			
			if(data==0){
				$('#'+fields).val(data);
				fields = fields+'_message';
				$('#'+fields).html('Invalid Promo Code');
				$('#'+promo_field).val('');
			} else {
				fields_message = fields+'_message';
				$('#'+fields_message).html('Promo Code applied Successfully');
				$('#'+fields).val(data);
			}		
			  
		}
    });
 }

 $('#log_show').on('click',function(){
	 if($(this).is(':checked')){
	 	$('#signin-password').attr('type','text');
	 } else {
	 	$('#signin-password').attr('type','password');
	 } 
	 
 })

  $('#sign_show').on('click',function(){
	 if($(this).is(':checked')){
	 	$('#signup-password').attr('type','text');
	 } else {
	 	$('#signup-password').attr('type','password');
	 } 
	 
 })

 

