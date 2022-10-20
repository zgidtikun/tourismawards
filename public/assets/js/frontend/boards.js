const tblar = null;

const boards = {
    dtb: null,
    at: {},
    dt: {},
    init(){
        const ld = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        $('#count-tab1').html(ld);
        $('#count-tab2').html(ld);
        $('#count-tab3').html(ld);
        $('#count-tab4').html(ld);

        api({method: 'get', url: '/inner-api/boards/count-stage'}).then(function(r){
            $('#count-tab1').html(r.pre_wait+' รายการ');
            $('#count-tab2').html(r.pre_comp+' รายการ');
            $('#count-tab3').html(r.inst_wait+' รายการ');
            $('#count-tab4').html(r.inst_comp+' รายการ');
        });

        api({method: 'get', url: '/inner-api/app/type-all'}).then(function(r){
            boards.at.main = r.main;
            boards.at.sub = r.sub;

            let opt;

            $.each(r.main, function(k,v){
                opt = '<option value="'+v.name+'">'+v.name+'</option>';
                $(mf.s[0].ip).append(opt);
            });

            $('#sat-main').prop('disabled',false);
            $('#sat-sub').prop('disabled',false);
            $('#sip').prop('disabled',false);
            boards.getData(); 
        });
    },
    getData(){   
        const vt = $('.btn-dashboard.active').attr('data-tab');
        const st = {
            method: 'post',
            url: '/inner-api/boards',
            data: {}
        };
          
        switch(Number(vt)){
            case 1:
                st.data.stage = 'pre-screen';
                st.data.status = 'wait';
            break;
            case 2:
                st.data.stage = 'pre-screen';
                st.data.status = 'finish';
            break;
            case 3:
                st.data.stage = 'in-plate';
                st.data.status = 'wait';
            break;
            case 4:
                st.data.stage = 'in-plate';
                st.data.status = 'finish';
            break;
        }
        
        api(st).then(function(rs){
            $('#sat-main').val('');
            $('#sat-sub').val('');
            $('#sip').val('');
            
            if(rs.result == 'success'){
                boards.dt = rs.data;
                boards.setDataTable(rs.data);
            } else {
                boards.dt = [];
                boards.setDataTable([]);
            }
        })
    },    
    setDataTable(dt){
        if(!$.fn.DataTable.isDataTable('#tbl-boards')){
            this.dtb = $('#tbl-boards').DataTable({
                data: dt,
                pageLength: 15,
                procressing: true,
                info: true,
                filter: true,
                lengthChange: false,
                columns: [
                    { data: 'no' },
                    { 
                        data: 'att_name',
                        render: function(data, type, row, meta){
                            const hr = 'href="javascript:boards.show('+row.id+');"';
                            let content = '<a '+hr+'>';
                            content += '<i class="bi bi-arrow-right-square-fill text-success mr-2"></i>';
                            content += data;

                            switch(Number(row.status)){
                                case 1:
                                    content += '<span class="badge badge-wait ml-1">';
                                    content += 'รอการประเมิน</span>';
                                break;
                                case 2:
                                    content += '<span class="badge badge-estimate ml-1">';
                                    content += 'กำลังประเมิน</span>';
                                break;
                                case 3:
                                    content += '<span class="badge badge-pass ml-1">';
                                    content += 'ประเมินเรียบร้อย</span>';
                                break;
                                case 4:
                                    content += '<span class="badge badge-notpass ml-1">';
                                    content += 'ไม่ผ่านประเมิน</span>';
                                break;
                            }
                            
                            content += '</a>';
                            return content;
                        }
                    },
                    { data: 'type' },
                    { data: 'section' },
                    { 
                        data: 'status',
                        render: function(data, type, row, meta){
                            let content;
                            switch(Number(data)){
                                case 1:
                                    content = '<span class="wait">';
                                    content += 'รอการประเมิน</span>';
                                break;
                                case 2:
                                    content = '<span class="estimate">';
                                    content += 'กำลังประเมิน</span>';
                                break;
                                case 3:
                                    content = '<span class="pass">';
                                    content += 'ประเมินเรียบร้อย</span>';
                                break;
                                case 4:
                                    content = '<span class="notpass">';
                                    content += 'ไม่ผ่านประเมิน</span>';
                                break;
                            }

                            return content;
                        }
                    },
                    { data: 'updated_at' },
                    { 
                        data: 'status',
                        render: function(data, type, row, meta){
                            let content,href;
                            href = getBaseUrl()+'/boards/estimate/pre-screen/'+row.id;

                            content = '<a href="javascript:;">';
                            content += '<i class="bi bi-toggles"></i></a>';
                            content += '<a href="'+href+'">';
                            content += '<i class="bi bi-pencil-square"></i></a>';
                            return content;
                        }
                    },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'no',
                        searchable: false,
                        orderable: false
                    },
                    { targets: 1, className: 'landmark' },
                    { targets: 2, className: 'type' },
                    { targets: 3, className: 'section' },
                    { targets: 4, className: 'status' },
                    { targets: 5, className: 'date' },
                    { 
                        targets: 6, 
                        className: 'edit',
                        searchable: false,
                        orderable: false
                    },
                ],
                order: [[5,'asc']],
                language: {
                    emptyTable: "ไม่มีรายการข้อมูล",
                    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    infoEmpty: "",
                    zeroRecords: "ไม่พบข้อมูลที่ค้นหา"
                },
                drawCallback: function(data, type, row, meta) {
                    $('.dataTables_paginate ul').addClass('pagination-sm justify-content-end');
                }                
            });        
        } else {
            this.dtb.clear().rows.add(dt).draw(); 
        }  

        this.dtb.on('order.dt search.dt', function() {
            let i = 1;

            boards.dtb.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    },
    searchAll(){
        if($.fn.DataTable.isDataTable('#tbl-boards')){
            const s1 = $('#sat-main');
            const s2 = $('#sat-sub');
            const s3 = $('#sip');
            this.dtb.columns(2).search(s1.val()).draw();
            this.dtb.columns(3).search(s2.val()).draw();
            this.dtb.search(s3.val()).draw();
        }   
    },
    show(id){
        const ref = this.dt.find(el => el.id == id);
        
        $('#modal-plate').html(ref.att_name);
        $('#modal-appt').html(ref.type);
        $('#modal-appts').html(ref.section);
        
        $('#modal-badge').removeClass('badge-wait, badge-estimate, badge-pass, badge-notpass');
        switch(Number(ref.status)){
            case 1: 
                $('#modal-badge').html('รอการประเมิน');
                $('#modal-badge').addClass('badge-wait');
            break;
            case 2: 
                $('#modal-badge').html('กำลังประเมิน');
                $('#modal-badge').addClass('badge-estimate');
            break;
            case 3: 
                $('#modal-badge').html('ประเมินเรียบร้อย');
                $('#modal-badge').addClass('badge-pass');
            break;
            case 4: 
                $('#modal-badge').html('ไม่ผ่านประเมิน');
                $('#modal-badge').addClass('badge-notpass');
            break;
        }

        $('#modal-date').html(ref.updated_at);
        $('#modal-detail').attr('data-id',ref.id);
        $('#modal-detail').modal('show');
    }
}

$('#sat-main').on('change',function(){
    const val = $(this).val();
    let opt;
    opt = '<option value="" selected>ทั้งหมด</option>';

    if(!empty(val)){        
        $.each(boards.at.main, function(km,vm){
            if(vm.name == val){
                $.each(boards.at.sub, function(ks,vs){
                    if(vs.application_type_id == vm.id){
                        opt += '<option value="'+vs.name+'">'+vs.name+'</option>';
                    }
                });

                return false;
            }
        });
    }
        
    $('#sat-sub').html(opt);
});

$('.btn-dashboard').click(function(){
    $('.btn-dashboard').removeClass('active');
    $(this).toggleClass('active');
    $('.fs-title').html('รายการ '+$(this)[0].innerHTML);
    boards.getData();
});

const mf = {
    s: [
        { ip: '#sat-main', id: 'sat-main' },
        { ip: '#sat-sub', id: 'sat-sub' },
        { ip: '#sip', id: 'sip' },
    ],
}