<?php
Class Berita_model extends CI_Model{

    public function get_all(){
        $query = $this->db->get('berita');
            return $query->result();
    }

    public function get_pagination($limit = 3, $offset = 0) {
        $this->db->select('berita.*, kategori_berita.nama_kategori');
        $this->db->from('berita');
        $this->db->join('kategori_berita', 'berita.kategori_id = kategori_berita.id', 'left');
        $this->db->order_by('berita.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_latest() {
        $this->db->select('berita.*, kategori_berita.nama_kategori');
        $this->db->from('berita');
        $this->db->join('kategori_berita', 'berita.kategori_id = kategori_berita.id', 'left');
        $this->db->order_by('berita.created_at', 'DESC'); // Urutkan berdasarkan kolom created_at dengan urutan menurun
        $this->db->limit(3); // Ambil hanya satu data paling baru
        $query = $this->db->get();
        return $query->result(); // Mengambil satu baris hasil
    }

    public function get_by_id($id) {
        $query = $this->db->get_where('berita', array('id' => $id));
        return $query->row();
    }

}