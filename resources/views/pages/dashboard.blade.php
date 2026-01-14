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
                                    <table class="data-table table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2"
                                                    style="padding: 12px 8px;">
                                                    Invoice ID
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Order ID
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Status
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Amount
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-primary">INV-2024-002</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">ORD-45824</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        <span class="me-1">●</span>Processing
                                                    </span>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 text-success">$899.50</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="View">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="Download">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="More">
                                                        <i class="fas fa-ellipsis-h text-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-primary">INV-2024-003</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">ORD-45825</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-warning">
                                                        <span class="me-1">●</span>Parsed Raw
                                                    </span>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 text-success">$2,499.00</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="View">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="Download">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="More">
                                                        <i class="fas fa-ellipsis-h text-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm text-primary">INV-2024-001</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">ORD-45823</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-success">
                                                        <span class="me-1">●</span>Completed
                                                    </span>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 text-success">$1,299.99</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="View">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="Download">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="More">
                                                        <i class="fas fa-ellipsis-h text-xs"></i>
                                                    </button>
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