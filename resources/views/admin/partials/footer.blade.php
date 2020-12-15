</div>
</section>
<footer>
<div class="pull-right hidden-xs">
    <b>Version</b> 1.0.0       </div>
<strong>&copy; <a href="" target="_blank"> E-coomerce website</a>.</strong>
All rights reserved.
</footer>
</div>
<div class="pusher"></div>
<!-- ===============  SCRIPTS ===============-->
<div id="dialog" title="Basic dialog"></div>
<!-- sticky Js-->
<script src="/admin/js/jquery.sticky.min.js"></script>
<script src="/admin/js/theia-sticky-sidebar.min.js"></script>
<script>
! function(e) {
    var t = e(window),
        a = e(document),
        o = e("body");
    e(function() {
        o = e();
        var n = e('[data-sticky-content="true"]');
        n.length && n.theiaStickySidebar({
            additionalMarginTop: o.length ? o.outerHeight() : 0
        })
    })
}(jQuery);
</script>

<!-- MODERNIZR-->
<script src="/admin/js/modernizr.custom.js"></script>
<!-- BOOTSTRAP-->
<script src="/admin/js/bootstrap.min.js"></script>
<!-- STORAGE API-->
<script src="/admin/js/jquery.storageapi.min.js"></script>
<!-- ANIMO-->
<script src="/admin/js/animo.min.js"></script>
<!-- SELECT2-->
<script src="/admin/js/select2.min.js"></script>
<!-- Data Table -->

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script src="/admin/js/dataTables.buttons.min.js"></script>
<script src="/admin/js/buttons.print.min.js"></script>
<script src="/admin/js/buttons.colVis.min.js"></script>
<script src="/admin/js/jszip.min.js"></script>
<script src="/admin/js/pdfmake.min.js"></script>
<script src="/admin/js/vfs_fonts.js"></script>
<script src="/admin/js/buttons.html5.min.js"></script>
<script src="/admin/js/dataTables.select.min.js"></script>
<script src="/admin/js/dataTables.responsive.min.js"></script>
<script src="/admin/js/dataTables.bootstrap.min.js"></script>
<script src="/admin/js/dataTables.bootstrapPagination.js"></script>
<script src="/admin/js/style.js"></script>
<script src="/admin/js/market.js"></script>
<!-- =============== Date and time picker ===============-->
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript">
$(document).on("click", "#lfm", function() {
   $(this).filemanager('file');
});
(function ($) {
var $window = $(window);

function UTCDate() {
    return new Date(Date.UTC.apply(Date, arguments));
}

function UTCToday() {
    var today = new Date();
    return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate());
}


// Picker object

var Datepicker = function (element, options) {
    var that = this;

    this._process_options(options);

    this.element = $(element);
    this.isInline = false;
    this.isInput = this.element.is('input');
    this.component = this.element.is('.date') ? this.element.find('.add-on, .btn') : false;
    this.hasInput = this.component && this.element.find('input').length;
    if (this.component && this.component.length === 0)
        this.component = false;

    this.picker = $(DPGlobal.template);
    this._buildEvents();
    this._attachEvents();

    if (this.isInline) {
        this.picker.addClass('datepicker-inline').appendTo(this.element);
    } else {
        this.picker.addClass('datepicker-dropdown dropdown-menu');
    }

    if (this.o.rtl) {
        this.picker.addClass('datepicker-rtl');
        this.picker.find('.prev i, .next i')
            .toggleClass('icon-arrow-left icon-arrow-right');
    }


    this.viewMode = this.o.startView;

    if (this.o.calendarWeeks)
        this.picker.find('tfoot th.today')
            .attr('colspan', function (i, val) {
                return parseInt(val) + 1;
            });

    this._allow_update = false;

    this.setStartDate(this._o.startDate);
    this.setEndDate(this._o.endDate);
    this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);

    this.fillDow();
    this.fillMonths();

    this._allow_update = true;

    this.update();
    this.showMode();

    if (this.isInline) {
        this.show();
    }
};

