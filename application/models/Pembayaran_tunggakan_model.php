<?php
Class Pembayaran_tunggakan_model extends CI_Model{
    public $nama;

    public function get_all()
    {
            $query = $this->db->get('tb_pembayaran_tunggakan');
            return $query->result();
    }

    public function get_by_id($id)
    {
            $query = $this->db->where('id',$id)->get('tb_pembayaran_tunggakan');
            return $query->row();
    }

    public function get_by_id_pembayaran($id)
    {
            $query = $this->db->where('id_pembayaran',$id)->get('tb_pembayaran_tunggakan');
            return $query->result();
    }
	public function get_by_id_pembayaran_tunggakan($id)
    {
			$jenis = array('1','16');
            $query = $this->db->where_in('id_jenis_pembayaran',$jenis)->where('id_pembayaran',$id)->get('tb_pembayaran_tunggakan');
            return $query->result();
    }
    public function insert($id_siswa, $id_pembayaran){
		
        
		$tunggakan = (int) str_replace(".", "", $this->input->post('tunggakan'));
		$update_pembayaran = $this->db->update('tb_pembayaran',array('jumlah_tunggakan'=>$tunggakan),array('id'=>$id_pembayaran));
		//$tunggakan = (int) str_replace(".", "", "1.050.000");
		//echo $tunggakan;
		$hasil = 0;
		if($tunggakan > 0){
			//echo "masuk sini";
			$get_tunggakan = $this->db->order_by('id_jenis_pembayaran',"asc")->where(['id_siswa'=>$id_siswa,'status'=>0])->get('tb_tunggakan')->result();
			// foreach($get_tunggakan as $row){
			// 	echo $tunggakan+(int)$row->pembayaran;
			// 	echo 
			// }
			$get_tunggakan = $this->db->order_by('id_jenis_pembayaran',"asc")->where(['id_siswa'=>$id_siswa,'status'=>0])->get('tb_tunggakan');
			if($get_tunggakan->num_rows() > 0){
				do{
					foreach($get_tunggakan->result() as $row){
						if(((int)$tunggakan+$row->pembayaran) < $row->kekurangan && $tunggakan > 0){
							$kekurangan = $row->kekurangan-$row->pembayaran;
							
							$data2 = array(
								'id_pembayaran' => $id_pembayaran,
								'id_tunggakan' => $row->id,
								'jumlah_bayar' => $row->pembayaran+$tunggakan,
							);
							$this->db->insert('tb_pembayaran_tunggakan',$data2);
							$tunggakan -= $kekurangan;
							//echo $kekurangan;
							$tunggakan -= $kekurangan;
						}elseif(($tunggakan+$row->pembayaran) >= $row->kekurangan && $tunggakan > 0){
							$kekurangan = $row->kekurangan-$row->pembayaran;
							
							$data2 = array(
								'id_pembayaran' => $id_pembayaran,
								'id_tunggakan' => $row->id,
								'jumlah_bayar' => $row->kekurangan,
							);
							$this->db->insert('tb_pembayaran_tunggakan',$data2); 
							//echo $kekurangan;
							$tunggakan -= $kekurangan;
						}else{
							break;
						}
						//jika uang sisa masukan ke jenis pembayaran lainnya
					}
					if($tunggakan > 0){
						$data = array(
							'id_pembayaran' => $id_pembayaran,
							'id_jenis_pembayaran' => 6,
							'nominal' => $tunggakan,
						);
						$this->db->insert('tb_detail_pembayaran',$data);
						$tunggakan = 0;
					}
				}while($tunggakan > 0);
				$hasil = 1;
			}else{
				$hasil = 2;
			}
		}else{
			$hasil = 0;
		}
		if($hasil > 0 ){
			return true;
		}else{
			return false;
		}
    }
    public function insert_admin($id_siswa, $id_pembayaran){
		
        
		$tunggakan = (int) str_replace(".", "", $this->input->post('tunggakan'));
		$update_pembayaran = $this->db->update('tb_pembayaran',array('jumlah_tunggakan'=>$tunggakan),array('id'=>$id_pembayaran));
		//$tunggakan = (int) str_replace(".", "", "1.050.000");
		//echo $tunggakan;
		$hasil = 0;
		if($tunggakan > 0){
			//echo "masuk sini";
			$get_tunggakan = $this->db->order_by('id_jenis_pembayaran',"asc")->where(['id_siswa'=>$id_siswa,'status'=>0])->get('tb_tunggakan')->result();
			// foreach($get_tunggakan as $row){
			// 	echo $tunggakan+(int)$row->pembayaran;
			// 	echo 
			// }
			$get_tunggakan = $this->db->order_by('id_jenis_pembayaran',"asc")->where(['id_siswa'=>$id_siswa,'status'=>0])->get('tb_tunggakan');
			if($get_tunggakan->num_rows() > 0){
				do{
					foreach($get_tunggakan->result() as $row){
						if(((int)$tunggakan+$row->pembayaran) < $row->kekurangan && $tunggakan > 0){
							$kekurangan = $row->kekurangan-$row->pembayaran;
							$data = array(
								'pembayaran' => $row->pembayaran+$tunggakan,
							);
							$where = array(
								'id' => $row->id,
							);
							$this->db->update("tb_tunggakan",$data,$where);
							
							$data2 = array(
								'id_pembayaran' => $id_pembayaran,
								'id_tunggakan' => $row->id,
								'jumlah_bayar' => $row->pembayaran+$tunggakan,
							);
							$this->db->insert('tb_pembayaran_tunggakan',$data2);
							$tunggakan -= $kekurangan;
							//echo $kekurangan;
							$tunggakan -= $kekurangan;
						}elseif(($tunggakan+$row->pembayaran) >= $row->kekurangan && $tunggakan > 0){
							$kekurangan = $row->kekurangan-$row->pembayaran;
							$data = array(
								'pembayaran' => $row->kekurangan,
								'status' => 1,
							);
							$where = array(
								'id' => $row->id,
							);
							$this->db->update("tb_tunggakan",$data,$where);
							
							$data2 = array(
								'id_pembayaran' => $id_pembayaran,
								'id_tunggakan' => $row->id,
								'jumlah_bayar' => $row->kekurangan,
							);
							$this->db->insert('tb_pembayaran_tunggakan',$data2); 
							//echo $kekurangan;
							$tunggakan -= $kekurangan;
						}else{
							break;
						}
						//jika uang sisa masukan ke jenis pembayaran lainnya
					}
					if($tunggakan > 0){
						$data = array(
							'id_pembayaran' => $id_pembayaran,
							'id_jenis_pembayaran' => 6,
							'nominal' => $tunggakan,
						);
						$this->db->insert('tb_detail_pembayaran',$data);
						$tunggakan = 0;
					}
				}while($tunggakan > 0);
				$hasil = 1;
			}else{
				$hasil = 2;
			}
		}else{
			$hasil = 0;
		}

		if($hasil > 0 ){
			return true;
		}else{
			return false;
		}
    }
	
	public function status_valid($id){
		$get_pembayaran_tunggakan = $this->db->select("tb_pembayaran_tunggakan.*,tb_tunggakan.kekurangan,tb_tunggakan.pembayaran")->join('tb_tunggakan','tb_tunggakan.id=tb_pembayaran_tunggakan.id_tunggakan')->where('id_pembayaran',$id)->get('tb_pembayaran_tunggakan')->result();
		$hasil = 0;
		foreach($get_pembayaran_tunggakan as $row){
			$total = ($row->pembayaran + $row->jumlah_bayar);
			$data = array();
			if($total == $row->kekurangan){
				$data = array(
					'pembayaran' => $total,
					'status' => 1
				);
			}else{
				$data = array(
					'pembayaran' => $total,
				);
			}
			$where = array(
				'id' => $row->id_tunggakan,
			);
			$update = $this->db->update('tb_tunggakan',$data,$where);
			if($update){
				$hasil += 1;
			}
		}
		if($hasil > 0){
			return true;
		}else{
			return false;
		}
	}
	public function status_invalid($id){
		$get_pembayaran_tunggakan = $this->db->select("tb_pembayaran_tunggakan.*,tb_tunggakan.kekurangan,tb_tunggakan.pembayaran")->join('tb_tunggakan','tb_tunggakan.id=tb_pembayaran_tunggakan.id_tunggakan')->where('id_pembayaran',$id)->get('tb_pembayaran_tunggakan')->result();
		$hasil = 0;
		foreach($get_pembayaran_tunggakan as $row){
			$total = ($row->pembayaran - $row->jumlah_bayar);
			$data = array(
				'pembayaran' => $total,
				'status' => 0
			);
			$where = array(
				'id' => $row->id_tunggakan,
			);
			$update = $this->db->update('tb_tunggakan',$data,$where);
			if($update){
				$hasil += 1;
			}
		}
		if($hasil > 0){
			return true;
		}else{
			return false;
		}
	}
	
    public function update(){
       
    }

    public function delete($id)
    {
        if($this->db->delete('tb_pembayaran_tunggakan', array('id' => $id))){
            return true;
        }else{
            return false;
        }
    }
}