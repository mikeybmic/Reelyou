<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

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
    public $model;
    public $curUser;

    function __construct() {
        parent::__construct();
		check_session();
        $this->model = load_basic_model('profile');
        $this->curUser = currentuser_session();
    }

    public function index() {
		check_session();
        $curUser = currentuser_session();
        $userId = $curUser['user_id'];

        $data['relation'] = "";
        if ($this->input->get('id')) {
            $userId = $this->input->get('id');

//		VISITING USER ID
            $data['v_userID'] = $userId;
            $data['curUserId'] = $curUser['user_id'];

//            check relation
            $curUserId = $curUser['user_id'];
            $userModel = model_load_model('User_model');
            $relation = $userModel->check_relation($curUserId, $userId);
            $data['relation'] = $relation['confirm'];
        }


        $model = model_load_model('Profile_model');
        $data['profileData'] = $model->getUserInfo($userId);

        //POSTS
        $postsModel = model_load_model('Posts_model');
        $data['posts'] = $postsModel->getPosts($userId);

//        CONNECTIONS
        $userModel = model_load_model('User_model');
        $data['users'] = $userModel->get_users($userId);

//        RECENT ACTIVITY
        $userModel = model_load_model('User_model');
        $data['recentActivities'] = $userModel->recent_activity($userId);

//        FEELING
        $data['feeling'] = $curUser['feeling'];

        render_view('profile', $data);
    }

    public function get_connected() {

        $curUser = currentuser_session();
        $userId = $curUser['user_id'];
		$postsModel = model_load_model('Posts_model');
        $data['posts'] = $postsModel->getPosts($userId);
        $userModel = model_load_model('User_model');
        $data['users'] = $userModel->get_users($userId);
		$data['recentActivities'] = $userModel->recent_activity($userId);
        render_view('get-connected.php', $data);
    }

    public function inspiration_board() {
        
		$this->form_validation->set_rules('background','background','required');
		$this->form_validation->set_rules('quote','quote','required');	
	
		if($this->form_validation->run()==false)
		{
		
		
		
		$service_url     = 'http://quotes.rest/qod.json?category=inspire';
        $curl            = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response   = curl_exec($curl);
        curl_close($curl);
        $json_objekat    = json_decode($curl_response);
		if(isset($json_objekat->error)){
		$data['error']	=	$json_objekat->error->message;
		}else{
		
        $quotes          = $json_objekat->contents->quotes;
		$data['quotes']  = $quotes ;
		}
		
        render_view('inspiration-board', $data);
		
		
		}else{
		$curUser = currentuser_session();
		$data['user_id']	=	$curUser['user_id'];
		$data['title']		=	$this->input->post('quote');
		$data['post_type']	=	3;
		$detail['post_id']	=	$this->Profile_model->insert_array('posts',$data);
		$detail['content']	=	$this->input->post('background');
		$this->Profile_model->insert_array('post_data',$detail);
		
		header('location:'.base_url().'profile/timeline');
		
		
		
		
		
		
		
			
		}
    }

   
	
	
	public function update_notification(){
	
		$data['seen']	=	1;
        $curUser = currentuser_session();
		$this->Profile_model->update_array(array('user_id' => $curUser['user_id']),'tag_comments',$data);
		exit;	
		
	}

    public function left_menu_notifications() {

//        $CI = get_instance();
        $curUser = currentuser_session();
        $userId = $curUser['user_id'];
        //get new notifications
        $model = model_load_model('User_model');
        $notifications = $model->get_notifications($userId);

//TAGING
        $tagNotification = $model->get_tag_notifications();
        $tagCommentsNotification = $model->get_comments_tag_notifications();
		
		$tag_total	=	count($tagNotification)+count($tagCommentsNotification);

//MESSAGES
        $pmModel = model_load_model('Pm_model');
        $msgNotification = $pmModel->get_messages_notifications();

?>

							
                                <li>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" type="button" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/images/user-icon.png" alt="" title=""><?php if(count($notifications)>0){?><span><?php echo count($notifications);?></span> <?php }?></a>
                                        
                                        <?php if ($notifications) {?>
                                        <ul class="dropdown-menu">
                                        	<?php foreach ($notifications as $n) { ?>
                                            <li>
                                                <div class="user-thumbnail">
                                                    <a href="<?php echo base_url()?>profile/user_profile/<?php echo $n['user_id']?>"><img  width="28px" height="28px" src="<?php echo $img = (!empty($n['profile_image'])) ? base_url()."assets/images/profile_images/".$n['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="" ></a>
                                                </div>
                                                <div class="user-detail">
                                                    <a href="<?php echo base_url()?>profile/user_profile/<?php echo $n['user_id']?>" class="username"><?php echo $n['first_name'].'&nbsp;'.$n['last_name']; ?></a>
                                                    <ul>
                                                        <li><a href="javascript:void(0)" class="reply-request" con="<?php echo $n['ID']; ?>" action="confirm">Confirm</a></li>
                                                        <li><a href="javascript:void(0)" class="reply-request" con="<?php echo $n['ID']; ?>" action="reject">Cancel Request</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php } ?> 
                                       
                                        </ul>
                                        
                                        <?php }else{?>
                                         <ul class="dropdown-menu">
                                          <li class="no-more">No Pending Request</li>
                                         </ul>
                                         <?php }?>
                                        
                                    </div>
                                </li>
                                <li onClick="update_notification();">
                                	<div class="dropdown">
                                    <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/images/bell-icon.png" alt="" title=""><?php if($tag_total>0){?><span id="not_total"><?php echo $tag_total?></span> <?php }?></a>
                                    <?php if ($tagNotification || $tagCommentsNotification) { ?>
                                    
                                    <ul class="dropdown-menu">
                                    <?php foreach ($tagNotification as $tn) { 
									
				$profile_pic	=	$this->Profile_model->get_signle_value(array('user_id'=>$tn['user_id']),'profile_image','profile');
				$user_name		=	$this->Profile_model->get_signle_value(array('user_id'=>$tn['user_id']),'first_name','users');
									?>
                                            <li>
                                                <div class="media">
                                                    <a class="pull-left" href="#">
                                               <img class="img-circle" width="16px" height="16px" src="<?php echo base_url()?>assets/images/profile_images/<?php echo $profile_pic?>" class="img-circle" />
                                                    </a>
                                                    <div class="media-body">
                                                        <p class="name"><b><?php echo substr($user_name, 0, 6); ?></b></p>
                                                        <p><?php echo $tn['title']; ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                      <?php }
                                       foreach ($tagCommentsNotification as $tcn) {
										   
				$profile_pic	=	$this->Profile_model->get_signle_value(array('user_id'=>$tcn['user_id']),'profile_image','profile');
				$user_name		=	$this->Profile_model->get_signle_value(array('user_id'=>$tcn['user_id']),'first_name','users');
											?>
											<li>
                                                <div class="media">
                                                    <a class="pull-left" href="<?php echo base_url('Posts/view_post?id='.$tcn['post_id']); ?>">
                                               <img class="img-circle" width="16px" height="16px"  src="<?php echo base_url()?>assets/images/profile_images/<?php echo $profile_pic?>" class="img-circle" />
                                                    </a>
                                                    <div class="media-body">
                                                        <p class="name"><b><?php echo substr($user_name, 0, 6); ?></b></p>
                                                        <p>Comment:<?php echo substr($tcn['message'], 0, 50); ?></p>
                                                    </div>
                                                </div>
                                            </li>
										<?php } ?>
                                        </ul>
                                    
                            
                                    <?php }else{?>
                                    <ul class="dropdown-menu">
                                     <li class="no-more">No Notifications</li>
                                    </ul>
                                    
                                    <?php }?>
                                    </div>
                                </li>
                                <li>
                                <div class="dropdown">
                                    <a href="#" type="button" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>assets/images/mail-icon.png" alt="" title=""><?php if(count($msgNotification)>0){?><span><?php echo count($msgNotification)?></span><?php }?></a>
                                     <?php if ($msgNotification) { ?>
                                    <ul class="dropdown-menu">
                                     <?php foreach ($msgNotification as $mn) {    ?>
                                        <li>
                                            <div class="user-thumbnail">
                                                <img class="img-circle" width="16px" height="16px"  src="<?php echo $img = (!empty($mn['profile_image'])) ? base_url()."assets/images/profile_images/".$mn['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="" >
                                            </div>
                                            <div class="msg-body"><a href="<?php echo base_url('Pm/thread?i='.$mn['privmsg_author']); ?>"><?php echo substr($mn['privmsg_body'],0,20); ?></a></div>
                                        </li>
                                    <?php } ?>
                                    	<li>
                                        <a href="<?php echo base_url('Pm'); ?>" >View All Messages</a>
                                    	</li>
                                     </ul>
                                     <?php }else{?>
                                      <ul class="dropdown-menu">
                                            <li class="no-more">No New Message</li>
                                            <li class="no-more"><a href="<?php echo base_url('Pm'); ?>" >View All Messages</a></li>
                                      </ul>
                                     
                                     <?php }?>
                                     
                                    </div>
                                </li>
                                <li class="logout">
                                    <a href="<?php echo base_url()?>logout">
									Log Out</a>
                                </li>
<?php exit;                        
        if ($notifications) {
            ?>
            <!--notifications-->
            <div class="notification-detail">
                <ul>
                    <?php foreach ($notifications as $n) { ?>
                        <li>
                            <div class="user-thumbnail">
                                <a href="#"><img src="<?php echo $img = (!empty($n['profile_image'])) ? base_url()."assets/images/profile_images/".$n['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="" ></a>
                            </div>
                            <div class="user-detail">
                                <a href="#" class="username"><?php echo $n['first_name'].'&nbsp;'.$n['last_name']; ?></a>
                                <ul>
                                    <li><a href="javascript:void(0)" class="reply-request" con="<?php echo $n['ID']; ?>" action="confirm">Confirm</a></li>
                                    <li><a href="javascript:void(0)" class="reply-request" con="<?php echo $n['ID']; ?>" action="reject">Cancel Request</a></li>
                                </ul>
                            </div>
                        </li>
                    <?php } ?> 
                </ul>
            </div>
            <?php
        }
        else {
            ?>
            <div class="notification-detail no-notification">
                <ul>
                    <li class="no-more">No Pending Request</li>
                </ul>
            </div>
        <?php } ?>
        <!--end notifications-->

        <!--TAG notifications-->
        <?php if ($tagNotification || $tagCommentsNotification) { ?>
            <div class="tag-notification-detail">
                <ul>
                    <?php foreach ($tagNotification as $tn) { ?>
                        <li>
                            <a href="<?php echo base_url('Posts/view_post?id='.$tn['post_id']); ?>"><?php echo $tn['title']; ?></a>
                        </li>
                        <?php
                    }
                    foreach ($tagCommentsNotification as $tcn) {
                        ?>
                        <li>
                            <a href="<?php echo base_url('Posts/view_post?id='.$tcn['post_id']); ?>"><?php echo substr($tcn['comment_body'], 0, 50); ?></a>
                        </li>
                    <?php } ?> 
                </ul>
            </div>
            <?php
        }
        else {
            ?>
            <div class="tag-notification-detail no-notification">
                <ul>
                    <li class="no-more">No notifications</li>
                </ul>
            </div>
        <?php } ?>

        <!--messages notifications-->
        <?php if ($msgNotification) { ?>
            <div class="msg-notification-detail">
                <ul>
                    <?php foreach ($msgNotification as $mn) {    ?>
                        <li>
                            <div class="user-thumbnail">
                                <img src="<?php echo $img = (!empty($mn['profile_image'])) ? base_url()."assets/images/profile_images/".$mn['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="" >
                            </div>
                            <div class="msg-body"><a href="<?php echo base_url('Pm/thread?i='.$mn['privmsg_author']); ?>"><?php echo substr($mn['privmsg_body'],0,20); ?></a></div>
                        </li>
                    <?php } ?>
                    <li class="no-more">
                        <a href="<?php echo base_url('Pm'); ?>" >All Messages</a>
                    </li>
                </ul>
            </div>
            <?php
        }
        else {
            ?>
            <div class="msg-notification-detail no-notification">
                <ul>
                    <li class="no-more">No notifications</li>
                    <li class="no-more">
                        <a href="<?php echo base_url('Pm'); ?>" >All Messages</a>
                    </li>
                </ul>
            </div>
        <?php } ?>
        <!--end TAG notifications-->
        
        <div class="user-action">
            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/images/users-icon.png" class="tagNotification" alt="" title="You are tagged by">
                <?php if ($notifications) { ?>
                    <span></span>
                <?php } ?>
            </a>
            <a href="javascript:void(0)" class="msg-notification"><img src="<?php echo base_url(); ?>assets/images/message-icon.png" alt="" title="">
            <?php if ($msgNotification) { ?>
                    <span></span>
                <?php } ?>
            </a>
            <a href="javascript:void(0)" class="settings"><img src="<?php echo base_url(); ?>assets/images/setting-icon.png" alt="" title=""></a>
            <a href="javascript:void(0)" class="notification">
                <img src="<?php echo base_url(); ?>assets/images/notification-icon.png" alt="" title="">
                <?php if ($tagNotification || $tagCommentsNotification) { ?>
                    <span></span>
                <?php } ?>
            </a>
        </div>
        <?php
    }

}