Datepicker.prototype = {
    constructor: Datepicker,

    _process_options: function (opts) {
        // Store raw options for reference
        this._o = $.extend({}, this._o, opts);
        // Processed options
        var o = this.o = $.extend({}, this._o);

        // Check if "de-DE" style date is available, if not language should
        // fallback to 2 letter code eg "de"
        var lang = o.language;
        if (!dates[lang]) {
            lang = lang.split('-')[0];
            if (!dates[lang])
                lang = defaults.language;
        }
        o.language = lang;

        switch (o.startView) {
            case 2:
            case 'decade':
                o.startView = 2;
                break;
            case 1:
            case 'year':
                o.startView = 1;
                break;
            default:
                o.startView = 0;
        }

        switch (o.minViewMode) {
            case 1:
            case 'months':
                o.minViewMode = 1;
                break;
            case 2:
            case 'years':
                o.minViewMode = 2;
                break;
            default:
                o.minViewMode = 0;
        }

        o.startView = Math.max(o.startView, o.minViewMode);

        o.weekStart %= 7;
        o.weekEnd = ((o.weekStart + 6) % 7);

        var format = DPGlobal.parseFormat(o.format);
        if (o.startDate !== -Infinity) {
            if (!!o.startDate) {
                if (o.startDate instanceof Date)
                    o.startDate = this._local_to_utc(this._zero_time(o.startDate));
                else
                    o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
            } else {
                o.startDate = -Infinity;
            }
        }
        if (o.endDate !== Infinity) {
            if (!!o.endDate) {
                if (o.endDate instanceof Date)
                    o.endDate = this._local_to_utc(this._zero_time(o.endDate));
                else
                    o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
            } else {
                o.endDate = Infinity;
            }
        }

        o.daysOfWeekDisabled = o.daysOfWeekDisabled || [];
        if (!$.isArray(o.daysOfWeekDisabled))
            o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
        o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function (d) {
            return parseInt(d, 10);
        });

        var plc = String(o.orientation).toLowerCase().split(/\s+/g),
            _plc = o.orientation.toLowerCase();
        plc = $.grep(plc, function (word) {
            return (/^auto|left|right|top|bottom$/).test(word);
        });
        o.orientation = {x: 'auto', y: 'auto'};
        if (!_plc || _plc === 'auto')
            ; // no action
        else if (plc.length === 1) {
            switch (plc[0]) {
                case 'top':
                case 'bottom':
                    o.orientation.y = plc[0];
                    break;
                case 'left':
                case 'right':
                    o.orientation.x = plc[0];
                    break;
            }
        }
        else {
            _plc = $.grep(plc, function (word) {
                return (/^left|right$/).test(word);
            });
            o.orientation.x = _plc[0] || 'auto';

            _plc = $.grep(plc, function (word) {
                return (/^top|bottom$/).test(word);
            });
            o.orientation.y = _plc[0] || 'auto';
        }
    },
    _events: [],
    _secondaryEvents: [],
    _applyEvents: function (evs) {
        for (var i = 0, el, ev; i < evs.length; i++) {
            el = evs[i][0];
            ev = evs[i][1];
            el.on(ev);
        }
    },
    _unapplyEvents: function (evs) {
        for (var i = 0, el, ev; i < evs.length; i++) {
            el = evs[i][0];
            ev = evs[i][1];
            el.off(ev);
        }
    },
    _buildEvents: function () {
        if (this.isInput) { // single input
            this._events = [
                [this.element, {
                    focus: $.proxy(this.show, this),
                    keyup: $.proxy(this.update, this),
                    keydown: $.proxy(this.keydown, this)
                }]
            ];
        }
        else if (this.component && this.hasInput) { // component: input + button
            this._events = [
                // For components that are not readonly, allow keyboard nav
                [this.element.find('input'), {
                    focus: $.proxy(this.show, this),
                    keyup: $.proxy(this.update, this),
                    keydown: $.proxy(this.keydown, this)
                }],
                [this.component, {
                    click: $.proxy(this.show, this)
                }]
            ];
        }
        else if (this.element.is('div')) {  // inline datepicker
            this.isInline = true;
        }
        else {
            this._events = [
                [this.element, {
                    click: $.proxy(this.show, this)
                }]
            ];
        }

        this._secondaryEvents = [
            [this.picker, {
                click: $.proxy(this.click, this)
            }],
            [$(window), {
                resize: $.proxy(this.place, this)
            }],
            [$(document), {
                mousedown: $.proxy(function (e) {
                    // Clicked outside the datepicker, hide it
                    if (!(
                            this.element.is(e.target) ||
                            this.element.find(e.target).length ||
                            this.picker.is(e.target) ||
                            this.picker.find(e.target).length
                        )) {
                        this.hide();
                    }
                }, this)
            }]
        ];
    },
    _attachEvents: function () {
        this._detachEvents();
        this._applyEvents(this._events);
    },
    _detachEvents: function () {
        this._unapplyEvents(this._events);
    },
    _attachSecondaryEvents: function () {
        this._detachSecondaryEvents();
        this._applyEvents(this._secondaryEvents);
    },
    _detachSecondaryEvents: function () {
        this._unapplyEvents(this._secondaryEvents);
    },
    _trigger: function (event, altdate) {
        var date = altdate || this.date,
            local_date = this._utc_to_local(date);

        this.element.trigger({
            type: event,
            date: local_date,
            format: $.proxy(function (altformat) {
                var format = altformat || this.o.format;
                return DPGlobal.formatDate(date, format, this.o.language);
            }, this)
        });
    },

    show: function (e) {
        if (!this.isInline)
            this.picker.appendTo('body');
        this.picker.show();
        this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
        this.place();
        this._attachSecondaryEvents();
        if (e) {
            e.preventDefault();
        }
        this._trigger('show');
    },

    hide: function (e) {
        if (this.isInline) return;
        if (!this.picker.is(':visible')) return;
        this.picker.hide().detach();
        this._detachSecondaryEvents();
        this.viewMode = this.o.startView;
        this.showMode();

        if (
            this.o.forceParse &&
            (
                this.isInput && this.element.val() ||
                this.hasInput && this.element.find('input').val()
            )
        )
            this.setValue();
        this._trigger('hide');
    },

    remove: function () {
        this.hide();
        this._detachEvents();
        this._detachSecondaryEvents();
        this.picker.remove();
        delete this.element.data().datepicker;
        if (!this.isInput) {
            delete this.element.data().date;
        }
    },

    _utc_to_local: function (utc) {
        return new Date(utc.getTime() + (utc.getTimezoneOffset() * 60000));
    },
    _local_to_utc: function (local) {
        return new Date(local.getTime() - (local.getTimezoneOffset() * 60000));
    },
    _zero_time: function (local) {
        return new Date(local.getFullYear(), local.getMonth(), local.getDate());
    },
    _zero_utc_time: function (utc) {
        return new Date(Date.UTC(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate()));
    },

    getDate: function () {
        return this._utc_to_local(this.getUTCDate());
    },

    getUTCDate: function () {
        return this.date;
    },

    setDate: function (d) {
        this.setUTCDate(this._local_to_utc(d));
    },

    setUTCDate: function (d) {
        this.date = d;
        this.setValue();
    },

    setValue: function () {
        var formatted = this.getFormattedDate();
        if (!this.isInput) {
            if (this.component) {
                this.element.find('input').val(formatted).change();
            }
        } else {
            this.element.val(formatted).change();
        }
    },

    getFormattedDate: function (format) {
        if (format === undefined)
            format = this.o.format;
        return DPGlobal.formatDate(this.date, format, this.o.language);
    },

    setStartDate: function (startDate) {
        this._process_options({startDate: startDate});
        this.update();
        this.updateNavArrows();
    },

    setEndDate: function (endDate) {
        this._process_options({endDate: endDate});
        this.update();
        this.updateNavArrows();
    },

    setDaysOfWeekDisabled: function (daysOfWeekDisabled) {
        this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
        this.update();
        this.updateNavArrows();
    },

    place: function () {
        if (this.isInline) return;
        var calendarWidth = this.picker.outerWidth(),
            calendarHeight = this.picker.outerHeight(),
            visualPadding = 10,
            windowWidth = $window.width(),
            windowHeight = $window.height(),
            scrollTop = $window.scrollTop();

        var zIndex = parseInt(this.element.parents().filter(function () {
                return $(this).css('z-index') != 'auto';
            }).first().css('z-index')) + 10;
        var offset = this.component ? this.component.parent().offset() : this.element.offset();
        var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
        var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
        var left = offset.left,
            top = offset.top;

        this.picker.removeClass(
            'datepicker-orient-top datepicker-orient-bottom ' +
            'datepicker-orient-right datepicker-orient-left'
        );

        if (this.o.orientation.x !== 'auto') {
            this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
            if (this.o.orientation.x === 'right')
                left -= calendarWidth - width;
        }
        // auto x orientation is best-placement: if it crosses a window
        // edge, fudge it sideways
        else {
            // Default to left
            this.picker.addClass('datepicker-orient-left');
            if (offset.left < 0)
                left -= offset.left - visualPadding;
            else if (offset.left + calendarWidth > windowWidth)
                left = windowWidth - calendarWidth - visualPadding;
        }

        // auto y orientation is best-situation: top or bottom, no fudging,
        // decision based on which shows more of the calendar
        var yorient = this.o.orientation.y,
            top_overflow, bottom_overflow;
        if (yorient === 'auto') {
            top_overflow = -scrollTop + offset.top - calendarHeight;
            bottom_overflow = scrollTop + windowHeight - (offset.top + height + calendarHeight);
            if (Math.max(top_overflow, bottom_overflow) === bottom_overflow)
                yorient = 'top';
            else
                yorient = 'bottom';
        }
        this.picker.addClass('datepicker-orient-' + yorient);
        if (yorient === 'top')
            top += height;
        else
            top -= calendarHeight + parseInt(this.picker.css('padding-top'));

        this.picker.css({
            top: top,
            left: left,
            zIndex: zIndex
        });
    },

    _allow_update: true,
    update: function () {
        if (!this._allow_update) return;

        var oldDate = new Date(this.date),
            date, fromArgs = false;
        if (arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) {
            date = arguments[0];
            if (date instanceof Date)
                date = this._local_to_utc(date);
            fromArgs = true;
        } else {
            date = this.isInput ? this.element.val() : this.element.data('date') || this.element.find('input').val();
            delete this.element.data().date;
        }

        this.date = DPGlobal.parseDate(date, this.o.format, this.o.language);

        if (fromArgs) {
            // setting date by clicking
            this.setValue();
        } else if (date) {
            // setting date by typing
            if (oldDate.getTime() !== this.date.getTime())
                this._trigger('changeDate');
        } else {
            // clearing date
            this._trigger('clearDate');
        }

        if (this.date < this.o.startDate) {
            this.viewDate = new Date(this.o.startDate);
            this.date = new Date(this.o.startDate);
        } else if (this.date > this.o.endDate) {
            this.viewDate = new Date(this.o.endDate);
            this.date = new Date(this.o.endDate);
        } else {
            this.viewDate = new Date(this.date);
            this.date = new Date(this.date);
        }
        this.fill();
    },

    fillDow: function () {
        var dowCnt = this.o.weekStart,
            html = '<tr>';
        if (this.o.calendarWeeks) {
            var cell = '<th class="cw">&nbsp;</th>';
            html += cell;
            this.picker.find('.datepicker-days thead tr:first-child').prepend(cell);
        }
        while (dowCnt < this.o.weekStart + 7) {
            html += '<th class="dow">' + dates[this.o.language].daysMin[(dowCnt++) % 7] + '</th>';
        }
        html += '</tr>';
        this.picker.find('.datepicker-days thead').append(html);
    },

    fillMonths: function () {
        var html = '',
            i = 0;
        while (i < 12) {
            html += '<span class="month">' + dates[this.o.language].monthsShort[i++] + '</span>';
        }
        this.picker.find('.datepicker-months td').html(html);
    },

    setRange: function (range) {
        if (!range || !range.length)
            delete this.range;
        else
            this.range = $.map(range, function (d) {
                return d.valueOf();
            });
        this.fill();
    },

    getClassNames: function (date) {
        var cls = [],
            year = this.viewDate.getUTCFullYear(),
            month = this.viewDate.getUTCMonth(),
            currentDate = this.date.valueOf(),
            today = new Date();
        if (date.getUTCFullYear() < year || (date.getUTCFullYear() == year && date.getUTCMonth() < month)) {
            cls.push('old');
        } else if (date.getUTCFullYear() > year || (date.getUTCFullYear() == year && date.getUTCMonth() > month)) {
            cls.push('new');
        }
        // Compare internal UTC date with local today, not UTC today
        if (this.o.todayHighlight &&
            date.getUTCFullYear() == today.getFullYear() &&
            date.getUTCMonth() == today.getMonth() &&
            date.getUTCDate() == today.getDate()) {
            cls.push('today');
        }
        if (currentDate && date.valueOf() == currentDate) {
            cls.push('active');
        }
        if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate ||
            $.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1) {
            cls.push('disabled');
        }
        if (this.range) {
            if (date > this.range[0] && date < this.range[this.range.length - 1]) {
                cls.push('range');
            }
            if ($.inArray(date.valueOf(), this.range) != -1) {
                cls.push('selected');
            }
        }
        return cls;
    },

    fill: function () {
        var d = new Date(this.viewDate),
            year = d.getUTCFullYear(),
            month = d.getUTCMonth(),
            startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
            startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
            endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
            endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
            currentDate = this.date && this.date.valueOf(),
            tooltip;
        this.picker.find('.datepicker-days thead th.datepicker-switch')
            .text(dates[this.o.language].months[month] + ' ' + year);
        this.picker.find('tfoot th.today')
            .text(dates[this.o.language].today)
            .toggle(this.o.todayBtn !== false);
        this.picker.find('tfoot th.clear')
            .text(dates[this.o.language].clear)
            .toggle(this.o.clearBtn !== false);
        this.updateNavArrows();
        this.fillMonths();
        var prevMonth = UTCDate(year, month - 1, 28, 0, 0, 0, 0),
            day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
        prevMonth.setUTCDate(day);
        prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7) % 7);
        var nextMonth = new Date(prevMonth);
        nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
        nextMonth = nextMonth.valueOf();
        var html = [];
        var clsName;
        while (prevMonth.valueOf() < nextMonth) {
            if (prevMonth.getUTCDay() == this.o.weekStart) {
                html.push('<tr>');
                if (this.o.calendarWeeks) {
                    // ISO 8601: First week contains first thursday.
                    // ISO also states week starts on Monday, but we can be more abstract here.
                    var
                    // Start of current week: based on weekstart/current date
                        ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5),
                    // Thursday of this week
                        th = new Date(+ws + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
                    // First Thursday of year, year from thursday
                        yth = new Date(+(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay()) % 7 * 864e5),
                    // Calendar week: ms between thursdays, div ms per day, div 7 days
                        calWeek = (th - yth) / 864e5 / 7 + 1;
                    html.push('<td class="cw">' + calWeek + '</td>');

                }
            }
            clsName = this.getClassNames(prevMonth);
            clsName.push('day');

            if (this.o.beforeShowDay !== $.noop) {
                var before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
                if (before === undefined)
                    before = {};
                else if (typeof(before) === 'boolean')
                    before = {enabled: before};
                else if (typeof(before) === 'string')
                    before = {classes: before};
                if (before.enabled === false)
                    clsName.push('disabled');
                if (before.classes)
                    clsName = clsName.concat(before.classes.split(/\s+/));
                if (before.tooltip)
                    tooltip = before.tooltip;
            }

            clsName = $.unique(clsName);
            html.push('<td class="' + clsName.join(' ') + '"' + (tooltip ? ' title="' + tooltip + '"' : '') + '>' + prevMonth.getUTCDate() + '</td>');
            if (prevMonth.getUTCDay() == this.o.weekEnd) {
                html.push('</tr>');
            }
            prevMonth.setUTCDate(prevMonth.getUTCDate() + 1);
        }
        this.picker.find('.datepicker-days tbody').empty().append(html.join(''));
        var currentYear = this.date && this.date.getUTCFullYear();

        var months = this.picker.find('.datepicker-months')
            .find('th:eq(1)')
            .text(year)
            .end()
            .find('span').removeClass('active');
        if (currentYear && currentYear == year) {
            months.eq(this.date.getUTCMonth()).addClass('active');
        }
        if (year < startYear || year > endYear) {
            months.addClass('disabled');
        }
        if (year == startYear) {
            months.slice(0, startMonth).addClass('disabled');
        }
        if (year == endYear) {
            months.slice(endMonth + 1).addClass('disabled');
        }

        html = '';
        year = parseInt(year / 10, 10) * 10;
        var yearCont = this.picker.find('.datepicker-years')
            .find('th:eq(1)')
            .text(year + '-' + (year + 9))
            .end()
            .find('td');
        year -= 1;
        for (var i = -1; i < 11; i++) {
            html += '<span class="year' + (i == -1 ? ' old' : i == 10 ? ' new' : '') + (currentYear == year ? ' active' : '') + (year < startYear || year > endYear ? ' disabled' : '') + '">' + year + '</span>';
            year += 1;
        }
        yearCont.html(html);
    },

    updateNavArrows: function () {
        if (!this._allow_update) return;

        var d = new Date(this.viewDate),
            year = d.getUTCFullYear(),
            month = d.getUTCMonth();
        switch (this.viewMode) {
            case 0:
                if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()) {
                    this.picker.find('.prev').css({visibility: 'hidden'});
                } else {
                    this.picker.find('.prev').css({visibility: 'visible'});
                }
                if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()) {
                    this.picker.find('.next').css({visibility: 'hidden'});
                } else {
                    this.picker.find('.next').css({visibility: 'visible'});
                }
                break;
            case 1:
            case 2:
                if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()) {
                    this.picker.find('.prev').css({visibility: 'hidden'});
                } else {
                    this.picker.find('.prev').css({visibility: 'visible'});
                }
                if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()) {
                    this.picker.find('.next').css({visibility: 'hidden'});
                } else {
                    this.picker.find('.next').css({visibility: 'visible'});
                }
                break;
        }
    },

    click: function (e) {
        e.preventDefault();
        var target = $(e.target).closest('span, td, th');
        if (target.length == 1) {
            switch (target[0].nodeName.toLowerCase()) {
                case 'th':
                    switch (target[0].className) {
                        case 'datepicker-switch':
                            this.showMode(1);
                            break;
                        case 'prev':
                        case 'next':
                            var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className == 'prev' ? -1 : 1);
                            switch (this.viewMode) {
                                case 0:
                                    this.viewDate = this.moveMonth(this.viewDate, dir);
                                    this._trigger('changeMonth', this.viewDate);
                                    break;
                                case 1:
                                case 2:
                                    this.viewDate = this.moveYear(this.viewDate, dir);
                                    if (this.viewMode === 1)
                                        this._trigger('changeYear', this.viewDate);
                                    break;
                            }
                            this.fill();
                            break;
                        case 'today':
                            var date = new Date();
                            date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);

                            this.showMode(-2);
                            var which = this.o.todayBtn == 'linked' ? null : 'view';
                            this._setDate(date, which);
                            break;
                        case 'clear':
                            var element;
                            if (this.isInput)
                                element = this.element;
                            else if (this.component)
                                element = this.element.find('input');
                            if (element)
                                element.val("").change();
                            this._trigger('changeDate');
                            this.update();
                            if (this.o.autoclose)
                                this.hide();
                            break;
                    }
                    break;
                case 'span':
                    if (!target.is('.disabled')) {
                        this.viewDate.setUTCDate(1);
                        if (target.is('.month')) {
                            var day = 1;
                            var month = target.parent().find('span').index(target);
                            var year = this.viewDate.getUTCFullYear();
                            this.viewDate.setUTCMonth(month);
                            this._trigger('changeMonth', this.viewDate);
                            if (this.o.minViewMode === 1) {
                                this._setDate(UTCDate(year, month, day, 0, 0, 0, 0));
                            }
                        } else {
                            var year = parseInt(target.text(), 10) || 0;
                            var day = 1;
                            var month = 0;
                            this.viewDate.setUTCFullYear(year);
                            this._trigger('changeYear', this.viewDate);
                            if (this.o.minViewMode === 2) {
                                this._setDate(UTCDate(year, month, day, 0, 0, 0, 0));
                            }
                        }
                        this.showMode(-1);
                        this.fill();
                    }
                    break;
                case 'td':
                    if (target.is('.day') && !target.is('.disabled')) {
                        var day = parseInt(target.text(), 10) || 1;
                        var year = this.viewDate.getUTCFullYear(),
                            month = this.viewDate.getUTCMonth();
                        if (target.is('.old')) {
                            if (month === 0) {
                                month = 11;
                                year -= 1;
                            } else {
                                month -= 1;
                            }
                        } else if (target.is('.new')) {
                            if (month == 11) {
                                month = 0;
                                year += 1;
                            } else {
                                month += 1;
                            }
                        }
                        this._setDate(UTCDate(year, month, day, 0, 0, 0, 0));
                    }
                    break;
            }
        }
    },

    _setDate: function (date, which) {
        if (!which || which == 'date')
            this.date = new Date(date);
        if (!which || which == 'view')
            this.viewDate = new Date(date);
        this.fill();
        this.setValue();
        this._trigger('changeDate');
        var element;
        if (this.isInput) {
            element = this.element;
        } else if (this.component) {
            element = this.element.find('input');
        }
        if (element) {
            element.change();
        }
        if (this.o.autoclose && (!which || which == 'date')) {
            this.hide();
        }
    },

    moveMonth: function (date, dir) {
        if (!dir) return date;
        var new_date = new Date(date.valueOf()),
            day = new_date.getUTCDate(),
            month = new_date.getUTCMonth(),
            mag = Math.abs(dir),
            new_month, test;
        dir = dir > 0 ? 1 : -1;
        if (mag == 1) {
            test = dir == -1
                // If going back one month, make sure month is not current month
                // (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
                ? function () {
                return new_date.getUTCMonth() == month;
            }
                // If going forward one month, make sure month is as expected
                // (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
                : function () {
                return new_date.getUTCMonth() != new_month;
            };
            new_month = month + dir;
            new_date.setUTCMonth(new_month);
            // Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
            if (new_month < 0 || new_month > 11)
                new_month = (new_month + 12) % 12;
        } else {
            // For magnitudes >1, move one month at a time...
            for (var i = 0; i < mag; i++)
                // ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
                new_date = this.moveMonth(new_date, dir);
            // ...then reset the day, keeping it in the new month
            new_month = new_date.getUTCMonth();
            new_date.setUTCDate(day);
            test = function () {
                return new_month != new_date.getUTCMonth();
            };
        }
        // Common date-resetting loop -- if date is beyond end of month, make it
        // end of month
        while (test()) {
            new_date.setUTCDate(--day);
            new_date.setUTCMonth(new_month);
        }
        return new_date;
    },

    moveYear: function (date, dir) {
        return this.moveMonth(date, dir * 12);
    },

    dateWithinRange: function (date) {
        return date >= this.o.startDate && date <= this.o.endDate;
    },

    keydown: function (e) {
        if (this.picker.is(':not(:visible)')) {
            if (e.keyCode == 27) // allow escape to hide and re-show picker
                this.show();
            return;
        }
        var dateChanged = false,
            dir, day, month,
            newDate, newViewDate;
        switch (e.keyCode) {
            case 27: // escape
                this.hide();
                e.preventDefault();
                break;
            case 37: // left
            case 39: // right
                if (!this.o.keyboardNavigation) break;
                dir = e.keyCode == 37 ? -1 : 1;
                if (e.ctrlKey) {
                    newDate = this.moveYear(this.date, dir);
                    newViewDate = this.moveYear(this.viewDate, dir);
                    this._trigger('changeYear', this.viewDate);
                } else if (e.shiftKey) {
                    newDate = this.moveMonth(this.date, dir);
                    newViewDate = this.moveMonth(this.viewDate, dir);
                    this._trigger('changeMonth', this.viewDate);
                } else {
                    newDate = new Date(this.date);
                    newDate.setUTCDate(this.date.getUTCDate() + dir);
                    newViewDate = new Date(this.viewDate);
                    newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir);
                }
                if (this.dateWithinRange(newDate)) {
                    this.date = newDate;
                    this.viewDate = newViewDate;
                    this.setValue();
                    this.update();
                    e.preventDefault();
                    dateChanged = true;
                }
                break;
            case 38: // up
            case 40: // down
                if (!this.o.keyboardNavigation) break;
                dir = e.keyCode == 38 ? -1 : 1;
                if (e.ctrlKey) {
                    newDate = this.moveYear(this.date, dir);
                    newViewDate = this.moveYear(this.viewDate, dir);
                    this._trigger('changeYear', this.viewDate);
                } else if (e.shiftKey) {
                    newDate = this.moveMonth(this.date, dir);
                    newViewDate = this.moveMonth(this.viewDate, dir);
                    this._trigger('changeMonth', this.viewDate);
                } else {
                    newDate = new Date(this.date);
                    newDate.setUTCDate(this.date.getUTCDate() + dir * 7);
                    newViewDate = new Date(this.viewDate);
                    newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir * 7);
                }
                if (this.dateWithinRange(newDate)) {
                    this.date = newDate;
                    this.viewDate = newViewDate;
                    this.setValue();
                    this.update();
                    e.preventDefault();
                    dateChanged = true;
                }
                break;
            case 13: // enter
                this.hide();
                e.preventDefault();
                break;
            case 9: // tab
                this.hide();
                break;
        }
        if (dateChanged) {
            this._trigger('changeDate');
            var element;
            if (this.isInput) {
                element = this.element;
            } else if (this.component) {
                element = this.element.find('input');
            }
            if (element) {
                element.change();
            }
        }
    },

    showMode: function (dir) {
        if (dir) {
            this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
        }
        /*
         vitalets: fixing bug of very special conditions:
         jquery 1.7.1 + webkit + show inline datepicker in bootstrap popover.
         Method show() does not set display css correctly and datepicker is not shown.
         Changed to .css('display', 'block') solve the problem.
         See https://github.com/vitalets/x-editable/issues/37

         In jquery 1.7.2+ everything works fine.
         */
        //this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).show();
        this.picker.find('>div').hide().filter('.datepicker-' + DPGlobal.modes[this.viewMode].clsName).css('display', 'block');
        this.updateNavArrows();
    }
};

