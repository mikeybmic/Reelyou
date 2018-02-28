<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $CI = & get_instance();
        $currentUser = $CI->session->userdata("currentUser");
        $currentUser['loggedIn'] = $CI->session->userdata("loggedIn");
        if ($currentUser['loggedIn'] == TRUE) {
            redirect(base_url('Profile/timeline'));
        }
        else {
            return TRUE;
        }
    }

    public function index() {
        $data['first_name'] = '';
        $data['last_name'] = '';
        $data['user_email'] = '';
        $data['password'] = '';
        $data['passconf'] = '';
		$data['check_login'] = 1;
        render_view('login', $data, $header = array('loginPage' => TRUE));
    }
	
	 public function process_login() {
//     echo '<pre>';
//     print_r($this->db);exit;
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $where_user = array(
            'user_email' => $email,
            'password' => md5($password),
            'user_status' => '1'
        );
        $basicModal = load_basic_model('users');

        $result = $basicModal->get($where_user, 1);

        $loggedIn = FALSE;
        if (array_filter($result)) {
            $currentUserData = array(
                'user_id' => $result['user_id'],
                'first_name' => $result['first_name'],
                'last_name' => $result['last_name'],
                'user_email' => $result['user_email'],
                'user_role' => $result['user_role'],
                'feeling' => '2'
            );
            $loggedIn = true;
            $session_data = array(
                "currentUser" => $currentUserData,
                'loggedIn' => $loggedIn
            );
            $this->session->set_userdata($session_data);
//CHECK ASSESMENT
            $userModel = model_load_model('User_model');
            $userAssesment = $userModel->getUserAssesment();
//            print_r($userAssesment);exit;
            if ($userAssesment['assesment'] == 1) {
                redirect(base_url('Profile/timeline'));
            }
            else {
                $this->session->set_flashdata('error', 'Complete assesment first to activate your account.');
                $model = model_load_model('profile_model');
                $data['states'] = $model->getStates();
                $data['assesment'] = 0;
                $data['assesmentData'] = array(
                    'state' => "",
                    'city' => "",
                    'zip' => "",
                    'interest' => "",
                    'dob' => "",
                    'profession' => "",
                    'looking_to' => ""
                );
                render_view('assesment.php', $data);
            }
        }
        else {

            $status   =  $this->Profile_model->get_signle_value(array('user_email'=>$email),'user_status','users');
            if($status==0){
              $this->session->set_flashdata('error', 'Please activate your account first <a href="'.base_url().'login/reactivate_link">Resent activation link</a>');   
          }else{
              $this->session->set_flashdata('error', 'Username/password incorrect or inactive user.');
          }
           
            redirect(base_url('Login'));
        }
    }

     public function register() {
        $allPost = $this->input->post(NULL, TRUE);
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($allPost) {
            $data['first_name'] = $allPost['first_name'];
            $data['last_name'] = $allPost['last_name'];
            $data['user_email'] = $allPost['user_email'];
            $data['password'] = $allPost['password'];
            $data['passconf'] = $allPost['passconf'];
        }
        else {
            $data['first_name'] = '';
            $data['last_name'] = '';
            $data['user_email'] = '';
            $data['password'] = '';
            $data['passconf'] = '';
        }
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[users.user_email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
			
            render_view('login', $data);
            return;
        }
        else {
            $password = $allPost['password'];
            $allPost['password'] = md5($allPost['password']);
            unset($allPost['passconf']);
            $basicModel = load_basic_model('users');
            $result = $basicModel->insert($allPost);
            $userId = $this->db->insert_id();


// email section

            $email_title = config_item('registration');

            $emailModel = load_basic_model('email_templates');
            $where_template = array(
                'template_title' => $email_title
            );

            $templateData = $emailModel->get($where_template, 1);

            $search = array(
                'LINK'
            );
            $email = $allPost['user_email'];
            $link = base_url('login/activate/?id='.$userId);

            $replace = array(
                $link
            );
            $templateBody = str_replace($search, $replace, $templateData['template_body']);
            $email_data = array(
                'from' => config_item('email_from'),
                'username' => config_item('mailer_name'),
                'subject' => $templateData['template_title'],
                'message' => $templateBody,
                'to' => $email
            );


// end email section
            $email_result = email_send($email_data);

            if ($result > 0 && $email_result == TRUE)
                $this->session->set_flashdata('success', 'Follow email sent to activate your account.');
            else if ($result > 0 && $email_result == FALSE)
                $this->session->set_flashdata('success', 'Email sending failed, ask admin to activate your account.');
            else if ($result < 1 && $email_result == FALSE)
                $this->session->set_flashdata('error', 'Operation Failed try again.');

            redirect(base_url('Login'));
        }
    }


   public function reactivate_link() {
    
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|callback_check_email');
         if ($this->form_validation->run() == false) {
            $data['user_email'] = '';
            $data['check_login'] = 1;
            render_view('reactivate_link', $data, $header = array('loginPage' => TRUE));
          }
        else {  

          $email = $this->input->post('user_email');
          $check = $this->Profile_model->select_where('user_id', 'users', array('user_email' => $email))->num_rows(); 
          if($check>0){ 
           
           $status   =  $this->Profile_model->get_signle_value(array('user_email'=>$email),'user_status','users');
           if($status==1){

            $this->session->set_flashdata('error', 'Your Account has already activated');
            redirect(base_url('login/reactivate_link'));
            exit;

           }else{

            $email_title = config_item('registration');
            $userId   =  $this->Profile_model->get_signle_value(array('user_email'=>$email),'user_id','users');
            $emailModel = load_basic_model('email_templates');
            $where_template = array(
                'template_title' => $email_title
            );

            $templateData = $emailModel->get($where_template, 1);

            $search = array(
                'LINK'
            );
            $link = base_url('login/activate/?id='.$userId);

            $replace = array(
                $link
            );
            $templateBody = str_replace($search, $replace, $templateData['template_body']);

            $email_data = array(
                'from' => config_item('email_from'),
                'username' => config_item('mailer_name'),
                'subject' => $templateData['template_title'],
                'message' => $templateBody,
                'to' => $email
            );


// end email section
            $email_result = email_send($email_data);

            if ($result > 0 && $email_result == TRUE)
                $this->session->set_flashdata('success', 'Follow email sent to activate your account.');
            else if ($result > 0 && $email_result == FALSE)
                $this->session->set_flashdata('success', 'Email sending failed, ask admin to activate your account.');
            else if ($result < 1 && $email_result == FALSE)
                $this->session->set_flashdata('error', 'Operation Failed try again.');

            redirect(base_url('login/reactivate_link'));
          
           }

        }else{

        $this->session->set_flashdata('error', 'You have not any account with this email');
        header('location:'.base_url().'login/reactivate_link');
        redirect(base_url('login/reactivate_link'));
        exit;

        }


           }

    }

	
	
	public function activate() {
        $userId = $this->input->get('id');


        $model = load_basic_model('users');
        $status   =  $this->Profile_model->get_signle_value(array('user_id'=>$userId),'user_status','users');

        if($status==1){
             $this->session->set_flashdata('error', 'Your account is already activated');
             redirect(base_url());

        }else{


        $result = $model->get(array('user_id' => $userId), 1);
        $array['user_status']    =   '1';
        $updateResult   =   $this->Profile_model->common_update('users','user_id',$userId,$array);
        

        $loggedIn = FALSE;

        if ($updateResult > 0 || $result['user_status'] == 'active') {

            $result = $model->get(array('user_id' => $userId), 1);

            $currentUserData = array(
                'user_id' => $result['user_id'],
                'first_name' => $result['first_name'],
                'last_name' => $result['last_name'],
                'user_email' => $result['user_email'],
                'user_role' => $result['user_role'],
				'feeling' =>'2'
            );

            $loggedIn = true;

            $session_data = array(
                "currentUser" => $currentUserData,
                'loggedIn' => $loggedIn
            );

            $this->session->set_userdata($session_data);

            $this->session->set_flashdata('success', 'Account activated successfully.');

            if ($updateResult < 1 && $result['user_status'] == 'active')
                $this->session->set_flashdata('success', 'Account already active.');

            redirect(base_url('profile/assesment'));
        } else {

            $this->session->set_flashdata('error', 'Some error occured while activation , please try again.');

            redirect(base_url());
        }

    }

    }
	
	
	public function forget_password() {
	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|callback_check_email');
		 if ($this->form_validation->run() == false) {
			$data['user_email'] = '';
			$data['check_login'] = 1;
			render_view('forget_password', $data, $header = array('loginPage' => TRUE));
		  }
        else {	
		 
		   $email = $this->input->post('user_email');
           $status   =  $this->Profile_model->get_signle_value(array('user_email'=>$email),'user_status','users');
           if($status==1){
		   $email_title = config_item('forget_password');
           $username   =  $this->Profile_model->get_signle_value(array('user_email'=>$email),'first_name','users');
            $emailModel = load_basic_model('email_templates');
            $where_template = array(
                'template_title' => $email_title
            );

            $templateData = $emailModel->get($where_template, 1);
			

            $search = array(
                'forget_password',
                'username'
            );

            
			$password	=	$this->generateRandomString(12);
            $replace = array(
                $password,
                $username
            );
            $templateBody = str_replace($search, $replace, $templateData['template_body']);
						
            $email_data = array(
                'from' => config_item('email_from'),
                'username' => config_item('mailer_name'),
                'subject' => $templateData['template_title'],
                'message' => $templateBody,
                'to' => $email
            );


// end email section
            $email_result = email_send($email_data);
			$array['password']	=	md5($password);
            $this->Profile_model->common_update('users','user_email',$email,$array);							
        	 $this->session->set_flashdata('error', 'Follow the email sent to get your password.');
        	 
             redirect(base_url('Login/forget_password'));
        	exit;

        }else{

          $this->session->set_flashdata('error', 'Please activate your account first <a href="'.base_url().'login/reactivate_link">Resent activation link</a>');   
          redirect(base_url('Login/forget_password'));   
        }
		
		}
		

	}
	
	function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	
	
	function check_email() {
        $this->load->library('form_validation');
        $email_address 		= $this->input->post('email_address');
        $oldemail_address   = $this->input->post('oldemail_address');
        $curUser = currentuser_session();
		if($oldemail_address==$email_address){
			return TRUE;
		}else{
		  $check = $this->Profile_model->select_where('user_id', 'users', array('user_email' => $email_address))->num_rows();	
		  
		  if($check>0){
			$this->form_validation->set_message('check_email', 'This email address already in use');
            return FALSE;  
		  }else{
			 return TRUE;  
		  }
			
		}
		
	
    }
	
	

}
