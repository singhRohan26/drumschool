<?php 
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Api extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Api_model');
	}

	/*Unique Id Starts*/
	public function uniqueId() {
		$str = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNIPQRSTUVWXYZ';
		$nstr = str_shuffle($str);
		$unique_id = substr($nstr, 0, 10);
		return $unique_id;
	}
	/*Unique Id Ends*/

	/*Send Mail Function Starts*/
	public function send($to, $htmlContent){
	    $url = 'https://api.sendgrid.com/';
        $user = 'rajatdesignoweb';
        $pass = 'Rajat123@.';

 
        $params = array(
            'api_user' => $user,
            'api_key' => $pass,
            'to' => $to,
            'subject' => '[Drumschool] Please Verify your Email Address.',
            'html' => $htmlContent,
            'text' => $htmlContent,
            'from' => 'info@drumschool.com',
        );

        $request = $url.'api/mail.send.json';
    
        // Generate curl request
        $session = curl_init($request);
    
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
    
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
    
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
    }
	/*Send Mail Ends*/
	
	/*Registration Start*/
	public function registration(){
		$this->output->set_content_type('application/json');
		$user_id = $this->input->post('user_id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
        $country_id = $this->input->post('country_id');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
		$password = $this->security->xss_clean(hash('sha256', $this->input->post('password')));
		$confirm_password = $this->security->xss_clean(hash('sha256', $this->input->post('confirm_password')));
		$unique_id = $this->uniqueId();

		if(!empty($user_id)){
			$data['result'] = $resendMail = $this->Api_model->resendMail($user_id, $unique_id);
			if($resendMail){
				$to = $resendMail['email'];
	            $htmlContent = $this->load->view('admin/signup_mail', $data, TRUE);
	            $mail = $this->send($to, $htmlContent);
				$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Activation Link has been sent to your E-mail Id.' ,'data' => $resendMail]));
				return false;
			}
		}else{
			$checkmail = $this->Api_model->checkmail($email);
			if($checkmail){
				$this->output->set_output(json_encode(['result' => -1, 'msg' => 'Email already exists.' ,'data' => 'Email already exists.']));
				return false;
			}else{
				if($password == $confirm_password){
					$data['result'] = $result = $this->Api_model->signUp($name, $email, $phone, $country_id, $state_id, $city_id, $password, $unique_id);
					if($result){
						$to = $result['email'];
			            $htmlContent = $this->load->view('admin/signup_mail', $data, TRUE);
			            $mail = $this->send($to, $htmlContent);
						$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Registration Successful and an Activation Link has been sent to your E-mail Id.' ,'data' => $result]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => 0, 'msg' => 'Registration Failed' ,'data' => 'Registration Failed']));
						return false;
					}
				}else{
					$this->output->set_output(json_encode(['result' => -2, 'msg' => 'Password and Confirm Password did not match.' ,'data' => 'Password and Confirm Password did not match.']));
					return false;
				}
			}
		}
	}
	/*Registration Ends*/

	/*User Email Verification Starts*/
	public function verifyEmail($unique_id){
		$this->output->set_content_type('application/json');
        $user_data = $this->Api_model->getDataByUniqueId($unique_id);
        if ($user_data['status'] == 'Inactive') {
            $result = $this->Api_model->verifyEmail($unique_id);
            if($result){
            	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Account Activated.' ,'data' => 'Account Activated.']));
				return false;
            }else{
            	$this->output->set_output(json_encode(['result' => -1, 'msg' => 'Account Not Activated.' ,'data' => 'Account Not Activated.']));
				return false;
            }
        }else{
        	$this->output->set_output(json_encode(['result' => 0, 'msg' => 'Your Account is already Activated.' ,'data' => 'Your Account is already Activated.']));
			return false;
        }
    }
	/*User Email Verification Ends*/

	/*Login Starts*/
	public function login(){
		$this->output->set_content_type('application/json');
		$email = $this->input->post('email');
		$password = $this->security->xss_clean(hash('sha256', $this->input->post('password')));

		$checkmail = $this->Api_model->checkmail($email);
		if($checkmail){
			if(!empty($password)){
				$password = $this->Api_model->checkpass($email, $password);
				if($password){
					if($password['status'] == 'Active'){
						$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Login successful' ,'data' => $password]));
						return false;
					}else{
						$this->output->set_output(json_encode(['result' => -2, 'msg' => 'Your Account is Inactive.' ,'data' => 'Your Account is Inactive.']));
						return false;
					}
				}else{
					$this->output->set_output(json_encode(['result' => -1, 'msg' => 'Email or Password is Invalid.' ,'data' => 'Email or Password is Invalid.']));
					return false;
				}
			}else{
				$this->output->set_output(json_encode(['result' => 2, 'msg' => 'Email checked' ,'data' => 'Email checked']));
			}
		}else{
			$this->output->set_output(json_encode(['result' => -3, 'msg' => 'Email Id does not exist.' ,'data' => 'Email Id does not exist.']));
			return false;
		}
	}
	/*Login Ends*/

	/*Change Password Starts*/
	public function changePassword(){
        $this->output->set_content_type('application/json');
        $user_id = $this->input->post('user_id');
        $old_pass = $this->input->post('old_password');
        $new_pass  = $this->input->post('new_password');
        $c_pass  = $this->input->post('confirm_password');

        $checkold = $this->Api_model->checkold($old_pass, $user_id);
        if($checkold){
            if($old_pass == $new_pass){
                $this->output->set_output(json_encode(['result' => -2, 'msg' =>'New and Old Password should not be same.' , 'data' => 'New and Old Password should not be same.']));
            }else{
                if($new_pass == $c_pass){
                    $result = $this->Api_model->changePass($user_id, $old_pass, $new_pass);
                    if($result){
                        $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Password changes successfully' , 'data' => 'Password changes successfully']));
                    }else{
                        $this->output->set_output(json_encode(['result' => -1, 'msg' =>'Update Failed' , 'data' => 'Update Failed']));
                    }
                }else{
                    $this->output->set_output(json_encode(['result' => 0, 'msg' =>'New and Confirm password did not match.' , 'data' => 'New and Confirm password did not match.']));
                }
            }  
        }else{
            $this->output->set_output(json_encode(['result' => -3, 'msg' =>'Old password is Incorrect.' , 'data' => 'Old password is Incorrect.']));
        }
    }
	/*Change Password Ends*/

	/*Forgot Password Starts*/
	public function forgotPassword(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('email', 'E-mail ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->verify_emailid();

        if (!empty($result)) {
            $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $activationcode = substr(str_shuffle($str), 0, 10);
            $this->send_forgot_password_link($result, $activationcode);
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Reset Password Link has been Sent to Your E-mail Id.Please Check your E-mail.', 'data' => $result]));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'This email id does not exist!', 'data' => 'This email id does not exist!']));
            return FALSE;
        }
    }

    public function send_forgot_password_link($result, $activationcode) {
        $config = array(
            'mailtype' => 'html',
        );
        $this->load->library('email',$config);
        $getEmailResponse = $this->Api_model->insert_user_activationcode($activationcode, $result);

        $htmlContent = "<h3>Dear " . $result['name'] . ",</h3>";
        $htmlContent .= "<div style='padding-top:8px;'>Please click The following link For Update your password..</div>";
        $htmlContent .= base_url('user/password-reset/' . $result['user_id'] . '/' . $activationcode) . " Click Here!! Set new password!";

        $this->email->to($result['email']);
        $this->email->from('info@drumschool.com', 'Drumschool');
        $this->email->subject('Hey!, ' . $result['name'] . ' your reset password link');
        $this->email->message($htmlContent);
        $this->email->send();
        return true;
    }

    public function password_reset($user_id, $activationcode) {
        $data['user_id'] = $user_id;
        $checkResponse = $this->Api_model->update_user_email_status($user_id, $activationcode);
        $data['title'] = "Drumschool| Reset Password";
        if ($checkResponse) {
            $this->load->view('user_reset_password', $data);
        } else {
            echo "This is the Wrong or Expired Activation Code";
        }
    }

    public function update_forgot_password() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[new_password]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->doChangeForgotPassword();
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'url' => base_url('/'), 'msg' => 'Password changes sucessfully.']));
            return FALSE;
        } else {
            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'Password is not correct']));
            return FALSE;
        }
    }
	/*Forgot Password Ends*/

	/*Static Pages Starts*/
	public function getPages(){
        $this->output->set_content_type('application/json');
        $page_id = $this->input->post('page');
        $result = $this->Api_model->getPages($page_id);
        $result['description'] = html_entity_decode(strip_tags($result['description']));
        if ($result) {
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found.', 'data' => $result]));
        } else {
            $this->output->set_output(json_encode(['result' => 0, 'msg' => 'No Data Found.', 'data' => 'No Data Found.']));
            return FALSE;
        }
    }
	/*Static Pages Ends*/

	/*FAQ Starts*/
	public function getFaqs(){
        $this->output->set_content_type('application/json');
        $result = $this->Api_model->getAllFaqs();
        if ($result) {
        	$i=0;
	        foreach($result as $results){
	        	$result[$i]['answer'] = html_entity_decode(strip_tags($results['answer']));
	        	$i++;
	        }
        	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found.', 'data' => $result]));
        } else {
            $this->output->set_output(json_encode(['result' => 0, 'msg' => 'No Data Found.', 'data' => 'No Data Found.']));
            return FALSE;
        }
    }
	/*FAQ Ends*/

	/*All Countries Listing Starts*/
	public function getAllCountries(){
		$this->output->set_content_type('application/json');
		$countries = $this->Api_model->getAllCountries();
		if($countries){
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $countries]));
		}else{
			$this->output->set_output(json_encode(['result' => -1, 'msg' =>'No data found' , 'data' => 'No data found']));
		}
	}
	/*All Countries Listing Ends*/

	/*All States Listing Starts*/
	public function getAllStates(){
		$this->output->set_content_type('application/json');
		$country_id = $this->input->post('country_id');

		$states = $this->Api_model->getAllStates($country_id);
		if($states){
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $states]));
		}else{
			$this->output->set_output(json_encode(['result' => -1, 'msg' =>'No data found' , 'data' => 'No data found']));
		}
	}
	/*All States Listing Ends*/

	/*All Cities Listing Starts*/
	public function getAllCities(){
		$this->output->set_content_type('application/json');
		$state_id = $this->input->post('state_id');

		$cities = $this->Api_model->getallCities($state_id);
		if($cities){
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $cities]));
		}else{
			$this->output->set_output(json_encode(['result' => -1, 'msg' =>'No data found' , 'data' => 'No data found']));
		}
	}
	/*All Cities Listing Ends*/

	/*All Courses Listing Starts*/
	public function getallCourses(){
		$this->output->set_content_type('application/json');
		$courses = $this->Api_model->getAllCourses();
		if($courses){
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $courses]));
		}else{
			$this->output->set_output(json_encode(['result' => -1, 'msg' =>'No data found' , 'data' => 'No data found']));
		}
	}
	/*All Courses Listing Ends*/

	/*Job Post Starts*/
	public function postJob(){
		$this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('country_id', 'Country Id', 'required');
        $this->form_validation->set_rules('state_id', 'State Id', 'required');
        $this->form_validation->set_rules('city_id', 'City Id', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('employee_type_id', 'Employee Type Id', 'required');
        $this->form_validation->set_rules('industry_type_id', 'Industry Type Id', 'required');
        $this->form_validation->set_rules('qualification_id', 'Qualification Type Id', 'required');
        $this->form_validation->set_rules('experience_id', 'Experience Type Id', 'required');
        $this->form_validation->set_rules('salary', 'Salary', 'numeric');
        $this->form_validation->set_rules('job_desc', 'Job Description', 'required');
        $this->form_validation->set_rules('name', 'User Name', 'required');
        $this->form_validation->set_rules('phone_code', 'User Name', 'required');
        $this->form_validation->set_rules('phone', 'User Phone', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }  
		if(!empty($_FILES['file1']['name'])){
            $file1=$this->doUploadLogo('file1');
        }if(empty($_FILES['file1']['name'])){
            $file1='';
        }
		$result = $this->Api_model->postJob($file1);
		if($result){
            $qualifications = explode(',',$this->input->post('qualification_id'));
            foreach($qualifications as $qualification)
            {
                $this->Api_model->jobsQualification($qualification,$result);
            }
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Job Successfully Added.' , 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => 0, 'msg' =>'Job Could not be Added.' , 'data' => 'Job Could not be Added.']));
		}
	}
    
    public function doUploadLogo($file){
        $file1 = $_FILES[$file]['name'];
        $config['upload_path'] = './uploads/company-logo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
       // $config['max_filename'] = '2555';
        $config['file_name'] = rand();
        $this->upload->initialize($config);
        $this->upload->do_upload($file);
        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
        
    }
	/*Job Post Ends*/

	/*Job Listing By User Id Starts*/
	public function getJobsListByUserId(){
		$this->output->set_content_type('application/json');
		$user_id = $this->input->post('user_id');
        $id = $this->input->post('id');
		$result = $this->Api_model->getJobsListByUserId($user_id, $id);
        $i=0;
        foreach($result as $res){
          $result[$i]['image_url'] = base_url('uploads/company-logo/'.$res['image_url']); 
            $i++;
        }
		if($result){
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'No Data Found.' , 'data' => 'No Data Found.']));
		}
	}
	/*Job Listing By User Id Ends*/

    /*Jobs Applied By User Starts*/
    public function getJobsAppliedByUserId(){
        $this->output->set_content_type('application/json');
        $user_id = $this->input->post('user_id');
        $id = $this->input->post('id');
        $result = $this->Api_model->getJobsAppliedByUserId($user_id, $id);
        $i=0;
        foreach($result as $res){
          $result[$i]['image_url'] = base_url('uploads/company-logo/'.$res['image_url']); 
            $i++;
        }
        if($result){
            $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $result]));
        }else{
            $this->output->set_output(json_encode(['result' => 1, 'msg' =>'No Data Found.' , 'data' => 'No Data Found.']));
        }
    }
    /*Jobs Applied By User Ends*/

	/*University Listing By User Starts*/
	public function universityListByUserId(){
		$this->output->set_content_type('application/json');
		$user_id = $this->input->post('user_id');
        $id = $this->input->post('id');
		$universities = $this->Api_model->getallUniversitiesByUserId($user_id,$id);
		if($universities){
			$i = 0;
			foreach($universities as $university){
				$universityImage = $university['media'];
				if(!empty($universityImage)){
					$universities[$i]['media'] = base_url('uploads/university/'.$universityImage);
				}else{
					$universities[$i]['media'] = '';
				}
				$i++;
			}
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Universities Found' , 'data' => $universities]));
		}else{
			$this->output->set_output(json_encode(['result' => -1, 'msg' =>'No Universities Found' , 'data' => 'No Universities Found']));
		}
	}
	/*University Listing By User Ends*/

	/*University Detail Starts*/
	public function universityDetail(){
		$this->output->set_content_type('application/json');
		$university_id = $this->input->post('university_id');
		$user_id = $this->input->post('user_id');
		$result = $this->Api_model->getUniversityDetailByUniversityId($university_id);
		if($result){
			$result['coursesFee'] = $this->Api_model->getCoursesFeeByUniversityId($university_id);
			$result['about'] = html_entity_decode(strip_tags($result['about']));
			$result['accomodation'] = html_entity_decode(strip_tags($result['accomodation']));
			$result['interest'] = $this->Api_model->checkUserInterest($user_id, $university_id);
            $i = 0;
            $courses = $this->Api_model->getCoursesByUniversityId($university_id);
            foreach($courses as $course){          	
				$result['courses_name'][$i] = $course['course_name'];            	
            	$i++;
            }
            $j=0;
            $images = $this->Api_model->getUniversityImages($university_id);
            foreach($images as $img){
                // $result['images'][$j]['id'] = $img['university_image_id'];
                $result['images'][$j] = base_url('uploads/university/'.$img['media']);
                $j++;
            }
			$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found.', 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found.', 'data' => 'No Data Found.']));
		}
	}
	/*University Detail Ends*/

	/*University Interest Starts*/
	public function addUniversityInterest(){
		$this->output->set_content_type('application/json');
		$user_id = $this->input->post('user_id');
		$university_id = $this->input->post('university_id');
		$checkingResponse = $this->Api_model->checkInterest($user_id, $university_id);
		if ($checkingResponse) {
            $this->output->set_output(json_encode(['result' => 0, 'msg' => 'University already added to Interest.']));
            return FALSE;
        } else {
            $response = $this->Api_model->addToInterest($user_id, $university_id);
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'University added to Interest.']));
            return FALSE;
        }
	}
	/*University Interest Ends*/

	/*Delete University Interest Starts*/
	public function deleteUniversityInterest(){
		$this->output->set_content_type('application/json');
		$user_id = $this->input->post('user_id');
		$university_id = $this->input->post('university_id');
        $response = $this->Api_model->deleteInterest($user_id, $university_id);
        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'University removed from Interested.']));
        return FALSE;
	}
	/*Delete University Interest Ends*/

	/*Home Page Starts*/
	public function getJobsTopRecommendedUniversityList(){
		$this->output->set_content_type('application/json');
		$key = $this->input->post('key');
		$user_id = $this->input->post('user_id');
        $id = $this->input->post('id');
		// Jobs Listing
		if($key === "jobs"){
			$jobs = $this->Api_model->getAllJobs($user_id, $id);
			$i=0;
	        foreach($jobs as $job){
	          	$jobs[$i]['image_url'] = base_url('uploads/company-logo/'.$job['image_url']);
	          	$i++;
	        }
			if($jobs){
				$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $jobs]));
			}else{
				$this->output->set_output(json_encode(['result' => 1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));
			}
			//Top Universities
		}else if($key === "top"){
			$topUniversity = $this->Api_model->getAllTopUniversities($id);
			if($topUniversity){
				$i = 0;
				foreach($topUniversity as $topUniversities){
					$universityImage = $topUniversities['media'];
                    $fav = $this->Api_model->getFavourite($topUniversities['university_id'],$user_id);
                    if($fav){
                      $topUniversity[$i]['status'] = 'Intrested';  
                    }else{
                      $topUniversity[$i]['status'] = 'Not Intrested';  
                    }
					if(!empty($universityImage)){
						$topUniversity[$i]['media'] = base_url('uploads/university/'.$universityImage);
					}else{
						$topUniversity[$i]['media'] = '';
					}
					$i++;
				}
				$this->output->set_output(json_encode(['result' => 2, 'msg' => 'Data Found', 'data' => $topUniversity]));
			}else{
				$this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Data Found', 'data' => 'No Data Found']));
			}
        }else if($key == 'alluniversities'){
          $all = $this->Api_model->getAllUniversities($id);
            if($all){
               $i = 0;
				foreach($all as $alluniversity){
					$universityImage = $alluniversity['media'];
                    
                    $fav = $this->Api_model->getFavourite($alluniversity['university_id'],$user_id);
                    if($fav){
                      $all[$i]['status'] = 'Intrested';  
                    }else{
                      $all[$i]['status'] = 'Not Intrested';  
                    }
//                    print_r($fav);die;
					if(!empty($universityImage)){
						$all[$i]['media'] = base_url('uploads/university/'.$universityImage);
					}else{
						$all[$i]['media'] = '';
					}
					$i++;
				} 
             $this->output->set_output(json_encode(['result' => 2, 'msg' => 'Data Found', 'data' => $all]));   
            }else{
              $this->output->set_output(json_encode(['result' => -2, 'msg' => 'No Data Found', 'data' => 'No Data Found']));  
            }
            
        }
        else{
			//Recommended Universities
			$recommendedUniversity = $this->Api_model->getAllRecommendedUniversities($id);
			if($recommendedUniversity){
				$i = 0;
				foreach($recommendedUniversity as $recommendedUniversities){
					$universityImage = $recommendedUniversities['media'];
                    $fav = $this->Api_model->getFavourite($recommendedUniversities['university_id'],$user_id);
                    if($fav){
                      $recommendedUniversity[$i]['status'] = 'Intrested';  
                    }else{
                      $recommendedUniversity[$i]['status'] = 'Not Intrested';  
                    }
					if(!empty($universityImage)){
						$recommendedUniversity[$i]['media'] = base_url('uploads/university/'.$universityImage);
					}else{
						$recommendedUniversity[$i]['media'] = '';
					}
					$i++;
				}
				$this->output->set_output(json_encode(['result' => 3, 'msg' => 'Data Found', 'data' => $recommendedUniversity]));
			}else{
				$this->output->set_output(json_encode(['result' => -3, 'msg' => 'No Data Found', 'data' => 'No Data Found']));
			}
       		return FALSE;	
		}
	}
	/*Home Page Ends*/
    
    /*Job Searching starts*/
    public function jobSearching(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('search', 'Search', 'required');        
        $this->form_validation->set_rules('user_id', 'user ID', 'required');        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $search = $this->input->post('search');
        $user_id = $this->input->post('user_id');
        $id = $this->input->post('id');
        $result = $this->Api_model->jobSearching($search, $user_id, $id);
        $i=0;
        foreach($result as $res){
          	$result[$i]['image_url'] = base_url('uploads/company-logo/'.$res['image_url']);
          	$i++;
        }
        if($result){
			$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => 1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));
		}
    }
    /*Job Searching ends*/
    
    /*University Searching */
    public function universitySearching(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('search', 'Search', 'required');         
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $search = $this->input->post('search');
        $id = $this->input->post('id');
        $result = $this->Api_model->universitySearching($search,$id);

        
        if($result){
            $i=0;
        foreach($result as $res){
            $image = $this->Api_model->getimage($res['university_id']);
          	$result[$i]['media'] = base_url('uploads/university/'.$image['media']);
          	$i++;
        }
			$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => 1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));
		}    
    }
    /*University Searching ends */
    
    /*Banner Starts*/
    public function getBannerImages(){
        $this->output->set_content_type('application/json');
        $result = $this->Api_model->getBannerImages();
        $i=0;
        foreach($result as $res){
          	$result[$i]['image_url'] = base_url('uploads/banner/'.$res['image_url']);
          	$i++;
        }
        if($result){
           $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result])); 
        }else{
           $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found'])); 
        }
    }
    /*Banner ends*/
    
    /*Walkthrough Starts*/
    public function getWalkthrough(){
      	$this->output->set_content_type('application/json');
      	$result = $this->Api_model->getWalkthrough();
       	$i=0;
        foreach($result as $res){
          	$result[$i]['image_url'] = base_url('uploads/walkthrough/'.$res['image_url']);
          	$result[$i]['text'] = strip_tags($res['text']);
          	$i++;
        } 
        if($result){
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result])); 
        }else{
           $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found'])); 
        }
    }
    /*Walkthrough ends*/
    
    /*Profile Complete*/
    public function profileComplete(){
        $this->output->set_content_type('application/json');
        $user_id = $this->input->post('user_id');
        $result = $this->Api_model->getUserDetails($user_id);
        $maximumPoints  = 100;
        if(!empty($result['name'])){
            $name = 10;            
        }if(!empty($result['email'])){
            $email = 10;
        }if(!empty($result['phone'])){
            $phone = 10;
        }if(!empty($result['qualification'])){
            $quali = 10;
        }else{ $quali = 0; }
        if(!empty($result['country_id'])){
            $country = 10;
        }else{ $country = 0;  }        
        if(!empty($result['programme'])){
            $program = 10;
        }else{ $program= 0; }
        if(!empty($result['study'])){
            $study = 10;
        }else{ $study=0; }
        if(!empty($result['start_time'])){
            $start = 10;
        }else{ $start=0;}
        $percentage = ($name+$email+$phone+$quali+$country+$program+$study+$start)*$maximumPoints/100;
        if($percentage){
          $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'percentage' => $percentage]));   
        }else{
          $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));  
        }  
    }
    /*Profile Complete ends*/
    
    /*Employee Type*/
    public function getEmployeeType(){ 
        $this->output->set_content_type('application/json');
        $result = $this->Api_model->getEmployeeType();
        if($result){
          	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result]));   
        }else{
          	$this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));  
        }
    }
    /*Employee Type Ends*/
    
    /*Industry Type*/
    public function getIndustryTypes(){
     	$this->output->set_content_type('application/json');
     	$result = $this->Api_model->getIndustryTypes();
        if($result){
          	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result]));   
        }else{
          	$this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));  
        }
    }    
    /*Industry Type Ends*/
    
    /*Experience Starts*/
    public function getExperience(){
     	$this->output->set_content_type('application/json');
     	$result = $this->Api_model->getExperience();
        if($result){
          	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result]));   
        }else{
          	$this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));  
        }    
    }
    /*Experience Ends*/
    
    /*user profile details*/
    public function getUserProfileDetails(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $user_id = $this->input->post('user_id');
        $result = $this->Api_model->getUserDetails($user_id);
        if($result){
            if($result['programme'] == 'Undergraduate'){
            	$result['Undergraduate'] = $this->Api_model->getUserUndergraduate($user_id);
            }
            if($result['programme'] == 'Post Graduate'){
               $result['Post Graduate'] = $this->Api_model->getUserPostgraduate($user_id); 
            }
            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Data Found', 'data' => $result]));
        }else{
           $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found']));  
        }
    }    
    /*user profile details ends*/
    
    /*user profile update starts*/
    public function updateUserProfile(){
       	$this->output->set_content_type('application/json');
       	$this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('qualification', 'Highest Qualification', 'required');
        $this->form_validation->set_rules('country_id', 'Country', 'required');
        $this->form_validation->set_rules('state_id', 'State', 'required');
        $this->form_validation->set_rules('city_id', 'City', 'required');
        $this->form_validation->set_rules('programme', 'Programme', 'required');
        $this->form_validation->set_rules('study', 'Study in UK', 'required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $user_id = $this->input->post('user_id');
        $program = $this->input->post('programme');
        $study = $this->input->post('study');
        $result = $this->Api_model->updateUserProfile($user_id);
        if($result){
            if($program == 'Undergraduate'){
                $this->userUndergraduateUpdate($user_id);                
            }
            if($program == 'Post Graduate'){
                $this->userPostgraduateUpdate($user_id);
            }
            if($study == 'Yes'){
                $this->userStudyinUkUpdate($user_id);
            }
           	$this->output->set_output(json_encode(['result' => 1, 'msg' => 'Profile Updated', 'data' => $result])); 
        }else{
           $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Data Found', 'data' => 'No Data Found'])); 
        }
    }
    
    public function userUndergraduateUpdate($user_id){
       $country = $this->input->post('ug_country_id');
       $state = $this->input->post('ug_state_id');
       $city = $this->input->post('ug_city_id');
            if(!empty($_FILES['ug_passport']['name'])){
            	$file1=$this->doUploadUGFile('ug_passport');
            }if(empty($_FILES['ug_passport']['name'])){
                $file1='';
            }if(!empty($_FILES['ug_degree']['name'])){
                $file2 = $this->doUploadUGFile('ug_degree');
            }if(empty($_FILES['ug_degree']['name'])){
                $file2 = '';
            }if(!empty($_FILES['ug_diploma']['name'])){
                $file3 = $this->doUploadUGFile('ug_diploma');
            }if(empty($_FILES['ug_diploma']['name'])){
                $file3 = '';
            }
        $checkug = $this->Api_model->checkug($user_id);
        if($checkug > 0){
            $this->Api_model->updateUserUG($user_id,$country,$state,$city,$file1,$file2,$file3);
          	return;
        }else{
            $this->Api_model->insertUserUG($user_id,$country,$state,$city,$file1,$file2,$file3);
        }        
    }
    
    public function doUploadUGFile($file){
        $file1 = $_FILES[$file]['name'];
        $config['upload_path'] = './uploads/undergraduate/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        $config['file_name'] = rand();
        $this->upload->initialize($config);
        $this->upload->do_upload($file);
        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }
    
    public function userPostgraduateUpdate($user_id){
        $country = $this->input->post('pg_country_id');
        $state = $this->input->post('up_state_id');
        $city = $this->input->post('pg_city_id');
        $percentage = $this->input->post('pg_percentage');
            if(!empty($_FILES['pg_passport']['name'])){
            	$file1=$this->doUploadPGFile('pg_passport');
            }if(empty($_FILES['pg_passport']['name'])){
                $file1='';
            }if(!empty($_FILES['pg_transcript']['name'])){
                $file2 = $this->doUploadPGFile('pg_transcript');
            }if(empty($_FILES['pg_transcript']['name'])){
                $file2 = '';
            }if(!empty($_FILES['pg_certificate']['name'])){
                $file3 = $this->doUploadPGFile('pg_certificate');
            }if(empty($_FILES['pg_certificate']['name'])){
                $file3 = '';
            }if(!empty($_FILES['pg_cv']['name'])){
                $file4 = $this->doUploadPGFile('pg_cv');
            }if(empty($_FILES['pg_cv']['name'])){
                $file4 = '';
            }if(!empty($_FILES['pg_rf1']['name'])){
                $file5 = $this->doUploadPGFile('pg_rf1');
            }if(empty($_FILES['pg_rf1']['name'])){
                $file5 = '';
            }if(!empty($_FILES['pg_rf2']['name'])){
                $file6 = $this->doUploadPGFile('pg_rf2');
            }if(empty($_FILES['pg_rf2']['name'])){
                $file6 = '';
            }
            $checkpg = $this->Api_model->checkpg($user_id);
            
        if($checkpg > 0){
            $this->Api_model->updateUserPG($user_id,$country,$state,$city,$percentage,$file1,$file2,$file3,$file4,$file5,$file6);
               return;
        }else{
            $this->Api_model->insertUserPG($user_id,$country,$state,$city,$percentage,$file1,$file2,$file3,$file4,$file5,$file6);
            return;
        }          
    }
    
    public function doUploadPGFile($file){
        $file1 = $_FILES[$file]['name'];
        $config['upload_path'] = './uploads/postgraduate/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        $config['file_name'] = rand();
        $this->upload->initialize($config);
        $this->upload->do_upload($file);
        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }
    
    public function userStudyinUkUpdate($user_id){
        if(!empty($_FILES['study_visa']['name'])){
            $file1=$this->doUploadstudyFile('study_visa');
        }if(empty($_FILES['study_visa']['name'])){
                $file1='';
        }if(!empty($_FILES['study_visaLetter']['name'])){
            $file2 = $this->doUploadstudyFile('study_visaLetter');
        }if(empty($_FILES['study_visaLetter']['name'])){
            $file2 = '';
        }
        $this->Api_model->userStudyinUkUpdate($user_id,$file1,$file2);
        return;
    }

    public function doUploadstudyFile($file){
        $file1 = $_FILES[$file]['name'];
        $config['upload_path'] = './uploads/studyuk/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '0';
        $config['file_name'] = rand();
        $this->upload->initialize($config);
        $this->upload->do_upload($file);
        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }

    public function applyJob(){
    	$this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('job_id', 'Job Id', 'required');    	
    	if(!empty($_FILES['resume']['name'])){
            $resume=$this->doUploadResume('resume');
        }if(empty($_FILES['resume']['name'])){
            $resume='';
        }
		$result = $this->Api_model->applyJob($resume);
		if($result){
			$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Job Applied Successfully.' , 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => 0, 'msg' =>'Job Could not be Applied.' , 'data' => 'Job Could not be Applied.']));
		}
    }

    public function doUploadResume($file){
        $resume = $_FILES[$file]['name'];
        $config['upload_path'] = './uploads/resume/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|txt';
        $config['max_size'] = '0';
        $config['file_name'] = rand();
        $this->upload->initialize($config);
        $this->upload->do_upload($file);
        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }

    public function applicationSupport(){
    	$this->output->set_content_type('application/json');
       	$this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('university_id', 'University Name', 'required');
        $this->form_validation->set_rules('school_name', 'School Name', 'required');
        $this->form_validation->set_rules('city_id', 'City Name', 'required');
        $this->form_validation->set_rules('month', 'Month', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('country_from', 'Country From', 'required');
        $this->form_validation->set_rules('country_now', 'Country Now', 'required');
        $this->form_validation->set_rules('study', 'Study', 'required');
        $this->form_validation->set_rules('qualification', 'Highest Qualification', 'required');
        $this->form_validation->set_rules('passport', 'Passport', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->applicationSupport();
        if($result){
        	$this->output->set_output(json_encode(['result' => 1, 'msg' =>'Application Submitted successfully.' , 'data' => $result]));
		}else{
			$this->output->set_output(json_encode(['result' => 0, 'msg' =>'Application could not be Added.' , 'data' => 'Application could not be Added.']));
		}
    }

    public function arrivalSupport(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('university_id', 'University Name', 'required');
        $this->form_validation->set_rules('school_name', 'School Name', 'required');
        $this->form_validation->set_rules('city_id', 'City Name', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');
        $this->form_validation->set_rules('airport', 'Airport Name', 'required');
        $this->form_validation->set_rules('terminal', 'Terminal', 'required');
        $this->form_validation->set_rules('flight_number', 'Flight Number', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->arrivalSupport();
        if($result){
            $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Arrival Submitted successfully.' , 'data' => $result]));
        }else{
            $this->output->set_output(json_encode(['result' => 0, 'msg' =>'Arrival could not be Submitted.' , 'data' => 'Arrival could not be Submitted.']));
        }
    }

    public function visaSupport(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('university_id', 'University Name', 'required');
        $this->form_validation->set_rules('school_name', 'School Name', 'required');
        $this->form_validation->set_rules('city_id', 'City Name', 'required');
        $this->form_validation->set_rules('month', 'Month', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('fees', 'Fees', 'required');
        $this->form_validation->set_rules('cas_letter', 'CAS Letter', 'required');
        $this->form_validation->set_rules('apply', 'Apply', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->visaSupport();
        if($result){
            $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Visa Submitted successfully.' , 'data' => $result]));
        }else{
            $this->output->set_output(json_encode(['result' => 0, 'msg' =>'Visa could not be Submitted.' , 'data' => 'Visa could not be Submitted.']));
        }
    }
    
    public function insertToken(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('token_id', 'Token Id', 'required');     
        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->insertToken();
        if($result){
         $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Token Inserted successfully.' , 'data' => $result]));   
        }else{
          $this->output->set_output(json_encode(['result' => 0, 'msg' =>'Failed to insert.' , 'data' => 'Failed to insert.']));  
        }
        
    }
    
    public function getNotificationLists(){
       $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');            
        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        } 
        $user_id = $this->input->post('user_id');
        $result = $this->Api_model->getNotificationLists($user_id);
        if($result){
         $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Data Found' , 'data' => $result]));   
        }else{
          $this->output->set_output(json_encode(['result' => 0, 'msg' =>'Data not Found.' , 'data' => 'Data not Found.']));  
        }
        
    }
    
    public function logout(){
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('user_id', 'User Id', 'required');
        $this->form_validation->set_rules('token_id', 'Token Id', 'required');     
        
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_output(json_encode(['result' => 0, 'errors' => $this->form_validation->error_array()]));
            return FALSE;
        }
        $result = $this->Api_model->logout();
        if($result){
         $this->output->set_output(json_encode(['result' => 1, 'msg' =>'Logout Sucess' , 'data' => 'Logout Sucess']));   
        }else{
          $this->output->set_output(json_encode(['result' => 0, 'msg' =>'Failed to Logout.' , 'data' => 'Failed to Logout..']));  
        }
    }
    
    

//    public function getAllNotifications(){
//        $this->output->set_content_type('application/json');
//        $user_id=$this->input->post('user_id');
//        $results=$this->Api_model->getAllNotification($user_id);
//        if($results){
//            $this->output->set_output(json_encode(['result' => 1, 'msg' => 'All Notifications','notification'=>$results]));
//            return false;    
//        }else{
//            $this->output->set_output(json_encode(['result' => -1, 'msg' => 'No Notification Available']));
//            return false;
//        }
//    }
//
//    public function sendNotificationToUser(){
//        $this->output->set_content_type('application/json');
//        $user_id = $this->input->post('user_id');
//        $token=$this->Api_model->getTokenByUserId($user_id);
//        $title="New Message";
//        $body="Hello, buddy How Are You?";
//        $msg= array(
//            'body'  => $body,
//            'title' => $title
//        );
//                     
//        $this->Api_model->addNotificationMessage($title, $body, $user_id);
//                     
//        $fields = array(
//             'to' => $token['token_id'],
//             'notification' =>$msg
//            );
//            
//            
//        $headers = array('Authorization:key = '.'AAAAvoE-tGc:APA91bEfBDIaCjg6M7pQfvFt5lbQgdat19NgTrxZyC7jRD91KZ_J6FOVJSFjsXhW--xyxZvb2kdZG1G92Kw2Z3RHKnCNvjkT5w5OhPyzC6TsaecLC7OYrYfIVVdTaEa_Njb30a8viusi',
//        'Content-Type: application/json' 
//        );
//         $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//   
//        $result = curl_exec($ch);    
//        if ($result === FALSE) {
//          die('Curl failed: ' . curl_error($ch));
//        }
//
//        curl_close($ch);
//        
//        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Notification Send']));
//        return false;
//    }
//    
//    public function sendNotificationToAll(){
//        $this->output->set_content_type('application/json');
//        $token_arrs=$this->Api_model->getAllTokenId(); 
//        $i=0;
//        
//        $token=[];
//        
//        foreach($token_arrs as $tok){
//            $msg= array(
//                'body'  => "Hello, user How are you.",
//                'title' => 'New Message'
//            );
//            
//            $fields = array(
//                'to' => $tok["token_id"],
//                'notification' =>$msg
//            );
//            
//            $headers = array('Authorization:key = '.'AAAAvoE-tGc:APA91bEfBDIaCjg6M7pQfvFt5lbQgdat19NgTrxZyC7jRD91KZ_J6FOVJSFjsXhW--xyxZvb2kdZG1G92Kw2Z3RHKnCNvjkT5w5OhPyzC6TsaecLC7OYrYfIVVdTaEa_Njb30a8viusi',
//            'Content-Type: application/json'
//            );
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//            curl_setopt($ch, CURLOPT_POST, true);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//       
//            $result = curl_exec($ch);    
//            if ($result === FALSE) {
//               die('Curl failed: ' . curl_error($ch));
//            }
//            curl_close($ch);
//        }
//            
//        $this->output->set_output(json_encode(['result' => 1, 'msg' => 'Notification Send']));
//        return false;  
//    }
}
?>