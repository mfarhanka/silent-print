<?php include 'header.php'; ?>

<!-- Business Card Customization Page -->
<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Customize Your Business Card</h2>
        <form action="#" method="post">
            <div class="row g-4">
                <div class="col-12">
                    <div class="alert alert-info" id="priceDisplay" style="font-size:1.2em;">
                        Total Price: <span id="calculatedPrice">-</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="paperType" class="form-label">Paper Type</label>
                    <select class="form-select" id="paperType" name="paperType" required>
                        <option value="">Select paper type</option>
                        <option value="matte">Matte (from MYR 30)</option>
                        <option value="glossy">Glossy (from MYR 35)</option>
                        <option value="textured">Textured (from MYR 40)</option>
                        <option value="recycled">Recycled (from MYR 32)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sideType" class="form-label">Printing Side</label>
                    <select class="form-select" id="sideType" name="sideType" required>
                        <option value="">Select side</option>
                        <option value="one">One Side</option>
                        <option value="double">Double Side (+MYR 15)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <select class="form-select" id="quantity" name="quantity" required>
                        <option value="">Select quantity</option>
                        <option value="100">100</option>
                        <option value="200">200 (+MYR 25)</option>
                        <option value="500">500 (+MYR 90)</option>
                        <option value="1000">1000 (+MYR 170)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="finish" class="form-label">Finish</label>
                    <select class="form-select" id="finish" name="finish" required>
                        <option value="">Select finish</option>
                        <option value="standard">Standard</option>
                        <option value="laminated">Laminated (+MYR 20)</option>
                        <option value="spotUV">Spot UV (+MYR 40)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="corner" class="form-label">Corner Style</label>
                    <select class="form-select" id="corner" name="corner" required>
                        <option value="">Select corner style</option>
                        <option value="square">Square</option>
                        <option value="rounded">Rounded (+MYR 10)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="designFile" class="form-label">Upload Design (optional)</label>
                    <input class="form-control" type="file" id="designFile" name="designFile" accept=".jpg,.jpeg,.png,.pdf">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-5">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
const priceTable = {
    matte: { 100: 30, 200: 55, 500: 120, 1000: 200 },
    glossy: { 100: 35, 200: 60, 500: 130, 1000: 210 },
    textured: { 100: 40, 200: 70, 500: 150, 1000: 240 },
    recycled: { 100: 32, 200: 58, 500: 125, 1000: 205 }
};
const finishAdd = { standard: 0, laminated: 20, spotUV: 40 };
const cornerAdd = { square: 0, rounded: 10 };
const sideAdd = { one: 0, double: 15 };

function calculatePrice() {
    const paper = document.getElementById('paperType').value;
    const side = document.getElementById('sideType').value;
    const quantity = document.getElementById('quantity').value;
    const finish = document.getElementById('finish').value;
    const corner = document.getElementById('corner').value;
    let price = '-';

    if (paper && side && quantity && finish && corner) {
        const base = priceTable[paper] && priceTable[paper][quantity] ? priceTable[paper][quantity] : 0;
        const total = base + (sideAdd[side] || 0) + (finishAdd[finish] || 0) + (cornerAdd[corner] || 0);
        price = 'MYR ' + total.toFixed(2);
    }

    document.getElementById('calculatedPrice').textContent = price;
}

document.getElementById('paperType').addEventListener('change', calculatePrice);
document.getElementById('sideType').addEventListener('change', calculatePrice);
document.getElementById('quantity').addEventListener('change', calculatePrice);
document.getElementById('finish').addEventListener('change', calculatePrice);
document.getElementById('corner').addEventListener('change', calculatePrice);
</script>

<?php include 'footer.php'; ?>
