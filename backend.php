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

	public function addWhereParameter($paramName, $value, $type, $operator = "=") {
		$this->sql.=" AND $paramName $operator ?";
		$this->sqlParams[] = "$value";
		$this->sqlParamTypes.=$type;
	}	
	
	public function getData() {
		// print_r($this->sql);
		// print_r("<br/>");
		// print_r($this->sqlParamTypes);
		// print_r("<br/>");
		// print_r($this->sqlParams);
		return $this->db->select($this->sql, $this->sqlParams, $this->sqlParamTypes);
	}

	public function getDisplaytypes() {
		$result = $this->db->select("SELECT DisplayTypeID, DisplayTypeName FROM displaytypes WHERE 1", [], '');
		return $result;
	}
	public function getDpis() {
		$result = $this->db->select("SELECT DpiID, DPI FROM dpis WHERE 1", [], '');
		return $result;
	}
	public function getPrinterTypes() {
		$result = $this->db->select("SELECT PrinterTypeID, PrinterType FROM printertypes WHERE 1", [], '');
		return $result;
	}
	public function getPrintingTypes() {
		$result = $this->db->select("SELECT PrintingTypeID, PrintingType FROM printingtypes WHERE 1", [], '');
		return $result;
	}
	public function getWindings() {
		$result = $this->db->select("SELECT WindingID, Winding FROM windings WHERE 1", [], '');
		return $result;
	}
}

return new Backend();
?>