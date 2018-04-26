<script>
    function show_notif(tipe, message){
        if(tipe == 201 || tipe == 200){
            $("#respon_server").attr('class','alert alert-success');
        } else {
            $("#respon_server").attr('class','alert alert-danger');
        }
        $("#respon_server .message").html(message);
        $("#respon_server").show('slow');
    }

    function save() 
    {
        var name = $("#name").val();

        var data = {
            name : name,
        }

        var dataSend = {
            data : JSON.stringify(data)
        }
        
        $.ajax({
            type: "POST",
            url: "/master/vesselType/saveVesselType",
            dataType: "json",
            data:dataSend,
            success: function (data) {
                show_notif(data.code, data.message);
                if (data.code==200 || data.code==201) {
                    $("#name").val("");
                }
            }
        })
    }
</script>