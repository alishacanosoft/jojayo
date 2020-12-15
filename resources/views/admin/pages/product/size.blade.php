<div class="form-group div" id="appendDiv{{$number}}">
    <div class="row">
        <label class="col-sm-2 control-label"></label>
        <div class="col-md-10 col-lg-9 col-sm-12">
             <select name="imageColor[]" id="colorsData{{$number}}" class="form-control selectebox">
                   <option>--Select any One--</option>
                   <option value="15">Aqua</option>
                   <option value="4">Black</option>
                   <option value="3">Blue</option>
                   <option value="22">Bubblegum Pink</option>
                   <option value="29">Capri Blue</option>
                   <option value="28">Cobalt</option>
                   <option value="19">Coral</option>
                   <option value="18">Coral rose</option>
                   <option value="26">Fuchsia</option>
                   <option value="34">Grape</option>
                   <option value="13">Green</option>
                   <option value="23">Hot Pink</option>
                   <option value="30">Jade</option>
                   <option value="33">Lavender</option>
                   <option value="32">Light Orchid</option>
                   <option value="20">Light Pink</option>
                   <option value="12">Lime</option>
                   <option value="7">Maroon</option>
                   <option value="35">Mint</option>
                   <option value="10">Navy blue</option>
                   <option value="14">Ocean blue</option>
                   <option value="6">Orange</option>
                   <option value="21">Pearl Pink</option>
                   <option value="8">Pink</option>
                   <option value="16">Plum</option>
                   <option value="17">Poppy red</option>
                   <option value="11">Purple</option>
                   <option value="1">Red</option>
                   <option value="9">Royal blue</option>
                   <option value="24">Shocking Pink</option>
                   <option value="31">Teal</option>
                   <option value="27">Tropic</option>
                   <option value="5">White</option>
                   <option value="25">Wine</option>
                   <option value="2">Yellow</option>
               </select>
            </div>
            <div class="col-md-10 col-lg-1 col-sm-12">                
                <span class="btn btn-xs text-danger" id="removeColorDiv{{$number}}"><i class="fa fa-trash"></i></span>
            </div>
        </div>
        <p></p>        
        <div class="row">
            <label class="col-sm-2 control-label"></label>
            <div class="col-md-10 col-lg-10 col-sm-12">
                <select name="" id="demosize{{$number}}" class="form-control" multiple="multiple">
                    @foreach($allSizes as $size)
                        <option value="{{$size->id}}">{{$size->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <p></p>
        <div class="row" id="firstFileUploader">
            <label class="col-sm-2 control-label"></label>
            <div class="col-md-10 col-lg-10 col-sm-12">
                <div class="dropzone">
                    <div class="drop-upload" aria-disabled="false">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail{{$number}}" data-preview="holder{{$number}}" style="border: 1px dashed rgb(196, 198, 207); border-radius: 2px; width: 140px; height: 45px; background-color: rgb(255, 255, 255); text-align: center; cursor: pointer; transition: border-color 0.3s ease 0s; display: inline-block; vertical-align: top;">
                                    <img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_MediaCenter.png" style="position: relative;">
                                    <span class="upload-text" data-spm-anchor-id="0.0.p-30129.i2.81e84edfnX8IMm" style="font-size: 14px; position: relative; top: 10px; color: rgb(102, 102, 102); width: 96px; display: inline-block; text-align: left; margin-left: 10px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Media Center</span>
                                </a>
                            </span>
                            <input id="thumbnail{{$number}}" class="form-control hidden" type="text" name="image[]">
                            <span class="lfmholder" id="holder{{$number}}" style="max-height:100px;margin-left:10px;display:flex"> </span>
                        </div>
                    <div class="medi">
                        <div class="file-upload">
                            <input type="file" class="files" name="images[]" multiple="">
                            <img src="//laz-g-cdn.alicdn.com/lazada/lib/0.0.81/image/publish/IC_upload.png" style="position: relative;top: 11px;height: 16px;width: 16px;margin-left: 8px;">
                            <span class="upload-text">Upload</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><p></p>
</div>

<script>
    $('#colorsData'+{{$number}}).on('change',function(){
        var selected_color = $(this).find(":selected").val();
        var selected_c_name = $(this).find(":selected").text();   
        var html = '';  
        num = {{$number}}+1;
        let cat_id = $('#category_id :selected').val();
        $.ajax({
            url: "{{ route('getsize') }}",
            method: 'POST',
            data: { _token:"{{ csrf_token() }}", _method:"POST", cat_id: cat_id, num: num},
            success:function(response){
                $('#append').append(response);
                $('#demosize'+num).select2({placeholder: 'Select available sizes for this color'});
                $('#demosize'+num).on('change', function(){
                var selected_size = $(this).find(":selected").get().reduce((ob, el) => {
                    ob[el.value] = el.textContent;
                    return ob
                }, {});
                $.ajax({
                  url: "{{ route('getrecent') }}",
                  method: 'POST',
                  data: { _token:"{{ csrf_token() }}", _method:"POST", selected_size: selected_size, num: num,selected_color:selected_color,selected_c_name:selected_c_name},
                  success:function(response){
                     $('#appendDiv'+(num-2)).append(response);
                  }
                });
                // html = '<div class="row size-row" style="margin-top: 5px;"><label class="col-sm-2 control-label"></label><div class="col-md-2 col-lg-2"><select class="form-control" name="color[]" id="sizesData"><option value="'+selected_color+'">'+selected_c_name+'</option></select></div><div class="col-md-1 col-lg-1"><select class="form-control" name="size[]" id="sizesData'+num+'">';
                // $.each(selected_size, function(key, value) {
                //     html += '<option value="'+key+'">'+value+'</option>';
                // });
                // html += '</select></div><div class="col-md-2 col-lg-2"><input type="number" placeholder="availability" name="stock[]" class="form-control h-100"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="price[]" placeholder="Selling price"></div><div class="col-md-2 col-lg-2"><input class="form-control h-100" value="" type="text" name="discount[]" placeholder="discount"></div><div class="col-md-1 col-lg-1"><span class="btn btn-xs text-danger removeCurrent"><i class="fa fa-trash"></i></span></div></div>';                
                // $('#appendDiv'+(num-2)).append(html);
                })                 
                num++;
            }
        })
    })

    $('#removeColorDiv'+{{$number}}).on('click',function(){
        $('#appendDiv'+{{$number}}).remove()
    })
    $(document).on("click", ".removeCurrent", function() {
        $(this).closest('.size-row').remove();
    })

</script>
