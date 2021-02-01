<?php
class ModelExtensionModuleAdminEmail extends Model {
	public function getImages() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "adminemail`");

		return $query->rows;
	}
   
 }