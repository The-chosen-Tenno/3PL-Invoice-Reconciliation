<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="dashboard"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="dashboard"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize m-0">
                                    All Invoices
                                </h6>
                                <button type="button" id="addProject" class="btn bg-gradient-dark mb-0"
                                    data-bs-toggle="modal" data-bs-target="#uploadInvoiceModal">
                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp; Invoices
                                </button>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <div class="search-filter">
                                        <div class="search-box">
                                            <i class="material-icons">search</i>
                                            <input type="text" placeholder="Search invoices, orders, IDs..."
                                                id="tableSearch">
                                        </div>
                                        <select class="filter-select" id="statusFilter">
                                            <option value="">All Statuses</option>
                                            <option value="parsed_raw">Parsed Raw</option>
                                            <option value="processing">Processing</option>
                                            <option value="completed">Completed</option>
                                            <option value="failed">Failed</option>
                                        </select>
                                        <select class="filter-select" id="dateFilter">
                                            <option>Last 30 days</option>
                                            <option>Last 7 days</option>
                                            <option>This month</option>
                                            <option>Custom range</option>
                                        </select>
                                    </div>

                                    <table class="data-table">
                                        <thead>
                                            <tr>
                                                <th>Invoice</th>
                                                <th>Invoice ID</th>
                                                <th>Order ID</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="invoice-cell">
                                                        <div class="invoice-icon">
                                                            <i class="material-icons">description</i>
                                                        </div>
                                                        <div class="invoice-info">
                                                            <h6>Monthly Subscription</h6>
                                                            <p>Premium Plan - December</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="id-badge">INV-2024-001</span>
                                                </td>
                                                <td>
                                                    <span class="id-badge">ORD-45823</span>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-completed">
                                                        <span class="status-dot"></span>
                                                        Completed
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="price">$129.99</span>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <button class="action-btn" title="View">
                                                            <i class="material-icons">visibility</i>
                                                        </button>
                                                        <button class="action-btn" title="Download">
                                                            <i class="material-icons">download</i>
                                                        </button>
                                                        <button class="action-btn" title="More">
                                                            <i class="material-icons">more_horiz</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="invoice-cell">
                                                        <div class="invoice-icon">
                                                            <i class="material-icons">description</i>
                                                        </div>
                                                        <div class="invoice-info">
                                                            <h6>Product Purchase</h6>
                                                            <p>Electronics Bundle</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="id-badge">INV-2024-002</span>
                                                </td>
                                                <td>
                                                    <span class="id-badge">ORD-45824</span>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-processing">
                                                        <span class="status-dot"></span>
                                                        Processing
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="price">$899.50</span>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <button class="action-btn" title="View">
                                                            <i class="material-icons">visibility</i>
                                                        </button>
                                                        <button class="action-btn" title="Download">
                                                            <i class="material-icons">download</i>
                                                        </button>
                                                        <button class="action-btn" title="More">
                                                            <i class="material-icons">more_horiz</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="invoice-cell">
                                                        <div class="invoice-icon">
                                                            <i class="material-icons">description</i>
                                                        </div>
                                                        <div class="invoice-info">
                                                            <h6>Consulting Services</h6>
                                                            <p>Q4 2024 Advisory</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="id-badge">INV-2024-003</span>
                                                </td>
                                                <td>
                                                    <span class="id-badge">ORD-45825</span>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-parsed_raw">
                                                        <span class="status-dot"></span>
                                                        Parsed Raw
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="price">$2,499.00</span>
                                                </td>
                                                <td>
                                                    <div class="actions">
                                                        <button class="action-btn" title="View">
                                                            <i class="material-icons">visibility</i>
                                                        </button>
                                                        <button class="action-btn" title="Download">
                                                            <i class="material-icons">download</i>
                                                        </button>
                                                        <button class="action-btn" title="More">
                                                            <i class="material-icons">more_horiz</i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('pages.modals.add-invoices-modal')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</x-layout>