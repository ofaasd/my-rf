<?php
Class User_model extends CI_Model{
    public $name;
    public $username;
    public $password;
    public $email;
    public $roles;

    public function verification(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $query = $this->db->where(['username'=>$username,'password'=>$password])->get('users');
        if($query->num_rows() > 0){
            $user = $query->row();
            $this->session->set_userdata(array(
               'nama' => $user->name,
               'email' => $user->email,
               'id' => $user->id,
               'roles' => $user->roles,
            ));
            return true;
        }else{
            return false;
        }

    }
    public function register(){
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'created_at' => date('Y-m-d H:i:s'),
        );
        $query = $this->db->insert('users',$data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
	public function register_admin(){
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'roles' => $this->input->post('roles'),
            'password' => md5($this->input->post('password')),
            'created_at' => date('Y-m-d H:i:s'),
        );
        $query = $this->db->insert('users',$data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    public function check_username($username){
        $query = $this->db->where("username",$username)->get('users');
        if($query->num_rows() > 0){
            return false;
        }else{
            return true;
        }
    }
    public function check_email($email){
        $query = $this->db->where("email",$email)->get('users');
        if($query->num_rows() > 0){
            return false;
        }else{
            return true;
        }
    }
	public function get_all()
    {
            $query = $this->db->get('users');
            return $query->result();
    }
	
	public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('users');
            return $query->row();
    }
    public function insert(){
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'roles' => $this->input->post('roles'),
            'password' => md5($this->input->post('password')),
            'created_at' => date('Y-m-d H:i:s'),
        );
        $query = $this->db->insert('users',$data);
        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function update(){
        $data = array(
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
			'roles' => $this->input->post('roles'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if($this->db->update('users', $data, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }
	public function update_password(){
		$data = array(
            'password' => md5($this->input->post('password')),
            'updated_at' => date('Y-m-d H:i:s'),
        );
		if($this->db->update('users', $data, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
	}

    public function delete($id)
    {
        if($this->db->delete('users', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}