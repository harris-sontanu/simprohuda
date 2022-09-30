<script>
    $(function() {

        $('.select-search').select2();

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        $(document).on('change', '.custom-file-input', function() {
            let filename = $(this)[0].files[0].name;
            $(this).next().html(filename);
        })

        const daterangepickerConfig = {
            parentEl: '.content-inner',
            autoApply: true,
            singleDatePicker: true,
            autoUpdateInput: false,
            applyButtonClasses : 'btn-secondary',
            locale: {
                format: 'DD-MM-YYYY',
                applyLabel: "Ok",
                cancelLabel: "Batal",
                fromLabel: "Dari",
                toLabel: "Ke",
                daysOfWeek: [
                    "Mg",
                    "Sn",
                    "Sl",
                    "Rb",
                    "Km",
                    "Jm",
                    "Sb"
                ],
                monthNames: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
            }
        }

        if ($().daterangepicker) {
            $('.daterange-single').daterangepicker(daterangepickerConfig);

            $('.daterange-single').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });

            $('.daterange-single').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            daterangepickerConfig.timePicker = true;
            daterangepickerConfig.timePicker24Hour = true;
            $('.datetimerange-single').daterangepicker(daterangepickerConfig);

            $('.datetimerange-single').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY HH:mm'));
            });

            $('.datetimerange-single').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        }

        if ($().finderSelect) {
            new findData();
        }

        $(document).on('click', '.trigger', function() {
            let items  = new collect_data(),
                action = $(this).data('action'),
                val    = $(this).data('val');

            if (action === 'delete') {
                bootbox.confirm({
                    title: 'Konfirmasi Perintah',
                    message: 'Apakah Anda yakin ingin menghapus rancangan produk hukum?',
                    buttons: {
                        confirm: {
                            label: 'Yakin',
                            className: 'btn-secondary'
                        },
                        cancel: {
                            label: 'Batal',
                            className: 'btn-link'
                        }
                    },
                    callback: function (result) {
                        if (result == true) {
                            triggerAction(items, action, val);
                        }
                    }
                });
            } else {
                triggerAction(items, action, val);
            }
        })

        $('.delete-form').submit(function(e) {
            e.preventDefault();

            let form = $(this);

            bootbox.confirm({
                title: 'Konfirmasi Perintah',
                message: 'Apakah Anda yakin ingin menghapus rancangan produk hukum?',
                buttons: {
                    confirm: {
                        label: 'Yakin',
                        className: 'btn-secondary'
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
        
        $('#filter').click(function() {
            $('#filter-options').slideToggle('fast');
        })

        $('.reset').click(function() {
            $('.filter-form').trigger('reset');
            $('.daterange-single').val('');
        })

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });

        $(document).on('click', '.new-attachment', function() {

            let html = '<div class="my-3"><input type="text" class="form-control" name="attachments[][title]" placeholder="Judul Lampiran" /></div>'
                     + '<div class="custom-file">'
                     + '<input id="customFile" type="file" class="custom-file-input" name="attachments[][file]" accept=".pdf, .doc, .docx">'
                     + '<label class="custom-file-label" for="customFile">Choose file</label>'
                     + '</div>';

            $(this).before(html);
        })

        $('#upload-doc-modal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget), // Button that triggered the modal
                action = button.data('action');

            if (action == 'create') {
                var legislation = button.data('legislation'),
                    title = button.data('title'),
                    type = button.data('type'),
                    order = button.data('order'),
                    data = {legislation_id:legislation, title:title, action:action, type:type, order:order};
            } else if (action == 'edit') {
                var id = button.data('id'),
                    data = {id:id, action:action};
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post( "/legislation/document/modal", data)
                .done(function(html) {
                    $('#ajax-modal-body').html(html);
                })
        });
        
    })

    function triggerAction(items, action, val) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/legislation/perda/trigger',
            method: 'POST',
            data: {'items':items, 'action': action, 'val': val}
        }).done(function(){
            location.reload();
        })
    }

    function collect_data(){
        var array_item_id = [];
        $('.checkbox:checked').each(function() {
            array_item_id.push($(this).data('item'));
        });
        return array_item_id;
    }

    function findData(){

        // Initialise the Demo with the Ctrl Click Functionality as the Default
        var list = $('.table tbody').finderSelect({enableDesktopCtrlDefault:true, selectClass:'table-info'});

        // Add a hook to the highlight function so that checkboxes in the selection are also checked.
        list.finderSelect('addHook','highlight:before', function(el) {
            el.find('input').prop('checked', true);
            $('#bulk-actions').show();
            let i = $('.table .checkbox:checked').length;
            $('#count-selected').html(i);
        });

        // Add a hook to the unHighlight function so that checkboxes in the selection are also unchecked.
        list.finderSelect('addHook','unHighlight:before', function(el) {
            el.find('input').prop('checked', false);
            let i = $('.table .checkbox:checked').length;
            if (i === 0) {
                $('#bulk-actions').hide();
            } else {
                $('#count-selected').html(i);
            }
        });

        // Add a Safe Zone to show not all child elements have to be active.
        $(".safezone").on("mousedown", function(e){
            return false;
        });

        // Prevent Checkboxes from being triggered twice when click on directly.
        list.on("click", "input[type='checkbox']", function(e){
            e.preventDefault();
        });

        // Add Select All functionality to the checkbox in the table header row.
        $('.table').find("thead input[type='checkbox']").change(function () {
            if ($(this).is(':checked')) {
                list.finderSelect('highlightAll');
                $('#bulk-actions').show();
                let i = $('.table .checkbox:checked').length;
                $('#count-selected').html(i);
            } else {
                list.finderSelect('unHighlightAll');
                $('#bulk-actions').hide();
            }
        });
    }
</script>
