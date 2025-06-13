document.addEventListener('DOMContentLoaded', () => {
    const searchContainer = document.querySelector('.search');
    if (!searchContainer) return;

    const searchInput = searchContainer.querySelector('input[name="q"]');
    const searchBar = searchContainer.querySelector('.search__bar');
    
    const openSearchTriggers = document.querySelectorAll('.navbar__content__icons__search, .navbar--mobile__links__single--search');

    function openSearch() {
        searchContainer.style.display = 'block';
        searchInput.focus();
    }

    function closeSearch() {
        searchContainer.style.display = 'none';
    }

    openSearchTriggers.forEach(trigger => {
        trigger.addEventListener('click', openSearch);
    });

    document.addEventListener('mouseup', (e) => {
        if (searchContainer.style.display === 'block' && !searchBar.contains(e.target)) {
            closeSearch();
        }
    });
});