import $ from 'jquery';

class Search {
    constructor() {
        this.openSearch = $(".js-search-trigger");
        this.closeSearch = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.events();
        this.overlayIsOpen = false;
    }
    events() {
        this.openSearch.on('click', this.openOverlay.bind(this));
        this.closeSearch.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
    }
    keyPressDispatcher(event) {
        if (event.keyCode == 83 && !this.overlayIsOpen) { // S Key
            this.openOverlay();
            this.overlayIsOpen = true;
        }
        if (event.keyCode == 27 && this.overlayIsOpen) { // Esc Key
            this.closeOverlay();
            this.overlayIsOpen = false;
        }
    }
    openOverlay() {
        this.searchOverlay.addClass('search-overlay--active');
        $("body").addClass("body-no-scroll");
    }
    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass("body-no-scroll");
    }
}
export default Search;