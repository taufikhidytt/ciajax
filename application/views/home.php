<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="<?= base_url().'assets/js/jquery-3.2.1.min.js'?>"></script>
</head>
<body>
    <div class="container">
        <h2>Belajar Ajax</h2><br>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form" onclick="submit('tambah')">
            Tambah Data
        </button><br><br>
        <table class="table table-bordered text-center table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="target"></tbody>
        </table>
    </div>

    <!-- Modal Tambah-->
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tambah">Tambah Data Barang</h5>
            <h5 class="modal-title" id="ubah">Ubah Data Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <span id="pesan" class="text-danger"></span>
            <form action="" method="post">
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" class="form-control" autocomplete="off" placeholder="Masukan Kode Barang">
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" autocomplete="off" placeholder="Masukan Nama Barang">
                </div>
                <div class="form-group">
                    <label for="harga">Harga Barang</label>
                    <input type="number" name="harga" id="harga" class="form-control" autocomplete="off" placeholder="Masukan Harga Barang">
                </div>
                <div class="form-group">
                    <label for="stock">Stock Barang</label>
                    <input type="number" name="stock" id="stock" class="form-control" autocomplete="off" placeholder="Masukan Stock Barang">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-tambah" onclick="tambahData()">Tambah Data</button>
            <button type="button" class="btn btn-primary" id="btn-ubah" onclick="ubahData()">Ubah Data</button>
        </div>
        </div>
    </div>
    </div>

    <script>
        getData();
        function getData(){
            $.ajax({
                url: '<?= base_url('page/getData')?>',
                type: 'POST',
                dataType: 'json',
                success: function(data){
                    var baris = '';
                    for(var i = 0; i < data.length; i++){
                        baris += '<tr>'+
                                    '<td>'+ (i+1) +'</td>'+
                                    '<td>'+ data[i].kode_barang +'</td>'+
                                    '<td>'+ data[i].nama_barang +'</td>'+
                                    '<td>'+ data[i].harga +'</td>'+
                                    '<td>'+ data[i].stock +'</td>'+
                                    '<td><a href="#form" data-toggle="modal" class="btn btn-primary" onclick="submit('+ data[i].id +')">Ubah</a><a onclick="hapusData('+ data[i].id +')" class="btn btn-danger text-white">Hapus</a></td>'+
                                '</tr>'
                    }
                    $('#target').html(baris);
                }
            })
        }   

        function tambahData(){
            var kode_barang = $("[name='kode_barang']").val();
            var nama_barang = $("[name='nama_barang']").val();
            var harga = $("[name='harga']").val();
            var stock = $("[name='stock']").val();

            $.ajax({
                url: '<?= base_url('page/tambahdata')?>',
                type: 'POST',
                data: 'kode_barang='+ kode_barang +'&nama_barang='+ nama_barang +'&harga='+ harga +'&stock='+ stock,
                dataType: 'json',
                success: function(hasil){
                    $('#pesan').html(hasil.pesan);
                    $('#modaltambah').modal('hide');
                    getData();

                    $("[name='kode_barang']").val('');
                    $("[name='nama_barang']").val('');
                    $("[name='harga']").val('');
                    $("[name='stock']").val('');
                }
            });
        }

        function submit(x){
            if(x == 'tambah'){
                $('#btn-tambah').show();
                $('#btn-ubah').hide();
                $('#tambah').show();
                $('#ubah').hide();
            }else{
                $('#btn-tambah').hide();
                $('#btn-ubah').show();
                $('#ubah').show();
                $('#tambah').hide();

                $.ajax({
                    url: '<?= base_url('page/getId')?>',
                    data: 'id='+x,
                    dataType: 'json',
                    type: 'POST',
                    success: function(dataId){
                        $("[name='id']").val(dataId[0].id);
                        $("[name='kode_barang']").val(dataId[0].kode_barang);
                        $("[name='nama_barang']").val(dataId[0].nama_barang);
                        $("[name='harga']").val(dataId[0].harga);
                        $("[name='stock']").val(dataId[0].stock);
                    }
                });
            }
        }

        function ubahData(){
            var id = $("[name='id']").val();
            var kode_barang = $("[name='kode_barang']").val();
            var nama_barang = $("[name='nama_barang']").val();
            var harga = $("[name='harga']").val();
            var stock = $("[name='stock']").val();

            $.ajax({
                type: 'POST',
                data: 'id='+id+'&kode_barang='+kode_barang+'&nama_barang='+nama_barang+'&harga='+harga+'&stock='+stock,
                url: '<?= base_url('page/ubahData')?>',
                dataType: 'json',
                success: function(hasilUbah){
                    $("#pesan").html(hasilUbah.pesan);

                    if(hasilUbah.pesan == ''){
                        $("#form").modal('hide');
                        getData();
                    }
                }
            });
        }

        function hapusData(id){
            var alert = confirm('Apakah Anda Ingin Menghapus Data Ini?');
            if(alert){
                $.ajax({
                    type: 'POST',
                    data: 'id='+id,
                    url: '<?= base_url('page/hapusData')?>',
                    success: function(){
                        getData();
                    }
                });
            }
        }
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>