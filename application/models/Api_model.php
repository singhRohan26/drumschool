<?php 
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Author Rajat Agarwal
 */
class Api_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

    public function getAllCountries(){
        $this->db->select('coun.id as id,coun.name as name, coun.phonecode');
        $this->db->from('countries coun');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllStates($country_id){
        $this->db->select('s.*');
        $this->db->from('states s');
        $this->db->where('s.country_id', $country_id);
        $query = $this->db->get();
        return $query->result_array();
    }

	public function getAllCities($state_id = null){
        $this->db->select('cit.id as id,cit.name as name');
        $this->db->from('cities cit');
        if(!empty($state_id)){
            $this->db->where('cit.state_id', $state_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getallJobCategories(){
        $this->db->select('job_category.job_category_id, job_category.category_name');
        $this->db->from('job_category');
        $this->db->where('job_category.status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getallCourses(){
        $this->db->select('courses.course_id, courses.course_name');
        $this->db->from('courses');
        $this->db->where('courses.status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function checkmail($email){
        $this->db->select('u.user_id,u.name,u.email,u.phone');
        $this->db->from('users u');
        $this->db->where('u.email',$email);
        $sel = $this->db->get();
        return $sel->row_array();
    }

    public function checkpass($email, $password){
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('email',$email);
        $this->db->where('u.password',$password);
        $sel = $this->db->get();
        return $sel->row_array();
    }

    public function signUp($name, $email, $phone, $country_id, $state_id, $city_id, $password, $unique_id){
        $this->db->insert('users',['name'=>$name, 'email'=>$email, 'phone' => $phone, 'country_id' => $country_id, 'state_id' => $state_id, 'city_id' => $city_id, 'password'=>$password, 'unique_id' => $unique_id]);
        $id =  $this->db->insert_id();
        $this->db->select('u.user_id, u.name, u.email, u.phone, u.unique_id, u.status');
        $this->db->from('users u');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function resendMail($user_id, $unique_id){
        $this->db->where('user_id', $user_id);
        $this->db->update('users', ['unique_id' => $unique_id]);
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function checkold($old_pass, $user_id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('password',hash('sha256',$old_pass));
        $this->db->where('user_id',$user_id);
        $sel = $this->db->get();
        return $sel->row_array();
    }

    public function changePass($user_id, $old_pass, $new_pass){
        $old_p = hash('sha256',$old_pass);
        $this->db->select('*');
        $this->db->from('users');
        $where = "user_id = '$user_id' AND password = '$old_p'";
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows()>0){
           $this->db->where('user_id',$user_id);
           $q = $this->db->update('users',['password'=>hash('sha256',$new_pass)]);
           return true; 
        }else{
            return false;
        }
    }

    public function verify_emailid() {
        $query = $this->db->get_where('users', ['email' => $this->input->post('email')]);
        return $query->row_array();
    }

    public function insert_user_activationcode($activationcode, $result) {
        $data = array(
            'user_id' => $result['user_id'],
            'activationcode' => $activationcode
        );
        $this->db->insert('user_email_verify', $data);
        return $this->db->insert_id();
    }

    public function update_user_email_status($user_id, $activationcode) {
        $query = $this->db->get_where('user_email_verify', ['user_id' => $user_id, 'activationcode' => $activationcode, 'status' => 'Inactive']);
        if (!empty($query->row_array())) {
            $this->db->update('user_email_verify', ['status' => 'Active'], ['user_id' => $user_id, 'activationcode' => $activationcode]);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    public function doChangeForgotPassword() {
        $data = array(
            'password' => hash('sha256', $this->security->xss_clean($this->input->post('new_password'))),
        );
        $id = $this->security->xss_clean($this->input->post('userid'));
        $this->db->update('users', $data, ['user_id' => $id]);
        return $this->db->affected_rows();
    }

    public function getDataByUniqueId($unique_id) {
        $result = $this->db->get_where('users', ['unique_id' => $unique_id]);
        return $result->row_array();
    }

    public function verifyEmail($unique_id){
        $this->db->update('users', ['status' => 'Active'], ['unique_id' => $unique_id]);
        return $this->db->affected_rows();
    }

    public function getPages($page){
        $query = $this->db->get_where('site_settings', ['page' => $page]);
        return $query->row_array();
    }

    public function getAllFaqs(){
        $query = $this->db->get('faq');
        return $query->result_array();
    }

    public function postJob($file1){
        $data = array(
			'user_id' => $this->input->post('user_id'),
			'company_name' => $this->input->post('company_name'),
			'country_id' => $this->input->post('country_id'),
			'state_id' => $this->input->post('state_id'),
			'city_id' => $this->input->post('city_id'),
			'location' => $this->input->post('location'),
			'role' => $this->input->post('role'),
			'employee_type_id' => $this->input->post('employee_type_id'),
			'industry_type_id' => $this->input->post('industry_type_id'),
			'experience_id' => $this->input->post('experience_id'),
			'salary' => $this->input->post('salary'),
			'description' => $this->input->post('job_desc'),
			'user_name' => $this->input->post('name'),
			'user_phone_code' => $this->input->post('phone_code'),
            'user_phone' => $this->input->post('phone'),
			'image_url' => $file1,
            'status' => 'Inactive'
		);
        $this->db->insert('job', $data);
        return $this->db->insert_id();
    }

    public function getJobsListByUserId($user_id, $id=null){
        $this->db->select('j.*,s.name as state_name,c.name as country_name');
        $this->db->from('job j');
        $this->db->join('states s', 's.id = j.state_id');
        $this->db->join('countries c', 'c.id = j.country_id');
        $this->db->where('j.user_id', $user_id);
        $this->db->order_by('j.job_id','desc');
        if(!empty($id)){
            $this->db->where('j.job_id <',$id);  
            $this->db->limit('5');
        }else{
            $this->db->limit('5');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getJobsAppliedByUserId($user_id, $id=null){
        $this->db->select('j.*,s.name as state_name,c.name as country_name');
        $this->db->from('job_apply ja');
        $this->db->join('job j', 'j.job_id = ja.job_id');
        $this->db->join('states s', 's.id = j.state_id');
        $this->db->join('countries c', 'c.id = j.country_id');
        $this->db->where('ja.user_id', $user_id);
        $this->db->order_by('j.job_id','desc');
        if(!empty($id)){
            $this->db->where('j.job_id <',$id);  
            $this->db->limit('5');
        }else{
            $this->db->limit('5');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getallUniversitiesByUserId($user_id,$id=null){
        $this->db->select('u.university_id, u.university_name, c.name as country_name, cit.name as city_name, s.name as state_name, ui.media');
        $this->db->from('interest i');
        $this->db->join('university u', 'u.university_id = i.university_id');
        $this->db->join('countries c', 'u.country_id = c.id');
        $this->db->join('states s', 'u.state_id = s.id');
        $this->db->join('cities cit', 'u.city_id = cit.id');
        $this->db->join('university_images ui', 'u.university_id = ui.university_id');
        $this->db->where('i.user_id', $user_id);
        $this->db->group_by('u.university_id');
        $this->db->order_by('i.interest_id','desc');
        if(!empty($id)){
          $this->db->where('i.interest_id <',$id);  
          $this->db->limit('5');    
        }else{
            $this->db->limit('5');
        }
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function getUniversityDetailByUniversityId($university_id){
        $this->db->select('u.*');
        $this->db->from('university u');
        $this->db->where('u.university_id', $university_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getUniversityImages($university_id){
        $this->db->select('ui.university_image_id, ui.media');
        $this->db->from('university_images ui');
        $this->db->where('ui.university_id', $university_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCoursesByUniversityId($university_id){
        $this->db->select('uc.fee, c.course_name');
        $this->db->from('university_course uc');
        $this->db->join('courses c', 'c.course_id = uc.course');
        $this->db->where('uc.university_id', $university_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCoursesFeeByUniversityId($university_id){
        $this->db->select('MIN(uc.fee) as min_fee, MAX(uc.fee) as max_fee');
        $this->db->from('university_course uc');
        $this->db->where('uc.university_id', $university_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function checkInterest($user_id, $university_id) {
        $check_query = $this->db->get_where('interest', ['user_id' => $user_id, 'university_id' => $university_id]);
        if ($check_query->num_rows() >= 1) {
            return TRUE;
        }
    }

    public function addToInterest($user_id, $university_id) {
        $data = array(
            'user_id' => $user_id,
            'university_id' => $university_id
        );
        $query = $this->db->insert('interest', $data);
        return 1;
    }

    public function deleteInterest($user_id, $university_id) {
        $this->db->delete('interest', ['user_id' => $user_id, 'university_id' => $university_id]);
        return $this->db->affected_rows();
    }

    public function checkUserInterest($user_id, $university_id){
        $data=array(
            'user_id'=>$user_id,
            'university_id'=>$university_id,
        );
        $query=$this->db->get_where('interest',$data);
        $query->row_array();
        if($query->num_rows()>0){
            return "Interested";
        }else{
            return 'Not Interested';
        }
    }

    public function getAllJobs($user_id, $id=null){
        $this->db->select('job.job_id, job.user_id, job.company_name, job.location, job.role, job.image_url');
        $this->db->from('job');
        $this->db->where('job.status', 'Active');
        if(!empty($id))
        {
        $this->db->where('job.job_id <',$id);
        $this->db->limit(5);
        }else{
            $this->db->limit(5);
        }
        $this->db->where('job.user_id !=', $user_id);
        $this->db->where('job.user_id =', '');
        $this->db->order_by('job.job_id','desc');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function jobSearching($search, $user_id, $id=null){
        $this->db->select('job.job_id, job.user_id, job.company_name, job.location, job.role, job.image_url');
        $this->db->from('job');
        $this->db->join('employee_type','employee_type.employee_type_id=job.employee_type_id');
        $this->db->join('industry_type','industry_type.industry_type_id=job.industry_type_id');
        $this->db->join('countries','countries.id=job.country_id');
        $this->db->join('states','states.id=job.state_id');
        $this->db->join('cities','cities.id=job.city_id');
        $this->db->where('job.status', 'Active');
        $this->db->where('job.user_id !=', $user_id);        
        $this->db->where("job.company_name LIKE '%$search%'");        
        $this->db->or_where("employee_type.employee_type LIKE '%$search%'");        
        $this->db->or_where("industry_type.industry_type LIKE '%$search%'");        
        $this->db->or_where("countries.name LIKE '%$search%'");        
        $this->db->or_where("states.name LIKE '%$search%'");        
        $this->db->or_where("cities.name LIKE '%$search%'");        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function universitySearching($search,$id){
        $this->db->select('u.university_id, u.university_name, c.name as country_name, cit.name as city_name, s.name as state_name');
        $this->db->from('university u');
        $this->db->join('countries c', 'u.country_id = c.id');
        $this->db->join('states s', 'u.state_id = s.id');
        $this->db->join('cities cit', 'u.city_id = cit.id');
//        $this->db->join('university_images ui', 'u.university_id = ui.university_id');
        $this->db->where('u.status', 'Active');
        $this->db->where("u.university_name LIKE '%$search%'");
        $this->db->or_where("c.name LIKE '%$search%'");        
        $this->db->or_where("s.name LIKE '%$search%'");        
        $this->db->or_where("cit.name LIKE '%$search%'");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllTopUniversities($id=null){
        $this->db->select('u.university_id, u.university_name, c.name as country_name, cit.name as city_name, s.name as state_name, ui.media');
        $this->db->from('university u');
        $this->db->join('countries c', 'u.country_id = c.id');
        $this->db->join('states s', 'u.state_id = s.id');
        $this->db->join('cities cit', 'u.city_id = cit.id');
        $this->db->join('university_images ui', 'u.university_id = ui.university_id');
        $this->db->where('u.status', 'Active');
        $this->db->where('u.university_type', 'top');
        $this->db->order_by('u.university_id','desc');
        if(!empty($id))
        {
        $this->db->where('u.university_id <',$id);
        $this->db->limit(5);
        }else{
            $this->db->limit(5);
        }
        $this->db->group_by('u.university_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getAllUniversities($id){
       $this->db->select('u.university_id, u.university_name, c.name as country_name, cit.name as city_name, s.name as state_name, ui.media');
        $this->db->from('university u');
        $this->db->join('countries c', 'u.country_id = c.id');
        $this->db->join('states s', 'u.state_id = s.id');
        $this->db->join('cities cit', 'u.city_id = cit.id');
        $this->db->join('university_images ui', 'u.university_id = ui.university_id');
        $this->db->where('u.status', 'Active');
        $this->db->order_by('u.university_id','desc');
        if(!empty($id))
        {
        $this->db->where('u.university_id <',$id);
        $this->db->limit(5);
        }else{
            $this->db->limit(5);
        }
        $this->db->group_by('u.university_id');
        $query = $this->db->get();
        return $query->result_array();
 
    }

    public function getAllRecommendedUniversities($id=null){
        $this->db->select('u.university_id, u.university_name, c.name as country_name, cit.name as city_name, s.name as state_name, ui.media');
        $this->db->from('university u');
        $this->db->join('countries c', 'u.country_id = c.id');
        $this->db->join('states s', 'u.state_id = s.id');
        $this->db->join('cities cit', 'u.city_id = cit.id');
        $this->db->join('university_images ui', 'u.university_id = ui.university_id');
        $this->db->where('u.status', 'Active');
        $this->db->where('u.university_type', 'recommended');
        $this->db->group_by('u.university_id');
        $this->db->order_by('u.university_id','desc');
        if(!empty($id))
        {
        $this->db->where('u.university_id <',$id);
        $this->db->limit(5);
        }else{
            $this->db->limit(5);
        }
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }
    
    public function jobsQualification($qualification,$job_id){
        $this->db->insert('job_qualifications',['job_id'=>$job_id,'qualification_id'=>$qualification]);
        return $this->db->insert_id();
    }
    
    public function getBannerImages(){
        $this->db->select('banner.image_url');
        $this->db->from('banner');
        $sel = $this->db->get();
        return $sel->result_array();
    }
    
    public function getWalkthrough(){
        $this->db->select('*');
        $this->db->from('walkthrough');
        $sel = $this->db->get();
        return $sel->result_array();
    }
    
    public function getEmployeeType(){
        $this->db->select('employee_type.employee_type_id,employee_type.employee_type');
        $this->db->from('employee_type');
        $sel = $this->db->get();
        return $sel->result_array();
    }
    
    public function getIndustryTypes(){
        $this->db->select('industry_type.industry_type_id,industry_type.industry_type');
        $this->db->from('industry_type');
        $sel = $this->db->get();
        return $sel->result_array();
    }
     
    public function getExperience(){
       $this->db->select('experience.experience_id,experience.experience');
        $this->db->from('experience');
        $sel = $this->db->get();
        return $sel->result_array(); 
    }
    
    public function getUserDetails($user_id){
        $sel = $this->db->get_where('users',['user_id'=>$user_id]);
        return $sel->row_array();
    }
    
    public function getUserUndergraduate($user_id){
        $this->db->select('ug.country_id,ug.passport,ug.degree,ug.diploma');
        $this->db->from('user_undergraduate ug');
        $this->db->where('user_id',$user_id);
        $sel = $this->db->get();
        return $sel->row_array();
    }
    
    public function getUserPostgraduate($user_id){
        $this->db->select('pg.country_id,pg.precentage,pg.passport,pg.transcript,pg.certificate,pg.cv,pg.refrence1,pg.refrence2');
        $this->db->from('user_postgraduation pg');
        $this->db->where('user_id',$user_id);
        $sel = $this->db->get();
        return $sel->row_array();        
    }
    
    public function updateUserProfile($user_id){
        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone'=> $this->input->post('phone'),
            'qualification'=> $this->input->post('qualification'),
            'country_id'=> $this->input->post('country_id'),
            'state_id'=> $this->input->post('state_id'),
            'city_id'=> $this->input->post('city_id'),
            'programme'=> $this->input->post('programme'),
            'study'=> $this->input->post('study'),
            'start_time'=> $this->input->post('start_time')
        );
        $this->db->where('user_id',$user_id);
        $this->db->update('users',$data);
        return $this->db->affected_rows();
    }

    public function checkug($user_id){
        $this->db->select('*');
        $this->db->from('user_undergraduate');
        $this->db->where('user_id',$user_id);
        $sel = $this->db->get();
        return $sel->num_rows();
    }
    
    public function updateUserUG($user_id,$country,$state,$city,$file1,$file2,$file3){
            $data = array(
            'country_id'=>$country,
            'state_id'=>$state,
            'city_id'=>$city,
            'passport'=>$file1,
            'degree'=>$file2,
            'diploma'=>$file3
        );
        $this->db->where('user_id',$user_id);
        $this->db->update('user_undergraduate',$data);
        return $this->db->affected_rows();
    }

    public function insertUserUG($user_id,$country,$state,$city,$file1,$file2,$file3){
        $data = array(
            'user_id'=>$user_id,
            'country_id'=>$country,
            'state_id'=>$state,
            'city_id'=>$city,
            'passport'=>$file1,
            'degree'=>$file2,
            'diploma'=>$file3
        );
        $this->db->insert('user_undergraduate',$data);
        return $this->db->insert_id();
    }
    
    public function checkpg($user_id){
        $this->db->select('*');
        $this->db->from('user_postgraduation');
        $this->db->where('user_id',$user_id);
        $sel = $this->db->get();
        return $sel->num_rows();
    }

    public function updateUserPG($user_id,$country,$state,$city,$percentage,$file1,$file2,$file3,$file4,$file5,$file6){
        $data = array(        
            'country_id'=>$country,
            'state_id'=>$state,
            'city_id'=>$city,
            'precentage'=>$percentage,
            'passport'=>$file1,
            'transcript'=>$file2,
            'certificate'=>$file3,
            'cv'=>$file4,
            'refrence1'=>$file5,
            'refrence2'=>$file6
            
        );
        $this->db->where('user_id',$user_id);
        $this->db->update('user_postgraduation',$data);
        return $this->db->affected_rows();
    }

    public function insertUserPG($user_id,$country,$state,$city,$percentage,$file1,$file2,$file3,$file4,$file5,$file6){
      $data = array( 
            'user_id'=>$user_id,
            'country_id'=>$country,
            'state_id'=>$state,
            'city_id'=>$city,
            'precentage'=>$percentage,
            'passport'=>$file1,
            'transcript'=>$file2,
            'certificate'=>$file3,
            'cv'=>$file4,
            'refrence1'=>$file5,
            'refrence2'=>$file6            
        );
        $this->db->insert('user_postgraduation',$data);
        return $this->db->insert_id();
    }
    
    public function userStudyinUkUpdate($user_id,$file1,$file2){
        $data = array(
        'visa'=>$file1,
        'visa_letter'=>$file2
        );
        $this->db->where('user_id',$user_id);
        $this->db->update('users',$data);
        return $this->db->affected_rows();
    }

    public function applyJob($resume){
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'job_id' => $this->input->post('job_id'),
            'resume_file' => $resume
        );
        $this->db->insert('job_apply', $data);
        return $this->db->insert_id(); 
    }

    public function applicationSupport(){
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'university_id' => $this->input->post('university_id'),
            'school_name' => $this->input->post('school_name'),
            'city_id' => $this->input->post('city_id'),
            'month' => $this->input->post('month'),
            'year' => $this->input->post('year'),
            'country_from' => $this->input->post('country_from'),
            'country_now' => $this->input->post('country_now'),
            'study' => $this->input->post('study'),
            'qualification' => $this->input->post('qualification'),
            'passport' => $this->input->post('passport'),
            'consent' => $this->input->post('consent')
        );
        $this->db->insert('application_support', $data);
        return $this->db->insert_id();
    }

    public function arrivalSupport(){
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'university_id' => $this->input->post('university_id'),
            'school_name' => $this->input->post('school_name'),
            'city_id' => $this->input->post('city_id'),
            'settled' => $this->input->post('settled'),
            'meet' => $this->input->post('meet'),
            'guardianship' => $this->input->post('guardianship'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'airport' => $this->input->post('airport'),
            'terminal' => $this->input->post('terminal'),
            'flight_number' => $this->input->post('flight_number')
        );
        $this->db->insert('arrival_support', $data);
        return $this->db->insert_id();
    }

    public function visaSupport(){
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'university_id' => $this->input->post('university_id'),
            'school_name' => $this->input->post('school_name'),
            'city_id' => $this->input->post('city_id'),
            'month' => $this->input->post('month'),
            'year' => $this->input->post('year'),
            'fees' => $this->input->post('fees'),
            'cas_letter' => $this->input->post('cas_letter'),
            'apply' => $this->input->post('apply')
        );
        $this->db->insert('visa_support', $data);
        return $this->db->insert_id();
    }

    public function getAllNotification($user_id) {
        $query = $this->db->get_where('notification', ['user_id' => $user_id]);
        return $query->result_array();
    }

    public function getTokenByUserId($user_id) {
        $query = $this->db->get_where('token', ['user_id' => $user_id]);
        return $query->row_array();
    }

    public function addNotificationMessage($title, $body, $user_id) {
        $data = array(
            'title' => $title,
            'body' => $body,
            'user_id' => $user_id
        );
        $this->db->insert('notification', $data);
        return $this->db->insert_id();
    }

    public function getAllTokenId() {
        $this->db->distinct();
        $this->db->select('token_id');
        $this->db->from('token');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function getFavourite($university_id,$user_id){
       $this->db->select('*');
        $this->db->from('interest');
        $this->db->where('user_id',$user_id);
        $this->db->where('university_id',$university_id);
        $sel = $this->db->get();
        return $sel->row_array();
    }
    
    public function insertToken(){
        $data = array(
        'user_id'=> $this->input->post('user_id'),
        'token_id'=> $this->input->post('token_id'),
        'created'=> date('y-m-d h:i:s')
        );
        $this->db->insert('token',$data);
        return $this->db->insert_id();
    }
    
    public function getNotificationLists($user_id){
        $sel = $this->db->get_where('notification',['user_id'=>$user_id]);
        return $sel->result_array();
    }
    
    public function logout(){
     $this->db->where('user_id',$this->input->post('user_id'));
     $this->db->where('token_id',$this->input->post('token_id'));
     $this->db->update('token',['status'=>'0']);
     return $this->db->affected_rows();   
        
    }
    
    public function getimage($university_id){
        $this->db->select('*');
        $this->db->from('university_images');
        $this->db->where('university_id',$university_id);
        $sel = $this->db->get();
        return $sel->row_array();
    }
    
}
?>