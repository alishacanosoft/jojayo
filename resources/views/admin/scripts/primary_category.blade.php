<script>
    $(document).ready(function () {

        /*add category*/
        $('#submit').click(function(){
            let name = $('#name').val();
            $.ajax({
                method: "POST",
                url: "{{ route('primary_categories.store') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}",name:name},
                success: function(response) {
                    $('#name').val('');
                    javaAlert(response);
                    $.ajax({
                        method: "GET",
                        url: "{{ route('PrimarylastData') }}",
                        dataType: 'json',
                        success: function(response) {
                            let lastData = response.lastData;
                            let cat = lastData.category_id == null ? '-': lastData.category_id;
                            var editUrl = '{{ route("primary_categories.edit", ":data") }}';
                            editUrl = editUrl.replace(':data', lastData.id);
                            let html = "";
                            html += "<tr id='"+response.id+"'>";
                            html += "<input type='hidden' value='"+lastData.id+"'>";
                            html += "<td style='padding: 12px 10px;'>"+lastData.name+"</td>";
                            html += "<td style='padding: 12px 10px;'><a href='"+editUrl+"'><button type='button' value='"+lastData.id+"' class='btn btn-primary btn-xs waves-effect waves-light'><i class='fa fa-pencil-square-o'></i></button></a> <button type='button' value='"+lastData.id+"' class='btn-xs btn btn-danger waves-effect waves-light lastDataDelete'><i class='fa fa-trash-o'></i></button></td>";
                            $('#check tr:first').before(html);
                        },
                    });

                },
                error: function(response){
                    $('#name').val();
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
            if(confirm("Are you sure, you want to delete this category? Removing this category will delete product with in this category."))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("primary_categories.destroy", ":data") }}';

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

                var url = '{{ route("primary_categories.destroy", ":data") }}';

                url = url.replace(':data', data);

                var rowDelete = $(this).closest('tr').fadeOut();

                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE"},
                    success(response){

                        javaAlert(response);

                        $('#parentcategories').empty();

                        getParentCategory();

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
        /*delete*/
    })
</script>
