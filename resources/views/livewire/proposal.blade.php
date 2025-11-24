<div class="">
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

    <table class="m-auto w-[210mm]">
        <thead id="header">
            <tr>
                <th>
                    <div class="p-4 mb-8 text-white border-b-2 bg-neutral-900 border-b-neutral-900">
                        <div class="flex justify-between">
                            <div>
                                <div class="w-32 ">
                                    <img
                                        src="/assets/images/kawnek-enterprise-logo-crop.png"
                                        alt=""
                                        srcset=""
                                    >
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
                                <a
                                    href="http://kawnek.com"
                                    target="_blank"
                                >kawnek.com</a>
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
                    <section
                        id="body"
                        class="px-4 pb-8"
                    >
                        <div id="mvp">
                            <h1 class="text-3xl font-bold text-center uppercase">
                                {{ $project->name }} PROPOSAL
                            </h1>
                            <div class="mt-4">
                                @foreach ($project->feature_groups as $groupKey => $feature_group)
                                <div class="break-inside-avoid">
                                    <h2 class="text-2xl font-semibold capitalize">
                                        {{ $feature_group->title }}
                                    </h2>
                                    @foreach ($feature_group->features as $featureKey => $feature)
                                    {{-- @if ($feature->is_selected) --}}
                                    <div class="my-2 pl-4 {{ $feature->is_selected ? '' : 'line-through' }}">
                                        <h6 class="text-lg underline uppercase">
                                            {{ $feature->name }}
                                        </h6>
                                        @if ($feature->is_selected)
                                        <div class="pl-4">
                                            {!! nl2br($feature->description) !!}
                                        </div>
                                        @endif
                                    </div>
                                    {{-- @endif --}}
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            <div
                                style=""
                                id="price-summary"
                            >
                                <h2 class="text-2xl font-semibold mt-12 capitalize">
                                    Development cost of the software
                                </h2>
                                <div class="mt-4 pl-4">
                                    <div class="gap-2 grid grid-cols-2">
                                        @foreach ($project->feature_groups as $groupKey => $feature_group)
                                        @foreach ($feature_group->features as $featureKey => $feature)
                                        @if ($feature->is_selected)
                                        <div class="capitalize">
                                            {{ $feature->name }}
                                        </div>
                                        <div>
                                            ₹ {{ number_format($feature->cost, 2) }}
                                        </div>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @if ($project->discount_amount > 0)
                                        <div class="font-semibold">
                                            Sub total:
                                        </div>
                                        <div class="font-semibold">
                                            ₹{{ number_format($project->total_cost, 2) }}
                                        </div>

                                        <div class="text-red-500 mt-2">
                                            Discount ({{ $project->discount_percent }}%)
                                        </div>
                                        <div class="text-red-500 line-through mt-2">
                                            ₹{{ number_format($project->discount_amount, 2) }}
                                        </div>
                                        @endif

                                        <div class="font-bold">
                                            GRAND TOTAL
                                        </div>
                                        <div class="font-bold italic">
                                            ₹{{ number_format($project->total_cost - $project->discount_amount, 2) }}
                                        </div>
                                    </div>
                                </div>
                                <h2 class="text-2xl font-semibold capitalize mt-12">Post deployment
                                </h2>

                                <div>
                                    <div style="display: inline-block; width: 250px; padding: 4px">Hosting and
                                        maintenance fees:
                                    </div>
                                    <div style="display: inline-block; padding: 4px">
                                        ₹{{ number_format(9500, 2) }}
                                        per year
                                        <i class="text-xs">
                                            (price may vary baed on provider)
                                        </i>
                                    </div>
                                </div>
                                <div>
                                    <div style="display: inline-block; width: 250px; padding: 4px">Domain fees:
                                    </div>
                                    <div
                                        style="display: inline-block; padding: 4px"
                                        class="relative"
                                    >
                                        ₹{{ number_format(1550, 2) }}
                                        per year
                                    </div>
                                </div>
                                <div class="mt-8 break-inside-avoid">
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
                                            The software (with features defined above) should be delivered within 4
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
                                            is not delivered within 4 weeks, if no additional feature is added.
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
                                            <div class="font-bold uppercase">
                                                {{ $project->client_name }}
                                            </div>
                                            <i>{{$project->client_designation}}@if($project->client_org), @endif</i>
                                            <i class="font-bold">
                                                {{$project->client_org}}
                                            </i>
                                        </div>
                                    </div>

                                </div>
                            </div>



                        </div>
                    </section>
                </td>
            </tr>
        </tbody>
    </table>

    <div
        class="w-[210mm] m-auto flex justify-between p-4 bg-neutral-200"
        id="footer"
    >
        <strong>
            GSTIN: 15AYKPL0160C1ZX
        </strong>
        <strong class="">
            UDYAM: UDYAM-MZ-01-0012328
        </strong>
    </div>
</div>