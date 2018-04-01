var HomeClass = function(){
	this.title = document.querySelector('#title');
	this.panel = document.querySelector('#panel');
	this.home = document.querySelector('#home');
	this.categories = null;

	this._getCategories();
	this._build();
	this.runAnimation();
};

HomeClass.prototype = {

	runAnimation: function(){

		let context = this;
		let children = this.home.querySelectorAll( '.block' );

		var animate = function(element){

			return new Promise( function(resolve,reject){
				$(element).animate({opacity:1}, 1000, function(){
					resolve();
				});	
			});
		}

		let i = 0;

		var goAnimation = function(element){
			animate( element ).then(function(){
				i++;
				if( children[i] !== undefined ){
					goAnimation(children[i]);
				}
				else{
				}	
			}.bind(this));
		}
	
		$(this.title).animate( {opacity:1}, 1000, function(){
			goAnimation( children[i] );	
		});

	},

	_getCategories: function(){
		let categories = new category();
			this.categories = categories;
	},

	_build: function(){
		let elements = this.categories.getElements();

		let nav = document.createElement('nav');
			let ul = document.createElement('ul');
			let homeLi = document.createElement('li');
				homeLi.setAttribute('class', 'title');
				homeLi.innerHTML = 'L\'Original\'Créations';
				$(homeLi).off('click').on('click', function(){
					let context = this;
					$(this.panel).animate({opacity:0, zIndex:0}, 250, function(){
						context.runAnimation();
					});	
				}.bind(this));
			ul.appendChild(homeLi);	

		for( let i = 0; i < elements.children.length; i++ ){
			let div = elements.children[i];

			$(div).off('click').on('click', function(){
				this.loadPanel( div.dataset.id );
			}.bind(this));
			document.querySelector('#block-home').appendChild( div );

			// Prepare the nav of the panel
			let li = document.createElement('li');
				li.setAttribute('data-parentid', div.dataset.id);
				li.innerHTML = div.dataset.title;
				
				$(li).off('click').on('click', function(){
					this.loadPanel( div.dataset.id, true );
				}.bind(this));
				
			ul.appendChild(li);	
		}

		nav.appendChild(ul);
		this.panel.appendChild(nav);
	},

	loadPanel: function(parentID, dontAnimate){

		let categories = new category(parentID);
		let elements = categories.getElements();

		// Remove the last loaded categories blocks
		let blocks = this.panel.querySelectorAll('.block');
		for( let i = 0; i < blocks.length; i++ ){
			blocks[i].remove();
		}

		// Set the list to non active
		let li = this.panel.querySelectorAll('li');
		for( let i = 0; i < li.length; i++ ){
			li[i].classList.remove('active');
		}

		let targetLi = this.panel.querySelector('li[data-parentid="'+parentID+'"]');
		if( targetLi !== null )
			targetLi.classList.add('active');

		if( elements.category !== null )
			elements.category.classList.add('visible');this.panel.appendChild( elements.category );
		console.log(elements.children);
		for( let i = 0; i < elements.children.length; i++ ){
			let div = elements.children[i];
			$(div).off('click').on('click', function(){
				this.loadPanel( div.dataset.id );
			}.bind(this));
			div.classList.add('visible');
			this.panel.appendChild( div );
		}
		
		if( !dontAnimate )	
			this._animatePanel();

	},

	_animatePanel(){
		let context = this;
		let children = document.querySelector('#block-home').querySelectorAll( '.block' );

		var animate = function(element){

			return new Promise( function(resolve,reject){

				$(element).stop().animate({opacity:0}, 250, function(){
					resolve();
				});

			});
		}

		let i = 0;

		var goAnimation = function(element){
			animate( element ).then(function(){
				i++;
				if( children[i] !== undefined ){
					goAnimation(children[i]);
				}
				else{
					let context = this;
					$(this.title).animate( {opacity:0}, 250, function(){
						$(context.panel).animate({'opacity':'1', 'z-index':'1'});
					});
				}	
			}.bind(this));
		}
		goAnimation( children[i] );	

	}

}