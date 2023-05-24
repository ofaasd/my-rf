<?php
Class Bukatutup_model extends CI_Model{
    public $status;

    public function get_all()
    {
            $query = $this->db->get('tb_bukatutup');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('tb_bukatutup');
            return $query->row();
    }
	public function get_bukatutup(){
		$query = $this->db->order_by("id","desc")->limit('1')->get('tb_bukatutup');
		return $query->row();
	}
    
    public function insert(){
		$bukatutup = $this->get_bukatutup();
        $this->status = 0;
		if($bukatutup->status == 0){
			$this->status = 1;
		}
		$data = array(
			'status'=>$this->status,
		);
        if($this->db->insert('tb_bukatutup',$this)){
            return true;
        }else{
            return false;
        }
        
    }

    public function update(){
        $this->status = $_POST['status'];

        if($this->db->update('tb_bukatutup', $this, array('id' => $_POST['id']))){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id)
    {
        if($this->db->delete('tb_bukatutup', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}