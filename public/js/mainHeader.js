


function commaSeparateNumber(val){

    if(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+'.'+'$2');
        }
        return val;
        }
    else {
        return 0;
    }

}


function commaDot(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/\./g, ',');
    }
    return val;
}
