/**
 * Application script
 */

(function($) {
  $(function() {

    /**
     * Merchant edit form
     */
    $(document).on('change.app', 'form.merchant-edit #merchant_commissionType', function(e) {
      var $this = $(this);
      var $commMax = $this.parents('form').find('#merchant_commissionMax');
      if ($this.val().match(/_var$/)) {
        $commMax.removeAttr('readonly');
      } else {
        $commMax.val(0.00).attr('readonly', 'readonly');
      }
    });

  });
})(window.jQuery);
