<?php
/**
* 
*/
class Backend
{
	private $sql;
	private $sqlParams;
	private $sqlParamTypes;
	function __construct()
	{
		include_once('db.php');
		$this->db = new Connection();
		$this->db->connect();

		$this->sql ="SELECT p.RowID,p.CountTickets, p.Speed, p.UseKnife, p.UseSeparator, p.UseEthernet, p.Price, 
			p.DiamSleeveTicket, p.MaxDiamRollTicket, p.DiamSleeveRibbon, p.MaxWoundRibbon, p.MaxPrintingWidth,
			p.UseWinder, p.SKU,
			pt.PrinterType,
			dp.DPI,
			w.Winding,
			prt.PrintingType,
			m.ModelName,
			v.VendorName,
			dt.DisplayTypeName
			FROM Printers p 
			LEFT JOIN PrinterTypes pt ON pt.PrinterTypeId = p. PrinterType_ID
			LEFT JOIN DPIs dp ON dp.DPIid = p.DPI_ID
			LEFT JOIN Windings w ON w.WindingID = p.WInding_ID
			LEFT JOIN PrintingTypes prt ON prt.PrintingTypeID = p.PrintingType_ID
			LEFT JOIN Models m ON m.ModelID = p.Model_ID
			LEFT JOIN Vendors v ON v.VendorID = m.Vendor_ID
			LEFT JOIN DisplayTypes dt ON dt.DisplayTypeID = p.Display_ID WHERE 1";
		$this->sqlParams = array();
	}

	public function addWhereParameter($paramName, $value, $type) {
		$this->sql.=" AND $paramName = ?";
		$this->sqlParams[] = "$value";
		$this->sqlParamTypes.=$type;
	}	
	
	public function runQuery() {
		// print_r($this->sql);
		// print_r("<br/>");
		// print_r($this->sqlParamTypes);
		// print_r("<br/>");
		// print_r($this->sqlParams);
		return $this->db->select($this->sql, $this->sqlParams, $this->sqlParamTypes);
	}
}

return new Backend();
?>