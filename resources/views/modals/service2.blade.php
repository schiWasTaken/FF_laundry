<div class="modal-body">
    <!-- Modal content goes here -->
    <p>Layanan seterika dan lipat.</p>
    <div class="mt-3">
        <form id="service2Form">
            <label class="form-label">Pilih layanan:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="serviceType2" id="normalService2" value="normal" checked>
                <label class="form-check-label" for="normalService2">
                    {{ $prices['2']['normal']['description'] }}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="serviceType2" id="expressService2" value="express">
                <label class="form-check-label" for="expressService2">
                    {{ $prices['2']['express']['description'] }}
                </label>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary confirmSelectionButton" data-service="2" data-bs-dismiss="modal">Select</button>
</div>