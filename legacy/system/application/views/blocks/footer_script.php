<?php 

$CI =& get_instance();
$popup=$CI->checkpopup();

$popup=$popup['popup_status'];


//echo $popup; exit;


 if($popup==1){
 if($this->db_session->userdata('login')['login']){
}
else
{?>
  
  <style>
.login_main_div{
 width: 600px!important;
 margin: auto!important;
}

.login_main_div .btn.focus, 
.login_main_div .btn:focus, 
.login_main_div .btn:hover {
    color: #b9b9b9!important;
    text-decoration: none!important;;
}


    .login_new_popup {
    position: absolute;
    height: auto;
    width: 600px!important;
    top: 0px;
    left: inherit!important;
    display: block;
    z-index: 1222!important;
    margin-top: 70px!important;
}
.login_main_div .ui-widget-content a {
    color: #fff!important;
}
.login_new_popup .ui-dialog-titlebar.ui-widget-header.ui-corner-all.ui-helper-clearfix.ui-draggable-handle {
    background: transparent!important;
    border: transparent!important;
}
.ui-dialog .ui-dialog-content {
    margin-top: 0px!important;
}
@media only screen and (max-width: 768px){
    .login_main_div{
 width: 450px!important;
 margin: auto!important;
}
 .login_new_popup {
    width: 450px!important;
    }
        .login_new_popup {
    margin-top: 50px!important;
}
}
@media only screen and (max-width: 490px) and (min-width: 220px){
    .login_main_div{
 width: 350px!important;
 margin: auto!important;
}
 .login_new_popup {
    width: 350px!important;
    }
            .login_new_popup {
    margin-top: 30px!important;
}
}
</style>

<div class="login_main_div">

<div class="modal-dialog model-class" id='dialog1'>
                       
NOT A MEMBER ? JOIN NOW
 Register with Google +
Register with Facebook


            <form name="registerForm" id="registerForm" method="POST" action="http://192.168.1.201/projects/beesavy_new/legacy/public/account/register" style="margin-top: 15px;">
                <div class="row">
                 <div class="col-md-6">
                   <a href="http://192.168.1.201/projects/beesavy_new/legacy/public/main/glogin"> <button type="button" class="btn btn-google btn-block" style="margin-bottom: 10px;">Register with Google +</button></a>
                 </div>
                 <div class="col-md-6">
                 
             <a type="button" class="btn btn-facebook btn-block" href="http://192.168.1.201/projects/beesavy_new/legacy/public/main/joinnow?fb=true " style="margin-bottom: 10px;">Register with Facebook
             </a>
                 </div>    
                 
                </div>
                <hr>
                 <div class="space20"></div>
                <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"> <i class="fa fa-envelope"></i></label>   
                 </div>
                 <div class="col-md-11 col-sm-11 col-xs-11">
                     <input required="required" type="text" name="email" placeholder="Enter Email Address" value="" id="email" class="form-control">
                 </div>    
                </div>
                                  
                    <div class="space20"></div>
                   <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"><i class="fa fa-lock"></i> </label>   
                 </div>
                 <div class="col-md-11 col-sm-11 col-xs-11">
                     <input required="required" type="password" placeholder="Enter Password" name="password" id="password" class="form-control">
                 </div>    
                </div>
                    <div class="space20"></div>
                       <div class="row">
                 <div class="col-md-1 col-sm-1 col-xs-1">
                 <label class="label-gap"><i class="fa fa-lock"></i>  </label>   
                 </div>
                 <div class="col-md-11 col-sm-11 col-xs-11">
                    <input required="required" type="password" name="password_confirm" placeholder=" Confirm Password" id="password_confirm" class="form-control">
                 </div>    
                </div>
                    <div class="space20"></div>
                      
                           <div class="row ">
                 
                 <div class="col-md-6 col-md-offset-3">
                     <input type="submit" class="btn btn-saving btn-block reg-btn" value="Start Saving">
                 </div>    
                </div>
                    
                    
                    
                    </form> 

                        </div>
                        </div>

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
 
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />

    <script type="text/javascript">
    $.noConflict();
jQuery( document ).ready(function( $ ) {

  $( "#dialog1" ).dialog({
    autoOpen: false
  });
  
  $("section").mouseover(function() { 

    $("#dialog1").dialog('open');
$('.ui-resizable').addClass('login_new_popup');
$('.ui-dialog.ui-widget').wrap('<div class="login_main_div"></div>');
$('.ui-dialog.ui-widget').addClass('login_new_popup');



    $('.model-class').removeAttr('id');


  });
});
    </script>

<?php }
}
  ?>


