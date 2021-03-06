EasySocial.module('apps/fields/event/startend/content', function($) {
    var module = this;

    var lang = EasySocial.options.momentLang;

    EasySocial
    .require()
    .library('datetimepicker', 'moment/' + lang)
    .language('FIELDS_EVENT_STARTEND_VALIDATION_DATETIME_START_REQUIRED', 'FIELDS_EVENT_STARTEND_VALIDATION_DATETIME_END_REQUIRED')
    .done(function($) {
        EasySocial.Controller('Field.Event.Startend', {
            defaultOptions: {
                dateFormat: '',
                allowTime: true,
                allowTimezone: true,
                disallowPast: false,
                minuteStepping: 15,
                yearfrom: '',
                yearto: '',
                requiredEnd: false,
                allday: false,

                '{startForm}': '[data-event-start]',
                '{endForm}': '[data-event-end]',

                '{timezone}': '[data-event-timezone]'
            }
        }, function(self) {
            return {
                init: function() {
                    // There is an issue with yearto where if I set yearto = 2014, I won't be able to select 2014 dates. This is a bug in datetimepicker. Currently, temporarily, we manually add 1 to the value if there are value set.
                    if (!$.isEmpty(self.options.yearto)) {
                        self.options.yearto = parseInt(self.options.yearto) + 1;
                    } else {
                        self.options.yearto = new Date().getFullYear() + 100
                    }

                    self.options.yearfrom = self.options.yearfrom || 1930;

                    self.startDatetime = self.startForm().addController('EasySocial.Controller.Field.Event.Startend.Form', {
                        '{parent}': self,
                        type: 'start'
                    });

                    self.endDatetime = self.endForm().addController('EasySocial.Controller.Field.Event.Startend.Form', {
                        '{parent}': self,
                        type: 'end'
                    });
                },

                '{self} onSubmit': function(el, ev, register) {
                    register.push(self.validateInput());
                },

                validateInput: function() {
                    self.clearError();

                    if ($.isEmpty(self.startDatetime.datetime().val())) {
                        self.raiseError($.language('FIELDS_EVENT_STARTEND_VALIDATION_DATETIME_START_REQUIRED'));

                        return false;
                    }

                    if (self.options.requireEnd && $.isEmpty(self.endDatetime.datetime().val())) {
                        self.raiseError($.language('FIELDS_EVENT_STARTEND_VALIDATION_DATETIME_END_REQUIRED'));

                        return false;
                    }

                    return true;
                },

                raiseError: function(msg) {
                    self.trigger('error', [msg]);
                },

                clearError: function() {
                    self.trigger('clear');
                }
            }
        });

        EasySocial.Controller('Field.Event.Startend.Form', {
            defaultOptions: {
                type: null,

                '{picker}': '[data-picker]',
                '{toggle}': '[data-picker-toggle]',
                '{datetime}': '[data-datetime]'
            }
        }, function(self) {
            return {
                init: function() {
                    self.load();
                },

                '{window} easysocial.fields.allday.change': function(el, ev, value) {
                    self.datetimepicker('destroy');

                    self.parent.options.allday = value == 1 ? true : false;

                    self.load();
                },

                // We move this here because there is a possibility that we want to "reinit"
                load: function() {
                    var minDate = new $.moment();

                    if (self.parent.options.disallowPast) {
                        // Minus 1 on the date to allow today
                        minDate.date(minDate.date() - 1);
                    } else {
                        minDate.year(self.parent.options.yearfrom);
                    }

                    var allowTime = self.parent.options.allowTime && !self.parent.options.allday;

                    var dateFormat = self.parent.options.dateFormat;

                    // If time is not allowed, then we remove the time part
                    // Since the format is always (10 chars) (remaining chars)
                    // We just substr by 10 chars
                    if (!allowTime) {
                        dateFormat = dateFormat.substr(0, 10);
                    }

                    self.picker()._datetimepicker({
                        component: "es",
                        useCurrent: false,
                        format: dateFormat,
                        minDate: minDate,
                        maxDate: new $.moment({y: self.parent.options.yearto}),
                        icons: {
                            time: 'glyphicon glyphicon-time',
                            date: 'glyphicon glyphicon-calendar',
                            up: 'glyphicon glyphicon-chevron-up',
                            down: 'glyphicon glyphicon-chevron-down'
                        },
                        sideBySide: false,
                        pickTime: allowTime,
                        minuteStepping: parseInt(self.parent.options.minuteStepping),
                        language: lang
                    });

                    var date = self.datetime().val();

                    if (!$.isEmpty(date)) {
                        // Datetimepicker is using moment.js, hence here we manually create a moment object to pass in instead of passing in date time string
                        // This is because datetimepicker.setDate function passes along the format from self.options.calendarDateFormat to generate the date object, which will render moment.js to generate an invalid dateobject
                        // self.options.calendarDateFormat is only for display purposes
                        // Raw date object is always in SQL format
                        var dateObj = $.moment(date);

                        self.datetimepicker('setDate', dateObj);
                    }
                },

                datetimepicker: function(name, value) {
                    return self.picker().data('DateTimePicker')[name](value);
                },

                '{toggle} click': function() {
                    self.picker().focus();
                },

                '{picker} dp.change': function(el, ev) {
                    self.setDateValue(ev.date.toDate());

                    self.parent.element.trigger('event' + $.String.capitalize(self.options.type), [ev.date]);
                },

                '{picker} change': function(el, ev) {
                    if ($.isEmpty(el.val())) {
                        self.datetime().val('');
                    }
                },

                setDateValue: function(date) {
                    // Convert the date object into sql format and set it into the input
                    self.datetime().val(date.getFullYear() + '-' +
                                        ('00' + (date.getMonth()+1)).slice(-2) + '-' +
                                        ('00' + date.getDate()).slice(-2) + ' ' +
                                        ('00' + date.getHours()).slice(-2) + ':' +
                                        ('00' + date.getMinutes()).slice(-2) + ':' +
                                        ('00' + date.getSeconds()).slice(-2));
                },

                /*'{clear} click': function(el, ev) {
                    // Brute force way to clear the datetimepicker
                    self.datetimepicker('setValue', new $.moment());

                    self.picker().val('');

                    self.datetime().val('');

                    el.hide();

                    self.parent.element.trigger('event' + $.String.capitalize(self.options.type), [null]);
                },*/

                '{parent} eventStart': function(el, ev, date) {
                    if (self.options.type === 'start') {
                        return;
                    }

                    // self.datetimepicker('setMinDate', date ? date : new $.moment({y: self.parent.options.yearfrom}));
                },

                '{parent} eventEnd': function(el, ev, date) {
                    if (self.options.type === 'end') {
                        return;
                    }

                    // self.datetimepicker('setMaxDate', date ? date : new $.moment({y: self.parent.options.yearto}));
                }
            }
        });

        module.resolve();
    });
});
