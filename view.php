<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <title>Retrieve Data with PDO</title>
    <script src="script.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #007bff;
            color: #fff;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: bold;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #e9ecef;
        }

        .edit-link, .delete-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .action-links a:hover {
            color: #0056b3;
        }

        #EditForm {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #EditForm input {
            width: calc(50% - 20px);
            margin: 10px 10px 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        #EditForm input:focus {
            border-color: #007bff;
            outline: none;
        }

        #EditForm button {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        #EditForm button:hover {
            background-color: #0056b3;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
        }
        
        .edit-link {
            background-color: #3C1053FF;
            color: #DF6589FF;
            margin-right: 5px;
        }

        .delete-link {
            background-color: #dc3545;
            color: white;
        }

        .edit-link:hover {
            background-color: #7c0e77;
        }

        .delete-link:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
        <h1>Retrieve Employee Data</h1>

        <table id="data-table">
            <thead>
                <tr>

            <th>Employee ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Contact Number</th> 
            <th>Actions</th>               
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
        <div id="retrieveDataQueryResult"></div>
        <br>
        <form id="EditForm">
            <input type="hidden" id="id">
            <input type="text" id="employeeId" placeholder="ID Number">
            <input type="text" id="firstName" placeholder="Firstname">
            <input type="text" id="middleName" placeholder="Middlename">
            <input type="text" id="lastName" placeholder="Lastname">
            <input type="text" id="contactNumber" placeholder="ContactNumber">
            <button type="button" onclick="updateData()">Update</button>
        </form>
        
       
       <script>
            $(document).ready(function() {

              $.ajax ({
                  url:'retrieve.php',
                  type: 'GET',
                  dataType: 'json',
                  success: function(data) {
                      if (data.length > 0) {
                          var tableBody = $('#data-table tbody');
                          tableBody.empty();

                          $.each(data, function(index, item) {
                              var row = $('<tr></tr>');
                              row.append($('<td></td>').text(item.employeeId));
                              row.append($('<td></td>').text(item.firstName));
                              row.append($('<td></td>').text(item.middleName));
                              row.append($('<td></td>').text(item.lastName));
                              row.append($('<td></td>').text(item.contactNumber));

                              var actionCell = $('<td></td>');

                              var editLinkData = $('<a href="#" class="edit-link">Edit</a>');
                              editLinkData.on('click', function(event) {
                                  event.preventDefault();
                                  editData(item.id);
                              });

                              var deleteLinkData = $('<a href="#" class="delete-link">Del</a>');
                              deleteLinkData.on('click', function(event) {
                                  event.preventDefault();
                                  deleteData(item.id, row);
                              });

                              actionCell.append(editLinkData);
                              actionCell.append(deleteLinkData);

                              row.append(actionCell);
                              tableBody.append(row);
                          });

                          $('#data-table').table('refresh');
                      } else {
                          $("#retrieveDataQueryResult").html("<p style='color: red;'>No Data found.</p>");
                      }
                  }  
            });
            });
            function editData(id) {
                alert(id);

                $.ajax ({
                    url: 'retrieve.php',
                    method: 'Get',
                    data: {  id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#id').val(response.data.id);
                            $('#employeeId').val(response.data.employeeId);
                            $('#firstName').val(response.data.firstName);
                            $('#middleName').val(response.data.middleName);
                            $('#lastName').val(response.data.lastName);
                            $('#contactNumber').val(response.data.contactNumber);
                        } else {
                            alert(response.message || "Error retrieving data");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("AJAX error:" + error);
                    }
                });
            }
            
            function updateData() {
                var updatedData = {
                    id: $('#id').val(),
                    employeeId: $('#employeeId').val(),
                    firstName: $('#firstName').val(),
                    middleName: $('#middleName').val(),
                    lastName: $('#lastName').val(),
                    contactNumber: $('#contactNumber').val()
                };

                $.ajax({
                    url: 'update.php',
                    method:'POST',
                    data: updatedData,
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            alert("Data updated successfully");
                            location.reload();
                        } else {
                            alert("Error: Could not update data");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("AJAX error: " + error);
                    }
                });
            }

            function deleteData(id, row){
                if (confirm("Are you sure you want to delete this record")) {
                    $.ajax ({
                        url: 'delete.php', //URL of the PHP script to handle deletion
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            try {
                                var result = JSON.parse(response);
                                if (result.success) {
                                    alert('Record deleted successfully!');
                                    row.remove(); //Remove the row from table
                                } else {
                                    alert('Failed to delete record: ' + (result.message || 'Unknown error'));
                                }
                            } catch (e) {
                                alert('Failed to delete record: Invalid server response');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Failed to delete record: ' + error);
                        }
                    });
                }
            }
        </script>
    </body>
</html>