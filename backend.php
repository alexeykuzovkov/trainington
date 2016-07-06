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

		$this->notFirstWhere = false;

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
			LEFT JOIN DisplayTypes dt ON dt.DisplayTypeID = p.Display_ID";
		$this->sqlParams = array();
	}

	public function getVariantsForRow($rowName) {
		$sql = "SELECT $rowName FROM Printers GROUP BY $rowName ORDER BY $rowName";
		$res = $this->db->select($sql, [], '');
		$result = array();
		foreach ($res as $key => $value) {
			$result[] = $value["$rowName"];
		}

		return $result;
	}

	public function addWhereParameter($paramName, $value, $type, $operator = "=") {
		if (!$this->notFirstWhere) $this->sql.=" WHERE ";
		else $this->sql.=" AND ";
		if ($type=="array") {
			$this->sql.=" (";
			$index = 0;
			foreach ($value as $key => $val) {
				if ($index>0) $this->sql.=" OR ";
				$this->sql.="$paramName $operator ?";
				$this->sqlParams[] = "$val";
				$this->sqlParamTypes.="i";
				$index++;
			}
			$this->sql.=")";
		}
		else {
			$this->sql.=" $paramName $operator ?";
			$this->sqlParams[] = "$value";
			$this->sqlParamTypes.=$type;
		}
		$this->notFirstWhere = true;		
	}	
	
	public function getData() {
		error_log($this->sql);
		foreach ($this->sqlParams as $key => $value) {
			error_log($value);
		}
		$result = $this->db->select($this->sql, $this->sqlParams, $this->sqlParamTypes);
		return $result;
	}

	public function getDisplaytypes() {
		$result = $this->db->select("SELECT DisplayTypeID as id, DisplayTypeName as name FROM displaytypes WHERE 1", [], '');
		return $result;
	}
	public function getDpis() {
		$result = $this->db->select("SELECT DpiID as id, DPI as name FROM dpis WHERE 1", [], '');
		return $result;
	}
	public function getPrinterTypes() {
		$result = $this->db->select("SELECT PrinterTypeID as id, PrinterType as name FROM printertypes WHERE 1", [], '');
		return $result;
	}
	public function getPrintingTypes() {
		$result = $this->db->select("SELECT PrintingTypeID as id, PrintingType as name FROM printingtypes WHERE 1", [], '');
		return $result;
	}
	public function getWindings() {
		$result = $this->db->select("SELECT WindingID as id, Winding as name FROM windings WHERE 1", [], '');
		return $result;
	}

	public function getVendors() {
		$result = $this->db->select("SELECT VendorID as id, VendorName as name FROM Vendors WHERE 1", [], '');
		return $result;
	}
}

return new Backend();
?>