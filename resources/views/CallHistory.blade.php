<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call History for {{ $customer->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8" x-data="{ showModal: false }">
        <h1 class="text-2xl font-bold mb-4">Call History for: {{ $customer->name }}</h1>
        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Called At</th>
                        <th class="py-3 px-6 text-left">Device</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Notes</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($callHistory->where('notes', '!=', 'Initial call record created automatically') as $call)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $call->called_at->format('jS \of F Y') }} {{ $call->called_at->format('g.i A') }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                @if($call->device_id && isset($customer->devices))
                                    @php
                                        $device = $customer->devices->where('id', $call->device_id)->first();
                                    @endphp
                                    @if($device)
                                        {{ $device->brand }} {{ $device->model }}
                                    @else
                                        N/A
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-3 px-6 text-left">
                                <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{ $call->status }}</span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $call->notes }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 px-6 text-center">No call history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add New Call Button -->
        <div class="flex justify-end">
            <button @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Call
            </button>
        </div>

        <!-- Add New Call Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center" x-cloak>
            <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white" @click.away="showModal = false">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Call Record</h3>
                    <div class="mt-2 px-7 py-3">
                        <form method="POST" action="{{ route('customers.calls.store', $customer->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="called_at" class="block text-gray-700 text-sm font-bold mb-2 text-left">Date and Time:</label>
                                <input type="datetime-local" id="called_at" name="called_at" value="{{ now()->format('Y-m-d\TH:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div class="mb-4">
                                <label for="device_id" class="block text-gray-700 text-sm font-bold mb-2 text-left">Device:</label>
                                <select id="device_id" name="device_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Select Device (Optional)</option>
                                    @if(isset($customer->devices))
                                        @foreach($customer->devices as $device)
                                            <option value="{{ $device->id }}">{{ $device->brand }} {{ $device->model }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2 text-left">Status:</label>
                                <select id="status" name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="answered">Answered</option>
                                    <option value="no_answer">No Answer</option>
                                    <option value="busy">Busy</option>
                                    <option value="switched_off">Switched Off</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="notes" class="block text-gray-700 text-sm font-bold mb-2 text-left">Notes:</label>
                                <textarea id="notes" name="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                <button type="button" @click="showModal = false" class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                    Close
                                </button>
                                <button type="submit" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                    Save Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</html>
