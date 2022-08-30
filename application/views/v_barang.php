
<?php $this->load->view('template/header'); ?>
	<!-- Page Heading -->
    <div class="row">
        <div class="col-12">
            <h1 class="page-header">Data
                <small>Barang</small>
                <div class="text-right">
                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalAdd"><span class="fa fa-plus"></span> Tambah Barang</a>
                </div>
            </h1>
        </div>
    </div>
	<div class="row">
		<div class="col-12">
            <div class="table-responsive">
            <table class="table table-striped" id="getData">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataList">
                    
                </tbody>
            </table>
            </div>
		</div>
	</div>


<!-- MODAL ADD -->

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveData">
                <div class="modal-body">
                    <span class="text-danger msgError" style="display: none"></span>
                    <div class="form-group">
                        <label class="form-label">Kode Barang</label>
                        <input name="barang_kode" id="barang_kode" class="form-control" type="text" placeholder="Kode Barang">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input name="barang_nama" id="barang_nama" class="form-control" type="text" placeholder="Nama Barang">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga</label>
                        <input name="barang_harga" id="barang_harga" class="form-control" type="text" placeholder="Harga">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateData">
                <div class="modal-body">
                    <span class="text-danger msgError" style="display: none"></span>
                    <div class="form-group">
                        <label class="form-label">Nama Barang</label>
                        <input name="barang_kode" id="barang_kode_edit" class="form-control" type="hidden" placeholder="Kode Barang">
                        <input name="barang_nama" id="barang_nama_edit" class="form-control" type="text" placeholder="Nama Barang">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga</label>
                        <input name="barang_harga" id="barang_harga_edit" class="form-control" type="text" placeholder="Harga">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!--MODAL HAPUS-->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteData">
                <div class="modal-body">
                    <input type="hidden" name="barang_kode" id="barang_kode_hapus" value="">
                    <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function loadDataBarang(){
        table = $('#getData').DataTable({
            responsive : true,
            "destroy" : true,
            "processing" : true,
            "serverside" : true,
            "ajax" : {
                "url" : "<?= base_url('Barang/get_barang') ?>",
                "type" : "POST"
            },
            "columnDefs" : [{
                "targets" : [0, 4],
                "orderable" : false,
                "className" : "text-center"
            }],
        });
    }
	$(document).ready(function(){
		loadDataBarang();

        $('#saveData').submit(function(e){
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Barang/simpan_barang')?>",
                dataType : "JSON",
                data : $(this).serialize(),
                success: function(res){
                    if(res.error){
                        $('.msgError').html(res.error).show();
                    }else{
                        if(res.response){
                            populateSuccess(res.message);
                        }else{
                            populateError(res.message);
                        }
                        $('#modalAdd').modal('hide');
                        loadDataBarang();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });

		$('#dataList').on('click','#btnEdit',function(){
            var id = $(this).attr('data');
            $.ajax({
                type : "GET",
                url  : "<?= base_url('Barang/get_barang_by_id')?>",
                dataType : "JSON",
                data : {
                    id : id
                },
                success: function(res){
                    let data = res.data;
                	$('#modalEdit').modal('show');
                    $('#barang_kode_edit').val(data.barang_kode);
                    $('#barang_nama_edit').val(data.barang_nama);
                    $('#barang_harga_edit').val(data.barang_harga);
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });

		$('#dataList').on('click','#btnDelete',function(){
            var id = $(this).attr('data');
            $('#modalDelete').modal('show');
            $('#barang_kode_hapus').val(id);
        });	

		$('#updateData').submit(function(e){
            $.ajax({
                type : "POST",
                url  : "<?= base_url('Barang/update_barang')?>",
                dataType : "JSON",
                data : $(this).serialize(),
                success: function(res){
                    if(res.error){
                        $('.msgError').html(res.error).show();
                    }else{
                        if(res.response){
                            populateSuccess(res.message);
                        }else{
                            populateError(res.message);
                        }
                        $('#modalEdit').modal('hide');
                        loadDataBarang();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
                  
            });
            return false;
        });

        $('#deleteData').submit(function(e){
            $.ajax({
                type : "POST",
                url  : "<?= base_url('Barang/hapus_barang')?>",
                dataType : "JSON",
                data : $(this).serialize(),
                success: function(res){
                    if(res.response){
                        populateSuccess(res.message);
                    }else{
                        populateError(res.message);
                    }
                    $('#modalDelete').modal('hide');
                    loadDataBarang();
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });

	});
</script>
<!--END MODAL HAPUS-->
<?php $this->load->view('template/footer'); ?>