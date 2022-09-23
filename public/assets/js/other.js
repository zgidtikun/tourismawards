async function loading(action){
    if(action == 'show') $('#loading-page').addClass('loading');
    else $('#loading-page').removeClass('loading');    
}

function empty(data){
    if($.isArray(data)) {
        if(data.length > 0)
            return true;
    }
    else if($.type(data) === 'object'){
        if(!$.isEmptyObject(data))
            return true;
    }
    else if(data == '' || data === null || data === undefined || data === 'undefined')
        return true;
    return false;
}