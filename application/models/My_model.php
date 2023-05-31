<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class My_model extends CI_Model
{
    public function getData()
    {
        return $this->db->get('data_barang');
    }

    public function tambahData($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function getId($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    public function update($data, $where)
    {
        $params = [
            'kode_barang'   =>  $data['kode_barang'],
            'nama_barang'   =>  $data['nama_barang'],
            'harga'         =>  $data['harga'],
            'stock'         =>  $data['stock'],
        ];
        $this->db->where('id', $where['id']);
        $this->db->update('data_barang', $params);
    }

    public function hapusData($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
?>