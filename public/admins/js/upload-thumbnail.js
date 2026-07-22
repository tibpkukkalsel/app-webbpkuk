function uploadFile(){

    $('#file-thumbail').click();

}

$(document).on('change','#file-thumbail',function(){

    let file=this.files[0];

    if(file){

        let reader=new FileReader();

        reader.onload=function(e){

            $('#preview-thumb').attr('src',e.target.result);

        }

        reader.readAsDataURL(file);

    }

});