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
    <div class="max-w-7xl mx-auto p-6">
        {{-- method="POST" action="{{ route('repair.store') }}" --}}
        <form >
            @csrf
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white p-6 rounded-2xl shadow-2xl mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium mb-2">Date</label>
                        <input type="date" class="w-full px-4 py-3 rounded-lg border-0 text-gray-900 shadow-md focus:ring-2 focus:ring-white focus:outline-none" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label for="repair_id" class="block text-sm font-medium mb-2">Repair ID</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border-0 text-gray-900 shadow-md focus:ring-2 focus:ring-white focus:outline-none" id="repair_id" name="repair_id" placeholder="Enter Repair ID" required>
                    </div>
                    <div>
                        <label for="device_id" class="block text-sm font-medium mb-2">Device ID</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border-0 text-gray-900 shadow-md focus:ring-2 focus:ring-white focus:outline-none" id="device_id" name="device_id" placeholder="Enter Device ID" required>
                    </div>
                </div>
            </div>

            <!-- Modern Checklist Section -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white text-center py-6">
                    <h2 class="text-3xl font-bold">DEVICE CHECKLIST</h2>
                    <p class="text-purple-100 mt-2">Select the status for each component</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @php
                            $components = [
                                ['name' => 'Brand', 'icon' => 'fas fa-tag'],
                                ['name' => 'Processor', 'icon' => 'fas fa-microchip'],
                                ['name' => 'Motherboard', 'icon' => 'fas fa-memory'],
                                ['name' => 'RAM', 'icon' => 'fas fa-memory'],
                                ['name' => 'Hard Disk', 'icon' => 'fas fa-hdd'],
                                ['name' => 'SSD Drive', 'icon' => 'fas fa-save'],
                                ['name' => 'Optical Drive', 'icon' => 'fas fa-compact-disc'],
                                ['name' => 'Network Card', 'icon' => 'fas fa-network-wired'],
                                ['name' => 'WiFi Module', 'icon' => 'fas fa-wifi'],
                                ['name' => 'Camera', 'icon' => 'fas fa-camera'],
                                ['name' => 'Front USB', 'icon' => 'fab fa-usb'],
                                ['name' => 'Rear USB', 'icon' => 'fab fa-usb'],
                                ['name' => 'Front Audio', 'icon' => 'fas fa-volume-up'],
                                ['name' => 'Rear Audio', 'icon' => 'fas fa-volume-up'],
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
                                ['name' => 'Speakers', 'icon' => 'fas fa-volume-up'],
                                ['name' => 'Microphone', 'icon' => 'fas fa-microphone'],
                                ['name' => 'TouchPad', 'icon' => 'fas fa-hand-pointer'],
                                ['name' => 'Keyboard', 'icon' => 'fas fa-keyboard'],
                                ['name' => 'Back Panel', 'icon' => 'fas fa-screwdriver']
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
                                        class="status-btn {{ $config['color'] }} text-white px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-1 transition-all duration-300 opacity-70 hover:opacity-100"
                                        onclick="selectStatus({{ $index }}, '{{ $status }}', this)">
                                    <i class="{{ $config['icon'] }} text-xs"></i>
                                    <span>{{ $config['text'] }}</span>
                                </button>
                                @endforeach
                            </div>
                            
                            <input type="hidden" name="checklist[{{ $index }}][component]" value="{{ $component['name'] }}">
                            <input type="hidden" name="checklist[{{ $index }}][status]" id="status_{{ $index }}" value="">
                        </div>
                        @endforeach
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
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="customer_name" name="customer_name" placeholder="Enter customer name" required onchange="generateSlug()">
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
                                <input type="checkbox" id="whatsapp_enabled" name="whatsapp_enabled" value="1">
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
                    <div>
                        <label for="device_customer_name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="device_customer_name" name="device_customer_name" placeholder="Enter customer name" required onchange="generateSlug()">
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
                        <label for="device_device_id" class="block text-sm font-medium text-gray-700 mb-2">Device ID</label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                               id="device_device_id" name="device_device_id" placeholder="Enter device ID" required>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Auto-Generated Slug</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-800 font-medium" id="slug_display">
                        Slug will be auto-generated when you fill in the details...
                    </div>
                    <input type="hidden" id="slug" name="slug" value="">
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
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white p-6 rounded-2xl text-center mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <strong>Contact:</strong> 081-2577370, 0777-977070, 0777-535121
                </div>
                <div>
                    <strong>Address:</strong> No 339, Colombo Road, Pilimathalawa
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mt-2">
                <div>
                    <strong>Website:</strong> www.nccs.lk
                </div>
                <div>
                    <strong>Email:</strong> thenccs@gmail.com
                </div>
            </div>
        </div>
    </div> name="slug" value="">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn create-btn">
                    <i class="fas fa-tools"></i> Create Repair
                </button>
            </div>
        </form>

        <!-- Company Information -->
        <div class="company-info">
            <div class="row">
                <div class="col-md-6">
                    <strong>Contact:</strong> 081-2577370, 0777-977070, 0777-535121
                </div>
                <div class="col-md-6">
                    <strong>Address:</strong> No 339, Colombo Road, Pilimathalawa
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <strong>Website:</strong> www.nccs.lk
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong> thenccs@gmail.com
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
            const customerName = document.getElementById('device_customer_name').value;
            const brand = document.getElementById('device_brand').value;
            const model = document.getElementById('device_model').value;
            
            if (customerName && brand && model) {
                // Get first name only
                const firstName = customerName.split(' ')[0];
                
                // Get first 3 letters of model
                const modelShort = model.substring(0, 3);
                
                // Create slug: "FirstName's Brand ModelShort"
                const slug = `${firstName}'s ${brand} ${modelShort}`;
                
                document.getElementById('slug').value = slug;
                document.getElementById('slug_display').textContent = slug;
            } else {
                document.getElementById('slug_display').textContent = 'Slug will be auto-generated...';
            }
        }

        // Sync customer name between sections
        document.getElementById('customer_name').addEventListener('input', function() {
            document.getElementById('device_customer_name').value = this.value;
            generateSlug();
        });

        document.getElementById('device_customer_name').addEventListener('input', function() {
            document.getElementById('customer_name').value = this.value;
            generateSlug();
        });
    </script>
</body>
</html>