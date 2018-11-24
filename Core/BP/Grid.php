<?php

class Core_BP_Grid {
    function generate_old($query,$actions = array(), $title=null, $new_btn_data=null, $progress_bar_cols=array(), $_pager="1", $hide_column_list = array()) {
        $btn_view_link = "";
        $btn_view_text = "";
        $btn_create_link = "";
        $btn_create_text = "";
        $btn_assign_text = array();
        $btn_assign_link = array();
        $btn_assign_data = array();
        $btn_text = $new_btn_data['text'];
        $btn_link = $new_btn_data['link'];
        if(isset($actions['view'])){
            $btn_view_text = $actions['view']['text'];
            $btn_view_link = $actions['view']['link'];
        }
        if(isset($actions['edit']['text'])){
            $btn_edit_text = $actions['edit']['text'];
            $btn_edit_link = $actions['edit']['link'];
        }
        if(isset($actions['delete']['text'])){
            $btn_delete_text = $actions['delete']['text'];
            $btn_delete_link = $actions['delete']['link'];
        }
        if(isset($actions['create'])){
            $btn_create_text = $actions['create']['text'];
            $btn_create_link = $actions['create']['link'];
            if(isset($actions['create']['view_link'])){
                $btn_create_view_text = $actions['create']['view_text'];
                $btn_create_view_link = $actions['create']['view_link'];
            }
        }
        if(isset($actions['assign'])){
            $count = 0;
            foreach ($actions['assign'] as $key => $value) {
                $btn_assign_text[$count] = $value['text'];
                $btn_assign_link[$count] = $value['link'];
                $btn_assign_data[$count] = $value['data'];
                $count++;
            }
        }
        $db = Zend_Db_Table::getDefaultAdapter();
        $res = $db->query($query);
        $data_arr = array();
        $count = 0;
        foreach ($res as $_res) {
            $col_count = 0;
            foreach ($_res as $key => $val) {
                if(in_array($key, $progress_bar_cols)){
                    $data_arr[$count][$key] = '
                        <div class="td-progress">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$val.'%" aria-valuemin="0" aria-valuemax="100" style="width: '.$val.'%;">
                                    <span class="sr-only">'.$val.'% Complete</span>
                                </div>
                            </div>
                            <div class="progress planned-progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'.$val.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$val.'%;">
                                    <span class="sr-only">'.$val.'% Complete</span>
                                </div>
                            </div>
                            <span>'.$val.'%</span>
                        </div>';
                }
                else{
                    $data_arr[$count][$key] = $val;
                }
                $col_count++;
            }
            $count++;
        }
        $record_count = $count;
        $top_header = '<div class="search-table">
                        <div class="col-md-12">
                            <ul class="list-inline">
                                <li> <h4><span class="badge badge_dashboard badge_green">'.$record_count.'</span>'.$title.'</h4> </li>
                                <li><a href="'.$btn_link.'" class="btn btn-primary space0"><i class="fa fa-plus-circle" aria-hidden="true"></i>'.$btn_text.'</a></li>
                            </ul>                            
                        </div>
                    </div>';
		echo '<div class="inner-padding">'; 
                if($title!=""){
                    echo $top_header;
                    $pager = $_pager;
                    echo '<table class="table table-with-progress table-with-progress-4" id="tablesorting-'.$pager.'">';
                    $col_count = 6;
                }
                else{
                    echo '<table class="table table-with-progress table-with-progress-4" id="tablesorting-3">';
                    $pager = "3";
                }
                            $limit = 0;
                            foreach ($data_arr as $value) {
                                $limit++;
                                if($limit==1){
                                    echo '<thead>
                                        <tr>';
                                    foreach ($value as $key => $val) {
                                        if(!in_array($key, $hide_column_list)){
                                            echo '<th scope="col" data-rt-column="'.$key.'">'.$key.'</th>';
                                        }
                                    }
                                    if($btn_view_link!=""||$btn_create_link!=""){
                                        echo '<th scope="col" data-rt-column="Actions">Actions</th>';
                                    }
                                    echo '</tr>
                                    </thead>';
                                    echo '<tbody>';
                                }
                            }
                            foreach ($data_arr as $value) {
                                $sub_count = 0;
                                foreach ($value as $key => $val) {
                                    if($sub_count==0){
                                        $_id = $val;
                                        $sub_count = 1;
                                    }
                                }
                                if($btn_view_link!=""){
                                    echo '<tr class="clickable-row" data-href="'.str_replace('{id}', $_id, $btn_view_link).'">';
                                }
                                else{
                                    echo '<tr>';
                                }
                                $sub_count = 0;
                                foreach ($value as $key => $val) {
                                    if(!in_array($key, $hide_column_list)){
                                        echo '<td>'.$val.'</td>';
                                    }
                                }
                                if($btn_view_link!=""||$btn_create_link!=""){
                                    echo '<td>';
                                    if($btn_view_link!=""){
                                        echo '<a href="'.str_replace('{id}', $_id, $btn_view_link).'" class="btn btn-default">'.$btn_view_text.'</a>';
                                    }
                                    if($btn_edit_link!=""){
                                        echo '<a href="'.str_replace('{id}', $_id, $btn_edit_link).'" class="btn btn-default space0"><i class="fa fa-pencil" aria-hidden="true"></i>'.$btn_edit_text.'</a>';
                                    }
                                     if($btn_edit_link!=""){
                                        echo '<a href="'.str_replace('{id}', $_id, $btn_delete_link).'" class="btn btn-default space0"><i class="fa fa-remove" aria-hidden="true"></i>'.$btn_delete_text.'</a>';
                                    }
                                    if($btn_create_link!=""){
                                        $display = true;
                                        if(isset($value['rfq_id'])){
                                            if($value['rfq_id']!=""){
                                                $display = false;
                                            }
                                        }
                                        if($display){
                                            echo '<a href="'.str_replace('{id}', $_id, $btn_create_link).'" class="btn btn-primary space0"><i class="fa fa-plus-circle" aria-hidden="true"></i> '.$btn_create_text.'</a>';
                                        }
                                        else{
                                            echo '<a href="'.str_replace('{id}', $value['rfq_id'], $btn_create_view_link).'" class="btn btn-default space0"> '.$btn_create_view_text.'</a>';
                                        }
                                    }
                                    if(isset($actions['assign'])){
                                        for($count=0; $count<count($btn_assign_text); $count++){
                                            echo '<div class="dropdown user_dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'.$btn_assign_text[$count].'
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu pull-right">';
                                                $old_usertype = "";
                                                foreach ($btn_assign_data[$count] as $_assign_data) {
                                                    if($old_usertype!=$_assign_data['usertype']){
                                                        echo "<li class='separator'>".$_assign_data['usertype']."</li>";
                                                        $old_usertype = $_assign_data['usertype'];
                                                    }
                                                    echo '<li><a href="'.str_replace('{usertype}', $_assign_data['usertype'], str_replace('{id}',$_id,(str_replace('{userid}', $_assign_data['id'],$btn_assign_link[$count])))).'">'.$_assign_data['val'].'</a></li>';
                                                }
                                                echo '</ul>
                                            </div>';
                                        }
                                    }
                                    echo '</td>';
                                }
                                echo '</tr>';
                            }
                            echo '</tbody>';
                        
                        echo '<tfoot>
                            <tr>
                                <td colspan="'.$col_count.'" class="pager-'.$pager.' form-horizontal">
                                    <button class="btn first"><i class="fa fa-step-backward"></i></button>
                                    <button class="btn prev"><i class="fa fa-arrow-left"></i></button>
                                    <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                                    <button class="btn next"><i class="fa fa-arrow-right"></i></button>
                                    <button class="btn last"><i class="fa fa-step-forward"></i></button>
                                    <select class="pagesize input-xs" title="Select page size">
                                        <option selected="selected" value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                    </select>
                                    <select class="pagenum input-xs" title="Select page number"></select>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>';
	}

