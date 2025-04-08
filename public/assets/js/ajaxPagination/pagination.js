let debounceTimer;
let currentPage;
let searchValue;
let pageLimit;

async function ajaxRequest(page = 2, limit = 10, search = '') {
    const preloaderContainer = document.createElement('div');
    preloaderContainer.setAttribute('id', 'preloader');

    const spinnerElement = document.createElement('div');
    spinnerElement.classList.add('spinner');

    preloaderContainer.appendChild(spinnerElement);

    const tableContainer = document.getElementsByClassName('table-responsive')[0];
    tableContainer.appendChild(preloaderContainer);

    callAjax(`?page=${page}&limit=${limit}&q=${search}`, null, function (res) {
        const jsonData = JSON.parse(res);

        document.getElementsByTagName('tbody')[0].innerHTML = jsonData.tbody;
        document.getElementById('pagination').innerHTML = jsonData.pagination;

        tableContainer.removeChild(preloaderContainer);
    }, 'GET');
}

function search(onSearch) {
    if (document.getElementById('searchId') === null) {
        return;
    }

    document.getElementById('searchId').addEventListener('input', function (e) {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(async () => {
            const query = e.target.value;
            onSearch(query);
        }, 300);
    });
}

function limit(onLimit) {
    if (document.getElementById('pageLimit') === null) {
        return;
    }

    const lim = document.getElementById('pageLimit');
    lim.addEventListener('change', function (e) {
        const query = e.target.value;
        onLimit(query);
    });
}

function page(onPage) {
    if (document.getElementById('pagination') === null) {
        return;
    }
    document.getElementById('pagination').addEventListener('click', function (e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            const url = e.target.href;
            const parsedUrl = new URL(url);
            currentPage = parsedUrl.searchParams.get('page');
            onPage(currentPage);
        }
    });
}

function ajaxPagination() {
    ajaxRequest(currentPage, pageLimit, searchValue);
}

document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.querySelector('tbody');

    if (tbody === null) {
        return;
    }

    const totalRows = tbody.getElementsByTagName('tr').length;

    if (totalRows <= 0) {
        tbody.innerHTML = '<tr class="text-center"><td colspan="100%">No data found</td></tr>';
    }

    page(value => {
        currentPage = value;
        ajaxPagination();
    });

    search(value => {
        searchValue = value;
        ajaxPagination();
    });

    limit(value => {
        pageLimit = value;
        ajaxPagination();
    });
});

