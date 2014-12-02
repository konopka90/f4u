
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
					data: {	tree : tree, table: 'product' },  
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
			url: BASE_URL + 'admin/product/remove/' + id,
			type: 'POST',
			dataType: 'json',
			data: {ajax : true},
			timeout: 2000,
			beforeSend  : function() {
				$('#preloader').show();
			},
			success: function(result) {	
				$('#preloader').hide();	
				
				$('#product_' + result.id).slideUp().remove();
				
			}
		});
	});
	
	
} );