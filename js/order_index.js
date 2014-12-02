var editor; // use a global for the submit and return data rendering in the examples
 
$(document).ready(function() {


	$('.orders_filter_dr').daterangepicker({
			format: 'YYYY-MM-DD',
			opens: 'left',
			separator: ' do ',
			ranges: {
				'Ostatni tydzień': [moment().subtract('days', 6), moment()],
				'Ostatnie 2 tygodnie': [moment().subtract('days', 13), moment()],
				'Ten miesiąc': [moment().startOf('month'), moment()],
				
			},
			endDate: moment(),
			locale: {
				applyLabel: "Zapisz",
				cancelLabel: "Anuluj",
				fromLabel: "Od",
				toLabel: "Do",
				firstDay: 1,
				customRangeLabel: 'Wybierz przedział',
				daysOfWeek: ['Nie', 'Pon', 'Wt', 'Śr', 'Cz', 'Pią', 'Sob'],
				monthNames: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
			},	
		}
	);



    $('#orders_table').dataTable( {
		
		"sPaginationType": "bs_normal",

		"aaSorting": [[ 0, "desc" ]],

		"iDisplayLength": 25, 
		"oLanguage": {
			"sProcessing":   "Proszę czekać...",
			"sLengthMenu":   "Pokaż _MENU_ pozycji",
			"sZeroRecords":  "Nie znaleziono żadnych pasujących indeksów",
			"sInfo":         "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
			"sInfoEmpty":    "Pozycji 0 z 0 dostępnych",
			"sInfoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
			"sInfoPostFix":  "",
			"sSearch":       "",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Pierwsza",
				"sPrevious": "Poprzednia",
				"sNext":     "Następna",
				"sLast":     "Ostatnia",
			}
		}
    });
	
	$('#orders_table').each(function(){
		var datatable = $(this);
		// SEARCH - Add the placeholder for Search and Turn this into in-line form control
		var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
		search_input.attr('placeholder', 'Szukaj...');
		search_input.addClass('form-control input-sm');
		// LENGTH - Inline-Form control
		var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
		length_sel.addClass('form-control input-sm');
	});
	
	
	

} );