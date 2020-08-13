<?php 
defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class University_model extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
	}

	public function getAllUniversities(){
		$this->db->select('u.*,c.name as cname,s.name as sname,ui.media as image_url')
                ->from('university u')
                ->join('countries c', 'c.id=u.country_id')
                ->join('states s', 's.id=u.state_id')
                ->join('university_images ui', 'ui.university_id=u.university_id')
                ->order_by('university_id', 'DESC')
                ->group_by('u.university_id');
        $result = $this->db->get();
		return $result->result_array();
	}

	public function getUniversityById($id){
		$this->db->select('u.*,c.name as cname,s.name as sname')
                ->from('university u')
                ->join('countries c', 'c.id=u.country_id')
                ->join('states s', 's.id=u.state_id')
                ->where('university_id', $id);
        $query = $this->db->get();
		return $query->row_array();
	}

    public function getUniversityCourseById($id){
        $query = $this->db->select('uc.university_id, uc.course, uc.fee, uc.status ,c.course_name')
                 ->from('university_course uc')
                 ->join('courses c', 'c.course_id = uc.course')
                 ->where('uc.university_id', $id)
                 ->get();
        return $query->result_array();
    }

	public function getAllCourses(){
        $query = $this->db->get_where('courses', ['status' => 'Active']);
        return $query->result_array();
    }

    public function getAllCountries(){
        $query = $this->db->get('countries');
        return $query->result_array();
    }

    public function getAllStates(){
        $query = $this->db->get_where('states');
        return $query->result_array();
    }

    public function filteredCities($state_id){
        $result = $this->db->get_where('cities',['state_id'=>$state_id]);
        return $result->result_array();
    }

    public function getAllCities(){
        $query = $this->db->get_where('cities');
        return $query->result_array();
    }

    public function filteredStates($country_id){
        $result = $this->db->get_where('states',['country_id'=>$country_id]);
        return $result->result_array();
    }

    public function do_delete_university($university_id){
        $this->db->delete('university_course', ['university_id' => $university_id]);
        $this->db->delete('university_images', ['university_id' => $university_id]);
        $this->db->delete('university', ['university_id' => $university_id]);
        return $this->db->affected_rows();
    }

    public function doAddUniversity($image_url1, $image_url2, $image_url3){
        $data = array(
            'university_name' => $this->security->xss_clean($this->input->post('university_name')),
            'university_type' => $this->security->xss_clean($this->input->post('university_type')),
            'country_id' => $this->security->xss_clean($this->input->post('country')),
            'state_id' => $this->security->xss_clean($this->input->post('state')),
            'city_id' => $this->security->xss_clean($this->input->post('city')),
            'accomodation' => $this->security->xss_clean($this->input->post('accomodation')),
            'about' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->insert('university', $data);
        $university_id = $this->db->insert_id();
        if(!empty($image_url1)){
            $this->db->insert('university_images',['university_id' => $university_id, 'media' => $image_url1]);
        }
        if(!empty($image_url2)){
            $this->db->insert('university_images',['university_id' => $university_id, 'media' => $image_url2]);
        }
        if(!empty($image_url3)){
            $this->db->insert('university_images',['university_id' => $university_id, 'media' => $image_url3]);
        }
        return $university_id;
    }

    public function doUpdateUniversity($university_id, $image_url1, $image_url2, $image_url3){
        $data = array(
            'university_name' => $this->security->xss_clean($this->input->post('university_name')),
            'university_type' => $this->security->xss_clean($this->input->post('university_type')),
            'country_id' => $this->security->xss_clean($this->input->post('country')),
            'state_id' => $this->security->xss_clean($this->input->post('state')),
            'city_id' => $this->security->xss_clean($this->input->post('city')),
            'accomodation' => $this->security->xss_clean($this->input->post('accomodation')),
            'about' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->update('university', $data, ['university_id' => $university_id]);
        $this->db->delete('university_images', ['university_id' => $university_id]);
        if(!empty($image_url1)){
            $this->db->insert('university_images',['university_id' => $university_id, 'media' => $image_url1]);
        }
        if(!empty($image_url2)){
            $this->db->insert('university_images',['university_id' => $university_id, 'media' => $image_url2]);
        }
        if(!empty($image_url3)){
            $this->db->insert('university_images',['university_id' => $university_id, 'media' => $image_url3]);
        }
        return $this->db->insert_id();
    }

    public function getUniversityImageById($university_id){
        $this->db->select('*');
        $this->db->from('university_images');
        $this->db->where('university_id',$university_id);
        $sel = $this->db->get();
        return $sel->result_array();
    }

    public function do_add_university_course($university_id, $course, $fee){
        $data = array(
            'university_id' => $university_id,
            'course' => $course,
            'fee' => $fee,
        );
        $this->db->insert('university_course', $data);
        return $this->db->insert_id();
    }

    public function do_delete_university_course($university_id){
        $this->db->delete('university_course', ['university_id' => $university_id]);
        return $this->db->affected_rows();
    }

    public function get_university_name_validation($university_id) {
        $query = $this->db->get_where('university', ['university_id' => $university_id])->row()->university_name ;
        return $query;
    }
}
?>