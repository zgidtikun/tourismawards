<div class="continer">
    <div class="bs-row justify-content-center mt-5 mb-5">
        <div class="col-sm-12 col-md-9 mb-4">
            <div class="card card-body">
                <span class="text-base-main fw-semibold">
                    <i class="bi bi-bell-fill mr-2"></i>รายการการแจ้งเตือน
                <span>
            </div>
        </div>
        <div class="col-sm-12 col-md-9">
            <div class="card card-body">
                <div class="bs-row">
                    <div class="col-12">
                        <span class="text-base-main fw-semibold">
                            รายการแจ้งเตือนทั้งหมด
                        </span>
                    </div>
                    <div class="col-12 mt-3">
                        <table id="tbl-noti" class="table boards" style="font-size: 16px;">
                            <thead style="border-radius: 6px;">
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">รายละเอียด</th>
                                    <th class="text-center">วันเวลาที่แจ้ง</th>
                                    <th class="text-center">ผู้แจ้ง</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $app = new \Config\App(); ?>
<script src="<?= base_url('assets/DataTables/datatables.js') ?>?v=<?= $app->script_v ?>"></script>
<script>
    var dttb;

    $(document).ready(() => {
        noti();
        $('body').css('background-color','#f5f4f1');
    });

    const noti = () => {
        $.ajax({
            type: 'post',
            url: window.location.origin+'/inner-api/noti/get',
            data: {limit: 'all'},
            dataType: 'json',
            success: (response) => {
                if(response.result == 'success') {
                    $.each(response.noti,(k,v) => {
                        response.noti[k].no = 0;
                    });
                    
                    initDTTB(response.noti);
                    $('#tbl-noti').attr('data-id',response.id);
                } else {
                    initDTTB([]);
                }
            }
        });
    }

    const initDTTB = (dt) => {
        if(!$.fn.DataTable.isDataTable('#tbl-noti')){
            dttb = $('#tbl-noti').DataTable({
                data: dt,
                pageLength: 25,
                procressing: true,
                info: true,
                filter: true,
                lengthChange: false,
                columns: [
                    { data: 'no' },
                    { 
                        data: 'message',
                        render: (data, type, row, meta) => {
                            let content = '<a href="'+row.link+'">'
                                + data
                                + '</a>';
                            return content;
                        } 
                    },
                    { data: 'send_date' },
                    { data: 'send_by' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center',
                        searchable: false,
                        orderable: false
                    },
                    { targets: 2, className: 'text-center' }
                ],
                order: [[2,'desc']],
                language: {
                    emptyTable: "ไม่มีรายการข้อมูล",
                    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    infoEmpty: "",
                    zeroRecords: "ไม่พบข้อมูลที่ค้นหา",
                    infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
                },
                drawCallback: function(data, type, row, meta) {
                    $('.dataTables_paginate ul').addClass('pagination-sm justify-content-end');
                } 
            });
        } else {
            dttb.clear().rows.add(dt).draw(); 
        }        

        dttb.on('order.dt search.dt', function() {
            let i = 1;

            dttb.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    }
</script>