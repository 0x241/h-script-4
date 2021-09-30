var indexGraphMass = [{
	valueField: 'val1',
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
	valueField: 'val2',
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
	valueField: 'val3',
	color: '#ffd200',
	point: {
		size: 6,
		border: {
			width: '2px',
			visible: true,
			color: '#'
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
	valueField: 'val4',
	color: '#ff7f02',
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
			color: '#ff7f02',
			size: 7
		}
	}
}
, {
	valueField: 'val5',
	color: '#ff0202',
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
			color: '#ff0202',
			size: 7
		}
	}
}
, {
	valueField: 'val6',
	color: '#ff02af',
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
			color: '#ff02af',
			size: 7
		}
	}
}
, {
	valueField: 'val7',
	color: '#c20cff',
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
			color: '#c20cff',
			size: 7
		}
	}
}, {
	valueField: 'val8',
	color: '#4c16ff',
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
			color: '#4c16ff',
			size: 7
		}
	}
}, {
	valueField: 'val9',
	color: '#1f63ff',
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
			color: '#1f63ff',
			size: 7
		}
	}
}
, {
	valueField: 'val10',
	color: '#28fff7',
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
			color: '#28fff7',
			size: 7
		}
	}
}
, {
	valueField: 'val11',
	color: '#ADFF2F',
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
			color: '#ADFF2F',
			size: 7
		}
	}
}
, {
	valueField: 'val12',
	color: '#CD5C5C',
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
			color: '#CD5C5C',
			size: 7
		}
	}
}
, {
	valueField: 'val13',
	color: '#F4A460',
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
			color: '#F4A460',
			size: 7
		}
	}
}
, {
	valueField: 'val14',
	color: '#D02090',
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
			color: '#D02090',
			size: 7
		}
	}
}
, {
	valueField: 'val15',
	color: '#104E8B',
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
			color: '#104E8B',
			size: 7
		}
	}
}
, {
	valueField: 'val16',
	color: '#FF3030',
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
			color: '#FF3030',
			size: 7
		}
	}
}
];

function chartInit( chartContainer, chartDefaultProps ) {
	var chartData = JSON.parse( $(chartContainer).attr('data-source') );

	for ( i=0; i<chartData.length; i++ ) {
		for ( prop in chartData[i] ) {
			prop !== 'date' ? chartData[i][prop] = parseFloat( chartData[i][prop] ) :'';
		}
	}
	$(chartContainer).dxChart($.extend({}, {dataSource: chartData}, chartDefaultProps));
}