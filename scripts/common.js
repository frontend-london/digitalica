

$(window).load
(
	function()
	{
		if($('a[rel*=hover] img'))
		{
			$.each							   
			(
				$('a[rel*=hover] img'),
				function()
				{
					var originalImage = this.src;
					var hoverImage = this.src.replace('original', 'hover');
					
					$(this).mouseover
					(
					 	function()
						{
							this.src = hoverImage;
						}
					);
					
					$(this).mouseout
					(
					 	function()
						{
							this.src = originalImage;
						}
					);
				}
			);
		}
		
		
		if($('input.inputBlur'))
		{
			$.each							   
			(
				$('input.inputBlur'),
				function()
				{
				
					var elementValue = $(this).get(0);
					
					var originalElementValue = elementValue.value;				
					
					$(this).focus
					(
					 	function()
						{
							if(elementValue.value == originalElementValue)
							{
								elementValue.value = '';
							}
						}
					);
					
					$(this).blur
					(
					 	function()
						{
							if(elementValue.value == '')
							{
								elementValue.value = originalElementValue;
							}
						}
					);
				}
			);
		}				
	}
);

$(document).ready
(
	function()
	{
		$('a').focus(function() {
		  this.blur();
		});

                var counter_design = 0;
                var counter_sound = 0;

                $("#more-news-design").click(function(event){
                    event.preventDefault();
                    $('.box-ajaxloader-design').remove();
                    $("#boxes-design").append('<div class="box-ajaxloader-design"><img src="images/icons/ajax-loader-pink.gif" alt="loading.." /></div>')
                    $.get('ajax/1/'+counter_design, function(data) {
                        $('.box-ajaxloader-design').remove();
                        $(data).hide().appendTo('#boxes-design').slideDown('slow');

                        if($("#nomore-design").length>0) {
                            $("#box-news-title-design").html('No more news');
                        }
                        counter_design+=3;
                    });
                });

                $("#more-news-sound").click(function(event){
                    event.preventDefault();
                    $("#boxes-sound").append('<div class="box-ajaxloader-sound"><img src="images/icons/ajax-loader-brown.gif" alt="loading.." /></div>')
                    $.get('ajax/2/'+counter_sound, function(data) {
                        $('.box-ajaxloader-sound').remove();
                        $(data).hide().appendTo('#boxes-sound').slideDown('slow');

                        if($('#nomore-sound').length>0) {
                            $("#box-news-title-sound").html('No more news');
                        }
                        counter_sound+=3;
                    });
                });

                $('#sendButton').click(function(event){
                    event.preventDefault();
                    var nameToVal = $('#formName').val();
                    var emailToVal = $('#formEmail').val();
                    var commentToVal = $('#formComment').val();
                    var hasError = false;
                    var message = '';
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    if((nameToVal == '') || (emailToVal == '') || (commentToVal == '')) {
                            message = 'Wszystkie pola muszą zostać wypełnione';
                            hasError = true;
                    } else if(!emailReg.test(emailToVal)) {
                            message = 'Nieprawidłowy adres email';
                            hasError = true;
                    } else {
                        message = 'Komentarz został dodany. Zostanie opublikowany po zweryfikowaniu przez moderatora';
                    }

                    if(!hasError) {
                        $('#send_comment').ajaxSubmit();
                        $('#send_comment').clearForm();
                    }

                    $("#boxbig-comments-message").hide();
                    $("#boxbig-comments-message").html(message);
                    $("#boxbig-comments-message").fadeIn('slow');
                });

                $('.addWebsiteDOMWindow').openDOMWindow({
                    borderSize:0,
                    eventType:'click',
                    height:252,
                    loader:1,
                    loaderImagePath:'images\icons\ajax-loader-pink.gif',
                    loaderHeight:11,
                    loaderWidth:43,
                    overlayColor:'#fbdede',
                    overlayOpacity:'80',
                    width:431,
                    windowBGColor: 'transparent'
                });
                $('.addWebsiteCloseDOMWindow').closeDOMWindow({
                    eventType:'click'
                });

                $('#baw-send').click(function(event){
                    event.preventDefault();
                    var nameToVal = $('#baw-name').val();
                    var emailToVal = $('#baw-email').val();
                    var urlToVal = $('#baw-url').val();
                    if(nameToVal=='yout name') nameToVal='';
                    if(emailToVal=='e-mail') emailToVal='';
                    if(urlToVal=='url') urlToVal='';


                    var hasError = false;
                    var message = '';
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    if((nameToVal == '') || (emailToVal == '') || (urlToVal == '')) {
                            message = 'Wszystkie pola muszą zostać wypełnione';
                            hasError = true;
                    } else if(!emailReg.test(emailToVal)) {
                            message = 'Nieprawidłowy adres email';
                            hasError = true;
                    } else {
                        message = 'Webstite has been put in the air!';
                    }

                    if(!hasError) {
                        $('#boxAddWebsiteForm').ajaxSubmit();
                        $('#boxAddWebsiteForm').resetForm();
                        $('.addWebsiteCloseDOMWindow').closeDOMWindow();
                        //$("#baw-close").click();
                    }                    
                    alert(message);
                });

                $('#search-bar-submit').click(function(event){
                    event.preventDefault();
                    $('#search_form_sphider').submit();
                });

                $('#search-button').click(function(event){
                    event.preventDefault();
                    $('#search_form').submit();
                });

                $('#footersee-select').change(function() {
                    url = $(this, 'option:selected').val();
//                    window.location = url;
//                    window.open(url, 'seealso').blur();
//                    window.open(url, 'seealso', 'menubar=yes,toolbar=yes,location=yes,directories=yes,status=yes,scrollbars=yes,resizable=yes,fullscreen=no,channelmode=no,width=300,height=200').focus();
                    window.open(url,'digitalica-seealso','width=600,height=600,toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,copyhistory=yes,resizable=yes');
//                    alert('t');
                    return false;
                });

	}
)
	
$(document).ajaxComplete(function(){
    try{
        FB.XFBML.parse(); 
    }catch(ex){}
});