function resizeHeight(element){
    var maxHeight = 0;
    jQuery(element).each(function(){
        var height = jQuery(this).height();
        if(height > maxHeight) maxHeight = height;
    });
    jQuery(element).each(function(){
        jQuery(this).height(maxHeight);
    });
}

jQuery(document).ready(function(){
    jQuery(document).on('click', '.reroll', function(e){
        var thisItem = jQuery(this);
        e.preventDefault();
        var item = jQuery(thisItem).parents('.item').find('.item_name').html();
        var item_id = jQuery(thisItem).parents('.item').find('input[name="item_id"]').val();
        var item_type = jQuery(thisItem).parents('.item').find('input[name="item_type"]').val();

        console.log(item_type);
        jQuery.ajax({
            type: "POST",
            url: 'reroll.php',
            data:{item_id: item_id, item_type: item_type},
            timeout: 3000,
            error: function(request,error) {
                console.log(error);
            },
            success: function(data) {
                var item = JSON.parse(data);
                jQuery(thisItem).parents('.item').find('.item_name').html(item['name']);
                jQuery(thisItem).parents('.item').find('input[name="item_id"]').val(item['id']);
            }
        });
    });
    jQuery(document).on('click', '.god-reroll', function(e){
        var thisGod = jQuery(this);
        e.preventDefault();
        var god = jQuery(thisGod).parents('#god').find('.god_name').html();
        var god_id = jQuery(thisGod).parents('#god').find('input[name="god_id"]').val();
        var god_type = jQuery(thisGod).parents('#god').find('input[name="god_type"]').val();

        jQuery.ajax({
            type: "POST",
            url: 'reroll-god.php',
            data:{god_id: god_id, god_type: god_type},
            timeout: 3000,
            error: function(request,error) {
                console.log(error);
            },
            success: function(data) {
                var retGod = JSON.parse(data);
                jQuery(thisGod).parents('#god').find('.god_name').html(retGod['name']);
                jQuery(thisGod).parents('#god').find('input[name="god_id"]').val(retGod['id']);
            }
        });
    });
});