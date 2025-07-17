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
            width: 60px;
            height: 34px;
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
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
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
            transform: translateX(26px);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
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
    
    <div class="max-w-7xl mx-auto p-6">
        <!-- Invoice-style Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-white rounded-2xl shadow-2xl p-6 mb-6 border-b-4 border-blue-200">
            <div class="flex items-center gap-6">
                <img src="/photos/logo.png" alt="Company Logo" class="w-32 h-auto">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Nawarathna Computer</h1>
                    <div class="text-base text-gray-700">
                        <div><strong>Address:</strong> No 339, Colombo Road, Pilimathalawa</div>
                        <div><strong>Contact:</strong> 081-2577370, 0777-977070, 0777-535121</div>
                        <div><strong>Website:</strong> www.nccs.lk</div>
                        <div><strong>Email:</strong> thenccs@gmail.com</div>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex justify-end">
                <a href="/admin" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-2 px-6 rounded-xl text-base shadow-lg transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-user-shield mr-2"></i>Admin
                </a>
            </div>
        </div>

        <!-- Separated Input Fields Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 flex flex-col md:flex-row gap-6">
            <div class="flex-1">
                <label for="date" class="block text-sm font-medium mb-2">Date</label>
                <input type="date" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 shadow-md focus:ring-2 focus:ring-purple-500 focus:outline-none" id="date" name="date" required>
            </div>
            <div class="flex-1">
                <label for="repair_id" class="block text-sm font-medium mb-2">Repair ID</label>
                <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 shadow-md bg-gray-50 cursor-not-allowed" id="repair_id" name="repair_id" placeholder="Auto-generated" required readonly>
                <div class="text-xs text-gray-500 mt-1">Auto-generated repair ID</div>
            </div>
            <div class="flex-1">
                <label for="time" class="block text-sm font-medium mb-2">Time</label>
                <input 
                    type="time" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 shadow-md bg-gray-50 cursor-not-allowed" 
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

        <form method="POST" action="{{ route('checklist.save') }}">
            @csrf
            
            <!-- Modern Checklist Section -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8">
                <div class="text-gray-900 text-center py-6 bg-white">
                    <h2 class="text-3xl font-bold">DEVICE CHECKLIST</h2>
                    <p class="text-purple-700 mt-2">Select the status for each component</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @php
                            $components = [
                                ['name' => 'Processor', 'icon' => 'fas fa-microchip'],
                                ['name' => 'Motherboard', 'icon' => 'fas fa-memory'],
                                ['name' => 'RAM', 'icon' => 'fas fa-memory'],
                                ['name' => 'Hard Disk 1', 'icon' => 'fas fa-hdd'],
                                ['name' => 'Hard Disk 2', 'icon' => 'fas fa-hdd'],
                                ['name' => 'Optical Drive', 'icon' => 'fas fa-compact-disc'],
                                ['name' => 'Network', 'icon' => 'fas fa-network-wired'],
                                ['name' => 'WiFi Module', 'icon' => 'fas fa-wifi'],
                                ['name' => 'Camera', 'icon' => 'fas fa-camera'],
                                ['name' => 'Front USB', 'icon' => 'fab fa-usb'],
                                ['name' => 'Rear USB', 'icon' => 'fab fa-usb'],
                                ['name' => 'Front Sound', 'icon' => 'fas fa-volume-up'],
                                ['name' => 'Rear Sound', 'icon' => 'fas fa-volume-up'],
                                ['name' => 'VGA Port', 'icon' => 'fas fa-tv'],
                                ['name' => 'HDMI Port', 'icon' => 'fas fa-tv'],
                                ['name' => 'Hard Health', 'icon' => 'fas fa-heartbeat'],
                                ['name' => 'Stress Test', 'icon' => 'fas fa-chart-line'],
                                ['name' => 'Benchmark', 'icon' => 'fas fa-tachometer-alt'],
                                ['name' => 'Power Cable 1', 'icon' => 'fas fa-plug'],
                                ['name' => 'Power Cable 2', 'icon' => 'fas fa-plug'],
                                ['name' => 'VGA Cable', 'icon' => 'fas fa-plug'],
                                ['name' => 'DVI Cable', 'icon' => 'fas fa-plug'],
                                ['name' => 'Hinges', 'icon' => 'fas fa-laptop'],
                                ['name' => 'Laptop Speakers', 'icon' => 'fas fa-volume-up'],
                                ['name' => 'Camera', 'icon' => 'fas fa-camera'],
                                ['name' => 'Microphone', 'icon' => 'fas fa-microphone'],
                                ['name' => 'TouchPad', 'icon' => 'fas fa-hand-pointer'],
                                ['name' => 'Keyboard', 'icon' => 'fas fa-keyboard'],
                                
                            ];
                            
                            $statusConfig = [
                                'not_tested' => ['color' => 'bg-gray-500 hover:bg-gray-600', 'text' => 'Not Tested', 'icon' => 'fas fa-question'],
                                'working' => ['color' => 'bg-green-500 hover:bg-green-600', 'text' => 'Working', 'icon' => 'fas fa-check'],
                                'replaced' => ['color' => 'bg-blue-500 hover:bg-blue-600', 'text' => 'Replaced', 'icon' => 'fas fa-sync-alt'],
                                'removed' => ['color' => 'bg-red-500 hover:bg-red-600', 'text' => 'Removed', 'icon' => 'fas fa-times'],
                                'installed' => ['color' => 'bg-purple-500 hover:bg-purple-600', 'text' => 'Installed', 'icon' => 'fas fa-plus']
                            ];
                        @endphp
                        
                        @foreach($components as $index => $component)
                        <div class="component-card bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <i class="{{ $component['icon'] }} text-purple-600 text-xl mr-3"></i>
                                <h3 class="font-semibold text-gray-800 text-lg">{{ $component['name'] }}</h3>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                @foreach($statusConfig as $status => $config)
                                <button type="button" 
                                        class="status-btn bg-white border-2 border-blue-500 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition-all duration-300 opacity-70 hover:opacity-100"
                                        data-color="{{ $config['color'] }}"
                                        data-status="{{ $status }}"
                                        onclick="selectStatus({{ $index }}, '{{ $status }}', this)">
                                    <i class="{{ $config['icon'] }} text-xs"></i>
                                    <span>{{ $config['text'] }}</span>
                                </button>
                                @endforeach
                            </div>
                            
                            <input type="hidden" name="checklist[{{ $index }}][component]" value="{{ $component['name'] }}">
                            <input type="hidden" name="checklist[{{ $index }}][status]" id="status_{{ $index }}" value="not_tested">
                            @if(isset($component['extra']))
                                <div class="mt-3">
                                    <label for="{{ $component['extra']['name'] }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $component['extra']['label'] }}</label>
                                    <input type="{{ $component['extra']['type'] }}" name="{{ $component['extra']['name'] }}" id="{{ $component['extra']['name'] }}" min="{{ $component['extra']['min'] }}" placeholder="{{ $component['extra']['placeholder'] }}" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                </div>
                            @endif
                        </div>
                        @endforeach
                        <!-- Back Panel Nut Quantity as checklist item -->
                        <div class="component-card bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-screwdriver text-purple-600 text-xl mr-3"></i>
                                <h3 class="font-semibold text-gray-800 text-lg">Back Panel Nut Quantity</h3>
                            </div>
                            <div class="mt-3">
                                <label for="back_panel_nut_quantity" class="block text-sm font-medium text-gray-700 mb-1">Nut Quantity</label>
                                <input type="number" name="back_panel_nut_quantity" id="back_panel_nut_quantity" min="0" placeholder="Enter nut quantity" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center mb-6">
                    <i class="fas fa-user text-purple-600 text-2xl mr-3"></i>
                    <h4 class="text-2xl font-bold text-gray-800">Customer Details</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="relative">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
                        <div class="relative">
                            <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   id="customer_name" name="customer_name" placeholder="Search or enter customer name" required onchange="generateSlug()" autocomplete="off">
                            <input type="hidden" id="customer_id" name="customer_id" value="">
                            <div id="customer_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Customer options will be populated here -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="tel" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="customer_phone" name="customer_phone" placeholder="Enter phone number" required>
                    </div>
                    <div>
                        <label for="customer_city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="customer_city" name="customer_city" placeholder="Enter city" required>
                    </div>
                    <div>
                        <label for="whatsapp_enabled" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Enabled</label>
                        <div class="flex items-center mt-3">
                            <label class="toggle-switch">
                                <input type="checkbox" id="whatsapp_enabled" name="whatsapp_enabled" value="1" checked>
                                <span class="slider"></span>
                            </label>
                            <span class="ml-3 text-sm text-gray-600">Enable WhatsApp notifications</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Details Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center mb-6">
                    <i class="fas fa-laptop text-purple-600 text-2xl mr-3"></i>
                    <h4 class="text-2xl font-bold text-gray-800">Device Details</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="relative">
                        <label for="device_type" class="block text-sm font-medium text-gray-700 mb-2">Device Type</label>
                        <div class="relative">
                            <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                   id="device_type" name="device_type" placeholder="Search or enter device type" required autocomplete="off">
                            <input type="hidden" id="device_id" name="device_id" value="">
                            <div id="device_dropdown" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                                <!-- Device options will be populated here -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="device_brand" class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="device_brand" name="device_brand" placeholder="Enter brand (e.g., Acer)" required onchange="generateSlug()">
                    </div>
                    <div>
                        <label for="device_model" class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="device_model" name="device_model" placeholder="Enter model (e.g., Laptop)" required onchange="generateSlug()">
                    </div>
                    <div>
                        <label for="problem_description" class="block text-sm font-medium text-gray-700 mb-2">Problem Ddescription</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="problem_description" name="problem_description" placeholder="Problem" required>
                    </div>
                    
                </div>
                <div class="mt-6 flex flex-col md:flex-row md:space-x-6">
                    <div class="flex-1">
                        <label for="device_id" class="block text-sm font-medium mb-2">Device ID</label>
                        <div class="relative">
                            @php
                                $nextDeviceId = \DB::table('devices')->max('id') + 1;
                            @endphp
                            <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 shadow-md focus:ring-2 focus:ring-purple-500 focus:outline-none bg-gray-50" 
                                   id="device_id" name="device_id" 
                                   placeholder="Suggested: {{ $nextDeviceId }}">
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Suggested next device ID (you can change if needed)</div>
                    </div>
                    <div class="flex-1">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Auto-Generated Slug</label>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-800 font-medium" id="slug_display">
                            Slug will be auto-generated..
                        </div>
                        <input type="hidden" id="slug" name="slug" value="">
                    </div>
                    <div class="flex-1 mt-6 md:mt-0">
                        <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">Assign Technician</label>
                        <select id="technician_id" name="technician_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                            <option value="">Select a technician</option>
                            @php
                                $technicians = \DB::table('technictions')->orderBy('name')->get();
                            @endphp
                            @foreach($technicians as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-2xl text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-tools mr-2"></i>Create Repair Order
                </button>
            </div>
        </form>

        <!-- Company Information -->
        <!-- Removed duplicate footer/company info as it's now in the header -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load next repair ID when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadNextRepairId();
            loadNextDeviceId();
            // Set default "Not Tested" status and style on page load for all checklist items
            @foreach($components as $index => $component)
                setDefaultStatus({{ $index }});
            @endforeach
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

        // Handle checkbox changes (only one can be selected per row)
        function handleCheckboxChange(rowIndex, selectedStatus) {
            const statuses = ['not_tested', 'working', 'replaced', 'removed', 'installed'];
            
            statuses.forEach(status => {
                if (status !== selectedStatus) {
                    document.getElementById(`checklist_${rowIndex}_${status}`).checked = false;
                }
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
                document.getElementById('slug_display').textContent = 'Slug will be auto-generated...';
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
            document.getElementById('customer_city').value = customer.city;
            document.getElementById('whatsapp_enabled').checked = customer.whatsAppEnable === 'yes';
            
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

        // Called when a status button is clicked
        function selectStatus(index, status, btn) {
            // Update hidden input
            document.getElementById('status_' + index).value = status;
            // Update button styles
            const buttons = btn.parentElement.querySelectorAll('button');
            buttons.forEach(b => {
                b.classList.remove('active');
                b.classList.remove(...b.getAttribute('data-color').split(' '));
            });
            btn.classList.add('active');
            btn.classList.add(...btn.getAttribute('data-color').split(' '));
        }

        // Set default "Not Tested" status and style on page load for all checklist items
        function setDefaultStatus(index) {
            // Set the hidden input to "not_tested"
            document.getElementById('status_' + index).value = 'not_tested';
            // Find all status buttons for this component
            const buttons = document.querySelectorAll('[onclick^="selectStatus(' + index + ',"]');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove(...btn.getAttribute('data-color').split(' '));
                if (btn.getAttribute('data-status') === 'not_tested') {
                    btn.classList.add('active');
                    btn.classList.add(...btn.getAttribute('data-color').split(' '));
                }
            });
        }
    </script>
</body>
</html>