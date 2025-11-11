<body class="">
    @vite('resources/css/app.css')
    @php
        $softwareFeatures = collect([
            [
                'name' => 'User Management',
                'fields' => ['name', 'phone', 'phone_alt', 'document_no', 'address'],
            ],
            [
                'name' => 'Roles & Permissions',
                'fields' => ['roles', 'permissions'], // Based on the section name
            ],
            [
                'name' => 'Tax Configuration',
                'fields' => ['accommodation (5%; 18% when < 7,500; )', 'food & beverages [5%]'],
            ],
            [
                'name' => 'Room Management',
                'fields' => ['name', 'cost'],
            ],
            [
                'name' => 'Blacklist Management',
                'fields' => ['related_user', 'related_blacklist (nullable)'],
            ],
            [
                'name' => 'Booking Management',
                'fields' => [
                    'related_user (related_client)',
                    'no_of_adults',
                    'no_of_chlidren',
                    'related_room',
                    'date',
                    'date_list',
                    'departure_date',
                    'advance_amount',
                    'room_costs',
                    'discount',
                    'pathian_ram',
                    'total_amount',
                ],
            ],
            [
                'name' => 'Menu Management',
                'fields' => ['name', 'cost', 'description'],
            ],
            [
                'name' => 'Invoice Management',
                'fields' => ['date', 'related_booking', 'total_amount', 'room_amount', 'total_discount'],
            ],
            [
                'name' => 'Invoice Items',
                'fields' => [
                    'description',
                    'quantity',
                    'list_price',
                    'unit',
                    'discount',
                    'tax_percentage',
                    'tax_amount',
                    'amount',
                    'service_by_user',
                ],
            ],
            [
                'name' => 'Payment Management',
                'fields' => ['amount', 'date', 'mode'],
            ],
            [
                'name' => 'Expenditure Tracking',
                'fields' => ['item', 'cost', 'date', 'related_user', 'name', 'phone'],
            ],
            [
                'name' => 'List Bookings Report',
                'fields' => [
                    'Filter by phone (user)',
                    'Filter by date range',
                    'Filter by room',
                    'Calculate amount received from bookings',
                    'Calculate amount received from restaurant',
                ],
            ],
            [
                'name' => 'Room Analytics',
                'fields' => [
                    'Filter by room and by date range',
                    'Calculate amount received from bookings',
                    'Calculate amount received from restaurant',
                    'Sort room by stats (most bookings, most amount received)',
                ],
            ],
            [
                'name' => 'Other Features',
                'fields' => ['List bookings [filter by user/phone?] and by date', 'Import data from excel'],
            ],
        ]);
        $developmentCost = collect([
            'Users, Roles & Permissions' => 10000,
            'Room Management' => 10000,
            'Room Bookings' => 15000,
            'Blacklisting' => 5000,
            'Restaurant Menu' => 5000,
            'Invoice' => 15000,
            'Payments' => 10000,
            'Expenditures' => 5000,
            'List Bookings' => 15000,
            'Import Old Data' => 5000,
            'Analytics (Chart)' => 15000,
            'Website: Browsing & Info' => 10000,
            'Website: WhatsApp Booking/Order' => 10000,
        ]);
    @endphp
    <style>
        html {
            margin: 0;
        }

        #footer {
            position: sticky;
            bottom: 0;
        }

        #header {
            position: sticky;
            top: 0;
        }

        .printcontainer {
            border-radius: 8px;
            margin: 50px auto;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        @media print {
            #header {
                position: static;
                top: none;
            }

            .printcontainer {
                margin: auto;
                border-radius: none;
                box-shadow: none;
            }

            .outer-group {
                page-break-inside: avoid;
            }

            #spacer {
                height: 60px;
            }

            #footer {
                position: fixed;
                bottom: 0;
            }

            #price-summary {
                page-break-inside: avoid;
            }

            #suggestions {
                page-break-before: always;
            }

        }
    </style>
    {{-- <div class="w-[210mm] printcontainer">

        </div> --}}
    <table class="m-auto w-[210mm]">
        <thead id="header">
            <tr>
                <th>
                    <div class="p-4 mb-8 text-white border-b-2 bg-neutral-900 border-b-neutral-900">
                        <div class="flex justify-between">
                            <div>
                                <div class="w-32 ">
                                    <img src="/assets/images/kawnek-enterprise-logo-crop.png" alt=""
                                        srcset="">
                                </div>
                            </div>
                            <div class=" text-end">
                                <a href="https://maps.app.goo.gl/pNzyVJSq1DBNh72Z7">
                                    Ramhlun South
                                    <br>
                                    Aizawl, Mizoram
                                </a>
                                <div class="italic text-blue-500">
                                    <a href="mailto:support@kawnek.com">support@kawnek.com</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="text-blue-500 textitalic">
                                <a href="http://kawnek.com" target="_blank">kawnek.com</a>
                            </div>
                            <div class="italic text-blue-500">
                                <a href="tel:+919996244310">+91 99962 44310</a>
                            </div>
                        </div>

                    </div>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td id="spacer">
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>
                    <section id="body" class="px-4 pb-8">
                        <div id="mvp">
                            <h1 class="text-3xl font-bold text-center">
                                HOLIDAY PALACE - HOTEL MANAGEMENT SOFTWARE PROPOSAL
                            </h1>
                            <div class="mt-4 ">
                                <h1 class="text-3xl">Software Features (Minimum Viable Product)</h1>
                                <i class="text-lg text-gray-500">
                                    *This is first draft of the proposal, anything may be changed later.*
                                </i>
                                <ol>
                                    @foreach ($softwareFeatures as $index => $feature)
                                        <li class="outer-group">
                                            <h2 class="text-xl font-bold">
                                                {{ $index + 1 }}.
                                                {{ $feature['name'] }}</h2>
                                            <ul>
                                                @foreach ($feature['fields'] as $field)
                                                    <li class="pl-4">
                                                        &#9702;
                                                        {!! $field !!}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                            <div style="margin-top: 32px" id="price-summary">
                                <div style="font-size: 24px; margin-bottom: 16px">Development cost of software:
                                </div>
                                @foreach ($developmentCost as $description => $value)
                                    <div>
                                        <div style="display: inline-block; width: 250px; padding: 4px">
                                            {{ $description }}
                                        </div>
                                        <div style="display: inline-block; padding: 4px; font-style: italic">
                                            ₹{{ number_format($value, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div>
                                        <div style="display: inline-block; width: 250px; padding: 4px">
                                            UI/UX design:</div>
                                        <div style="display: inline-block; padding: 4px">₹{{ number_format(20000, 2) }}
                                        </div>
                                    </div>

                                    <div>
                                        <div
                                            style="display: inline-block; width: 250px; padding: 4px; vertical-align: top">
                                            Frontend development
                                        </div>
                                        <div style="display: inline-block; padding: 4px;">
                                            ₹{{ number_format(30000, 2) }}
                                        </div>
                                    </div>

                                    <div>
                                        <div
                                            style="display: inline-block; width: 250px; padding: 4px; vertical-align: top">
                                            Backend development
                                        </div>
                                        <div style="display: inline-block; padding: 4px;">
                                            ₹{{ number_format(30000, 2) }}
                                        </div>
                                    </div>

                                    <div>
                                        <div
                                            style="display: inline-block; width: 250px; padding: 4px; vertical-align: top">
                                            Total cost of development
                                        </div>
                                        <div style="display: inline-block; padding: 4px; ">
                                            <span>
                                                ₹{{ number_format(50000, 2) }}
                                            </span>
                                            <span style="text-decoration: line-through;"
                                                class="pl-3 text-xs text-red-500">
                                                (₹{{ number_format(80000, 2) }})
                                            </span>
                                        </div>
                                    </div> --}}
                                <div style="font-size: 24px; margin-top: 16px; margin-bottom: 16px">Post deployment
                                </div>

                                <div>
                                    <div style="display: inline-block; width: 250px; padding: 4px">Hosting and
                                        maintenance fees:
                                    </div>
                                    <div style="display: inline-block; padding: 4px">
                                        ₹{{ number_format(9000, 2) }}
                                        per year
                                    </div>
                                </div>
                                <div>
                                    <div style="display: inline-block; width: 250px; padding: 4px">Domain fees:
                                    </div>
                                    <div style="display: inline-block; padding: 4px" class="relative">
                                        ₹{{ number_format(1200, 2) }}
                                        per year (approx)
                                    </div>
                                </div>
                                <div class="mt-8">
                                    <h2 class="text-2xl">Terms and conditions</h2>
                                    <ul>
                                        <li> -
                                            This agreement is solely for web application alone, if a native android
                                            or
                                            ios application is required, the agreement may be revised.
                                        </li>
                                        <li> -
                                            50% of the base price should be paid before the project is initiated.
                                        </li>
                                        <li> -
                                            The project will be deliverd with features as explained in the agreement
                                        </li>
                                        <li> -
                                            Any additional features will affect the cost of the software.
                                        </li>
                                        <li> -
                                            The software (with features defined above) should be delivered within 12
                                            weeks from the date of confirmation.
                                        </li>
                                        <li> -
                                            The duration for the development of the software may vary depending on
                                            the change in requirements
                                        </li>
                                        <li> -
                                            The remaining 50% as well as the first year hoting & maintenance cost
                                            should be paid on delivery of the software.
                                        </li>
                                        <li> -
                                            The developer has the right to terminate the service if any of the above
                                            conditions is not met.
                                        </li>
                                        <li> -
                                            The client has the right to withdraw the initial deposit if the software
                                            is not delivered within 12 weeks, if no additional feature is added.
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-8 break-inside-avoid">
                                    <h2 class="text-2xl">Declaration</h2>
                                    By signing below, both the Client and the Software development firm hereby
                                    acknowledge and affirm that they have thoroughly reviewed, comprehended, and
                                    willingly accept all terms and conditions stipulated within this agreement. They
                                    further acknowledge that they enter into this agreement with full understanding
                                    of
                                    their rights and obligations, and agree to be bound by its provisions.

                                    <div class="flex justify-between mt-24">
                                        <div>
                                            <div class="font-bold">
                                                B. LALMALSAWMA
                                            </div>
                                            <i>Proprietor,</i>
                                            <i class="font-bold">Kawnek Enterprise</i>
                                        </div>

                                        <div>
                                            <div class="font-bold">
                                                LALRINPUII
                                            </div>
                                            <i>Incharge,</i>
                                            <i class="font-bold">Holiday Palace</i>
                                        </div>
                                    </div>

                                </div>
                            </div>



                        </div>
                        {{-- <div id="suggestions">
                                <h1 class="mt-8 text-3xl font-bold text-center">
                                    SUGGESTED SOFTWARE FEATURES
                                </h1>
                                <div class="mt-4 ">
                                    <ol>
                                        @foreach ($suggestedFeatures as $index => $feature)
                                            <li class="outer-group">
                                                <h2 class="text-xl font-bold">
                                                    {{ $index + 1 }}.
                                                    {{ $feature['name'] }}</h2>
                                                <ul>
                                                    @foreach ($feature['fields'] as $field)
                                                        <li class="pl-4">
                                                            &#9702;
                                                            {!! $field !!}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div> --}}
                    </section>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="w-[210mm] m-auto flex justify-between p-4 bg-neutral-200" id="footer">
        <strong>
            GSTIN: 15AYKPL0160C1ZX
        </strong>
        <strong class="">
            UDYAM: UDYAM-MZ-01-0012328
        </strong>
    </div>
</body>
