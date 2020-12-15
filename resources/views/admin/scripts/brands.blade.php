<script>
    $(document).ready(function () {
        /*add category*/
        $('#submit').click(function(){
            let name = $('#name').val();
            let is_parent = null;
            let slug = $('#slug').val();
            let logo = $('#thumbnail').val();
            $.ajax({
                method: "POST",
                url: "{{ route('brands.store') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}",name:name,slug:slug, logo: logo},
                success: function(response) {
                    $('#name').val('');
                    $('#slug').val('');
                    $('#thumbnail').val('');
                    $('#holder').removeAttr('src');
                    javaAlert(response);
                    $.ajax({
                        method: "GET",
                        url: "{{ route('brandLastData') }}",
                        dataType: 'json',
                        success: function(response) {
                            let lastData = response.lastData;
                            let image = lastData.logo;
                            var editUrl = '{{ route("editBrand", ":data") }}';
                            editUrl = editUrl.replace(':data', lastData.slug);
                            let html = "";
                            html += "<tr id='"+lastData.id+"'>";
                            html += "<input type='hidden' value='"+lastData.id+"'>";
                            html += "<td style='padding: 6px 9px;'>"+lastData.name+"</td>";
                            html += "<td style='padding: 6px 9px;'><span>"+lastData.slug+"</span></td>";
                            html += "<td style='padding: 6px 9px;'><span><img src='"+image+"' class='list-logo'></span></td>";
                            html += "<td style='padding: 6px 14px;'><a href='"+editUrl+"'><button type='button' value='"+lastData.id+"' class='btn btn-primary btn-xs waves-effect waves-light'><i class='fa fa-pencil-square-o'></i></button></a> <button type='button' value='"+lastData.id+"' class='btn-xs btn btn-danger waves-effect waves-light lastDataDelete'><i class='fa fa-trash-o'></i></button></td>";
                            $('#check tr:first').before(html);
                        },
                    });

                    $('#parentcategories').empty();

                },
                error: function(response){
                    $('#name').val();
                    $('#slug').val();
                    let data = response.responseJSON.errors;
                    $.each( data, function( key, value ) {
                        $( "<span class='validation-errors text-danger'>"+value+"</span>" ).insertAfter( "#"+key );
                    });
                }
            })
        });
        /*add category*/


        /*delete*/
        $(document).on("click", "#check tr td .table-delete", function() {
            if(confirm("Are you sure, you want to delete this brand?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("brands.destroy", ":data") }}';

                url = url.replace(':data', data);

                var rowDelete = $(this).closest('tr').fadeOut();

                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE"},
                    success(response){
                        
                        javaAlert(response);
                   
                        rowDelete;

                    },

                    error: function(response){

                        let data = response.responseJSON.errors;

                        $.each( data, function( key, value ) {
                            $( "<span class='validation-errors text-danger'>"+value+"</span>" ).insertAfter( "#"+key );
                        });
                    }
                });
            }
        });

        $(document).on("click", "#check tr td .lastDataDelete", function() {
            if(confirm("Are you sure, you want to delete this category?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();
                var url = '{{ route("brands.destroy", ":data") }}';

                url = url.replace(':data', data);

                var rowDelete = $(this).closest('tr').fadeOut();

                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE"},
                    success(response){

                        javaAlert(response);

                        rowDelete;

                    },

                    error: function(response){

                        let data = response.responseJSON.errors;

                        $.each( data, function( key, value ) {
                            $( "<span class='validation-errors text-danger'>"+value+"</span>" ).insertAfter( "#"+key );
                        });
                    }
                });
            }
        });
      
    })
</script>
