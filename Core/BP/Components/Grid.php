<?
class Core_BP_Components_Grid {
	function generate($query,$actions = array(), $title=null, $new_btn_data=null, $progress_bar_cols=array(), $_pager="1", $hide_column_list = array()) {
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
}
