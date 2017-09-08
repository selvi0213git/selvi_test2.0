<?php
/**
* [init]     
* [20170515] | 파일 최초 수정                                         | eley 
* ---------------------------------------------------------------------
* [after]
* [20170515] | CRUD TEST - mystatus.php                          | eley 
* [20170607] | 이벤트등록 및 응모 crud php파일 include - eventinfo.php    | eley 
* [20170623] | 이벤트배달정보입력 crud php파일 include - eventdelivery.php | eley 
* [20170629] | 마이페이지정보입력 crud php파일 include - myinfo.php        | eley 
* [20170703] | 이벤트응모리스트 crud php파일 include - evententerlist.php | eley 
* [20170707] | mypage화면 통합을 위한 php파일 include - mypage.php       | eley 
* [20170718] | 관련글 php파일 include - relation.php                  | eley 
* [20170718] | 관리자 php파일 include - admin_control.php             | eley 
* [20170724] | custom css파일 추가 - custom-style.css                | eley 
* [20170724] | style 함수 추가(커스텀+부모 css)
			   부모 css  : /style.css
			   커스텀 css : /assets/css/custom-style.css
																  | eley
* [20170728] | js및 css include - Kboard, rollet, flickity(slider) | eley
* [20170804] | 함수추가 post contents dafault setting                 | eley
*/

//20170607 eley
include 'inc/eventinfo.php';
$GLOBALS['eventinfo'] = new event_info();

//20170623 eley
include 'inc/eventdelivery.php';
$GLOBALS['eventdelivery'] = new event_delivery();

//20170629 eley
include 'inc/myinfo.php';
$GLOBALS['myinfo'] = new my_info();

//20170703 eley
include 'inc/evententerlist.php';
$GLOBALS['evententerlist'] = new event_enterlist();

//20170707 eley
include 'inc/mypage.php';
$GLOBALS['mypage'] = new mypage();

//20170718 eley
include 'inc/relations.php';
$GLOBALS['relationlist'] = new relation_list();

//20170718 eley
include 'inc_admin/admin_control.php';
$GLOBALS['admincontrol'] = new admin_control();

//style 20170724 eley
function enqueue_child_theme_styles() {
	
	/*parent*/
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	
	/*child*/
	wp_enqueue_style( 'custom-styling', get_stylesheet_directory_uri() . '/assets/css/custom-style.css', array( 'parent-style' ) );
	
	/*yeonok: add kboard ui script*/
	// create new skin & css & js 
	//wp_enqueue_style( 'kboard-styling', get_stylesheet_directory_uri() . '/assets/css/kboard-selvi-style.css', array( 'parent-style' ) );
	
	/*yeonok: add other event list carousel script*/
	wp_enqueue_style( 'flickity-styling', get_stylesheet_directory_uri() . '/assets/js/lib/flickity/flickity.css', array( 'parent-style' ) );
	// yeonok: add flickity ie9 support
	//wp_enqueue_style( 'flickity-v1-styling', get_stylesheet_directory_uri() . '/assets/js/lib/flickity/v1/flickity.css', array( 'parent-style' ) );
	
	}
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles' );

//js 20170728 eley
function enqueue_child_theme_js() {
	
	/*yeonok: add selvi ui script*/
	wp_enqueue_script('selvi-ui-js', get_stylesheet_directory_uri().'/assets/js/selvi-ui.js', array(),null,true);

	/*yeonok: add rollet script*/
	wp_enqueue_script('winwheel-js', get_stylesheet_directory_uri().'/assets/js/lib/Winwheel.min.js', array(),null,true);
	
	wp_enqueue_script('flickity-js', get_stylesheet_directory_uri().'/assets/js/lib/flickity/flickity.pkgd.min.js', array(),null,true);
	// yeonok: add flickity ie9 support
	//wp_enqueue_script('flickity-v1-js', get_stylesheet_directory_uri().'/assets/js/lib/flickity/v1/flickity.pkgd.min.js', array(),null,true);
	
}
add_action('wp_enqueue_scripts', 'enqueue_child_theme_js');

//post contents dafault setting 20170804 eley
function default_post_content( $content ) {
$content = '<!-- 미디어 시작 -->
			<section class="event-visual">
				영상 및 사진 영역
			</section><!-- /.event-mv -->
			<!-- 미디어 끝 -->

			<!-- 텍스트 시작 -->
			<section class="event-desc">
				텍스트영역
			</section><!-- /.event-desc -->
			<!-- 텍스트 끝 -->
			
			<!-- 게시판 시작 -->
				게시판 코드영역
			<!-- 게시판 끝 -->';
return $content;
}
 
add_filter( 'default_content', 'default_post_content' );



/* style 20170724 함수 하나로 합침
// 부모 style
function enqueue_child_theme_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);

// 커스텀 style 20170724 eley
function custom_style_sheet() {
	wp_enqueue_style( 'custom-styling', get_stylesheet_directory_uri() . '/assets/css/custom-style.css', array( 'parent-style' ));
}
add_action('wp_enqueue_scripts', 'custom_style_sheet');
*/

/** 보류
//글 작성자 이메일전송기능 추가 20170518 eley
add_action('kboard_comments_insert', 'my_kboard_comments_insert', 10, 2);
function my_kboard_comments_insert($comment_uid, $content_uid){
    $content = new KBContent();
    $content->initWithUID($content_uid);
    if($content->option->email){
        $email = $content->option->email;
        $title = '등록하신 글에 대해 답변이 등록 되었습니다.';
        $content = '등록하신 글에 대해 답변이 등록 되었습니다. 게시판을 확인해주세요.';
        wp_mail($email, $title, $content);
    }
}
*/

/**
 * Add page classes to the array of body classes.
 */
function selvi_body_classes( $classes ) {

	global $post;
	$post_id = $post->ID;
	$post_type = $post->post_type;

	if ($post_id == '1141') {
		$classes[] = 'bg-gray';
	}

	if($post_type == "post") {
		$classes[] = "page-event-detail";
	}

	return $classes;
}
add_filter( 'body_class', 'selvi_body_classes' );
?>