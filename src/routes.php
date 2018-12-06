<?php
    $doc_root = getenv("DOCUMENT_ROOT") . "/contact_mgr/";
    include $doc_root .'app/connection.php';
    $db = new connection();

if(isset($_POST['type']) && !empty($_POST['type'])){    
    $type = $_POST['type'];
    switch($type){
        case "addContact":
            $tblName = "contact";
            if((!empty($_POST['fullname']))&&(!empty($_POST['mobile']))){
                $value = array(
                    'fullname' => $_POST['fullname'],
                    'mobile' => $_POST['mobile'],
                    'email' => $_POST['email'],
                    'company' => $_POST['company'],
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'birthday' => $_POST['birthday'],
                    'user_id' => $_SESSION['user_id']
                );
                $q = $db->insertData($tblName,$value);
                if($q){
                $db->send_feedback("Contact saved","SUCCESS");    
                }
                else{
                    $db->send_feedback("Operation failed to insert record","ERROR");
                }
                
            }
            else{
                $db->send_feedback("Field(s) cannot be empty.","ERROR");    
            }
            break;        
        case "deleteContact":
            $tblName = "contact";
            if(!empty($_POST['id'])){
                $condition = array('id' => $_POST['id']);
                if(!$delete = $db->delete($tblName,$condition)){
                    $db->send_feedback("delete failed","ERROR");
                }
                else {
                    //$data['status'] = 'OK';
                    //echo json_encode($data);
                    $db->send_feedback("Contact Deleted","SUCCESS"); 
                }
            }
            break;
        case "updateContact":
            $tblName = "contact";
            if((!empty($_POST['fullname']))&&(!empty($_POST['mobile']))){
                $value = array(
                    'fullname' => $_POST['fullname'],
                    'mobile' => $_POST['mobile'],
                    'email' => $_POST['email'],
                    'company' => $_POST['company'],
                    'street' => $_POST['street'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'birthday' => $_POST['birthday']
                );
                $condition = array('id' => $_POST['id']);
                $update = $db->updateRecord($tblName,$value,$condition);
                //echo $update
                //exit();
                if($update){
                    $db->send_feedback("Record has been updated.","SUCCESS");
                }else{
                    $db->send_feedback("Record update failed.","ERROR");
                }
            }
            else{
                $db->send_feedback("Field(s) cannot be empty.","ERROR");    
            }
        break;
        case "addUser":
            $tblName = "user";
            if((!empty($_POST['fullname']))&&(!empty($_POST['username']))){
                $value = array(
                    'fullname' => $_POST['fullname'],
                    'username' => $_POST['username'],
                    'password' => sha1("12345") //default password 12345
                );
                $q = $db->insertData($tblName,$value);
                if($q){
                $db->send_feedback("User added","SUCCESS");    
                }
                else{
                    $db->send_feedback("Operation failed to insert record","ERROR");
                }
                
            }
            else{
                $db->send_feedback("Field(s) cannot be empty.","ERROR");    
            }
            break;        
        case "deleteUser":
            $tblName = "user";
            if(!empty($_POST['id'])){
                $condition = array('id' => $_POST['id']);
                if(!$delete = $db->delete($tblName,$condition)){
                    $db->send_feedback("delete failed","ERROR");
                }
                else {
                    $db->send_feedback("User Deleted","SUCCESS"); 
                }
            }
            break;
        case "updateUser":
            $tblName = "user";
            if((!empty($_POST['fullname']))&&(!empty($_POST['username']))){
                $value = array(
                    'fullname' => $_POST['fullname'],
                    'username' => $_POST['username']
                );
                $condition = array('id' => $_POST['id']);
                $update = $db->updateRecord($tblName,$value,$condition);                
                if($update){
                    $db->send_feedback("Record has been updated.","SUCCESS");
                }else{
                    $db->send_feedback("Record update failed.","ERROR");
                }
            }
            else{
                $db->send_feedback("Field(s) cannot be empty.","ERROR");    
            }
        break;
        case "reloadContact":
            $result = $db->getAllContactAsHtml();
            echo $result;
            break;
        case "reloadUser":
            $result = $db->getAllUserAsHtml();
            echo $result;
            break;
        case "searchUser":
            $tblName = "user";
            $key = $_POST['key'];
            $result = $db->searchUser($tblName,$key);
            echo $result;
            break;
        case "searchContact":
            $tblName = "contact";
            $key = $_POST['key'];
            $result = $db->searchRecords($tblName,$key);
            echo $result;
            break;
        case "view":
            $id = $_POST['id'];
            $tblName = "contact";
            $result = $db->getRecord($tblName,$id);
            echo json_encode($result);
            break;
        case "viewUser":
            $id = $_POST['id'];
            $tblName = "user";
            $result = $db->getRecord($tblName,$id);
            echo json_encode($result);
            break;
        case "updateUserStatus":
            $tblName = "user";
            $user_id = $_POST['id'];
            $status = $_POST['status'];
            $result = $db->changeUserStatus($user_id, $status);
            if($result){
                echo "Record has been updated.";
            }else{
                echo "Record update failed.";
            }
            break;
        case "changePass":
            $tblName = "user";
            $user_id = $_SESSION['user_id'];
            $upassword = $_POST['upassword'];
            $cpassword = $_POST['cpassword'];
            $password = sha1($_POST['password']);
            if($upassword == $cpassword){
                $result = $db->confirmPassword($user_id, $password);
                if($result){
                    $password = sha1($cpassword);
                    $result = $db->changePassword($user_id, $password);
                    if($result){
                        $db->send_feedback("Password has been changed.","SUCCESS");
                    }else{
                        $db->send_feedback("Password change failed.","ERROR");
                    }
                }
                else{
                    $db->send_feedback("Ouch! Current Password does not match.","ERROR");
                }
            }
            else{
                $db->send_feedback("Ouch! Password does not match.","ERROR");
            }
            
            break;
        default:
            $db->send_feedback("Invalid Request Type","ERROR");  
    }
}
else{
 $db->send_feedback("The process failed because of missing type parameter.","ERROR");
}