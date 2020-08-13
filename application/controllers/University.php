<?php 
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class University extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model(['admin_model','university_model']);
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
		$data['title'] = "University Management";
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['university'] = $this->university_model->getAllUniversities();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/university/university');
		$this->load->view('admin/commons/footer');
	}

	public function addUniversity($id=null){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		if(!empty($id)) {
        	$data['university'] = $this->university_model->getUniversityById($id);
        	$data['university_course'] = $this->university_model->getUniversityCourseById($id);
        	$data['count_university_course'] = count($data['university_course']);
        }
		$data['title'] = "University Management";
		$data['editor'] = '1';
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['course'] = $this->university_model->getAllCourses();
        $data['country'] = $this->university_model->getAllCountries();
        $data['states'] = $this->university_model->getAllStates();
        $data['cities'] = $this->university_model->getAllCities();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/university/add_university');
		$this->load->view('admin/commons/footer');
	}

	public function filteredStates() {
        $this->output->set_content_type('application/json');
        $country_id = $this->input->post('val');
        $result = $this->university_model->filteredStates($country_id);
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
        $result = $this->university_model->filteredCities($state_id);
        $list = [];
        foreach ($result as $type) {
            $list[$type['id']] = $type['name'];
        }
        $this->output->set_output(json_encode(['result' => 1, 'city' => $list]));
        return FALSE;
    }

    public function doDeleteUniversity($university_id){
		$this->output->set_content_type('application/json');
		$this->university_model->do_delete_university($university_id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'University deleted successfully.', 'url' => base_url('admin/university')]));
        return FALSE;
	}

	public function viewUniversityWrapper($university_id){
		$this->output->set_content_type('application/json');
		$data['admin'] = $admin = $this->getLoginDetail();
        $data['university'] = $this->university_model->getUniversityById($university_id);
        $data['university_images'] = $this->university_model->getUniversityImageById($university_id);
        // print_r($data['university_images']);die;
        $content_wrapper = $this->load->view('admin/university/viewuniversity_wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
	}

	public function doUploadUniversityImage1() {
        $config = array(
            'upload_path' => "./uploads/university/",
            'allowed_types' => "jpeg|jpg|png",
            'file_name' => rand(11111, 99999),
            'max_size' => "2048"
        );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image_url1')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url1' => $this->upload->display_errors()]);
            return 0;
        }
    }

    public function doUploadUniversityImage2() {
        $config = array(
            'upload_path' => "./uploads/university/",
            'allowed_types' => "jpeg|jpg|png",
            'file_name' => rand(11111, 99999),
            'max_size' => "2048"
        );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image_url2')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url2' => $this->upload->display_errors()]);
            return 0;
        }
    }

    public function doUploadUniversityVideo() {
        $config = array(
            'upload_path' => "./uploads/university/",
            'allowed_types' => "mp4|3gp|mov|wmv|webm",
            'file_name' => rand(11111, 99999),
            'max_size' => ""
        );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('image_url3')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url3' => $this->upload->display_errors()]);
            return 0;
        }
    }

	public function doAddUniversity(){
		$this->output->set_content_type('application/json');
		$err_chk = $this->input->post('err_chk');
        $this->form_validation->set_rules('university_name', 'University Name', 'trim|required|is_unique[university.university_name]');
    	$this->form_validation->set_rules('country', 'Country Name', 'trim|required');
    	$this->form_validation->set_rules('state', 'State Name', 'trim|required');
        $this->form_validation->set_rules('city', 'City Name', 'trim|required');
    	$this->form_validation->set_rules('accomodation', 'Accomodation', 'trim|required');
    	$this->form_validation->set_rules('description', 'Description', 'trim|required');
    	foreach($err_chk as $err_ck){
            if($err_ck != ""){
                $this->form_validation->set_rules('fee'.$err_ck, 'Fee', 'required|numeric');
                $this->form_validation->set_rules('course'.$err_ck, 'Course', 'required');
            }
        }
    	if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $image_url1 = $this->doUploadUniversityImage1();
        if (!$image_url1) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
            $this->session->unset_userdata('error');
            return FALSE;
        }
        $image_url2 = $this->doUploadUniversityImage2();
        if (!$image_url2) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
            $this->session->unset_userdata('error');
            return FALSE;
        }
        $image_url3 = $this->doUploadUniversityVideo();
        if (!$image_url3) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
            $this->session->unset_userdata('error');
            return FALSE;
        }
        $sr = 0;
        $result = $this->university_model->doAddUniversity($image_url1, $image_url2, $image_url3);
        $university_id = $result;
        if($university_id){
	        foreach($err_chk as $err_ck){
	            if($err_ck != ""){
	                $course = $this->security->xss_clean($this->input->post('course'.$err_ck));
	                $fee = $this->security->xss_clean($this->input->post('fee'.$err_ck));
	                $resultCourse = $this->university_model->do_add_university_course($university_id, $course, $fee);
	                if($resultCourse){
	                    $sr++;
	                }
	            }
	        }
	    }
        if ($sr) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'University Added Sucessfully', 'url' => base_url('admin/university')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'University Not Added']));
            return FALSE;
        }
	}

    public function doUpdateUniversity($university_id){
        $this->output->set_content_type('application/json');
        $err_chk = $this->input->post('err_chk');
        $this->form_validation->set_message('is_unique', 'This {field} field is already taken');
        $original_value = $this->university_model->get_university_name_validation($university_id);
        if ($this->input->post('university_name') != $original_value) {
            $is_unique = '|is_unique[university.university_name]';
        } else {
            $is_unique = '';
        }
        $this->form_validation->set_rules('university_name', 'University Name', 'trim|required' . $is_unique);
        $this->form_validation->set_rules('country', 'Country Name', 'trim|required');
        $this->form_validation->set_rules('state', 'state Name', 'trim|required');
        $this->form_validation->set_rules('accomodation', 'Accomodation', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        foreach($err_chk as $err_ck){
            if($err_ck != ""){
                $this->form_validation->set_rules('fee'.$err_ck, 'Fee', 'required|numeric');
                $this->form_validation->set_rules('course'.$err_ck, 'Course', 'required');
            }
        }
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $universityImageById = $this->university_model->getUniversityImageById($university_id);
        if(!empty($_FILES['image_url1']['name'])){
            $image_url1=$this->doUploadUniversityImage1('image_url1');
        }else{
            $image_url1=$universityImageById[0]['media'];
        }
        if(!empty($_FILES['image_url2']['name'])){
            $image_url2 = $this->doUploadUniversityImage2('image_url2');
        }else{
            if(!empty($universityImageById[1]['media'])){
                $image_url2=$universityImageById[1]['media']; 
            }else{
                $image_url2 = '';
            }
        }
        if(!empty($_FILES['image_url3']['name'])){
            $image_url3 = $this->doUploadUniversityVideo('image_url3');
        }else{
           if(!empty($universityImageById[2]['media'])){
                $image_url3=$universityImageById[2]['media']; 
            }else{
                $image_url3 = '';
            }
        }
        $sr = 0;
        $result = $this->university_model->doUpdateUniversity($university_id, $image_url1, $image_url2, $image_url3);
        $deleteCourse = $this->university_model->do_delete_university_course($university_id);
        foreach($err_chk as $err_ck){
            if($err_ck != ""){
                $course = $this->security->xss_clean($this->input->post('course'.$err_ck));
                $fee = $this->security->xss_clean($this->input->post('fee'.$err_ck));
                $resultCourse = $this->university_model->do_add_university_course($university_id, $course, $fee);
                if($resultCourse){
                    $sr++;
                }
            }
        }
        if ($sr) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'University Updated Sucessfully', 'url' => base_url('admin/university')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'University Not Updated']));
            return FALSE;
        }
    }
}
?>