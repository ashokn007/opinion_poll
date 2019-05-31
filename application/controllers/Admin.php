<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * @Controller      admin
 * @author          AShok Kumar
 * @added           2019.05.27
 * @updated author  none
 * @update date     none
 * @since           Version 1.0
 * @filesource      Controller/Admin
 */
/* @property opinion_model $opinion */
class Admin extends Front_end
{

    function __construct()
    {

        parent::__construct();
        $this->load->language('voting');
        $this->load->model('opinion_model', 'opinion');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters("<span class='notification-input ni-error'>", "</span>");

         if($this->session->userdata('username') == '')  
           {  
                redirect(base_url() . 'main/login');  
           }  
          

    }

    public function index()
    {
        $this->question_list();
    }

    /** 
     *  display all categories of opinions in datagrid.
     */
    public function question_list()
    {
        $data['categories'] = $this->opinion->get_question_list();
        $this->view('content/question_list', $data);
    }

    /**
     *  create new voting
     */
    public function create()
    {

        $this->form_validation->set_rules('dv_title', $this->lang->line('dv_title'), 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->view('content/question_new');
        } else {
            // choices sent by the form
            $fields = $this->input->post('fields');
            // remove empty choices,order every choice by chars from A To Z
            $orderd_data = $this->array_combine2($fields);

            $this->opinion->create($orderd_data);
            $this->session->set_flashdata('success_msg', 'Question Succesfully Created');
            redirect('admin/question_list/');
        }
    }

    /**
     * This function edit the Question
     * @example id=1
     * @param integer $id
     */
    public function edit($id)
    {
        $data['vote'] = $this->opinion->get_one($id);
        $columns = $this->opinion->get_all_columns($id);
        $data['columns'] = array_filter($columns);
        $vote = $this->opinion->is_voted($id);
        if (!empty($vote)) {
            $this->session->set_flashdata('success_msg', 'sorry,you cant edit live vote');
            redirect('admin/question_list/');
        }
        $this->form_validation->set_rules('dv_title', $this->lang->line('dv_title'), 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->view('content/question_edit', $data);
        } else {

            $fields = $this->input->post('fields');
            $orderd_data = $this->array_combine2($fields);
            $this->opinion->update($orderd_data, $id);
            $this->session->set_flashdata('success_msg', 'Vote Succesfully edit');
            redirect('admin/question_list/');
        }
    }

    function array_combine2($arr2)
    {
        $filter_arr2 = array_filter($arr2);
        $arr1 = range('A', 'z');
        $count = min(count($arr1), count($filter_arr2));
        return array_combine(array_slice($arr1, 0, $count), array_slice($filter_arr2, 0, $count));
    }


    /**
     * This function remove Question then redirect to questions_list
     * @example id=1
     * @param integer $id
     */
    public function remove($id)
    {
        if ($this->opinion->delete($id)) {
            $this->session->set_flashdata('success_msg', 'Vote successfully removed');
            redirect('admin/question_list/');
        }
    }

    /**
     * This function active question then redirect to questions_list
     * @example id=1
     * @param integer $id
     */
    function activate_question($id)
    {

        $this->opinion->active($id);
        $this->session->set_flashdata('success_msg', '1 new category activated!');
        redirect('admin/question_list/');
    }

    /**
     * This function deactivate question then redirect to questions_list
     * @example id=1
     * @param integer $id
     */
    function deactivate_question($id)
    {
        $this->opinion->deactivate($id);
        $this->session->set_flashdata('success_msg', '1 new category deactivated!');
        redirect('admin/question_list/');
    }


}

/* End of file dashboard.php */
/* Location: ./system/application/modules/matchbox/controllers/dashboard.php */