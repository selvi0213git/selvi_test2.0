/**
 * Selvi UI Scripts
 * ui.kboardToggle
 * ui.openModal
 */

/* Run Globally */
jQuery(function() {
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
		if(!jQuery(".styled-select-outer").size()) return;

		var _container = jQuery(".styled-select-outer");
		var pr = 30;

		function init() {
			if(window.opera) return;

			resizeSelect();
			build();

			jQuery(window).bind("resize", resizeListener);
		}

		function resizeListener() {
			resizeSelect();
			resizeAltSelect();
		}

		function build() {
			_container.each(function() {

				var _outer = jQuery(this);
				
				_outer.find("select").each(function(){
				
					if(jQuery(this).parent().find(".alt-select").length) return;
					
					var title = jQuery("option:first-child", this).text();
					var w = jQuery(this).outerWidth();

					if( jQuery('option:selected', this).val() != ''  ) title = jQuery('option:selected',this).text();
					
					jQuery(this)
						.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
						.after('<input type="text" class="alt-select" style="width:' + w + 'px;" value="' + title + '" readonly>')
						.bind("change", function(){
							val = jQuery('option:selected',this).text();
							jQuery(this).next().val(val);
						});
				});

			});
		}//build

		function resizeSelect() {
			_container.each(function() {
				var _outer = jQuery(this);
				
				jQuery(this).find("select").each(function(){
					// if(_outer.width() > jQuery(this).outerWidth()) {
						jQuery(this).outerWidth(_outer.width());
					// }
				});

			});
		}//resizeSelect

		function resizeAltSelect() {
			var _select;
			var _altSelect;
			var w;
			_container.each(function(i) {
				_select = jQuery(this).find("select");
				_altSelect = jQuery(this).find(".alt-select");
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
		jQuery(".kboard-selvi").each(function() {
			if(jQuery(this).find(".kboard-list-title").find(".content-view").size()) {
				jQuery(this).find(".kboard-list-title").find("a").on("click", function(e) {
					e.preventDefault();
					jQuery(this).find(".content-view").slideToggle("fast");
					jQuery(this).parents("tr").toggleClass("open");
					jQuery(this).parents("tr").next(".kboard-list-reply").toggle();
				});
			}
		});
	},//end kboardToggle

	/**
	 * Open magnificpopup
	 * doc: http://dimsemenov.com/plugins/magnific-popup/documentation.html
	 * need 'magnific-popup.css'
	 * need 'jquery.magnific-popup.min.js'
	 */
	"openModal": function($src, $type) {
		jQuery.magnificPopup.open({
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

		jQuery(".filebox").each(function() {
			_container = jQuery(this);
			_fileTarget = jQuery(this).find(".hidden-input-file");

		  _fileTarget.on('change', function(){  // 값이 변경되면
		    if(window.FileReader){  // modern browser
		      var filename = jQuery(this)[0].files[0].name;
		    }
		    else {  // old IE
		      var filename = jQuery(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
		    }

		    // 추출한 파일명 삽입
		    _container.find('.input-file-name').val(filename);
		  });
		});//each

	},//end filebox
}//ui

/* popup functions */
function openApplyConfirm() {
	ui.openModal('/wp-content/themes/proton-child/pop/1.1.0-pop-apply-confirm.html', 'ajax');
}

function openApplyRoulette($prize) {
	ui.openModal('/wp-content/themes/proton-child/pop/1.1.1-pop-apply-roulette.php?prize=' + $prize, 'ajax');
}

function openApplyWin() {
	ui.openModal('/wp-content/themes/proton-child/pop/1.1.2-pop-apply-win.html', 'ajax');
}

function openApplyLose() {
	ui.openModal('/wp-content/themes/proton-child/pop/1.1.3-pop-apply-lose.html', 'ajax');
}

function openWriteReview() {
	ui.openModal('/wp-content/themes/proton-child/pop/1.2-pop-write-review.html', 'ajax');
}

function openWriteQna() {
	ui.openModal('/wp-content/themes/proton-child/pop/1.3-pop-write-qna.html', 'ajax');
}