<?
class Core_BP_Components_ProcessData {
	function readcsv($batch_id) {
		try{
			$db = Zend_Db_Table::getDefaultAdapter();
			//get file path
			$query_get_file_path = "SELECT file_name, file_path FROM upload_batch WHERE id='".$batch_id."'";
			$res = $db->query($query_get_file_path);
			if($row = $res->fetch()) {
				$s3 = Core_BP_Helpers::coreRegistry('s3');
				$accessKey = $s3->awsAccessKey;
				$secretKey = $s3->awsSecretKey;
				$bucketName = $s3->bucket;
				$s3 = new Core_BP_S3($accessKey, $secretKey);

				$file_data = $s3->getObject($bucketName, $row['file_name']);
				if($file_data->error!=""){
					Core_BP_Session::setMessage("Error in read CSV from S3");
					die("Error in read CSV from S3");
					return false;
				}
				else{
					$csv_file_data = $file_data->body;

					$database = Core_BP_Helpers::coreRegistry('database');
					$db_params = $database->db->params;

					$databasehost 		= $db_params->host; 
					$databasename 		= $db_params->dbname; 
					$databasetable 		= "shipments_info"; 
					$databaseusername	=$db_params->username; 
					$databasepassword 	= $db_params->password; 
					$fieldseparator 	= ","; 
					$lineseparator 		= "\n";
					$datetime = date('Y-m-d H:i:s');
					$csvfile = APPLICATION_PDF_SAVE_PATH."/csvfile-".$datetime.".csv";
					$myfile = fopen($csvfile, "w");
					fwrite($myfile, $csv_file_data);
					fclose($myfile);

					if(!file_exists($csvfile)) {
					    die("File not found. Make sure you specified the correct path.");
					}
					try {
					    $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
					        $databaseusername, $databasepassword,
					        array(
					            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
					            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					        )
					    );
					} catch (PDOException $e) {
						unlink(APPLICATION_PDF_SAVE_PATH.'/temp.txt');
					    die("database connection failed: ".$e->getMessage());
					}
					$affectedRows = $pdo->exec("LOAD DATA LOCAL INFILE ".$pdo->quote($csvfile)." INTO TABLE `$databasetable`
					      FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
					      OPTIONALLY ENCLOSED BY '\"'
					      LINES TERMINATED BY ".$pdo->quote($lineseparator));
					unlink($csvfile);


					//Core_BP_Components_ProcessData::storeCsvData($csv_lines, $batch_id);
					return true;
				}
			}
			else{
				Core_BP_Session::setMessage("Uploaded CSV not stored in DB");
				die("Uploaded CSV not stored in DB");
				return false;
			}
		}
		catch(Exception $e){
			Core_BP_Session::setMessage("Error in read CSV");
			die("Error in read CSV ".$e);
			unlink(APPLICATION_PDF_SAVE_PATH.'/temp.txt');
			return false;
		}
	}

	function storeCsvData($data, $batch_id){
		Core_BP_Components_ProcessData::flush_buffers();
		echo "<br>Processing data..";
		Core_BP_Components_ProcessData::flush_buffers();
		try{
			if(count($data)>0){
				array_shift($data);
				$shipments_info = array();
				foreach($data as $_data){
					echo " .";
					Core_BP_Components_ProcessData::flush_buffers();
					$csv_column_data = str_getcsv($_data);
					if(count($csv_column_data)>1){
						$shipments_info['Shipper'] 			= $csv_column_data[0];
						$shipments_info['ShipperClass'] 	= $csv_column_data[1];
						$shipments_info['ShipperCompany'] 	= $csv_column_data[2];
						$shipments_info['ShipperAddress'] 	= $csv_column_data[3];
						$shipments_info['ShipperCity'] 		= $csv_column_data[4];
						$shipments_info['ShipperSt'] 		= $csv_column_data[5];
						$shipments_info['ShipperZip'] 		= $csv_column_data[6];
						$shipments_info['RecipientName'] 	= $csv_column_data[7];
						$shipments_info['RecipientCompany'] = $csv_column_data[8];
						$shipments_info['RecipientAddress'] = $csv_column_data[9];
						$shipments_info['RecipientCity'] 	= $csv_column_data[10];
						$shipments_info['RcptSt'] 			= $csv_column_data[11];
						$shipments_info['RcptZip'] 			= $csv_column_data[12];
						$shipments_info['TrackingID'] 		= $csv_column_data[13];
						$shipments_info['ShipDate'] 		= date('Y-m-d', strtotime($csv_column_data[14]));
						$shipments_info['DeliveryDate'] 	= date('Y-m-d', strtotime($csv_column_data[15]));
						$shipments_info['Wt'] 				= $csv_column_data[16];
						$shipments_info['NumberPkgs'] 		= $csv_column_data[17];
						$shipments_info['TypeofPKG'] 		= $csv_column_data[18];
						$shipments_info['Kind'] 			= $csv_column_data[19];
						$shipments_info['VolmlperPkg'] 		= $csv_column_data[20];
						$shipments_info['upload_batch_id'] 	= $batch_id;

						Core_BP_BaseTable::insert_new('shipments_info', $shipments_info);
						unset($shipments_info);
					}
				}
				
				$db = Zend_Db_Table::getDefaultAdapter();
				$res = $db->query($query);
			}
		}
		catch(Exception $e){
			Core_BP_Session::setMessage("Error in store CSV data ".$e);
			echo '<script type="text/javascript">
				function redirect(){
					window.location.href = "/index/upload";
					return false;
				}
				redirect();
				</script>';
			//die();
		}
	}

