/**
 * Selvi UI Scripts
 * ui.kboardToggle
 * ui.openModal
 */

/* Run Globally */
$(function() {
	ui.kboardToggle();
	ui.filebox();
	ui.styledSelect();
});


/* UI Methods */
var ui = {

	/**
	 * alternative to custom styling of the SELECT elements
	 */
	"styledSelect": function() {
		if(!$(".styled-select-outer").size()) return;

		var _container = $(".styled-select-outer");
		var pr = 30;

		function init() {
			if(window.opera) return;

			resizeSelect();
			build();

			$(window).bind("resize", resizeListener);
		}

		function resizeListener() {
			resizeSelect();
			resizeAltSelect();
		}

		function build() {
			_container.each(function() {

				var _outer = $(this);
				
				_outer.find("select").each(function(){
				
					if($(this).parent().find(".alt-select").length) return;
					
					var title = $("option:first-child", this).text();
					var w = $(this).outerWidth();

					if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
					
					$(this)
						.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
						.after('<input type="text" class="alt-select" style="width:' + w + 'px;" value="' + title + '" readonly>')
						.bind("change", function(){
							val = $('option:selected',this).text();
							$(this).next().val(val);
						});
				});

			});
		}//build

		function resizeSelect() {
			_container.each(function() {
				var _outer = $(this);
				
				$(this).find("select").each(function(){
					// if(_outer.width() > $(this).outerWidth()) {
						$(this).outerWidth(_outer.width());
					// }
				});

			});
		}//resizeSelect

		function resizeAltSelect() {
			var _select;
			var _altSelect;
			var w;
			_container.each(function(i) {
				_select = $(this).find("select");
				_altSelect = $(this).find(".alt-select");
				w = _select.outerWidth();
				_altSelect.css("width", w + "px");
			});
		}

		init();
	}, //styledSelect

	/**
	 * Kboard Toggle
	 */
	"kboardToggle": function() {
		$(".kboard-selvi").each(function() {
			if($(this).find(".kboard-list-title").find(".content-view").size()) {
				$(this).find(".kboard-list-title").find("a").on("click", function(e) {
					e.preventDefault();
					$(this).find(".content-view").slideToggle("fast");
					$(this).parents("tr").toggleClass("open");
					$(this).parents("tr").next(".kboard-list-reply").toggle();
				});
			}

			$(this).find(".btn-board-toggle").on("click", function(e) {
				e.preventDefault();
				$(this).parents("tr").find(".btn-board-toggle").toggleClass("on");
				$(this).parents("tr").next(".row-addr").find(".addr-info").slideToggle("fast");
			});
		});
	},//end kboardToggle

	/**
	 * Open magnificpopup
	 * doc: http://dimsemenov.com/plugins/magnific-popup/documentation.html
	 * need 'magnific-popup.css'
	 * need 'jquery.magnific-popup.min.js'
	 */
	"openModal": function($src, $type) {
		$.magnificPopup.open({
	    items: {
	      src: $src,
	      type: $type
	    },
	    closeOnBgClick: false,
	    showCloseBtn: false,
	    enableEscapeKey: false
	  });
	},//end openModal

	/**
	 * Filebox
	 */
	"filebox" : function() {
		var _container;
		var _fileTarget;

		$(".filebox").each(function() {
			_container = $(this);
			_fileTarget = $(this).find(".hidden-input-file");

		  _fileTarget.on('change', function(){  // 값이 변경되면
		    if(window.FileReader){  // modern browser
		      var filename = $(this)[0].files[0].name;
		    }
		    else {  // old IE
		      var filename = $(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
		    }

		    // 추출한 파일명 삽입
		    _container.find('.input-file-name').val(filename);
		  });
		});//each

	},//end filebox
}//ui

/* popup functions */
function openApplyConfirm() {
	ui.openModal('1.1.0-pop-apply-confirm.html', 'ajax');
}

function openApplyRoulette($prize) {
	ui.openModal('1.1.1-pop-apply-roulette.php?prize=' + $prize, 'ajax');
}

function openApplyWin() {
	ui.openModal('1.1.2-pop-apply-win.html', 'ajax');
}

function openApplyLose() {
	ui.openModal('1.1.3-pop-apply-lose.html', 'ajax');
}

function openWriteReview() {
	ui.openModal('1.2-pop-write-review.html', 'ajax');
}

function openWriteQna() {
	ui.openModal('1.3-pop-write-qna.html', 'ajax');
}