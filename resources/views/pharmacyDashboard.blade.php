
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Dashboard</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&display=swap'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notiflix@3/dist/notiflix-aio-3.2.5.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <style>
        /* تصميم الأزرار */
        .action-button {
            padding: 5px 10px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
        }

        .delete-button:hover {
            background-color: #d32f2f;
        }

        /* تنسيق الأزرار في صف واحد بجانب البيانات */
        .action-buttons {
            display: flex;
            gap: 5px;
        }

        /* تصميم الجدول */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        /* تصميم النموذج المنبثق */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 500px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-out;
        }

        /* تأثير للظهور */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10%);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #888;
        }

        .close-button:hover {
            color: #333;
        }

        .modal-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .save-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .save-button:hover {
            background-color: #45a049;
        }

        .cancel-button {
            background-color: #888;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel-button:hover {
            background-color: #666;
        }

        /* تحسين تصميم قسم الطلبات */
        .orders-section {
            display: none;
            margin-top: 30px;
            padding: 25px;
            /* background-color: #ffffff; */
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .orders-header {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-row {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s, background-color 0.3s;
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .order-row:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-details-left {
            display: flex;
            flex-direction: column;
        }

        .order-details h4 {
            margin: 0;
            color: #007bff;
            font-size: 20px;
            font-weight: bold;
        }

        .order-details p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }

        .order-actions {
            display: flex;
            gap: 10px;
        }

        .confirm-button,
        .cancel-button-orders {
            padding: 12px 18px;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .confirm-button {
            background-color: #4CAF50;
            color: white;
        }

        .confirm-button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .cancel-button-orders {
            background-color: #f44336;
            color: white;
        }

        .cancel-button-orders:hover {
            background-color: #d32f2f;
            transform: scale(1.05);
        }

        .order-status {
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            margin-top: 10px;
            width: fit-content;
        }

        .order-status.confirmed {
            background-color: #28a745;
        }

        .order-status.pending {
            background-color: #ffc107;
        }

        .input-error {
            border-color: red;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }


        body {
            background-image: url("{{ asset('images/backgrond.webp') }}"); /* Set background image */
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            direction: ltr;
            /* Left-to-Right Direction */
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
        /* resources/css/app.css */

        /* Clinic Card Styling */
        .clinic-card {
            flex: 1 1 180px;
            max-width: 220px;
            min-height: 358px;
            border-radius: 15px;
            background: linear-gradient(145deg, #ffffff, #f9f9f9);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        .clinic-card.expanded {
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .clinic-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }

        .clinic-card-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            transition: filter 0.3s ease;
        }

        .clinic-card:hover .clinic-card-img {
            filter: brightness(1);
        }

        .card-content {
            padding: 15px;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }

        .card-content h3 {
            font-size: 18px;
            color: #1e1e1e;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .edit-button,
        .delete-button {
            flex-grow: 1;
            padding: 8px 10px;
            font-size: 10px;
            border-radius: 25px;
            color: #fff;
            border: none;
            transition: background 0.3s ease, transform 0.3s ease;
            margin: 2px;
        }

        .edit-button {
            background-color: #e08e0b;
        }

        .edit-button:hover {
            background-color: #e08e0b;
            transform: scale(1.05);
        }

        .delete-button {
            background-color: #d62c1a;
        }

        .delete-button:hover {
            background-color: #d62c1a;
            transform: scale(1.05);
        }

        .show-info-button {
            margin-top: 10px;
            background-color: #15926c;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 12px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .medications-section {
            margin-top: 15px;
        }

        .medications-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .medications-table th,
        .medications-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .medications-table th {
            background-color: #f4f6f8;
            color: #333;
            font-weight: bold;
        }

        .medications-table td {
            background-color: #ffffff;
        }

        .medications-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }


        .show-info-button:hover {
            background-color: #15926c;
            transform: scale(1.05);
        }

        .details-section {
            display: none;
        }

        .clinic-card-actions {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .pagination .page-link {
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination .page-link:hover {
            background-color: #f1f1f1;
        }



    </style>
</head>

<body>
<x-popup-message/>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Notiflix.Report.success('Success!', '{{ session('success') }}', 'OK');
        });
    </script>
@endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Notiflix.Report.failure('Error!', '{{ session('error') }}', 'OK');
        });
    </script>
@endif

<div class="sidebar">
    <div class="user-profile">
        <i class="fas fa-user-circle user-icon"></i>
        <div class="user-info">
            <span class="user-name">{{\App\Services\Login\LoginService::isAuthenticatedAcrossGuards()->name}}</span>
            <span class="user-email">{{\App\Services\Login\LoginService::isAuthenticatedAcrossGuards()->email}}</span>
        </div>
    </div>
    <hr class="divider">
    <ul class="sidebar-menu">
        <li><button class="button" onclick="showForm('medicineForm', 'Add Medicine')"><i class="fas fa-pills"></i> Add Medicine</button></li>
        <li><button class="button" onclick="showForm('viewMedicines', 'View Medicines')"><i class="fas fa-capsules"></i> View Medicines</button></li>
        <li><button class="button" onclick="showForm('ordersSection', 'Patient Orders')"><i class="fas fa-notes-medical"></i> Orders</button></li>
        <li><button class="button" onclick="Logout()"><i class="fas fa-sign-out-alt"></i> Logout</button></li>
    </ul>
</div>

<div class="wrapper">
    <div class="main_box">
        <div class="main-header">
            <span id="dynamicTitle">Pharmacy Dashboard</span>
        </div>

        <div id="medicineForm" class="content-section" style="display: none;">
            <form class="form-container" action="{{ url('/pharmacy/medications/add') }}" method="POST">
                @csrf
                <div class="input_box">
                    <input type="text" class="input-field @error('name') input-error @enderror" id="name" name="name" required>
                    <label class="label" for="name">Medicine Name</label>
                    <i class="icon fas fa-pills"></i>
                    @error('name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input_box">
                    <select class="input-field @error('type') input-error @enderror" id="type" name="type" required>
                        <option value="" disabled selected>Select Medicine Type</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Capsule">Capsule</option>
                    </select>
                    <label class="label" for="type">Medicine Type</label>
                    <i class="icon fas fa-capsules"></i>
                    @error('type')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input_box">
                    <input type="number" class="input-field @error('quantity') input-error @enderror" id="quantity" name="quantity" required min="1">
                    <label class="label" for="quantity">Quantity</label>
                    <i class="icon fas fa-box"></i>
                    @error('quantity')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input_box">
                    <input type="date" class="input-field @error('expiry_date') input-error @enderror" id="expiry_date" name="expiry_date" required>
                    <label class="label" for="expiry_date">Expiry Date</label>
                    <i class="icon fas fa-calendar"></i>
                    @error('expiry_date')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="input-submit">Add Medicine</button>
            </form>
        </div>

        <div id="viewMedicines" class="content-section" style="display: none;">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="medicineTable">
                @foreach($medicines as $index => $medicine)
                    <tr id="medicine-{{ $medicine->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->type }}</td>
                        <td>{{ $medicine->quantity }}</td>
                        <td>{{ $medicine->expiry_date }}</td>
                        <td>
                            <button class="edit-button" onclick="openEditModal({{ $medicine->id }})">Edit</button>
                            <button class="delete-button" onclick="deleteMedicine({{ $medicine->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal for Editing Medicine -->
        <div class="modal" id="editModal">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">&times;</span>
                <div class="modal-header">Edit Medicine</div>
                <!-- Dynamically set the form action using Blade -->
                <form method="POST" id="saveForm" action="{{ route('medication.update', ['id' => $medicine->id]) }}">
                    @csrf

                    <div class="input_box">
                        <label for="editMedicineName">Medicine Name</label>
                        <input type="text" id="editMedicineName" name="name" value="{{ $medicine->name }}" required>
                    </div>
                    <div class="input_box">
                        <label for="editMedicineType">Type</label>
                        <select id="editMedicineType" name="type" required>
                            <option value="Tablet" {{ $medicine->type == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Capsule" {{ $medicine->type == 'Capsule' ? 'selected' : '' }}>Capsule</option>
                        </select>
                    </div>
                    <div class="input_box">
                        <label for="editQuantity">Quantity</label>
                        <input type="number" id="editQuantity" name="quantity" value="{{ $medicine->quantity }}" required min="1">
                    </div>
                    <div class="input_box">
                        <label for="editExpiryDate">Expiry Date</label>
                        <input type="date" id="editExpiryDate" name="expiry_date" value="{{ $medicine->expiry_date }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cancel-button" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="save-button">Save</button>
                    </div>
                </form>
            </div>
        </div>


                <div id="ordersSection" class="content-section" style="display: none;">
                    <div id="ordersContainer">
                        @foreach($orders as $order)
                            <div class="order-row">
                                <div class="order-details">
                                    <div class="order-details-left">
                                        <h4>Patient: {{ $order['patient']['first_name'] }} {{ $order['patient']['last_name'] }}</h4>
                                        <p><strong>Doctor:</strong> Dr. {{ $order['doctor']['name'] }} - {{ $order['doctor']['specialty'] }}</p>
                                        <p><strong>Prescription Date:</strong> {{ $order['date'] }}</p>
                                        <p><strong>Estimated Pickup Time:</strong> {{ $order['estimated_pickup_time'] }}</p>
                                        <span class="order-status {{ strtolower($order['status']) }}">{{ ucfirst($order['status']) }}</span>
                                    </div>
                                    <div class="order-actions">
                                        <button class="confirm-button" onclick="confirmOrder({{ $order['id'] }})">Confirm</button>
                                        <button class="cancel-button-orders" onclick="cancelOrder({{ $order['id'] }})">Cancel</button>
                                    </div>
                                </div>

                                <!-- عرض الأدوية -->
                                @if(count($order['medications']) > 0)
                                    <div class="medications-section">
                                        <h5>Medications:</h5>
                                        <table class="medications-table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Dosage</th>
                                                <th>Instructions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order['medications'] as $medication)
                                                <tr>
                                                    <td>{{ $medication['medication']['name'] }}</td>
                                                    <td>{{ $medication['medication']['type'] }}</td>
                                                    <td>{{ $medication['patient_quantity'] }}</td>
                                                    <td>{{ $medication['dosage'] }}</td>
                                                    <td>{{ $medication['instructions'] }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No medications attached to this order.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>



    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    function confirmOrder(param) {
            window.location.href = `/pharmacy/appointments/${param}/finish`;
        }
        function cancelOrder(param) {
            window.location.href = `/pharmacy/appointments/${param}/cancel`;
        }
        // Utility Functions
    flatpickr("#expiry_date, #editExpiryDate", { dateFormat: "Y-m-d", minDate: "today" });

    let currentRow;

    function openEditModal(id) {
        currentRow = document.getElementById(`medicine-${id}`);
        document.getElementById("editMedicineName").value = currentRow.cells[1].innerText;
        document.getElementById("editMedicineType").value = currentRow.cells[2].innerText;
        document.getElementById("editQuantity").value = currentRow.cells[3].innerText;
        document.getElementById("editExpiryDate").value = currentRow.cells[4].innerText;
        document.getElementById("editModal").style.display = "flex";
        document.getElementById("saveForm").action = `/pharmacy/medication/${id}/update`;
    }

    function closeModal() {
        document.getElementById("editModal").style.display = "none";
    }


    function deleteMedicine(id) {
        if (confirm("Are you sure you want to delete this medicine?")) {
            fetch(`/pharmacy/medication/${id}/delete`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete medicine');
                    }

                    // Display success message using Notiflix before redirecting
                    Notiflix.Report.success(
                        'Success!',
                        'Medication deleted successfully!',
                        'OK',
                        {
                            messageMaxLength: 400,
                            plainText: true,
                            cssAnimationStyle: 'zoom',
                            backOverlay: false,
                            success: {
                                backgroundColor: 'transparent',
                                textColor: '#333',
                            }
                        }
                    );

                    // Redirect to dashboard after a short delay to allow user to see the message
                    setTimeout(() => {
                        window.location.href = "http://127.0.0.1:8000/pharmacy/dashboard";
                    }, 2000); // Adjust delay as needed
                })
                .catch(error => {
                    // Display error message using Notiflix if there's an issue
                    Notiflix.Report.failure(
                        'Error!',
                        'Medication not found or failed to delete.',
                        'OK',
                        {
                            messageMaxLength: 400,
                            plainText: true,
                            cssAnimationStyle: 'zoom',
                            backOverlay: false,
                            failure: {
                                backgroundColor: 'transparent',
                                textColor: '#333',
                            }
                        }
                    );
                    console.error('Error:', error);
                });
        }
    }



    function showForm(formId, title) {
        document.querySelectorAll('.content-section').forEach(section => section.style.display = 'none');
        document.getElementById(formId).style.display = 'block';
        document.getElementById('dynamicTitle').innerText = title;
    }

    function Logout() {
        window.location.href = '/logout';
    }
</script>

</body>

</html>
