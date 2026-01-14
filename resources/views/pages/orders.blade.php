<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="orders"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="orders"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize m-0">My Projects</h6>
                                <button type="button" id="addProject" class="btn bg-gradient-dark mb-0"
                                    data-bs-toggle="modal" data-bs-target="#addProjectModal">
                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add
                                </button>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="data-table table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2"
                                                    style="padding: 12px 8px;">
                                                    Order
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Order ID
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Invoice
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Amount
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Status
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                                                    style="padding: 12px 8px;">
                                                    Date
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
                                                            <h6 class="mb-0 text-sm">Premium Widget Set</h6>
                                                            <p class="text-xs text-secondary mb-0">ID: #ORD-2024-001</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">#ORD-2024-001</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">
                                                        <a href="#"
                                                            class="text-primary font-weight-bold">INV-2024-150</a>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 text-success">$1,299.99</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-gradient-success">Completed</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">Jan 14,
                                                        2026</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="Download">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="More Options">
                                                        <i class="fas fa-ellipsis-v text-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Enterprise License</h6>
                                                            <p class="text-xs text-secondary mb-0">ID: #ORD-2024-002</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">#ORD-2024-002</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">
                                                        <a href="#"
                                                            class="text-primary font-weight-bold">INV-2024-151</a>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 text-success">$4,599.00</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">Jan 13,
                                                        2026</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="Download">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="More Options">
                                                        <i class="fas fa-ellipsis-v text-xs"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Starter Package</h6>
                                                            <p class="text-xs text-secondary mb-0">ID: #ORD-2024-003</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">#ORD-2024-003</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs mb-0">
                                                        <span class="text-muted">-</span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-bold mb-0 text-success">$299.99</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="badge badge-sm bg-gradient-info">Processing</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">Jan 12,
                                                        2026</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="Download">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </button>
                                                    <button class="btn btn-link text-secondary mb-0 px-1"
                                                        data-bs-toggle="tooltip" title="More Options">
                                                        <i class="fas fa-ellipsis-v text-xs"></i>
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
</x-layout>