<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @Model      		Opinion_counter_model
 * @author          AShok Kumar
 * @added           2019.05.27
 * @updated author  none
 * @update date     none
 * @since           Version 1.0
 * @filesource      model/Opinion_counter_model
 */

class Opinion_counter_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}


	function submit_opinion($id, $ip)
	{
		try {
			$opt_leave = explode(",", $this->input->post('v_column'));
			$column = $opt_leave[0];
			$data = $opt_leave[1];
			$this->db->set('v_column',$column);
			$this->db->set('v_data',$data);
			$this->db->set('v_vistor_ip',$ip);
			$this->db->set('v_voting_id', $id);
			$query = $this->db->insert('ci_opinion_counter');
            
            if(!$query){
                throw new Exception('Custom error message');
            }

          }catch (Exception $e) {
            log_message("error", $e->getMessage());
            return show_error($e->getMessage());
          }

	}

	function get_one_active()
	{
		$this->db->where('dv_state', 1);
		$result = $this->db->get('ci_opinion');
		return $result->row();
	}

	function get_all_columns_active()
	{
		$this->db->where('dv_state', 1);
		$this->db->select('A,B,C,D,E,F,G,H,I,J');
		$result = $this->db->get('ci_opinion');
		$return = array();
		if ($result->num_rows() > 0) {
			foreach ($result->row_array() as $key => $value) {
				$return[$key] = $value;
			}
		}

		return $return;
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////frontend//////////////////////////////////////////////////////////
	function check_ip($id, $ip)
	{
		$this->db->where('v_voting_id', $id);
		$this->db->where('v_vistor_ip', $ip);
		$result = $this->db->get('ci_opinion_counter');
		if ($result->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	

	function result($id)
	{

		$result = $this->db->query(" SELECT * FROM ci_opinion_counter INNER JOIN ci_opinion
                            ON ci_opinion_counter.v_voting_id = ci_opinion.dv_id
                            WHERE dv_id=$id ")->row();
		return $result;
	}

	// get total number of voting one
	function getNumsubmitedopinion($id)
	{
		$result = $this->db->query("SELECT v_column,v_data,
									SUM(v_value) as vote_value,
			(SELECT SUM(v_value)FROM ci_opinion_counter WHERE v_voting_id=$id) as total
									FROM ci_opinion_counter
									WHERE v_voting_id=$id
									GROUP BY v_column")->result_array();

		foreach($result as $key => $value)
		{
			$value['prec'] = round(100*($value['vote_value'] / $value['total']),2);
			$result[$key] = $value;

		}
		return array_filter($result);

	}

}