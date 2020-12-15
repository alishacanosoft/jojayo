<script>
    $(document).ready(function () {

        /*parent categories*/
        function getParentCategory(){
            $.ajax({
                method: "GET",
                url: "{{ route('postparentCategories') }}",
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
            let is_parent = null;
            let parent = $('#parentcategories').val();
            if(parent == 0){
                is_parent = 1;
                parent = null;
            } else {
                is_parent = 0;
                parent = parent;
            }
            let slug = $('#slug').val();
            $.ajax({
                method: "POST",
                url: "{{ route('category.store') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}",name:name,is_parent:is_parent,parent:parent, slug:slug},
                success: function(response) {
                    $('#name').val('');
                    $('#slug').val('');
                    javaSuccess(response.data);
                    $.ajax({
                        method: "GET",
                        url: "{{ route('lastData') }}",
                        dataType: 'json',
                        success: function(response) {
                            let lastData = response.lastData; console.log(lastData)
                            let cat = lastData.parent == null ? '-': lastData.parentCategory.name;
                            var editUrl = '{{ route("editPostCategory", ":data") }}';
                            editUrl = editUrl.replace(':data', lastData.slug);
                            let html = "";
                            html += "<tr id='"+response.id+"'>";
                            html += "<input type='hidden' value='"+lastData.id+"'>";
                            html += "<td style='padding: 6px 9px;'>"+lastData.name+"</td>";
                            html += "<td style='padding: 6px 9px;'><span>"+lastData.slug+"</span></td>";
                            html += "<td style='padding: 6px 9px;'><span>"+cat+"</span></td>";
                            html += "<td style='padding: 6px 14px;'><a href='"+editUrl+"'><button type='button' value='"+response.id+"' class='btn btn-primary btn-sm waves-effect waves-light'><span class='feather icon-edit-1'></span></button></a> <button type='button' value='"+response.id+"' class='btn-sm btn btn-danger waves-effect waves-light lastDataDelete'><span class='feather icon-trash-2 close-card'></span></button></td>";
                            $('#check tr:first').before(html);
                        },
                    });

                    $('#parentcategories').empty();

                    getParentCategory();

                },
                error: function(response){  console.log(response)
                    $('#name').val();
                    $('#slug').val();
                    let data = response.responseJSON.error;
                    $.each( data, function( key, value ) {
                        $( "<span class='validation-errors text-danger'>"+value+"</span><br>" ).insertAfter( "#"+key );
                    });
                }
            })
        });

        /*add category*/


        /*delete*/
        $(document).on("click", "#check tr td .table-delete", function() {
            if(confirm("Are you sure, you want to delete this category?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("category.destroy", ":data") }}';

                url = url.replace(':data', data);

                var rowDelete = $(this).closest('tr').fadeOut();

                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE"},
                    success(response){

                        javaSuccess(response.data);

                        $('#parentcategories').empty();

                        getParentCategory();

                        rowDelete;

                    },

                    error: function(response){

                        let data = response.responseJSON.errors;

                        $.each( data, function( key, value ) {
                            $( "<span class='validation-errors text-danger'>"+value+"</span><br>" ).insertAfter( "#"+key );
                        });
                    }
                });
            }
        });

        $(document).on("click", "#check tr td .lastDataDelete", function() {
            if(confirm("Are you sure, you want to delete this category?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("category.destroy", ":data") }}';

                url = url.replace(':data', data);

                var rowDelete = $(this).closest('tr').fadeOut();

                $.ajax({
                    method: "POST",
                    url: url,
                    dataType: 'json',
                    data: { _token:"{{ csrf_token() }}", _method:"DELETE"},
                    success(response){

                        javaSuccess(response.data);

                        $('#parentcategories').empty();

                        getParentCategory();

                        rowDelete;

                    },

                    error: function(response){

                        let data = response.responseJSON.errors;

                        $.each( data, function( key, value ) {
                            $( "<span class='validation-errors text-danger'>"+value+"</span><br>" ).insertAfter( "#"+key );
                        });
                    }
                });
            }
        });
    })
</script>
<script>
    $("#name").keyup(function (){
        let Slug = $('#name').val();
        document.getElementById("slug").value = convertToSlug(Slug);
    });
</script>