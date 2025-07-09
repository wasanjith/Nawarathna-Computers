<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Call History for {{ $customer->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
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
                    @forelse ($callHistory as $call)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                {{ $call->called_at->format('Y-m-d H:i A') }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                @if($call->device)
                                    {{ $call->device->brand }} {{ $call->device->model }}
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
    </div>
</body>
</html>
