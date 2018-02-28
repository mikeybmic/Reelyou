<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        public $data;
 	public function __construct()
	{//Core controller constructor
	    parent::__construct();
	    $this->load->model('ektreemodel');
               
				
	}
	public function index()
	{
                $data['img']='Tulips.jpg';
		$this->load->view('cropimage',$data);
	}
        public function cropimage()
        {
        $res['img']=$this->ektreemodel->upload_image();
        $this->load->view("cropimage",$res);

		
        }
        public function updatecropimage()
        {
           // echo $x=$this->input->post('x_axis');
            $img['imgpath']=$this->ektreemodel->upload_thumbnail();
            echo $img=$img['imgpath'];
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */