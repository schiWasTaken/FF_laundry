<div class="modal-body">
    <!-- Modal content goes here -->
    <p>Put description here etc</p>
    <p>(Base 2kg)</p>
    <div class="mt-3">
        <form id="service1Form">
            <label class="form-label">Choose Service Type:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="serviceType1" id="normalService1" value="normal" checked>
                <label class="form-check-label" for="normalService1">
                    Normal (Rp 7.000,00 / 1kg, 2-3 days)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="serviceType1" id="expressService1" value="express">
                <label class="form-check-label" for="expressService1">
                    Express (Rp 10.000,00 / 1kg, 1 day)
                </label>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary confirmSelectionButton" data-service="1" data-bs-dismiss="modal">Select</button>
</div>