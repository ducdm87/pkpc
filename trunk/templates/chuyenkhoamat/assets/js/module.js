//window.addEvent('domready', function(){
//	/***************************************************************
//	*******************module mod-f5categories**********************
//	***************************************************************/
//	$$('div .module-listcat').each(function(module_item){
//		//get the span size
//		var title_size = module_item.getFirst('h3').getFirst('span').getSize().x;
//		if(!title_size){
//			return;
//		}
//		//set the titlecategory left possition
//		var title_category = module_item.getFirst('div').getFirst('div').getFirst('div');
//		if(!title_category.hasClass('titlecategory')){
//			return;
//		}
//		title_category.setStyle('left', title_size - 5);
//		title_category.setStyle('display', 'block');
//	});
//});