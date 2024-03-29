<div class="bs-continer">
    <div class="bs-row justify-content-center mt-3 mb-5">
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
                                    <th class="text-center" id="tr-1">#</th>
                                    <th class="text-center" id="tr-2">รายละเอียด</th>
                                    <th class="text-center" id="tr-3">วันเวลาที่แจ้ง</th>
                                    <!-- <th class="text-center" id="tr-4">ผู้แจ้ง</th> -->
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
                            return `<a href="${row.link}">${data}</a>`;
                        } 
                    },
                    { 
                        data: 'send_date',
                        render: (data, type, row, meta) => {
                            const arr = data.split(' ');
                            return `${arr[0]}\r\n${arr[1]}`;
                        }  
                    },
                    // { data: 'send_by' },
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
                    $('#tr-1').css('width','7%');
                    $('#tr-3').css('width','15%');
                    // $('#tr-4').css('width','15%');
                    $('#tbl-noti_paginate').css('margin-top','1rem');
                    $('#tbl-noti_info').css('margin-top','1rem');
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