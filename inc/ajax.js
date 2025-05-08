$(document).ready(function () {
  let scannedCode = '';
  let barcodeTimeout;

  // Handle barcode scanner input
  $(document).on('keydown', function (e) {
    if (e.key.length === 1 || e.key === 'Enter') {
      if (barcodeTimeout) clearTimeout(barcodeTimeout);
      if (e.key !== 'Enter') {
        scannedCode += e.key;
      }
      if (e.key === 'Enter') {
        e.preventDefault();
        $('#medcode').val(scannedCode);

        scannedCode = '';
      }
      barcodeTimeout = setTimeout(() => {
        scannedCode = '';
      }, 100);
    }
  });

});


$('#addmedicinesForm').on('submit', function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  formData.append("addmedicinesForm", "true");
  $.ajax({
    url: '../inc/controller.php',
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {
      console.log(response);
      var data = JSON.parse(response);
      if (data.exists) {
        Swal.fire({
          title: 'Error!',
          text: 'Medicine Barcode or Medicine Name already exists!',
          icon: 'error',
          confirmButtonColor: '#d33'
        });
      } else if (data.success) {
        Swal.fire({
          position: "top-end",
          icon: 'success',
          title: 'Medicine Registered',
          text: 'Data Saved!',
          showConfirmButton: false,
          timer: 1500
        });
        setTimeout(function () {
          location.reload();
        }, 1600);
      }
    },

  });

});


$(document).on('click', '#updatemeds', function () {
  var medicineID = $(this).data('medicine-id');
  console.log(medicineID);
  $.ajax({
    type: "GET",
    url: "../inc/controller.php",
    data: {
      medregisterid: medicineID,
      updatemeds: true,
    },
    dataType: "json",
    success: function (data) {
      console.log("AJAX Response:", data);
      $('#medregisterid').val(data.medregisterid);
      $('#medcodes').val(data.medcode);
      $('#medname').val(data.medname);
      $('#medprice').val(data.medprice);
      $('#medtablets').val(data.medtablets);
      $('#medpriceeach').val(data.medpriceeach);
    }
  })



});


$('#updatemedicinesForm').on('submit', function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  formData.append("updatemedicinesForm", "true");
  $.ajax({
    url: '../inc/controller.php',
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {

      Swal.fire({
        position: "top-end",
        icon: 'success',
        title: 'Medicine Updated',
        text: 'Data Update!',
        showConfirmButton: false,
        timer: 1500
      });
      setTimeout(function () {
        location.reload();
      }, 1600);
    }

  });

});



$(document).on('click', '#removemeds', function () {
  var medicineID = $(this).data('medicine-id');
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this action to delete the product!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Deactivate it!"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../inc/controller.php",
        method: 'GET',
        data: {
          medregisterid: medicineID,
          removemeds: true,
        },
        success: function (response) {
          Swal.fire({
            position: "top-end",
            title: "Deleted!",
            text: "The product has been deleted.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          setTimeout(function () {
            location.reload();
          }, 1600);
        }

      });
    }
  });
});



$('#addstocksForm').on('submit', function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  formData.append("addstocksForm", "true");
  $.ajax({
    url: '../inc/controller.php',
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {

      Swal.fire({
        position: "top-end",
        icon: 'success',
        title: 'Stock Added',
        text: 'Data Save!',
        showConfirmButton: false,
        timer: 1500
      });
      setTimeout(function () {
        location.reload();
      }, 1600);
    }

  });

});





