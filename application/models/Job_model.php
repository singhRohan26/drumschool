<?php 
defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Job_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	public function getAllJobs(){
		$this->db->select('j.*,c.name as cname,s.name as sname, et.employee_type');
		$this->db->from('job j');
		$this->db->join('countries c', 'c.id=j.country_id');
		$this->db->join('states s', 's.id=j.state_id');
        $this->db->join('employee_type et', 'et.employee_type_id=j.employee_type_id');
		$this->db->order_by('job_id', 'DESC');
        $this->db->where('j.status', 'Active');
		$query = $this->db->get();
		return $query->result_array();
	}

    public function getAllJobRequests(){
        $this->db->select('j.*,c.name as cname,s.name as sname, et.employee_type');
        $this->db->from('job j');
        $this->db->join('countries c', 'c.id=j.country_id');
        $this->db->join('states s', 's.id=j.state_id');
        $this->db->join('employee_type et', 'et.employee_type_id=j.employee_type_id');
        $this->db->order_by('job_id', 'DESC');
        $this->db->where('j.status', 'Inactive');
        $query = $this->db->get();
        return $query->result_array();
    }

	public function getJobById($job_id){
		$this->db->select('j.*,c.name as cname,s.name as sname, et.employee_type, it.industry_type');
		$this->db->from('job j');
		$this->db->join('countries c', 'c.id=j.country_id');
		$this->db->join('states s', 's.id=j.state_id');
        $this->db->join('employee_type et', 'et.employee_type_id=j.employee_type_id');
        $this->db->join('industry_type it', 'it.industry_type_id=j.industry_type_id');
		$this->db->where('j.job_id', $job_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getJobQualificationsByJobId($job_id){
		$this->db->select('jq.*, c.course_name');
		$this->db->from('job_qualifications jq');
		$this->db->join('courses c', 'c.course_id = jq.qualification_id');
		$this->db->where('jq.job_id', $job_id);
		$query = $this->db->get();
		return $query->result_array();
	}

    public function getAllQualifications(){
        $query = $this->db->get_where('courses', ['status' => 'Active']);
        return $query->result_array();
    }

    public function getAllEmployeeTypes(){
        $query = $this->db->get_where('employee_type', ['status' => 'Active']);
        return $query->result_array();
    }

    public function getAllIndustryTypes(){
        $query = $this->db->get_where('industry_type', ['status' => 'Active']);
        return $query->result_array();
    }

    public function getAllExperiences(){
        $query = $this->db->get_where('experience', ['status' => 'Active']);
        return $query->result_array();
    }

    public function getAllCountries(){
        $query = $this->db->get_where('countries');
        return $query->result_array();
    }

    public function getAllStates(){
        $query = $this->db->get_where('states');
        return $query->result_array();
    }

    public function getAllCities(){
        $query = $this->db->get_where('cities');
        return $query->result_array();
    }

    public function filteredStates($country_id){
        $result = $this->db->get_where('states',['country_id'=>$country_id]);
        return $result->result_array();
    }

    public function filteredCities($state_id){
        $result = $this->db->get_where('cities',['state_id'=>$state_id]);
        return $result->result_array();
    }

    public function doAddJob($image_url){
    	$data = array(
            'image_url' => $image_url,
            'company_name' => $this->security->xss_clean($this->input->post('company_name')),
            'country_id' => $this->security->xss_clean($this->input->post('country')),
            'state_id' => $this->security->xss_clean($this->input->post('state')),
            'city_id' => $this->security->xss_clean($this->input->post('city')),
            'location' => $this->security->xss_clean($this->input->post('location')),
            'role' => $this->security->xss_clean($this->input->post('role')),
            'employee_type_id' => $this->security->xss_clean($this->input->post('employee_type')),
            'industry_type_id' => $this->security->xss_clean($this->input->post('industry_type')),
            'salary' => $this->security->xss_clean($this->input->post('salary')),
            'experience_id' => $this->security->xss_clean($this->input->post('experience')),
            'description' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->insert('job', $data);

        $job_id = $this->db->insert_id();
        	foreach($this->input->post('qualification') as $job_qualification_id){
        		$this->db->insert('job_qualifications', ['job_id' => $job_id, 'qualification_id' => $job_qualification_id]);
        	}
        return $job_id;
    }

    public function get_company_name_validation($job_id) {
        $query = $this->db->get_where('job', ['job_id' => $job_id])->row()->company_name ;
        return $query;
    }

    public function doEditJob($job_id, $image_url){
        $data = array(
            'image_url' => $image_url,
            'company_name' => $this->security->xss_clean($this->input->post('company_name')),
            'country_id' => $this->security->xss_clean($this->input->post('country')),
            'state_id' => $this->security->xss_clean($this->input->post('state')),
            'city_id' => $this->security->xss_clean($this->input->post('city')),
            'location' => $this->security->xss_clean($this->input->post('location')),
            'experience_id' => $this->security->xss_clean($this->input->post('experience')),
            'role' => $this->security->xss_clean($this->input->post('role')),
            'employee_type_id' => $this->security->xss_clean($this->input->post('employee_type')),
            'industry_type_id' => $this->security->xss_clean($this->input->post('industry_type')),
            'salary' => $this->security->xss_clean($this->input->post('salary')),
            'description' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->update('job', $data, ['job_id' => $job_id]);
        $this->db->delete('job_qualifications', ['job_id' => $job_id]);
        foreach($this->input->post('qualification') as $job_qualification_id){
            $this->db->insert('job_qualifications', ['job_id' => $job_id, 'qualification_id' => $job_qualification_id]);
        }
        return $this->db->affected_rows();
    }

    public function do_delete_job($job_id){
        $this->db->delete('job_qualifications', ['job_id' => $job_id]);
        $this->db->delete('job', ['job_id' => $job_id]);
        return $this->db->affected_rows();
    }

    public function change_job_status($id, $status){
        $this->db->update('job', ['status' => $status], ['job_id' => $id]);
        return $this->db->affected_rows();
    }
}
?>