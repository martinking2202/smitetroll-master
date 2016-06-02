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

function reroll_item(newType, item_count, exclusions, rerolled){
    var thisItem = jQuery('.item').eq(item_count);

    item_exclusions_JSON = JSON.stringify(exclusions);

    jQuery.ajax({
        type: "POST",
        url: 'reroll.php',
        async: true,
        data:{item_exclusions: item_exclusions_JSON, item_type: newType, rerolled: rerolled},
        timeout: 3000,
        error: function(request,error) {
            console.log(error);
        },
        success: function(data) {
            var itemJSON = JSON.parse(data);
            var item = JSON.parse(itemJSON);
            console.log(item);
            jQuery(thisItem).find('.item_name').html(item['itemname']);
            jQuery(thisItem).find('input[name="item_id"]').val(item['itemid']);
            jQuery(thisItem).find('img').attr('src', item['itemimage']);
        }
    });
}
                        
jQuery(document).ready(function(){

    var count = 3;

    jQuery(document).on('click', '.reroll', function(e){
        if(count > 0){
            var thisItem = jQuery(this);
            e.preventDefault();
            var item_exclusions = [];

            jQuery('.item').each(function(){
                item_exclusions.push(jQuery(this).find('input[name="item_id"]').val());
            });

            item_exclusions = JSON.stringify(item_exclusions);

            var item = jQuery(thisItem).parents('.item').find('.item_name').html();
            var item_type = jQuery(thisItem).parents('.item').find('input[name="item_type"]').val();

            jQuery.ajax({
                type: "POST",
                url: 'reroll.php',
                data:{item_exclusions: item_exclusions, item_type: item_type, rerolled: item},
                timeout: 3000,
                error: function(request,error) {
                    console.log(error);
                },
                success: function(data) {
                    if(jQuery('div#god-overlay').length){
                        jQuery('div#god-overlay').fadeIn();
                    }
                    else {
                        jQuery('div#god').prepend('<div id="god-overlay"></div>');
                    }
                    setTimeout(function(){
                        jQuery('div#god-overlay').fadeOut();
                    }, 5000);
                    count--;
                    var jsonItem = JSON.parse(data);
                    var item = JSON.parse(jsonItem);
                    jQuery(thisItem).parents('.item').find('.item_name').html(item['itemname']);
                    jQuery(thisItem).parents('.item').find('input[name="item_id"]').val(item['itemid']);
                    jQuery(thisItem).parents('.item').find('img').attr('src', item['itemimage']);
                    jQuery('#count').html(count);
                    jQuery.ajax({
                        type: "POST",
                        url: 'get-reroll-exceptions.php',
                        data:{exception_name: item['itemname']},
                        timeout: 3000,
                        error: function(request,error) {
                            console.log(error);
                        },
                        success: function(data) {
                            var retExceptions = JSON.parse(data);

                            if(retExceptions.length){
                                if(jQuery('div#god-overlay').length){
                                    jQuery('div#god-overlay').fadeIn();
                                }
                                else {
                                    jQuery('div#god').prepend('<div id="god-overlay"></div>');
                                }
                                setTimeout(function(){
                                    jQuery('div#god-overlay').fadeOut();
                                }, 5000);

                                for(i = 0; i < retExceptions.length; i++){
                                    var type = retExceptions[i]['type'];
                                    var placement = retExceptions[i]['placement'];
                                    var url = retExceptions[i]['url'];
                                    var src = retExceptions[i]['src'];

                                    if(retExceptions[i]['element']){ 
                                        var element = retExceptions[i]['element'];
                                        var elementHTML = '';
                                        if(element === 'audio'){
                                            elementHTML = '<audio autoplay><source src="'+src+'.ogg" type="audio/ogg"><source src="'+src+'.mp3" type="audio/mpeg"></audio>';
                                        }
                                    }

                                    if(type === 'file' || type === 'css_file' || type === 'js_file'){
                                        jQuery('')
                                    }

                                    if(type === 'css_file' || type === 'js_file'){
                                        var html = ''
                                        if(type === 'css_file') {
                                            html = '<link rel="stylesheet" type="text/css" href="'+url+'" />';
                                        }
                                        else if(type === 'js_file'){
                                            html = '<script type="text/javascript" src="'+url+'"></script>';
                                        }
                                        jQuery('footer').append(html);
                                    }
                                    else {
                                        jQuery('#'+placement+'_exception').append(elementHTML);
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }
    });
    jQuery(document).on('click', '.god-reroll', function(e){
        if(count > 0){
            var thisGod = jQuery(this);
            e.preventDefault();
            var god = jQuery(thisGod).parents('#god').find('.god_name').html();
            var god_id = jQuery(thisGod).parents('#god').find('input[name="god_id"]').val();
            var god_type = jQuery(thisGod).parents('#god').find('input[name="god_type"]').val();
            jQuery.ajax({
                type: "POST",
                url: 'reroll-god.php',
                data:{god_id: god_id, god_type: god_type, rerolled: god},
                timeout: 3000,
                error: function(request,error) {
                    console.log(error);
                },
                success: function(data) {
                    count--;
                    var retGod = JSON.parse(data);
                    jQuery(thisGod).parents('.god').find('.god_name').html(retGod['name']);
                    jQuery(thisGod).parents('.god').find('input[name="god_id"]').val(retGod['id']);
                    jQuery(thisGod).parents('.god').find('img').attr('src', retGod['image']);
                    jQuery('#count').html(count);
                    jQuery.ajax({
                        type: "POST",
                        url: 'get-reroll-exceptions.php',
                        data:{exception_name: retGod['name']},
                        timeout: 3000,
                        error: function(request,error) {
                            console.log(error);
                        },
                        success: function(data) {
                            var retExceptions = JSON.parse(data);

                            if(retExceptions.length){
                                if(jQuery('div#god-overlay').length){
                                    jQuery('div#god-overlay').fadeIn();
                                }
                                else {
                                    jQuery('div#god').prepend('<div id="god-overlay"></div>');
                                }
                                setTimeout(function(){
                                    jQuery('div#god-overlay').fadeOut();
                                }, 5000);

                                for(i = 0; i < retExceptions.length; i++){
                                    var type = retExceptions[i]['type'];
                                    var placement = retExceptions[i]['placement'];
                                    var url = retExceptions[i]['url'];
                                    var src = retExceptions[i]['src'];

                                    if(retExceptions[i]['element']){ 
                                        var element = retExceptions[i]['element'];
                                        var elementHTML = '';
                                        if(element === 'audio'){
                                            elementHTML = '<audio autoplay><source src="'+src+'.ogg" type="audio/ogg"><source src="'+src+'.mp3" type="audio/mpeg"></audio>';
                                        }
                                    }

                                    if(type === 'file' || type === 'css_file' || type === 'js_file'){
                                        jQuery('')
                                    }

                                    if(type === 'css_file' || type === 'js_file'){
                                        var html = ''
                                        if(type === 'css_file') {
                                            html = '<link rel="stylesheet" type="text/css" href="'+url+'" />';
                                        }
                                        else if(type === 'js_file'){
                                            html = '<script type="text/javascript" src="'+url+'"></script>';
                                        }
                                        jQuery('footer').append(html);
                                    }
                                    else {
                                        jQuery('#'+placement+'_exception').append(elementHTML);
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }
    });
    jQuery(document).on('click', '#reroll-all', function(){
        if(count === 3){
            var thisButton = jQuery(this);
            var god = jQuery(thisButton).parents('#god').find('.god_name').html();
            var god_id = jQuery(thisButton).parents('#god').find('input[name="god_id"]').val();
            var god_type = jQuery(thisButton).parents('#god').find('input[name="god_type"]').val();

            jQuery.ajax({
                type: "POST",
                url: 'reroll-type.php',
                data:{god_type: god_type, rerolled_god: god},
                timeout: 3000,
                error: function(request,error) {
                    console.log(error);
                },
                success: function(data) {
                    count = 0;
                    var retGod = JSON.parse(data);
                    jQuery(thisButton).parents('#god').find('.god_name').html(retGod['name']);
                    jQuery(thisButton).parents('#god').find('input[name="god_id"]').val(retGod['id']);
                    jQuery(thisButton).parents('#god').find('input[name="god_type"]').val(retGod['type']);
                    jQuery(thisButton).parents('#god').find('.god img').attr('src', retGod['image']);

                    var item_exclusions = [];
                    var relic_exclusions = [];
                    var newType = jQuery(thisButton).parents('#god').find('input[name="god_type"]').val();

                    reroll_item('boots-'+newType, 0, item_exclusions, jQuery('.item').eq(0).find('h2.item_name').html());
                    item_exclusions.push(jQuery('.item').eq(0).find('input[name="item_id"]').val());

                    reroll_item(newType, 1, item_exclusions, jQuery('.item').eq(1).find('h2.item_name').html());
                    item_exclusions.push(jQuery('.item').eq(1).find('input[name="item_id"]').val());

                    reroll_item(newType, 2, item_exclusions, jQuery('.item').eq(2).find('h2.item_name').html());
                    item_exclusions.push(jQuery('.item').eq(2).find('input[name="item_id"]').val());

                    reroll_item(newType, 3, item_exclusions, jQuery('.item').eq(3).find('h2.item_name').html());
                    item_exclusions.push(jQuery('.item').eq(3).find('input[name="item_id"]').val());

                    reroll_item(newType, 4, item_exclusions, jQuery('.item').eq(4).find('h2.item_name').html());
                    item_exclusions.push(jQuery('.item').eq(4).find('input[name="item_id"]').val());

                    reroll_item(newType, 5, item_exclusions, jQuery('.item').eq(5).find('h2.item_name').html());
                    item_exclusions.push(jQuery('.item').eq(5).find('input[name="item_id"]').val());

                    reroll_item('relic', 6, relic_exclusions, jQuery('.item').eq(6).find('h2.item_name').html());
                    relic_exclusions.push(jQuery('.item').eq(6).find('input[name="item_id"]').val());

                    reroll_item('relic', 7, relic_exclusions, jQuery('.item').eq(7).find('h2.item_name').html());

                    jQuery('#count').html(count);
                    jQuery.ajax({
                        type: "POST",
                        url: 'get-reroll-exceptions.php',
                        data:{exception_name: retGod['name']},
                        timeout: 3000,
                        error: function(request,error) {
                            console.log(error);
                        },
                        success: function(data) {
                            var retExceptions = JSON.parse(data);
                            if(retExceptions.length){
                                if(jQuery('div#god-overlay').length){
                                    jQuery('div#god-overlay').fadeIn();
                                }
                                else {
                                    jQuery('div#god').prepend('<div id="god-overlay"></div>');
                                }
                                setTimeout(function(){
                                    jQuery('div#god-overlay').fadeOut();
                                }, 5000);

                                for(i = 0; i < retExceptions.length; i++){
                                    var type = retExceptions[i]['type'];
                                    var placement = retExceptions[i]['placement'];
                                    var url = retExceptions[i]['url'];
                                    var src = retExceptions[i]['src'];

                                    if(retExceptions[i]['element']){ 
                                        var element = retExceptions[i]['element'];
                                        var elementHTML = '';
                                        if(element === 'audio'){
                                            elementHTML = '<audio autoplay><source src="'+src+'.ogg" type="audio/ogg"><source src="'+src+'.mp3" type="audio/mpeg"></audio>';
                                        }
                                    }

                                    if(type === 'file' || type === 'css_file' || type === 'js_file'){
                                        jQuery('')
                                    }

                                    if(type === 'css_file' || type === 'js_file'){
                                        var html = ''
                                        if(type === 'css_file') {
                                            html = '<link rel="stylesheet" type="text/css" href="'+url+'" />';
                                        }
                                        else if(type === 'js_file'){
                                            html = '<script type="text/javascript" src="'+url+'"></script>';
                                        }
                                        jQuery('footer').append(html);
                                    }
                                    else {
                                        jQuery('#'+placement+'_exception').append(elementHTML);
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }
    });
});