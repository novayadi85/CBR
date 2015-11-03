jQuery(document).ready(function(){
	jQuery('#profile .btn-loading').click(function(){
		var url = SITE_URL+'profile/loadprofile';
		var month = jQuery('#profile select#bulan').val();
		var year = jQuery('#profile select#year').val();
		var office_id = jQuery('#profile select#office_id').val();
		//if(office_id = '') { alert('Silakan pilih kantor cabang.'); return false; }
        if(office_id == '' || year == '') {
			alert('Lengkapi pilihan terlebih dulu...');				
			return false;
		} 
		jQuery(function() {
            jQuery.ajax({
                url: url,
                dataType: 'html',
                type: 'post',
                data: {action:'CheckData',office_id:office_id,year:year,month:month},
                beforeSend: function () {
					jQuery('.subcriteria-ajax').html('');
					jQuery('#profile .btn-loading').text('Awaiting....');
				},
				complete: function() {
					
				},
                success: function(response) {
					
					jQuery('.subcriteria-ajax').html(response);
					jQuery('#profile .btn-loading').text('Load');
                }
            })
            return false;
        });
	});
	
});