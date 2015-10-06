<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MX_Controller {

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
         public function __construct() {
            parent::__construct();
            $this->load->library('form_validation');   
            $this->load->database();
            $this->load->helper(array('form', 'url'));
        }
         
	public function index()
	{
            if(!$this->session->userdata('islogin'))
            {
                $this->load->view('login');
            }
            else
            {
                $this->load->view('profile');
            }
	}
        
        public function xuly()
        {
            $this->form_validation->set_rules('username','Username','trim|required');
            $this->form_validation->set_rules('password','Password','trim|required');
            if($this->form_validation->run() != FALSE)
            {
                $username = $this->input->post('username');
                $password = md5($this->input->post('password'));
                $q = $this->db->query("select * from user where username = '$username' and password = '$password'");
                if($q->num_rows() == 1)
                {
                    $user = $q->row();
                    $this->session->set_userdata('islogin',1);
                    $this->session->set_userdata('id',$user->id);
                    $this->session->set_userdata('username',$user->username);
                    $this->session->set_userdata('permission',$user->permission);
                    //$this->load->view('profile');
                  redirect(base_url().'index.php/log/log/profile', 'location');
                }
                else {
                    $data['error'] = 'Invalid username or password.';
                    $this->load->view('login',$data);
                }
            }
            else
            {
                $this->load->view('login');
            }
        }
        
        public function profile()
        {
            if(!$this->session->userdata('islogin'))
            {
                redirect(base_url().'index.php/log/log/index', 'location');
            }
            else
            {
                $this->load->view('profile');
            }
        }
        
        
        public function xulyuser()
        {
                    if($this->input->post('delete'))
                    {
                        $username = $this->input->post('username');
                        $q = $this->db->query("select * from user where username='$username'");
                        if($q->num_rows() == 1)
                        {
                            $this->db->where('username', $username);
                            $this->db->delete('user'); 
                            redirect(base_url().'index.php/log/manage', 'location');
                        }
                    }
        }
        
        public function logout()
        {
            $this->session->sess_destroy();
            redirect(base_url().'index.php/log/log', 'location');
        }
        
        public function manage()
        {
            if(!$this->session->userdata('islogin'))
            {
                $this->load->view('login');
            }
            else {
                if($this->session->userdata('permission')!=1)
                {
                    redirect(base_url().'index.php/log/log/profile', 'location');
                }
                else
                {
                    $username = $this->session->userdata('username');
                    $q = $this->db->query("select * from user where username <> '$username'");
                    $data['list'] = $q->result_array();
                    $data['sub'] = $this->load->view('manage',$data,true);
                    $this->load->view('profile',$data);
                }
            }
        }
        
        
        
        public function eod($id)
        {
            if(!$this->session->userdata('islogin'))
            {
                $this->load->view('login');
            }
            else {
                if($this->session->userdata('permission')!=1)
                {
                    redirect(base_url().'index.php/log/log/profile', 'location');
                }
                else
                {
                    $username = $this->session->userdata('username');
                    $sid= $this->session->userdata('id');
                    $q = $this->db->query("select * from user where id='$id' and id <> '$sid'");
                    if($q->num_rows()!=1)
                    {
                        redirect(base_url().'index.php/log/log/manage', 'location');
                    }
                    else {
                        $user = $q->row();
                        $data['username'] = $user->username;
                        $data['email'] = $user->email;
                        $data['sub'] = $this->load->view('eod',$data,true);
                        $this->load->view('profile',$data);
                        
                    }
                }
            }
        }
        
        public function create()
        {
            if(!$this->session->userdata('islogin'))
            {
                $this->load->view('login');
            }
            else
            {
                if($this->input->post('create'))
                {
                    $this->form_validation->set_rules('username','Username','trim|required');
                    $this->form_validation->set_rules('password','Password','trim|required');
                    $this->form_validation->set_rules('email','Email','trim|required|valid_email');
                    if($this->form_validation->run()==FALSE)
                    {
                        $data['sub'] = $this->load->view('create','',true);
                        $this->load->view('profile',$data);
                    }
                    else
                    {
                        $username = $this->input->post('username');
                        $email = $this->input->post('email');
                        $password = md5($this->input->post('password'));
                        
                        $q = $this->db->query("select * from user where username='$username' or email='$email'");
                        if($q->num_rows() == 1)
                        {
                            $data['error'] = 'Username or email has been used';
                        }
                        else
                        {
                                $add = array(
                                    'username' => $username,
                                    'password' => $password,
                                    'email' => $email,
                                    'permission' => 0
                                );
                                
                                $this->db->insert('user',$add);
                                $data['error'] = 'Complete.';
                        }
                        $data['sub'] = $this->load->view('create',$data,true);
                        $this->load->view('profile',$data);
                    }
                }
                else
                {
                    $data['sub'] = $this->load->view('create','',true);
                    $this->load->view('profile',$data);
                }
            }
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
