window.addEvent('domready', function(){
	/*
	//process menu active and find the best possition for submenu	
	function submenu_center_possition(parrent_item){
		var parrent_possition = 0;
		var children_possition = 0;
		var children_width = 0;
		if(parrent_item && parrent_item.hasClass('parent')){
			var children_menu = parrent_item.getFirst('ul');
			parrent_possition = parrent_item.getLeft() + (parrent_item.getCoordinates().width)/2;
			children_possition = children_menu.getLeft() +  (children_menu.getCoordinates().width)/2;
			children_width = children_menu.getCoordinates().width;
		}
				
		if(parrent_possition - children_possition > 0){
			var left_value = parrent_possition - children_possition;
			if(left_value + children_width > 800){
				left_value = 800 - children_width;
			}
			if(left_value > 0){
				children_menu.setStyle('left', left_value);
			}
		}
	}
			
	//hover
	$('menu').getFirst('div').getFirst('ul').getChildren('li').each(function(menu_item){
		menu_item.addEvent('mouseover', function(){
			submenu_center_possition(menu_item);
		});
		menu_item.addEvent('mouseout', function(){
			if(menu_item.hasClass('parent')){
				menu_item.getFirst('ul').setStyle('left', '');
			}
		});
	});
	*/
});