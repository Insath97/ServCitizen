<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Ticket</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            line-height: 1.6;
        }

        .card-body {
            line-height: 1.6;
        }

        h4,
        h5 {
            line-height: 1.4;
        }

        table {
            line-height: 1.5;
        }

        .text-center p {
            line-height: 1.5;
        }

        .border-bottom,
        .border {
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="card border shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-uppercase">Divisional Secretariat Office</h4>
                    <p class="mb-0">Code No: 04/02/01</p>
                    <p class="mb-0">No.33, Main Street, Sainthamaruthu, Sri Lanka</p>
                    <p>Tel: 0672 221 890 | Email: example@dsoffice.lk</p>
                </div>
                <hr>
                <div class="text-center mb-4 bg-dark text-white p-2">
                    <h5 class="fw-bold">Client No: {{ $client->client_number }}</h5>
                </div>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ $client->name }}</td>
                        </tr>
                        <tr>
                            <th>NIC</th>
                            <td>{{ $client->nic }}</td>
                        </tr>
                        <tr>
                            <th>GN Division</th>
                            <td>{{ $client->gndivison->name }}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>{{ $client->mobile }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="border-bottom pt-3 mt-4">
                    <div class="row">
                        <div class="col-6">
                            <p class="mt-4 mb-0"><strong>Date:</strong> {{ date('Y-m-d') }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mt-4 mb-0">-----------------------------</p>
                            <p class="mt-0">Signature</p>
                        </div>
                    </div>
                </div>

                <div class="border mt-4 p-2 text-center">
                    <p class="mb-0">Open on weekdays 8:30 am to 4:30 pm</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();

                window.location.href = "{{ route('admin.client.index') }}"; // Redirect to the desired route
            }, 500); // Delay of 500ms to ensure content is loaded
        };
    </script>
</body>

</html>
