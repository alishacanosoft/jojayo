<script>
    $(document).ready(function () {

        /*parent categories*/
        function getParentCategory(){
            $.ajax({
                method: "GET",
                url: "{{ route('primaryCategories') }}",
                dataType: 'json',
                success: function(response) {
                    let html = "<option value='0'>None</option>";
                    $.each( response, function( key, value ) {
                        html += "<option value='"+value.id+"'>"+value.name+"</option>";
                    });
                    $('#parentcategories').append(html);
                },
            });
        }
        getParentCategory();
        /*parent categories*/

        /*add category*/
        $('#submit').click(function(){
            let name = $('#name').val();
            let primary_category_id = $('#parentcategories').val();
            let slug = $('#slug').val();
            $.ajax({
                method: "POST",
                url: "{{ route('secondary_categories.store') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}",name:name, primary_category_id:primary_category_id, slug:slug},
                success: function(response) {
                    $('#name').val('');
                    $('#slug').val('');
                    javaAlert(response);
                    $.ajax({
                        method: "GET",
                        url: "{{ route('SecondarylastData') }}",
                        dataType: 'json',
                        success: function(response) {
                            let lastData = response.lastData;
                            let cat = lastData.primary_category_id == null ? '-': lastData.primary_category_id;
                            var editUrl = '{{ route("secondary_categories.edit", ":data") }}';
                            editUrl = editUrl.replace(':data', lastData.id);
                            let html = "";
                            html += "<tr id='"+response.id+"'>";
                            html += "<input type='hidden' value='"+lastData.id+"'>";
                            html += "<td style='padding: 6px 9px;'>"+lastData.name+"</td>";
                            html += "<td style='padding: 6px 9px;'><span>"+lastData.slug+"</span></td>";
                            html += "<td style='padding: 6px 9px;'><span>"+cat+"</span></td>";
                            html += "<td style='padding: 8px;'><a href='"+editUrl+"'><button type='button' value='"+lastData.id+"' class='btn btn-primary btn-xs waves-effect waves-light'><i class='fa fa-pencil-square-o'></i></button></a> <button type='button' value='"+lastData.id+"' class='btn-xs btn btn-danger waves-effect waves-light lastDataDelete'><i class='fa fa-trash-o'></i></button></td>";
                            $('#check tr:first').before(html);
                        },
                    });

                    $('#parentcategories').empty();

                    getParentCategory();

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
            if(confirm("Are you sure, you want to delete this category? Deleting this category will remove products within this category."))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("secondary_categories.destroy", ":data") }}';

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

        $(document).on("click", "#check tr td .lastDataDelete", function() {
            if(confirm("Are you sure, you want to delete this category?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("secondary_categories.destroy", ":data") }}';

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
