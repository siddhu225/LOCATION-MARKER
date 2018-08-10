

<?php

class User extends CI_Controller {

public function __construct(){

        parent::__construct();
  			$this->load->helper('url');
  	 		$this->load->model('user_model');
        $this->load->library('session');


}

public function index()
{
$this->load->view("register.php");
}

public function register_user(){

      $user=array(
      'user_name'=>$this->input->post('user_name'),
      'user_email'=>$this->input->post('user_email'),
      'user_password'=>($this->input->post('user_password')),
      'user_age'=>$this->input->post('user_age'),
      'user_mobile'=>$this->input->post('user_mobile')
        );
        print_r($user);

$email_check=$this->user_model->email_check($user['user_email']);

if($email_check){
  $this->user_model->register_user($user);
  $this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
  redirect('user/login_view');

}
else{

  $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
  redirect('user');


}

}

public function login_view(){

$this->load->view("login.php");

}

function login_user(){
  $user_login=array(

  'user_email'=>$this->input->post('user_email'),
  'user_password'=>md5($this->input->post('user_password'))

    );



    $data=$this->user_model->login_user($user_login['user_email'],$user_login['user_password']);
      if($data)
      {
      $this->session->set_flashdata('success_msg', 'login was successful.');


      $this->session->set_userdata('user', $this->input->post('user_email'));

      redirect('user/maps_view');

      }
      else{
        $this->session->set_flashdata('error_msg', 'Error occured,Try again.');
        $this->load->view("login.php");

      }



}

public function maps_view(){
  if($this->session->userdata('user')){
    $this->session->unset_userdata('user');
    $this->load->model('User_model');
    $data['coords'] = $this->User_model->getCoords();
    // $this->load->view('maps', $data);
    $this->load->view("maps.php",$data);
  }else{
      $this->load->view("login.php");
  }

}

public function maps_user(){

  $con=array(
  'lat' =>$this->input->post('lat'),
  'lng' =>$this->input->post('lng')
);
$this->load->model('User_model');
$this->User_model->maps_user($con);
echo json_encode( $con );


}



public function user_logout(){

  $this->session->sess_destroy();
  $this->session->unset_userdata('user');
  redirect('user/login_view', 'refresh');
}

}

?>
