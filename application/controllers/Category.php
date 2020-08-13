<?php 
defined('BASEPATH') or exit ('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Category extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(['admin_model','category_model']);
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
            $data['category'] = $this->category_model->get_category_by_id($id);
        }
        $data['table'] = '1';
        $data['title'] = 'Category Management';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/category/category');
        $this->load->view('admin/commons/footer');
    }

    public function get_category_wrapper() {
        $this->output->set_content_type('application/json');
        $data['category'] = $this->category_model->getAllCategory();
        $content_wrapper = $this->load->view('admin/category/category-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_category() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|regex_match[/^[A-Z a-z 0-9]+$/]|is_unique[job_category.category_name]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->category_model->do_add_category();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Category Added Sucessfully', 'url' => base_url('admin/category')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Category Not Added']));
            return FALSE;
        }
    }

    public function do_edit_category($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->category_model->get_category_validation($id);
        if ($this->input->post('category_name') != $original_value) {
            $is_unique = '|is_unique[category.category_name]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|regex_match[/^[A-Z a-z 0-9]+$/]' . $is_unique);
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->category_model->do_edit_category($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Category Updated Successfully!', 'url' => base_url('admin/category')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/category')]));
            return FALSE;
        }
    }

    public function change_category_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->category_model->change_category_status($id, $status);
        $cat = $this->category_model->get_category_by_id($id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Category "'. $cat['category_name'].'" status changes to '.$cat['status'].'.']));
        return FALSE;
    }

    public function course($id = NULL) {
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
        if (!empty($id)) {
            $data['course'] = $this->category_model->get_course_by_id($id);
        }
        $data['table'] = '1';
        $data['title'] = 'Course Management';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/course/course');
        $this->load->view('admin/commons/footer');
    }

    public function get_course_wrapper() {
        $this->output->set_content_type('application/json');
        $data['course'] = $this->category_model->getAllCourses();
        $content_wrapper = $this->load->view('admin/course/course-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_course() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required|is_unique[courses.course_name]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->category_model->do_add_course();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Course Added Sucessfully', 'url' => base_url('admin/course')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Course Not Added']));
            return FALSE;
        }
    }

    public function do_edit_course($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->category_model->get_course_validation($id);
        if ($this->input->post('course_name') != $original_value) {
            $is_unique = '|is_unique[courses.course_name]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required' . $is_unique);
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->category_model->do_edit_course($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Course Updated Successfully!', 'url' => base_url('admin/course')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/course')]));
            return FALSE;
        }
    }

    public function change_course_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->category_model->change_course_status($id, $status);
        $course = $this->category_model->get_course_by_id($id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Course "'. $course['course_name'].'" status changes to '.$course['status'].'.']));
        return FALSE;
    }
}
?>