<?
class Core_BP_Components_Pagination {
	function display($total, $offset, $limit=50, $page, $link, $link_param=""){
		// Some information to display to the user
		$pages = ceil($total / $limit);
	    $start = $offset + 1;
	    $end = min(($offset + $limit), $total);

	    // The "back" link
	    $prevlink = ($page > 1) ? '<li> <a href="'.$link.'1'.$link_param.'" title="First page"><i class="fa fa-angle-left"></i></a> </li>' : '<li> <a disabled title="First page"><i class="fa fa-angle-left"></i></a> </li>';

	    // The "forward" link
	    $nextlink = ($page < $pages) ? '<li> <a href="' . $link . ($page + 1) . $link_param .'" title="Next page"><i class="fa fa-angle-right"></i></a> </li>' : '<li> <a disabled title="Next page"><i class="fa fa-angle-right"></i></a> </li>';

	    $response = "";
	    if($total>$limit){
	    	// Display the paging information
		    $response .= '<div class="text-center">
	            <ul class="pagination pagination-split">
	                '.$prevlink;
		    if($page==1){
		    	$lower_limit = 2;
		    	$higer_limit = 5;
		    	if($lower_limit>$pages){
		    		$lower_limit = 2;
		    	}
		    	if($higer_limit>$pages){
		    		$higer_limit = $pages+1;
		    	}
		    	$response .= '<li class="active"> <a disabled>'.$page.'</a> </li>';
		    	for ($count=$lower_limit; $count <= $higer_limit; $count++) {
		    		$response .= '<li> <a href="'.$link.$count.$link_param.'">'.$count.'</a> </li>';
		    	}
		    }
		    elseif($page==$pages){
		    	$lower_limit = $page-4;
		    	$higer_limit = 5;
		    	if($lower_limit>$pages){
		    		$lower_limit = 1;
		    	}
		    	if($higer_limit>$pages){
		    		$higer_limit = $pages+1;
		    	}
		    	for ($count=$lower_limit; $count <= $higer_limit; $count++) {
		    		$response .= '<li> <a href="'.$link.$count.$link_param.'">'.$count.'</a> </li>';
		    	}
		    	$response .= '<li class="active"> <a disabled>'.$page.'</a> </li>';
		    }
		    else{
		    	if($page-2>0){
		    		$lower_limit = $page-2;
		    		$higer_limit = $page+3;
		    	}
		    	else{
		    		$lower_limit = $page-1;
		    		$higer_limit = $page+4;
		    	}

		    	if($lower_limit>$pages){
		    		$lower_limit = 1;
		    	}
		    	if($higer_limit>$pages){
		    		$higer_limit = $pages+1;
		    	}

		    	for ($count=$lower_limit; $count < $page; $count++) {
		    		$response .= '<li> <a href="'.$link.$count.$link_param.'">'.$count.'</a> </li>';
		    	}
		    	$response .= '<li class="active"> <a disabled>'.$page.'</a> </li>';
		    	for ($count=$page+1; $count < $higer_limit; $count++) {
		    		$response .= '<li> <a href="'.$link.$count.$link_param.'">'.$count.'</a> </li>';
		    	}
		    }

		    $response .= $nextlink.'
	            </ul>
	        </div>';
	    }

	    return $response;
	}
}