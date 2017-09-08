<?php

function proton_custom_fonts() {

$options = get_proton_options();

// Header font
$proton_header_font = $options['proton_header_font'];
if($proton_header_font) :
	if(!$proton_header_font['color'] == 0){echo "<style>.wrapper header nav ul li a {color: ". $proton_header_font['color'] ."!important;;}</style>";}
	if(!$proton_header_font['font-style'] == 0){echo "<style>.wrapper header nav ul li a {font-style: ". $proton_header_font['font-style'] ."!important;;}</style>";}
	if(!$proton_header_font['font-family'] == 0){echo "<style>.wrapper header nav ul li a {font-family: ". $proton_header_font['font-family'] ."!important;;}</style>";}
	if(!$proton_header_font['font-size'] == 0){echo "<style>.wrapper header nav ul li a {font-size: ". $proton_header_font['font-size'] ."!important;;}</style>";}
	if(!$proton_header_font['line-height'] == 0){echo "<style>.wrapper header nav ul li a {line-height: ". $proton_header_font['line-height'] ."!important;;}</style>";}
	if(!$proton_header_font['text-transform'] == 0){echo "<style>.wrapper header nav ul li a {text-transform: ". $proton_header_font['text-transform'] ."!important;;}</style>";}
endif;

// Dropdown Font
$proton_dropdown_font = $options['proton_dropdown_font'];
if($proton_dropdown_font) :
	if(!$proton_dropdown_font['color'] == 0){echo "<style>.wrapper header nav ul li ul li a {color: ". $proton_dropdown_font['color'] ."!important;;}</style>";}
	if(!$proton_dropdown_font['font-style'] == 0){echo "<style>.wrapper header nav ul li ul li a {font-style: ". $proton_dropdown_font['font-style'] ."!important;;}</style>";}
	if(!$proton_dropdown_font['font-family'] == 0){echo "<style>.wrapper header nav ul li ul li a {font-family: ". $proton_dropdown_font['font-family'] ."!important;;}</style>";}
	if(!$proton_dropdown_font['font-size'] == 0){echo "<style>.wrapper header nav ul li ul li a {font-size: ". $proton_dropdown_font['font-size'] ."!important;;}</style>";}
	if(!$proton_dropdown_font['line-height'] == 0){echo "<style>.wrapper header nav ul li ul li a {line-height: ". $proton_dropdown_font['line-height'] ."!important;;}</style>";}
	if(!$proton_dropdown_font['text-transform'] == 0){echo "<style>.wrapper header nav ul li ul li a {text-transform: ". $proton_dropdown_font['text-transform'] ."!important;;}</style>";}
endif;

// Page Title Font
$proton_page_header_font = $options['proton_page_header_font'];
if($proton_page_header_font) :
	if(!$proton_page_header_font['color'] == 0){echo "<style>.wrapper .page-title h1 {color: ". $proton_page_header_font['color'] ." !important;}</style>";}
	if(!$proton_page_header_font['font-style'] == 0){echo "<style>.wrapper .page-title h1 {font-style: ". $proton_page_header_font['font-style'] ." !important;}</style>";}
	if(!$proton_page_header_font['font-family'] == 0){echo "<style>.wrapper .page-title h1 {font-family: ". $proton_page_header_font['font-family'] ." !important;}</style>";}
	if(!$proton_page_header_font['font-size'] == 0){echo "<style>.wrapper .page-title h1 {font-size: ". $proton_page_header_font['font-size'] ." !important;}</style>";}
	if(!$proton_page_header_font['line-height'] == 0){echo "<style>.wrapper .page-title h1 {line-height: ". $proton_page_header_font['line-height'] ." !important;}</style>";}
	if(!$proton_page_header_font['text-transform'] == 0){echo "<style>.wrapper .page-title h1 {text-transform: ". $proton_page_header_font['text-transform'] ." !important;}</style>";}
endif;

// Body Font
$proton_body_font = $options['proton_body_font'];
if($proton_body_font) :
	if(!$proton_body_font['color'] == 0){echo "<style>html, body, div, span, applet, object, iframe, table, caption, tbody, tfoot, thead, tr, th, td, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,dl, dt, dd, ol, ul, li, fieldset, form, label, legend {color: ". $proton_body_font['color'] ." !important;}</style>";}
	if(!$proton_body_font['font-style'] == 0){echo "<style>html, body, div, span, applet, object, iframe, table, caption, tbody, tfoot, thead, tr, th, td, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,dl, dt, dd, ol, ul, li, fieldset, form, label, legend {font-style: ". $proton_body_font['font-style'] ." !important;}</style>";}
	if(!$proton_body_font['font-family'] == 0){echo "<style>html, body, div, span, applet, object, iframe, table, caption, tbody, tfoot, thead, tr, th, td, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,dl, dt, dd, ol, ul, li, fieldset, form, label, legend {font-family: ". $proton_body_font['font-family'] ." !important;}</style>";}
	if(!$proton_body_font['font-size'] == 0){echo "<style>html, body, div, span, applet, object, iframe, table, caption, tbody, tfoot, thead, tr, th, td, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,dl, dt, dd, ol, ul, li, fieldset, form, label, legend {font-size: ". $proton_body_font['font-size'] ." !important;}</style>";}
	if(!$proton_body_font['line-height'] == 0){echo "<style>html, body, div, span, applet, object, iframe, table, caption, tbody, tfoot, thead, tr, th, td, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,dl, dt, dd, ol, ul, li, fieldset, form, label, legend {line-height: ". $proton_body_font['line-height'] ." !important;}</style>";}
	if(!$proton_body_font['text-transform'] == 0){echo "<style>html, body, div, span, applet, object, iframe, table, caption, tbody, tfoot, thead, tr, th, td, del, dfn, em, font, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,dl, dt, dd, ol, ul, li, fieldset, form, label, legend {text-transform: ". $proton_body_font['text-transform'] ." !important;}</style>";}
endif;

// Heading One Font
$proton_heading_one_font = $options['proton_heading_one_font'];
if($proton_heading_one_font) :
	if(!$proton_heading_one_font['color'] == 0){echo "<style>h1 {color: ". $proton_heading_one_font['color'] ." !important;}</style>";}
	if(!$proton_heading_one_font['font-style'] == 0){echo "<style>h1 {font-style: ". $proton_heading_one_font['font-style'] ." !important;}</style>";}
	if(!$proton_heading_one_font['font-family'] == 0){echo "<style>h1 {font-family: ". $proton_heading_one_font['font-family'] ." !important;}</style>";}
	if(!$proton_heading_one_font['font-size'] == 0){echo "<style>h1 {font-size: ". $proton_heading_one_font['font-size'] ." !important;}</style>";}
	if(!$proton_heading_one_font['line-height'] == 0){echo "<style>h1 {line-height: ". $proton_heading_one_font['line-height'] ." !important;}</style>";}
	if(!$proton_heading_one_font['text-transform'] == 0){echo "<style>h1 {text-transform: ". $proton_heading_one_font['text-transform'] ." !important;}</style>";}
endif;

// Heading Two Font
$proton_heading_two_font = $options['proton_heading_two_font'];
if($proton_heading_two_font) :
	if(!$proton_heading_two_font['color'] == 0){echo "<style>h2 {color: ". $proton_heading_two_font['color'] ." !important;}</style>";}
	if(!$proton_heading_two_font['font-style'] == 0){echo "<style>h2 {font-style: ". $proton_heading_two_font['font-style'] ." !important;}</style>";}
	if(!$proton_heading_two_font['font-family'] == 0){echo "<style>h2 {font-family: ". $proton_heading_two_font['font-family'] ." !important;}</style>";}
	if(!$proton_heading_two_font['font-size'] == 0){echo "<style>h2 {font-size: ". $proton_heading_two_font['font-size'] ." !important;}</style>";}
	if(!$proton_heading_two_font['line-height'] == 0){echo "<style>h2 {line-height: ". $proton_heading_two_font['line-height'] ." !important;}</style>";}
	if(!$proton_heading_two_font['text-transform'] == 0){echo "<style>h2 {text-transform: ". $proton_heading_two_font['text-transform'] ." !important;}</style>";}
endif;

// Heading Three Font
$proton_heading_three_font = $options['proton_heading_three_font'];
if($proton_heading_three_font) :
	if(!$proton_heading_three_font['color'] == 0){echo "<style>h3 {color: ". $proton_heading_three_font['color'] ." !important;}</style>";}
	if(!$proton_heading_three_font['font-style'] == 0){echo "<style>h3 {font-style: ". $proton_heading_three_font['font-style'] ." !important;}</style>";}
	if(!$proton_heading_three_font['font-family'] == 0){echo "<style>h3 {font-family: ". $proton_heading_three_font['font-family'] ." !important;}</style>";}
	if(!$proton_heading_three_font['font-size'] == 0){echo "<style>h3 {font-size: ". $proton_heading_three_font['font-size'] ." !important;}</style>";}
	if(!$proton_heading_three_font['line-height'] == 0){echo "<style>h3 {line-height: ". $proton_heading_three_font['line-height'] ." !important;}</style>";}
	if(!$proton_heading_three_font['text-transform'] == 0){echo "<style>h3 {text-transform: ". $proton_heading_three_font['text-transform'] ." !important;}</style>";}
endif;

// Heading Four Font
$proton_heading_four_font = $options['proton_heading_four_font'];
if($proton_heading_four_font) :
	if(!$proton_heading_four_font['color'] == 0){echo "<style>h4 {color: ". $proton_heading_four_font['color'] ." !important;}</style>";}
	if(!$proton_heading_four_font['font-style'] == 0){echo "<style>h4 {font-style: ". $proton_heading_four_font['font-style'] ." !important;}</style>";}
	if(!$proton_heading_four_font['font-family'] == 0){echo "<style>h4 {font-family: ". $proton_heading_four_font['font-family'] ." !important;}</style>";}
	if(!$proton_heading_four_font['font-size'] == 0){echo "<style>h4 {font-size: ". $proton_heading_four_font['font-size'] ." !important;}</style>";}
	if(!$proton_heading_four_font['line-height'] == 0){echo "<style>h4 {line-height: ". $proton_heading_four_font['line-height'] ." !important;}</style>";}
	if(!$proton_heading_four_font['text-transform'] == 0){echo "<style>h4 {text-transform: ". $proton_heading_four_font['text-transform'] ." !important;}</style>";}
endif;

// Heading Five Font
$proton_heading_five_font = $options['proton_heading_five_font'];
if($proton_heading_five_font) :
	if(!$proton_heading_five_font['color'] == 0){echo "<style>h5 {color: ". $proton_heading_five_font['color'] ." !important;}</style>";}
	if(!$proton_heading_five_font['font-style'] == 0){echo "<style>h5 {font-style: ". $proton_heading_five_font['font-style'] ." !important;}</style>";}
	if(!$proton_heading_five_font['font-family'] == 0){echo "<style>h5 {font-family: ". $proton_heading_five_font['font-family'] ." !important;}</style>";}
	if(!$proton_heading_five_font['font-size'] == 0){echo "<style>h5 {font-size: ". $proton_heading_five_font['font-size'] ." !important;}</style>";}
	if(!$proton_heading_five_font['line-height'] == 0){echo "<style>h5 {line-height: ". $proton_heading_five_font['line-height'] ." !important;}</style>";}
	if(!$proton_heading_five_font['text-transform'] == 0){echo "<style>h5 {text-transform: ". $proton_heading_five_font['text-transform'] ." !important;}</style>";}
endif;

// Heading Six Font
$proton_heading_six_font = $options['proton_heading_six_font'];
if($proton_heading_six_font) :
	if(!$proton_heading_six_font['color'] == 0){echo "<style>h6 {color: ". $proton_heading_six_font['color'] ." !important;}</style>";}
	if(!$proton_heading_six_font['font-style'] == 0){echo "<style>h6 {font-style: ". $proton_heading_six_font['font-style'] ." !important;}</style>";}
	if(!$proton_heading_six_font['font-family'] == 0){echo "<style>h6 {font-family: ". $proton_heading_six_font['font-family'] ." !important;}</style>";}
	if(!$proton_heading_six_font['font-size'] == 0){echo "<style>h6 {font-size: ". $proton_heading_six_font['font-size'] ." !important;}</style>";}
	if(!$proton_heading_six_font['line-height'] == 0){echo "<style>h6 {line-height: ". $proton_heading_six_font['line-height'] ." !important;}</style>";}
	if(!$proton_heading_six_font['text-transform'] == 0){echo "<style>h6 {text-transform: ". $proton_heading_six_font['text-transform'] ." !important;}</style>";}
endif;

}
add_action('wp_head', 'proton_custom_fonts');

?>
