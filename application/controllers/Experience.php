<?php 
defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Experience extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(['admin_model' ,'experience_model']);
	}

	private function is_login(){
		return $this->session->userdata('email');
	}

	private function getLoginDetail(){
		$email = $this->session->userdata('email');
		return $this->admin_model->getLoginDetail($email);
	}

	public function index($id = NULL) {
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
        if (!empty($id)) {
            $data['experience'] = $this->experience_model->get_experience_by_id($id);
        }
        $data['table'] = '1';
        $data['title'] = 'Experience Management';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/experience/experience');
        $this->load->view('admin/commons/footer');
    }

    public function get_experience_wrapper() {
        $this->output->set_content_type('application/json');
        $data['experience'] = $this->experience_model->getAllExperience();
        $content_wrapper = $this->load->view('admin/experience/experience-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_experience() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $this->form_validation->set_rules('experience', 'Experience', 'trim|required|is_unique[experience.experience]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_add_experience();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Experience Added Sucessfully', 'url' => base_url('admin/experience')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Experience Not Added']));
            return FALSE;
        }
    }

    public function do_edit_experience($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->experience_model->get_experience_validation($id);
        if ($this->input->post('experience') != $original_value) {
            $is_unique = '|is_unique[experience.experience]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('experience', 'Experience', 'trim|required' . $is_unique);
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_edit_experience($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Experience Updated Successfully!', 'url' => base_url('admin/experience')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/experience')]));
            return FALSE;
        }
    }

    public function change_experience_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->experience_model->change_experience_status($id, $status);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Status Changed Successfully.']));
        return FALSE;
    }
    // study category
    public function study($id = NULL){
       if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        if (!empty($id)) {
            $data['study'] = $this->experience_model->get_study_by_id($id);
        }
        $data['table'] = '1';
        $data['title'] = 'Study Type Management';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/study-type/study-type');
        $this->load->view('admin/commons/footer'); 
        
    }
    
    public function get_study_wrapper(){
        $this->output->set_content_type('application/json');
        $data['study'] = $this->experience_model->getAllstudycategory();
        $content_wrapper = $this->load->view('admin/study-type/study-type-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }
    
    public function do_add_study() {
        $this->output->set_content_type('application/json');
//        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $this->form_validation->set_rules('study_type', 'Study Type', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_add_study();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Study Type Added Sucessfully', 'url' => base_url('admin/study')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Study Type Not Added']));
            return FALSE;
        }
    }
    
    public function do_edit_study($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->experience_model->get_study_type_validation($id);
        if ($this->input->post('study_type') != $original_value) {
            $is_unique = '|is_unique[study_categories.name]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('study_type', 'Study Type', 'trim|required' . $is_unique);
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_edit_study($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Study Type Updated Successfully!', 'url' => base_url('admin/study')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/study')]));
            return FALSE;
        }
    }
    
    public function change_study_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->experience_model->change_study_status($id, $status);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Status Changed Successfully.']));
        return FALSE;
    }
    
    // study category
    public function industry($id = NULL) {
        if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        if (!empty($id)) {
            $data['industry'] = $this->experience_model->get_industry_by_id($id);
        }
        $data['table'] = '1';
        $data['title'] = 'Industry Type Management';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/industry-type/industry-type');
        $this->load->view('admin/commons/footer');
    }

    public function get_industry_wrapper() {
        $this->output->set_content_type('application/json');
        $data['industry'] = $this->experience_model->getAllIndustry();
        $content_wrapper = $this->load->view('admin/industry-type/industry-type-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_industry() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $this->form_validation->set_rules('industry_type', 'Industry Type', 'trim|required|is_unique[industry_type.industry_type]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_add_industry_type();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Industry Type Added Sucessfully', 'url' => base_url('admin/industry')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Industry Type Not Added']));
            return FALSE;
        }
    }

    public function do_edit_industry($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->experience_model->get_industry_type_validation($id);
        if ($this->input->post('industry_type') != $original_value) {
            $is_unique = '|is_unique[industry_type.industry_type]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('industry_type', 'Industry Type', 'trim|required' . $is_unique);
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_edit_industry_type($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Industry Type Updated Successfully!', 'url' => base_url('admin/industry')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/industry')]));
            return FALSE;
        }
    }

    public function change_industry_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->experience_model->change_industry_status($id, $status);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Status Changed Successfully.']));
        return FALSE;
    }

    public function employee($id = NULL) {
        if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        if (!empty($id)) {
            $data['employee'] = $this->experience_model->get_employee_by_id($id);
        }
        $data['table'] = '1';
        $data['title'] = 'Employee Type Management';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/employee-type/employee-type');
        $this->load->view('admin/commons/footer');
    }

    public function get_employee_wrapper() {
        $this->output->set_content_type('application/json');
        $data['employee'] = $this->experience_model->getAllEmployee();
        $content_wrapper = $this->load->view('admin/employee-type/employee-type-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_employee() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'trim|required|is_unique[employee_type.employee_type]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_add_employee_type();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Employee Type Added Sucessfully', 'url' => base_url('admin/employee')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Employee Type Not Added']));
            return FALSE;
        }
    }

    public function do_edit_employee($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->experience_model->get_employee_type_validation($id);
        if ($this->input->post('employee_type') != $original_value) {
            $is_unique = '|is_unique[employee_type.employee_type]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('employee_type', 'Employee Type', 'trim|required' . $is_unique);
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->experience_model->do_edit_employee_type($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Employee Type Updated Successfully!', 'url' => base_url('admin/employee')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/employee')]));
            return FALSE;
        }
    }

    public function change_employee_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->experience_model->change_employee_status($id, $status);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Status Changed Successfully.']));
        return FALSE;
    }
}
?>