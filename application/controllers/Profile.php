<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
		
        $this->load->model('Siswa_model','siswa');
		if(empty($this->session->userdata('siswa_id'))){
			$this->session->set_flashdata('error','Harap isi form ini terlebih dahulu');
			redirect(base_url('index.php/pembayaran/index/profile/kesehatan'));
		}

    }
	public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

	public function index()
	{	
		if(empty($this->session->userdata('pwd'))){
			$this->session->set_flashdata('error','Harap isi form ini terlebih dahulu');
			redirect(base_url('index.php/pembayaran/index_profile'));
		}
		$no_induk = $this->session->userdata('siswa_id');
		$siswa = $this->siswa->get_by_ni($this->session->userdata('siswa_id'));
        $data['siswa'] = $this->db->where('no_induk',$no_induk)->get('santri_detail')->row();
		$data['provinsi'] = $this->db->get('provinces')->result();
		$data['prov_curr']  = $this->db->where('prov_id',$data['siswa']->provinsi)->get('provinces')->row();
		$data['kota'] = $this->db->where('prov_id',$data['siswa']->provinsi)->get('cities')->result();
		$data['kota_curr']  = $this->db->where('city_id',$data['siswa']->kabkota)->get('cities')->row();

		$data['photo'] = base_url('assets/images/user.png');
		if(!empty($data['siswa']->photo) && $data['siswa']->photo_location == "1" ){
			$data['photo'] = base_url('assets/upload/user/' . $data['siswa']->photo);
		}elseif(!empty($data['siswa']->photo) && $data['siswa']->photo_location == "2" ){
			$data['photo'] = "https://manajemen.ppatq-rf.id/assets/img/upload/photo/" . $data['siswa']->photo;
		}

		$data['berkas'] = $this->db->where('no_induk',$no_induk)->get('tb_berkas_pendukung')->row();
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
				'photo_location' => 1,
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
	public function simpan_berkas(){
		$no_induk = $this->session->userdata('siswa_id');
		$nama_file = array('file_kk','file_akta');
		$array = array();

		$config['upload_path']          = './assets/upload/berkas';
        $config['allowed_types']        = '*';
        $config['max_size']             = 10000;

        $this->load->library('upload', $config);
		
        foreach($nama_file as $key => $value){
			
            if(!empty($_FILES[$value]['name'])){	
				
                $file_name = date('YmdHis') . $_FILES[$value]['name'];
				$pecah = explode($file_name,".");
                $ekstensi = end($pecah);
                //$filename = date('YmdHis') . $file->getClientOriginalName();

				$config['file_name']  = $file_name;	
				$this->upload->initialize($config);

				if ($key == 0) {
					$this->upload->do_upload('file_kk');
					$data = $this->upload->data();
				}else{
					$this->upload->do_upload('file_akta');
					$data = $this->upload->data();
				}

				$cek = $this->db->where('no_induk',$no_induk)->get('tb_berkas_pendukung');
                if($cek->num_rows() > 0){
					$data_upload[$value] = $file_name;
                    $update = $this->db->update('tb_berkas_pendukung',$data_upload,['no_induk'=>$no_induk]);
                }else{
                    $data_upload[$value] = $file_name;
					$data_upload['no_induk'] = $no_induk;
					$data_upload['created_at'] = date('Y-m-d H:i:s');
					$create = $this->db->insert('tb_berkas_pendukung',$data_upload);
                }
				$this->session->set_flashdata('message','data berhasil diupdate');

            }else{
				$this->session->set_flashdata('error','Data gagal disimpan');
			}
        }
		//$this->session->set_flashdata('message',$array);
        //redirect(base_url('index.php/profile/index'));
	}
	public function kesehatan(){
		$no_induk = $this->session->userdata('siswa_id');
		$riwayat_sakit = $this->db->where('santri_id',$no_induk)->get('tb_kesehatan')->result();
		$data['pemeriksaan'] = $this->db->where('no_induk',$no_induk)->get('tb_pemeriksaan')->result();
		$data['riwayat_sakit'] = $riwayat_sakit;
		$var['title'] = 'PPATQ Roudlotul Falah';
		$var['content'] = $this->load->view('profile/kesehatan',$data,true);
		echo $no_induk;

		$this->load->view('layouts/main',$var);
	}
}
?>
