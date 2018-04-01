var category = function( parentID ){
	this.parentID = parentID;
	this.datas = [];
	this.elements = { category: null, children: [] };
	this._init();
}

category.prototype = {

	_init: function(){
		$.ajax({
			url: 'index.php',
			data:{
				part: 'api',
				type: 'category',
				parent: this.parentID
			},
			dataType: 'JSON',
			method: 'POST',
			context:this,
			async: false,
			success: function(response){
				this.datas = response;
				this._build();
			}
		})
	},

	_build: function(){

		let htmlElements = [];

		let item = this.datas.category;
		if( item !== null ){
			let mainElement = document.createElement('div');
				mainElement.setAttribute('class', 'col-sm-12 block main-block');
					mainElement.dataset.id = item.id;
					mainElement.dataset.title = item.title;
						let title = document.createElement('h1');
						title.innerHTML = item.title;
						mainElement.appendChild(title);
					if( item.img !== null && item.img !== ''){
						let img = document.createElement('img');
							img.setAttribute('src', item.img);
							img.setAttribute('style', 'width:500px;display:block;margin:10px auto;');
							mainElement.appendChild(img);
					}	
			this.elements.category = mainElement;
		}
				
		for( let i = 0; i < this.datas.children.length; i++ ){
			let item = this.datas.children[i];
			let div = document.createElement('div');
			if( this.datas.category == null )
				div.setAttribute('class', 'col-sm-6 block');
			else
				div.setAttribute('class', 'col-sm-4 block');

			div.style.margin = '5px auto';
			div.dataset.id = item.id;
			div.dataset.title = item.title;
				let title = document.createElement('h1');
				title.innerHTML = item.title;
				div.appendChild(title);
			if( item.img !== null && item.img !== ''){
				let divImg = document.createElement('div');
					divImg.setAttribute('class', 'content-img');
					divImg.style.backgroundImage = 'url("'+item.img+'")';
				div.appendChild(divImg);	
			}	

			$(div).off('mouseenter').on('mouseenter', function(){
				div.classList.add('item-active');
			});
			$(div).off('mouseleave').on('mouseleave', function(){
				div.classList.remove('item-active');
			});

			htmlElements.push( div );		
		}

		this.elements.children = htmlElements;
	},

	getDatas: function(){
		return this.datas;
	},

	getElements: function(){
		return this.elements;
	}

}