var DateRangePicker = function (element, options) {
    this.element = $(element);
    this.inputs = $.map(options.inputs, function (i) {
        return i.jquery ? i[0] : i;
    });
    delete options.inputs;

    $(this.inputs)
        .datepicker(options)
        .bind('changeDate', $.proxy(this.dateUpdated, this));

    this.pickers = $.map(this.inputs, function (i) {
        return $(i).data('datepicker');
    });
    this.updateDates();
};
DateRangePicker.prototype = {
    updateDates: function () {
        this.dates = $.map(this.pickers, function (i) {
            return i.date;
        });
        this.updateRanges();
    },
    updateRanges: function () {
        var range = $.map(this.dates, function (d) {
            return d.valueOf();
        });
        $.each(this.pickers, function (i, p) {
            p.setRange(range);
        });
    },
    dateUpdated: function (e) {
        var dp = $(e.target).data('datepicker'),
            new_date = dp.getUTCDate(),
            i = $.inArray(e.target, this.inputs),
            l = this.inputs.length;
        if (i == -1) return;

        if (new_date < this.dates[i]) {
            // Date being moved earlier/left
            while (i >= 0 && new_date < this.dates[i]) {
                this.pickers[i--].setUTCDate(new_date);
            }
        }
        else if (new_date > this.dates[i]) {
            // Date being moved later/right
            while (i < l && new_date > this.dates[i]) {
                this.pickers[i++].setUTCDate(new_date);
            }
        }
        this.updateDates();
    },
    remove: function () {
        $.map(this.pickers, function (p) {
            p.remove();
        });
        delete this.element.data().datepicker;
    }
};

