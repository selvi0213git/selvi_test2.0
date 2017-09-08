<?php
/**
 * get_segment_number function
 * @param  $prize lose=1, win=2
 * @return segment number
 */
function get_segment_number($prize) {
	$random_id = rand(1, 3);
	$seg_num;

  switch ($prize) {
    case 1 :
    	$seg_num = ($random_id * 2) - 1; 
      break;
    case 2 :
    	$seg_num = $random_id * 2; 
      break;
  }//switch

  return $seg_num;
}

//꽝 or 당첨을 결정해서 1(꽝) 또는 2(당첨)를 넘겨주세요
echo get_segment_number(1);