<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Checklist Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .status-btn {
            transition: all 0.3s ease;
        }
        .status-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .status-btn.active {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }
        .component-card {
            transition: all 0.3s ease;
        }
        .component-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 26px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #25D366;
        }
        input:checked + .slider:before {
            transform: translateX(22px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-100 min-h-screen font-sans">
    <!-- Toast Message -->
    @if(session('success'))
        <div id="toast-message" class="fixed top-6 right-6 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('toast-message');
                if (toast) toast.style.display = 'none';
            }, 3500);
        </script>
    @endif
    @if(session('error'))
        <div id="toast-error" class="fixed top-6 right-6 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in">
            <i class="fas fa-times-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        <script>
            setTimeout(function() {
                var toast = document.getElementById('toast-error');
                if (toast) toast.style.display = 'none';
            }, 3500);
        </script>
    @endif

    <!-- Improved Header: readable, compact, and aligned with content width -->
    <header class="bg-white/90 rounded-xl shadow-lg p-4 md:p-6 max-w-5xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="flex flex-row items-center gap-4">
                <div class="flex flex-col items-center mr-3">
                    <img src="/photos/logo.png" alt="Company Logo" class="w-16 h-16 object-contain mb-1 drop-shadow-lg">
                    <span class="text-xs text-gray-700 mt-1 tracking-wide">www.nccs.lk</span>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-xl md:text-2xl font-extrabold tracking-widest text-gray-900 leading-none" style="letter-spacing:0.2em;">
                        NAWARATHNA
                    </div>
                    <div class="text-base md:text-lg font-light text-gray-700 leading-tight -mt-1 mb-1">
                        Cellular & Computer Systems
                    </div>
                    <div class="text-xs text-gray-700 font-normal">
                        <span>No 339, Colombo Road, Pilimathalawa. </span>
                        <span class="font-semibold text-blue-700">thenccs@gmail.com</span>
                    </div>
                    <div class="text-xs text-blue-700 font-normal">
                        081-2577370, 0777-977070, 0777-535121
                    </div>
                </div>
            </div>
            <div class="mt-2 md:mt-0 flex justify-end w-full md:w-auto">
                <a href="/admin" target="_blank" rel="noopener" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-xl text-sm shadow-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-user-shield mr-2"></i>Admin
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-2 md:p-4">
        <form method="POST" action="{{ route('checklist.save') }}" class="space-y-4">
            @csrf
            <!-- Customer Details Section -->
            <section class="bg-white/90 rounded-xl shadow-lg p-4 md:p-6 mb-2">
                <div class="flex items-center mb-3">
                    <i class="fas fa-user text-purple-600 text-xl mr-2"></i>
                    <h4 class="text-xl font-bold text-gray-800">Customer Details</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-4">
                    <div class="relative">
                        <label for="customer_state" class="block text-sm font-medium text-gray-700 mb-1">Customer Salutation</label>
                        <select id="customer_state" name="customer_state" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm">
                            <option value="Mr">Mr</option>
                            <option value="Ms">Ms</option>
                            <option value="Miss">Miss</option>
                        </select>
                    </div>
                    <div class="relative">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                        <div class="relative">
                            <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm" 
                                   id="customer_name" name="customer_name" placeholder="Search or enter customer name" required onchange="generateSlug()" autocomplete="off">
                            <input type="hidden" id="customer_id" name="customer_id" value="">
                            <div id="customer_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Customer options will be populated here -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="tel" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm" 
                               id="customer_phone" name="customer_phone" placeholder="Enter phone number" required>
                    </div>
                    <div>
                        <label for="customer_phone2" class="block text-sm font-medium text-gray-700 mb-1">Phone 2</label>
                        <input type="tel" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm" 
                               id="customer_phone2" name="customer_phone2" placeholder="Enter second phone number (optional)">
                    </div>
                    <div>
                        <label for="customer_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm" 
                               id="customer_city" name="customer_city" placeholder="Enter city" required value="Pilimathalawa">
                    </div>
                </div>
            </section>
            <!-- Device Details Section -->
            <section class="bg-white/90 rounded-xl shadow-lg p-4 md:p-6 mb-2">
                <div class="flex items-center mb-3">
                    <i class="fas fa-laptop text-purple-600 text-xl mr-2"></i>
                    <h4 class="text-xl font-bold text-gray-800">Device Details</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                    <div class="relative">
                        <label for="device_type" class="block text-sm font-medium text-gray-700 mb-1">Device Type</label>
                        <div class="relative">
                            <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm"
                                   id="device_type" name="device_type" placeholder="Search or enter device type" required autocomplete="off">
                            <input type="hidden" id="device_id" name="device_id" value="">
                            <div id="device_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Device options will be populated here -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="device_brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm" 
                               id="device_brand" name="device_brand" placeholder="Enter brand (e.g., Acer)" required onchange="generateSlug()">
                    </div>
                    <div>
                        <label for="device_model" class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm" 
                               id="device_model" name="device_model" placeholder="Enter model (e.g., Laptop)" required onchange="generateSlug()">
                    </div>
                    <div>
                        <label for="problem_description" class="block text-sm font-medium text-gray-700 mb-1">Problem Description</label>
                        <input list="problem_descriptions" id="problem_description" name="problem_description"
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 mt-1 text-sm"
                               placeholder="Type or select a problem...">
                        <datalist id="problem_descriptions">
                            <option value="No Power">
                            <option value="No Display">
                            <option value="Slow Performance">
                            <option value="Overheating">
                            <option value="Blue Screen/Crashes">
                            <option value="No Sound">
                            <option value="USB Ports Not Working">
                            <option value="Keyboard/Mouse Not Working">
                            <option value="WiFi Not Connecting">
                            <option value="Hard Disk Failure">
                            <option value="Software Issues">
                            <option value="Virus/Malware">
                            <option value="Battery Not Charging">
                            <option value="Screen Flickering">
                        </datalist>
                    </div>
                    
                </div>
                <div class="mt-3 flex flex-col md:flex-row md:space-x-4 gap-2">
                    <div class="flex-1">
                        <label for="device_id" class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
                        <div class="relative">
                            @php
                                $nextDeviceId = \DB::table('devices')->max('id') + 1;
                                $nextDeviceIdPadded = str_pad($nextDeviceId, 4, '0', STR_PAD_LEFT);
                            @endphp
                            <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-900 shadow-md focus:ring-2 focus:ring-purple-500 focus:outline-none bg-gray-50 text-sm" 
                                   id="device_id" name="device_id" 
                                   placeholder="Suggested: {{ $nextDeviceIdPadded }}"
                                   value="{{ $nextDeviceIdPadded }}">
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Suggested next serial number (4 digits, e.g., 0014). You can change if needed.</div>
                    </div>
                    <div class="flex-1">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Auto-Generated Slug</label>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-blue-800 font-medium text-sm" id="slug_display">
                            Slug will be auto-generated.
                        </div>
                        <input type="hidden" id="slug" name="slug" value="">
                    </div>
                </div>
                
            </section>

            <!-- Checklist Section -->
            <section class="bg-white/95 rounded-xl shadow-2xl overflow-hidden mb-2">
                <div class="text-gray-900 text-center py-4 bg-white/80">
                    <h2 class="text-2xl font-bold">DEVICE CHECKLIST</h2>
                </div>
                
                <!-- Date, Repair ID, and Time Fields -->
                <div class="bg-white/90 rounded-xl shadow-lg p-4 mb-2 flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-900 shadow-md focus:ring-2 focus:ring-purple-500 focus:outline-none text-sm" id="date" name="date" required>
                    </div>
                    <div class="flex-1">
                        <label for="repair_id" class="block text-sm font-medium text-gray-700 mb-1">Repair ID</label>
                        <input type="text" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-900 shadow-md bg-gray-50 cursor-not-allowed text-sm" id="repair_id" name="repair_id" placeholder="Auto-generated" required readonly>
                        <div class="text-xs text-gray-500 mt-1">Auto-generated repair ID</div>
                    </div>
                    <div class="flex-1">
                        <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input 
                            type="time" 
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-gray-900 shadow-md bg-gray-50 cursor-not-allowed text-sm" 
                            id="time" 
                            name="time" 
                            required 
                            readonly
                        >
                        <div class="text-xs text-gray-500 mt-1">Auto-filled with current time</div>
                    </div>
                </div>
        <script>
            // Set date and time to Sri Lanka/Colombo time zone on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Get current time in Asia/Colombo
                try {
                    const now = new Date();
                    // Use Intl.DateTimeFormat to get Colombo time
                    const colomboDateTime = new Intl.DateTimeFormat('en-CA', {
                        timeZone: 'Asia/Colombo',
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }).formatToParts(now);

                    let year, month, day, hour, minute;
                    colomboDateTime.forEach(part => {
                        if (part.type === 'year') year = part.value;
                        if (part.type === 'month') month = part.value;
                        if (part.type === 'day') day = part.value;
                        if (part.type === 'hour') hour = part.value;
                        if (part.type === 'minute') minute = part.value;
                    });

                    // Set date input
                    if (year && month && day) {
                        document.getElementById('date').value = `${year}-${month}-${day}`;
                    }
                    // Set time input
                    if (hour && minute) {
                        document.getElementById('time').value = `${hour}:${minute}`;
                    }
                } catch (e) {
                    // Fallback: use browser time if Intl fails
                    const now = new Date();
                    const pad = n => n.toString().padStart(2, '0');
                    document.getElementById('date').value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}`;
                    document.getElementById('time').value = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
                }
            });
        </script>
                
                <div class="p-2 md:p-4">
                    <table class="checklist-table w-full border-collapse mb-2 text-xs md:text-sm">
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
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="processor" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Front USB</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontUSB" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Motherboard</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="motherboard" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Rear USB</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearUSB" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Ram</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="ram" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Front Sound</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="frontSound" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Hard Disk</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_1" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Rear Sound</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="rearSound" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Hard Disk</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hard_disk_2" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>VGA Port</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaPort" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Optical Drive</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="optical_drive" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>HDMI Port</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hdmiPort" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Network</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="network" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Hard Health</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8">
                                    <input type="radio" id="hardHealth_not_tested" name="hardHealth" value="not_tested" class="w-4 h-4 m-0 hardHealth-radio" checked>
                                </td>
                                <td class="border border-gray-300 p-2 text-center align-middle" colspan="5">
                                    <input type="text" id="hardHealth_note" name="hardHealth_note" class="w-full px-2 py-1 border border-gray-300 rounded hardHealth-note" placeholder="Enter Hard Health details (if any)">
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Wifi</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="wifi" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Stress Test</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8">
                                    <input type="radio" id="stressTest_not_tested" name="stressTest" value="not_tested" class="w-4 h-4 m-0 stressTest-radio" checked>
                                </td>
                                <td class="border border-gray-300 p-2 text-center align-middle" colspan="5">
                                    <input type="text" id="stressTest_note" name="stressTest_note" class="w-full px-2 py-1 border border-gray-300 rounded stressTest-note" placeholder="Enter Stress Test details (if any)">
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Camera</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="camera" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>Benchmark</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8">
                                    <input type="radio" id="benchMark_not_tested" name="benchMark" value="not_tested" class="w-4 h-4 m-0 benchMark-radio" checked>
                                </td>
                                <td class="border border-gray-300 p-2 text-center align-middle" colspan="5">
                                    <input type="text" id="benchMark_note" name="benchMark_note" class="w-full px-2 py-1 border border-gray-300 rounded benchMark-note" placeholder="Enter Benchmark details (if any)">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12" class="bg-white h-6"></td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>PowerCable1</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_1" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Hinges</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="hinges" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>PowerCable2</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="powerCable_2" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Laptop SPK</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="laptopSPK" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>VGACable</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="vgaCable" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Mic</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="mic" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle"><strong>DVI Cable</strong></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="not_working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="dviCable" value="installed" class="w-4 h-4 m-0"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">TouchPad</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="touchPad" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                            </tr>
                            
                            <tr>
                                <td class="border border-gray-300 p-2 text-left font-bold bg-gray-50 w-32 align-middle">Keyboard</td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="not_tested" class="w-4 h-4 m-0" checked></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="working" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="replaced" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="removed" class="w-4 h-4 m-0"></td>
                                <td class="checkbox-cell border border-gray-300 p-2 text-center align-middle w-16 h-8"><input type="radio" name="keyboard" value="installed" class="w-4 h-4 m-0"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                                <td class="border border-gray-300 p-2 text-center align-middle"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="back-panel-section mt-2 p-2 bg-gray-50 rounded flex items-center justify-between">
                        <div class="flex items-center">
                            <label class="ml-2 font-bold">Back Panel Nuts Quantity:</label>
                            <input type="number" name="nutQty" value="0" class="qty-input w-14 p-1 border border-gray-300 rounded ml-2" min="0">
                        </div>
                        <div class="flex items-center gap-4">
                            <div>
                                <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-1">Assign Technician</label>
                                <select id="technician_id" name="technician_id" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 text-sm">
                                    <option value="">Select a technician</option>
                                    @php
                                        $technicians = \DB::table('technictions')->orderBy('name')->get();
                                    @endphp
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-2xl text-lg transition-all duration-300 transform hover:scale-105 shadow-xl drop-shadow-lg">
                                <i class="fas fa-tools mr-2"></i>Save Checklist
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>

    <script>
        // Load next repair ID when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadNextRepairId();
            loadNextDeviceId();
        });

        function loadNextRepairId() {
            fetch('/api/repairs/next-id')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('repair_id').value = data.next_id;
                })
                .catch(error => {
                    console.error('Error loading next repair ID:', error);
                    // Fallback: set a placeholder value
                    document.getElementById('repair_id').value = 'Auto-generated';
                });
        }

        // Remove device ID dropdown logic
        // Only keep the function to load next device ID and call it on page load and when customer changes

        function loadNextDeviceId() {
            fetch('/api/devices/next-id')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('device_id').value = data.next_id;
                })
                .catch(error => {
                    console.error('Error loading next device ID:', error);
                    // Fallback: set a placeholder value
                    document.getElementById('device_id').value = 'Auto-generated';
                });
        }

        // Generate slug automatically
        function generateSlug() {
            const customerName = document.getElementById('customer_name').value;
            const brand = document.getElementById('device_brand').value;
            const deviceType = document.getElementById('device_type').value;
            
            if (customerName && brand && deviceType) {
                // Get first name only
                const firstName = customerName.split(' ')[0];
                
                // Create slug: "FirstName's Brand DeviceType"
                const slug = `${firstName}'s ${brand} ${deviceType}`;
                
                document.getElementById('slug').value = slug;
                document.getElementById('slug_display').textContent = slug;
            } else {
                document.getElementById('slug_display').textContent = 'Slug will be auto-generated.';
            }
        }


        // Customer dropdown functionality
        let customerSearchTimeout;
        const customerNameInput = document.getElementById('customer_name');
        const customerDropdown = document.getElementById('customer_dropdown');
        const customerIdInput = document.getElementById('customer_id');

        customerNameInput.addEventListener('input', function() {
            clearTimeout(customerSearchTimeout);
            const searchTerm = this.value.trim();
            
            if (searchTerm.length < 2) {
                hideCustomerDropdown();
                return;
            }

            customerSearchTimeout = setTimeout(() => {
                searchCustomers(searchTerm);
            }, 300);
        });

        customerNameInput.addEventListener('focus', function() {
            const searchTerm = this.value.trim();
            if (searchTerm.length >= 2) {
                searchCustomers(searchTerm);
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!customerNameInput.contains(e.target) && !customerDropdown.contains(e.target)) {
                hideCustomerDropdown();
            }
        });

        function searchCustomers(term) {
            fetch(`/api/customers/search?term=${encodeURIComponent(term)}`)
                .then(response => response.json())
                .then(customers => {
                    showCustomerDropdown(customers);
                })
                .catch(error => {
                    console.error('Error searching customers:', error);
                });
        }

        function showCustomerDropdown(customers) {
            customerDropdown.innerHTML = '';
            
            if (customers.length === 0) {
                customerDropdown.innerHTML = '<div class="px-4 py-2 text-gray-500 text-sm">No customers found</div>';
            } else {
                customers.forEach(customer => {
                    const option = document.createElement('div');
                    option.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
                    option.innerHTML = `
                        <div class="font-medium text-gray-900">${customer.name}</div>
                        <div class="text-sm text-gray-600">${customer.phone} - ${customer.city}</div>
                    `;
                    option.addEventListener('click', () => selectCustomer(customer));
                    customerDropdown.appendChild(option);
                });
            }
            
            customerDropdown.classList.remove('hidden');
        }

        function hideCustomerDropdown() {
            customerDropdown.classList.add('hidden');
        }

        function selectCustomer(customer) {
            customerNameInput.value = customer.name;
            customerIdInput.value = customer.id;
            
            // Auto-fill other customer fields
            document.getElementById('customer_phone').value = customer.phone;
            document.getElementById('customer_phone2').value = customer.phone2; // Add this line
            document.getElementById('customer_city').value = customer.city;
            
            hideCustomerDropdown();
            
            // Clear device fields when customer changes
            clearDeviceFields();
            loadNextDeviceId(); // <-- add this line
        }

        function clearDeviceFields() {
            deviceTypeInput.value = '';
            document.getElementById('device_brand').value = '';
            document.getElementById('device_model').value = '';
            document.getElementById('device_id').value = '';
            hideDeviceDropdown();
            generateSlug();
        }

        // Device dropdown functionality
        let deviceSearchTimeout;
        const deviceTypeInput = document.getElementById('device_type');
        const deviceDropdown = document.getElementById('device_dropdown');
        const deviceIdInputForType = document.getElementById('device_id');

        deviceTypeInput.addEventListener('input', function() {
            clearTimeout(deviceSearchTimeout);
            const searchTerm = this.value.trim();
            
            if (searchTerm.length < 2) {
                hideDeviceDropdown();
                return;
            }

            deviceSearchTimeout = setTimeout(() => {
                searchDevices(searchTerm);
            }, 300);
        });

        deviceTypeInput.addEventListener('focus', function() {
            const customerId = customerIdInput.value;
            if (customerId) {
                loadCustomerDevices(customerId);
            }
        });

        // Hide device dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!deviceTypeInput.contains(e.target) && !deviceDropdown.contains(e.target)) {
                hideDeviceDropdown();
            }
        });

        function loadCustomerDevices(customerId) {
            fetch(`/api/customers/${customerId}/devices`)
                .then(response => response.json())
                .then(devices => {
                    showDeviceDropdown(devices);
                })
                .catch(error => {
                    console.error('Error loading customer devices:', error);
                });
        }

        function searchDevices(term) {
            const customerId = customerIdInput.value;
            if (!customerId) {
                hideDeviceDropdown();
                return;
            }

            fetch(`/api/customers/${customerId}/devices`)
                .then(response => response.json())
                .then(devices => {
                    // Filter devices by search term
                    const filteredDevices = devices.filter(device => 
                        device.device_type.toLowerCase().includes(term.toLowerCase()) ||
                        device.brand.toLowerCase().includes(term.toLowerCase()) ||
                        device.model.toLowerCase().includes(term.toLowerCase())
                    );
                    showDeviceDropdown(filteredDevices);
                })
                .catch(error => {
                    console.error('Error searching devices:', error);
                });
        }

        function showDeviceDropdown(devices) {
            deviceDropdown.innerHTML = '';
            
            if (devices.length === 0) {
                deviceDropdown.innerHTML = '<div class="px-4 py-2 text-gray-500 text-sm">No devices found</div>';
            } else {
                devices.forEach(device => {
                    const option = document.createElement('div');
                    option.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
                    option.innerHTML = `
                        <div class="font-medium text-gray-900">${device.device_type}</div>
                        <div class="text-sm text-gray-600">${device.brand} ${device.model}</div>
                    `;
                    option.addEventListener('click', () => selectDevice(device));
                    deviceDropdown.appendChild(option);
                });
            }
            
            deviceDropdown.classList.remove('hidden');
        }

        function hideDeviceDropdown() {
            deviceDropdown.classList.add('hidden');
        }

        function selectDevice(device) {
            deviceTypeInput.value = device.device_type;
            deviceIdInputForType.value = device.id;
            
            // Auto-fill other device fields
            document.getElementById('device_brand').value = device.brand;
            document.getElementById('device_model').value = device.model;
            
            hideDeviceDropdown();
            generateSlug();
        }

        // Refresh repair ID after form submission (for creating multiple repairs)
        document.querySelector('form').addEventListener('submit', function() {
            // Refresh the repair ID after a short delay to get the next available ID
            setTimeout(function() {
                loadNextRepairId();
            }, 1000);
        });

        // For all three fields, typing in the input unchecks the radio, checking the radio clears the input
        ['hardHealth', 'stressTest', 'benchMark'].forEach(function(field) {
            const radio = document.getElementById(field + '_not_tested');
            const note = document.getElementById(field + '_note');
            if (radio && note) {
                note.addEventListener('input', function() {
                    if (note.value.trim() !== '') {
                        radio.checked = false;
                    }
                });
                radio.addEventListener('change', function() {
                    if (radio.checked) {
                        note.value = '';
                    }
                });
            }
        });

        // Show/hide the 'Other' problem description input
        const problemDescriptionSelect = document.getElementById('problem_description_select');
        const problemDescriptionCustom = document.getElementById('problem_description_custom');
        if (problemDescriptionSelect && problemDescriptionCustom) {
            // The 'Other' option is removed, so we don't need to check for it.
            // The custom input is always visible.
        }


    </script>
</body>
</html>