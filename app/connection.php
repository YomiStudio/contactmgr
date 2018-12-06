<?php session_start(); ?>
<?php
class connection{
	
	private $dbHost     = 'localhost';
    private $dbUsername = 'root';
    private $dbPassword = 'xlwebdev';
    private $dbName     = 'contact_mgr';
    public $db;

	public function __construct(){
		//set time zone
		date_default_timezone_set("Africa/Lagos");

		//connect to database
		if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
	}

    /*
    * Returns the number of rows in the table given
    */
    public function getCount($table){
        $query = "SELECT * FROM ". $table;
        $stmt = $this->db->prepare($query);
        if($stmt->execute())
            return $stmt->rowCount();
        else
            return 0;
    }  

    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRecord ($table,$key){
        $sql = "SELECT * FROM ".$table ." WHERE id = " .$key;
        $query = $this->db->prepare($sql);
        if($query->execute()){
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

   
    public function getAllContactAsHtml (){
        $result ='<table cellspacing="0" width="100%" class="table table-hover"><tbody>';
        $stmt = $this->db->prepare("SELECT * FROM contact ORDER BY fullname ASC");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            { 
                $result .='<tr id="'. $row['id'] .'" class="view-link" title="View"><td>'.
                    $row['fullname'] . " ( " . $row['mobile']. ' )</td><td><a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a></td></tr>';
            }
        }
        else{
            $result .= '<tr><td>List is empty</td></tr>';
        }  
            $result .='</tbody></table>';

        echo $result;
    }

    public function getAllUserAsHtml (){
        $result ='<table cellspacing="0" width="100%" class="table table-hover"><tbody>';
        $stmt = $this->db->prepare("SELECT * FROM user ORDER BY fullname ASC");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            { 
                if($row['status']=="Active") {$status = "Deactivate"; }else{$status = "Activate";} 
                $result .='<tr><td id="'. $row['id'] .'" class="view-link" title="View">'.
                    $row['fullname'] . " ( " . $row['username']. ' )</td><td><button id="'. $row['id'] .'" type="button" class="btn btn-primary status">'.$status .'</button></td></tr>';
            }
        }
        else{
            $result .= '<tr><td>List is empty</td></tr>';
        }  
            $result .='</tbody></table>';

        echo $result;
    }

    public function searchUser($table, $search){
        $result ='<table cellspacing="0" width="100%" class="table table-hover"><tbody>';
        $stmt = $this->db->prepare("SELECT * FROM user WHERE fullname LIKE '%".$search. "%'");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            { 
                if($row['status']=="Active") {$status = "Deactivate"; }else{$status = "Activate";} 
                $result .='<tr><td id="'. $row['id'] .'" class="view-link" title="View">'.
                    $row['fullname'] . " ( " . $row['username']. ' )</td><td><button id="'. $row['id'] .'" type="button" class="btn btn-primary status">'.$status .'</button></td></tr>';
            }
        }
        else{
            $result .= '<tr><td>Record could not be found!</td></tr>';
        }  
            $result .='</tbody></table>';

        echo $result;
    }

    public function searchRecords ($table, $search){
        $result ='<table cellspacing="0" width="100%" class="table table-hover"><tbody>';
        $stmt = $this->db->prepare("SELECT * FROM contact WHERE fullname LIKE '%".$search. "%' OR mobile LIKE '%".$search ."%'");
        $stmt->execute();
        if($stmt->rowCount() > 0){
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            { 
                $result .='<tr id="'. $row['id'] .'" class="view-link" title="View"><td>'.
                    $row['fullname'] . " ( " . $row['mobile']. ' )</td><td><a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a></td></tr>';
            }
        }
        else{
            $result .= '<tr><td>Record could not be found!</td></tr>';
        }  
            $result .='</tbody></table>';

        echo $result;
    }


    public function changeUserStatus($id,$status){
        $stmt = $this->db->prepare("UPDATE user SET status = '".$status."' WHERE id =". $id);
        $update = $stmt->execute();
        return $update?$update:false;
    }

    public function confirmPassword($id,$password){
        $stmt = $this->db->prepare("SELECT password FROM user WHERE password = '".$password."' AND id =". $id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
          return false;  
        } 
    }

    public function changePassword($id,$password){
        $stmt = $this->db->prepare("UPDATE user SET password = '".$password."' WHERE id =". $id);
        $update = $stmt->execute();
        return $update?$update:false;
    }

    public function getRows($table,$conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
        
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }
        
        $query = $this->db->prepare($sql);
        $query->execute();
        
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return !empty($data)?$data:false;
    }

	public function insertData($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->db->prepare($sql);
            foreach($data as $key=>$val){
                $val = htmlspecialchars(strip_tags($val));
                $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            if($insert){
                //$data['id'] = $this->db->lastInsertId();
                //return $data;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
	
	public function updateRecord($table,$data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $val = htmlspecialchars(strip_tags($val));
                $colvalSet .= $pre.$key."='".$val."'";
               $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            $query = $this->db->prepare($sql);
            $update = $query->execute();
            return $update?$update:false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table.$whereSql;
        $delete = $this->db->exec($sql);
        return $delete?$delete:false;
    }

	//sending feedback to the calling page
	public function send_feedback($message, $status ="SUCCESS"){
		if($status == "SUCCESS"){
			//echo '<p class="alert alert-success" role="alert"><i class="fa fa-check-circle  fa-fw"></i>&nbsp;<strong>'.$message.'</strong></p>';
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fa fa-check-circle  fa-fw"></i>&nbsp;<strong>Success!</strong> '.$message.'
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span> </button></div>';
		}
		else{
			//echo '<p class="alert alert-danger" role="alert"><i class="fa fa-times-circle  fa-fw"></i>&nbsp;<strong>'.$message.'</strong></p>';
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><i class="fa fa-times-circle  fa-fw"></i>&nbsp;<strong>Error!</strong> '.$message.'
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span> </button></div>';
		}
		exit();							
	}

	public function get_current_date_formatted()
	{
		//return date('Y-M-d, g:i A');
		return date('Y-m-d, H:i:s');
	}

	public function get_current_date()
	{
		return date('Y-m-d H:i:s');
		//return date();
	}

    function auto_copyright($year = 'auto'){ 
       if(intval($year) == 'auto'){ $year = date('Y'); } 
       if(intval($year) == date('Y')){ echo intval($year); } 
       if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); } 
       if(intval($year) > date('Y')){ echo date('Y'); } 
    }

    function getYear(){ 
        return date('Y');
    }

}

?>