<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(empty($this->session->userdata('roles'))){
            redirect(base_url('index.php/auth/login'));
        }else{
            if($this->session->userdata('roles') != 'Admin'){
                redirect(base_url('index.php/auth/login'));
            }
        }
        $this->load->model('Wa_model','wa');
    }
    public $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

    public function index(){
		
        $data['wa'] = $this->wa->get_all();
        $data['bulan'] = $this->bulan;

		$var['title'] = 'Log Whatsapp';
		$var['content'] = $this->load->view('admin/wa/index',$data,true);

		$this->load->view('layouts/admin',$var);
    }
	public function create_kelas(){
		$data['template_pesan'] = $this->db->get_where('ref_template_pesan',array('status'=>1))->row();
		$data['kelas'] = $this->db->group_by('kelas')->get('santri_detail')->result();

		$var['title'] = 'Tambah Pesan Whatsapp Baru Dengan Kelas';
		$var['content'] = $this->load->view('admin/wa/create_kelas',$data,true    );

		$this->load->view('layouts/admin',$var);
	}
	public function get_review(){
		$kelas = $this->input->post('kelas');
		$detail = $this->db->get_where('santri_detail',array('kelas'=>$kelas))->result();
		echo "<table class='table'> <tr><td>No.</td><td>Nama</td><td>Kelas</td><td>No.HP</td></tr>";
		$i = 1;
		foreach($detail as $row){
			echo "<tr><td>" . $i . "</td><td>" . $row->nama . "</td><td>" . $row->kelas . "</td><td>" . $row->no_hp . "</td></tr>";
			$i++;
		}
		echo "</table>";
	}

    public function create(){

        $data['template_pesan'] = $this->db->get_where('ref_template_pesan',array('status'=>1))->row();
	
		$var['title'] = 'Tambah Pesan Whatsapp Baru';
		
		$var['content'] = $this->load->view('admin/wa/create_new',$data,true    );

		$this->load->view('layouts/admin',$var);
    }

    
    public function edit($id){

        $data['wa'] = $this->wa->get_by_id($id);

		$var['title'] = 'Edit whatsapp';
		$var['content'] = $this->load->view('admin/wa/create',$data,true);

		$this->load->view('layouts/admin',$var);
    }

    public function insert(){
        $insert = $this->wa->insert();
		if(empty($this->input->post('file_gambar'))){
			$data = array(
				'no_wa' => $this->input->post('no_wa'),
				'pesan' => $this->input->post('pesan'),
			);
			$send = $this->wa->send_wa($data);
		}else{
			$data = array(
				'no_wa' => $this->input->post('no_wa'),
				'pesan' => $this->input->post('pesan'),
				'url' => $this->input->post('file_gambar'),
			);
			$send = $this->wa->send_wa_img($data);
		}
        
        $decode = json_decode($send);
        $msg = "";
        if($decode->status != 200){
            $msg = $decode;
        }else{
            $msg = "pesan berhasil dikirimkan";
        }
        if($insert){
            $this->session->set_flashdata('message','data berhasil ditambahkan dan ' . $msg);
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/create'));
        }
    }
    public function insert_kelas(){
        

		$kelas = $this->input->post('kelas');
		$detail = $this->db->get_where('santri_detail',array('kelas'=>$kelas))->result();
		$jumlah_berhasil = 0;
		$jumlah_gagal = 0;
		$jumlah_tanpa_nomor = 0;
		
		foreach($detail as $row){
			$pesan = $this->input->post('pesan');
			$pesan = str_replace($pesan, "{{nama}}", $row->nama);
			$pesan = str_replace($pesan, "{{kelas}}", $row->kelas);
			echo $pesan;
			exit;
			if(!empty($row->no_hp)){
				$data = array(
					'nama' => $row->nama,	
					'no_wa' => $row->no_hp,	
					'pesan' => $this->input->post('pesan'),
				);
				$insert = $this->wa->insert_kelas($data);

				if(empty($this->input->post('file_gambar'))){
					$data = array(
						'no_wa' => $row->no_hp,
						'pesan' => $this->input->post('pesan'),
					);
					$send = $this->wa->send_wa($data);
				}else{
					$data = array(
						'no_wa' => $row->no_hp,
						'pesan' => $this->input->post('pesan'),
						'url' => $this->input->post('file_gambar'),
					);
					$send = $this->wa->send_wa_img($data);
				}
				$decode = json_decode($send);
				$msg = "";
				if($decode->status != 200){
					$msg = $decode;
					$jumlah_gagal++;
				}else{
					$msg = "pesan berhasil dikirimkan";
					$jumlah_berhasil++;
				}
			}else{
				$jumlah_tanpa_nomor++;
			}
			
		}
        
        
        if($jumlah_berhasil > 0){
            $this->session->set_flashdata('message','data berhasil ditambahkan ' . $jumlah_berhasil . ' Jumlah gagal : ' . $jumlah_gagal . ' Jumlah tanpa nomor' . $jumlah_tanpa_nomor);
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/create_kelas'));
        }
    }

    public function update(){
        $update = $this->wa->update();
        if($update){
            $this->session->set_flashdata('message','data berhasil diupdate');
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/edit/' . $id));
        }
    }
    public function resend($id){
        $wa = $this->wa->get_by_id($id);
        $data = array(
            'no_wa' => $wa->no_wa,
            'pesan' => $wa->pesan,
        );
        $send = $this->wa->send_wa($data);
        $decode = json_decode($send);
        $msg = "";
        if($decode->status != 200){
            $this->session->set_flashdata('error','pesan gagal dikirimkan ' . $send);
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            $this->session->set_flashdata('message','Pesan berhasil dikirimkan');
            redirect(base_url('index.php/admin/whatsapp'));
        }
    }

    public function delete($id){
        $delete = $this->wa->delete($id);
        if($delete){
            $this->session->set_flashdata('message','data berhasil dihapus');
            redirect(base_url('index.php/admin/whatsapp'));
        }else{
            redirect(base_url('index.php/admin/whatsapp/'));
        }
    }



}
