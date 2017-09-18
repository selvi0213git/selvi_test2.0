function buildHeader() {
	var htmlStr = '<div class="guide-center">';
		htmlStr += '<h1>';
			htmlStr += '<a href="http://www.selvi.co.kr" target="_blank">';
				htmlStr += '<img src="../assets/images/selvi-site-logo.png" class="img-symbol">';
			htmlStr += '</a>';
			htmlStr += '<small><a href="index.html">Front-end Style Guide</a></small>';
		htmlStr += '</h1>';
		htmlStr += '<a href="#" class="btn-page-top" id="btn-page-top" title="Page top">▲</a>';
	htmlStr += '</div>';

	var targetEl = document.getElementById("guide-header");
targetEl.innerHTML = htmlStr;
}//includeHeader

function buildSidebar() {
	var htmlStr = '<nav id="global-nav" class="global-nav">';
		htmlStr += '<ul>';
			htmlStr += '<li><h3>Elements</h3></li>';
			htmlStr += '<li><a href="index.html">Buttons</a></li>';
			htmlStr += '<li><a href="colors.html">Colors</a></li>';
			htmlStr += '<li><a href="forms.html">Forms</a></li>';
			htmlStr += '<li><a href="labels.html">Label / Flag / Badge</a></li>';
			htmlStr += '<li><a href="typography.html">Typography</a></li>';
			htmlStr += '<li><h3>Modules</h3></li>';
			htmlStr += '<li><a href="event-item.html">Event Item</a></li>';
			// htmlStr += '<li><h3>Layout</h3></li>';
			// htmlStr += '<li><a href="page-basic.html">Page Basic</a></li>';
			htmlStr += '<li><h3>UI</h3></li>';
			htmlStr += '<li><a href="popup.html">Popup</a></li>';
		htmlStr += '</ul>';
	htmlStr += '</nav>';

	var targetEl = document.getElementById("guide-sidebar");
targetEl.innerHTML = htmlStr;
}//includeSide