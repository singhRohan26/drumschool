<?php 
defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Category_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function get_category_by_id($id) {
        $query = $this->db->get_where('job_category', ['job_category_id' => $id]);
        return $query->row_array();
    }

    public function getAllCategory(){
        $this->db->order_by('job_category_id','desc');
        $query = $this->db->get('job_category');
        return $query->result_array();
    }

    public function do_add_category(){
        $data = array(
            'category_name' => $this->security->xss_clean($this->input->post('category_name'))
        );
        $this->db->insert('job_category', $data);
        return $this->db->insert_id();
    }

    public function get_category_validation($id) {
        $query = $this->db->get_where('job_category', ['job_category_id' => $id])->row()->category_name ;
        return $query;
    }

    public function do_edit_category($id){
        $data = array(
            'category_name' => $this->security->xss_clean($this->input->post('category_name'))
        );
        $this->db->update('job_category', $data, ['job_category_id' => $id]);
        return $this->db->affected_rows();
    }

    public function change_category_status($id, $status){
        $this->db->update('job_category', ['status' => $status], ['job_category_id' => $id]);
        return $this->db->affected_rows();
    }

    public function get_course_by_id($id) {
        $query = $this->db->get_where('courses', ['course_id' => $id]);
        return $query->row_array();
    }

    public function getAllCourses(){
        $this->db->order_by('course_id','desc');
        $query = $this->db->get('courses');
        return $query->result_array();
    }

    public function do_add_course(){
        $data = array(
            'course_name' => $this->security->xss_clean($this->input->post('course_name'))
        );
        $this->db->insert('courses', $data);
        return $this->db->insert_id();
    }

    public function get_course_validation($id) {
        $query = $this->db->get_where('courses', ['course_id' => $id])->row()->course_name ;
        return $query;
    }

    public function do_edit_course($id){
        $data = array(
            'course_name' => $this->security->xss_clean($this->input->post('course_name'))
        );
        $this->db->update('courses', $data, ['course_id' => $id]);
        return $this->db->affected_rows();
    }

    public function change_course_status($id, $status){
        $this->db->update('courses', ['status' => $status], ['course_id' => $id]);
        return $this->db->affected_rows();
    }
}
?>