    function generate($query, $actions = array(), $new_btn_data = null, $hide_column_list = array(), $limit, $page) {

        $start_from = ($page - 1) * $limit;
        $query.=" LIMIT $start_from, $limit";
        $controller_name = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();        
        $btn_view_link = "";
        $btn_view_text = "";
        $btn_create_link = "";
        $btn_create_text = "";
        $btn_text = $new_btn_data['text'];
        $btn_link = $new_btn_data['link'];
        if (isset($actions['view'])) {
            $btn_view_text = isset($actions['view']['text']) ? $actions['view']['text'] : '';
            $btn_view_link = $actions['view']['link'];
        }
        if (isset($actions['edit'])) {
            $btn_edit_text = isset($actions['edit']['text']) ? $actions['edit']['text'] : '';
            $btn_edit_link = $actions['edit']['link'];
        }
        if (isset($actions['delete']['text'])) {
            $btn_delete_text = isset($actions['delete']['text']) ? $actions['delete']['text'] : '';
            $btn_delete_link = $actions['delete']['link'];
        }
        if (isset($actions['create'])) {
            $btn_create_text = isset($actions['create']['text']) ? $actions['create']['text'] : '';
            $btn_create_link = $actions['create']['link'];
        }
        $db = Zend_Db_Table::getDefaultAdapter();
        $data_arr = $db->fetchAll($query);
        if (count($data_arr) > 0) {
            foreach ($data_arr as $value) {
                $_id = $value['id'];
                if($controller_name=='orders' && isset($value['transfer_transactionid']) && ($value['transfer_transactionid']=='' || $value['transfer_transactionid']==NULL) && $value['status']=='Approved')                                   
                {
                    echo '<tr class="clickable-row danger" data-href="'.str_replace('{id}', $_id, $btn_edit_link).'">';
                }
                else
                {
                    if($btn_edit_link!='')
                        echo '<tr class="clickable-row" data-href="'.str_replace('{id}', $_id, $btn_edit_link).'">';
                    else
                        echo '<tr class="clickable-row" data-href="'.str_replace('{id}', $_id, $btn_view_link).'">';
                }
                foreach ($value as $key => $val) {
                    if (!in_array($key, $hide_column_list)) {                        
                        //for status
                        if($key=='email_verified_status' || $key=='mobile_verified_status' || $key=='idm_personal_info_status' || $key=='idm_document_verification_status' || $key=='encrypted' || $key=='can_user_purchase')
                        {
                            //user
                            if($val=='1' || $val=='A')
                                echo '<td><div class="label label-table label-success">YES</div></td>';                            
                            else if($val=='R')
                                echo '<td><div class="label label-table label-warning">Under Review</div></td>';
                            else
                                echo '<td><div class="label label-table label-danger">NO</div></td>';
                        }
                        else if($key=='status')
                        {
                            //over all
                            if($val=='1' || $val=='Active')
                                echo '<td><div class="label label-table label-success">Active</div></td>';                                                        
                            else if($val=='0' || $val=='In-Active')
                                echo '<td><div class="label label-table label-danger">Inactive</div></td>';
                            else if($val=='Pending')
                                echo '<td><div class="label label-table label-warning">'.$val.'</div></td>';
                            else if($val=='Approved')
                                echo '<td><div class="label label-table label-success">'.$val.'</div></td>';
                            else if($val=='Declined' || $val=='Cancelled')
                                echo '<td><div class="label label-table label-danger">'.$val.'</div></td>';
                            else
                                echo '<td><div class="label label-table label-danger">'.$val.'</div></td>';
                        }
                        else if($key=='published')
                        {
                            //over all
                            if($val=='1')
                                echo '<td><div class="label label-table label-success">Published</div></td>';                                                        
                            else if($val=='0')
                                echo '<td><div class="label label-table label-danger">Un-published</div></td>';
                            
                        }
                        else if($key=='simplex_next_transaction_is_fee_free')
                        {
                            if($val=='Y')
                                echo '<td><div class="label label-table label-success">Yes</div></td>';                                                        
                            else if($val=='N')
                                echo '<td><div class="label label-table label-danger">No</div></td>';
                            else
                                echo "<td></td>";
                        }
                        else{
                            echo '<td>' . $val . '</td>';
                        }
                    }
                }
                if ($btn_create_link != "" || $btn_delete_link != '' || $btn_edit_link!='' || $btn_view_link!='') {
                    echo '<td class="text-nowrap">';                    
                    
                   // if(Plugin_ACL::user_can_edit_settings(Core_BP_Session::getVal("user_id")) || $controller_name!='settings'){
                    if ($btn_edit_link != "") {
                            echo '<a href="' . str_replace('{id}', $_id, $btn_edit_link) . '" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil text-inverse m-r-10"></i>' . $btn_edit_text . '</a>';
                    }                    
                   // }
                    else if ($btn_view_link != "") {
                            echo '<a href="' . str_replace('{id}', $_id, $btn_view_link) . '" data-toggle="tooltip" data-original-title="view"><i class="fa fa-eye text-inverse m-r-10"></i>' . $btn_view_text . '</a>';
                    }
                    
                        if ($btn_delete_link != "") {
                            echo '<a href="' . str_replace('{id}', $_id, $btn_delete_link) . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-remove text-inverse m-r-10"></i>' . $btn_delete_text . '</a>';
                        }
                    
                    if ($btn_create_link != "") {
                        echo '<a href="' . str_replace('{id}', $_id, $btn_create_link) . '" class="btn btn-primary space0"><i class="fa fa-plus-circle" aria-hidden="true"></i> ' . $btn_create_text . '</a>';
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
    }

    function get_pagination_old($limit = 10, $page = 1, $sql) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchAll($sql);
        $total_records = count($result);
        $total_pages = ceil($total_records / $limit);
        $pagLink = "<div class='text-center'><ul class='pagination pagination-split'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                $pagLink .= "<li  class='active'><a href='?page=" . $i . "&limit=$limit" . "'>" . $i . "</a></li>";
            } else {
                $pagLink .= "<li><a href='?page=" . $i . "&limit=$limit" . "'>" . $i . "</a></li>";
            }
        }
        return $pagLink . "</ul></div>";
    }
    function get_pagination($per_page = 10, $page = 1, $sql) {
        $ver=Core_BP_Helpers::get_pagination_link();
        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchAll($sql);
        $total = count($result);
        $adjacents = "2";

    	$page = ($page == 0 ? 1 : $page);
    	$start = ($page - 1) * $per_page;

    	$prev = $page - 1;
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;

    	$pagination = "";
    	if($lastpage > 1)
    	{
    		$pagination .= "<div class='text-center'><ul class='pagination'>";

    		if ($lastpage < 7 + ($adjacents * 2))
    		{
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='active'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";
    				}
    				$pagination.= "<li class='disabled'>...</li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>...</a></li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";
    				}
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='$ver&page=$lastpage'>$lastpage</a></li>";
    			}
    			else
    			{
    				$pagination.= "<li><a href='$ver&page=1'>1</a></li>";
    				$pagination.= "<li><a href='$ver&page=2'>2</a></li>";
    				$pagination.= "<li class='disabled'><a>..</a></li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='active'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='$ver&page=$counter'>$counter</a></li>";
    				}
    			}
    		}

    		if ($page < $counter - 1){
    			$pagination.= "<li><a href='$ver&page=$next'>Next</a></li>";
                $pagination.= "<li><a href='$ver&page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='disabled'>Next</a></li>";
                $pagination.= "<li><a class='disabled'>Last</a></li>";
            }
    		$pagination.= "</ul></div>\n";
    	}


        return $pagination;

    }
    function get_record_per_page($limit) {
        $page_link= str_replace(" ","+",Core_BP_Helpers::get_current_page_link());
        $data = "<!-- <label class='control-label col-md-offset-8 col-md-2 space10'>Records Per Page:</b></label>
                    <div class=' col-md-2'> -->
                        <select name='records' id='records' onchange=set_page_url(this.value,'$page_link') class='form-control'>";
        $data.= "<option value='10'";
        if ($limit == 10)
            $data.="selected";$data.= ">10</option>";
        $data.="<option value='20'";
        if ($limit == 20)
            $data.="selected";$data.= ">20</option>";
        $data.="<option value='50'";
        if ($limit == 50)
            $data.="selected";$data.= ">50</option>";
        $data.="<option value='100'";
        if ($limit == 100)
            $data.="selected";$data.= ">100</option>";
        $data.="<option value='200'";
        if ($limit == 200)
            $data.="selected";$data.= ">200</option>";
        $data.="<option value='999999'";
        if ($limit == 999999)
            $data.="selected";$data.= ">999999</option>";
        $data.= "</select><!-- </div> -->";
        return $data;
    }
}
