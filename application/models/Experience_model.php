<?php 
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * AUthor Rajat Agarwal
 */
class Experience_model extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
	}

	public function get_experience_by_id($experience_id) {
        $query = $this->db->get_where('experience', ['experience_id' => $experience_id]);
        return $query->row_array();
    }

    public function getAllExperience(){
        $this->db->order_by('experience_id','desc');
        $query = $this->db->get('experience');
        return $query->result_array();
    }

    public function do_add_experience(){
        $data = array(
            'experience' => $this->security->xss_clean($this->input->post('experience'))
        );
        $this->db->insert('experience', $data);
        return $this->db->insert_id();
    }

    public function get_experience_validation($id) {
        $query = $this->db->get_where('experience', ['experience_id' => $id])->row()->experience ;
        return $query;
    }

    public function do_edit_experience($id){
        $data = array(
            'experience' => $this->security->xss_clean($this->input->post('experience'))
        );
        $this->db->update('experience', $data, ['experience_id' => $id]);
        return $this->db->affected_rows();
    }

    public function change_experience_status($id, $status){
        $this->db->update('experience', ['status' => $status], ['experience_id' => $id]);
        return $this->db->affected_rows();
    }

    public function get_industry_by_id($industry_type_id) {
        $query = $this->db->get_where('industry_type', ['industry_type_id' => $industry_type_id]);
        return $query->row_array();
    }
    
    
//study
 public function get_study_by_id($id){
        $query = $this->db->get_where('study_categories', ['study_id' => $id]);
        return $query->row_array();
    }
    
public function getAllstudycategory(){
        $this->db->order_by('study_id','desc');
        $query = $this->db->get('study_categories');
        return $query->result_array();
    }
    
     public function do_add_study(){
       $data = array(
            'name' => $this->security->xss_clean($this->input->post('study_type'))
        );
        $this->db->insert('study_categories', $data);
        return $this->db->insert_id(); 
    }
    
    public function get_study_type_validation($id){
        $query = $this->db->get_where('study_categories', ['study_id' => $id])->row() ;
        return $query;
    }
    
    public function do_edit_study($id){
        $data = array(
            'name' => $this->security->xss_clean($this->input->post('study_type'))
        );
        $this->db->update('study_categories', $data, ['study_id' => $id]);
        return $this->db->affected_rows();
    }
    
     public function change_study_status($id, $status){
        $this->db->update('study_categories', ['status' => $status], ['study_id' => $id]);
        return $this->db->affected_rows();
    }
    
//study    
    public function getAllIndustry(){
        $this->db->order_by('industry_type_id','desc');
        $query = $this->db->get('industry_type');
        return $query->result_array();
    }
    
    public function do_add_industry_type(){
        $data = array(
            'industry_type' => $this->security->xss_clean($this->input->post('industry_type'))
        );
        $this->db->insert('industry_type', $data);
        return $this->db->insert_id();
    }
    
   public function get_industry_type_validation($id) {
        $query = $this->db->get_where('industry_type', ['industry_type_id' => $id])->row()->industry_type ;
        return $query;
    }
    
    public function do_edit_industry_type($id){
        $data = array(
            'industry_type' => $this->security->xss_clean($this->input->post('industry_type'))
        );
        $this->db->update('industry_type', $data, ['industry_type_id' => $id]);
        return $this->db->affected_rows();
    }
    
    public function change_industry_status($id, $status){
        $this->db->update('industry_type', ['status' => $status], ['industry_type_id' => $id]);
        return $this->db->affected_rows();
    }
    
   public function get_employee_by_id($employee_type_id) {
        $query = $this->db->get_where('employee_type', ['employee_type_id' => $employee_type_id]);
        return $query->row_array();
    }

    public function getAllEmployee(){
        $this->db->order_by('employee_type_id','desc');
        $query = $this->db->get('employee_type');
        return $query->result_array();
    }

    public function do_add_employee_type(){
        $data = array(
            'employee_type' => $this->security->xss_clean($this->input->post('employee_type'))
        );
        $this->db->insert('employee_type', $data);
        return $this->db->insert_id();
    }

    public function get_employee_type_validation($id) {
        $query = $this->db->get_where('employee_type', ['employee_type_id' => $id])->row()->employee_type ;
        return $query;
    }

    public function do_edit_employee_type($id){
        $data = array(
            'employee_type' => $this->security->xss_clean($this->input->post('employee_type'))
        );
        $this->db->update('employee_type', $data, ['employee_type_id' => $id]);
        return $this->db->affected_rows();
    }

    public function change_employee_status($id, $status){
        $this->db->update('employee_type', ['status' => $status], ['employee_type_id' => $id]);
        return $this->db->affected_rows();
    }
}
?>