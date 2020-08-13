<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Admin controller.
	 * Created By Rajat Agarwal
	 
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('admin_model');
	}

	public function index(){
		if(!empty($this->is_login())){
			redirect(base_url('admin/dashboard'));
		}
		$data['title'] = "Login Page";
		$this->load->view('admin/login', $data);
	}

	//Do Admin Login 
	public function doLogin(){
		$this->output->set_content_type('application/json');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() === FALSE) {
			$this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
			return FALSE;
		}
		$result = $this->admin_model->checkLogin();
		if ($result) {
			$this->session->set_userdata('email', $result['email']);
			$this->output->set_output(json_encode(['result' => 1, 'url' => base_url("admin/dashboard"), 'msg' => 'Signup Successfully!!!']));
			return FALSE;
		} else {
			$this->output->set_output(json_encode(['result' => -1, 'msg' => 'Invalid Username or Password']));
			return FALSE;
		}
	}

	//Forgot Password View
	public function forgot_password(){
		$data['title'] = "Forgot Password";
		$this->load->view('admin/forgot-password', $data);
	}

	//Checking email of admin to reset the password
    public function doForgotPassword(){
        $this->output->set_content_type('application/json');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() === FALSE) {
			$this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
			return FALSE;
		}
		$result = $this->admin_model->getEmailId();
		if ($result) {
			$password = substr(md5(uniqid()), 0, 6);
			$updatePassword = $this->admin_model->updatePassword($password);
			$this->send_forgot_password_link($password, $result['name'], $result['email']);
			$this->output->set_output(json_encode(['result' => 1, 'url' => base_url("admin"), 'msg' => 'New Password has been sent to your E-mail ID..']));
			return FALSE;
		} else {
			$this->output->set_output(json_encode(['result' => -1, 'msg' => 'This E-mail id does not exist']));
			return FALSE;
		}
    }

    //Sending Forgot Password Link
    private function send_forgot_password_link($password, $name, $email) {
        $config = array(
            'mailtype' => 'html',
        );
        $this->load->library('email',$config);
        $htmlContent = "<div>Hi " . $name . ",</div>";
        $htmlContent .= "<div style='padding-top:8px;'>your password is ".$password."</div>";
        $this->email->to($email);
        $this->email->from('info@admin.com', 'Admin');
        $this->email->subject('Hey!, ' . $name . ' Forgot Password');
        $this->email->message($htmlContent);
        $this->email->send();
        return true;
    }

    private function is_login(){
		return $this->session->userdata('email');
	}

	//Admin Details
	private function getLoginDetail(){
		$email = $this->session->userdata('email');
		return $this->admin_model->getLoginDetail($email);
	}

	//Admin Dashboard View
	public function dashboard(){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		$data['title'] = "Dashboard";
		$data['admin'] = $this->getLoginDetail();
		$data['users'] = $this->admin_model->getUsersCount();
        $data['users_interest'] = $this->admin_model->getUsersInterestCount();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/index');
		$this->load->view('admin/commons/footer');
	}

    //Change password View
	public function change_password(){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		$data['title'] = "Change Password";
		$data['admin'] = $this->getLoginDetail();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/change_password');
		$this->load->view('admin/commons/footer');
	}

	//admin Change Password
	public function doChangePass(){
		$this->output->set_content_type('application/json');
		$this->form_validation->set_rules('opass', 'Old Password', 'required');
		if ($this->form_validation->run() === FALSE) {
			$this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
			return FALSE;
		}
		$this->form_validation->set_rules('npass', 'New Password', 'required|min_length[6]');
		$this->form_validation->set_rules('cpass', 'Confirm Password', 'required|min_length[6]|matches[npass]');
		$userData = $this->getLoginDetail();
		if($userData['password'] != $this->security->xss_clean(hash('sha256', $this->input->post('opass')))){
			$err['opass'] = 'Old Password is incorrect';
			$this->output->set_output(json_encode(['result' => 0, 'errors' => $err]));
			return FALSE;
		}
		if ($this->form_validation->run() === FALSE) {
			$this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
			return FALSE;
		}
		$result = $this->admin_model->doChangePass();
		if ($result) {
			$this->output->set_output(json_encode(['result' => 1, 'url' => base_url("admin/dashboard"), 'msg' => 'Password Changed Successfully..']));
			return FALSE;
		} else {
			$this->output->set_output(json_encode(['result' => -1, 'msg' => 'Old Password and new password should not be same']));
			return FALSE;
		}
	}

	//admin profile View
	public function profile(){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		$data['title'] = "Admin Profile";
		$data['editor'] = "1";
        $data['admin'] = $admin = $this->getLoginDetail();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/profile');
		$this->load->view('admin/commons/footer');
	}

	//To upload the profile image of admin
	public function doUploadProfileImage() {
        $config = array(
            'upload_path' => "./uploads/profile-images/",
            'allowed_types' => "jpeg|jpg|png",
            'file_name' => rand(11111, 99999),
            'max_size' => "2048"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image_url')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url' => $this->upload->display_errors()]);
            return 0;
        }
    }

    //To upload the banner image
	public function doUploadBannerImage() {
        $config = array(
            'upload_path' => "./uploads/banner/",
            'allowed_types' => "jpeg|jpg|png",
            'file_name' => rand(11111, 99999),
            'max_size' => "2048"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image_url')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url' => $this->upload->display_errors()]);
            return 0;
        }
    }

    //To upload the walkthrough image
	public function doUploadWalkthroughImage() {
        $config = array(
            'upload_path' => "./uploads/walkthrough/",
            'allowed_types' => "jpeg|jpg|png",
            'file_name' => rand(11111, 99999),
            'max_size' => "2048"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image_url')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            $this->session->set_userdata('error', ['image_url' => $this->upload->display_errors()]);
            return 0;
        }
    }

    //To update the admin profile
    public function doUpdateProfile() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('name', 'Admin Name', 'required');
        $this->form_validation->set_rules('phone', 'Admin Phone Number', 'required|numeric|max_length[15]');
        $this->form_validation->set_rules('description', 'Admin Description', 'required');
        $this->form_validation->set_rules('address', 'Admin Address', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $email = $this->session->userdata('email');
        if (!empty($_FILES['image_url']['name'])) {
            $image_url = $this->doUploadProfileImage();
            if (!$image_url) {
                $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
                $this->session->unset_userdata('error');
                return FALSE;
            }
        } else {
            $admin = $this->admin_model->getLoginDetail($email);
            $image_url = $admin['image_url'];
        }
        $result = $this->admin_model->doUpdateProfile($email, $image_url);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Admin Profile Updated Succesfully!!!','url' => base_url('admin/dashboard')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No changes were made.']));
            return FALSE;
        }
    }

    //Setting View
    public function settings(){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		$data['title'] = "Site Settings";
		$data['editor'] = 1;
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['settings'] = $settings = $this->admin_model->getAllSiteSettings();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/settings/settings');
		$this->load->view('admin/commons/footer');
	}

	//Settings Wrapper View
	public function settingWrapper($setting_id){
		$this->output->set_content_type('application/json');
		$data['editor'] = 1;
		$data['admin'] = $admin = $this->getLoginDetail();
        $data['settings'] = $this->admin_model->getSettingsById($setting_id);
        $content_wrapper = $this->load->view('admin/settings/setting-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
	}

	//to update the site settings 
	public function doUpdateSettings($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->admin_model->doUpdateSettings($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => $result['title'].' '.'Updated Succesfully!!!','url' => base_url('admin/settings')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No changes were made.']));
            return FALSE;
        }
    }

    //FAQ View
    public function faq(){
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		$data['title'] = "FAQ's";
		$data['editor'] = 1;
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['faq'] = $this->admin_model->getAllFaqs();
		$this->load->view('admin/commons/header', $data);
		$this->load->view('admin/commons/sidebar');
		$this->load->view('admin/faq/faq');
		$this->load->view('admin/commons/footer');
	}

	//Wrapper FAQ View
	public function faqWrapper($faq_id = null){
		$this->output->set_content_type('application/json');
		$data['editor'] = 1;
		$data['admin'] = $admin = $this->getLoginDetail();
		if(!empty($faq_id)) {
        	$data['faq'] = $this->admin_model->getFaqById($faq_id);
        }
        $content_wrapper = $this->load->view('admin/faq/faq-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
	}

	//to add the faq
	public function doAddFaq() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('description', 'Answer', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->admin_model->doAddFaq();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'FAQ Added Succesfully!!','url' => base_url('admin/faq')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'FAQ Not Added!!']));
            return FALSE;
        }
    }

    //to update the faq
    public function doUpdateFaq($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('description', 'Answer', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->admin_model->doUpdateFaq($id);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'FAQ Updated Succesfully!!','url' => base_url('admin/faq')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No changes were made.!!']));
            return FALSE;
        }
    }

    public function banner() {
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
        $data['table'] = '1';
        $data['title'] = 'Banner';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/banner/banner');
        $this->load->view('admin/commons/footer');
    }

    public function get_banner_wrapper() {
        $this->output->set_content_type('application/json');
        $data['banner'] = $this->admin_model->getAllBanners();
        $content_wrapper = $this->load->view('admin/banner/banner-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_banner() {
        $this->output->set_content_type('application/json');
        $image_url = $this->doUploadBannerImage();
        if (!$image_url) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
            $this->session->unset_userdata('error');
            return FALSE;
        }
        $result = $this->admin_model->do_add_banner($image_url);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Banner Added Sucessfully', 'url' => base_url('admin/banner')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Banner Not Added']));
            return FALSE;
        }
    }

    public function doDeleteBanner($banner_id){
    	$this->output->set_content_type('application/json');
    	$this->admin_model->do_delete_banner($banner_id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Banner deleted successfully.', 'url' => base_url('admin/banner')]));
        return FALSE;
    }

    public function walkthrough($id = null) {
		if(empty($this->is_login())){
			redirect(base_url('admin'));
		}
		if (!empty($id)) {
            $data['walkthrough'] = $this->admin_model->get_walkthrough_by_id($id);
        }
        $data['table'] = '1';
        $data['editor'] = "1";
        $data['title'] = 'Walkthrough';
        $data['admin'] = $admin = $this->getLoginDetail();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar', $data);
        $this->load->view('admin/walkthrough/walkthrough');
        $this->load->view('admin/commons/footer');
    }

    public function get_walkthrough_wrapper() {
        $this->output->set_content_type('application/json');
        $data['walkthrough'] = $this->admin_model->getAllWalkthroughs();
        $content_wrapper = $this->load->view('admin/walkthrough/walkthrough-wrapper', $data, true);
        $this->output->set_output(json_encode(['result' => 1, 'content_wrapper' => $content_wrapper]));
        return FALSE;
    }

    public function do_add_walkthrough() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Text', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $image_url = $this->doUploadWalkthroughImage();
        if (!$image_url) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
            $this->session->unset_userdata('error');
            return FALSE;
        }
        $result = $this->admin_model->do_add_walkthrough($image_url);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Walkthrough Added Sucessfully', 'url' => base_url('admin/walkthrough')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Walkthrough Not Added']));
            return FALSE;
        }
    }

    public function do_edit_walkthrough($id) {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('description', 'Text', 'trim|required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        if (!empty($_FILES['image_url']['name'])) {
            $image_url = $this->doUploadWalkthroughImage();
            if (!$image_url) {
                $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->session->userdata('error')]));
                $this->session->unset_userdata('error');
                return FALSE;
            }
        } else {
            $walkthrough_image = $this->admin_model->get_walkthrough_by_id($id);
            $image_url = $walkthrough_image['image_url'];
        }
        $result = $this->admin_model->do_edit_walkthrough($id,$image_url);
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Walkthrough Updated Successfully!', 'url' => base_url('admin/walkthrough')]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Changes Were Made.', 'url' => base_url('admin/walkthrough')]));
            return FALSE;
        }
    }

    public function libraryListing(){
        if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        $data['title'] = "Library Management";
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['users'] = $this->admin_model->getAllUsersLibrary();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar');
        $this->load->view('admin/library/library');
        $this->load->view('admin/commons/footer');
    }

    public function viewLibrary($job_apply_id){
        if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        $data['title'] = "Library Management";
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['view_job_library'] = $this->admin_model->getJobApplyData($job_apply_id);
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar');
        $this->load->view('admin/library/view-library', $data);
        $this->load->view('admin/commons/footer');
    }

    public function accountListing(){
        if(empty($this->is_login())){
            redirect(base_url('admin'));
        }
        $data['title'] = "Account Management";
        $data['admin'] = $admin = $this->getLoginDetail();
        $data['users'] = $this->admin_model->getAllUsers();
        $this->load->view('admin/commons/header', $data);
        $this->load->view('admin/commons/sidebar');
        $this->load->view('admin/account/account');
        $this->load->view('admin/commons/footer');
    }

    public function change_account_status($id, $status) {
        $this->output->set_content_type('application/json');
        $this->admin_model->change_account_status($id, $status);
        $user = $this->admin_model->get_user_by_id($id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'User "'. $user['name'].'" payment  status changes to '.$user['payment_status'].'.']));
        return FALSE;
    }

    //to logout from the admin panel
	public function logout() {
		$this->output->set_content_type('application/json');
		$this->session->unset_userdata('email');
		$this->output->set_output(json_encode(['result' => 1, 'url' => base_url('admin')]));
		return FALSE;
	}
}