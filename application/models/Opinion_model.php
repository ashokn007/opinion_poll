<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @Model           Opinion_model
 * @author          AShok Kumar
 * @added           2019.05.27
 * @updated author  none
 * @update date     none
 * @since           Version 1.0
 * @filesource      Model/Opinion_model
 */
class Opinion_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /* This function create new Question. */

    function create($orderd_data)
    {
       try {
        foreach($orderd_data as $key => $value){
            $this->db->set('dv_title',$this->input->post('dv_title'));
            $this->db->set($key,$value);
            $this->db->set('dv_created', time());
        }
        $query = $this->db->insert('ci_opinion');
        if(!$query){
            throw new Exception('Custom error message');
        }

        }catch (Exception $e) {
        log_message("error", $e->getMessage());
        return show_error($e->getMessage());
        }

    }


    function update($orderd_data,$id)
    {
         try {
                $this->db->where('dv_id',$id);
                $this->db->delete('ci_opinion');

            foreach($orderd_data as $key => $value){
                $this->db->set($key,$value);
                $this->db->set('dv_created', time());
            }
            $this->db->set('dv_title',$this->input->post('dv_title'));
            $this->db->set('dv_state',$this->input->post('dv_state'));
            $query = $this->db->insert('ci_opinion');
            if(!$query){
                throw new Exception('Custom error message');
            }

        }catch (Exception $e) {
        log_message("error", $e->getMessage());
        return show_error($e->getMessage());
        }


    }


    /* This function delete votes of new from database. */

    function delete($id)
    {
        $this->db->where('dv_id', $id);
        $this->db->delete('ci_opinion');

        $this->db->where('v_voting_id', $id);
        $this->db->delete('ci_opinion_counter');
        return TRUE;


        try {
            $this->db->where('dv_id', $id);
            $query_opinion = $this->db->delete('ci_opinion');

             $this->db->where('v_voting_id', $id);
            $query_count = $this->db->delete('ci_opinion_counter');
            
            if(!$query_opinion){
                throw new Exception('Custom error message');
            }
            if(!$query_count){
                throw new Exception('Custom error message');
            }

          }catch (Exception $e) {
            log_message("error", $e->getMessage());
            return show_error($e->getMessage());
          }
    }

    function active($id) {
        $this->db->set('dv_state', 1);
        $this->db->where('dv_id', $id);
        $this->db->update('ci_opinion');

        $this->db->set('dv_state',0);
        $this->db->where('dv_id !=', $id);
        $this->db->update('ci_opinion');
        return $this->db->elapsed_time();
    }

    function deactivate($id) {
        $this->db->set('dv_state', 0);
        $this->db->where('dv_id', $id);
        $this->db->update('ci_opinion');

        $this->db->set('dv_state',1);
        $this->db->where('dv_id !=', $id);
        $this->db->update('ci_opinion');
    }

    function get_one($id)
    {
       $this->db->where('dv_id',$id);
       $result=$this->db->get('ci_opinion');
       return $result->row();
    }
    /*  This function get all votes of news from database sort by order asc.*/

    function get_question_list()
    {
        $this->db->order_by('dv_id', 'asc');
        $result=$this->db->get('ci_opinion');
        return $result->result_array();
    }




    function get_categories_active()
    {
        $this->db->where('dv_state', '1');
        $result=$this->db->get('ci_opinion');
        return $result->result_array();
    }

    function get_all_columns($id) {
        $this->db->where('dv_id',$id);
        $this->db->select('A,B,C,D,E,F,G,H,I,J');
        $result=$this->db->get('ci_opinion');
        $return = array();
        if ($result->num_rows() > 0) {
            foreach ($result->row_array() as $key=>$value) {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    function is_voted($id)
    {
        $this->db->where('v_voting_id', $id);
        $result = $this->db->get('ci_opinion_counter');
        if ($result->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


}