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
            <div class="modal-body">
                Deseja realmente confirmar a saída do cliente do quarto?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger">Finalizar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    (function (){
        var modal = $('#{{ $id }}');
        var modalForm = modal.find('form').first();
        var modalTitle = modal.find('.modal-title').first();
        var modalBody = modal.find('.modal-body').first();
        var buttonCancel = modal.find('.btn-secondary[data-dismiss="modal"]').first();
        var buttonFinish = modal.find('.btn-danger').first();

        var action = '';
        var title = '';
        var text = '';

        buttonFinish.on('click', function(e){
            e.preventDefault();
            let metaCsrf = document.querySelector('meta[name="csrf-token"]');
            let xhr = new XMLHttpRequest();
            xhr.open('PUT', action, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', metaCsrf.getAttribute('content'));
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.send();

            xhr.addEventListener('readystatechange', function() {
                if( xhr.readyState === 4 && xhr.status === 200){
                    data = JSON.parse(xhr.responseText);
                    window.location.href = "{{ route('system.dashboard') }}";
                    // modal.modal('hide');
                }
            }, false);
        });

        modal.on('show.bs.modal', function (e) {
            action = $(e.relatedTarget).data('action');
            title = $(e.relatedTarget).data('title');
            text = $(e.relatedTarget).data('text');
            modalForm.attr('action', action);
            modalTitle.text(title);
            modalBody.text(text);
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
@endpush