<?php
class Barang extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_barang');
	}
	function index(){
		$this->load->view('v_barang');
	}

	function get_barang() {
		$list = $this->m_barang->get_datatables();
		$data = array();
		$no = @$_POST['start'];
		foreach ($list as $i) {
			$no++;
			$row = array();
			$row[] = $no.".";
			$row[] = $i->barang_kode;
			$row[] = $i->barang_nama;
			$row[] = $i->barang_harga;
			// add html for action
			$row[] = '<a href="#" class="btn btn-info btn-xs" id="btnEdit" data="'.$i->barang_kode.'">Edit</a>
							<a href="#" class="btn btn-danger btn-xs" id="btnDelete" data="'.$i->barang_kode.'">Hapus</a>';
			$data[] = $row;
		}
		$output = [
			"draw" => @$_POST['draw'],
			"recordsTotal" => $this->m_barang->count_all(),
			"recordsFiltered" => $this->m_barang->count_filtered(),
			"data" => $data,
		];
		// output to json format
		echo json_encode($output);
}

	function get_barang_by_id(){
		$kobar = $this->input->get('id');
		$data = $this->m_barang->get_by_id($kobar);
		$res = [
			'data' => $data,
			'response' => $data ? true : false,
		];

		echo json_encode($res);
	}

	function simpan_barang(){
		$res = [];
		if($this->input->is_ajax_request() == true){
			$this->validation();
			if (!$this->form_validation->run()) {
				$res = [
					'error' => validation_errors()
				];
			}else{
				$data = [
					'barang_kode' => $this->input->post('barang_kode', true),
					'barang_nama' => $this->input->post('barang_nama', true),
					'barang_harga' => $this->input->post('barang_harga', true),
				];
	
				$q = $this->m_barang->insert($data);
	
				$res = [
					'data' => $data,
					'response' => $q,
					'message' => $q ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!'
				];
			}
			echo json_encode($res);
		}
		
	}

	function update_barang(){
		$res = [];
		if($this->input->is_ajax_request() == true){
			$this->validation('edit');
			if (!$this->form_validation->run()) {
				$res = [
					'error' => validation_errors()
				];
			}else{
				$data = [
					'barang_kode' => $this->input->post('barang_kode', true),
					'barang_nama' => $this->input->post('barang_nama', true),
					'barang_harga' => $this->input->post('barang_harga', true),
				];
	
				$q = $this->m_barang->update($data);
	
				$res = [
					'data' => $data,
					'response' => $q,
					'message' => $q ? 'Data Berhasil Diupdate!' : 'Data Gagal Diupdate!'
				];
			}
			echo json_encode($res);
		}
	}

	function hapus_barang(){
		$res = [];
		if($this->input->is_ajax_request() == true){
			$barang_kode = $this->input->post('barang_kode', true);
			$q = $this->m_barang->delete($barang_kode);

			$res = [
				'response' => $q,
				'message' => $q ? 'Data Berhasil Dihapus!' : 'Data Gagal Dihapus!'
			];
			echo json_encode($res);
		}
	}

	private function validation($mode = 'add')
	{
		if($mode == 'add'){
			$this->form_validation->set_rules('barang_kode', 'kode_barang', 'required|trim|is_unique[tbl_barang.barang_kode]', ['is_unique'	=> 'Kode Barang Sudah Ada']);
		}else{
			$this->form_validation->set_rules('barang_kode', 'kode_barang', 'required|trim');
		}
		
		$this->form_validation->set_rules('barang_nama', 'nama_barang', 'required|trim');
		$this->form_validation->set_rules('barang_harga', 'harga', 'required|numeric');
		
	}

}