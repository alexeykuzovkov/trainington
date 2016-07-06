<?php
/**
* 
*/
class Backend
{
	function __construct()
	{
		include_once('db.php');
		$this->db = new Connection();
		$this->db->connect();
	}

	private function checkActiveSessionByHash($hash) {
		$sql = "SELECT userid FROM sessions WHERE hash = ? AND token=? AND expireDate > NOW()";
		$result = $this->db->select($sql, [$hash, session_id()], 'ss');
		if (count($result)==0) return false;
		else return $result[0]['userid'];
	}
	private function updateActionAndEndDatesByHash($hash) {
		$sql = "UPDATE sessions SET expireDate = NOW() + INTERVAL 1 DAY, lastActionDate = NOW() WHERE hash = ?;";
		$result = $this->db->sql($sql, [$hash],'s');
	}

	/** Получение списка страниц для меню */
	public function getMenuPages() {
		$result = $this->db->select('SELECT url, name FROM Pages WHERE Pages.mainMenu=1 ORDER BY Pages.order;',[], '');
		return $result;
	}

	/** Топы тренеров */
	public function getFeatured() {
		$result = $this->db->select('SELECT f.id fetid, f.name fetname, fc.trainerid, 
			CONCAT_WS(" ",u.lastname, u.firstname) username, 
			u.avatar avatar, u.id userid, u.skill
			from featured f 
			LEFT JOIN featuredcontent as fc ON fc.featuredID = f.id 
			LEFT JOIN users as u ON u.id = fc.trainerid 
			LEFT JOIN pricelist as pl on pl.trainerid = fc.trainerid
			WHERE f.startdate < NOW() AND f.enddate >= NOW() AND u.userlevel = 2 AND pl.activity = 1
GROUP BY fc.trainerid
			ORDER BY fc.dorder', [], '');
		if (count($result)>0) {
			$featured = array();
			foreach ($result as $key => $value) {
				if (!isset($featured[$value["fetid"]])) {
					$featured[$value["fetid"]] = array("fetname"=>$value["fetname"], "trainers"=>array());
				}
				$featured[$value["fetid"]]["trainers"][] = array('username' => $value["username"], 'userid' => $value["userid"], 'avatar' => $value["avatar"], 'skill' => $value['skill']); 
			}
			return $featured;
		}
		return false;
	}

	public function getFeatureContents($fetid) {
		$sql = 'SELECT 
				CONCAT_WS(" ",u.lastname, u.firstname) username, 
							u.avatar avatar, u.id userid, u.skill, f.name name
				FROM featuredcontent fc
				LEFT JOIN users u on u.id = fc.trainerID
				LEFT JOIN featured f on f.id = fc.featuredID
				WHERE u.userlevel = 2 AND fc.featuredID = ?';
		return $this->db->select($sql,[(int)$fetid], 'i');	
	}

}

return new Backend();
?>