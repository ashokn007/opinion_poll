<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @Controller      Opinion
 * @author          AShok Kumar
 * @added           2019.05.27
 * @updated author  none
 * @update date     none
 * @since           Version 1.0
 * @filesource      Controller/Opinion
 */

/* @property opinion_counter_model $opinion_counter */
class Opinion extends Front_end
{

    function __construct()
    {

        parent::__construct();
        $this->load->model('opinion_counter_model', 'opinion_counter');
    }

    public function index()
    {
        $this->opinion_page();
    }

    /**
     *  display all categories of voting in frontend.
     */
    public function opinion_page()
    {
        $data['vote'] = $this->opinion_counter->get_one_active();
        $columns = $this->opinion_counter->get_all_columns_active();
        $data['columns'] = array_filter($columns);
       //echo "<pre>"; print_r($data); exit;

        $this->view('content/opinion_page', $data);
    }

    /**
     * This function to submit Opinion
     * @param integer $id
     */
    public function submit_opinion($id)
    {

        $ip = $this->input->ip_address();
        $v_column = $this->input->post('v_column');
        if (!empty($v_column)) {
            $found_ip = $this->opinion_counter->check_ip($id, $ip);
            if (empty($found_ip)) {
                $this->opinion_counter->submit_opinion($id, $ip);
                $data['result'] = $this->opinion_counter->result($id);
                $data['rows'] = $this->opinion_counter->getNumsubmitedopinion($id);
                $this->view('content/opinion_result_current', $data);
            } else {
                $data['result'] = $this->opinion_counter->result($id);
                $data['rows'] = $this->opinion_counter->getNumsubmitedopinion($id);
                $this->view('content/opinion_result_current', $data);
            }
        }
    }



}

/* End of file dashboard.php */
/* Location: ./system/application/modules/matchbox/controllers/dashboard.php */