// Mix multi select from combobox
function mix_value(cbo_id, return_to){
    //alert('run');
    var foo = ''; 
    $('#' + cbo_id + ' :selected').each(function(i, selected){ 
        foo += ',' + $(selected).val(); 
    });
    if(foo.length > 1)
        foo = foo.substr(1);
    else
        foo = -1;
    $('#' + return_to).val(foo);
}