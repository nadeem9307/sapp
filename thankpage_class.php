<?php
include_once 'connect_db.php';
//************************ Class for MenuMeals Plan ************************* //
class thankpage_class extends CONNECT_DB {

    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->connect;
    }

    public function add_thankyou_message($data1 = array()) {
    	$id="";
    	$sql = "select id,img_url FROM `thankyou_page` LIMIT 1";
    	$res=mysqli_query($this->conn, $sql);
    	if($res && $res->num_rows > 0) {
    		$target_dir = 'uploads/';
			$data=mysqli_fetch_assoc($res);
			
			if(isset($data['img_url']) && $data['img_url']!="" && $data['img_url']!="0"){
				unlink($target_dir.$data['img_url']);
			}
			$id=$data['id'];
		}
    	
    	
    	if ($id!="") {
            $sql="UPDATE `thankyou_page` SET `description` = '" . $data1["msg"] . "', `img_url` = '" . $data1["file"] . "' WHERE `thankyou_page`.`id` = $id;";
        }else{
        	$sql="INSERT INTO `thankyou_page` (`description`, `img_url`) VALUES ('" . $data1["msg"] . "','" . $data1["file"] . "');";
		}
        $res=mysqli_query($this->conn, $sql);
        if($res){
			 return true;
		}else{
			 return false;
		}
       
    }
    
    public function query($sql = '') {
        $result = array();
        if ($sql != '') {
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        return $result;
    }
}
?>