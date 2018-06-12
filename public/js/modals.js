$(document).ready( function() {
  // Field list scroll initialization
  if (!clientInfo.mobile) {
      $('.field-list').mCustomScrollbar({
          scrollbarPosition: 'inside',
          scrollInertia: 0
      });
  }
  // Show field list
  $(document).on('click', '.btn-field-list', function(e) {
      e.preventDefault();
      var $this = $(e.target),
          fieldBlock = $this.closest('.field-block');
      if (fieldBlock.hasClass('field-list-active')) {
          fieldBlock.removeClass('field-list-active');
          // $('.field-block.field-list-active').removeClass('field-list-active');
          // $this.closest('.field-block').toggleClass('field-list-active');
      } else {
          $('.field-block.field-list-active').removeClass('field-list-active');
          fieldBlock.addClass('field-list-active');
      }
  });
  // Close field list by click on list element and filling text input
  $(document).on('click', '.field-list', function(e) {
      e.stopPropagation();
      e.preventDefault();

      var $this = $(e.target),
          inputBlock = $this.closest('.field-block');
      if ($this.hasClass('element')) {
          inputBlock.find('input').val($this.text().trim());
          inputBlock.find('input').attr('data-value', $this.attr('data-value').trim());
          inputBlock.removeClass('field-list-active');
      }
  });
  // Close field list
  $(document).on('click', function(e) {
      if ((!$(e.target).hasClass('field-block--list field-list-active')) && (!$(e.target).closest('.field-block--list.field-list-active').length)) {
          $('.field-block--list.field-list-active').removeClass('field-list-active');
      }
  });
  // Field list search
  $('.field-block--list input').on('input change paste propertychange', function(e) {
      var val = $(this).val();
          fieldBlock = $(this).closest('.field-block'),
          list = fieldBlock.find('.field-list'),
          listElements = list.find('li');

      listElements.removeClass('hidden').each(function() {
          if ($(this).find('a').text().trim().toLowerCase().indexOf(val.toLowerCase()) !== 0) $(this).addClass('hidden');
      });

      fieldBlock.addClass('field-list-active');

  });
});
