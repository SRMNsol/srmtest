/**
 * Merchant delete action
 */
(function($, bootbox) {
  $(function() {
    $(document).on('click.app', 'button.merchant-delete', function(e) {
      var $this = $(this);
      var $form = $this.parents('form');
      var merchantName = $this.data('merchant-name') || 'merchant';

      bootbox.dialog({
        title: 'Delete merchant',
        message: 'Click OK to delete '+merchantName,
        buttons: {
          cancel: {
            label: 'Cancel',
            className: 'btn-default'
          },
          ok: {
            label: 'OK',
            className: 'btn-primary',
            callback: function() {
              $form.submit();
            }
          }
        }
      });
    });
  });
})(window.jQuery, window.bootbox);
