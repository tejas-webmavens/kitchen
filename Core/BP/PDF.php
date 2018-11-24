<?
class Core_BP_PDF {
	function wkhtml2pdf($url,$output) {
		$customer_path = realpath(CORE_PATH."/../../Customer");
		
		if(strpos(__FILE__,"home/webs")!==false) {
			$run = $customer_path."/public/wkhtmltopdf-i386";
		} else {
			//$run = $customer_path."/public/wkhtmltopdf.i368";
			$run = $customer_path."/public/wkhtmltopdf --load-error-handling ignore";
		}
		
		$run .= " $url $output";
		exec($run);
		
	}
}