<script src="<?php echo s3path("/script_files/js/jquery.min.js") ?>"></script>
<script  src="<?php echo s3path("/script_files/js/bootstrap.min.js") ?>"></script>
<script  src="<?php echo s3path("/script_files/js/custom.js") ?>"></script>



<script>
/*

$( function () {
  $(window).unload( function () {
    alert('gggggggg');
    unloadHandler();
  } );
  $( 'a.outlink' ).click( function () {
    unloadHandler = function () {};
  });
});


*/
/*
window.onbeforeunload = function (e) {


    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = 'Any string';
    }

    // For Safari
    return 'This is simple string';
};

*/

$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
});
</script>

<script type="text/javascript">
    $(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});
    
    </script>
    
<script>

         jQuery(document).ready(function($){
    //update these values if you change these breakpoints in the style.css file (or _layout.scss if you use SASS)
    var MqM= 768,
        MqL = 1024;

    var faqsSections = $('.cd-faq-group'),
        faqTrigger = $('.cd-faq-trigger'),
        faqsContainer = $('.cd-faq-items'),
        faqsCategoriesContainer = $('.cd-faq-categories'),
        faqsCategories = faqsCategoriesContainer.find('a'),
        closeFaqsContainer = $('.cd-close-panel');
    
    //select a faq section 
    faqsCategories.on('click', function(event){
        event.preventDefault();
        var selectedHref = $(this).attr('href'),
            target= $(selectedHref);
        if( $(window).width() < MqM) {
            faqsContainer.scrollTop(0).addClass('slide-in').children('ul').removeClass('selected').end().children(selectedHref).addClass('selected');
            closeFaqsContainer.addClass('move-left');
            $('body').addClass('cd-overlay');
        } else {
            $('body,html').animate({ 'scrollTop': target.offset().top - 19}, 200); 
        }
    });

    //close faq lateral panel - mobile only
    $('body').bind('click touchstart', function(event){
        if( $(event.target).is('body.cd-overlay') || $(event.target).is('.cd-close-panel')) { 
            closePanel(event);
        }
    });
    faqsContainer.on('swiperight', function(event){
        closePanel(event);
    });

    //show faq content clicking on faqTrigger
    faqTrigger.on('click', function(event){
        event.preventDefault();
        $(this).next('.cd-faq-content').slideToggle(200).end().parent('li').toggleClass('content-visible');
    });

    //update category sidebar while scrolling
    $(window).on('scroll', function(){
        if ( $(window).width() > MqL ) {
            (!window.requestAnimationFrame) ? updateCategory() : window.requestAnimationFrame(updateCategory); 
        }
    });

    $(window).on('resize', function(){
        if($(window).width() <= MqL) {
            faqsCategoriesContainer.removeClass('is-fixed').css({
                '-moz-transform': 'translateY(0)',
                '-webkit-transform': 'translateY(0)',
                '-ms-transform': 'translateY(0)',
                '-o-transform': 'translateY(0)',
                'transform': 'translateY(0)',
            });
        }   
        if( faqsCategoriesContainer.hasClass('is-fixed') ) {
            faqsCategoriesContainer.css({
                'left': faqsContainer.offset().left,
            });
        }
    });

    function closePanel(e) {
        e.preventDefault();
        faqsContainer.removeClass('slide-in').find('li').show();
        closeFaqsContainer.removeClass('move-left');
        $('body').removeClass('cd-overlay');
    }

    function updateCategory(){
        updateCategoryPosition();
        updateSelectedCategory();
    }

    function updateCategoryPosition() {
        var top = $('.cd-faq').offset().top,
            height = jQuery('.cd-faq').height() - jQuery('.cd-faq-categories').height(),
            margin = 20;
        if( top - margin <= $(window).scrollTop() && top - margin + height > $(window).scrollTop() ) {
            var leftValue = faqsCategoriesContainer.offset().left,
                widthValue = faqsCategoriesContainer.width();
            faqsCategoriesContainer.addClass('is-fixed').css({
                'left': leftValue,
                'top': margin,
                '-moz-transform': 'translateZ(0)',
                '-webkit-transform': 'translateZ(0)',
                '-ms-transform': 'translateZ(0)',
                '-o-transform': 'translateZ(0)',
                'transform': 'translateZ(0)',
            });
        } else if( top - margin + height <= $(window).scrollTop()) {
            var delta = top - margin + height - $(window).scrollTop();
            faqsCategoriesContainer.css({
                '-moz-transform': 'translateZ(0) translateY('+delta+'px)',
                '-webkit-transform': 'translateZ(0) translateY('+delta+'px)',
                '-ms-transform': 'translateZ(0) translateY('+delta+'px)',
                '-o-transform': 'translateZ(0) translateY('+delta+'px)',
                'transform': 'translateZ(0) translateY('+delta+'px)',
            });
        } else { 
            faqsCategoriesContainer.removeClass('is-fixed').css({
                'left': 0,
                'top': 0,
            });
        }
    }

    function updateSelectedCategory() {
        faqsSections.each(function(){
            var actual = $(this),
                margin = parseInt($('.cd-faq-title').eq(1).css('marginTop').replace('px', '')),
                activeCategory = $('.cd-faq-categories a[href="#'+actual.attr('id')+'"]'),
                topSection = (activeCategory.parent('li').is(':first-child')) ? 0 : Math.round(actual.offset().top);
            
            if ( ( topSection - 20 <= $(window).scrollTop() ) && ( Math.round(actual.offset().top) + actual.height() + margin - 20 > $(window).scrollTop() ) ) {
                activeCategory.addClass('selected');
            }else {
                activeCategory.removeClass('selected');
            }
        });
    }
});
        </script>

    
