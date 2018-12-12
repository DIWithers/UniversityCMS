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
            if (this.searchField.val()) {
                if (!this.spinnerVisible) {
                    this.resultsSection.html('<div class="spinner-loader"></div>');
                    this.spinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 1000);
            }
            else {
                this.resultsSection.html('');
                this.spinnerVisible = false;
            }
        }
        this.previousValue = this.searchField.val();
    }
    getResults() {
        $.getJSON(mainData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val(), posts => {
        this.resultsSection.html(`
                <h2>General Information</h2>
                ${posts.length ? '<ul class="link-list min-list">' :'<p> No results found.</p>' }
                
                ${posts.map(post => 
                    `<li>
                        <a href="${post.link}">${post.title.rendered}</a>
                    </li>`
                ).join(' ')}
                ${posts.length ? '</ul>' :'' }
            `);
        this.spinnerVisible = false;
        });
    }
    keyPressDispatcher(event) {
        if (event.keyCode == 83 && !this.overlayIsOpen && !$('input, textarea').is(':focus')) { // S Key if no other field is active
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