const boards = {
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
            
            loading('hide');
        });
    },
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