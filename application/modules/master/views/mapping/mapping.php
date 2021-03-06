<div class="alert alert-success" role="alert" id="respon_server" style="display: none">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <p class="message"></p>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $title ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group pull-right">
                    <a href="/master/areas/addMappping">
                        <button class="btn btn-primary" type="button">
                            <span class="fa fa-plus"></span> Tambah Data
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="row np-lr">
         <ul class="nav nav-tabs" id="tabs">
            <li class="active"><a data-toggle="tab" href="#sectionA">Unit Pelaksana Teknis</a></li>
            <li><a data-toggle="tab" href="#sectionB">Satuan Pengawasan</a></li>
         </ul>
         <div class="tab-content">
            <div id="sectionA" class="tab-pane fade in active">
                <br>
               <table id="unitKerja" class="table table-striped table-hover" style="width: 100%">
                  <thead>
                     <tr>
                        <th>Unit Pelaksana Teknis (UPT)</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                   <tbody></tbody>
               </table>
            </div>
            <div id="sectionB" class="tab-pane fade">
                <br>
                <table id="satuanPengawas" class="table table-striped table-hover" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Satuan Pengawasan (SATWAS)</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
         </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DETAIL UPT</h4>
            </div>
            <div class="modal-body">
                <br>
                <table id="detailUPT" class="table table-striped table-hover" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Satuan Pengawasan (SATWAS)</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="model_remove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Mapping</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus relasi <b id="parrentData"></b> dengan <b id="childData"></b> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnHapus" onclick="hapus()" data-dismiss="modal">Setuju</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var upt = $('#unitKerja').DataTable({
            dom: 'Bfrtip',
            ajax: {
                url: '<?php echo base_url()?>/master/mapping/getUnitWorkingById/1',
                dataSrc: 'data.content',
                processing: true
            },
            columns: [
                {
                    data:"",
                    render: function (data, type, full) {
                        return full.name.toUpperCase();
                    }
                },
                {
                    data: "",
                    className: "center",
                    render: function (data, type, full) {
                        return '<a onclick="showModal('+full.id+')">Detail</a>';
                    }
                }
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        var satwas = $('#satuanPengawas').DataTable({
            dom: 'Bfrtip',
            ajax: {
                url: '<?php echo base_url()?>/master/mapping/getUnitWorkingById/2',
                dataSrc: 'data.content',
                processing: true
            },
            columns: [
                {
                    data:"",
                    render: function (data, type, full) {
                        return full.name.toUpperCase();
                    }
                },
                {
                    data: "",
                    className: "center",
                    render: function (data, type, full) {
                        return '<a onclick="showModal('+full.id+')">Detail</a>';
                    }
                }
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });

    function showModal(id) {
        getDetailChild(id, "upt");
        $("#detail").modal("show");
    }

    function showModal_satwas(id) {
        getDetailChild(id);
        $("#detail").modal("show");
    }

    function getDetailChild(id, type) {
        var table = $('#detailUPT').DataTable({
            dom: 'Bfrtip',
            ajax: {
                url: '<?php echo base_url()?>/master/mapping/getMappingByParrent/' + id,
                dataSrc: 'data.content',
                processing: true
            },
            columns: [
                {
                    data: "",
                    render: function (data, type, full) {
                        return full.child.name.toUpperCase();
                    }
                },{
                    data: "",
                    className: "center",
                    render: function (data, type, full) {
                        return '<a onclick="showModalRemove(\''+full.parrent.name+'\',\''+full.child.name+'\',\''+full.id+'\')">Hapus</a>';
                    }
                }
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "bDestroy": true
        });
    }

    function showModalRemove(parrent,child,id) {
        $("#parrentData").html(parrent.toUpperCase());
        $("#childData").html(child.toUpperCase());
        $("#btnHapus").attr('onclick', 'hapus("'+id+'")');
        $("#model_remove").modal('show');
    }

    function hapus(id) {
        $("#detail").modal('hide');
        var id = id;

        var data = {
            id: parseInt(id)
        }

        var dataSend = {
            data : JSON.stringify(data)
        }
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/master/mapping/deleteMapping",
            data:dataSend,
            success: function (data) {
                var data = JSON.parse(data);
                show_notif(data.code, data.message);
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        })
    }

    function show_notif(tipe, message){
        if(tipe == 201 || tipe == 200){
            $("#respon_server").attr('class','alert alert-success');
        } else {
            $("#respon_server").attr('class','alert alert-danger');
        }
        $("#respon_server .message").html(message);
        $("#respon_server").show('slow');
    }

</script>

