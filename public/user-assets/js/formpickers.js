(function($) {
  'use strict';
  if ($("#checkin").length) {
    $('#checkin').datetimepicker({
        format:'DD/MM/YYYY HH:mm:ss',
    });
  }

  if ($("#checkout").length) {
    $('#checkout').datetimepicker({
        format:'DD/MM/YYYY HH:mm:ss',
    });
  }

  if ($(".color-picker").length) {
    $('.color-picker').asColorPicker();
  }
  if ($("#datepicker-popup").length) {
    $('#datepicker-popup').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
    });
  }
  if ($("#inline-datepicker").length) {
    $('#inline-datepicker').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
    });
  }
  if ($(".datepicker-autoclose").length) {
    $('.datepicker-autoclose').datepicker({
      autoclose: true
    });
  }
  if($('.input-daterange').length) {
    $('.input-daterange input').each(function() {
      $(this).datepicker('clearDates');
    });
    $('.input-daterange').datetimepicker({

        dateFormat: "yy-mm-dd",
        timeFormat:  "hh:mm:ss"
    });
  }
})(jQuery);