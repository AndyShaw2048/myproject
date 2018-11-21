/**
 * Created by hasee on 2018-11-21.
 */
function http(_type,_url,_data,callback)
{
    $.ajax({
        type : _type,
        url  : _url,
        data : _data,
        dataType : 'json',
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data){
            callback(data);
        },
        error:function(){
            alert('Request Error');
        }
    });
}
