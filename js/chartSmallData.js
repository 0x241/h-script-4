var smallGraph = {
    commonSeriesSettings: {
        type: 'area',
        argumentField: 'date',
        point: {
            size: 1
        },
        border: {
            width: 1,
            color: '#0c92c9',
            visible: true
        }
    },
    series: {
        valueField: 'val',
        color: '#e0f1f8'
    },
    argumentAxis: {
        label: {
            visible: false
        }
    },
    valueAxis: {
        tickInterval: 1000,
        label: {
            visible: false
        },
        grid: {
            visible: false
        }
    },
    legend: {
        visible: false
    }
};

function chartSmallInit( chartContainer, chartDefaultProps ) {
    var chartData = JSON.parse( $(chartContainer).attr('data-source') );

    for ( i=0; i<chartData.length; i++ ) {
        for ( prop in chartData[i] ) {
            prop !== 'date' ? chartData[i][prop] = parseFloat( chartData[i][prop] ) :'';
        }
    }
    $(chartContainer).dxChart($.extend({}, {dataSource: chartData}, chartDefaultProps));
}


(function($){
    // Chart hits
    chartSmallInit($('.stat-graph-container-registration'),smallGraph);
    chartSmallInit($('.stat-graph-container-accrual'),smallGraph);
    chartSmallInit($('.stat-graph-container-deposit'),smallGraph);
    chartSmallInit($('.stat-graph-container-contribution'),smallGraph);
    chartSmallInit($('.stat-graph-container-withdraw'),smallGraph);
    chartSmallInit($('.stat-graph-container-output'),smallGraph);
    chartSmallInit($('.stat-graph-container-reffs'),smallGraph);

})(jQuery);