/**
 * Transaction delete action
 */
(function($, bootbox) {
  $(function() {
    $(document).on('click.app', 'button.transaction-delete', function(e) {
      var $this = $(this);
      var $form = $this.parents('form');
      var transactionDetail = $this.data('transaction-detail');

      bootbox.dialog({
        title: 'Delete transaction',
        message: 'Click OK to delete transaction \''+transactionDetail + '\'',
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
