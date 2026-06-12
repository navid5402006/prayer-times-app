<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramadan Management | IslamicPrayerTimes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6e6e;
            --secondary-color: #054545;
            --accent-color: #d4af37;
            --light-color: #f5f5f0;
            --text-color: #333;
            --light-text: #777;
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        /* Sidebar */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-color);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background: var(--primary-color);
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul li a {
            padding: 15px 25px;
            display: block;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover {
            background: var(--primary-color);
        }
        
        #sidebar ul li.active > a {
            background: var(--primary-color);
            border-left: 4px solid var(--accent-color);
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Content */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
        }
        
        .table th {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        /* Status badges */
        .badge-updated {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-auto {
            background-color: #ffc107;
            color: #212529;
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        /* Table styles */
        .table td, .table th {
            vertical-align: middle;
        }
        
        /* Container with margin-left */
        .main-container {
            margin-left: 100px;
            margin-right: 30px;
            width: calc(100% - 130px);
            padding: 20px;
        }
        
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        /* Card styling - width 90% and margin-left 200px */
        .custom-card {
            width: 90% !important;
            margin-left: 150px !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .custom-card {
                width: 100% !important;
                margin-left: 0 !important;
            }
        }
        
        /* Delete modal */
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        
        .modal-header.bg-danger {
            background-color: #dc3545 !important;
            border-radius: 15px 15px 0 0;
        }
        
        .modal-header .btn-close-white {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body>
    @include('admin.layout')

    <div class="main-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Ramadan Cities</h2>
            <div>
                <span class="badge badge-updated me-2">
                    <i class="fas fa-check-circle me-1"></i> Updated (Manually Edited)
                </span>
                <span class="badge badge-auto">
                    <i class="fas fa-robot me-1"></i> Auto (API Generated)
                </span>
            </div>
        </div>

        <!-- Card with width 90% and margin-left 200px -->
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-moon me-2"></i> All Ramadan Searches</span>
                <span class="badge bg-primary">{{ $searches->total() }} Cities</span>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Timezone</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($searches as $row)
                                @php
                                    // Check if city has been manually updated using updated_at
                                    $isManuallyUpdated = false;
                                    if ($row->created_at && $row->updated_at) {
                                        // If updated_at is different from created_at (more than 10 seconds gap)
                                        $differenceInSeconds = $row->created_at->diffInSeconds($row->updated_at);
                                        if ($differenceInSeconds > 10) {
                                            $isManuallyUpdated = true;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $row->id }}</span></td>
                                    <td><strong>{{ $row->city }}</strong></td>
                                    <td>{{ $row->state ?? '—' }}</td>
                                    <td>{{ $row->country }}</td>
                                    <td>
                                        @if($row->timezone)
                                            <span class="badge bg-info text-dark">{{ $row->timezone }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if($isManuallyUpdated)
                                            <!-- ✅ GREEN UPDATED - Jab is city mein kuch change hua ho -->
                                            <span class="badge badge-updated">
                                                <i class="fas fa-check-circle me-1"></i> Updated
                                            </span>
                                        @else
                                            <!-- 🟡 YELLOW AUTO - Jab kabhi change na hua ho -->
                                            <span class="badge badge-auto">
                                                <i class="fas fa-robot me-1"></i> Auto
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->created_at)
                                            <small>{{ $row->created_at->format('M d, Y') }}</small>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->updated_at && $isManuallyUpdated)
                                            <span title="{{ $row->updated_at->format('Y-m-d H:i:s') }}">
                                                {{ $row->updated_at->diffForHumans() }}
                                            </span>
                                        @elseif($row->updated_at)
                                            <span class="text-muted">Never</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.ramadan-searches.edit', $row->id) }}"
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                               <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete"
                                                    onclick="confirmDelete({{ $row->id }}, '{{ $row->city }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-moon fa-4x text-muted mb-3"></i>
                                        <p class="text-muted fs-5">No ramadan searches found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $searches->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5">Are you sure you want to delete <strong id="deleteCityName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone. All data for this city will be permanently removed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i> Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Delete confirmation function
        function confirmDelete(id, cityName) {
            document.getElementById('deleteCityName').textContent = cityName;
            
            const baseUrl = "{{ url('') }}";
            document.getElementById('deleteForm').action = baseUrl + '/admin/ramadan-searches/' + id;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>