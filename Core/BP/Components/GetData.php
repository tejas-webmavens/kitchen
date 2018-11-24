<?
class Core_BP_Components_GetData {
	function unmatchedShipper($batch_id, $ShipperCompany) {
        $db = Zend_Db_Table::getDefaultAdapter();

        $query_shipper_details = "SELECT Shipper, ShipperClass, ShipperCompany, ShipperAddress, ShipperCity, ShipperSt, ShipperZip FROM shipments_info WHERE ShipperCompany='".$ShipperCompany."' AND upload_batch_id='".$batch_id."'";

        $res = $db->query($query_shipper_details);
        $data_shipper_details = $res->fetch();
        return $data_shipper_details;
	}
}