<?php
class Core_BP_Factory{
	
	public static function LoginAuthorizor($_idValue=null){
		return new LoginAuthorizer($_idValue);
	}

	public static function RfqRequest($_idValue=null){
		return new Core_BP_Models_2rfqrequest($_idValue);
	}

	public static function Customers($_idValue=null){
		return new Core_BP_Models_1customers($_idValue);
	}

	public static function RfqRequestAttachments($_idValue=null){
		return new Core_BP_Models_21rfqrequestattachments($_idValue);
	}

	public static function Rfq($_idValue=null){
		return new Core_BP_Models_3rfq($_idValue);
	}

	public static function RfqItems($_idValue=null){
		return new Core_BP_Models_31rfqitems($_idValue);
	}

	public static function RfqItemsReleaseQtys($_idValue=null){
		return new Core_BP_Models_32rfqitemsqty($_idValue);
	}

	public static function RfqItemsDrawing($_idValue=null){
		return new Core_BP_Models_4rfqitemsdrawing($_idValue);
	}

	public static function RfqItemsBom($_idValue=null){
		return new Core_BP_Models_5rfqitemsbom($_idValue);
	}

	public static function RfqItemsBomItem($_idValue=null){
		return new Core_BP_Models_51rfqitemsbomitems($_idValue);
	}

	public static function RfqConsolidatedBom($_idValue=null){
		return new Core_BP_Models_511rfqconsolidatedbom($_idValue);
	}

	public static function RfqConsolidatedBomCosting($_idValue=null){
		return new Core_BP_Models_5111rfqconsolidatedbomcosting($_idValue);
	}

	public static function OutboundFreight($_idValue=null){
		return new Core_BP_Models_9rfqoutboundfreight($_idValue);
	}

	public static function RfqItemsLabor($_idValue=null){
		return new Core_BP_Models_6rfqitemslabor($_idValue);
	}

	public static function RfqItemsLaborSummary($_idValue=null){
		return new Core_BP_Models_61rfqitemslaborsummary($_idValue);
	}

	public static function Assumptions($_idValue=null){
		return new Core_BP_Models_8rfqitemsassumptions($_idValue);
	}

	public static function OctapartsRequest($_idValue=null){ 
	    return new Core_BP_Models_Octapartsrequestdata($_idValue); 
	} 
	 
	public static function OctapartsRes($_idValue=null){ 
	    return new Core_BP_Models_Octapartsresponseoffers($_idValue); 
	} 
	 
	public static function OctapartsResPrice($_idValue=null){ 
	    return new Core_BP_Models_Octapartsresponseprice($_idValue); 
	}

	public static function ItemsNreTools($_idValue=null){
		return new Core_BP_Models_7rfqitemsnretools($_idValue);
	}
}
?>
