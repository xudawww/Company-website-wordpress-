jQuery(document).ready(function ($) {


    $(".bot-tab").hide();


    $(".book-now-option").click(function()
    {
        $(".book-now-option").hide();
            $(".bot-tab").removeClass("animated slideOutDown");
            $(".bot-tab").addClass("animated slideInUp").show();
    });

    $(".bk-option-down").click(function()
    {

        $(".bot-tab").removeClass("animated slideInUp");
        $(".bot-tab").addClass("animated slideOutDown");
        setTimeout(function(){
        $(".bot-tab").hide();
        $(".book-now-option").show();
        },1000);
    });




    //  Menu Focus

    var  url = document.URL;

    var page = url.split('/').pop();

    $(".nav li a").each(function(){

        if(page == 'index.php' || page == ''){

            $(".nav li a").each(function() {

                // checks if its the same on the address bar

                var anchorText = $(this).text();

                if(anchorText == 'HOME'){

                    $(this).parent().addClass("active");

                }

            });

        }

        else if(url == (this.href)){

            $(this).parent().addClass("active");
            $(".m-1").removeClass("active");
        }

    })


    if ($('#back-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }


    // contact-hide

    $(".hd-div-1").hide();
    $(".cnt-hide").hide();

    $(".show-div").click(function()
    {
        $(".hd-div-1").show();
        $(".show-div").hide();
        $(".cnt-hide").show();
    });

    $(".hd-div-1").click(function()
    {
        $(".hd-div-1").hide();
        $(".show-div").show();
        $(".cnt-hide").hide();
    });


   /* $(".cl-mdl").click(function()
    {
      $(".modal-backdrop").hide();
           
    });*/

	$('.signup_now').on("click", function() {
        $('#myModallogin').modal('hide');
        setTimeout(function() {
            $('#myModalsignup').modal('show');
        }, 500);

    });

    $('.login_now').on("click", function() {
        $('#myModalsignup').modal('hide');
        setTimeout(function() {
            $('#myModallogin').modal('show');
        }, 500);
    });

    
    
       
});


$('input[name="optradio"]').on('click',function(){
    var select = $(this).val();
    if(select=="going"){
        $('#airport_label').html('Pickup Area');
        $('#airport_field').attr('name','drop_area');
        $('#autocomplete_pick').attr('name','pickup_area');
    } else {
        $('#airport_label').html('Drop Area');
        $('#airport_field').attr('name','pickup_area');
        $('#autocomplete_pick').attr('name','drop_area');
    }
})

 $(".m-s-2").hide();
    $(".c-pass").click(function()
    {
        $(".m-s-1").hide();
        $(".m-s-2").show();
    });
 

