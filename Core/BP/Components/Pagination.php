<?
class Core_BP_Components_Pagination {
	function display($total, $offset, $limit, $page, $link='/index/displayunmatched/page/', $link_param=""){
		// Some information to display to the user
		$pages = ceil($total / $limit);
	    $start = $offset + 1;
	    $end = min(($offset + $limit), $total);

	    // The "back" link
	    $prevlink = ($page > 1) ? '<a href="'.$link.'1'.$link_param.'" title="First page">&laquo;</a> <a href="'. $link . ($page - 1) . $link_param .'" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

	    // The "forward" link
	    $nextlink = ($page < $pages) ? '<a href="' . $link . ($page + 1) . $link_param .'" title="Next page">&rsaquo;</a> <a href="' . $link . $pages . $link_param .'" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

	    // Display the paging information
	    $response =  '<div id="paging"><p>'. $prevlink. ' Page '. $page. ' of '. $pages. ' pages, displaying '. $start. '-'. $end. ' of '. $total. ' results '. $nextlink. ' </p></div>';

	    return $response;
	}
}