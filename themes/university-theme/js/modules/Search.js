import $ from 'jquery';

class Search {
    constructor() {
        this.openSearch = $(".js-search-trigger");
        this.closeSearch = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsSection = $("#search-over__results");
        this.events();
        this.overlayIsOpen = false;
        this.spinnerVisible = false;
        this.previousValue;
        this.typingTimer;
    }
    events() {
        this.openSearch.on('click', this.openOverlay.bind(this));
        this.closeSearch.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.on('keyup', this.typingLogic.bind(this));
    }
    typingLogic() {
        if (this.searchField.val() !== this.previousValue) {
            clearTimeout(this.typingTimer);
            if (!this.spinnerVisible) {
                this.resultsSection.html('<div class="spinner-loader"></div>');
                this.spinnerVisible = true;
            }
            this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
        }
        this.previousValue = this.searchField.val();
    }
    getResults() {
        this.resultsSection.html("Search results........");
        this.spinnerVisible = false;
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