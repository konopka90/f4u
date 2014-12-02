
$(document).ready(function() {
	
	//ZMIANA KOLEJNOŚCI
	if ($(".sortable").length > 0){
		$('.sortable').nestedSortable({
	
			handle: '.move',
			items: 'li',
			listType: 'ol',
			forcePlaceholderSize: true,
			placeholder: 'alert-warning alert margin_b_5',
			update: function() {
	
				var tree = Array();
				tree = $(this).nestedSortable('toArray');
	
				var add_custom_data = function (x, idx) {
					
					var structure_id =  tree[idx].item_id;
					
					tree[idx].ip = $('#structure_' + structure_id).data('ip');
					tree[idx].name = $('#structure_' + structure_id).data('name');
				}
				
				tree.forEach(add_custom_data);
				
				$.ajax({  
					type: "POST",  
					url: BASE_URL + 'admin/page/update_order',  
					data: {	tree : tree },  
					success: function() {
					
					}
				});  
				
			}
	
		});
	}
	
	//USUWANIE
	$('body').on('click', ".btn_remove_row", function() {
	
		var id = $(this).data('id');
		
		$.ajax({
			url: BASE_URL + 'admin/structure/remove/' + id,
			type: 'POST',
			dataType: 'json',
			data: {ajax : true},
			timeout: 2000,
			beforeSend  : function() {
				$('#preloader').show();
			},
			success: function(result) {	
				$('#preloader').hide();	
				
				$('#structure_' + result.id).slideUp().remove();
				
			}
		});
	});
	
	//PUBLIKACJA
	$('body').on('click', '.btn_publication_change', function() {
		
		var id = $(this).data('id');
		var publication = $(this).data('publication');
		
		$.ajax({
			url: BASE_URL + 'admin/page/change_publication/' + id + '/' + publication,
			type: 'POST',
			dataType: 'json',
			data: {  },
			beforeSend  : function() {
				$('#preloader').show();
			},
			success: function(result) {	
				$('#preloader').hide();	
				
				if(result.publication == 1) {
					$('#btn_publication_change_' + id).find('i').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
					$('#btn_publication_change_' + id).data('publication', 1);
				} else {
					$('#btn_publication_change_' + id).find('i').addClass('glyphicon-eye-close').removeClass('glyphicon-eye-open');
					$('#btn_publication_change_' + id).data('publication', 0);
				}
				
			}
		});	
		
	});

} );