function opts_from_el(el, prefix) {
    // Derive options from element data-attrs
    var data = $(el).data(),
        out = {}, inkey,
        replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])'),
        prefix = new RegExp('^' + prefix.toLowerCase());
    for (var key in data)
        if (prefix.test(key)) {
            inkey = key.replace(replace, function (_, a) {
                return a.toLowerCase();
            });
            out[inkey] = data[key];
        }
    return out;
}

function opts_from_locale(lang) {
    // Derive options from locale plugins
    var out = {};
    // Check if "de-DE" style date is available, if not language should
    // fallback to 2 letter code eg "de"
    if (!dates[lang]) {
        lang = lang.split('-')[0]
        if (!dates[lang])
            return;
    }
    var d = dates[lang];
    $.each(locale_opts, function (i, k) {
        if (k in d)
            out[k] = d[k];
    });
    return out;
}

var old = $.fn.datepicker;
$.fn.datepicker = function (option) {
    var args = Array.apply(null, arguments);
    args.shift();
    var internal_return,
        this_return;
    this.each(function () {
        var $this = $(this),
            data = $this.data('datepicker'),
            options = typeof option == 'object' && option;
        if (!data) {
            var elopts = opts_from_el(this, 'date'),
            // Preliminary otions
                xopts = $.extend({}, defaults, elopts, options),
                locopts = opts_from_locale(xopts.language),
            // Options priority: js args, data-attrs, locales, defaults
                opts = $.extend({}, defaults, locopts, elopts, options);
            if ($this.is('.input-daterange') || opts.inputs) {
                var ropts = {
                    inputs: opts.inputs || $this.find('input').toArray()
                };
                $this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
            }
            else {
                $this.data('datepicker', (data = new Datepicker(this, opts)));
            }
        }
        if (typeof option == 'string' && typeof data[option] == 'function') {
            internal_return = data[option].apply(data, args);
            if (internal_return !== undefined)
                return false;
        }
    });
    if (internal_return !== undefined)
        return internal_return;
    else
        return this;
};

