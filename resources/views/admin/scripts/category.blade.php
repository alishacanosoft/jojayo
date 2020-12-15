<script>
    $(document).ready(function () {

        /*delete*/
        $(document).on("click", "#check tr td .table-delete", function() {
            if(confirm("Are you sure, you want to delete this category?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("product_categories.destroy", ":data") }}';

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
                            $( "<span class='validation-errors text-danger'>"+value+"</span>" ).insertAfter( "#"+key );
                        });
                    }
                });
            }
        });
        /*delete*/
    })
</script>
