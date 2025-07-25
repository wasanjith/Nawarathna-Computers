<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-4">Activity History</h2>
        <table class="min-w-full text-sm">
            <thead>
                <tr>
                    <th class="px-2 py-1 text-left">User</th>
                    <th class="px-2 py-1 text-left">Action</th>
                    <th class="px-2 py-1 text-left">Subject</th>
                    <th class="px-2 py-1 text-left">Description</th>
                    <th class="px-2 py-1 text-left">Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                    <tr>
                        <td class="px-2 py-1">{{ $activity->user->name ?? 'Unknown' }}</td>
                        <td class="px-2 py-1">{{ ucfirst($activity->action) }}</td>
                        <td class="px-2 py-1">{{ class_basename($activity->subject_type) }}</td>
                        <td class="px-2 py-1">{{ $activity->description }}</td>
                        <td class="px-2 py-1">{{ $activity->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-2 py-1 text-center">No activity found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-filament::card>
</x-filament::widget> 