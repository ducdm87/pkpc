
function checkType(type)
{
	alert(type);
}

window.addEvent('load', function() { // wait for the content
	
	checkType();
	// our uploader instance
	$('sectiontab').addEvent('click', function(e) {
		sectionLoad();
	});	
	$('categorytab').addEvent('click', function(e) {
		categoryLoad();
	});
	function sectionLoad()
	{
		n=document.adminForm.boxchecked.value;
		checkCheckbox( n, 'cbc');
		var cbsection=$('cbsection');
		var cbcate=$('cbcate');	
		cbcate.name='hide';
		cbsection.name='toggle';
		document.adminForm.boxchecked.value=0;
		document.adminForm.type.value='section';
	}
	function checkCheckbox( n, fldName)
	{
		var f = document.adminForm;
		f.toggle.checked=false;	
		var n2 = 0;
		for (i=0; i < n; i++) {
			cb = eval( 'f.' + fldName + '' + i );
			if (cb) 
			{
				cb.checked = false;
				n2++;
			}
		} 
	}
	function categoryLoad()
	{
		n=document.adminForm.boxchecked.value;
		checkCheckbox( n, 'cbs');
		var cbsection=$('cbsection');
		var cbcate=$('cbcate');
		cbsection.name='hide';
		cbcate.name='toggle';
		document.adminForm.boxchecked.value=0;
		document.adminForm.type.value='category';	
	}
	function checkType()
	{		
//		getChildren
		if(type=='category')
		{			
			$('sectiontab').removeClass('open');
			$('sectiontab').addClass('closed');			
			$('categorytab').removeClass('closed');
			$('categorytab').addClass('open');			
					
			
			abc=document.getElementById('myForm');			
			section=abc.childNodes[2].childNodes[0];
			section.setStyle('display','none' );
			category=abc.childNodes[2].childNodes[1];
			category.setStyle('display','block' );
			categoryLoad();
		}
		else if(type=='section')
		{			
			$('sectiontab').removeClass('closed');
			$('sectiontab').addClass('open');
			
			$('categorytab').removeClass('open');
			$('categorytab').addClass('closed');
			
			abc=document.getElementById('myForm');			
			section=abc.childNodes[2].childNodes[0];
			section.setStyle('display','block' );
			category=abc.childNodes[2].childNodes[1];
			category.setStyle('display','none' );
			sectionLoad();
		}
	}
});