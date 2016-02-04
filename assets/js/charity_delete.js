/**
 * Charity delete action
 */
(function($, bootbox) {
  $(function() {
    $(document).on('click.app', 'button.charity-delete', function(e) {
      var $this = $(this);
      var $form = $this.parents('form');
      var charityName = $this.data('charity-name');

      bootbox.dialog({
        title: 'Delete charity',
        message: 'Click OK to delete charity \''+charityName + '\'',
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
