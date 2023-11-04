<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
		
        $this->load->model('Siswa_model','siswa');
		if(empty($this->session->userdata('pwd'))){
			$this->session->set_flashdata('error','Harap isi form ini terlebih dahulu');
			redirect(base_url('index.php/pembayaran/index_profile'));
		}

    }
	public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

	public function index()
	{
		$siswa = $this->siswa->get_by_ni($this->session->userdata('siswa_id'));
        $data['siswa'] = $this->db->where('no_induk',$siswa->no_induk)->get('santri_detail')->row();
		$data['provinsi'] = $this->db->get('provinces')->result();
		$data['prov_curr']  = $this->db->where('prov_id',$data['siswa']->provinsi)->get('provinces')->row();
		$data['kota'] = $this->db->where('prov_id',$data['siswa']->provinsi)->get('cities')->result();
		$data['kota_curr']  = $this->db->where('city_id',$data['siswa']->kabkota)->get('cities')->row();

		$data['photo'] = base_url('assets/images/user.png');
		if(!empty($data['siswa']->photo) && $data['siswa']->photo_location == "1" ){
			$data['photo'] = base_url('assets/upload/user/' . $data['siswa']->photo);
		}elseif(!empty($data['siswa']->photo) && $data['siswa']->photo_location == "2" ){
			echo "masuk sini";
			$data['photo'] = "https://manajemen.ppatq-rf.sch.id/assets/img/upload/photo/" . $data['siswa']->photo;
		}
        echo "<br />>";$data['siswa']->photo;
		echo $data['siswa']->photo_location;
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('profile/index',$data,true);


		$this->load->view('layouts/main',$var);
	}
	
	public function get_kota(){
		$id_provinsi = $this->input->post('prov_id');
		$kota = $this->db->where('prov_id',$id_provinsi)->get('cities')->result();
		foreach($kota as $row){
			echo '<option value="' . $row->city_id .'" ';
			echo '>' . $row->city_name . '</option>';
		
		}
	}
	public function simpan(){
		$id_santri = $this->input->post('no_induk');
		$santri = $this->db->where(['no_induk'=>$id_santri])->get("santri_detail")->row();
		$nama_santri = $santri->nama;
		$tanggal = date('YmdHis');

		$filename = $nama_santri . "-" . $tanggal;
        

		$config['upload_path']          = './assets/upload/user';
        $config['allowed_types']        = '*';
        $config['max_size']             = 10000;
        $config['file_name']            = $filename;

        $this->load->library('upload', $config);
		if($this->upload->do_upload('photo')){
			$data = $this->upload->data();
			$filename = $data['file_name'];

			$bukti = explode(".",$_FILES['photo']['name']);
        	$ext = end($bukti);

			if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' ){
				//Compress Image
				$config['image_library']='gd2';
				$config['source_image']='./assets/upload/user/'.$filename;
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '50%';
				$config['width']= 400;
				$config['height']= 400;
				$config['new_image']= './assets/upload/user/'.$filename;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}
			$data = array(
				'photo' => $filename,
				'photo_source' => 1,
			);
			$update = $this->db->update('santri_detail',$data,array('no_induk' => $this->input->post('no_induk')));
		}
		$update = $this->siswa->update_siswa_detail();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/profile/index'));
        }else{
            redirect(base_url('index.php/profile/index'));
        }
	}
}
?>
