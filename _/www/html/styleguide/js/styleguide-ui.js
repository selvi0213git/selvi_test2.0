/**
 * Runs Globally ========================
 */
SyntaxHighlighter.all();

$(function() {
	guideUI.initPageTopBtn();
	guideUI.globalNav();
});
//========================================

/**
 * UI Actions
 */
var guideUI = {
	"globalNav": function() {
		var pageTit = $(".guide-page-tit").text();

		$("#global-nav").find("a").each(function() {
			if($(this).text() == pageTit) {
				$(this).addClass("active");
			}
		});
	},

	"initPageTopBtn": function() {
		var _btn = $("#btn-page-top");

		_btn.on("click", clickListener);
		$(window).on("scroll", scrollListener);

		function clickListener(e) {
			e.preventDefault();
			$(window).scrollTop(0);
		}

		function scrollListener() {
			if($(window).scrollTop() > 0) {
				_btn.addClass("active");
			} else {
				_btn.removeClass("active");
			}
		}
	}//initPageTopBtn
}//ui