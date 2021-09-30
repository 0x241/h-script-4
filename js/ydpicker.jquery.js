var i18n = {
            ru:{ // Russian
                months:[
                    'Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'
                ],
                monthsShort:[
                    'янв.','фев.','мар.','апр.','май','июнь','июль','авг.','сент.','окт.','нбр.','дек.'
                ],
                dayOfWeek:[
                    "Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"
                ]
            },
            en:{ // English
                months: [
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
                ],
                dayOfWeek: [
                    "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"
                ]
            },
            de:{ // German
                months:[
                    'Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'
                ],
                dayOfWeek:[
                    "So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"
                ]
            }
    };

(function($) {


    $.fn.ydpicker = function(options) {
        var options = $.extend({
            id: '',
            lang: 'ru',
            headerTitle: '',
            formatDate: 'Y/m/d',
            startDate: new Date(),
            onAction: 'click',
            coupleCalendarId: '',
            directionCoupleCalendar: '',
            closeAfterSelecting: false
        }, options);

        return $(this).each(function() {
            if (options.id) var ydpicker = $(options.id);
            else {
                var ydpicker = $("<div/>", {
                    "class": "ydpicker-calendar",
                    style: "top: "+($(this).offset().top+$(this).outerHeight())+"px; left: "+$(this).offset().left+"px;",
                }).appendTo("body");
            }

            options.startDate.setHours(0,0,0,0);

            var input = $(this),
                currentDate = options.startDate,
                currenMonth = currentDate.getMonth(),
                header = $('<div class="ydpicker-header cfix"><span class="ydpicker-header-prev">&#9001;</span><span class="ydpicker-header-next">&#9002;</span><div class="ydpicker-header-month"><span>'+options.headerTitle+'</span>'+i18n[options.lang].months[currenMonth]+'</div></div>'),
                content = $('<div class="ydpicker-content"><table><thead><th>'+i18n[options.lang].dayOfWeek.join('</th><th>')+'</th></thead><tbody></tbody></table></div>'),
                btnPrev = header.find('.ydpicker-header-prev'),
                btnNext = header.find('.ydpicker-header-next'),
                selectedDate = options.startDate,
                setColorRange = false,
                dateCouple = '';

            ydpicker.addClass('ydpicker-wrapper');
            ydpicker.html(header);
            ydpicker.append(content);

            $(btnPrev).on(options.onAction,function(){
                createYDPicker(-1);
            })

            $(btnNext).on(options.onAction,function(){
                createYDPicker(1);
            })

            if (!options.id) {
                $(this).on(options.onAction,function(){

                    ydpicker.slideToggle();
                })
            }

            $(ydpicker.find('tbody')).on(options.onAction,'td:not(.ydpicker-other-month)',function() {
                ydpicker.find('td.active').removeClass('active');
                $(this).addClass('active');
                if (input) input.val($(this).attr('data-year')+'/'+$(this).attr('data-month')+'/'+$(this).attr('data-date'));

                selectedDate = new Date($(this).attr('data-year'), $(this).attr('data-month')-1, $(this).attr('data-date'));

                if (options.coupleCalendarId)
                    if (dateCouple) {
                        input.trigger('setColorRange', selectedDate);
                    } else $(options.coupleCalendarId).trigger('setDateCouple', selectedDate);

                if (options.closeAfterSelecting) 
                {
                  ydpicker.slideUp();
                }
            })

            var createYDPicker = function(index) {
                if (index!=0) {
                    currentDate.setMonth(currentDate.getMonth()+index);
                    currenMonth = currentDate.getMonth();
                }
                ydpicker.find('.ydpicker-header-month').html('<span>'+options.headerTitle+'</span>'+i18n[options.lang].months[currenMonth]);

                beginDate = new Date(currentDate.getFullYear(), currenMonth, 1);
                beginDate.setDate(1-(beginDate.getDay()?beginDate.getDay()-1:6));

                endDate = new Date(currentDate.getFullYear(), currenMonth+1, 0);
                endDate.setDate(endDate.getDate()+(endDate.getDay()?(7-endDate.getDay()):0));

                dates = dateRange(beginDate,endDate);
                
                
                ydpicker.find('tbody').html(dates);
            }

            var dateRange = function(from, to) {
                currentM = from.getMonth();
                incr = from.getDate();

                table='<tr>';
                while (from<to) {
                    table+='</tr><tr>';
                    for (var j = 0; j<7; j++){
                        currentD = from.getDate();
                        if(from.getMonth()!= currentM) {
                            currentM = from.getMonth();
                            incr = 1;
                        }

                        tdClass = '';
                        if (selectedDate && selectedDate.getTime()==from.getTime()) tdClass += 'active ';
                        if (currenMonth!=currentM) tdClass += 'ydpicker-other-month ';
                        if (setColorRange)
                            switch (options.directionCoupleCalendar) {
                                case 'from':
                                    if (selectedDate<=from && dateCouple>=from) tdClass += 'ydpicker-in-range ';
                                    break;
                                case 'to':
                                    if (selectedDate>=from && dateCouple<=from) tdClass += 'ydpicker-in-range ';
                                    break;
                            }

                        table+='<td data-date="'+currentD+'" data-month="'+(currentM+1)+'" data-year="'+from.getFullYear()+'"'+' class="'+tdClass+'"><div>'+currentD+'<div></td>';
                        from.setDate(++incr);
                    }
                }
                table+='</tr>';
                return table;
            }

            input.bind('setColorRange', function(even, d){
                setColorRange = true;
                createYDPicker(0);
                $(options.coupleCalendarId).trigger('setColorRangeSameMonth', d);
            });

            input.bind('setColorRangeSameMonth', function(even,d){
                dateCouple = d;
                setColorRange = true;
                createYDPicker(0);
            });

            input.bind('setDateCouple', function(even,d){dateCouple = d;});

            input.bind('setDate', function(even,d){
                selectedDate = d;
                currenMonth = selectedDate.getMonth();
                createYDPicker(0);

                if (options.coupleCalendarId) {
                    $(options.coupleCalendarId).trigger('setDateCouple', selectedDate);
                    input.trigger('setColorRange', selectedDate);
                }
            });

           createYDPicker(0);

        });
    };
})(jQuery);