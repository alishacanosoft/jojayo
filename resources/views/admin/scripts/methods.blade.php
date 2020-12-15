<script>
    $(document).ready(function () {
        /*add category*/
        $('#submit').click(function(){
            let name = $('#name').val();
            $.ajax({
                method: "POST",
                url: "{{ route('payments.store') }}",
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}",name:name},
                success: function(response) {
                    $('#name').val('');
                    javaSuccess(response.data);
                    $.ajax({
                        method: "GET",
                        url: "{{ route('lastPaymentData') }}",
                        dataType: 'json',
                        success: function(response) {
                            let lastData = response.lastData; console.log(lastData)
                            var editUrl = '{{ route("payments.edit", ":data") }}';
                            editUrl = editUrl.replace(':data', lastData.id);
                            let html = "";
                            html += "<tr id='"+response.id+"'>";
                            html += "<input type='hidden' value='"+lastData.id+"'>";
                            html += "<td style='padding: 6px 9px;'>"+lastData.name+"</td>";
                            html += "<td style='padding: 6px 14px;'><a href='"+editUrl+"'><button type='button' value='"+response.id+"' class='btn btn-primary btn-sm waves-effect waves-light'><span class='feather icon-edit-1'></span></button></a> <button type='button' value='"+response.id+"' class='btn-sm btn btn-danger waves-effect waves-light lastDataDelete'><span class='feather icon-trash-2 close-card'></span></button></td>";
                            $('#check tr:first').before(html);
                        },
                    });

                    $('#parentcategories').empty();

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
            if(confirm("Are you sure, you want to delete this payment method?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("payments.destroy", ":data") }}';

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
            if(confirm("Are you sure, you want to delete this payment method?"))
            {
                var data = $(this).closest('tr').find('input[type=hidden]').val();

                var url = '{{ route("payments.destroy", ":data") }}';

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

                        getMethod();

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
