<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Checklist</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans p-5">
    <div class="checklist-container bg-white p-5 rounded-lg shadow-md max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Repair Checklist</h2>
        
        <form action="{{ isset($checklist) ? route('checklist.update', $checklist->id) : route('checklist.store') }}" method="POST">
            @csrf
            @if(isset($checklist))
                @method('PUT')
            @endif
            <input type="hidden" name="repair_id" value="{{ $repair->id ?? $checklist->repair_id }}">
            
            <table class="checklist-table w-full border-collapse mb-5">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs"></th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Not Tested</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Working</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Replaced</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Removed</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Installed</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs"></th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Not Tested</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Working</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Not Working</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Removed</th>
                        <th class="border border-gray-300 p-2 text-center bg-gray-50 font-bold text-xs">Installed</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Processor</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="not_tested" {{ old('processor', $checklist->processor ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="working" {{ old('processor', $checklist->processor ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="replaced" {{ old('processor', $checklist->processor ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="removed" {{ old('processor', $checklist->processor ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="installed" {{ old('processor', $checklist->processor ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Front USB</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="not_tested" {{ old('frontUSB', $checklist->frontUSB ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="working" {{ old('frontUSB', $checklist->frontUSB ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="not_working" {{ old('frontUSB', $checklist->frontUSB ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="removed" {{ old('frontUSB', $checklist->frontUSB ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="installed" {{ old('frontUSB', $checklist->frontUSB ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Motherboard</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="not_tested" {{ old('motherboard', $checklist->motherboard ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="working" {{ old('motherboard', $checklist->motherboard ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="replaced" {{ old('motherboard', $checklist->motherboard ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="removed" {{ old('motherboard', $checklist->motherboard ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="installed" {{ old('motherboard', $checklist->motherboard ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Rear USB</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="not_tested" {{ old('rearUSB', $checklist->rearUSB ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="working" {{ old('rearUSB', $checklist->rearUSB ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="not_working" {{ old('rearUSB', $checklist->rearUSB ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="removed" {{ old('rearUSB', $checklist->rearUSB ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="installed" {{ old('rearUSB', $checklist->rearUSB ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Ram</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="not_tested" {{ old('ram', $checklist->ram ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="working" {{ old('ram', $checklist->ram ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="replaced" {{ old('ram', $checklist->ram ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="removed" {{ old('ram', $checklist->ram ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="installed" {{ old('ram', $checklist->ram ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Front Sound</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="not_tested" {{ old('frontSound', $checklist->frontSound ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="working" {{ old('frontSound', $checklist->frontSound ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="not_working" {{ old('frontSound', $checklist->frontSound ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="removed" {{ old('frontSound', $checklist->frontSound ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="installed" {{ old('frontSound', $checklist->frontSound ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Hard Disk</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="not_tested" {{ old('hard_disk_1', $checklist->hard_disk_1 ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="working" {{ old('hard_disk_1', $checklist->hard_disk_1 ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="replaced" {{ old('hard_disk_1', $checklist->hard_disk_1 ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="removed" {{ old('hard_disk_1', $checklist->hard_disk_1 ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="installed" {{ old('hard_disk_1', $checklist->hard_disk_1 ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Rear Sound</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="not_tested" {{ old('rearSound', $checklist->rearSound ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="working" {{ old('rearSound', $checklist->rearSound ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="not_working" {{ old('rearSound', $checklist->rearSound ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="removed" {{ old('rearSound', $checklist->rearSound ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="installed" {{ old('rearSound', $checklist->rearSound ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Hard Disk</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="not_tested" {{ old('hard_disk_2', $checklist->hard_disk_2 ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="working" {{ old('hard_disk_2', $checklist->hard_disk_2 ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="replaced" {{ old('hard_disk_2', $checklist->hard_disk_2 ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="removed" {{ old('hard_disk_2', $checklist->hard_disk_2 ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="installed" {{ old('hard_disk_2', $checklist->hard_disk_2 ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>VGA Port</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="not_tested" {{ old('vgaPort', $checklist->vgaPort ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="working" {{ old('vgaPort', $checklist->vgaPort ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="not_working" {{ old('vgaPort', $checklist->vgaPort ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="removed" {{ old('vgaPort', $checklist->vgaPort ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="installed" {{ old('vgaPort', $checklist->vgaPort ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Optical Drive</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="not_tested" {{ old('optical_drive', $checklist->optical_drive ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="working" {{ old('optical_drive', $checklist->optical_drive ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="replaced" {{ old('optical_drive', $checklist->optical_drive ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="removed" {{ old('optical_drive', $checklist->optical_drive ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="installed" {{ old('optical_drive', $checklist->optical_drive ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>HDMI Port</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="not_tested" {{ old('hdmiPort', $checklist->hdmiPort ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="working" {{ old('hdmiPort', $checklist->hdmiPort ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="not_working" {{ old('hdmiPort', $checklist->hdmiPort ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="removed" {{ old('hdmiPort', $checklist->hdmiPort ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="installed" {{ old('hdmiPort', $checklist->hdmiPort ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Network</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="not_tested" {{ old('network', $checklist->network ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="working" {{ old('network', $checklist->network ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="replaced" {{ old('network', $checklist->network ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="removed" {{ old('network', $checklist->network ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="installed" {{ old('network', $checklist->network ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Hard Health</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hardHealth" value="not_tested" {{ old('hardHealth', $checklist->hardHealth ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hardHealth" value="working" {{ old('hardHealth', $checklist->hardHealth ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hardHealth" value="not_working" {{ old('hardHealth', $checklist->hardHealth ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hardHealth" value="removed" {{ old('hardHealth', $checklist->hardHealth ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hardHealth" value="installed" {{ old('hardHealth', $checklist->hardHealth ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Wifi</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="not_tested" {{ old('wifi', $checklist->wifi ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="working" {{ old('wifi', $checklist->wifi ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="replaced" {{ old('wifi', $checklist->wifi ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="removed" {{ old('wifi', $checklist->wifi ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="installed" {{ old('wifi', $checklist->wifi ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Stress Test</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="stressTest" value="not_tested" {{ old('stressTest', $checklist->stressTest ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="stressTest" value="working" {{ old('stressTest', $checklist->stressTest ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="stressTest" value="not_working" {{ old('stressTest', $checklist->stressTest ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="stressTest" value="removed" {{ old('stressTest', $checklist->stressTest ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="stressTest" value="installed" {{ old('stressTest', $checklist->stressTest ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Camera</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="not_tested" {{ old('camera', $checklist->camera ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="working" {{ old('camera', $checklist->camera ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="replaced" {{ old('camera', $checklist->camera ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="removed" {{ old('camera', $checklist->camera ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="installed" {{ old('camera', $checklist->camera ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Benchmark</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="benchMark" value="not_tested" {{ old('benchMark', $checklist->benchMark ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="benchMark" value="working" {{ old('benchMark', $checklist->benchMark ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="benchMark" value="not_working" {{ old('benchMark', $checklist->benchMark ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="benchMark" value="removed" {{ old('benchMark', $checklist->benchMark ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="benchMark" value="installed" {{ old('benchMark', $checklist->benchMark ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>PowerCable1</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="not_tested" {{ old('powerCable_1', $checklist->powerCable_1 ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="working" {{ old('powerCable_1', $checklist->powerCable_1 ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="not_working" {{ old('powerCable_1', $checklist->powerCable_1 ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="removed" {{ old('powerCable_1', $checklist->powerCable_1 ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="installed" {{ old('powerCable_1', $checklist->powerCable_1 ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Hinges</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="not_tested" {{ old('hinges', $checklist->hinges ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="working" {{ old('hinges', $checklist->hinges ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="replaced" {{ old('hinges', $checklist->hinges ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="removed" {{ old('hinges', $checklist->hinges ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="installed" {{ old('hinges', $checklist->hinges ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>PowerCable2</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="not_tested" {{ old('powerCable_2', $checklist->powerCable_2 ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="working" {{ old('powerCable_2', $checklist->powerCable_2 ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="not_working" {{ old('powerCable_2', $checklist->powerCable_2 ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="removed" {{ old('powerCable_2', $checklist->powerCable_2 ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="installed" {{ old('powerCable_2', $checklist->powerCable_2 ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Laptop SPK</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="not_tested" {{ old('laptopSPK', $checklist->laptopSPK ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="working" {{ old('laptopSPK', $checklist->laptopSPK ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="replaced" {{ old('laptopSPK', $checklist->laptopSPK ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="removed" {{ old('laptopSPK', $checklist->laptopSPK ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="installed" {{ old('laptopSPK', $checklist->laptopSPK ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>VGACable</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="not_tested" {{ old('vgaCable', $checklist->vgaCable ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="working" {{ old('vgaCable', $checklist->vgaCable ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="not_working" {{ old('vgaCable', $checklist->vgaCable ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="removed" {{ old('vgaCable', $checklist->vgaCable ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="installed" {{ old('vgaCable', $checklist->vgaCable ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Mic</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="not_tested" {{ old('mic', $checklist->mic ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="working" {{ old('mic', $checklist->mic ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="replaced" {{ old('mic', $checklist->mic ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="removed" {{ old('mic', $checklist->mic ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="installed" {{ old('mic', $checklist->mic ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>DVI Cable</strong></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="not_tested" {{ old('dviCable', $checklist->dviCable ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="working" {{ old('dviCable', $checklist->dviCable ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="not_working" {{ old('dviCable', $checklist->dviCable ?? '') == 'not_working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="removed" {{ old('dviCable', $checklist->dviCable ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="installed" {{ old('dviCable', $checklist->dviCable ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">TouchPad</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="not_tested" {{ old('touchPad', $checklist->touchPad ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="working" {{ old('touchPad', $checklist->touchPad ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="replaced" {{ old('touchPad', $checklist->touchPad ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="removed" {{ old('touchPad', $checklist->touchPad ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="installed" {{ old('touchPad', $checklist->touchPad ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                    </tr>
                    
                    <tr>
                        <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Keyboard</td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="not_tested" {{ old('keyboard', $checklist->keyboard ?? 'not_tested') == 'not_tested' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="working" {{ old('keyboard', $checklist->keyboard ?? '') == 'working' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="replaced" {{ old('keyboard', $checklist->keyboard ?? '') == 'replaced' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="removed" {{ old('keyboard', $checklist->keyboard ?? '') == 'removed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="installed" {{ old('keyboard', $checklist->keyboard ?? '') == 'installed' ? 'checked' : '' }} class="w-4 h-4 m-0"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                        <td class="border border-gray-300 p-2 text-center align-middle"></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="back-panel-section mt-5 p-4 bg-gray-50 rounded">
                <label class="mr-4 font-bold">Back Panel Nuts:</label>
                <input type="radio" name="backpanelnuts" value="yes" {{ old('backpanelnuts', $checklist->backpanelnuts ?? 'yes') == 'yes' ? 'checked' : '' }} class="mr-2"> Yes
                <input type="radio" name="backpanelnuts" value="no" {{ old('backpanelnuts', $checklist->backpanelnuts ?? '') == 'no' ? 'checked' : '' }} class="mr-2 ml-4"> No
                
                <label style="margin-left: 20px;" class="ml-5 font-bold">Quantity:</label>
                <input type="number" name="nutQty" value="{{ old('nutQty', $checklist->nutQty ?? 0) }}" class="qty-input w-16 p-1 border border-gray-300 rounded ml-1" min="0">
            </div>
            
            <button type="submit" class="submit-btn bg-blue-500 text-white py-2 px-4 rounded cursor-pointer text-base mt-5 hover:bg-blue-700">Save Checklist</button>
        </form>
    </div>
</body>
</html>