var defaults = $.fn.datepicker.defaults = {
    autoclose: false,
    beforeShowDay: $.noop,
    calendarWeeks: false,
    clearBtn: false,
    daysOfWeekDisabled: [],
    endDate: Infinity,
    forceParse: true,
    format: 'yyyy/mm/dd',
    keyboardNavigation: true,
    language: 'en',
    minViewMode: 0,
    orientation: "auto",
    rtl: false,
    startDate: -Infinity,
    startView: 0,
    todayBtn: false,
    todayHighlight: false,
    weekStart: 0
};
var locale_opts = $.fn.datepicker.locale_opts = [
    'format',
    'rtl',
    'weekStart'
];
$.fn.datepicker.Constructor = Datepicker;
var dates = $.fn.datepicker.dates = {
    en: {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear"
    }
};
var DPGlobal = {
    modes: [
        {
            clsName: 'days',
            navFnc: 'Month',
            navStep: 1
        },
        {
            clsName: 'months',
            navFnc: 'FullYear',
            navStep: 1
        },
        {
            clsName: 'years',
            navFnc: 'FullYear',
            navStep: 10
        }],
    isLeapYear: function (year) {
        return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
    },
    getDaysInMonth: function (year, month) {
        return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
    },
    validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
    nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
    parseFormat: function (format) {
        // IE treats \0 as a string end in inputs (truncating the value),
        // so it's a bad format delimiter, anyway
        var separators = format.replace(this.validParts, '\0').split('\0'),
            parts = format.match(this.validParts);
        if (!separators || !separators.length || !parts || parts.length === 0) {
            throw new Error("Invalid date format.");
        }
        return {separators: separators, parts: parts};
    },
    parseDate: function (date, format, language) {
        if (date instanceof Date) return date;
        if (typeof format === 'string')
            format = DPGlobal.parseFormat(format);
        if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)) {
            var part_re = /([\-+]\d+)([dmwy])/,
                parts = date.match(/([\-+]\d+)([dmwy])/g),
                part, dir;
            date = new Date();
            for (var i = 0; i < parts.length; i++) {
                part = part_re.exec(parts[i]);
                dir = parseInt(part[1]);
                switch (part[2]) {
                    case 'd':
                        date.setUTCDate(date.getUTCDate() + dir);
                        break;
                    case 'm':
                        date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
                        break;
                    case 'w':
                        date.setUTCDate(date.getUTCDate() + dir * 7);
                        break;
                    case 'y':
                        date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
                        break;
                }
            }
            return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
        }
        var parts = date && date.match(this.nonpunctuation) || [],
            date = new Date(),
            parsed = {},
            setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
            setters_map = {
                yyyy: function (d, v) {
                    return d.setUTCFullYear(v);
                },
                yy: function (d, v) {
                    return d.setUTCFullYear(2000 + v);
                },
                m: function (d, v) {
                    if (isNaN(d))
                        return d;
                    v -= 1;
                    while (v < 0) v += 12;
                    v %= 12;
                    d.setUTCMonth(v);
                    while (d.getUTCMonth() != v)
                        d.setUTCDate(d.getUTCDate() - 1);
                    return d;
                },
                d: function (d, v) {
                    return d.setUTCDate(v);
                }
            },
            val, filtered, part;
        setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
        setters_map['dd'] = setters_map['d'];
        date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
        var fparts = format.parts.slice();
        // Remove noop parts
        if (parts.length != fparts.length) {
            fparts = $(fparts).filter(function (i, p) {
                return $.inArray(p, setters_order) !== -1;
            }).toArray();
        }
        // Process remainder
        if (parts.length == fparts.length) {
            for (var i = 0, cnt = fparts.length; i < cnt; i++) {
                val = parseInt(parts[i], 10);
                part = fparts[i];
                if (isNaN(val)) {
                    switch (part) {
                        case 'MM':
                            filtered = $(dates[language].months).filter(function () {
                                var m = this.slice(0, parts[i].length),
                                    p = parts[i].slice(0, m.length);
                                return m == p;
                            });
                            val = $.inArray(filtered[0], dates[language].months) + 1;
                            break;
                        case 'M':
                            filtered = $(dates[language].monthsShort).filter(function () {
                                var m = this.slice(0, parts[i].length),
                                    p = parts[i].slice(0, m.length);
                                return m == p;
                            });
                            val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
                            break;
                    }
                }
                parsed[part] = val;
            }
            for (var i = 0, _date, s; i < setters_order.length; i++) {
                s = setters_order[i];
                if (s in parsed && !isNaN(parsed[s])) {
                    _date = new Date(date);
                    setters_map[s](_date, parsed[s]);
                    if (!isNaN(_date))
                        date = _date;
                }
            }
        }
        return date;
    },
    formatDate: function (date, format, language) {
        if (typeof format === 'string')
            format = DPGlobal.parseFormat(format);
        var val = {
            d: date.getUTCDate(),
            D: dates[language].daysShort[date.getUTCDay()],
            DD: dates[language].days[date.getUTCDay()],
            m: date.getUTCMonth() + 1,
            M: dates[language].monthsShort[date.getUTCMonth()],
            MM: dates[language].months[date.getUTCMonth()],
            yy: date.getUTCFullYear().toString().substring(2),
            yyyy: date.getUTCFullYear()
        };
        val.dd = (val.d < 10 ? '0' : '') + val.d;
        val.mm = (val.m < 10 ? '0' : '') + val.m;
        var date = [],
            seps = $.extend([], format.separators);
        for (var i = 0, cnt = format.parts.length; i <= cnt; i++) {
            if (seps.length)
                date.push(seps.shift());
            date.push(val[format.parts[i]]);
        }
        return date.join('');
    },
    headTemplate: '<thead>' +
    '<tr>' +
    '<th class="prev">&laquo;</th>' +
    '<th colspan="5" class="datepicker-switch"></th>' +
    '<th class="next">&raquo;</th>' +
    '</tr>' +
    '</thead>',
    contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
    footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
};
DPGlobal.template = '<div class="datepicker">' +
    '<div class="datepicker-days">' +
    '<table class=" table-condensed">' +
    DPGlobal.headTemplate +
    '<tbody></tbody>' +
    DPGlobal.footTemplate +
    '</table>' +
    '</div>' +
    '<div class="datepicker-months">' +
    '<table class="table-condensed">' +
    DPGlobal.headTemplate +
    DPGlobal.contTemplate +
    DPGlobal.footTemplate +
    '</table>' +
    '</div>' +
    '<div class="datepicker-years">' +
    '<table class="table-condensed">' +
    DPGlobal.headTemplate +
    DPGlobal.contTemplate +
    DPGlobal.footTemplate +
    '</table>' +
    '</div>' +
    '</div>';

