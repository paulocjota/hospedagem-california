@props([
    'id',
])

<div id="{{ $id }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <form action="#" method="POST" class="m-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
       (function (){
                var modal = $('#{{ $id }}');
                var modalForm = modal.find('form').first();
                var modalTitle = modal.find('.modal-title').first();
                var modalBody = modal.find('.modal-body').first();
                var buttonCancel = modal.find('.btn-secondary[data-dismiss="modal"]').first();

                modal.on('show.bs.modal', function (e) {
                    modalForm.attr('action', $(e.relatedTarget).data('action') );
                    modalTitle.text( $(e.relatedTarget).data('title') );
                    modalBody.text($(e.relatedTarget).data('text') );
                });

                modal.on('shown.bs.modal', function(e){
                    buttonCancel.trigger('focus');
                });

                modal.on('hidden.bs.modal', function (e) {
                    modalForm.attr('action', '#');
                    modalTitle.text('');
                    modalBody.text('');
                });
        })();
    </script>
@stop