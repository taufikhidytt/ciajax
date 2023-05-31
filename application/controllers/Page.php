<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('My_model', 'my');
    }

    public function index()
    {
        $data = [
            'title'     =>  'Belajar Ajax',
        ];
        $this->load->view('home', $data);
    }

    public function getData()
    {
        $data = $this->my->getData()->result();

        echo json_encode($data);
    }

    public function tambahData()
    {
        $kode_barang = $this->input->post('kode_barang');
        $nama_barang = $this->input->post('nama_barang');
        $harga = $this->input->post('harga');
        $stock = $this->input->post('stock');

        if($kode_barang == ''){
            $result['pesan'] = 'Kode Barang Tidak Boleh Kosong';
        }elseif($nama_barang == ''){
            $result['pesan'] = 'Nama Barang Tidak Boleh Kosong';
        }elseif($harga == ''){
            $result['pesan'] = 'Harga Barang Tidak Boleh Kosong';
        }elseif($stock == ''){
            $result['pesan'] = 'Stock Barang Tidak Boleh Kosong';
        }else{
            $result['pesan'] = '';

            $data = [
                'kode_barang'   =>  $kode_barang,
                'nama_barang'   =>  $nama_barang,
                'harga'         =>  $harga,
                'stock'         =>  $stock,
            ];
            $this->my->tambahData('data_barang', $data);
        }
        echo json_encode($result);
    }

    public function getId()
    {
        $id = $this->input->post('id');

        $where = array(
            'id'    =>  $id
        );

        $dataBarangId = $this->my->getId('data_barang', $where)->result();

        echo json_encode($dataBarangId);
    }

    public function ubahData()
    {
        $id = $this->input->post('id');
        $kode_barang = $this->input->post('kode_barang');
        $nama_barang = $this->input->post('nama_barang');
        $harga = $this->input->post('harga');
        $stock = $this->input->post('stock');

        if ($kode_barang == '') {
            $return['pesan'] = 'Kode Barang Tidak Boleh Kosong';
        }elseif($nama_barang == ''){
            $return['pesan'] = 'Nama Barang Tidak Boleh Kosong';
        }elseif($harga == ''){
            $return['pesan'] = 'Harga Barang Tidak Boleh Kosong';
        }elseif($stock == ''){
            $return['pesan'] = 'Stock Barang Tidak Boleh Kosong';
        }else{
            $return['pesan'] = '';
            
            $data = array(
                'kode_barang'   =>  $kode_barang,
                'nama_barang'   =>  $nama_barang,
                'harga'         =>  $harga,
                'stock'         =>  $stock
            );
            
            $where = array(
                'id'    =>  $id
            );
    
            $this->my->update($data, $where);
        }
        echo json_encode($return);
    }

    public function hapusData()
    {
        $id = $this->input->post('id');

        $where = array(
            'id'    =>  $id
        );
        $this->my->hapusData($where, 'data_barang');
    }
}
?>