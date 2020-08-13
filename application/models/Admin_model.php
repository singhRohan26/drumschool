<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	/**
	 * Admin  Model.
	 * Created By Rajat Agarwal
	 
	 */

	public function checkLogin() {
        $data = array(
            'email' => $this->security->xss_clean($this->input->post('email')),
            'password' => $this->security->xss_clean(hash('sha256', $this->input->post('password')))
        );
        $query = $this->db->get_where('admin', $data);
        return $query->row_array();
    }


    public function getLoginDetail($email){
        $query = $this->db->get_where('admin', ['email' => $email]);
        return $query->row_array();
    }
    public function doChangePass(){
        $data = array(
            'password' => $this->security->xss_clean(hash('sha256', $this->input->post('npass')))
        );
        $this->db->update('admin', $data);
        return $this->db->affected_rows();
    }

    public function getEmailId(){
        $query = $this->db->get_where('admin', ['email' => $this->security->xss_clean($this->input->post('email'))]);
        return $query->row_array();
    }

    public function updatePassword($password){
        $data = array(
            'password' => $this->security->xss_clean(hash('sha256', $password))
        );
        $this->db->update('admin', $data);
        return $this->db->affected_rows();
    }

    public function getUserDetail($email) {
        $query = $this->db->get_where('admin', ['email' => $email]);
        return $query->row_array();
    }

    public function doUpdateProfile($email, $image_url) {
        $data = array(
            'name' => $this->security->xss_clean($this->input->post('name')),
            'address' => $this->security->xss_clean($this->input->post('address')),
            'phone' => $this->security->xss_clean($this->input->post('phone')),
            'description' => $this->security->xss_clean($this->input->post('description')),
            'region' => $this->security->xss_clean($this->input->post('region')),
            'image_url' => $image_url
        );
        $this->db->update('admin', $data, ['email' => $email]);
        return $this->db->affected_rows();
    }

    public function doUpdateSettings($id) {
        $data = array(
            'description' => $this->security->xss_clean($this->input->post('description')),
            'title' => $this->security->xss_clean($this->input->post('title'))
        );
        $this->db->update('site_settings', $data, ['id' => $id]);
        $this->db->select('title');
        $this->db->from('site_settings');
        $this->db->where('id', $id);
        $result = $this->db->get();
        return $result->row_array();
    }

    public function doAddFaq() {
        $data = array(
            'question' => $this->security->xss_clean($this->input->post('question')),
            'answer' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->insert('faq', $data);
        return $this->db->insert_id();
    }

    public function doUpdateFaq($id) {
        $data = array(
            'question' => $this->security->xss_clean($this->input->post('question')),
            'answer' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->update('faq', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getAllSiteSettings(){
        $query = $this->db->get('site_settings');
        return $query->result_array();
    }

    public function getAllBanners(){
        $query = $this->db->get('banner');
        return $query->result_array();
    }

    public function getAllFaqs(){
        $this->db->select('*');
        $this->db->from('faq');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSettingsById($setting_id){
        $query = $this->db->get_where('site_settings', ['id' => $setting_id]);
        return $query->row_array();
    }

    public function get_walkthrough_by_id($walkthrough_id){
        $query = $this->db->get_where('walkthrough', ['walkthrough_id' => $walkthrough_id]);
        return $query->row_array();
    }

    public function getFaqById($faq_id){
        $query = $this->db->get_where('faq', ['id' => $faq_id]);
        return $query->row_array();
    }

    public function getUsersCount(){
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    public function getUsersInterestCount(){
        $query = $this->db->get('interest');
        return $query->num_rows();
    }

    public function do_add_banner($image_url){
        $data = array(
            'image_url' => $image_url
        );
        $this->db->insert('banner', $data);
        return $this->db->insert_id();
    }

    public function do_delete_banner($banner_id){
        $this->db->delete('banner', ['banner_id' => $banner_id]);
        return $this->db->affected_rows();
    }

    public function getAllWalkthroughs(){
        $query = $this->db->get('walkthrough');
        return $query->result_array();
    }

    public function getAllUsers(){
        $this->db->select('u.*, c.name as cname');
        $this->db->from('users u');
        $this->db->join('countries c', 'c.id = u.country_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllUsersNotifications(){
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->order_by('user_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getTokenIdByUser_id($user_id) {
        $query = $this->db->get_where('token', ['user_id' => $user_id]);
        return $query->row_array();
    }

    public function addNotification($title, $body, $user_id) {
        $data = array(
            'title' => $title,
            'body' => $body,
            'user_id' => $user_id
        );
        $this->db->insert('notification', $data);
        return $this->db->insert_id();
    }

    public function getNotificationByUserId($user_id) {
        $query = $this->db->get_where('notification', ['user_id' => $user_id]);
        return $query->result_array();
    }

    public function getUserById($user_id) {
        $query = $this->db->get_where('users', ['user_id' => $user_id]);
        return $query->row_array();
    }

    public function getAllUsersLibrary(){
        $this->db->select('u.*, j.*, ja.*, c.name as cname');
        $this->db->from('job_apply ja');
        $this->db->join('job j', 'j.job_id = ja.job_id');
        $this->db->join('users u', 'u.user_id = ja.user_id');
        $this->db->join('countries c', 'c.id = u.country_id');
        $this->db->order_by('ja.job_apply_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getJobApplyData($job_apply_id){
        $this->db->select('u.*, j.*, ja.*, c.name as cname, cit.name as citname, s.name as sname, e.experience, et.employee_type, it.industry_type');
        $this->db->from('job_apply ja');
        $this->db->join('job j', 'j.job_id = ja.job_id');
        $this->db->join('users u', 'u.user_id = ja.user_id');
        $this->db->join('countries c', 'c.id = j.country_id');
        $this->db->join('cities cit', 'cit.id = j.city_id');
        $this->db->join('states s', 's.id = j.state_id');
        $this->db->join('experience e', 'e.experience_id = j.experience_id');
        $this->db->join('employee_type et', 'et.employee_type_id = j.employee_type_id');
        $this->db->join('industry_type it', 'it.industry_type_id = j.industry_type_id');
        $this->db->where('ja.job_apply_id', $job_apply_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_user_by_id($id){
        $this->db->select('users.name, users.payment_status');
        $this->db->from('users');
        $this->db->where('users.user_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function change_account_status($id, $status){
        $this->db->update('users', ['payment_status' => $status], ['user_id' => $id]);
        return $this->db->affected_rows();
    }

    public function do_add_walkthrough($image_url){
        $data = array(
            'image_url' => $image_url,
            'title' => $this->security->xss_clean($this->input->post('title')),
            'text' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->insert('walkthrough', $data);
        return $this->db->insert_id();
    }

    public function do_edit_walkthrough($id,$image_url){
        $data = array(
            'image_url' => $image_url,
            'title' => $this->security->xss_clean($this->input->post('title')),
            'text' => $this->security->xss_clean($this->input->post('description'))
        );
        $this->db->update('walkthrough', $data, ['walkthrough_id' => $id]);
        return $this->db->affected_rows();
    }
}
