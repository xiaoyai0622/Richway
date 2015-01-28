jQuery(document).ready(function($) {

    var star_system = $('#uou-stars-system');
	var postId = star_system.data('post-id');
    var homeurl = $('#get_homeurl').data('homeurl');
	var star = star_system.find('.rating-send').find('.star');

    $(document).on("mouseenter", "#uou-stars-system .rating-send .star", function() {
        var id = parseInt($(this).data('star-id'));
        $(this).parent().find('> i').slice(0,id).removeClass('fa-star-o').addClass('fa-star');
    });
    $(document).on("mouseleave", "#uou-stars-system .rating-send .star", function() {
        var rating = $(this).parent().parent();
        var mean = parseInt(rating.data('rated-value'));
        $(this).parent().find('> i').removeClass('fa-star').addClass('fa-star-o');
        $(this).parent().find('> i').slice(0,mean).removeClass('fa-star-o').addClass('fa-star');
    });

    $(document).on("click", "#uou-stars-system .rating-send .star", function(event) {
        var rating = $(this).parent().parent();
        var ratingId = rating.data('rating-id');
        var id = parseInt($(this).data('star-id'));
        $(this).parent().find('> i').slice(0,id).removeClass('fa-star-o').addClass('fa-star');
        rating.data('rated-value',id).addClass('already');
    });


	$(document).on("click", "#uou-stars-system button.send-rating", function(event) {
		var values = {};
		var validator = true;
        console.log(postId);
        star_system.find('.rating-send').find('.rating').each(function(event) {
			if($(this).data('rated-value') == '0'){
				validator = false;
			}
			values[$(this).data('rating-id')] = $(this).data('rated-value');
		});
		if(!star_system.find('#rating-name').val()) { validator = false };

		if(validator) {
			$.post(MyAjax.ajaxurl, { action: 'action_item_rate', nonce: MyAjax.ajaxnonce, post_id: postId, rating_name: $('#uou-stars-system #rating-name').val(), rating_description: $('#uou-stars-system #rating-description').val(), rating_values: values }, function(data, textStatus, xhr) {
				if(data != "nonce" && data != "already" && data != "nonce"){
					$('#uou-stars-system').replaceWith(data);
					if ($.fn.inFieldLabels) {
                        star_system.find('label').inFieldLabels();
					}
				}
                console.log(values);
			});
		} else {
			// show error message
            star_system.find('.rating-send').find('.message.success').hide();
            star_system.find('.rating-send').find('.message.error').show();
            star_system.find('.rating-send').find('.message.br').show();
		}
	});

});