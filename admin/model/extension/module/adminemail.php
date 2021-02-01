<?php
class ModelExtensionModuleAdminEmail extends Model {
    public function deleteSchema() {
      $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "adminemail`");
    }
   
	public function createSchema() {
        $this->db->query("
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "adminemail` (
		`images` 		 INT(1) DEFAULT 1,
		`orientation` 	 VARCHAR(6) DEFAULT 'Width',
		`pixels` 	     INT(3) DEFAULT 90
        ) DEFAULT CHARSET=utf8");
		
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "adminemail`");
		
		$this->db->query("
		INSERT INTO `" . DB_PREFIX . "adminemail` (`images`, `orientation`, `pixels`) VALUES
			(1, 'Width', 90)");
    }
	
	public function setImages($images, $orientation, $pixels) {
		$this->db->query("UPDATE `" . DB_PREFIX . "adminemail` SET 
		    `images`          = '$images',
			`orientation`     = '$orientation',
			`pixels`          = '$pixels'
			");
	}
	
	public function getImages() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "adminemail`");

		return $query->rows;
	}
 }