	function getShipperAlias($_id){
		$db = Zend_Db_Table::getDefaultAdapter();

		$query_get_alias = "SELECT id, ownername, city, dba, zipcode, status, addressline1, addressline2 FROM m_shippers WHERE parent_shipper_id='".$_id."'";
		$res = $db->query($query_get_alias);
		$row = $res->fetchAll();

		return $row;
	}

	function checkMatch($shipper_name){
		$db = Zend_Db_Table::getDefaultAdapter();

		$query_get_shipper = "SELECT COUNT(id) AS count, id FROM m_shippers WHERE ownername='".addslashes($shipper_name)."'";
		$res = $db->query($query_get_shipper);
		$row = $res->fetch();

		return $row;
	}

	function calculateMatchCount($batch_id){
		$db = Zend_Db_Table::getDefaultAdapter();

		$query_get_number_of_lines = "SELECT COUNT(id) AS number_of_lines FROM shipments_info WHERE  upload_batch_id='".$batch_id."'";
		$res_number_of_lines = $db->query($query_get_number_of_lines);
		$row_number_of_lines = $res_number_of_lines->fetch();

		$query_get_match_count = "SELECT COUNT(id) AS authorized_shippers FROM shipments_info WHERE match_type='exact' AND upload_batch_id='".$batch_id."'";
		$res_match_count = $db->query($query_get_match_count);
		$row_match_count = $res_match_count->fetch();

		$query_get_non_matched_count = "SELECT COUNT(id) AS non_matched_count FROM shipments_info WHERE match_type='notmatched' AND upload_batch_id='".$batch_id."'";
		$res_non_matched_count = $db->query($query_get_non_matched_count);
		$row_non_matched_count = $res_non_matched_count->fetch();

		$query_get_custom_matched_count = "SELECT COUNT(id) AS non_matched_count FROM shipments_info WHERE match_type='partial' AND upload_batch_id='".$batch_id."'";
		$res_custom_matched_count = $db->query($query_get_custom_matched_count);
		$row_custom_matched_count = $res_custom_matched_count->fetch();

		$query_unauthorized_vol = "SELECT IFNULL(SUM(IFNULL(Wt, 0)), 0) AS unauthorized_volume FROM shipments_info WHERE match_type='notmatched' AND upload_batch_id='".$batch_id."'";
		$res_unauthorized_vol = $db->query($query_unauthorized_vol);
		$row_unauthorized_vol = $res_unauthorized_vol->fetch();

		$query_authorized_vol = "SELECT IFNULL(SUM(IFNULL(Wt, 0)), 0) AS authorized_volume FROM shipments_info WHERE match_type<>'notmatched' AND upload_batch_id='".$batch_id."'";
		$res_authorized_vol = $db->query($query_authorized_vol);
		$row_authorized_vol = $res_authorized_vol->fetch();

		//NEW
		$query_total_shippers = "SELECT COUNT(DISTINCT(ShipperCompany)) AS total_shippers FROM shipments_info WHERE upload_batch_id='".$batch_id."'";
		$res_total_shippers = $db->query($query_total_shippers);
		$row_total_shippers = $res_total_shippers->fetch();

		$query_non_matched_shippers = "SELECT COUNT(DISTINCT(ShipperCompany)) AS not_match FROM shipments_info WHERE match_type='notmatched' AND upload_batch_id='".$batch_id."'";
		$res_non_matched_shippers = $db->query($query_non_matched_shippers);
		$row_non_matched_shippers = $res_non_matched_shippers->fetch();

		$query_authorized_shipper = "SELECT COUNT(DISTINCT(ShipperCompany)) AS authorized_shippers FROM shipments_info WHERE match_type<>'notmatched' AND upload_batch_id='".$batch_id."'";
		$res_authorized_shipper = $db->query($query_authorized_shipper);
		$row_authorized_shipper = $res_authorized_shipper->fetch();

		$upload_batch = array();
		$upload_batch['exact_match'] = $row_match_count['authorized_shippers'];
		$upload_batch['partial_match'] = $row_custom_matched_count['non_matched_count'];
		$upload_batch['not_match'] = $row_non_matched_count['non_matched_count'];
		$upload_batch['authorized_shippers'] = $row_authorized_shipper['authorized_shippers'];
		$upload_batch['unauthorized_shippers'] = $row_non_matched_shippers['not_match'];
		$upload_batch['unauthorized_volume'] = $row_unauthorized_vol['unauthorized_volume'];
		$upload_batch['authorized_volume'] = $row_authorized_vol['authorized_volume'];
		$upload_batch['number_of_lines'] = $row_number_of_lines['number_of_lines'];
		$upload_batch['total_shippers'] = $row_total_shippers['total_shippers'];

		$wh = "id='".$batch_id."'";
		Core_BP_BaseTable::update_new('upload_batch', $upload_batch, $wh);
		unset($upload_batch);
	}

	function flush_buffers(){ 
	    ob_end_flush();
	    ob_flush();
	    flush();
	    ob_start();
	}
}
