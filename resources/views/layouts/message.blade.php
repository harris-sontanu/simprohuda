@if (session('message'))
    <div class="alert alert-success border-0 alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        {!! session('message') !!}
    </div>
@elseif (session('error-message'))
    <div class="alert alert-danger border-0 alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        {!! session('error-message') !!}
    </div>
@elseif (session('trash-message'))
    <div class="alert alert-info border-0 alert-dismissible">
        @php
            list($message, $action) = session('trash-message');
        @endphp
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        {!! $message !!}
        <form action="{{ $action }}" method="post" class="d-inline-block">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-info btn-sm"><i class="icon-undo mr-2"></i>Batal</button>
        </form>
    </div>
@endif
