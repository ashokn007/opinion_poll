 <?php   if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * @Model           Main_model
 * @author          AShok Kumar
 * @added           2019.05.27
 * @updated author  none
 * @update date     none
 * @since           Version 1.0
 * @filesource      Model/main_model
 */
 class Main_model extends CI_Model  
 {  
      function can_login($username, $password)  
      {  
          try {
            $this->db->where('username', $username);  
            $this->db->where('password', md5($password));  
            $query = $this->db->get('ci_users');  
            if(!$query){
                throw new Exception('Custom error message');
            }

          }catch (Exception $e) {
            log_message("error", $e->getMessage());
            return show_error($e->getMessage());
          }
          if($query->num_rows() > 0)  
           {  
                return true;  
           }  
           else  
           {  
                return false;       
           }  
      }  
 }  
 ?>
