<?php
Class Berita_model extends CI_Model{

    public function get_all(){
        $query = $this->db->where('berita.deleted_at', null)
                          ->get('berita');
        $results = $query->result();
        return $results;
    }

    public function get_pagination($limit = 3, $offset = 0) {
        $this->db->select('berita.*, kategori_berita.nama_kategori');
        $this->db->from('berita');
        $this->db->join('kategori_berita', 'berita.kategori_id = kategori_berita.id', 'left');
        $this->db->where('berita.deleted_at', null);
        $this->db->order_by('berita.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $results = $query->result();

        // Enkripsi ID dengan Base64
        foreach ($results as $row) {
            $row->id = rawurlencode(base64_encode($row->id . "ppatq"));
        }
        return $results;
    }

    public function get_latest() {
        $this->db->select('berita.*, kategori_berita.nama_kategori');
        $this->db->from('berita');
        $this->db->join('kategori_berita', 'berita.kategori_id = kategori_berita.id', 'left');
        $this->db->where('berita.deleted_at', null);
        $this->db->order_by('berita.created_at', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $results = $query->result();
    
        // Enkripsi ID dengan Base64
        foreach ($results as $row) {
            $row->id = rawurlencode(base64_encode($row->id . "ppatq"));
        }
    
        return $results;
    }

    public function get_by_id($idEnkripsi) {
        $idDekripsi = base64_decode(rawurldecode($idEnkripsi));
        $id = str_replace("ppatq", "", $idDekripsi);
        $query = $this->db->get_where('berita', array('id' => $id));
        return $query->row();
    }

}