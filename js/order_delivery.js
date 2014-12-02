$(document).ready(function() { 

	jsPlumb.bind("ready", function() {
		
		var common = {
			endpoint: ["Dot", {
				radius: 1
			}],
			endpointStyle: {
				fillStyle: "#89332f"
			},
			paintStyle: {
				strokeStyle: "#89332f",
				lineWidth: 1
			},
			connector:[ "StateMachine", { curviness: -20 } ],
			connectorStyle: {
				lineWidth: 1,
				strokeStyle: "#89332f"
			},
			overlays: [
				["Arrow", {
					width: 10,
					length: 10,
					foldback: 1,
					location: 1,
					id: "arrow"
				}]
			],
			anchor: [ "Perimeter", { shape:"Circle" } ]
		};
		
		jsPlumb.Defaults.Container = $("#deliveries_table");
		
		$('#deliveries_table tbody tr td .moved').each(function() {
			if ($('#' + $(this).attr('id')).length > 0 && $('#' + $(this).data('moved')).length > 0) {
				jsPlumb.connect({ source: $(this).attr('id'), target: $(this).data('moved') }, common);	
			
			}
		});
		
		/*
		jsPlumb.Defaults.Container = $("#plumb");
		jsPlumb.connect({ 
			source: 'delivery_2013-12-20',
			target: 'delivery_2013-12-30',
			endpoint: ["Dot", {
				radius: 1
			}],
			endpointStyle: {
				fillStyle: "#d8544f"
			},
			paintStyle: {
				strokeStyle: "#d8544f",
				lineWidth: 1
			},
			connector:[ "StateMachine", { curviness: -20 } ],
			connectorStyle: {
				lineWidth: 1,
				strokeStyle: "#d8544f"
			},
			overlays: [
				["Arrow", {
					width: 10,
					length: 10,
					foldback: 1,
					location: 1,
					id: "arrow"
				}]
			],
			anchor: [ "Perimeter", { shape:"Circle" } ]
		});
		/**/
	});

	
});
