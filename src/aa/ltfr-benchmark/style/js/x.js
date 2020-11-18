$(document).ready(function() {


	$("#user_type").change(function() {
		if ($(this).val() == '1') {

			$.ajax({
				type : "POST",
				url : "<?=base_url('admin/ajaxselect')?>",
				data : 'q=' + 'bod' + '&csrf_asaaxe=' + '<?=$this->security->get_csrf_hash();?>',
				cache : false,
				success : function(html) {
					$("#user_type_id").html(html);
					$('.province').hide();
					$('.user_type_id').show();
				}
			});

		} else if ($(this).val() == '2') {
			$.ajax({
				type : "POST",
				url : "<?=base_url('admin/ajaxselect')?>",
				data : 'q=' + 'dep' + '&csrf_asaaxe=' + '<?=$this->security->get_csrf_hash();?>',
				cache : false,
				success : function(html) {
					$("#user_type_id").html(html);
					$('.province').show();
					$('.user_type_id').show();
				}
			});

		} else if ($(this).val() == '3') {
			$.ajax({
				type : "POST",
				url : "<?=base_url('admin/ajaxselect')?>",
				data : 'q=' + 'center' + '&csrf_asaaxe=' + '<?=$this->security->get_csrf_hash();?>',
				cache : false,
				success : function(html) {
					$("#user_type_id").html(html);
					$('.province').show();
					$('.user_type_id').show();
				}
			});

		};

	});

});
