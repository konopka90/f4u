$(document).ready(function() {
	
	var message = '<div class="alert alert-info bordered"><a class="close" data-dismiss="alert" href="#">×</a>Brak wybranych pozycji</div>';

	//USERZY
	show_selected_users();
	
    $('body').on('change', '#select_user_id', function() {
		show_selected_users();
	});
	
	function show_selected_users() {
		
		var count = $("#select_user_id :selected").length;
		if(count > 0) {
			
			var j = 1;
			$('#div_user_id').html('<ul class="list-group">');
			$('#select_user_id option').each(function(i) {
				if(this.selected) {
					$('#div_user_id').append('<li class="list-group-item"><span class="badge">' + j + '</span> ' +  $(this).text() + '</li>');
					j++;
				}
			});
			$('#div_user_id').append('</ul>');
			
		} else {
			$('#div_user_id').html(message);	
		}
	
	}
		
	//ZAMOWIENIA
	show_selected_orders();
	
    $('body').on('change', '#select_order_id', function() {
		show_selected_orders();
	});
	
	function show_selected_orders() {
		
		var count = $("#select_order_id :selected").length;
		if(count > 0) {
			
			var j = 1;
			$('#div_order_id').html('<ul class="list-group">');
			$('#select_order_id option').each(function(i) {
				if(this.selected) {
					$('#div_order_id').append('<li class="list-group-item"><span class="badge">' + j + '</span> ' +  $(this).text() + '</li>');
					j++;
				}
			});
			$('#div_user_id').append('</ul>');
			
		} else {
			$('#div_order_id').html(message);	
		}
		
	}

});