console.log("Hello World");

// ── existing function (kept) ─────────────────────────────────────────────
function myfunc()
{
    document.getElementById("myp2").innerHTML = "<h1>Welcome to WT Project</h1>";
}

function getUserData(){
    var username=document.getElementById("username").value;
    var xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
          var data = JSON.parse(this.responseText);

            document.getElementById("result").innerHTML = "Username: " + data.username +
            "<br>Email: " + data.email
            + "<br>Profile Image: <img src='../uploads/" + data.file + "' alt='Profile Image' width='400' height='400'><br><hr>"    ;
        }
    };
    xhttp.open("GET", "../control/profile_process.php?username=" + username, true);
    xhttp.send();
}

// ── Task 4: checkout JS validation ──────────────────────────────────────
function validateCheckout()
{
    var isValid = true;

    var address = document.getElementById("address").value;
    var payment = document.getElementById("payment_method").value;

    document.getElementById("address_err").innerHTML = "";
    document.getElementById("payment_err").innerHTML = "";

    if(address.trim() == ""){
        document.getElementById("address_err").innerHTML = "Delivery address is required.";
        isValid = false;
    }

    if(payment == ""){
        document.getElementById("payment_err").innerHTML = "Please select a payment method.";
        isValid = false;
    }

    return isValid;
}

// ── Task 4: AJAX – check order status (same XHR pattern as getUserData) ──
function checkOrderStatus(order_id)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200){
            var data = JSON.parse(this.responseText);

            if(data.error){
                document.getElementById("status_result").innerHTML = "Error: " + data.error;
            } else {
                document.getElementById("order_status").innerHTML = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                document.getElementById("status_result").innerHTML = "Last checked: " + new Date().toLocaleTimeString();
            }
        }
    };
    xhttp.open("GET", "../control/order_status_ajax.php?order_id=" + order_id, true);
    xhttp.send();
}
