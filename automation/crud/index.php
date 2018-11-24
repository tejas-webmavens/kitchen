<?php
include("conn.php");
global $dbname;

?>
<style>
.shade{  
  font-weight: bold;  
  background-color: BDBDBD;
  font-family: verdana;
}
.lightshade{     
  background-color: E6E6E6;
  font-family: verdana;
}
</style>
<form method='post'>
	<table border=0 width=100% style='border:1px solid #000000'>
		<tr class="lightshade">
			<td align=center>
				<b>Enter Table Name : </b><input type=text name='table' value='<?php echo @$_POST['table']?>'>
			</td>
		</tr>
		<tr class="lightshade">
			<td align=center>
				<input type='submit' name='Addtable' value='Submit'>
			</td>
		</tr>
	</table>

<?php	
$prefix="Core_BP_";
if(isset($_POST['Addtable'])){	
	
	$tablename = $_POST['table'];
	$query = "SELECT distinct(COLUMN_NAME) FROM INFORMATION_SCHEMA.columns WHERE TABLE_NAME = '$tablename' and TABLE_SCHEMA ='$dbname' and COLUMN_NAME not in('audit_created_by', 'audit_updated_by', 'audit_created_date', 'audit_updated_date' ,'audit_ip')";
	$result = mysql_query($query);
	
	$column_arr= array();
	while($row = mysql_fetch_assoc($result))
	{
		array_push($column_arr,$row);		
	}
?>	
	<table border=0 width=100% style='border:1px solid #000000'>
		<tr>
			<td align=center colspan='4' align='center' class='shade' >
				Table Name : <?php echo $tablename; ?>
			</td>
		</tr>

		<tr class='shade'><td colspan=4 ></td></tr>
		
		<tr class='shade'>
			<td align=center ><b>Column Name</b></td>
			<td align=center>Html element</td>
			<td align=center>Data type</td>
			<td align=center>Editable</td>
		</tr>
<?php 	
	foreach($column_arr as $val){
		
?>				
		<tr class='lightshade'>
			<td align=center>		
				<?php echo $val['COLUMN_NAME'];?>
			</td>
			
			<td align=center>
				<select name="type[]">
					<?php if($val['COLUMN_NAME']=="id"){?>
						<option value=1>No</option>
					<?php }else{?>
						<option value=1>Textbox</option>
						<option value=2>Combo</option>
						<option value=3>Checkbox</option>
						<option value=4>Radiobutton</option>
						<option value=5>Textarea</option>
					<?php }?>
				</select>				
				<input type="hidden" name="column[]" value="<?php echo $val['COLUMN_NAME'];?>" /> 				
			</td>
			<td align=center>							
				<select name="datatype[]">
					<?php if($val['COLUMN_NAME']=="id"){?>
						<option value=2>Numeric</option>
					<?php }else{?>
						<option value=1>String</option>
						<option value=2>Numeric</option>
					<?php }?>					
				</select>				
			</td>
			<td align=center>							
				<select name="editable[]">
					<?php if($val['COLUMN_NAME']=="id"){?>
						<option value=2>No</option>
					<?php }else{?>
						<option value=1>Yes</option>
						<option value=2>No</option>
					<?php }?>					
				</select>				
			</td>
		</tr>		
<?php }?>	
		<tr>
			<td align=center colspan="4" align="center" class="lightshade">
				<input type='submit' name='Addtable1' value='Submit'>
			</td>
		</tr>
	</table>
<?php }elseif(isset($_POST['Addtable1'])){
	
	//echo "<pre>";
	//print_r ($_POST);
	
	//die;
	$column_arr = array();
	
	for($i=0;$i<count($_POST['type']);$i++){
		
		$arr = array();
		$arr['COLUMN_NAME']=$_POST['column'][$i];
		$arr['type']=$_POST['type'][$i];
		$arr['datatype']=$_POST['datatype'][$i];
		$arr['editable']=$_POST['editable'][$i];
				
		array_push($column_arr,$arr);		
	}	
	
	//print_r ($column_arr);
	//die;
	$tablename = $_POST['table'];
		
	//$query = "SELECT distinct(COLUMN_NAME) FROM INFORMATION_SCHEMA.columns WHERE TABLE_NAME = '$tablename' and TABLE_SCHEMA ='$dbname' and COLUMN_NAME not in('audit_created_by', 'audit_updated_by', 'audit_created_date', 'audit_updated_date' ,'audit_ip')";
	//$result = mysql_query($query);
	
	$tableclassname = ucwords(strtolower(str_replace("_","",$tablename)));
	mkdir(trim($tableclassname), 0777, true);
	$file = trim($tableclassname)."Controller.php";
	$fwrite = fopen("$tableclassname/$file","w") or exit("<br><hr>Unable to open file</hr></br>");
	
	$file = $fwrite;
	
	$str = "";
	$str.= "<?php \nclass ".$tableclassname."Controller extends Zend_Controller_Action{ \n\n"	;
	$str.= "\tprotected \$_redirector = null; \n\n";
	$str.= "\tpublic function init() \n";
	$str.= "\t{\n"; 
	$str.= "\t\t \$this->_redirector = \$this->_helper->getHelper('Redirector'); \n";
	$str.= "\t}\n";
	$str.= "\tpublic function indexAction(){\n";
	$str.="\t\tif(\$this->_request->getParam('search')){\n";
	$str.="\t\t\t\$search=\$this->_request->getParam('search');\n";
	$str.="\t\t\t\$this->view->query = \"SELECT ";
	end($column_arr);
	$lastElementKey = key($column_arr);	
	foreach($column_arr as $key=>$val){	
		$str.=strtolower($val['COLUMN_NAME']);
		if(count($column_arr)-1!=$key)
			$str.=",";
	}
	$str.="\n\t\t\t\t";
	$str.=" FROM ".strtolower($tablename)." WHERE ";	
	foreach($column_arr as $key=>$val){	
		$str.=strtolower($val['COLUMN_NAME'])." LIKE '%\$search%'";
		if(count($column_arr)-1!=$key)
			$str.=" OR ";
	}
	$str.=" ORDER BY id desc\";\n";
	$str.="\t\t}\n";
	$str.="\t\telse{\n";	
	$str.="\t\t\t\$this->view->query = \"SELECT ";	
	foreach($column_arr as $key=>$val){	
		$str.=strtolower($val['COLUMN_NAME']);
		if(count($column_arr)-1!=$key)
			$str.=",";
	}
	$str.="\n\t\t\t\t";
	$str.=" FROM ".strtolower($tablename)." ORDER BY id desc\";\n";	
	$str.= "\t\t}\n\n";
	$str.="\t\tif(\$this->_request->getParam('limit'))\n";
	$str.="\t\t\t\$this->view->limit=\$this->_request->getParam('limit');\n";            
	$str.= "\t\telse\n";
	$str.= "\t\t\t\$this->view->limit=10;\n";
	
	$str.="\t\tif(\$this->_request->getParam('page'))\n";
	$str.="\t\t\t\$this->view->page=\$this->_request->getParam('page');\n";    
	$str.= "\t\telse\n";
	$str.= "\t\t\t\$this->view->page=1;\n";
	$str.= "\t}\n\n";
		
	//add action
	$str.= "\tpublic function addAction(){\n\n";	
	$str.= "\t\tif(\$this->getRequest()->isPost())\n";
	$str.= "\t\t{\n";
	$str.= "\t\t\t\$data = \$this->_request->getPost();\n\n";
	
	foreach($column_arr as $val){	
		
		if($val['COLUMN_NAME']!="id")
			$str.= "\t\t\t\$".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']="."\$data['".strtolower($val['COLUMN_NAME'])."'];\n";  
	}	
	//$str.= "\t\t\t\$obj->add();\n\n";
	$str.= "\n\t\t\t\$".strtolower($tablename)."_id = ".$prefix."BaseTable::insert_new('".strtolower($tablename)."', \$".strtolower($tablename).");\n\n";
	$str.= "\t\t\t".$prefix."Session::setMessage(\"Data with id \".\$".strtolower($tablename)."_id.\" added\");\n";
	$str.= "\t\t\t\$this->_redirector->gotoSimple('index','".strtolower($tableclassname)."');\n";
	$str.= "\t\t}\n";
	$str.= "\t\t".$prefix."View::renderForm();\n";
	$str.= "\t}\n";
	
	//edit action
	$str.= "\tpublic function editAction(){\n\n";
	$str.= "\t\t\$db = Zend_Db_Table::getDefaultAdapter();\n";	
	$str.= "\t\t\$id = \$this->_request->getParam('id');\n";
	$str.= "\t\tif(\$this->getRequest()->isPost())\n";
	$str.= "\t\t{\n";
	$str.= "\t\t\t\$data = \$this->_request->getPost();\n\n";
	
	foreach($column_arr as $val){	
		
		if($val['COLUMN_NAME']!="id")
		$str.= "\t\t\t\$".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']="."\$data['".strtolower($val['COLUMN_NAME'])."'];\n";  
	}
	
	//$str.= "\t\t\t\$obj->update();\n\n";
	$str.= "\n\t\t\t".$prefix."BaseTable::update_new('".strtolower($tablename)."', \$".strtolower($tablename).",'id='.\$id);\n\n";
			
	$str.= "\t\t\t".$prefix."Session::setMessage(\"Data with id  \".\$id.\" updated\");\n";
	$str.= "\t\t\t\$this->_redirector->gotoSimple('index','".strtolower($tableclassname)."');\n";
	$str.= "\t\t}\n";
	$str.= "\t\t\$".strtolower($tablename)."= \$db->fetchAll(\"SELECT * FROM $tablename WHERE id=\$id\");\n";		
	$str.= "\t\t\$"."this->view->$tablename = array_shift(\$".strtolower($tablename).");\n";
	$str.= "\t\t".$prefix."View::renderForm();\n";
	$str.= "\t}\n";
	
	//view action
	$str.= "\tpublic function viewAction(){\n\n";
	$str.= "\t\t\$db = Zend_Db_Table::getDefaultAdapter();\n";
	$str.= "\t\t\$id = \$this->_request->getParam('id');\n";
	$str.= "\t\t\$".strtolower($tablename)."= \$db->fetchAll(\"SELECT * FROM $tablename WHERE id=\$id\");\n";		
	$str.= "\t\t\$"."this->view->$tablename = array_shift(\$".strtolower($tablename).");\n";
	
	$str.= "\t\t".$prefix."View::renderForm();\n";
	$str.= "\t}\n\n";
	

	//remove action
	$str.= "\tpublic function removeAction(){\n\n";
	$str.= "\t\t\$id = \$this->_request->getParam('id');\n";
	$str.= "\t\t\$rtn = ".$prefix."BaseTable::delete_new('".strtolower($tablename)."','id='.\$id);\n";	
	$str.= "\t\tif(\$rtn == 1)\n";
	$str.= "\t\t\t".$prefix."Session::setMessage(\"Data with id \$id deleted successfully\");\n";
	$str.= "\t\telse\n";
	$str.= "\t\t\t".$prefix."Session::setMessage(\"Data was not deleted because \$id not exists\");\n";
	$str.= "\t\t\$this->_redirector->gotoSimple('index','".strtolower($tableclassname)."');\n";
	$str.= "\t\tdie;\n";
	$str.= "\t}\n";
	$str.= "}?>\n";

	fputs($file, $str);
	echo $tableclassname."Controllers.php generated<br>";

	/*
	 * create index.phtml file 
	 */
	$file_index = "index.phtml";
	$fwrite = fopen("$tableclassname/$file_index","w") or exit("<br><hr>Unable to open file</hr></br>");
	
	$file_index = $fwrite;
	
	$str_index = "";
	
	$str_index.= "<?php \n\t\$title = '".ucfirst($tablename)."';\n";	
	$str_index.= "\t\$btn_data = array();\n";	
	$str_index.= "\t\$btn_data['text'] = 'Add ".ucfirst($tablename)."';\n";	
	$str_index.= "\t\$btn_data['link'] = '/".strtolower($tableclassname)."/add';\n";	
	$str_index.= "\t\$actions = array();\n";	
	$str_index.= "\t\$actions['view']['text'] = '';\n";	
	$str_index.= "\t\$actions['view']['link'] = '/".strtolower($tableclassname)."/view/id/{id}?action=view';\n";	
	$str_index.= "\t\$actions['edit']['text'] = '';\n";	
	$str_index.= "\t\$actions['edit']['link'] = '/".strtolower($tableclassname)."/edit/id/{id}';\n";
	$str_index.= "\t\$actions['delete']['text'] = '';\n";	
	$str_index.= "\t\$actions['delete']['link'] = '/".strtolower($tableclassname)."/remove/id/{id}';\n";	
	$str_index.= "\t\$hide_column = array('id');\n";	
	$str_index.= "\techo Core_BP_Grid::get_record_per_page(\$this->limit);\n?>\n";
	$str_index.= "<div class=\"row\">\n";
	$str_index.= "\t<div class=\"col-md-6\">\n";
	$str_index.= "\t\t<h3 class=\"box-title table-search-input-title\">$tableclassname<a href='/$tablename/add' class='btn btn-default m-l-15'>Add</a></h3>\n";
	$str_index.= "\t</div>";
	$str_index.= "\t<div class=\"col-md-6\">\n";
	$str_index.= "\t\t<form method=\"get\">\n";
	$str_index.="\t\t\t<div class=\"form-group table-search-input\">\n";
	$str_index.="\t\t\t\t<input type=\"text\" class=\"form-control\" placeholder=\"Search Here\" name=\"search\" id=\"search\" value=\"<?=@\$_GET['search']?>\">\n";
	$str_index.= "\t\t\t</div>\n";
	$str_index.= "\t\t</form>\n";
	$str_index.= "\t</div>\n";
	$str_index.= "</div>\n";
	$str_index.= "<div class=\"table-responsive\">\n";
	$str_index.= "\t<table class=\"table table-bordered\">\n";
	$str_index.= "\t\t<thead>\n";
	foreach($column_arr as $val){
		$str_index.= "\t\t\t<th>".ucfirst($val['COLUMN_NAME'])."</th>\n";
	}
	$str_index.= "\t\t</thead>\n";
	$str_index.= "\t\t<tbody>\n";
	$str_index.= "\t\t\t<?php\n";
	$str_index.="\t\t\t\t echo Core_BP_Grid::generate(\$this->query, \$actions, \$btn_data, \$hide_column,\$this->limit,\$this->page);\n";
	$str_index.= "\t\t\t?>\n";
	$str_index.= "\t\t</tbody>\n";	
	$str_index.= "\t</table>\n";
	$str_index.= "</div>\n";
	$str_index.="<?=Core_BP_Grid::get_pagination(\$this->limit, \$this->page, \$this->query); ?>";
	fputs($file_index, $str_index);
	echo "index.phtml generated for grid<br>";
	
	
	$file_form = "form.phtml";
	$fwrite = fopen("$tableclassname/$file_form","w") or exit("<br><hr>Unable to open file</hr></br>");
	
	$file_form = $fwrite;
	
	$str_form ="";
	$str_form.= "<?php \$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName()?>\n";
	$str_form.= "<p align=\"right\"><a href=\"/$tableclassname/index\" >";
	$str_form.= "View all</a></p>\n";	
	$str_form.= "\t<div class=\"row\">\n";
	$str_form.= "\t\t<div class=\"col-sm-12\">\n";
	$str_form.= "\t\t\t<div class=\"white-box\">\n";
	$str_form.= "\t\t\t\t<h3 class=\"box-title m-b-0\">$tableclassname</h3>\n";	
	$str_form.= "\t\t\t\t\t<form data-toggle=\"frm_$tablename\" method=\"post\">\n";	
	//print_r ($column_arr);
	
	foreach($column_arr as $val){	
			
		if($val['COLUMN_NAME']!='id'){
			$str_form.= "\t\t\t\t\t\t<div class=\"form-group\">\n";
			$str_form.= "\t\t\t\t\t\t\t<label for=\"".$val['COLUMN_NAME']."\" class=\"control-label\">".ucfirst($val['COLUMN_NAME'])." :</label>\n";			
			$str_form.= "\t\t\t\t\t\t\t<?php\n";
			$str_form.= "\t\t\t\t\t\t\t\tif(\$action==\"view\"){\n";
			$str_form.= "\t\t\t\t\t\t\t\t\techo \$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."'];\n";							
			$str_form.= "\t\t\t\t\t\t\t\t}else{\n";
			$str_form.= "\t\t\t\t\t\t\t\t?>\n";					
					
			switch($val['type']){
				
				case '1'://textbox
						$str_form.= "\t\t\t\t\t\t\t<input type=\"text\" class=\"form-control\" name=\"".strtolower($val['COLUMN_NAME'])."\" id=\"".strtolower($val['COLUMN_NAME'])."\" value=\"<?php echo \$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']; ?>\" />\n";
						break;
								
				case '2'://combo
						$str_form.= "\t\t\t\t\t\t\t\t<select name=\"".strtolower($val['COLUMN_NAME'])."\" class=\"form-control\" id=\"".strtolower($val['COLUMN_NAME'])."\">\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<option value='0' <?php if(\$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']==0){ echo 'selected'; }?>>--Please Select--</option>\n";
						$str_form.= "\t\t\t\t\t\t\t\t</select>\n";		
						//$str_form.= "<?php if(\$this->obj->get".ucfirst($val['COLUMN_NAME'])."()==1){ echo 'selected'; }";						
						break;					 
					 
				case '3'://checkbox
						$str_form.="\t\t\t\t\t\t\t\t<div class=\"checkbox\">\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"".strtolower($val['COLUMN_NAME'])."\"id=\"".strtolower($val['COLUMN_NAME'])."\" value=\"1\" <?php if(\$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']==1){ echo 'checked'; }?> />\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<label for=\"".strtolower($val['COLUMN_NAME'])."\"> ".$val['COLUMN_NAME']." </label>\n";
						$str_form.= "\t\t\t\t\t\t\t\t</div>\n";
						break;
						
				case '4'://radiobutton
						$str_form.="\t\t\t\t\t\t\t\t<div class=\"radio\">\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"".strtolower($val['COLUMN_NAME'])."\"  id=\"".strtolower($val['COLUMN_NAME'])."\" value=\"1\" <?php if(\$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']==1){ echo 'checked'; }?> />";
						$str_form.= "\t\t\t\t\t\t\t\t\t<label for=\"".strtolower($val['COLUMN_NAME'])."\"> ".$val['COLUMN_NAME']." </label>\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"".strtolower($val['COLUMN_NAME'])."\"  id=\"".strtolower($val['COLUMN_NAME'])."\" value=\"0\" <?php if(\$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']==0){ echo 'checked'; }?> />\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<label for=\"".strtolower($val['COLUMN_NAME'])."\"> ".$val['COLUMN_NAME']." </label>\n";
						$str_form.= "\t\t\t\t\t\t\t\t</div>\n";
						break;

				case '5'://textarea
						$str_form.= "\t\t\t\t\t\t\t\t<textarea name=\"".strtolower($val['COLUMN_NAME'])."\" class=\"form-control\" id=\"".strtolower($val['COLUMN_NAME'])."\"  >\n";
						$str_form.= "\t\t\t\t\t\t\t\t\t<?php echo \$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']; ?>\n";
						$str_form.= "\t\t\t\t\t\t\t\t</textarea>\n";
						break;
								
				default:
						$str_form.= "\t\t\t\t\t\t\t\t<input type=\"text\" name=\"".strtolower($val['COLUMN_NAME'])."\" class=\"form-control\" id=\"".strtolower($val['COLUMN_NAME'])."\" value=\"<?php echo \$this->".strtolower($tablename)."['".strtolower($val['COLUMN_NAME'])."']; ?>\" />\n";
						break;
			}			
			
			$str_form.= "\t\t\t\t\t\t\t<?php } ?>\n";				
			$str_form.= "\t\t\t\t\t\t</div>\n";		
		}
	}

	$str_form.= "\t\t<?php if(\$action!=\"view\"){?>\n";
	$str_form.= "\t\t<div class=\"form-group\">\n";		
	$str_form.= "\t\t\t<input class=\"btn btn-primary\" type=\"submit\" name=\"submit\" id=\"submit\" value=\"<?php echo ucfirst(\$action)?>\" >\n";		
	$str_form.= "\t\t</div>\n";
	$str_form.= "\t\t<?php }?>\n";
	$str_form.= "\t\t\t\t\t</form>\n";	
	$str_form.= "\t\t\t</div>\n";
	$str_form.= "\t\t</div>\n";
	$str_form.= "\t</div>\n";
	$str_form.= "<script>\n";	
	foreach($column_arr as $val){	
		
		if($val['COLUMN_NAME']!='id'){

			//$str_form.= "\tvar ".strtolower($val['COLUMN_NAME'])." = new LiveValidation('".strtolower($val['COLUMN_NAME'])."',{ validMessage: \" \", wait: 500 });\n";
			//$str_form.= "\t".strtolower($val['COLUMN_NAME']).".add( Validate.Presence );\n";
			
			$str_form.= "\tvar".strtolower($val['COLUMN_NAME'])." = new LiveValidation( '".strtolower($val['COLUMN_NAME'])."', {onlyOnSubmit: true } );\n";
			$str_form.= "\t".strtolower($val['COLUMN_NAME']).".add( Validate.Presence )\n";
			
		}	
	}
	
	$str_form.= "</script>";
	
	fputs($file_form, $str_form);
	echo "form.phtml generated for add, edit & view<br>";
	die;	
}
?>
</form>