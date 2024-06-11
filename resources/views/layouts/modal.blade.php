<div class="modal fade" id={{ $modalId }} tabindex="-1" aria-labelledby={{ $modalId }} aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id={{ $modalId }}>{{ $modalTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal content goes here -->
                {!!html_entity_decode($modalContent)!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">{{ $buttonConfirm }}</button>
            </div>
        </div>
    </div>
</div>