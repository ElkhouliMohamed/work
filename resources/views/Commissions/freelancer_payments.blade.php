@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Payments for {{ $freelancer->name }}</h1>
        <p class="text-gray-600 mt-1">View and manage commissions for this freelancer.</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All</option>
                    <option value="En Attente" {{ request('status')==='En Attente' ? 'selected' : '' }}>Pending</option>
                    <option value="Payment Requested" {{ request('status')==='Payment Requested' ? 'selected' : '' }}>
                        Payment Requested</option>
                    <option value="Payé" {{ request('status')==='Payé' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Per Page</label>
                <select name="per_page" id="per_page"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="10" {{ request('per_page', 10)==10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page', 10)==25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page', 10)==50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div>
                <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Commissions Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-4">{{ session('success') }}</div>
        @endif
        @if (session('warning'))
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-4">{{ session('warning') }}</div>
        @endif
        @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-4">{{ session('error') }}</div>
        @endif

        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h5 class="text-lg font-semibold text-gray-800">Commission Records</h5>
            <div class="space-x-2">
                @if (auth()->user()->hasRole(['Account Manager', 'Admin', 'Super Admin']))
                <form action="{{ route('commissions.approve_all_payments') }}" method="GET" style="display:inline;">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        onclick="return confirm('Are you sure you want to approve all payment requests?')">
                        Approve All Payments
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($commissions as $commission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $commission->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($commission->montant, 2) }} MAD
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $statusClasses = [
                            'En Attente' => 'bg-yellow-100 text-yellow-800',
                            'Payment Requested' => 'bg-blue-100 text-blue-800',
                            'Payé' => 'bg-green-100 text-green-800',
                            ];
                            @endphp
                            <span
                                class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$commission->statut] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $commission->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $commission->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            @if (auth()->user()->hasRole(['Account Manager', 'Admin', 'Super Admin']))
                            @if ($commission->statut === 'Payment Requested')
                            <button class="text-green-600 hover:text-green-900 font-medium process-payment"
                                data-id="{{ $commission->id }}" data-modal-target="paymentModal">
                                Process Payment
                            </button>
                            @endif
                            @if ($commission->statut === 'Payé')
                            <button onclick="clearCommission({{ $commission->id }})"
                                class="text-red-600 hover:text-red-900 font-medium">
                                Clear
                            </button>
                            @endif
                            @if ($commission->statut === 'En Attente' && $commission->demande_paiement)
                            <form action="{{ route('commissions.approve_payment', $commission) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-green-600 hover:text-green-900 font-medium bg-transparent border-none p-0">
                                    Approve Payment
                                </button>
                            </form>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No commissions found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-200">
            {{ $commissions->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Payment Processing Modal -->
@if (auth()->user()->hasRole(['Account Manager', 'Admin', 'Super Admin']))
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full"
    tabindex="-1">
    <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <form id="paymentForm" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold text-gray-800">Process Commission Payment</h5>
                <button type="button" class="text-gray-400 hover:text-gray-600 text-2xl close-modal">×</button>
            </div>
            <div class="space-y-4">
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="{{ now()->format('Y-m-d') }}" required>
                </div>
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select name="payment_method" id="payment_method"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required>
                        <option value="">Select Method</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Check">Check</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700">Payment Proof</label>
                    <input type="file" name="payment_proof" id="payment_proof"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                        accept=".pdf,.jpg,.png" required>
                    <p class="mt-1 text-xs text-gray-500">PDF, JPG or PNG (Max: 2MB)</p>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 close-modal">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
                const paymentModal = document.getElementById('paymentModal');
                const processButtons = document.querySelectorAll('.process-payment');
                const closeButtons = document.querySelectorAll('.close-modal');
                const paymentForm = document.getElementById('paymentForm');

                processButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const commissionId = this.getAttribute('data-id');
                        paymentForm.action = `/commissions/${commissionId}/process-payment`;
                        paymentModal.classList.remove('hidden');
                    });
                });

                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        paymentModal.classList.add('hidden');
                    });
                });

                paymentModal.addEventListener('click', function(e) {
                    if (e.target === paymentModal) {
                        paymentModal.classList.add('hidden');
                    }
                });

                window.clearCommission = function(commissionId) {
                    if (confirm('Are you sure you want to clear this commission record?')) {
                        window.location.href = `{{ route('commissions.clearCommission', ':id') }}`.replace(':id', commissionId);
                    }
                };
            });
</script>
@endsection
@endsection