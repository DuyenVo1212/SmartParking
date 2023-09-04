$(document).ready(function () {
  $(".create_account").click(function () {
    window.location.assign("new_account.php");
  });

  const avatar = document.querySelector(".avatar");
  function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function () {
        const avatar = document.querySelector(".avatar");
        avatar.style.backgroundImage = `url(${reader.result})`;
      };
      reader.readAsDataURL(file);
    }
  }

  avatar.addEventListener("click", function () {
    const input = avatar.querySelector('input[type="file"]');
    input.click();
  });

  $(".edit").click(function () {
    $("body .dt span").attr("contenteditable", "true");
    $("body .phone span").attr("contenteditable", "false");
    $(".profile button").fadeIn("fast");
    //$('.dt').hide();
  });
  $(".profile button").click(function () {
    $("body .dt span").attr("contenteditable", "false");
    //$('.profile button').hide)();
    var name = $(".profile .name span").html();
    var phone = $(".profile .phone span").html();
    var idno = $(".profile .id span").html();
    var plate = $(".profile .plate span").html();
    $.ajax({
      url: "proc/receiver.php",
      type: "POST",
      data: {
        name: name,
        phone: phone,
        idno: idno,
        plate: plate,
      },
      success: function (data) {
        if (data.trim() === "1") {
          $("#status")
            .addClass("success")
            .html("Data saved successfully")
            .fadeIn("fast")
            .delay(3000);
          fadeOut("slow");
        } else {
          $("#status")
            .addClass("error")
            .html("An error occured, the data could not be saved")
            .fadeIn("fast")
            .delay(3000)
            .fadeOut("slow");
        }
      },
    });
  });
});
