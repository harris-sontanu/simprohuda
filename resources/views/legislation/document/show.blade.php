<div class="modal-header">
    <h5 class="modal-title">Pratinjau Dokumen {{ $document->requirement->title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body p-0">
    @if ($document->ext === 'pdf')
        <iframe
            src="{{ asset('assets/js/vendor/pdfjs/web/viewer.html') }}?file={{ $document->source }}" 
            width="100%"
            height="600px"
        ></iframe>
    @else                                        
        <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ asset($document->source) }}' width='100%' height='650px' frameborder='0'></iframe>
    @endif   
</div>