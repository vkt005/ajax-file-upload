<form method="post" id="form_cnvc"class="form_cnvc">
   <p><input type="text" name="f_nm" value="" placeholder="type your first name"></p>
   <p><input type="text" name="l_nm" value="" placeholder="type your last name"></p>
   <div class="dropfile visible-lg">
   <input type="file" id="uploadfile" name="uploadfile">
   <span>Select Images(.jpg , .png, .bmp files) </span>
   <div id="output"></div>
   </div><p class="submit"><input type="submit" name="submit" value="post"></p>
 </form>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var a={
            completed  : '0%',
            output     :  $('#output'),
            file_field :  $('#uploadfile'), 
            url_phpscript_upload:'upload-file.php',
            max_no_upload:1
        }
        os_upload(a);
});
function os_upload(a){
    x=a.file_field; if($('#upd_msg').length==0) $( '<div id="upd_msg"></div>').insertAfter(x); 
   
        x.change(function() {
        var cd=$('.upload-result').length; console.log("loadcount"+cd);
        cd=parseInt(cd);
      if( cd < a.max_no_upload){
        var f=x.parents('form')[0];
        var formData = new FormData(f);
        $.ajax({
            url: a.url_phpscript_upload,  //Server script to process data
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            xhr: function ()
            {
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload)
                {
                    myXhr.upload.addEventListener('progress', updateProgress, false);
                }
                return myXhr;
            },
            complete: function(response) { 
            var resp=JSON.parse(response.responseText);
            if(resp.status==='Succcess'){ 
                 a.output.append('<div class="upload-result"><input type="hidden" name=[] value="'+resp.file+'"/>'+resp.file+'<button  type="button" class="rem_upload" >x</button></div>'); //update element with received data
                 x.attr('value','');
            }
            else if(resp.status==='Error'){ 
                $('#upd_msg').html(resp.msg);
            }
            $('#progressbox').slideUp(); // hide progressbar
            }
        }); } else{ $('#upd_msg').html('You can upload upto '+a.max_no_upload);}
       if(typeof live == 'function'){
            $('.rem_upload').live('click',function(){
            $(this).parents('.upload-result').fadeOut(300, function(){ $(this).remove();});
        });
        
        }else{
         $(document).on ('click', '.rem_upload', function () {
   $(this).parents('.upload-result').fadeOut(5000, function(){ $(this).remove();});
});
}
    });
    $( '<div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>').insertAfter(x); 
}
function updateProgress(evt)
{
    // evt is an ProgressEvent.
    if (evt.lengthComputable)
    {
        var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
        // Increase the progress bar length.
        $('#progressbox').show();
        $("div#progressbar").css({width: percentLoaded + '%'})
        $('#statustxt').html(percentLoaded+'%');
    }
}

</script>
<style type="text/css">
.upload-result {padding-right: 35px;padding: 5px 15px;font-size: 12px;background-color: #AAD2E5;border-color: #bce8f1;color: #fff;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px;-moz-box-sizing: border-box;box-sizing: border-box;-webkit-box-sizing: border-box;-o-box-sizing: border-box;width:400px;}
.close,.rem_upload {position: relative;top: -2px;right: 0px;color: inherit;padding: 0;cursor: pointer;background: 0 0;border: 0;-webkit-appearance: none;float: right;font-size: 21px;font-weight: 700;line-height: 1;text-shadow: 0 1px 0 #fff;opacity: .2;}
.pl{width:0%;height: auto;background: red;text-align: center;font-size: 10px}
#progress{width:500px;height: 10px;background: #ccc;}
#progressbox {border: 1px solid #0099CC;padding: 1px; position:relative;width:400px;border-radius: 3px;margin: 10px;display:none;text-align:left;}
#progressbar {height:20px;border-radius: 3px;background-color: #003333;width:1%;}
#statustxt {top:3px;left:50%;position:absolute;display:inline-block;color: #F38484;}
.rem_upload{display: inline-block;width: 20px;font-size: 12px;font-family: verdana;}
.rem_upload:hover{color:#000}
</style>