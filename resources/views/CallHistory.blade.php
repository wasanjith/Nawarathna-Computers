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
<body class="bg-gradient-to-br from-gray-50 to-blue-100 min-h-screen">
    <div class="container mx-auto p-6" x-data="{ showModal: false, selectedDevice: '{{ $latestDeviceId ?? '' }}', openModal() { this.selectedDevice = '{{ $latestDeviceId ?? '' }}'; this.showModal = true; } }">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-4 md:mb-0">Call History for <span class="text-blue-600">{{ $customer->name }}</span></h1>
            <button @click="openModal()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Add New Call
            </button>
        </div>
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Called At</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Device</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($callHistory->where('notes', '!=', 'Initial call record created automatically') as $call)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="py-3 px-6 whitespace-nowrap text-gray-700 font-medium">
                                {{ $call->called_at->format('jS \of F Y') }} <span class="text-xs text-gray-400">{{ $call->called_at->format('g.i A') }}</span>
                            </td>
                            <td class="py-3 px-6">
                                @if($call->device_id && isset($customer->devices))
                                    @php
                                        $device = $customer->devices->where('id', $call->device_id)->first();
                                    @endphp
                                    @if($device)
                                        <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">{{ $device->brand }} {{ $device->model }}</span>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="py-3 px-6">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @if($call->status === 'answered') bg-green-100 text-green-700
                                    @elseif($call->status === 'no_answer') bg-yellow-100 text-yellow-700
                                    @elseif($call->status === 'busy') bg-red-100 text-red-700
                                    @elseif($call->status === 'switched_off') bg-gray-200 text-gray-600
                                    @else bg-purple-200 text-purple-600 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $call->status)) }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-gray-600">
                                {{ $call->notes }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 px-6 text-center text-gray-400">No call history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add New Call Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" x-cloak>
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-8 relative animate-fadeIn" @click.away="showModal = false">
                <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <h3 class="text-xl font-bold text-gray-800 mb-6">Add New Call Record</h3>
                <form method="POST" action="{{ route('customers.calls.store', $customer->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="called_at" class="block text-gray-700 text-sm font-semibold mb-2">Date and Time</label>
                        <input type="datetime-local" id="called_at" name="called_at" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                    </div>
                    <div class="mb-4">
                        <label for="device_id" class="block text-gray-700 text-sm font-semibold mb-2">Device</label>
                        <select id="device_id" name="device_id" x-model="selectedDevice" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="">Select Device (Optional)</option>
                            @if(isset($customer->devices))
                                @foreach($customer->devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->brand }} {{ $device->model }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 text-sm font-semibold mb-2">Status</label>
                        <select id="status" name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="answered">Answered</option>
                            <option value="no_answer">No Answer</option>
                            <option value="busy">Busy</option>
                            <option value="switched_off">Switched Off</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="notes" class="block text-gray-700 text-sm font-semibold mb-2">Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showModal = false" class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">Cancel</button>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow transition">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.3s ease; }
    </style>
</body>
</html>