$.fn.datepicker.DPGlobal = DPGlobal;


/* DATEPICKER NO CONFLICT
 * =================== */

$.fn.datepicker.noConflict = function () {
    $.fn.datepicker = old;
    return this;
};


/* DATEPICKER DATA-API
 * ================== */

$(document).on(
    'focus.datepicker.data-api click.datepicker.data-api',
    '[data-provide="datepicker"]',
    function (e) {
        var $this = $(this);
        if ($this.data('datepicker')) return;
        e.preventDefault();
        // component click requires us to explicitly show it
        $this.datepicker('show');
    }
);
$(function () {
    $('[data-provide="datepicker-inline"]').datepicker();
});

}(window.jQuery));
</script><script src="/admin/js/timepicker.min.js"></script>
<!-- bootstrap-slider -->
<script src="/admin/js/bootstrap-slider.min.js"></script>
<!-- bootstrap-editable -->
<script src="/admin/js/bootstrap-editable.min.js"></script>
<!-- jquery-classyloader -->
<script src="/admin/js/jquery.classyloader.min.js"></script>
<!-- =============== Toastr ===============-->
<script src="/admin/js/toastr.min.js"></script>
<!-- =============== Toastr ===============-->
<script src="/admin/js/jasny-bootstrap.min.js"></script>
<!-- EASY PIE CHART-->
<script src="/admin/js/jquery.easypiechart.min.js"></script>

<!-- sparkline CHART-->
<script src="/admin/js/index.min.js"></script>

<script src="/admin/js/parsley.min.js"></script>

<!--- bootstrap-select ---->
<link href="/admin/css/bootstrap-select.min.css" rel="stylesheet">
<script src="/admin/js/bootstrap-select.min.js"></script>
<!--- push_notification ---->
<script src="/admin/js/push_notification.min.js"></script>

<script src='/admin/js/jquery.validate.min.js'></script>
<script src='/admin/js/jquery.form.min.js'></script>
<!--- dropzone ---->
<!--- malihu-custom-scrollbar ---->
<link rel="stylesheet" type="text/css"
href="/admin/css/jquery.mCustomScrollbar.min.css">
<script type="text/javascript"
src="/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- =============== APP SCRIPTS ===============-->
<script src="/admin/js/app.js"></script>

<script type="text/javascript">
function getCookie(name) {
var cookieValue = null;
if (document.cookie && document.cookie != '') {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = jQuery.trim(cookies[i]);
        if (cookie.substring(0, name.length + 1) == (name + '=')) {
            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
            break;
        }
    }
}
return cookieValue;
}

function reload_table() {
table.api().ajax.reload();
}

function table_url(url) {
table.api().ajax.url(url).load();
}
</script>

<script type="text/javascript">
$(document).ready(function () {
$('.datatable_action').dataTable({
    paging: true,
    "bSort": false,
    'dom': 'lBfrtip',
    buttons: [
        // {
        //     extend: 'print',
        //     text: "<i class='fa fa-print'> </i>",
        //     className: 'btn btn-danger btn-xs ml mr',
        // },
        // {
        //     extend: 'excel',
        //     text: '<i class="fa fa-file-excel-o"> </i>',
        //     className: 'btn btn-purple mr btn-xs',
        // },
        // {
        //     extend: 'csv',
        //     text: '<i class="fa fa-file-excel-o"> </i>',
        //     className: 'btn btn-primary mr btn-xs',
        // },
        // {
        //     extend: 'pdf',
        //     text: '<i class="fa fa-file-pdf-o"> </i>',
        //     className: 'btn btn-info mr btn-xs',
        // },
        // {
        //     text: "Bulk Delete",
        //     className: 'btn btn-danger bulk-delete btn-xs mr',
        //     action: function ( e, dt, node, config ) {
        //         var ids = [];
        //         var count = '';
        //         var url = $('#base').val();
        //         $.each($("input[name='delete_items']:checked"), function(){
        //             ids.push($(this).val());
        //         });
        //         count = ids.length;
        //         if(confirm("You are about to delete "+count+" record(s). This cannot be undone. Are you sure?"))
        //         {
        //             var before = ids;
        //             ids = ids.toString();
        //             var token = "{{ csrf_token() }}";
        //             $.ajax(
        //             {
        //             method: "POST",
        //             url: url,
        //             dataType: 'json',
        //             data: { _token:"{{ csrf_token() }}", _method:"DELETE", ids: ids},
        //             success: function (response)
        //             {
        //                 $.each(before, function(key, value){
        //                     $('#'+value).remove();
        //                 });
        //                 toastr.success(response);
        //             }
        //             });
        //         }
        //     }
        // }
        
    ],
    "lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
});
});
</script>
</body>
@yield('scripts')
</html>

<script type="text/javascript">
$(document).ready(function () {
$(".clock_in_button").click(function () {
    var ubtn = $(this);
    ubtn.html('Please wait' + '...');
    ubtn.addClass('disabled');
});

$('[data-ui-slider]').slider({
            });
/*
 * Multiple drop down select
 */
$(".select_box").select2({
            });
$(".select_2_to").select2({
    tags: true,
                allowClear: true,
    placeholder: 'To : Select or Write',
    tokenSeparators: [',', ' ']
});
$(".select_multi").select2({
    tags: true,
                allowClear: true,
    placeholder: 'Select Multiple',
    tokenSeparators: [',', ' ']
});
})
</script>

<script type="text/javascript">
$(document).on("click", '.is_complete input[type="checkbox"]', function () {
var task_id = $(this).data().id;
var task_complete = $(this).is(":checked");
var formData = {
    'task_id': task_id,
    'task_progress': 100,
    'task_status': 'completed'
};
$.ajax({
    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
    url: 'https://ultimate.codexcube.com/admin/tasks/completed_tasks/' + task_id, // the url where we want to POST
    data: formData, // our data object
    dataType: 'json', // what type of data do we expect back from the server
    encode: true,
    success: function (res) {
        if (res) {
            toastr[res.status](res.message);
        } else {
            alert('There was a problem with AJAX');
        }
    }
})
});
</script>
<script type="text/javascript">
$(document).ready(function () {
$('#permission_user_1').hide();
$("div.action_1").hide();
$("input[name$='permission']").click(function () {
    $("#permission_user_1").removeClass('show');
    if ($(this).attr("value") == "custom_permission") {
        $("#permission_user_1").show();
    } else {
        $("#permission_user_1").hide();
    }
});
$("input[name$='assigned_to[]']").click(function () {
    var user_id = $(this).val();
    $("#action_1" + user_id).removeClass('show');
    if (this.checked) {
        $("#action_1" + user_id).show();
    } else {
        $("#action_1" + user_id).hide();
    }

});
});
</script>

<!-- Modal -->
<style type="text/css">
.bootstrap-timepicker-widget.dropdown-menu.open {
display: inline-block;
z-index: 99999 !important;
}
</style>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

