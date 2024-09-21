<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Receipt</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            max-width: 80mm;
            /* Width suitable for thermal printers */
            margin: 0;
            padding: 0;
            color: #000;
            overflow: hidden;
            /* Hide scrollbars */
        }

        .receipt {
            padding: 5px;
        }

        .line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        .header-section {
            text-align: center;
            margin-bottom: 15px;
        }

        .header-section img {
            width: 100px;
            /* Adjust width for the logo */
            height: auto;
            margin-bottom: 2px;
        }

        .header-section .office-name {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 0;
        }

        .sm {
            margin-top: 0;
        }

        .token {
            text-align: center;
            margin: 10px 0;
            width: fit-content;
            margin: 0 auto;
            margin-bottom: 25px;
        }

        .token-fieldset {
            border: 1px dashed #000;
            padding: 5px 10px;
            margin: 0;
            display: inline-block;
            min-width: 100px;
        }

        .token-fieldset legend {
            font-size: 12px;
            text-transform: uppercase;
            padding: 0 5px;
        }

        .token-number {
            font-weight: bold;
            font-size: 14px;
            padding: 5px 0;
        }

        .label {
            text-align: left;
            font-size: 12px;
        }

        .value {
            text-align: right;
            font-size: 12px;
            font-weight: bold;
            word-wrap: break-word;
            /* Wrap long words */
            word-break: break-all;
            /* Break long words */
            max-width: 65%;
            /* Adjust width to fit content */
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .thank-you {
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        @media print {

            /* Print-specific styles */
            body {
                max-width: 80mm;
                /* Ensure width fits the printer paper */
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Header Section -->
        <div class="header-section">
            <img src="{{ asset('images/images.png') }}" alt="Logo">
            <p class="office-name">Divisional Secretariat Office</p>
            <p class="sm">{{ @$setting['site_office_name'] }}</p>
        </div>

        <!-- Token Number Section -->
        <div class="token">
            <fieldset class="token-fieldset">
                <legend>Token</legend>
                <div class="token-number">
                    <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Token Barcode">
                </div>
            </fieldset>
        </div>

        <div class="row">
            <div class="label">Token Number</div>
            <div class="value">{{ $request_service->token_number }}</div>
        </div>

        <!-- Client Information Section -->
        <div class="line"></div>
        <div class="row">
            <div class="label">Client Number</div>
            <div class="value">{{ $request_service->client->client_number }}</div>
        </div>

        <div class="row">
            <div class="label">Client Name</div>
            <div class="value">{{ $request_service->client->name }}</div>
        </div>

        <div class="row">
            <div class="label">Service Type</div>
            <div class="value">{{ $request_service->main_service->service_type->name }}</div>
        </div>

        <div class="row">
            <div class="label">Service Name</div>
            <div class="value">{{ $request_service->main_service->name }}</div>
        </div>

        <div class="row">
            <div class="label">Create Date</div>
            <div class="value">{{ $request_service->created_at->format('d/m/Y • h:i a') }}</div>
        </div>

        @if ($request_service->main_service->have_sub_service == 1)
            <div class="row">
                <div class="label">Fees Type</div>
                <div class="value">{{ $request_service->service->fees_type }}</div>
            </div>

            @if ($request_service->service->fees_type === 'paid')
                <div class="row">
                    <div class="label">Amount</div>
                    <div class="value">LKR {{ $request_service->service->amount }}</div>
                </div>

                <div class="row">
                    <div class="label">Payment Status</div>
                    <div class="value">{{ $request_service->payment_status }}</div>
                </div>

                <div class="row">
                    <div class="label">Minimum Working Peroid</div>
                    <div class="value">{{ $request_service->service->r_time }}
                        <span>{{ $request_service->service->r_time_type }}</span>
                    </div>
                </div>
            @endif

            <div class="line"></div>
            <div class="row">
                <div class="label">Branch</div>
                <div class="value">{{ $request_service->service->branch->name }}</div>
            </div>

            <div class="row">
                <div class="label">Floor</div>
                <div class="value">{{ $request_service->service->branch->floor }}</div>
            </div>

            <div class="row">
                <div class="label">Unit</div>
                <div class="value">{{ $request_service->service->unit->unit_name }}</div>
            </div>
        @else
            <div class="row">
                <div class="label">Fees Type</div>
                <div class="value">{{ $request_service->sub_service->fees_type }}</div>
            </div>

            @if ($request_service->sub_service->fees_type === 'paid')
                <div class="row">
                    <div class="label">Amount</div>
                    <div class="value">LKR {{ $request_service->sub_service->amount }}</div>
                </div>

                <div class="row">
                    <div class="label">Payment Status</div>
                    <div class="value">{{ $request_service->payment_status }}</div>
                </div>

                <div class="row">
                    <div class="label">Minimum Working Peroid</div>
                    <div class="value">{{ $request_service->sub_service->r_time }}
                        <span>{{ $request_service->sub_service->r_time_type }}</span>
                    </div>
                </div>
            @endif

            <div class="line"></div>
            <div class="row">
                <div class="label">Branch</div>
                <div class="value">{{ $request_service->sub_service->branch->name }}</div>
            </div>

            <div class="row">
                <div class="label">Floor</div>
                <div class="value">{{ $request_service->sub_service->branch->floor }}</div>
            </div>

            <div class="row">
                <div class="label">Unit</div>
                <div class="value">{{ $request_service->sub_service->unit->unit_name }}</div>
            </div>
        @endif

        <!-- Footer -->
        <div class="line"></div>
        <p style="margin-top: 15px; text-align: center">
            {{ now()->setTimezone('Asia/Colombo')->format('D, M j, Y • h:i:s A') }}</p>
        <div class="thank-you">Thank you for coming!</div>
        <p style="text-align: center; font-size: 9px; margin-top: 5px;">
            Developed by <strong> {{ @$setting['site_company_name'] }}</strong>
        </p>
    </div>
</body>

</html>
