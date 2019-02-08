// JavaScript Document

(function( $ ){

  $.fn.wsnSlider = function(options) {
  
        var defaults = {   
				interval: 5000,
				speed: 800,
				slwidth: $(this).width(), 
				push : false
		  };

		var settings = $.extend({}, defaults, options);  
		
		if (settings.interval <= settings.speed) {
			settings.speed = settings.interval - 100;	
		}

		settings.pushsize = (settings.push) ? 0 : 100;
		settings.slmove = (settings.push) ? 0 : settings.slwidth;
	
		
		this.each(function() {
				   
			var $this = $(this); //store reference	
			$('.buttons').css({visibility:"visible"});
			
			$('.buttons li:first').addClass("current");
			var imgSrc = $('.buttons li.current a').attr("href");
			$('.buttons li a').each (function (){
					 $this.append("<img src='" + $(this).attr("href") + "' class='buffer' />");
											   });
			$this.prepend("<img src='" + imgSrc + "'/>");
			$($this).find('img').not('.buffer').css({ position:"absolute", top:0, left:0 });
			rotator = setInterval(function() {nextslide($this, settings)}, settings.interval);
  		
			$('.buttons li a').click(function(evt) {
					evt.preventDefault();
					clearInterval(rotator);
					var imgSrc = $(this).attr("href");
					$($this).find('img').eq(1).attr("src", imgSrc).show(0);
					$($this).find('img').eq(0).fadeOut(100, function() {
							$($this).find('img').eq(0).attr("src", imgSrc).show(0);
					});
					$('.buttons li.current').removeClass("current");
					$(this).parent().addClass("current");
					rotator = setInterval(function() {nextslide($this, settings)}, settings.interval);
			});			
		
		});					 
		
		return this;	

	};

		nextslide = function ($this, settings) {
					$($this).find('img').eq(1).css({left: settings.slwidth+"px", width:settings.pushsize+"%", height: "100%"});
					var nextImage = $('.buttons li.current').next();
					if (nextImage.length == 0) {
						$('.buttons li.current').removeClass("current").siblings(":first").addClass("current");
					} else {	
						$('.buttons li.current').removeClass("current").next().addClass("current");
					}
						var imgSrc = $('.buttons li.current a').attr("href");
						$($this).find('img').eq(1).attr("src", imgSrc).animate({left:0, width:"100%"},(settings.speed));
						$($this).find('img').eq(0).animate({left:'-='+settings.slmove+'px', width:settings.pushsize+"%", height: "100%"}, settings.speed, function() {
																					$(this).attr("src", imgSrc).css({left: 0, width: "100%"});
																								});	
		};


})( jQuery );


$('document').ready(function () {
		$('#wsnSlider').wsnSlider({interval:5000, speed:300, push:true});
});