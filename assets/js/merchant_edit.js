/**
 * Merchant edit form
 */

(function($) {
  $(function() {

    $(document).on('change.app', 'form.merchant-edit #merchant_commissionType', function(e) {
      var $this = $(this);
      var $field = $this.parents('form').find('#merchant_commissionMax');

      if ($this.val().match(/_var$/)) {
        $field.prop('disabled', false);
      } else {
        $field.prop('disabled', true).val('0.00');
      }
    });

    $('form.merchant-edit #merchant_commissionType').trigger('change.app');

  });
})(window.jQuery);
