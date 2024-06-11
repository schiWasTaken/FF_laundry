<div class="modal fade" id={{ $modalId }} tabindex="-1" aria-labelledby={{ $modalId }} aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id={{ $modalId }}>{{ $modalTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!!html_entity_decode($modalContent)!!}
        </div>
    </div>
</div>