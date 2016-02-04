/**
 * Category delete action
 */
(function($, bootbox) {
  $(function() {
    $(document).on('click.app', 'button.category-delete', function(e) {
      var $this = $(this);
      var $form = $this.parents('form');
      var categoryName = $this.data('category-name');

      bootbox.dialog({
        title: 'Delete category',
        message: 'Click OK to delete category \''+categoryName + '\'',
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
