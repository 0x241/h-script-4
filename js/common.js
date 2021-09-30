var indexGraphMass = [{
	valueField: 'val1',
	color: '#ffd200',
	point: {
		size: 6,
		border: {
			width: '2px',
			visible: true,
			color: 'white'
		},
		hoverStyle: {
			border: {
				width: '2px',
				visible: true,
				color: 'white'
			},
			color: '#ffd200',
			size: 7
		}
	}
}, {
	valueField: 'val2',
	color: '#0c92c9',
	point: {
		size: 6,
		border: {
			width: '2px',
			visible: true,
			color: 'white'
		},
		hoverStyle: {
			border: {
				width: '2px',
				visible: true,
				color: 'white'
			},
			color: '#0c92c9',
			size: 7
		}
	}
}, {
	valueField: 'val3',
	color: '#0cc99a',
	point: {
		size: 6,
		border: {
			width: '2px',
			visible: true,
			color: 'white'
		},
		hoverStyle: {
			border: {
				width: '2px',
				visible: true,
				color: 'white'
			},
			color: '#0cc99a',
			size: 7
		}
	}
}, {
	valueField: 'val4',
	color: 'red',
	point: {
		size: 6,
		border: {
			width: '2px',
			visible: true,
			color: 'white'
		},
		hoverStyle: {
			border: {
				width: '2px',
				visible: true,
				color: 'white'
			},
			color: '#0cc99a',
			size: 7
		}
	}
}];

var indexGraph = {
	commonSeriesSettings: {
		argumentField: 'date',
		point: {size: 5}
	},
	series: indexGraphMass,
	argumentAxis: {
		valueMarginsEnabled: false,
		discreteAxisDivisionMode: 'crossLabels',
		label: {alignment: 'left'}
	},
	valueAxis: {
		min: 0,
		max: 3500,
		tickInterval: 500,
		label: {
			precision: 5,
			customizeText: function(){
				return this.valueText/1000 + ' k';
			}
		},
		visible: true
	},
	legend: {visible: false},
	tooltip: {
		enabled: true,
		color: '#7f7f7f',
		paddingLeftRight: 10,
		paddingTopBottom: 4,
		arrowLength: 5,
		font: {
	    	color: 'white',
	        family: 'Arial',
	        size: 12
	    },
	    customizeText: function (e) {
	    	return e.argumentText+' - '+e.originalValue;
	    }
	}
};

function chartInit( chartContainer, chartDefaultProps ) {
	var chartData = JSON.parse( $(chartContainer).attr('data-source1') );

	for ( i=0; i<chartData.length; i++ ) {
		for ( prop in chartData[i] ) {
			prop !== 'date' ? chartData[i][prop] = parseFloat( chartData[i][prop] ) :'';
		}
	}
	$(chartContainer).dxChart($.extend({}, {dataSource: chartData}, chartDefaultProps));
}


(function($){
	// Chart general
	chartInit($('.chart-stat-container'),indexGraph);

	// Chart hits
	chartInit(
		$('.stat-graph-container'), {
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
		}
	);

	function chartInit( chartContainer, chartDefaultProps ) {
		chartContainer.each(function() {
			var chartData = JSON.parse( $(this).attr('data-source') );

			for ( i=0; i<chartData.length; i++ ) {
				for ( prop in chartData[i] ) {
					prop !== 'date' ? chartData[i][prop] = parseFloat( chartData[i][prop] ) :'';
				}
			}

			$(this).dxChart( $.extend( {}, { dataSource: chartData }, chartDefaultProps ) );
		})
	}

})(jQuery);