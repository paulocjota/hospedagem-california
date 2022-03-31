@props([
    'id',
])

<div id="{{ $id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img class="img-fluid" src="http://localhost/file-server/product/pOPr01gsMCqXMUMDjUCV2pAb8IC8CGdvGuu4EgyD.jpg">
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        (function (){
            var modal = $('#{{ $id }}');
            var modalImg = modal.find('img').first();

            modal.on('show.bs.modal', function (e) {
                modalImg.attr('src', $(e.relatedTarget).data('img') );
            });

            modal.on('hidden.bs.modal', function (e) {
                modalImg.removeAttr('src');
            });
        })();
    </script>
@endpush