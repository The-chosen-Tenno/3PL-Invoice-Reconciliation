let tables = [];

document.addEventListener('DOMContentLoaded', () => {
    initDataTables();
    attachExportHandlers();
});

function initDataTables() {
    tables.forEach(t => t.destroy());
    tables = [];

    document.querySelectorAll('.data-table').forEach(tableEl => {
        const dt = new DataTable(tableEl, {
            responsive: false,
            pageLength: 10,
            pagingType: 'simple_numbers',
            language: {
                search: '',
                searchPlaceholder: 'Search...',
                paginate: { previous: '‹', next: '›' }
            }
        });
        tables.push(dt);
    });
}