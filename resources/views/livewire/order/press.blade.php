<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ordem de Serviço #{{ $number }}</title>
    <style>
        @page {
            margin: 30px 40px 30px 40px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        body {
            margin-top: 90px;
            background-color: #ffffff;
            /* Tailwind `bg-white` */
            color: #2d3748;
            /* Tailwind `text-gray-800` */
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 16px;
            /* Tailwind default */
            line-height: 1.5;
            /* Tailwind default */
        }

        #header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 6px;
        }

        #footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        #header h1 {
            font-size: 1.5rem;
            /* Tailwind `text-2xl` */
            font-weight: 700;
            /* Tailwind `font-bold` */
            margin: 0 !important;
        }

        #header h2 {
            font-size: 1.25rem;
            /* Tailwind `text-2xl` */
            font-weight: 700;
            /* Tailwind `font-bold` */
            margin: 0 !important;
        }

        #header p {
            font-size: 0.875rem;
            /* Tailwind `text-sm` */
            line-height: 1.25rem;
            /* Tailwind default */
            margin: 0 !important;
        }

        #main section h3 {
            font-size: 1.125rem;
            font-weight: 700;
            border-bottom: solid 1px #d1d5db;
            padding-bottom: 6px;
        }

        #main section p {
            font-size: 1.1rem;
            margin: 0 !important;
        }

        #main section p span {
            font-weight: 700;
            /* Tailwind `font-bold` */
            color: #374151;
            /* Tailwind `text-gray-700` */
        }

        #main table {
            font-size: 1.1rem;
            /* Tailwind `text-md` */
            margin-top: 1rem;
            /* Tailwind `mt-4` */
            width: 100%;
            /* Tailwind `w-full` */
            text-align: left;
            /* Tailwind `text-left` */
            border-collapse: collapse;
            /* Prevent double borders */
        }

        #main #products table th,
        #main #products table td {
            padding: 0.5rem;
            /* Tailwind `py-2` */

            color: #4a5568;
            /* Tailwind `text-gray-700` */
        }

        #main #products table th {
            font-weight: 700;
            /* Tailwind `font-bold` for `th` */
            text-align: left;
            /* Align text in headers */
        }

        #main #products table tbody tr {
            border-top: 1px solid #d1d5db;
            /* Tailwind `border-t border-gray-300` */
        }

        div.space-y-6>* {
            margin-bottom: 1.5rem;
            /* Tailwind `space-y-6` */
        }

        div.py-6 {
            padding-top: 1.5rem;
            /* Tailwind `py-6` */
            padding-bottom: 1.5rem;
        }

        .page-number {
            text-align: right;
        }

        .page-number:before {
            content: "Página " counter(page);
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div id="header">
        <table style="width: 100%">
            <tr>
                <td width="10%">
                    <img width="64" src="{{ public_path('images/app-logo-red.jpg') }}" alt="Clinica Barezzi" />
                </td>
                <td width="2%"></td>
                <td width="40%">
                    <h1>Clínica Barezzi</h1>
                    <p>contato@barezzi.com.br</p>
                    <p>61 3999-9898</p>
                    <p>Av. Principal, 123 Brasília-DF</p> 
                </td>
                <td width="2%"></td>
                <td width="36%" style="text-align: right;">
                    <div>
                        <h2>Ordem de Serviço</h2>
                        <p>Número: <strong>{{ $number }}</strong></p>
                        {{-- <p>Data: <strong>{{ $expense->created_at->format('d/m/Y') }}</strong></p> --}}
                        <br>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    {{-- HEADER --}}

    {{-- FOOTER --}}
    <div id="footer">
        <div class="page-number"></div>
    </div>
    {{-- FOOTER --}}

    {{-- MAIN --}}
    <div id="main">
        <div class="space-y-6 py-6">
            <!-- Dados da Ordem -->
            <section>
                <h3>Detalhes do Serviço e Medicamentos</h3>
                <table>
                    <tr>
                        <td colspan="3">
                            <p><span>Paciente:</span> {{ $order->patient->name ?? 'Sem paciente' }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <p><span>Data do Serviço:</span> {{ $order->open_date ? $order->open_date->format('d/m/Y') : 'Sem data' }}</p>
                        </td>
                        <td width="33%">
                            <p><span>Status:</span> {{ $order->orderStatus->name ?? 'Sem status' }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <p><span>Atendente:</span> {{ $order->user->name ?? 'Sem atendente' }}</p>
                        </td>
                        <td width="33%">
                            <p><span>Médico:</span> {{ $order->doctor ?? 'Sem médico' }}</p>
                        </td>
                        <td width="33%">
                            <p><span>CRM:</span> {{ $order->CRM ?? 'Sem CRM' }}</p>
                        </td>
                    </tr>
                </table>
            </section>
            

            <!-- Tabela de Itens -->
        
                <section id="products">
                    <h3>Itens</h3>
                    @php
                        $total_order = 0;
                    @endphp
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 15%">Item</th>
                                <th style="width: 65%">Descrição</th>
                                <th style="text-align: right; width: 20%">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_expense = 0; @endphp

                            @foreach ($order->medications as $med)
                                @php
                                    $subtotal = $med->pivot->price * $med->pivot->quantity;
                                     $total_expense += $subtotal;
                                @endphp
                            <tr>
                                <td>{{ $med->name }}</td>
                                <td>{{ $med->pivot->quantity }}x R$ @currency($med->pivot->price)</td>
                                <td style="text-align: right">R$ @currency($subtotal)</td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot></tfoot>
                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: 700">Total:</td>
                            <td style="text-align: right; font-weight: 700">R$ @currency($total_expense)</td>
                        </tr>
                        </tfoot>
                    </table>
                </section>
                <section style="margin-top: 100px">
                    <div style="border-top: 1px solid #000000; padding-top: 10px; width: 300px; margin: auto">
                        <p style="text-align: center">
                            {{ 'Enfermeiro(a): '. $order->nurse->name ?? 'Sem enfermeiro(a)' }}  
                        </p>
                    </div>
                </section>
            
        </div>
    </div>
    {{-- MAIN --}}
</body>

</html>
