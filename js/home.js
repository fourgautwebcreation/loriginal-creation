var HomeClass = function(){
	this.title = document.querySelector('#title');
	this.immo = document.querySelector('#immo');
	this.animations = document.querySelector('#animations');
	this.panel = document.querySelector('#panel');
	this._bindEvents();
	this.runAnimation();
};

HomeClass.prototype = {

	runAnimation: function(){
		let context = this;
		$(this.title).animate({ opacity:1},1000, function(){
			$(context.immo).animate({opacity:1},1000, function(){
				$(context.animations).animate({opacity:1}, 1000);
			});
		});
	},

	_bindEvents: function(){
		$(this.immo).on('click', function(){
			this.loadPanel( 'immo' );
		}.bind(this));

		$(this.animations).on('click', function(){
			this.loadPanel( 'animations' );
		}.bind(this));
	},

	_bindEventsPanel: function(){
		let returnTo = $('nav').find('li[data-return]');
		for( let i = 0; i < returnTo.length; i++ ){
			let elem = $(returnTo[i]);
			let partReturn = elem.attr('data-return');

			if( partReturn == 'home'){
				elem.off('click').on('click', function(){
					window.location.href = window.location.href;
				}.bind(this));
			}
				
		}

		let li = $('nav').find('li[data-part]');
		for( let i = 0; i < li.length; i++ ){
			let elem = $(li[i]);
			let part = elem.attr('data-part');
			elem.off('click').on('click', function(){
				this.loadPanel(part, true);
			}.bind(this));
		}
	},

	loadPanel: function(part, notFirstCall){
		$.ajax({
			url:'index.php',
			method: 'POST',
			data:{
				part: part
			},
			context:this,
			success: function(html){
				this.panel.innerHTML = html;
				this.panel.querySelector('li[data-part='+part+']').classList.add('active');
				this._bindEventsPanel();
				if( !notFirstCall )
					this._animatePanel();
			}
		})
	},

	_animatePanel(typeAnimation){
		let context = this;
		$(this.animations).stop().animate({ opacity:0},250, function(){
			$(context.immo).stop().animate({opacity:0},250, function(){
				$(context.title).stop().animate({opacity:0}, 500, function(){
					context.panel.style.top = 0;
					context.panel.style.zIndex = 2;
					$(context.panel).animate({
						opacity:1
					},500);
				});
			});
		});
		

	}

}