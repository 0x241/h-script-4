var lang = 'ru';

jQuery(document).ready(function(){
    jQuery('.menuLeft>ul>li>a').click(function() {
        if (!jQuery(this).parent().hasClass('active')) {
            jQuery('.menuLeft>ul>li>ul').slideUp();
            jQuery(this).next('ul').slideDown(function(){
                jQuery('.menuLeft>ul>li').removeClass('active');
                jQuery(this).parent().addClass('active');
            });
        } else {
            jQuery(this).next('ul').slideToggle(function(){
                jQuery(this).parent().removeClass('active');
            });

        }
        return false;
    })

    jQuery('#menu-button').click(function(){
        if (parseInt(jQuery('.menuLeft').css('left'), 10) || 0) left=0; else left = jQuery('.menuLeft').outerWidth();

        if (left==0) content=264; else content=10;
        if (jQuery('.menuLeft').css('position')=='fixed') jQuery('section.content').animate({paddingLeft: content});

        if (!jQuery('body').hasClass('show-menu')) jQuery('.menuLeft').show();
        jQuery('.menuLeft').animate({left: -left},function(){
            jQuery('body').toggleClass('show-menu');
            if (!jQuery('body').hasClass('show-menu')) jQuery('.menuLeft').hide();

            if ($('.chart-stat-container').length) {
                var majorChart = $('.chart-stat-container').dxChart("instance");
                majorChart.option({
                    commonAxisSettings: {}
                });
            }
        });

    })

    jQuery('.ydpicker_click').click(function(){
        jQuery(this).next('.ydpicker-block').slideToggle();
    })

    var lastAction = 'select';
    $($('.ydpicker-wrapper').find('tbody')).on('click','td:not(.ydpicker-other-month)',function() {
        lastAction = 'calendar';
    })
    $('#ydpicker-input-range').on('change',function() {
        lastAction = 'select';
        switch ($(this).val()) {
                case 'now':
                    date = new Date();
                    date.setHours(0,0,0,0);

                    var date_tmp=date;

                    jQuery('#ydpicker-input-from').trigger('setDate', date);
                    jQuery('#ydpicker-input-to').trigger('setDate', date);

                    var begin_month=date_tmp.getMonth()+1;
                    var end_month=date_tmp.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(date_tmp.getFullYear()+'/'+begin_month+'/'+date_tmp.getDate());
                    jQuery('#ydpicker-input-to').val(date_tmp.getFullYear()+'/'+end_month+'/'+date_tmp.getDate());

                    break;
                case 'yesterday':
                    date = new Date();
                    date.setHours(0,0,0,0);
                    date.setDate(date.getDate()-1);

                    var date_tmp=date;

                    jQuery('#ydpicker-input-from').trigger('setDate', date);
                    jQuery('#ydpicker-input-to').trigger('setDate', date);

                    var begin_month=date_tmp.getMonth()+1;
                    var end_month=date_tmp.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(date_tmp.getFullYear()+'/'+begin_month+'/'+date_tmp.getDate());
                    jQuery('#ydpicker-input-to').val(date_tmp.getFullYear()+'/'+end_month+'/'+date_tmp.getDate());

                    break;
                case 'lastweek':
                    beginDate = new Date();
                    beginDate.setHours(0,0,0,0);
                    beginDate.setDate(beginDate.getDate()-(beginDate.getDay()?beginDate.getDay()-1:6) - 7);

                    var beginDate_tmp=beginDate;

                    jQuery('#ydpicker-input-from').trigger('setDate', beginDate);

                    endDate = new Date();
                    endDate.setHours(0,0,0,0);
                    endDate.setDate(endDate.getDate()-(endDate.getDay()?endDate.getDay()-1:6)-1);

                    var endDate_tmp=endDate;

                    jQuery('#ydpicker-input-to').trigger('setDate', endDate);

                    var begin_month=beginDate_tmp.getMonth()+1;
                    var end_month=endDate_tmp.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(beginDate_tmp.getFullYear()+'/'+begin_month+'/'+beginDate_tmp.getDate());
                    jQuery('#ydpicker-input-to').val(endDate_tmp.getFullYear()+'/'+end_month+'/'+endDate_tmp.getDate());


                    break;
                case 'lastmonth':
                    date = new Date();
                    date.setHours(0,0,0,0);
                    beginDate = new Date(date.getFullYear(), date.getMonth()-1, 1);

                    var beginDate_tmp=beginDate;

                    jQuery('#ydpicker-input-from').trigger('setDate', beginDate);

                    endDate = new Date(date.getFullYear(), date.getMonth(), 0);

                    var endDate_tmp=endDate;

                    jQuery('#ydpicker-input-to').trigger('setDate', endDate);

                    var begin_month=beginDate_tmp.getMonth()+1;
                    var end_month=endDate_tmp.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(beginDate_tmp.getFullYear()+'/'+begin_month+'/'+beginDate_tmp.getDate());
                    jQuery('#ydpicker-input-to').val(endDate_tmp.getFullYear()+'/'+end_month+'/'+endDate_tmp.getDate());

                    break;
                case 'last7days':
                    beginDate = new Date();
                    beginDate.setHours(0,0,0,0);
                    beginDate.setDate(beginDate.getDate()-7);

                    var beginDate_tmp=beginDate;

                    jQuery('#ydpicker-input-from').trigger('setDate', beginDate);

                    endDate = new Date();
                    endDate.setHours(0,0,0,0);

                    var endDate_tmp=endDate;

                    jQuery('#ydpicker-input-to').trigger('setDate', endDate);

                    var begin_month=beginDate_tmp.getMonth()+1;
                    var end_month=endDate_tmp.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(beginDate_tmp.getFullYear()+'/'+begin_month+'/'+beginDate_tmp.getDate());
                    jQuery('#ydpicker-input-to').val(endDate_tmp.getFullYear()+'/'+end_month+'/'+endDate_tmp.getDate());


                    break;
                case 'last30days':
                    beginDate = new Date();
                    beginDate.setHours(0,0,0,0);
                    beginDate.setDate(beginDate.getDate()-30);

                    var beginDate_tmp=beginDate;

                    jQuery('#ydpicker-input-from').trigger('setDate', beginDate);

                    endDate = new Date();
                    endDate.setHours(0,0,0,0);

                    var endDate_tmp=endDate;

                    jQuery('#ydpicker-input-to').trigger('setDate', endDate);

                    var begin_month=beginDate_tmp.getMonth()+1;
                    var end_month=endDate_tmp.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(beginDate_tmp.getFullYear()+'/'+begin_month+'/'+beginDate_tmp.getDate());
                    jQuery('#ydpicker-input-to').val(endDate_tmp.getFullYear()+'/'+end_month+'/'+endDate_tmp.getDate());

                    break;
            }
    })

    jQuery('#ydpicker-accept').click(function() {
        if (lastAction=='calendar')
        {
            if (jQuery('#ydpicker-input-from').val() && jQuery('#ydpicker-input-to').val()) separate = ' - '; else separate = '';
            jQuery('#ydpicker-date-range').val(jQuery('#ydpicker-input-from').val()+separate+jQuery('#ydpicker-input-to').val());
        }
        else
        {
            /*
            switch ($('#ydpicker-input-range').val())
            {
                case 'now':
                    date = new Date();
                    dateStr = date.getDate()+' '+i18n[lang].monthsShort[date.getMonth()]+' '+date.getFullYear();

                    var begin_month=date.getMonth()+1;
                    var end_month=date.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(date.getFullYear()+'/'+begin_month+'/'+date.getDate());
                    jQuery('#ydpicker-input-to').val(date.getFullYear()+'/'+end_month+'/'+date.getDate());

                    break;
                case 'yesterday':
                    date = new Date();
                    date.setDate(date.getDate()-1);
                    dateStr = date.getDate()+' '+i18n[lang].monthsShort[date.getMonth()]+' '+date.getFullYear();

                    var begin_month=date.getMonth()+1;
                    var end_month=date.getMonth()+1;

                    jQuery('#ydpicker-input-from').val(date.getFullYear()+'/'+begin_month+'/'+date.getDate());
                    jQuery('#ydpicker-input-to').val(date.getFullYear()+'/'+end_month+'/'+date.getDate());

                    break;
                case 'lastweek':
                    beginDate = new Date();
                    beginDate.setDate(beginDate.getDate()-(beginDate.getDay()?beginDate.getDay()-1:6) - 7);

                    endDate = new Date();
                    endDate.setDate(endDate.getDate()-(endDate.getDay()?endDate.getDay()-1:6)-1);


                    var begin_month=beginDate.getMonth()+1;
                    var end_month=endDate.getMonth()+1;

                    dateStr = beginDate.getDate()+' '+i18n[lang].monthsShort[beginDate.getMonth()]+' '+beginDate.getFullYear()+' - '+endDate.getDate()+' '+i18n[lang].monthsShort[endDate.getMonth()]+' '+endDate.getFullYear();


                    jQuery('#ydpicker-input-from').val(beginDate.getFullYear()+'/'+begin_month+'/'+beginDate.getDate());
                    jQuery('#ydpicker-input-to').val(endDate.getFullYear()+'/'+end_month+'/'+endDate.getDate());

                    break;
                case 'lastmonth':
                    date = new Date();
                    beginDate = new Date(date.getFullYear(), date.getMonth()-1, 1);

                    endDate = new Date(date.getFullYear(), date.getMonth(), 0);

                    var begin_month=beginDate.getMonth()+1;
                    var end_month=endDate.getMonth()+1;

                    dateStr = beginDate.getDate()+' '+i18n[lang].monthsShort[beginDate.getMonth()]+' '+beginDate.getFullYear()+' - '+endDate.getDate()+' '+i18n[lang].monthsShort[endDate.getMonth()]+' '+endDate.getFullYear();

                    jQuery('#ydpicker-input-from').val(beginDate.getFullYear()+'/'+begin_month+'/'+beginDate.getDate());
                    jQuery('#ydpicker-input-to').val(endDate.getFullYear()+'/'+end_month+'/'+endDate.getDate());

                    break;
                case 'last7days':
                    beginDate = new Date();
                    beginDate.setDate(beginDate.getDate()-7);

                    endDate = new Date();

                    var begin_month=beginDate.getMonth()+1;
                    var end_month=endDate.getMonth()+1;

                    dateStr = beginDate.getDate()+' '+i18n[lang].monthsShort[beginDate.getMonth()]+' '+beginDate.getFullYear()+' - '+endDate.getDate()+' '+i18n[lang].monthsShort[endDate.getMonth()]+' '+endDate.getFullYear();

                    jQuery('#ydpicker-input-from').val(beginDate.getFullYear()+'/'+begin_month+'/'+beginDate.getDate());
                    jQuery('#ydpicker-input-to').val(endDate.getFullYear()+'/'+end_month+'/'+endDate.getDate());

                    break;
                case 'last30days':
                    beginDate = new Date();
                    beginDate.setDate(beginDate.getDate()-30);

                    endDate = new Date();

                    var begin_month=beginDate.getMonth()+1;
                    var end_month=endDate.getMonth()+1;

                    dateStr = beginDate.getDate()+' '+i18n[lang].monthsShort[beginDate.getMonth()]+' '+beginDate.getFullYear()+' - '+endDate.getDate()+' '+i18n[lang].monthsShort[endDate.getMonth()]+' '+endDate.getFullYear();

                    jQuery('#ydpicker-input-from').val(beginDate.getFullYear()+'/'+begin_month+'/'+beginDate.getDate());
                    jQuery('#ydpicker-input-to').val(endDate.getFullYear()+'/'+end_month+'/'+endDate.getDate());

                    break;
            }
            */
            var date_start=jQuery('#ydpicker-input-from').val().split('/');
            var date_end=jQuery('#ydpicker-input-to').val().split('/');

            if (jQuery('#ydpicker-input-from').val() == jQuery('#ydpicker-input-to').val())
            {
               dateStr = date_start[2]+' '+i18n[lang].monthsShort[date_start[1]-1]+' '+date_start[0];
            }
            else
            {
               dateStr = date_start[2]+' '+i18n[lang].monthsShort[date_start[1]-1]+' '+date_start[0]+' - '+date_end[2]+' '+i18n[lang].monthsShort[date_end[1]-1]+' '+date_end[0];
            }

            jQuery('#ydpicker-date-range').val(dateStr);
        }
        jQuery(this).parents('.ydpicker-block').slideUp();
        return false;
    })

    jQuery('#ydpicker-exit').click(function(){
        jQuery(this).parents('.ydpicker-block').slideUp();
        return false;
    })

    if (jQuery('.tooltip').length)
        jQuery('.tooltip').qtip({
            position: {
                my: 'top left',
                at: 'bottom center'
            }
        });

    if (jQuery(window).outerWidth()<768) jQuery('body').removeClass('show-menu');

    jQuery('.cap-plus-list-el input').click(function(){
        if (jQuery(this).is(':checked')) {
            block = '<div class="cap-elements-el cfix">'+jQuery("<div>").append(jQuery(this).siblings('label').clone()).html()+'</div>';
            jQuery('.cap-elements').append(block);
        } else {
            jQuery('.cap-elements').find('.'+jQuery(this).siblings('label').attr('class')).parent('div').animate({width: "0px"}, function(){jQuery(this).remove()});
        }
    })

    jQuery('.cdp-plus-list-el input').click(function(){
        jQuery('#'+jQuery(this).attr('data-id')).slideToggle();
        chartInit(jQuery('#'+jQuery(this).attr('data-id')+' .stat-graph-container'),smallGraph);
    })

    jQuery("select").selectBox();

})

jQuery(window).resize(function() {
    if (jQuery(window).outerWidth()<768) {
        jQuery('.menuLeft').animate({left: -jQuery('.menuLeft').outerWidth()},function(){
            jQuery('body').removeClass('show-menu');
        })
    }
});