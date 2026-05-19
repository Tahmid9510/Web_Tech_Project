
// add product validation
document.getElementById("productForm").addEventListener("submit", function(e) {
    let price = document.querySelector("input[name='price']").value.trim();
    if(price === "" || isNaN(price) || Number(price) <= 0) {
        alert("Price must be a positive number");
        e.preventDefault();
        return;
    }

    let imageInput = document.querySelector("input[name='image']");
    let file = imageInput.files[0];
    if(!file) {
        alert("Please select an image");
        e.preventDefault();
        return;
    }

    let allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
    if(!allowedTypes.includes(file.type)) {
        alert("Only JPG, JPEG, PNG, WEBP images are allowed");
        e.preventDefault();
        return;
    }
});


// AJAX code for order confirm 
function updateStatus(orderId, status) {
    var currentStatus = document.getElementById("status-" + orderId).innerHTML.trim().toLowerCase();
    if (currentStatus != "pending") {
        alert("Order already " + orderId);
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "success") {
                document.getElementById("status-" + orderId).innerHTML = status;
            }
            else {
                alert(this.responseText);
            }
        }
    };

    xhttp.open("GET", "../control/admin_orderlist_process.php?id=" + orderId + "&status=" + status, true);
    xhttp.send();
}