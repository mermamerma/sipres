/* Datepicker Validation 1.0.0 for jQuery UI Datepicker 1.8.6.
   Requires Jörn Zaefferer's Validation plugin (http://plugins.jquery.com/project/validate).
   Written by Keith Wood (kbwood{at}iinet.com.au).
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the authors if you use it. */

(function($) { // Hide the namespace

/* Add validation methods if validation plugin available. */
if ($.fn.validate) {

	$.datepicker._selectDate2 = $.datepicker._selectDate;
	
	$.extend($.datepicker.regional[''], {
		validateDate: 'Please enter a valid date',
		validateDateMin: 'Please enter a date on or after {0}',
		validateDateMax: 'Please enter a date on or before {0}',
		validateDateMinMax: 'Please enter a date between {0} and {1}'
	});
	
	$.extend($.datepicker._defaults, $.datepicker.regional['']);

	$.extend($.datepicker, {

		/* Trigger a validation after updating the input field with the selected date.
		   @param  id       (string) the ID of the target field
		   @param  dateStr  (string) the chosen date */
		_selectDate: function(id, dateStr) {
			this._selectDate2(id, dateStr);
			var input = $(id);
			var inst = this._getInst(input[0]);
			if (!inst.inline && $.fn.validate)
				input.parents('form').validate().element(input);
		},

		/* Correct error placement for validation errors - after (before if R-T-L) any trigger.
		   @param  error    (jQuery) the error message
		   @param  element  (jQuery) the field in error */
		errorPlacement: function(error, element) {
			var trigger = element.next('.' + $.datepicker._triggerClass);
			var before = false;
			if (trigger.length == 0) {
				trigger = element.prev('.' + $.datepicker._triggerClass);
				before = (trigger.length > 0);
			}
			error[before ? 'insertBefore' : 'insertAfter'](trigger.length > 0 ? trigger : element);
		},

		/* Format a validation error message involving dates.
		   @param  message  (string) the error message
		   @param  params  (Date[]) the dates
		   @return  (string) the formatted message */
		errorFormat: function(inst, message, params) {
			var format = $.datepicker._get(inst, 'dateFormat');
			$.each(params, function(i, v) {
				message = message.replace(new RegExp('\\{' + i + '\\}', 'g'),
					$.datepicker.formatDate(format, v) || 'nothing');
			});
			return message;
		}
	});

	var lastElement = null;

	/* Validate date field. */
	$.validator.addMethod('dpDate', function(value, element, params) {
			lastElement = element;
			var inst = $.datepicker._getInst(element);
			var dateFormat = $.datepicker._get(inst, 'dateFormat');
			var config = $.datepicker._getFormatConfig(inst);
			try {
				var date = $.datepicker.parseDate(dateFormat, value, config);
				var minDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'minDate'), null);
				var maxDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'maxDate'), null);
				var beforeShowDay = $.datepicker._get(inst, 'beforeShowDay');
				return this.optional(element) || !date || 
					((!minDate || date >= minDate) && (!maxDate || date <= maxDate) &&
					(!beforeShowDay || beforeShowDay.apply(element, [date])[0]));
			}
			catch (e) {
				return false;
			}
		}, function(params) {
			var inst = $.datepicker._getInst(lastElement);
			var minDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'minDate'), null);
			var maxDate = $.datepicker._determineDate(inst, $.datepicker._get(inst, 'maxDate'), null);
			var messages = $.datepicker._defaults;
			return (minDate && maxDate ?
				$.datepicker.errorFormat(inst, messages.validateDateMinMax, [minDate, maxDate]) :
				(minDate ? $.datepicker.errorFormat(inst, messages.validateDateMin, [minDate]) :
				(maxDate ? $.datepicker.errorFormat(inst, messages.validateDateMax, [maxDate]) :
				messages.validateDate)));
		});

	/* And allow as a class rule. */
	$.validator.addClassRules('dpDate', {dpDate: true});
}

})(jQuery);
