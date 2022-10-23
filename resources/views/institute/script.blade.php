<script>
    $(function() {

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        $('.delete-form').submit(function(e) {
            e.preventDefault();

            let name = $(this).data('name'),
                form = $(this);
            
            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: 'Apakah Anda yakin menghapus data perangkat daerah <strong>' + name + '</strong>?',
                buttons: {
                    confirm: {
                        label: 'Yakin',
                        className: 'btn-indigo'
                    },
                    cancel: {
                        label: 'Batal',
                        className: 'btn-link'
                    }
                },
                callback: function (result) {
                    if (result == true) {
                        form.unbind('submit').submit();
                    }
                }
            });
        })

    })
</script>