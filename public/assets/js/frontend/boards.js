const boards = {
    dtb: null,
    at: {},
    init(){
        api({method: 'get', url: '/inner-api/app/type-all'}).then(function(r){
            boards.at.main = r.main;
            boards.at.sub = r.sub;

            let opt;

            $.each(r.main, function(k,v){
                opt = '<option value="'+v.name+'">'+v.name+'</option>';
                $(mf.s[0].ip).append(opt);
            });

            boards.getData();
        });
    },
    getData(){                 
        loading('show');
        const vt = $('.btn-dashboard.active').attr('data-tab');
        const st = {};
        console.log(vt)     
        switch(Number(vt)){
            case 1:
                st.stage = 'pre-screen';
                st.status = 2;
            break;
            case 2:
                st.stage = 'pre-screen';
                st.status = 4;
            break;
            case 3:
                st.stage = 'in-plate';
                st.status = 1;
            break;
            case 4:
                st.stage = 'in-plate';
                st.status = 2;
            break;
        }
        
        st.method = 'post';
        st.url = '/inner-api/boards';

        loading('hide');
    },
    setData(){

    }
}

$('#sat-main').on('change',function(){
    let opt, id = $(this).val();
    opt = '<option value="0" selected>ทั้งหมด</option>'

    $.each(boards.at.sub, function(k,v){
        if(v.application_type_id == id){
            opt += '<option value="'+v.name+'">'+v.name+'</option>';
        }
    });

    $('#sat-sub').html(opt);
});

$('.btn-dashboard').click(function(){
    $('.btn-dashboard').removeClass('active');
    $(this).toggleClass('active');
    $('.fs-title').html('รายการ '+$(this)[0].innerHTML);
})

const mf = {
    s: [
        { ip: '#sat-main', id: 'sat-main' },
        { ip: '#sat-sub', id: 'sat-sub' },
        { ip: '#sip', id: 'sip' },
    ],
}