</div>
</div>
</div>
<link rel="stylesheet" href="/admin/css/select2.min.css">
<link rel="stylesheet"
href="/admin/css/select2-bootstrap.min.css">
<script src="/admin/js/select2.min.js"></script>
<!-- =============== Datepicker ===============-->
<link rel="stylesheet" href="/admin/css/datepicker.min.css">
<!-- =============== timepicker ===============-->
<link rel="stylesheet" href="/admin/css/timepicker.min.css">
<script src="/admin/js/timepicker.min.js"></script>

<script src="/admin/js/parsley.min.js"></script>
<script type="text/javascript">
$('#myModal').on('loaded.bs.modal', function () {
$(function () {
    $('.selectpicker').selectpicker({});
    $('[data-toggle="tooltip"]').tooltip();

    $('.select_box').select2({
        theme: 'bootstrap',
                    });
    $('.select_multi').select2({
        theme: 'bootstrap',
                    });
    $('.start_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
        // update "toDate" defaults whenever "fromDate" changes
    }).on('changeDate', function () {
        // set the "toDate" start to not be later than "fromDate" ends:
        $('.end_date').datepicker('setStartDate', new Date($(this).val()));
    });

    $('.end_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
// update "fromDate" defaults whenever "toDate" changes
    }).on('changeDate', function () {
        // set the "fromDate" end to not be later than "toDate" starts:
        $('.start_date').datepicker('setEndDate', new Date($(this).val()));
    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
    });
    $('.monthyear').datepicker({
        autoclose: true,
        startView: 1,
        format: 'yyyy-mm',
        minViewMode: 1,
    });
    $('.timepicker').timepicker();

    $('.timepicker2').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();

    $('input.select_one').on('change', function () {
        $('input.select_one').not(this).prop('checked', false);
    });
});
$(document).ready(function () {
    $('#permission_user').hide();
    $("div.action").hide();
    $("input[name$='permission']").click(function () {
        $("#permission_user").removeClass('show');
        if ($(this).attr("value") == "custom_permission") {
            $("#permission_user").show();
        } else {
            $("#permission_user").hide();
        }
    });

    $("input[name$='assigned_to[]']").click(function () {
        var user_id = $(this).val();
        $("#action_" + user_id).removeClass('show');
        if (this.checked) {
            $("#action_" + user_id).show();
        } else {
            $("#action_" + user_id).hide();
        }

    });
});
});
$(document).on('hide.bs.modal', '#myModal', function () {
$('#myModal').removeData('bs.modal');
});

</script>
<!-- Modal -->
<style type="text/css">
.bootstrap-timepicker-widget.dropdown-menu.open {
display: inline-block;
z-index: 99999 !important;
}
</style>
<div class="modal fade" id="myModal_lg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content" id="ajax_modal">

</div>
</div>
</div>

<link rel="stylesheet" href="/admin/css/select2.min.css">
<link rel="stylesheet"
href="/admin/css/select2-bootstrap.min.css">
<script src="/admin/js/select2.min.js"></script>
<!-- =============== Datepicker ===============-->
<link rel="stylesheet" href="/admin/css/datepicker.min.css">

<!-- =============== timepicker ===============-->
<link rel="stylesheet" href="/admin/css/timepicker.min.css">
<script src="/admin/js/timepicker.min.js"></script>


<script src="/admin/js/parsley.min.js"></script>

<script type="text/javascript">
$('#myModal_lg').on('loaded.bs.modal', function () {
$(function () {
    $('.selectpicker').selectpicker({});
    $('[data-toggle="tooltip"]').tooltip();

    $('.select_box').select2({
        theme: 'bootstrap',
                    });
    $('.select_multi').select2({
        theme: 'bootstrap',
                    });
    $('.start_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
        // update "toDate" defaults whenever "fromDate" changes
    }).on('changeDate', function () {
        // set the "toDate" start to not be later than "fromDate" ends:
        $('.end_date').datepicker('setStartDate', new Date($(this).val()));
    });

    $('.end_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
// update "fromDate" defaults whenever "toDate" changes
    }).on('changeDate', function () {
        // set the "fromDate" end to not be later than "toDate" starts:
        $('.start_date').datepicker('setEndDate', new Date($(this).val()));
    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
    });
    $('.monthyear').datepicker({
        autoclose: true,
        startView: 1,
        format: 'yyyy-mm',
        minViewMode: 1,
    });
    $('.timepicker').timepicker();

    $('.timepicker2').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();

    $('input.select_one').on('change', function () {
        $('input.select_one').not(this).prop('checked', false);
    });
});
$(document).ready(function () {
    $('#permission_user').hide();
    $("div.action").hide();
    $("input[name$='permission']").click(function () {
        $("#permission_user").removeClass('show');
        if ($(this).attr("value") == "custom_permission") {
            $("#permission_user").show();
        } else {
            $("#permission_user").hide();
        }
    });

    $("input[name$='assigned_to[]']").click(function () {
        var user_id = $(this).val();
        $("#action_" + user_id).removeClass('show');
        if (this.checked) {
            $("#action_" + user_id).show();
        } else {
            $("#action_" + user_id).hide();
        }

    });
});
});
//abort ajax request on modal close.
$(document).on('hide.bs.modal', '#myModal_lg', function () {
$('#myModal_lg').removeData('bs.modal');
});
</script>
<!-- Modal -->
<style type="text/css">

.bootstrap-timepicker-widget.dropdown-menu.open {
display: inline-block;
z-index: 99999 !important;
}
</style>
<div class="modal fade" id="myModal_large" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-large">
<div class="modal-content">

</div>
</div>
</div>
<!-- SELECT2-->

<link rel="stylesheet" href="/admin/css/select2.min.css">
<link rel="stylesheet"
href="/admin/css/select2-bootstrap.min.css">
<script src="/admin/js/select2.min.js"></script>


<!-- =============== Datepicker ===============-->
<link rel="stylesheet" href="/admin/css/datepicker.min.css">
<!-- =============== timepicker ===============-->
<link rel="stylesheet" href="/admin/css/timepicker.min.css">
<script src="/admin/js/timepicker.min.js"></script>


<script src="/admin/js/parsley.min.js"></script>

<script type="text/javascript">
$('#myModal_large').on('loaded.bs.modal', function () {
$(function () {
    $('.selectpicker').selectpicker({});

    $('.select_box').select2({
        theme: 'bootstrap',
                    });
    $('.select_multi').select2({
        theme: 'bootstrap',
                    });
    $('.start_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
        // update "toDate" defaults whenever "fromDate" changes
    }).on('changeDate', function () {
        // set the "toDate" start to not be later than "fromDate" ends:
        $('.end_date').datepicker('setStartDate', new Date($(this).val()));
    });

    $('.end_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
// update "fromDate" defaults whenever "toDate" changes
    }).on('changeDate', function () {
        // set the "fromDate" end to not be later than "toDate" starts:
        $('.start_date').datepicker('setEndDate', new Date($(this).val()));
    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
    });
    $('.timepicker2').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();


    $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();

    $('input.select_one').on('change', function () {
        $('input.select_one').not(this).prop('checked', false);
    });
});

$(document).ready(function () {
    // Init bootstrap select picker
    function init_selectpicker() {
        $('body').find('select.selectpicker').not('.ajax-search').selectpicker({
            showSubtext: true,
        });
    }

    $('#permission_user').hide();
    $("div.action").hide();
    $("input[name$='permission']").click(function () {
        $("#permission_user").removeClass('show');
        if ($(this).attr("value") == "custom_permission") {
            $("#permission_user").show();
        } else {
            $("#permission_user").hide();
        }
    });

    $("input[name$='assigned_to[]']").click(function () {
        var user_id = $(this).val();
        $("#action_" + user_id).removeClass('show');
        if (this.checked) {
            $("#action_" + user_id).show();
        } else {
            $("#action_" + user_id).hide();
        }

    });
});
});
$(document).on('hide.bs.modal', '#myModal_large', function () {
$('#myModal_large').removeData('bs.modal');
});
</script>
<!-- Modal -->
<style type="text/css">
.bootstrap-timepicker-widget.dropdown-menu.open {
display: inline-block;
z-index: 99999 !important;
}
</style>
<div class="modal fade" id="myModal_extra_lg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal_extra_lg">
<div class="modal-content">

