<div class="modal-body">
    <p class="addressDisplay">Loading address...</p>
    <div id="map" style="width: 100%; height: 400px;"></div>
    <div class="mt-3">
        <label for="notes" class="form-label">Notes</label>
        <textarea id="notes" class="form-control" rows="4" style="resize: none;" placeholder="Additional address details or other notes..."></textarea>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="openBillModalButton" data-service="1" data-bs-toggle="modal" data-bs-target="#confirmPickupModal">Next</button>
</div>
