const getBaseUrl = () => {
    return window.location.origin
}

const loading = async(action) => {
    if(action == 'show') $('#loading-page').addClass('loading');
    else $('#loading-page').removeClass('loading');    
}

const empty = (data) =>{
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

const api = async(setting) => {
    return new Promise(function(resolve, reject){
        let setAjax = {
            url: getBaseUrl()+setting.url,
            async: false,
        };

        switch(setting.method){
            case 'get':
                setAjax.type = 'get';
            break;
            case 'post':
            case 'action':
                setAjax.type = 'post',
                setAjax.data = setting.data,
                setAjax.dataType = 'json';

                if(setting.method == 'action'){
                    setAjax.contentType = false,
                    setAjax.processData = false;
                }
            break;
        }

        let request = $.ajax(setAjax);
        request.done(function(response){
            resolve(response);
        })
        .fail(function(jqXHR, textStatus){
            reject({
                result: 'error',
                message: 'Request failed: '+textStatus
            });
        });
    });
}