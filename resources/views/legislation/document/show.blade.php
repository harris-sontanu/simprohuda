<div class="modal-header">
    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Pratinjau Dokumen {{ $document->requirement->title }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if ($document->ext === 'pdf')
        <iframe
            src="{{ asset('assets/js/plugins/pdfjs/web/viewer.html') }}?file={{ $document->source }}" 
            width="100%"
            height="600px"
        ></iframe>
    @else                                        
        <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ asset($document->source) }}' width='100%' height='650px' frameborder='0'></iframe>
    @endif   
</div>