<script type="text/javascript">
    $(document).ready(function(){

    $(".sign_button").click(function(){
    $("#login-box").toggle();
    });
    });
</script>


<script>
class KS_ToTop {
   
   constructor(selector, appearPx, scrollSpd=10) {
      this.$selector = document.querySelector(selector);
        this.appearPx = appearPx;
      this.scrollSpd = scrollSpd;
      this.timeOut = null;
      this.isAutoScrolling = false;
      
      this.init();
   }
   
   init() {
      // Add event listeners for page scrolling
      document.addEventListener('mousewheel',     (e) => this.scrollHandler(e), false);
      document.addEventListener('DOMMouseScroll', (e) => this.scrollHandler(e), false);
      
      // Add event listener for click
      this.$selector.addEventListener('click', () => {
         this.$selector.classList.remove('ks-appear');
            this.scrollToTop();
      });
   }
   
   scrollHandler(e) {
      var offsetY = window.pageYOffset;

      if(!this.isAutoScrolling) {
         if(offsetY >= this.appearPx) {
            this.$selector.classList.add('ks-appear');
         }
         else {
            this.$selector.classList.remove('ks-appear');
         }
      }
   }
   
   scrollToTop() {
      this.isAutoScrolling = true;

      if(document.body.scrollTop !== 0 || document.documentElement.scrollTop !== 0) {
          window.scrollBy(0, -this.scrollSpd);
          this.timeOut = setTimeout( () => { this.scrollToTop(); }, 10);
      }
      else {
         clearTimeout(this.timeOut);
         this.isAutoScrolling = false;
      }
   }
}

document.addEventListener('DOMContentLoaded', function () {
    var toTop = new KS_ToTop('#back-to-top', 200);
});

</script>

<script>
  $(document).ready(function(){
  $('#admin-header ul.option').click(function(){
    $('li a').removeClass("active");
    $(this).addClass("active");
});
});
</script>


<script>
/*
window.onunload = function() {
    var win = window.opener;
    if (!win.closed) {
        alert('dddddddd');
        return false;
    }
};*/
</script>

<script type="text/javascript">
/*
 var popit = true;
     window.close = function() {
          if(popit == true) {
               popit = false;
               return "Are you sure you want to leave Beesavy?"; 
          }
     } 
*/
</script>
