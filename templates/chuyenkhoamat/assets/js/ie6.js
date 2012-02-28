navHover = function() {
	var lis1 = document.getElementById("menu-nav").getElementsByTagName("LI");
	for (var i=0; i<lis1.length; i++) {
		lis1[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		lis1[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", navHover);