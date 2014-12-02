var editor; // use a global for the submit and return data rendering in the examples
 
$(document).ready(function() {

    $('#consultations_table').dataTable( {
		
		"sPaginationType": "bs_normal",

		"aaSorting": [[ 0, "desc" ]],
        "aoColumns": [
            { "bSortable": true, "sType": "date" },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
			{ "bSortable": true },
            { "bSortable": true },
			{ "bSortable": true },
			{ "bSortable": false },
        ],
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
	
	$('#consultations_table').each(function(){
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