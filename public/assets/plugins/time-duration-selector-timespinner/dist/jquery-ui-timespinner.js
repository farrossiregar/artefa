(function($) {
  $.widget("ui.timespinner", $.ui.spinner, {
    options: {
      step: 60,
      page: 60,
      format: 'HH:mm'
    },

    _parse: function(value) {
      if (typeof value === "string") {
        if (Number(value) == value) {
          return Number(value);
        }
        return moment.utc(value, this.options.format).unix();
      }
      return value;
    },

    _format: function(value) {
      return moment.unix(value).utc().format(this.options.format);
    }
  });
})(jQuery);
