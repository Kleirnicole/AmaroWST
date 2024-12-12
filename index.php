<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Data with PDO</title>
    <script src="script.js"></script>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: all 0.3s ease-in-out;
        }

        .input-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .input-group .icon {
            position: absolute;
            top: 63%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #aaa;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            form {
                width: 90%;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <h1>Insert Employee Data</h1>
    <form id="employeeForm">
        <div class="input-group">
            <label for="employeeId">Employee ID:</label>
            <span class="icon">🆔</span>
            <input type="text" id="employeeId" name="employeeId" required>
        </div>

        <div class="input-group">
            <label for="firstName">First Name:</label>
            <span class="icon">👤</span>
            <input type="text" id="firstName" name="firstName" required>
        </div>

        <div class="input-group">
            <label for="middleName">Middle Name:</label>
            <span class="icon">📝</span>
            <input type="text" id="middleName" name="middleName">
        </div>

        <div class="input-group">
            <label for="lastName">Last Name:</label>
            <span class="icon">👤</span>
            <input type="text" id="lastName" name="lastName" required>
        </div>

        <div class="input-group">
            <label for="contactNumber">Contact Number:</label>
            <span class="icon">📞</span>
            <input type="text" id="contactNumber" name="contactNumber" required>
        </div>

        <button type="submit">Submit</button>
    </form>
    <script>
        $(document).ready(function() {
            $("#employeeForm").on("submit", function(event) {
                event.preventDefault();
                const formData = {
                    employeeId: $("#employeeId").val(),
                    firstName: $("#firstName").val(),
                    middleName: $("#middleName").val(),
                    lastName: $("#lastName").val(),
                    contactNumber: $("#contactNumber").val()
                };

                $.ajax({
                    url: 'insert.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response);
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>