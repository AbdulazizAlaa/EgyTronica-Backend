$(document).ready(function () {
  $('#rec-form').submit(function (e) {
    var name = $('#name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var college = $('#college').val();
    var colYear = $('#col-year').val();
    var firstPref = $('#first-pref').val();
    var secPref = $('#sec-pref').val();

    if (name.length == 0 || email.length == 0 || phone.length == 0 || college.length == 0) {
      $('.msg').toggleClass("red");
      $('.msg').html("All fields are required.");
    }
    else {
      submitForm(name, email, phone, college, colYear, firstPref, secPref);
    }
    e.preventDefault();
  });
});

submitForm = function (name, email, phone, college, colYear, firstPref, secPref) {
  $.ajax({
    type: "POST",
    crossDomain: true,
    dataType: "json",
    url: "url",
    data: {
      name: name,
      email: email,
      phone: phone,
      college: college,
      colYear: colYear,
      firstPref: firstPref,
      secPref: secPref
    },
    success: function (response) {
      $('.msg').toggleClass("green");
      $('.msg').html(name +" has been registered successfully.");

      setTimeout(function() {
        $('.msg').html("");
      }, 5000);
      console.log(response);
    },
    error: function (response) {
      $('.msg').toggleClass("red");
      $('.msg').html("Something went wrong.");
      console.log(response);
    }
  });
};
