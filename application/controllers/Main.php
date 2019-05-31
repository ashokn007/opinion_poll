 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
/**
 * @Controller      Login
 * @author          AShok Kumar
 * @added           2019.05.27
 * @updated author  none
 * @update date     none
 * @since           Version 1.0
 * @filesource      Controller/main
 */

 class Main extends CI_Controller {  
      //functions  
      function login()  
      {  
          
           $data['title'] = 'login';  
           $this->load->view("theme/login", $data);  
      }  
      function login_validation()  
      {  
           $this->load->library('form_validation');  
           $this->form_validation->set_rules('username', 'Username', 'required');  
           $this->form_validation->set_rules('password', 'Password', 'required');  
           if($this->form_validation->run())  
           {  
                //true  
                $username = $this->input->post('username');  
                $password = $this->input->post('password');  
                //model function  
                $this->load->model('main_model');  
                
                if($this->main_model->can_login($username, $password))  
                {  

                     $session_data = array(  
                          'username'     =>     $username  
                     );  
                     $this->session->set_userdata($session_data);  

                      redirect(base_url() . 'Admin');  
                   
                }  
                else  
                {  
                     $this->session->set_flashdata('error', 'Invalid Username and Password');  
                     redirect(base_url() . 'main/login');  
                }  
           }  
           else  
           {  
                //false  
                $this->login();  
           }  
      }  
      function enter(){  
           if($this->session->userdata('username') != '')  
           {  
                echo '<h2>Welcome - '.$this->session->userdata('username').'</h2>';  
                echo '<label><a href="'.base_url().'main/logout">Logout</a></label>';  
           }  
           else  
           {  
                redirect(base_url() . 'main/login');  
           }  
      }  
      function logout()  
      {  
           $this->session->unset_userdata('username');  
           redirect(base_url() . 'main/login');  
      }  
 } 