// ví dụ sử dụng javascript thuần

// ví dụ sử dụng jquery
$(document).ready(() => {

});

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

function btn_view_user(element){
    let id = element.parentNode.parentNode.id;
    location.href = "detail-user.php?id="+id
    
}

function reset_password(element){
    let id = element.parentNode.parentNode.id;
    location.href = "resetpassword.php?id="+id
}

function startTimer() {
    let duration = 5;
    let countDown = 5;
    
    let id = setInterval(() => {

        countDown --;
        if (countDown >= 0) {
            $('#second').html(countDown);
        }
        if (countDown == -1) {
            clearInterval(id);
            window.location.href = 'login.php';
        }

    }, 1000);
  }