$('#addtocartform').on('submit', function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  formData.append("addtocartform", "true");

  $.ajax({
    url: '../inc/controller.php',
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (response) {
      console.log(response); // Log the raw response to check what's being returned

      try {
        // Parse the JSON response
        var data = JSON.parse(response);

        // Display success or error message based on response
        if (data.status === "success") {
          Swal.fire({
            title: 'Success!',
            text: data.message,  // Use the message from the response
            icon: 'success',
            showConfirmButton: false,  // Hide the confirm button
            timer: 1500  // Auto-close after 1.5 seconds
          });

          // Reload the page after success
          setTimeout(function () {
            location.reload();
          }, 1600);  // Slight delay to ensure Swal closes before reload
        } else if (data.status === "error") {
          Swal.fire({
            title: 'Error!',
            text: data.message,  // Use the error message from the response
            icon: 'error',
            showConfirmButton: false,  // Hide the confirm button
            timer: 1500  // Auto-close after 1.5 seconds
          });

          // Reload the page after error
          setTimeout(function () {
            location.reload();
          }, 1600);  // Slight delay to ensure Swal closes before reload
        }
      } catch (e) {
        console.error("Error parsing JSON:", e);
        Swal.fire({
          title: 'Error!',
          text: "An error occurred while processing the request.",
          icon: 'error',
          showConfirmButton: false,  // Hide the confirm button
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Request failed: " + error);
      Swal.fire({
        title: 'Error!',
        text: "An error occurred. Please try again.",
        icon: 'error',
        showConfirmButton: false,  // Hide the confirm button
      });
    }
  });
});







// $(document).on('click', '#acceptbuyall', function () {
//   $.ajax({
//     type: "GET",
//     url: '../inc/controller.php',
//     data: {
//       acceptbuyall: 1
//     },
//     success: function (response) {
//       Swal.fire({
//         position: "top-end",
//         icon: 'success',
//         title: 'Medicine Updated',
//         text: 'Data Update!',
//         showConfirmButton: false,
//         timer: 1500
//       });
//       setTimeout(function () {
//         location.reload();
//       }, 1600);
//     }
//   });
// });



function printInvoice() {
  // Open a new window for printing
  var printWindow = window.open('', '_blank');
  var content = document.getElementById("invoiceContent").innerHTML;

  // Write HTML structure and content for the print window
  printWindow.document.write(`
    <html>
    <head>
      <title>Print Receipt</title>
      <style>
        body {
          width: 58mm;
          margin: 0;
          padding: 0;
          font-family: Arial, sans-serif;
          font-size: 10px;
        }

        #invoiceContent {
          padding: 20px;
          box-sizing: border-box;
        }

        h5 {
          font-size: 20px;
          font-weight: bold;
          text-align: center;
          margin: 5px 0;
        }

        p, address {
          margin: 5px 0;
          font-size: 10px;
          line-height: 1.4;
        }

        .border-bottom {
          border-bottom: 1px solid #e0e0e0;
          margin-bottom: 3px;
        }

        .table {
          width: 100%;
          border-collapse: collapse;
        }

        .table th, .table td {
          padding: 2px;
          font-size: 9px;
          text-align:left;
        }

        .footer-message {
          text-align: center;
          margin-top: 5px;
          font-size: 8px;
        }
      </style>
    </head>
    <body onload="window.print();">
      <div id="invoiceContent">
        ${content}
      </div>
    </body>
    </html>
  `);

  // Close the print window after printing
  printWindow.document.close();
  printWindow.focus();

  // Check when the print dialog closes
  printWindow.onafterprint = function () {
    printWindow.close();
    executeAfterPrint(); // Call AJAX after the print window closes
  };

  // Fallback for browsers that don't support `onafterprint`
  printWindow.onbeforeunload = function () {
    executeAfterPrint();
  };
}

function executeAfterPrint() {
  // AJAX call to execute after print
  $.ajax({
    type: "GET",
    url: '../inc/controller.php',
    data: {
      acceptbuyall: 1
    },
    success: function (response) {
      Swal.fire({
        position: "top-end",
        icon: 'success',
        title: 'Medicine Buy success',
        text: 'Data Update!',
        showConfirmButton: false,
        timer: 1500
      });
      setTimeout(function () {
        location.reload();
      }, 1600);
    }
  });
}

$(document).on('click', '#acceptbuyall', function () {
  printInvoice(); // Trigger the printing process
});




$(document).ready(function () {
  $("#logout-btn").click(function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, logout!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../inc/logout.php",
          type: "POST",
          success: function (response) {
            Swal.fire({
              title: "Logged out!",
              text: "You have been successfully logged out.",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.href = "../index.php";
            });
          },
          error: function () {
            Swal.fire({
              title: "Error!",
              text: "There was a problem logging you out.",
              icon: "error"
            });
          }
        });
      }
    });
  });
});