@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Approve Commission Payment</h1>

            <form method="POST" action="{{ route('commissions.approve_payment', $commission) }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

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
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700">Payment Proof (Optional)</label>
                        <input type="file" name="payment_proof" id="payment_proof"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                               accept=".pdf,.jpg,.png">
                        <p class="mt-1 text-xs text-gray-500">PDF, JPG or PNG (Max: 2MB)</p>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('commissions.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Approve Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
