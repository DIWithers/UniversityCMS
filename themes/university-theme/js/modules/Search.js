import $ from 'jquery';

class Search {
    constructor() {
        this.addSearchHtml();
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
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            }
            else {
                this.resultsSection.html('');
                this.spinnerVisible = false;
            }
        }
        this.previousValue = this.searchField.val();
    }
    getResults() {
        $.when(
            $.getJSON(mainData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
            $.getJSON(mainData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
        )
        .then((posts, pages) => {
            let combinedResults = posts[0].concat(pages[0]);
            this.resultsSection.html(`
                <h2>General Information</h2>
                ${combinedResults.length ? '<ul class="link-list min-list">' :'<p> No results found.</p>' }
                ${combinedResults.map(result => 
                    `<li>
                        <a href="${result.link}">${result.title.rendered}</a> ${result.type == 'post' ? `by ${result.authorName}` : ''}
                    </li>`
                ).join(' ')}
                ${combinedResults.length ? '</ul>' :'' }
            `);
            this.spinnerVisible = false;
        }, () => {
            this.resultsSection.html('<p> Unexpected error, please try again.</p>');
        } );
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
        this.searchField.val('');
        setTimeout(() => this.searchField.focus(), 301);
        this.overlayIsOpen = true;
    }
    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass("body-no-scroll");
        this.overlayIsOpen = false;
    }
    addSearchHtml() {
        $("body").append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                            <input type="text" id="search-term" class="search-term" placeholder="What are you looking for?">
                            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="container">
                    <div id="search-over__results"></div>
                </div>
            </div>
        `);
    }
}
export default Search;