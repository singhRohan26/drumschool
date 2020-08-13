<?php 
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Job extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(['admin_model','job_model']);
	}

	private function is_login(){
		return $this->session->userdata('email');
	}

	private function getLoginDetail(){
		$email = $this->session->userdata('email');
		return $this->admin_model->getLoginDetail($email);
	}

	public function index(){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		$data['title'] = "Job Management";
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['job'] = $this->job_model->getAllJobs();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/job/job');
		$this->load->view('admin/commons/footer');
	}

	public function addJob($id=null){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		if(!empty($id)) {
        	$data['job'] = $this->job_model->getJobById($id);
        	$data['job_qualification'] = $this->job_model->getJobQualificationsByJobId($id);
        }
		$data['title'] = "Job Management";
		$data['editor'] = '1';
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['country'] = $this->job_model->getAllCountries();
        $data['states'] = $this->job_model->getAllStates();
        $data['cities'] = $this->job_model->getAllCities();
        $data['qualification'] = $this->job_model->getAllQualifications();
        $data['employee_type'] = $this->job_model->getAllEmployeeTypes();
        $data['industry_type'] = $this->job_model->getAllIndustryTypes();
        $data['experience'] = $this->job_model->getAllExperiences();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/job/add_job');
		$this->load->view('admin/commons/footer');
	}

	public function viewJobWrapper($job_id){
		$this->output->set_content_type('application/json');
		$data['admin'] = $admin = $this->getLoginDetail();
        $data['job'] = $this->job_model->getJobById($job_id);
        $data['job_qualification'] = $this->job_model->getJobQualificationsByJobId($job_id);
        $content_wrapper = $this->load->view('admin/job/viewjob_wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
	}

	public function filteredStates() {
        $this->output->set_content_type('application/json');
        $country_id = $this->input->post('val');
        $result = $this->job_model->filteredStates($country_id);
        $list = [];
        foreach ($result as $type) {
            $list[$type['id']] = $type['name'];
        }
        $this->output->set_output(json_encode(['result' => 1, 'state' => $list]));
        return FALSE;
    }

    public function filteredCities() {
        $this->output->set_content_type('application/json');
        $state_id = $this->input->post('val');
        $result = $this->job_model->filteredCities($state_id);
        $list = [];
        foreach ($result as $type) {
            $list[$type['id']] = $type['name'];
        }
        $this->output->set_output(json_encode(['result' => 1, 'city' => $list]));
        return FALSE;
    }

    //To upload the Company Logo
    public function doUploadCompanyLogo() {
        $config = array(
            'upload_path' => "./uploads/company-logo/",
            'allowed_types' => "jpeg|jpg|png",
            'file_name' => rand(11111, 99999),
            'max_size' => "2048"
        );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image_url')){
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url' => $this->upload->display_errors()]);
            return 0;
        }
    }

    public function doAddJob(){
    	$this->output->set_content_type('application/json');
    	$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|is_unique[job.company_name]');
    	$this->form_validation->set_rules('country', 'Country Name', 'trim|required');
    	$this->form_validation->set_rules('state', 'State Name', 'trim|required');
        $this->form_validation->set_rules('city', 'City Name', 'trim|required');
        $this->form_validation->set_rules('location', 'Job Location', 'trim|required');
    	$this->form_validation->set_rules('role', 'Role', 'trim|required');
    	$this->form_validation->set_rules('employee_type', 'Employee Type', 'trim|required');
    	$this->form_validation->set_rules('industry_type', 'Industry Type', 'trim|required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|numeric');
        $this->form_validation->set_rules('experience', 'Experience', 'trim|required');
    	if(empty($this->input->post('qualification'))){
			$this->form_validation->set_rules('qualification', 'Job qualification', 'trim|required');
    	}
    	$this->form_validation->set_rules('description', 'Job Description', 'trim|required');
    	if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $image_url = $this->doUploadCompanyLogo();
        // echo $image_url;die;
        if (!$image_url) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
            $this->session->unset_userdata('error');
            return FALSE;
        }
        $result = $this->job_model->doAddJob($image_url);
        if($result){
        	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Job Added Succesfully!!!','url' => base_url('admin/job')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Job Not Added.']));
            return FALSE;
        }
    }

    public function doEditJob($job_id){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->job_model->get_company_name_validation($job_id);
        if ($this->input->post('company_name') != $original_value) {
            $is_unique = '|is_unique[job.company_name]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required' . $is_unique);
        $this->form_validation->set_rules('country', 'Country Name', 'trim|required');
        $this->form_validation->set_rules('state', 'state Name', 'trim|required');
        $this->form_validation->set_rules('city', 'City Name', 'trim|required');
        $this->form_validation->set_rules('location', 'Job Location', 'trim|required');
        $this->form_validation->set_rules('experience', 'Experience', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'trim|required');
        $this->form_validation->set_rules('industry_type', 'Industry Type', 'trim|required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim|numeric');
        if(empty($this->input->post('qualification'))){
            $this->form_validation->set_rules('qualification', 'Job Qualification', 'trim|required');
        }
        $this->form_validation->set_rules('description', 'Job Description', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        if (!empty($_FILES['image_url']['name'])) {
            $image_url = $this->doUploadCompanyLogo();
            if (!$image_url) {
                $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
                $this->session->unset_userdata('error');
                return FALSE;
            }
        } else {
            $company_logo = $this->job_model->getJobById($job_id);
            $image_url = $company_logo['image_url'];
        }
        $result = $this->job_model->doEditJob($job_id, $image_url);
        if($result){
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Job Updated Succesfully!!!','url' => base_url('admin/job')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Changes were made.']));
            return FALSE;
        }
    }

    public function doDeleteJob($job_id){
		$this->output->set_content_type('application/json');
		$this->job_model->do_delete_job($job_id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Job deleted successfully.', 'url' => base_url('admin/job')]));
        return FALSE;
	}

    public function change_job_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->job_model->change_job_status($id, $status);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Job Status Changes Succesfully.']));
        return FALSE;
    }

    public function jobRequest(){
        if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        $data['title'] = "Job Request Management";
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['jobrequest'] = $this->job_model->getAllJobRequests();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar');
        $this->load->view('admin/job/job-request');
        $this->load->view('admin/commons/footer');
    }
}
?>