</div>
</div>
</div>

<script src="/admin/js/parsley.min.js"></script>

<script type="text/javascript">
$('#myModal_extra_lg').on('loaded.bs.modal', function () {
$(function () {
    $('.selectpicker').selectpicker({});
    $('.select_box').select2({
        theme: 'bootstrap',
                    });
    $('.select_multi').select2({
        theme: 'bootstrap',
                    });
    $('.start_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
        // update "toDate" defaults whenever "fromDate" changes
    }).on('changeDate', function () {
        // set the "toDate" start to not be later than "fromDate" ends:
        $('.end_date').datepicker('setStartDate', new Date($(this).val()));
    });

    $('.end_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked"
// update "fromDate" defaults whenever "toDate" changes
    }).on('changeDate', function () {
        // set the "fromDate" end to not be later than "toDate" starts:
        $('.start_date').datepicker('setEndDate', new Date($(this).val()));
    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
    });
    $('.timepicker2').timepicker({
        minuteStep: 1,
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();

    $('.note-toolbar .note-fontsize,.note-toolbar .note-help,.note-toolbar .note-fontname,.note-toolbar .note-height,.note-toolbar .note-table').remove();

    $('input.select_one').on('change', function () {
        $('input.select_one').not(this).prop('checked', false);
    });
});
$(document).ready(function () {
    // Init bootstrap select picker
    function init_selectpicker() {
        $('body').find('select.selectpicker').not('.ajax-search').selectpicker({
            showSubtext: true,
        });
    }

    $('#permission_user').hide();
    $("div.action").hide();
    $("input[name$='permission']").click(function () {
        $("#permission_user").removeClass('show');
        if ($(this).attr("value") == "custom_permission") {
            $("#permission_user").show();
        } else {
            $("#permission_user").hide();
        }
    });

    $("input[name$='assigned_to[]']").click(function () {
        var user_id = $(this).val();
        $("#action_" + user_id).removeClass('show');
        if (this.checked) {
            $("#action_" + user_id).show();
        } else {
            $("#action_" + user_id).hide();
        }

    });
});
});
$(document).on('hide.bs.modal', '#myModal_extra_lg', function () {
$('#myModal_extra_lg').removeData('bs.modal');
});
</script>

<script src="{{ asset('/vendor/fancybox/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script>

$("#name").keyup(function (){
    let Slug = $('#name').val();
    document.getElementById("slug").value = convertToSlug(Slug);
});

$('.iframe-btn').fancybox({
    'width'		: 900,
    'height'	: 400,
    'type'		: 'iframe',
    'autoScale'    	: false
});

</script>

<script>
    setTimeout(function(){
        $(".alert").removeClass('fadeInRight');
        $(".alert").addClass('fadeOutRight');
    }, 5000);

    $(function () {

        $('.iframe-btn').fancybox({
            'width'		: 900,
            'height'	: 600,
            'type'		: 'iframe',
            'autoScale'    	: false
        });

        tinymce.PluginManager.add('twitter_url', function(editor, url) {
        var icon_url='/admin/img/twitter.png';

            editor.on('init', function (args) {
                editor_id = args.target.id;

            });
            editor.addButton('twitter_url',
                {
                    text:false,
                    icon: true,
                    image:icon_url,

                    onclick: function () {

                        editor.windowManager.open({
                            title: 'Twitter Embed',

                            body: [
                                {   type: 'textbox',
                                    size: 40,
                                    height: '100px',
                                    name: 'twitter',
                                    label: 'twitter'
                                }
                            ],
                            onsubmit: function(e) {

                                var tweetEmbedCode = e.data.twitter;

                                $.ajax({
                                    url: "https://publish.twitter.com/oembed?url="+tweetEmbedCode,
                                    dataType: "jsonp",
                                    async: false,
                                    success: function(data){
                                        // $("#embedCode").val(data.html);
                                        // $("#preview").html(data.html)
                                        tinyMCE.activeEditor.insertContent(
                                            '<div class="div_border" contenteditable="false">' +
                                                '<img class="twitter-embed-image" src="'+icon_url+'" alt="image" />'
                                                +data.html+
                                            '</div>');

                                    },
                                    error: function (jqXHR, exception) {
                                        var msg = '';
                                        if (jqXHR.status === 0) {
                                            msg = 'Not connect.\n Verify Network.';
                                        } else if (jqXHR.status == 404) {
                                            msg = 'Requested page not found. [404]';
                                        } else if (jqXHR.status == 500) {
                                            msg = 'Internal Server Error [500].';
                                        } else if (exception === 'parsererror') {
                                            msg = 'Requested JSON parse failed.';
                                        } else if (exception === 'timeout') {
                                            msg = 'Time out error.';
                                        } else if (exception === 'abort') {
                                            msg = 'Ajax request aborted.';
                                        } else {
                                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                        }
                                        alert(msg);
                                    },
                                });
                                setTimeout(function() {
                                    iframe.contentWindow.twttr.widgets.load();

                                }, 1000)
                            }
                        });
                    }
                });
        });

        var editor_config = {

            path_absolute : "/",
            selector: "textarea.editor",
            height: 400,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality imagetools",
                "emoticons template paste textcolor responsivefilemanager colorpicker textpattern preview twitter_url"
            ],
            menubar: false,
            branding: false,
            //toolbar: "responsivefilemanager | insertfile | styleselect | bold italic | alignleft aligncenter alignright alignjustify | hr | forecolor backcolor blockquote | bullist numlist outdent indent | link media | code | preview | twitter_url",
            toolbar1: "bold italic underline | alignleft aligncenter alignright | bullist numlist | styleselect | responsivefilemanager | link unlink | forecolor backcolor  | preview code ",
               //toolbar2: "",
               image_advtab: true ,
            valid_elements : '+*[*]',

            extended_valid_elements: "+iframe[width|height|name|align|class|frameborder|allowfullscreen|allow|src|*]," +
            "script[language|type|async|src|charset]" +
            "img[*]" +
            "embed[width|height|name|flashvars|src|bgcolor|align|play|loop|quality|allowscriptaccess|type|pluginspage]" +
            "blockquote[dir|style|cite|class|id|lang|onclick|ondblclick"
            +"|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout"
            +"|onmouseover|onmouseup|title]",

            content_css: ['/admin/css/twitter.css?' + new Date().getTime(),
                '//fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap'
            ],
            relative_urls: false,
            filemanager_access_key:"061e0de5b8d667cbb7548b551420eb821075e7a6" ,
            filemanager_sort_by: "date",
            filemanager_descending: 1,
            external_filemanager_path:"/vendor/filemanager",
            filemanager_title:"File Manager" ,
            external_plugins: { "filemanager" : "/vendor/filemanager/plugin.min.js"},
            image_class_list: [
                {title: 'img-responsive', value: 'img-responsive'},
            ],
            image_caption: true
        };

        tinymce.init(editor_config);

    });

    function responsive_filemanager_callback(field_id){
        var url=jQuery('#'+field_id).val();
        $("#"+field_id+"holder").attr("src",url);
        $('#thumbnail'+field_id).val(url.replace('http://news.local',''));
    }
</script>
<script>
	@if(Session::has('message'))
		var type="{{Session::get('alert-type','info')}}"
		switch(type){
			case 'info':
         toastr.info("{{ Session::get('message') }}");
         break;
      case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;
     	case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;
      case 'error':
        toastr.error("{{ Session::get('message') }}");
        break;
		}
	@endif
</script>
<script>
   $(document).ready(function() {
      $('#all').click(function() {
        $('input[type="checkbox"]').prop('checked', this.checked);
      })
    });
</script>