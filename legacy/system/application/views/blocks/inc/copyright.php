<section id="bee_copy_rights">
    <div class="container">
        <div class="copy_rights">
            <span>Copyright &copy; 2011 - 2017 BeeSavy, LLC.  All Rights Reserved. </span>
        </div>
    </div>
</section>

<script src="../js/jquery.min.js"></script>
<script  src="../js/bootstrap.min.js"></script>
<script  src="../js/custom.js"></script>
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