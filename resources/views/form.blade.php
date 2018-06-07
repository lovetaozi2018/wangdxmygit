<form method="POST" action="http://sandbox:8080/photo/public/teachers/create" accept-charset="UTF-8" id="formTeacher" data-parsley-validate="true">

<div class="form-group">
    <label for="mobile" class="col-sm-3 control-label">手机号码</label>
    <div class="col-sm-6">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-phone"></i>
            </div>
            <input class="form-control" required="true" data-parsley-length="[11,11]" data-parsley-type="integer" placeholder="(请输入手机号码)" name="mobile" type="text" id="mobile">
        </div>
    </div>
</div>

    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-3">
            <input class="btn btn-primary pull-left" id="save" type="submit" value="保存">
            <input class="btn btn-default pull-right" id="cancel" type="reset" value="取消">
        </div>
    </div>

</form>
<script src="{{URL::asset('js/jquery.min.js')}}"></script>
<script>
    $('#save').on('click',function(e){
        e.preventDefault();
       var id=1;
       var mobile=$('#mobile').val();
       console.log(mobile);
       $.ajax({
           type: 'get',
           dataType: 'json',
           url: 'b/'+id,
           data: {'mobile':mobile},
           success: function (result) {
               if (result.statusCode === 200) {
                   $('#mobile').html(result.mobile);
               } else {
               }
           },
       });
    });
</script>
