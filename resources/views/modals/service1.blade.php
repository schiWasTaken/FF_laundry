<div class="modal-body">
    <!-- Modal content goes here -->
    <p>Layanan cuci, kering, seterika dan lipat.</p>
    <div class="mt-3">
        <form id="service1Form">
            <label class="form-label">Pilih layanan:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="serviceType1" id="normalService1" value="normal" checked>
                <label class="form-check-label" for="normalService1">
                    {{ $prices['1']['normal']['description'] }}
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="serviceType1" id="expressService1" value="express">
                <label class="form-check-label" for="expressService1">
                    {{ $prices['1']['express']['description'] }}
                </label>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary confirmSelectionButton" data-service="1" data-bs-dismiss="modal">Select</button>
</div>